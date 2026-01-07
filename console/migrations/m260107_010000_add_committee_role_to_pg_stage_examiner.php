<?php

use yii\db\Migration;

class m260107_010000_add_committee_role_to_pg_stage_examiner extends Migration
{
    public function up()
    {
        $this->addColumn('{{%pg_stage_examiner}}', 'committee_role', $this->integer(1)->notNull()->defaultValue(3)->after('stage_id'));
    }

    public function down()
    {
        $this->dropColumn('{{%pg_stage_examiner}}', 'committee_role');
    }
}
