<?php

use yii\db\Migration;

class m201127_085639_0058_create_table_sp_course_clo extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(
            '{{%sp_course_clo}}',
            [
                'id' => $this->primaryKey(),
                'crs_version_id' => $this->integer()->notNull(),
                'verb' => $this->string(100)->notNull(),
                'clo_text' => $this->text()->notNull(),
                'clo_text_bi' => $this->text()->notNull(),
                'percentage' => $this->decimal(5, 2)->notNull(),
                'PLO1' => $this->boolean()->notNull()->defaultValue('0'),
                'PLO2' => $this->boolean()->notNull()->defaultValue('0'),
                'PLO3' => $this->boolean()->notNull()->defaultValue('0'),
                'PLO4' => $this->boolean()->notNull()->defaultValue('0'),
                'PLO5' => $this->boolean()->notNull()->defaultValue('0'),
                'PLO6' => $this->boolean()->notNull()->defaultValue('0'),
                'PLO7' => $this->boolean()->notNull()->defaultValue('0'),
                'PLO8' => $this->boolean()->notNull()->defaultValue('0'),
                'PLO9' => $this->boolean()->notNull()->defaultValue('0'),
                'PLO10' => $this->boolean()->notNull()->defaultValue('0'),
                'PLO11' => $this->boolean()->notNull()->defaultValue('0'),
                'PLO12' => $this->boolean()->notNull()->defaultValue('0'),
                'C1' => $this->boolean()->notNull()->defaultValue('0'),
                'C2' => $this->boolean()->notNull()->defaultValue('0'),
                'C3' => $this->boolean()->notNull()->defaultValue('0'),
                'C4' => $this->boolean()->notNull()->defaultValue('0'),
                'C5' => $this->boolean()->notNull()->defaultValue('0'),
                'C6' => $this->boolean()->notNull()->defaultValue('0'),
                'A1' => $this->boolean()->notNull()->defaultValue('0'),
                'A2' => $this->boolean()->notNull()->defaultValue('0'),
                'A3' => $this->boolean()->notNull()->defaultValue('0'),
                'A4' => $this->boolean()->notNull()->defaultValue('0'),
                'A5' => $this->boolean()->notNull()->defaultValue('0'),
                'P1' => $this->boolean()->notNull()->defaultValue('0'),
                'P2' => $this->boolean()->notNull()->defaultValue('0'),
                'P3' => $this->boolean()->notNull()->defaultValue('0'),
                'P4' => $this->boolean()->notNull()->defaultValue('0'),
                'P5' => $this->boolean()->notNull()->defaultValue('0'),
                'P6' => $this->boolean()->notNull()->defaultValue('0'),
                'P7' => $this->boolean()->notNull()->defaultValue('0'),
                'CS1' => $this->boolean()->notNull(),
                'CS2' => $this->boolean()->notNull(),
                'CS3' => $this->boolean()->notNull(),
                'CS4' => $this->boolean()->notNull(),
                'CS5' => $this->boolean()->notNull(),
                'CS6' => $this->boolean()->notNull(),
                'CS7' => $this->boolean()->notNull(),
                'CS8' => $this->boolean()->notNull(),
                'CT1' => $this->boolean()->notNull(),
                'CT2' => $this->boolean()->notNull(),
                'CT3' => $this->boolean()->notNull(),
                'CT4' => $this->boolean()->notNull(),
                'CT5' => $this->boolean()->notNull(),
                'CT6' => $this->boolean()->notNull(),
                'CT7' => $this->boolean()->notNull(),
                'TS1' => $this->boolean()->notNull(),
                'TS2' => $this->boolean()->notNull(),
                'TS3' => $this->boolean()->notNull(),
                'TS4' => $this->boolean()->notNull(),
                'TS5' => $this->boolean()->notNull(),
                'LL1' => $this->boolean()->notNull(),
                'LL2' => $this->boolean()->notNull(),
                'LL3' => $this->boolean()->notNull(),
                'ES1' => $this->boolean()->notNull(),
                'ES2' => $this->boolean()->notNull(),
                'ES3' => $this->boolean()->notNull(),
                'ES4' => $this->boolean()->notNull(),
                'EM1' => $this->boolean()->notNull(),
                'EM2' => $this->boolean()->notNull(),
                'EM3' => $this->boolean()->notNull(),
                'LS1' => $this->boolean()->notNull(),
                'LS2' => $this->boolean()->notNull(),
                'LS3' => $this->boolean()->notNull(),
                'LS4' => $this->boolean()->notNull(),
                'trash' => $this->boolean()->notNull(),
                'created_by' => $this->integer()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%sp_course_clo}}');
    }
}
