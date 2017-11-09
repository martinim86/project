<?php

namespace frontend\controllers;

use common\models\CommentsForm;
use common\models\Comments;
use Yii;
use common\models\Posting;
use common\models\PostingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
//use yii\filters\AccessControl;
use frontend\rbac\AuthorRule;
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
        $posting = new Posting();
        $searchModel = new PostingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'getcategory'=>$getcategory,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'posting' =>$posting
        ]);
    }
    public function actionIn($id)
    {

        if(Yii::$app->request->isPost)
        {
            $model = new CommentsForm();
            $model->load(Yii::$app->request->post());

            if($model->saveComments($id))
            {
                Yii::$app->getSession()->setFlash('comment', 'Your comment add to post!');

            }
        }

        $model = Posting::findOne($id);
        $commentsForm = new CommentsForm();
        $tags = $model->tags;
        $dataProvider = new ActiveDataProvider([
            'query' => Comments::find()->where(['id_post'=>$id])->orderBy(' id DESC'),
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);


        return $this->render('view',
            [
                'model' => $model,
                'dataProvider'=>$dataProvider,
                'commentsForm'=>$commentsForm,
                'tags' => $tags

            ]);
    }

    /**
     * Displays a single Posting model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Posting::findOne($id);
        $comments2 = $model->comments;
        $tags = $model->tags;
        $commentsForm = new CommentsForm();

        $dataProvider = new ActiveDataProvider([
            'query' => Comments::find()->where(['id_post'=>$id])->orderBy(' id DESC'),
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);
        return $this->render('view', [
            'model' => $model,
            'dataProvider'=>$dataProvider,
            'comments2'=>$comments2,
            'commentsForm'=>$commentsForm,
            'tags' => $tags
        ]);
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
    public function createDirectory($path) {
        //$filename = "/folder/{$dirname}/";
        if (file_exists($path)) {
            //echo "The directory {$path} exists";
        } else {
            mkdir($path, 0775, true);
            //echo "The directory {$path} was successfully created.";
        }
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


}
