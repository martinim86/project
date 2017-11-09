<?php
namespace frontend\rbac;

use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public $name = 'isAuthor'; // Имя правила

    public function execute($id, $item, $params)
    {
        if (isset($params['author_id'])){
            return true;
        } else {
            return false;
        }
    }
}