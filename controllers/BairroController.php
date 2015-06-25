<?php

namespace app\controllers;

use Yii;
use app\models\Bairro;
use app\models\BairroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * BairroController implements the CRUD actions for Bairro model.
 */
class BairroController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Bairro models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BairroSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bairro model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Bairro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bairro();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->codigo]);
        }
        else
        {
            
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Bairro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->codigo]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Bairro model.
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
     * Finds the Bairro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bairro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bairro::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionGetBairros($cidade, $type = null)
    {        
        $bairros = Bairro::find()->select(['label'=>'nome', 'value'=>'codigo'])->where(['cidade' => $cidade])->orderBy('nome asc')->asArray()->all();
        
        $retorno = '';
        
        if(!is_null($type))
        {
            //Definindo o retorno como json, para o widget de multiselect
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            $retorno = $bairros;
        }
        else
        {
            if(count($bairros) > 0)
            {
                $retorno .= "<option value=''>Selecione</option>";
                
                foreach($bairros as $bairro){
                    $retorno .= "<option value='".$bairro['value']."'>".$bairro['label']."</option>";
                }
            }
            else{
                $retorno .= "<option>-</option>";
            }
        }
            
        
        return $retorno;  
    }
}
