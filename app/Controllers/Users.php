<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use App\Models\WilayahUserModel;
use App\Models\WilayahModel;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Authentication\Passwords;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ValidationException;

/**
 * Controller untuk mengatur user
 * Hanya dapat diakses oleh akun dengan role superadmin
 */
class Users extends BaseController
{
    protected UsersModel $model;
    
    public function index()
    {
        $this->model = new UsersModel();
        if(auth()->user()->inGroup('adminkab')){
            return $this->adminKabPage();
        };
        $list = $this->model->getAllUser();
        $data = ['list' => $list];
        return view('users/list_user', $data);
    }

    protected function adminKabPage()
    {
        $user = new WilayahUserModel();
        $kode_desa = $user->getWilayah(auth()->getUser()->id);
        $kode_kab=substr($kode_desa,0,4);
        $list = $this->model->getAllUserByKab($kode_kab);
        $data = ['list' => $list];
        return view('users/list_user', $data);
    }

    public function detail($id){
        if (! auth()->loggedIn()) {
            return redirect()->back();
        }

        $this->model = new UsersModel();
        $user = $this->model->detailUser($id)[0];
        
        // Nama Kabupaten
        $wil = new WilayahModel;
        $wil = $wil->namaKab(substr($user['kode_desa'],2,2));
        $user['nama_kab'] = $wil ? $wil[0]['nama_kab']:null;
        
        if(auth()->user()->inGroup('adminkab')){
            $wilayah = new WilayahUserModel();
            $kode_kab1 = substr($wilayah->getWilayah(auth()->user()->id),2,2);
            $kode_kab2 = substr($user['kode_desa'],2,2);
            if($kode_kab1 == $kode_kab2){
                return $this->response->setJSON($user);
            }
            return $this->response->setJSON(null);
        };

        return $this->response->setJSON($user);
    }

    public function editview($id){
        if (! auth()->loggedIn()) {
            return redirect()->back();
        }
        $desa = new WilayahModel();

        $this->model = new UsersModel();
        $user = $this->model->detailUser($id)[0];

        // Nama Kabupaten
        $wil = new WilayahModel;
        $wil = $wil->namaKab(substr($user['kode_desa'],2,2));
        $user['nama_kab'] = $wil ? $wil[0]['nama_kab']:null;
        
        if (auth()->user()->inGroup('adminkab')){
            $wilayah = new WilayahUserModel();
            $kode_kab1 = substr($wilayah->getWilayah(auth()->user()->id),0,4);
            $kode_kab2 = substr($user['kode_desa'],0,4);
            if($kode_kab1 !== $kode_kab2){
                return redirect()->back()->withInput()->with('errors', 'Tidak dapat mengedit akun ini!');
            }
        }

        $wilayah = new WilayahUserModel();
        $kode_kab = $wilayah->getWilayah($user['user_id']);
        $kode_kab = substr($kode_kab,2,2);
        if(auth()->user()->inGroup('adminkab')){
            return view('users/edit_user', ['list' => $desa->findDescanByKab($kode_kab), 'user' => $user]);
        } else if (auth()->user()->inGroup('superadmin')){
            return view('users/edit_user', ['kab' => $desa->distinctKab(),'list' => $desa->findDescanByKab($kode_kab), 'user' => $user]);
        }
            
    }

