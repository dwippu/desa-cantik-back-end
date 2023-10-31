<?php

declare(strict_types=1);

namespace CodeIgniter\Shield\Database\Migrations;

use CodeIgniter\Database\Forge;
use CodeIgniter\Database\Migration;
use CodeIgniter\Shield\Config\Auth;

class CreateAuthTables extends Migration
{
    /**
     * Auth Table names
     */
    private array $tables;

    public function __construct(?Forge $forge = null)
    {
        parent::__construct($forge);

        /** @var Auth $authConfig */
        $authConfig   = config('Auth');
        $this->tables = $authConfig->tables;
    }

    public function up(): void
    {
        // Users Table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'username'       => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'status'         => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status_message' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'active'         => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'last_active'    => ['type' => 'datetime', 'null' => true],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable($this->tables['users']);

        /*
         * Auth Identities Table
         * Used for storage of passwords, access tokens, social login identities, etc.
         */
        $this->forge->addField([
            'id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'type'         => ['type' => 'varchar', 'constraint' => 255],
            'name'         => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'secret'       => ['type' => 'varchar', 'constraint' => 255],
            'secret2'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'expires'      => ['type' => 'datetime', 'null' => true],
            'extra'        => ['type' => 'text', 'null' => true],
            'force_reset'  => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
            'last_used_at' => ['type' => 'datetime', 'null' => true],
            'created_at'   => ['type' => 'datetime', 'null' => true],
            'updated_at'   => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['type', 'secret']);
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id', $this->tables['users'], 'id', '', 'CASCADE');
        $this->forge->createTable($this->tables['identities']);

        /**
         * Auth Login Attempts Table
         * Records login attempts. A login means users think it is a login.
         * To login, users do action(s) like posting a form.
         */
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'id_type'    => ['type' => 'varchar', 'constraint' => 255],
            'identifier' => ['type' => 'varchar', 'constraint' => 255],
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true], // Only for successful logins
            'date'       => ['type' => 'datetime'],
            'success'    => ['type' => 'tinyint', 'constraint' => 1],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['id_type', 'identifier']);
        $this->forge->addKey('user_id');
        // NOTE: Do NOT delete the user_id or identifier when the user is deleted for security audits
        $this->forge->createTable($this->tables['logins']);

