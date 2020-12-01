<?php

use yii\db\Migration;

class m201127_085637_0001_create_table_archive extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%archive}}',
            [
                'id' => $this->primaryKey(),
                'author' => $this->text(),
                'title' => $this->string(200),
                'abstract' => $this->text(),
                'reference' => $this->text(),
                'pdf_file' => $this->string(6),
                'keyword' => $this->string(200),
                'volume' => $this->integer(1),
                'issue' => $this->integer(1),
                'priod' => $this->string(13),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%archive}}');
    }
}