    public function edit(){
        if (! auth()->loggedIn()) {
            return redirect()->back();
        }
        $this->model = new UsersModel();
        $pos = $this->request->getPost();
        $user = $this->model->detailUser($pos['id'])[0];

        // Nama Kabupaten
        $wil = new WilayahModel;
        $wilayah = new WilayahUserModel();
        $wil = $wil->namaKab(substr($user['kode_desa'],2,2));
        $user['nama_kab'] = $wil ? $wil[0]['nama_kab']:null;

        if(auth()->user()->inGroup('adminkab')){            
            $kode_kab1 = substr($wilayah->getWilayah(auth()->user()->id),0,4);
            $kode_kab2 = substr($user['kode_desa'],0,4);
            if($kode_kab1 !== $kode_kab2){
                return redirect()->to('/users')->withInput()->with('errors','Tidak dapat mengedit akun ini!');
            }
        }

        if (! in_array($pos['role'], ['operator', 'verifikator', 'adminkab'])){
            return redirect()->back()->withInput()->with('errors', 'Role tidak terdaftar');
        }

        if (auth()->user()->inGroup('adminkab')){
            if($pos['role'] == 'adminkab'){
                return redirect()->back()->withInput()->with('errors', 'Role tidak terdaftar');
            }
            $kode_kab = $wilayah->getWilayah(auth()->user()->id);
            if (substr($kode_kab,0,4) != substr($pos['kode_desa'],0,4)){
                return redirect()->back()->withInput()->with('errors', 'Desa tidak ditemukan');
            }
        }

        $desa = new WilayahModel();
        if (! $desa->find($pos['kode_desa'])){
            if (substr($pos['kode_desa'],4,6) != '000000'){
                return redirect()->back()->withInput()->with('errors', 'Desa tidak ditemukan');
            }
        };

        if($user['secret'] !== $pos['email']){
            if(!$this->validate($this->getValidationEmail())){
                $validation = \Config\Services::validation();
                session()->setFlashdata('validation', $validation->getErrors());
                return redirect()->back()->withInput('errors', $validation->getError('email'));
            };
        }

        if(!$this->validate([
            'username' => [
            'label' => 'Auth.username',
            'rules' => 'alpha_space|max_length[100]|required',
            'errors' =>
                ['alpha_space' => 'Nama hanya boleh terdiri dari huruf dan spasi',
                'max_length' => 'Panjang nama tidak boleh lebih dari 100 karakter']
            ],
            'role' => [
                'label' => 'role',
                'rules' => 'required',
            ],
            'kode_desa' => [
                'label' => 'role',
                'rules' => 'required|max_length[10]|min_length[10]',
            ]
            ])){
            $validation = \Config\Services::validation();
            session()->setFlashdata('validation', $validation->getErrors());
            foreach($validation->getErrors() as $eror){
                $error = $eror;
                break;
            }
            return redirect()->back()->with('errors', $error);
        };
        $this->model->update($pos['id'], ['username'=>$pos['username']]);

        $users = new UserModel();
        $users = $users->findById($pos['id']);
        $users->removeGroup($users->getGroups()[0]);
        $users->addGroup($pos['role']);
        
        $wilayah->setWilayah($pos['id'], $pos['kode_desa']);

        return redirect()->to('/users')->with('succes', 'Profil Berhasil diubah');
    }

    public function nonaktifuser(){
        helper('oldpassword');

        $pass = $this->request->getPost('old-password');
        if (!old_password_is_correct($pass)){
            return redirect()->back()->withInput()->with('errors', 'Password Salah!');
        };

        if($this->request->getPost('user_id') == auth()->user()->id){
            return redirect()->back()->withInput()->with('errors', 'Tidak dapat menonaktifkan akun ini!');
        }

        if(auth()->user()->inGroup('adminkab')){
            $this->model = new UsersModel();
            $user1 = $this->model->detailUser($this->request->getPost('user_id'))[0];

            // Nama Kabupaten
            $wil = new WilayahModel;
            $wil = $wil->namaKab(substr($user1['kode_desa'],2,2));
            $user1['nama_kab'] = $wil ? $wil[0]['nama_kab']:null;

            $wilayah = new WilayahUserModel();
            $kode_kab1 = substr($wilayah->getWilayah(auth()->user()->id),0,4);
            $kode_kab2 = substr($user1['kode_desa'],0,4);
            if($kode_kab1 !== $kode_kab2){
                return redirect()->back()->withInput()->with('errors','Tidak dapat menonaktifkan akun ini!');
            }

            if($user1['kode_desa'] == $wilayah->getWilayah(auth()->user()->id)){
                return redirect()->back()->withInput()->with('errors','Tidak dapat menonaktifkan akun ini!');
            }
        }

        $user = new UserModel();
        $user = $user->find($this->request->getPost('user_id'));
        
        if($user->isBanned()){
            $user->unBan();
            return redirect()->back()->withInput()->with('succes', 'Akun Berhasil Diaktifkan Kembali!');
        }
        $user->ban('Akun dinonaktifkan oleh Admin Kabupaten. Hubungi Admin untuk membuka kembali');
        return redirect()->back()->withInput()->with('succes', 'Akun Berhasil Dinonaktifkan!');
    }

