<?php

use yii\db\Migration;

class m260107_052000_add_last_status_daftar_to_pg_student extends Migration
{
    public function up()
    {
        $this->addColumn('{{%pg_student}}', 'last_status_daftar', $this->integer()->null());
    }

    public function down()
    {
        $this->dropColumn('{{%pg_student}}', 'last_status_daftar');
    }
}
