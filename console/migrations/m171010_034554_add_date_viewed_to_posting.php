<?php

use yii\db\Migration;

class m171010_034554_add_date_viewed_to_posting extends Migration
{
    public function up()
    {
        $this->addColumn('posting','date', $this->date());
        $this->addColumn('posting','viewed', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('posting','date');
        $this->dropColumn('posting','viewed');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171010_034554_add_date_viewed_to_posting cannot be reverted.\n";

        return false;
    }
    */
}
