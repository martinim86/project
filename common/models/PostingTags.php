<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "posting_tags".
 *
 * @property integer $id
 * @property integer $posting_id
 * @property integer $tags_id
 *
 * @property Posting $posting
 * @property Tags $tags
 */
class PostingTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posting_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['posting_id', 'tags_id'], 'required'],
            [['posting_id', 'tags_id'], 'integer'],
            [['posting_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posting::className(), 'targetAttribute' => ['posting_id' => 'id']],
            [['tags_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::className(), 'targetAttribute' => ['tags_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'posting_id' => 'Posting ID',
            'tags_id' => 'Tags ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosting()
    {
        return $this->hasOne(Posting::className(), ['id' => 'posting_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasOne(Tags::className(), ['id' => 'tags_id']);
    }
}
