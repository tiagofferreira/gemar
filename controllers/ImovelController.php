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
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;

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

            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => [
                            User::MASTER
                        ],
                    ],
               
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
            $caracteristicas = Yii::$app->request->post('CaracteristicasImovel')['caracteristica'];
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
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            //Caracteristicas salvas
            $savedCaract = ArrayHelper::map($model->caracteristicasImovel, 'caracteristica', 'caracteristica');
            //exit(print_r($savedCaract));
            //Caracteristicas selecionadas 
            $caracteristicas = Yii::$app->request->post('CaracteristicasImovel')['caracteristica'];
                    
            
            //Se vazio, as caracteristicas todas foram desmarcadas
            //Exclui as caracteristicas para este imovel
            if(empty($caracteristicas) && !empty($savedCaract))
            {
                CaracteristicasImovel::deleteAll('imovel = '.$model->id);
            }
            else
            {
                //Só os valores que não existem em ambos
                $intersec = array_merge(array_diff($savedCaract, $caracteristicas),
                                        array_diff($caracteristicas, $savedCaract));
                
                foreach($intersec as $value)
                {
                    //Se valor já salvo mas não está na seleção, excluir
                    if(in_array($value, $savedCaract) && !in_array($value, $caracteristicas))
                    {
                        CaracteristicasImovel::deleteAll('imovel = '.$model->id.' and caracteristica = '.$value);
                    }
                    //Se valor não salvo mas selecionado, inserir
                    elseif(!in_array($value, $savedCaract) && in_array($value, $caracteristicas))
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
            
            $model->valor = str_replace(['R$ ','.',','], ['','','.'], $model->valor);
            $model->iptu = str_replace(['R$ ','.',','], ['','','.'], $model->iptu);
            $model->condominio = str_replace(['R$ ','.',','], ['','','.'], $model->condominio);
            
            $model->area_util = str_replace(' m²', '', $model->area_util);
            $model->area_lote = str_replace(' m²', '', $model->area_lote);
            $model->area_const = str_replace(' m²', '', $model->area_const);     
            
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
     * Exibe as informações do imóvel selecionado pelo usuário
    */
    public function actionGuestView($id)
    {
        $this->layout = 'main';
        
        return $this->render('guestView', [
            'model' => $this->findModel($id),
        ]);
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
