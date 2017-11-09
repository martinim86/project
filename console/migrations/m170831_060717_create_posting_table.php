<?php

use yii\db\Migration;

/**
 * Handles the creation of table `posting`.
 * Has foreign keys to the tables:
 *
 * - `category`
 */
class m170831_060717_create_posting_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('posting', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer(),
            'title' => $this->string()->notNull(),
            'subtitle' => $this->string(),
            'content' => $this->string(),
            'category' => $this->integer(),
            'status' => $this->integer(),
            'important' => $this->integer(),
            'tag' => $this->string(),
            'img' => $this->string(),
            'tmb' => $this->string(),
        ]);

        // creates index for column `category`
        $this->createIndex(
            'idx-posting-category',
            'posting',
            'category'
        );

        // add foreign key for table `category`
        $this->addForeignKey(
            'fk-posting-category',
            'posting',
            'category',
            'category',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `category`
        $this->dropForeignKey(
            'fk-posting-category',
            'posting'
        );

        // drops index for column `category`
        $this->dropIndex(
            'idx-posting-category',
            'posting'
        );

        $this->dropTable('posting');
    }
}
