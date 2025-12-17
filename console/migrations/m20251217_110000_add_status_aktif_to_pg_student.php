<?php

use yii\db\Migration;

class m20251217_110000_add_status_aktif_to_pg_student extends Migration
{
    public function up()
    {
        $this->addColumn('{{%pg_student}}', 'status_aktif', $this->tinyInteger()->null());
    }

    public function down()
    {
        $this->dropColumn('{{%pg_student}}', 'status_aktif');
    }
}
