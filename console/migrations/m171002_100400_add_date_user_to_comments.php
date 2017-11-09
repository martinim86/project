<?php

use yii\db\Migration;

class m171002_100400_add_date_user_to_comments extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('comments','date', $this->date());
        $this->addColumn('comments','user_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('comments','date');
        $this->dropColumn('comments','user_id');
    }
}