    public function resetPasswordView(){
        helper('oldpassword');
        $pass = $this->request->getPost('old-password');
        if (!old_password_is_correct($pass)){
            return redirect()->back()->withInput()->with('errors', 'Password Salah!');
        };

        if($this->request->getPost('user_id') == auth()->user()->id){
            return redirect()->back()->withInput()->with('errors', 'Tidak dapat mereset passord akun ini!');
        }

        if(auth()->user()->inGroup('adminkab')){
            $this->model = new UsersModel();
            $user1 = $this->model->detailUser($this->request->getPost('user_id'))[0];

            // Nama Kabupaten
            $wil = new WilayahModel;
            $wil = $wil->namaKab(substr($user1['kode_desa'],2,2));
            $user1['nama_kab'] = $wil ? $wil[0]['nama_kab']:null;

            $wilayah = new WilayahUserModel();
            $kode_kab1 = substr($wilayah->getWilayah(auth()->user()->id),0,4);
            $kode_kab2 = substr($user1['kode_desa'],0,4);
            if($kode_kab1 !== $kode_kab2){
                return redirect()->back()->withInput()->with('errors', 'Tidak dapat mereset password akun ini!');
            }

            if($user1['kode_desa'] == $wilayah->getWilayah(auth()->user()->id)){
                return redirect()->back()->withInput()->with('errors', 'Tidak dapat mereset password akun ini!');
            }
        }

        return view('users/change_password', ['old_password'=>$pass, 'id' => $this->request->getPost('user_id')]);
    }

    public function resetPasswordAction(){
        helper('oldpassword');
        $pass = $this->request->getPost('old-password');
        if (!old_password_is_correct($pass)){
            return redirect()->to('/users')->with('errors', 'Password Salah!');
        };

        if($this->request->getPost('id') == auth()->user()->id){
            return redirect()->to('/users')->with('errors', 'Tidak dapat mereset passord akun ini!');
        }

        if(auth()->user()->inGroup('adminkab')){
            $this->model = new UsersModel();
            $user1 = $this->model->detailUser($this->request->getPost('id'))[0];

            // Nama Kabupaten
            $wil = new WilayahModel;
            $wil = $wil->namaKab(substr($user1['kode_desa'],2,2));
            $user1['nama_kab'] = $wil ? $wil[0]['nama_kab']:null;

            $wilayah = new WilayahUserModel();
            $kode_kab1 = substr($wilayah->getWilayah(auth()->user()->id),0,4);
            $kode_kab2 = substr($user1['kode_desa'],0,4);
            if($kode_kab1 !== $kode_kab2){
                return redirect()->to('/users')->with('errors', 'Tidak dapat mereset password akun ini!');
            }

            if($user1['kode_desa'] == $wilayah->getWilayah(auth()->user()->id)){
                return redirect()->to('/users')->with('errors', 'Tidak dapat mereset password akun ini!');
            }
        }

        if(!$this->validate([
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
            ])){
            $validation = \Config\Services::validation();
            // session()->setFlashdata('validation', $validation->getErrors());
            $eror = ($validation->getError('password')) ? $validation->getError('password') : $validation->getError('password_confirm');
            // dd($eror);
            return redirect()->to('/users')->with('errors', $eror);
        };
        
        $provider = model(setting('Auth.userProvider'));
        assert($provider instanceof UserModel, 'Config Auth.userProvider is not a valid UserProvider.');
        $users = $provider;
        
        $user              = new User();
        $user->fill($this->request->getPost());

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
        return redirect()->to('/users')->withInput()->with('succes', 'Password Berhasil direset');
    }

    protected function getValidationEmail(): array
    {
        $authConfig   = config('Auth');
        $tables = $authConfig->tables;

        $registrationEmailRules = array_merge(
            config('AuthSession')->emailValidationRules,
            [sprintf('is_unique[%s.secret]', $tables['identities'])]
        );

        return setting('Validation.registration') ?? [
            'email' => [
                'label' => 'Auth.email',
                'rules' => $registrationEmailRules,
            ],
        ];
    }
}
;