<?php
namespace frontend\controllers;

use Yii;
use common\models\Card;
use common\models\CardSearchDB;
use common\models\CardElastic;
use common\models\CardElasticSearch;
use common\models\CardImageHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;


/**
 * CardController implements the CRUD actions for Card model.
 */
class CardController extends Controller
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
        ];
    }

    /**
     * Lists all Card models.
     * @return mixed
     */
    public function actionIndex()
    {
       
        $model = new CardElasticSearch();
        $provider = $model->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'provider' => $provider,
        ]);
    }

    /**
     * Displays a single Card model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->view_increase();
        $model->update();

        return $this->render('card', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Card model.
     * If creation is successful, the browser will be redirected to the 'card' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Card();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $upload_img = UploadedFile::getInstance($model, 'image');
			if(!empty($upload_img)){
				$image = new CardImageHelper();
				if($old_img){
					$image->delete($old_img);
				}
				$image->image = UploadedFile::getInstance($model, 'image');
				$model->image = $image->upload($model->id);
				$model->save();
			}
			$elasticModel = new CardElastic();

            $elasticModel->attributes = [
                'id' => $model->id,
                'title' => $model->title,
                'description' => $model->description,
				'image' => $model->image,
                'views' => 0,
            ];
            $elasticModel->primaryKey = $model->id;
            $elasticModel->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Card model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$old_img = $model->image;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            
			$upload_img = UploadedFile::getInstance($model, 'image');
			if(!empty($upload_img)){
				$image = new CardImageHelper();
				if($old_img){
					$image->delete($old_img);
				}
				$image->image = UploadedFile::getInstance($model, 'image');
				$model->image = $image->upload($model->id);
			}
			else{
				$model->image = $old_img;
			}
			$model->save();
			
			$elasticModel = $this->findElasticModel($id);
            $elasticModel->attributes = [
                'title' => $model->title,
                'description' => $model->description,
				'image' => $model->image,
            ];
			
            $elasticModel->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Card model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findElasticModel($id)->delete();
		$db_model = $this->findModel($id);
		$del_img = $db_model->image;
		if($del_img){
			$image = new CardImageHelper();
			$image->delete($del_img);
		}
		
		$db_model->delete();
        
		
        return $this->redirect(['index']);
    }

    /**
     * Finds the Card model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Card the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Card::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Card Elastic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CardElastic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findElasticModel($id)
    {
        if (($model = CardElastic::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

