<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m170829_120823_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'category_name' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('category');
    }
}
