<?php

use yii\db\Migration;

/**
 * Handles the creation of table `posting_tags`.
 * Has foreign keys to the tables:
 *
 * - `posting`
 * - `tags`
 */
class m171004_034554_create_posting_tags_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('posting_tags', [
            'id' => $this->primaryKey(),
            'posting_id' => $this->integer()->notNull(),
            'tags_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `posting_id`
        $this->createIndex(
            'idx-posting_tags-posting_id',
            'posting_tags',
            'posting_id'
        );

        // add foreign key for table `posting`
        $this->addForeignKey(
            'fk-posting_tags-posting_id',
            'posting_tags',
            'posting_id',
            'posting',
            'id',
            'CASCADE'
        );

        // creates index for column `tags_id`
        $this->createIndex(
            'idx-posting_tags-tags_id',
            'posting_tags',
            'tags_id'
        );

        // add foreign key for table `tags`
        $this->addForeignKey(
            'fk-posting_tags-tags_id',
            'posting_tags',
            'tags_id',
            'tags',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `posting`
        $this->dropForeignKey(
            'fk-posting_tags-posting_id',
            'posting_tags'
        );

        // drops index for column `posting_id`
        $this->dropIndex(
            'idx-posting_tags-posting_id',
            'posting_tags'
        );

        // drops foreign key for table `tags`
        $this->dropForeignKey(
            'fk-posting_tags-tags_id',
            'posting_tags'
        );

        // drops index for column `tags_id`
        $this->dropIndex(
            'idx-posting_tags-tags_id',
            'posting_tags'
        );

        $this->dropTable('posting_tags');
    }
}
