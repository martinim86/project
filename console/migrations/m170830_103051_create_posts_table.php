<?php

use yii\db\Migration;

/**
 * Handles the creation of table `posts`.
 * Has foreign keys to the tables:
 *
 * - `category`
 */
class m170830_103051_create_posts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('posts', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'title' => $this->string()->notNull(),
            'subtitle' => $this->string(),
            'content' => $this->string(),
            'category' => $this->integer(),
            'status' => $this->integer(),
            'important' => $this->integer(),
            'tag' => $this->string(),
            'img' => $this->string(),
        ]);

        // creates index for column `category`
        $this->createIndex(
            'idx-posts-category',
            'posts',
            'category'
        );

        // add foreign key for table `category`
        $this->addForeignKey(
            'fk-posts-category',
            'posts',
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
            'fk-posts-category',
            'posts'
        );

        // drops index for column `category`
        $this->dropIndex(
            'idx-posts-category',
            'posts'
        );

        $this->dropTable('posts');
    }
}