        /*
         * Auth Token Login Attempts Table
         * Records Bearer Token type login attempts.
         */
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'id_type'    => ['type' => 'varchar', 'constraint' => 255],
            'identifier' => ['type' => 'varchar', 'constraint' => 255],
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true], // Only for successful logins
            'date'       => ['type' => 'datetime'],
            'success'    => ['type' => 'tinyint', 'constraint' => 1],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['id_type', 'identifier']);
        $this->forge->addKey('user_id');
        // NOTE: Do NOT delete the user_id or identifier when the user is deleted for security audits
        $this->forge->createTable($this->tables['token_logins']);

        /*
         * Auth Remember Tokens (remember-me) Table
         * @see https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
         */
        $this->forge->addField([
            'id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'selector'        => ['type' => 'varchar', 'constraint' => 255],
            'hashedValidator' => ['type' => 'varchar', 'constraint' => 255],
            'user_id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'expires'         => ['type' => 'datetime'],
            'created_at'      => ['type' => 'datetime', 'null' => false],
            'updated_at'      => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('selector');
        $this->forge->addForeignKey('user_id', $this->tables['users'], 'id', '', 'CASCADE');
        $this->forge->createTable($this->tables['remember_tokens']);

        // Groups Users Table
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'group'      => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'kode_desa'  => ['type' => 'varchar', 'constraint' => 9, 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', $this->tables['users'], 'id', '', 'CASCADE');
        $this->forge->createTable($this->tables['groups_users']);

        // Users Permissions Table
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'permission' => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'created_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', $this->tables['users'], 'id', '', 'CASCADE');
        $this->forge->createTable($this->tables['permissions_users']);

        // Wilayah Table
        $this->forge->addField([
            'kode_desa'      => ['type' => 'varchar', 'constraint' => 10, 'null' => false],
            'prov'           => ['type' => 'varchar', 'constraint' => 2, 'null' => false],
            'nama_prov'      => ['type' => 'varchar', 'constraint' => 20, 'null' => false],
            'kab'            => ['type' => 'varchar', 'constraint' => 2, 'null' => false],
            'nama_kab'       => ['type' => 'varchar', 'constraint' => 20, 'null' => false],
            'kec'            => ['type' => 'varchar', 'constraint' => 3, 'null' => false],
            'nama_kec'       => ['type' => 'varchar', 'constraint' => 25, 'null' => false],
            'desa'           => ['type' => 'varchar', 'constraint' => 3, 'null' => false],
            'nama_desa'      => ['type' => 'varchar', 'constraint' => 25, 'null' => false],
            'descan'         => ['type' => 'int', 'constraint' => 1, 'null' => false]
        ]);
        $this->forge->addPrimaryKey('kode_desa');
        $this->forge->createTable($this->tables['wilayah']);

        // sk_pembina Table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_kab'       => ['type' => 'varchar', 'constraint' => 4, 'null' => false],
            'nomor_sk'       => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'tanggal_sk'     => ['type' => 'date', 'null' => false],
            'file'           => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'last_edit'      => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable($this->tables['sk_pembina']);

        // sk_descan Table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nomor_sk'       => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'tanggal_sk'     => ['type' => 'date', 'null' => false],
            'file'           => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'list_descan'    => ['type' => 'logtext', 'null' => false],
            'tanggal_upload' => ['type' => 'datetime', 'null' => true],
            'status'         => ['type' => 'varchar', 'constraint' => 15, 'null' => false]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable($this->tables['sk_descan']);

        // sk_agen Table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_desa'      => ['type' => 'varchar', 'constraint' => 10, 'null' => false],
            'nomor_sk'       => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'tanggal_sk'     => ['type' => 'date', 'null' => false],
            'file'           => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'last_edit'      => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable($this->tables['sk_agen']);

        // profil_desa Table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'        => ['type' => 'int', 'constraint' => 11, 'null' => false],
            'kode_desa'      => ['type' => 'varchar', 'constraint' => 10, 'null' => false],
            'alamat'         => ['type' => 'text', 'null' => true],
            'email'          => ['type' => 'varchar', 'constraint' => 50, 'null' => false],
            'telp'           => ['type' => 'varchar', 'constraint' => 13, 'null' => true],
            'info_umum'      => ['type' => 'longtext', 'null' => false],
            'html_tag'       => ['type' => 'longtext', 'null' => false],
            'approval'       => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'tanggal_pengajuan' => ['type' => 'datetime', 'null' => true],
            'tanggal_konfirmasi' => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable($this->tables['profil_desa']);

        // perangkat_desa Table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'        => ['type' => 'int', 'constraint' => 11, 'null' => false],
            'kode_desa'      => ['type' => 'varchar', 'constraint' => 10, 'null' => false],
            'nama'           => ['type' => 'varchar', 'constraint' => 50, 'null' => false],
            'email'          => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'instagram'      => ['type' => 'varchar', 'constraint' => 25, 'null' => true],
            'jabatan'        => ['type' => 'varchar', 'constraint' => 25, 'null' => false],
            'aktif'          => ['type' => 'varchar', 'constraint' => 12, 'null' => true],
            'gambar'         => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'approval'       => ['type' => 'varchar', 'constraint' => 25, 'null' => false],
            'tanggal_pengajuan' => ['type' => 'datetime', 'null' => false],
            'tanggal_konfirmasi' => ['type' => 'datetime', 'null' => true],
            'edit_from'          => ['type' => 'int', 'constraint' => 11, 'null' => true]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable($this->tables['perangkat_desa']);

        // pengajuan_sk_agen Table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'        => ['type' => 'int', 'constraint' => 11, 'null' => false],
            'kode_desa'      => ['type' => 'varchar', 'constraint' => 10, 'null' => false],
            'id_sk'          => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'nomor_sk'       => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'tanggal_sk'     => ['type' => 'date', 'null' => false],
            'file'           => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'approval'       => ['type' => 'varchar', 'constraint' => 25, 'null' => false],
            'tanggal_pengajuan' => ['type' => 'datetime', 'null' => true],
            'tanggal_konfirmasi' => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable($this->tables['pengajuan_sk_agen']);

        // pengajuan_laporan_bulanan Table
        $this->forge->addField([
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'          => ['type' => 'int', 'constraint' => 11, 'null' => false],
            'kode_desa'        => ['type' => 'varchar', 'constraint' => 10, 'null' => false],
            'id_kegiatan'      => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'nama_kegiatan'    => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'tanggal_kegiatan' => ['type' => 'date', 'null' => false],
            'peserta_kegiatan' => ['type' => 'text', 'null' => false],
            'file'             => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'approval'         => ['type' => 'varchar', 'constraint' => 27, 'null' => false],
            'tanggal_pengajuan' => ['type' => 'datetime', 'null' => true],
            'tanggal_konfirmasi' => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable($this->tables['pengajuan_laporan_bulanan']);

        // laporan_bulanan Table
        $this->forge->addField([
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_desa'        => ['type' => 'varchar', 'constraint' => 10, 'null' => false],
            'nama_kegiatan'    => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'tanggal_kegiatan' => ['type' => 'date', 'null' => false],
            'peserta_kegiatan' => ['type' => 'text', 'null' => false],
            'last_edit'        => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable($this->tables['laporan_bulanan']);


    }

    // --------------------------------------------------------------------

    public function down(): void
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropTable($this->tables['logins'], true);
        $this->forge->dropTable($this->tables['token_logins'], true);
        $this->forge->dropTable($this->tables['remember_tokens'], true);
        $this->forge->dropTable($this->tables['identities'], true);
        $this->forge->dropTable($this->tables['groups_users'], true);
        $this->forge->dropTable($this->tables['permissions_users'], true);
        $this->forge->dropTable($this->tables['users'], true);
        $this->forge->dropTable($this->tables['wilayah'], true);
        $this->forge->dropTable($this->tables['sk_pembina'], true);
        $this->forge->dropTable($this->tables['sk_descan'], true);
        $this->forge->dropTable($this->tables['sk_agen'], true);
        $this->forge->dropTable($this->tables['profil_desa'], true);
        $this->forge->dropTable($this->tables['perangkat_desa'], true);
        $this->forge->dropTable($this->tables['pengajuan_sk_agen'], true);
        $this->forge->dropTable($this->tables['pengajuan_laporan_bulanan'], true);
        $this->forge->dropTable($this->tables['laporan_bulanan'], true);

        $this->db->enableForeignKeyChecks();
    }
}
