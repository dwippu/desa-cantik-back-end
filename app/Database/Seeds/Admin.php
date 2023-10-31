<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Admin extends Seeder
{
    public function run()
    {
        $users =[
            'username' => 'admin'
        ];

        $auth_identities =[
            'user_id' => 1,
            'type' => 'email_password',
            'secret' => 'admin@gmail.com',
            'secret2' => '$2y$10$u9W3sGGMC7tbNB4qs2rRsOoYcvacGazT3PDPGyvapGsAw5rES4Cy6'
        ];

        $auth_groups_users =[
            'user_id' => 1,
            'group' => 'superadmin',
            'kode_desa' => '3200000000',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('users')->insert($users);
        $this->db->table('auth_identities')->insert($auth_identities);
        $this->db->table('auth_groups_users')->insert($auth_groups_users);
    }
}
