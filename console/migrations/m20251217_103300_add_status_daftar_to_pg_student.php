<?php

use yii\db\Migration;

class m20251217_103300_add_status_daftar_to_pg_student extends Migration
{
    public function up()
    {
        $this->addColumn('{{%pg_student}}', 'status_daftar', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('{{%pg_student}}', 'status_daftar');
    }
}
