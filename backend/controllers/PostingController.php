<?php

namespace backend\controllers;
use common\models\Category;
use common\models\ImageUpload;
use common\models\Tags;
use Yii;
use common\models\CommentsForm;
use common\models\Comments;
use common\models\Posting;
use common\models\PostingSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\imagine\Image;

use Imagine\Image\Box;


/**
 * PostingController implements the CRUD actions for Posting model.
 */
class PostingController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['news'],
//                        'allow' => true,
//                        'roles' => ['admin'],
//                    ],
//                ],
//            ],
        ];
    }

    /**
     * Lists all Posting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $posts = new Posting();
        $getcategory = $posts->getCategory();
        $searchModel = new PostingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'getcategory'=>$getcategory,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Posting model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionCreatecom($id)
    {
        $model = new CommentsForm();
        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            if($model->saveComments($id))
            {
                Yii::$app->getSession()->setFlash('comment', 'Your comment add to post!');
                return $this->redirect(['posting/view','id'=>$id]);
            }
        }
    }
    public function actionAllow($id)
    {
        $posting = Posting::findOne($id);
        if($posting->allow())
        {
            return $this->redirect(['posting/view','id'=>$id]);
        }
    }

    public function actionDisallow($id)
    {
        $posting = Posting::findOne($id);
        if($posting->disallow())
        {
            return $this->redirect(['posting/view','id'=>$id]);
        }
    }

    /**
     * Creates a new Posting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Posting();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->controller->createDirectory(Yii::getAlias('images/news/'));
            $file = UploadedFile::getInstance($model, 'img');
            if ($file && $file->tempName) {
                $model->img = $file;
                    $dir = Yii::getAlias('images/news/');
                    $fileName = $model->img->baseName . '.' . $model->img->extension;
                    $model->img->saveAs($dir . $fileName);
                    $model->img = $fileName; // без этого ошибка
                    $model->img = '/'.$dir . $fileName;
// Для ресайза фотки до 800x800px по большей стороне надо обращаться к функции Box() или widen, так как в обертках доступны только 5 простых функций: crop, frame, getImagine, setImagine, text, thumbnail, watermark
                    $photo = Image::getImagine()->open($dir . $fileName);
                    $photo->thumbnail(new Box(800, 800))->save($dir . $fileName, ['quality' => 90]);
                    Yii::$app->controller->createDirectory(Yii::getAlias('images/news/thumbs'));
                    Image::thumbnail($dir . $fileName, 150, 70)
                        ->save(Yii::getAlias($dir .'thumbs/'. $fileName), ['quality' => 80]);
                    $model->tmb = '/'.$dir .'thumbs/'. $fileName;
                }
            }
            if ($model->save()) {
                return $this->render('create', [
                    'model' => $model,
                ]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSetImage($id)
    {
        $model = new ImageUpload;
//
        if (Yii::$app->request->isPost)
        {
            $article = $this->findModel($id);
            $file = UploadedFile::getInstance($model, 'img');


            if($article->saveImage($model->uploadFile($file,$article->img)))
            {
                return $this->redirect(['view', 'id'=>$article->id]);
            }
        }

        return $this->render('img', ['model'=>$model]);
    }
    public function createDirectory($path) {
        //$filename = "/folder/{$dirname}/";
        if (file_exists($path)) {
            //echo "The directory {$path} exists";
        } else {
            mkdir($path, 0775, true);
            //echo "The directory {$path} was successfully created.";
        }
    }
    public function actionSetCategory($id)
    {
        $article = $this->findModel($id);
        $selectedCategory = $article->categories->id;
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'category_name');

        if(Yii::$app->request->isPost)
        {
            $category = Yii::$app->request->post('category');
            if($article->saveCategory($category))
            {
                return $this->redirect(['view', 'id'=>$article->id]);
            }
        }

        return $this->render('category', [
            'article'=>$article,
            'selectedCategory'=>$selectedCategory,
            'categories'=>$categories
        ]);
    }
    public function actionSetTags($id)
    {
        $article = $this->findModel($id);
        $selectedTags = $article->getSelectedTags(); //
        $tags = ArrayHelper::map(Tags::find()->all(), 'id', 'title');

        if(Yii::$app->request->isPost)
        {
            $tags = Yii::$app->request->post('tags');

            $article->saveTags($tags);
            return $this->redirect(['view', 'id'=>$article->id]);
        }

        return $this->render('tags', [
            'selectedTags'=>$selectedTags,
            'tags'=>$tags
        ]);
    }

    /**
     * Updates an existing Posting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
            //Yii::$app->controller->createDirectory(Yii::getAlias('images/news/'));
            $file = UploadedFile::getInstance($model, 'img');
            if(!empty($file) && $model->load(Yii::$app->request->post())) {
                    $model->img = $file;
                    $dir = Yii::getAlias('images/news/');
                    $fileName = $model->img->baseName . '.' . $model->img->extension;
                    $model->img->saveAs($dir . $fileName);
                    $model->img = $fileName; // без этого ошибка
                    $model->img = '/' . $dir . $fileName;
// Для ресайза фотки до 800x800px по большей стороне надо обращаться к функции Box() или widen, так как в обертках доступны только 5 простых функций: crop, frame, getImagine, setImagine, text, thumbnail, watermark
                    $photo = Image::getImagine()->open($dir . $fileName);
                    $photo->thumbnail(new Box(800, 800))->save($dir . $fileName, ['quality' => 90]);
                    Yii::$app->controller->createDirectory(Yii::getAlias('images/news/thumbs'));
                    Image::thumbnail($dir . $fileName, 150, 70)
                        ->save(Yii::getAlias($dir . 'thumbs/' . $fileName), ['quality' => 80]);
                    $model->tmb = '/' . $dir . 'thumbs/' . $fileName;
                $model->save();
            } else {
                $model->save();
            }
            return $this->render('create', [
                'model' => $model,
            ]);
    }


    /**
     * Deletes an existing Posting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Posting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionNews(){

        $posts = Posting::find()->all();

        return $this->render('news', ['posts' => $posts]);
    }
    public function actionCategory($category)
    {
        $posts = Posting::find()
            ->where(['category'=> $category])
            ->all();
        return $this->render('news', [
            'posts' =>  $posts,
        ]);
    }
    public function actionCreate123()
    {
        $model = new Comments();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
//            return $this->render('view', [
//                'model' => $this->findModel($id),
//            ]);

        }
    }
    public function action123()
    {
//        $auth = Yii::$app->authManager;
//        $rule = new AuthorRule;
////        $auth->add($rule);
//        $updateOwnPost = $auth->createPermission('updateOwnPost');
//        $updateOwnPost->description = 'Редактировать посты';
//        $updateOwnPost->ruleName = $rule->name;
////        $auth->add($updateOwnPost);
////        $updatePost = Yii::$app->authManager->getPermission('updatePost');
////        $auth->addChild($updateOwnPost, $updatePost);
//        $admin = Yii::$app->authManager->getRole('admin');
////// и тут мы позволяем автору редактировать свои посты
////        $auth->addChild($admin, $updateOwnPost);
//        $role = Yii::$app->authManager->getRole($admin);
//        $permit = Yii::$app->authManager->getPermission($createPost);
//        Yii::$app->authManager->addChild($role, $permit);
//        $userRole = Yii::$app->authManager->getRole('visitor');
//        Yii::$app->authManager->assign($userRole, 10);
        $auth = Yii::$app->authManager;
        $updatePost = Yii::$app->authManager->getPermission('createPost');
        $author = Yii::$app->authManager->getRole('redactor');
// и тут мы позволяем автору редактировать свои посты
        $auth->addChild($author, $updatePost);
        return 123;
    }
}
