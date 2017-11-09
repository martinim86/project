<?php
namespace common\models;
use yii\base\Model;
use Yii;


class CommentsForm extends Model{
    public $comment;
    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['comment'], 'string', 'length' => [3,250]]
        ];
    }
    public function saveComments($id_post)
    {
        $comment = new Comments;
        $comment->content = $this->comment;
        $comment->user_id = Yii::$app->user->id;
        $comment->id_post = $id_post;
        $comment->date = "01.12.2015";
        $comment->name = "123";
        $comment->email = "123";
        return $comment->save();

    }
}