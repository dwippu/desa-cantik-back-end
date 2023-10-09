<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Controllers\Auth\WilayahUserController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Authentication\Passwords;
use CodeIgniter\Shield\Config\Auth;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Traits\Viewable;
use Psr\Log\LoggerInterface;
use App\Models\WilayahModel;

/**
 * Class RegisterController
 *
 * Halaman dapat diakses dengan akun dengan role superadmin.
 * Akun superadmin akan ditambakan ke dalam database saat pembangunan sistem
 * Halaman akan berfungsi sebagai manjemen user
 */
class RegisterController extends BaseController
{
    use Viewable;

    protected $helpers = ['setting'];

    /**
     * Auth Table names
     */
    private array $tables;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ): void {
        parent::initController(
            $request,
            $response,
            $logger
        );

        /** @var Auth $authConfig */
        $authConfig   = config('Auth');
        $this->tables = $authConfig->tables;
    }

    /**
     * Displays the registration form.
     *
     * @return RedirectResponse|string
     */
    public function registerView()
    {
        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show');
        }

        $desa = new WilayahModel();

        if (auth()->user()->inGroup('superadmin')){
            return $this->view('superadmin_pages/register', ['kab' => $desa->distinctKab()]);
        }
        
        $wilayah = new WilayahUserController();
        $kode_kab = $wilayah->getWilayah(auth()->user());
        $kode_kab = substr($kode_kab,2,2);
        return $this->view('register_kab', ['list' => $desa->findDescanByKab($kode_kab)]);
    }

    /**
     * Attempts to register the user.
     */
    public function registerAction(): RedirectResponse
    {
        $wilayah = new WilayahUserController();

        $users = $this->getUserProvider();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        if (! $this->validateData($this->request->getPost(), $rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if (! in_array($this->request->getPost()['role'], ['operator', 'verifikator', 'adminkab'])){
            return redirect()->back()->withInput()->with('errors', 'Role tidak terdaftar');
        }

        if (auth()->user()->inGroup('adminkab')){
            if($this->request->getPost()['role'] == 'adminkab'){
                return redirect()->back()->withInput()->with('errors', 'Role tidak terdaftar');
            }
            $kode_kab = $wilayah->getWilayah(auth()->user());
            if (substr($kode_kab,0,4) != substr($this->request->getPost()['kode_desa'],0,4)){
                return redirect()->back()->withInput()->with('errors', 'Desa tidak ditemukan');
            }
        }

        $desa = new WilayahModel();
        if (! $desa->find($this->request->getPost()['kode_desa'])){
            if (substr($this->request->getPost()['kode_desa'],4,6) != '000000'){
                return redirect()->back()->withInput()->with('errors', 'Desa tidak ditemukan');
            }
        };
        
        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        // Add to default group
        $role = $this->request->getPost()['role'];
        $user->addGroup($role);
        $this->setUserWilayah($user, $this->request->getPost()['kode_desa']);

        Events::trigger('register', $user);

        // Success!
        return redirect()->to(base_url().'register')
            ->with('message', lang('Auth.registerSuccess'));
    }

    /**
     * Returns the User provider
     */
    protected function getUserProvider(): UserModel
    {
        $provider = model(setting('Auth.userProvider'));

        assert($provider instanceof UserModel, 'Config Auth.userProvider is not a valid UserProvider.');

        return $provider;
    }

    /**
     * Returns the Entity class that should be used
     */
    protected function getUserEntity(): User
    {
        return new User();
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return array<string, array<string, array<string>|string>>
     * @phpstan-return array<string, array<string, string|list<string>>>
     */
    protected function getValidationRules(): array
    {
        $registrationEmailRules = array_merge(
            config('AuthSession')->emailValidationRules,
            [sprintf('is_unique[%s.secret]', $this->tables['identities'])]
        );

        return setting('Validation.registration') ?? [
            'username' => [
                'label' => 'Auth.username',
                'rules' => 'alpha_space|max_length[100]|required',
                'errors' =>
                    ['alpha_space' => 'Nama hanya boleh terdiri dari huruf dan spasi',
                    'max_length' => 'Panjang nama tidak boleh lebih dari 100 karakter']
            ],
            'email' => [
                'label' => 'Auth.email',
                'rules' => $registrationEmailRules,
            ],
            'password' => [
                'label'  => 'Auth.password',
                'rules'  => 'required|' . Passwords::getMaxLenghtRule() . '|strong_password',
                'errors' => [
                    'max_byte' => 'Auth.errorPasswordTooLongBytes',
                ],
            ],
            'password_confirm' => [
                'label' => 'Auth.passwordConfirm',
                'rules' => 'required|matches[password]',
            ],
            'role' => [
                'label' => 'role',
                'rules' => 'required',
            ],
            'kode_desa' => [
                'label' => 'role',
                'rules' => 'required|max_length[10]|min_length[10]',
            ]
        ];
    }

    protected function setUserWilayah(User $user, string $kode_wilayah){
        $wil = new WilayahUserController();
        $wil->addWilayah($user, $kode_wilayah);
    }

    protected function editUserWilayah(User $user, string $kode_wilayah){
        dd($kode_wilayah);
    }
}
