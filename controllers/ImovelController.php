<?php

namespace app\controllers;

use Yii;
use app\models\Imovel;
use app\models\ImovelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\TipoImovel;
use app\models\Cidade;
use app\models\Caracteristicas;
use app\models\CaracteristicasImovel;
use app\models\Bairro;

/**
 * ImovelController implements the CRUD actions for Imovel model.
 */
class ImovelController extends Controller
{
    public $layout = 'admin';
    
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
     * Lists all Imovel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImovelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Imovel model.
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
     * Creates a new Imovel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Imovel();
        $caractImovel = new CaracteristicasImovel();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $caracteristicas = Yii::$app->request->post('CaracteristicasImovel');
            
            $model->codigo = strtoupper(Yii::$app->request->post('Imovel')['codigo']);
            if($model->save(false))
            {
                if(!empty($caracteristicas))
                {
                    foreach($caracteristicas as $value)
                    {
                        $caractImovel = new CaracteristicasImovel();
                        
                        $caractImovel->imovel = $model->id;
                        $caractImovel->caracteristica = $value;
                        
                        $caractImovel->save(false);
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else
        {
            $tipoImovel = ArrayHelper::map(TipoImovel::find()->orderBy('nome')->all(), 'id', 'nome');
            $cidades = ArrayHelper::map(Cidade::find()->orderBy('nome')->all(), 'codigo', 'nome');            
            $caracteristicas = ArrayHelper::map(Caracteristicas::find()->all(), 'id', 'nome');
                
            return $this->render('create', [
                'model' => $model,
                'tipoImovel' => $tipoImovel,
                'cidades'=>$cidades,
                'caracteristicas'=>$caracteristicas,
                'caractImovel'=>$caractImovel
            ]);
        }
    }

    /**
     * Updates an existing Imovel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        print_r(ArrayHelper::map($model->caracteristicasImovel, 'caracteristica', 'caracteristica'));
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            //Caracteristicas salvas
            $savedCaract = ArrayHelper::map($model->caracteristicasImovel, 'caracteristica', 'caracteristica');
            
            $caracteristicas = Yii::$app->request->post('CaracteristicasImovel');
            
            exit(print_r(array_diff($savedCaract, $caracteristicas)));
                
            if(!empty($caracteristicas))
            {
                //CaracteristicasImovel::
                
                foreach($caracteristicas as $value)
                {
                    $caractImovel = new CaracteristicasImovel();

                    $caractImovel->imovel = $model->id;
                    $caractImovel->caracteristica = $value;

                    $caractImovel->save(false);
                }
            }
            
            
           
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else
        {
            
            $tipoImovel = ArrayHelper::map(TipoImovel::find()->orderBy('nome')->all(), 'id', 'nome');
            $cidades = ArrayHelper::map(Cidade::find()->orderBy('nome')->all(), 'codigo', 'nome');            
            $caracteristicas = ArrayHelper::map(Caracteristicas::find()->all(), 'id', 'nome');
            
            $caractImovel = new CaracteristicasImovel();
            
            $cidade = $model->bairro0->cidade0->codigo;
            
            $cidades = ArrayHelper::map(Cidade::find()->all(), 'codigo', 'nome');
            
            $bairros = ArrayHelper::map(Bairro::find()->where("cidade = $cidade")->all(), 'codigo', 'nome');
            
            $caractSelected = ArrayHelper::map(CaracteristicasImovel::find()->where("imovel = $model->id")->all(), 'caracteristica', 'caracteristica');
            
            return $this->render('update', [
                'model' => $model,
                'tipoImovel' => $tipoImovel,
                'cidades'=>$cidades,
                'caracteristicas'=>$caracteristicas,
                'caractSelected'=>$caractSelected,
                'caractImovel'=>$caractImovel,
                'cidade'=>$cidade,
                'bairros'=>$bairros
            ]);
        }
    }

    /**
     * Deletes an existing Imovel model.
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
     * Finds the Imovel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Imovel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Imovel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
