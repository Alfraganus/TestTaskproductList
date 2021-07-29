<?php

namespace app\controllers;

use Yii;
use app\models\Products;
use app\models\search\Products as ProductsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Products model.
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create','update','view','delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create','update','view','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();
        if ($model->load(Yii::$app->request->post())) {
            $newCover = UploadedFile::getInstance($model, 'image');
            $newCoverName = Yii::$app->security->generateRandomString();
            $model->image = $newCoverName . '.' . $newCover->extension;
            $newCover->saveAs('covers/' . $newCoverName . '.' . $newCover->extension);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
            $sku = Yii::$app->security->generateRandomString(20);

        return $this->render('create', [
            'model' => $model,
            'sku' => $sku,
        ]);
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldImage = $model->image;
       $model->image = '/covers/'.$model->image??'/covers/noimage.png';
        if ($model->load(Yii::$app->request->post())  ) {

            $newCover = UploadedFile::getInstance($model, 'image');

            if(isset($newCover)){
                $newCoverName = Yii::$app->security->generateRandomString();
                $model->image =  $newCoverName . '.' . $newCover->extension;
                $newCover->saveAs( $newCoverName . '.' . $newCover->extension);
            } else {
                $model->image = $oldImage;
            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionBulkDelete()
    {
        $selection = (array)Yii::$app->request->post('selection');//typecasting
        if (sizeof($selection) > 0) {
            foreach ($selection as $select) {
                $product = Products::findOne($select);
                $product->delete();
            }
            Yii::$app->session->setFlash('info', 'Product(s) have been deleted successfully');
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::$app->session->setFlash('danger', 'Please choose at least 1 element!');
            return $this->redirect(Yii::$app->request->referrer);
        }
    }


    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
