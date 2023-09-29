<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Wilayah extends Migration
{
    public function up()
    {
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
            'nama_desa'       => ['type' => 'varchar', 'constraint' => 25, 'null' => false],
        ]);
        $this->forge->addPrimaryKey('kode_desa');
        $this->forge->createTable($this->tables['wilayah']);

        // Wilayah Table
        $this->forge->addField([
            'kode_desa'      => ['type' => 'varchar', 'constraint' => 10, 'null' => false],
            'alamat'         => ['type' => 'text', 'null' => true],
            'email'          => ['type' => 'varchar', 'constraint' => 50, 'null' => false],
            'telp'           => ['type' => 'varchar', 'constraint' => 13, 'null' => true],
            'info_umum'      => ['type' => 'longtext', 'null' => true],
            'html_tag'      => ['type' => 'longtext', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('kode_desa');
        $this->forge->createTable($this->tables['profil_desa']);

        // Wilayah Table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_desa'      => ['type' => 'varchar', 'constraint' => 10, 'null' => false],
            'nama'           => ['type' => 'varchar', 'constraint' => 50, 'null' => false],
            'email'          => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'instagram'      => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'jabatan'        => ['type' => 'varchar', 'constraint' => 16, 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable($this->tables['perangkat_desa']);
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropTable($this->tables['wilayah'], true);
        $this->forge->dropTable($this->tables['profil_desa'], true);
        $this->forge->dropTable($this->tables['perangkat_desa'], true);

        $this->db->enableForeignKeyChecks();
    }
}
