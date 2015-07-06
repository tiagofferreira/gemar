<?php

namespace app\controllers;

use Yii;
use app\models\FotosImovel;
use app\models\FotosImovelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Imovel;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;

/**
 * FotosImovelController implements the CRUD actions for FotosImovel model.
 */
class FotosImovelController extends Controller
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
                'only' => ['create', 'update', 'delete', 'deleteMass'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete', 'delete-mass'],
                        'allow' => true,
                        'roles' => [
                            User::MASTER,
                        ],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [
                            User::ADMIN
                        ],
                    ],
                    [
                        'actions' => ['update', 'delete', 'delete-mass'],
                        'allow' => false,
                        'roles' => [
                            User::ADMIN
                        ],
                    ],
               
                ],
            ],
        ];
    }

    /**
     * Lists all FotosImovel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FotosImovelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FotosImovel model.
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
     * Creates a new FotosImovel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($imovel)
    {
        $model = new FotosImovel();

        $objImovel = Imovel::find()->where(['id' => $imovel])->one();
        
        //Fotos existentes
        $fotos = FotosImovel::find()->where(['imovel' => $imovel])->all();
        
        if ($model->load(Yii::$app->request->post()))
        {
            $salvo = true;
            $arquivos = UploadedFile::getInstances($model, 'arquivo');
            
            $qtdFotos = FotosImovel::find()->where('imovel = '.$imovel)->count();
        
            if((count($arquivos) + $qtdFotos) > 7)
            {
                Yii::$app->getSession()->setFlash('danger', 'A seleção ultrapassa o limite de 7 fotos por imóvel.');
                return $this->redirect(['imovel/view', 'id' => $imovel]);
            }
            
            foreach($arquivos as $arquivo)
            {
                
               //Extensão do arquivo
                $ext = end((explode(".", strtolower($arquivo->name))));

                $model->nome_arquivo = strtolower($arquivo->name);
                $model->nome_hash = Yii::$app->security->generateRandomString().".{$ext}";
                $model->imovel = $imovel;

                $path = Yii::$app->params['upFotos'] . $model->nome_hash;

                if($model->save())
                {
                    $arquivo->saveAs($path);
                    $this->tratarImagem($path);
                    $model = new FotosImovel();
                    Yii::$app->getSession()->setFlash('success', 'Fotos enviadas com sucesso!');
                }
                else
                {
                    $salvo = false;
                    Yii::$app->getSession()->setFlash('danger', $model->getFirstError('arquivo'));
                    break;
                }
            }
            
            return $this->redirect(['imovel/view', 'id' => $imovel]);
        }
        else
        {
            return $this->render('create', [
                'model' => $model,
                'imovel' => $objImovel,
                'fotos' => $fotos
            ]);
        }
    }
    
    public function tratarImagem($path)
    {
        $imagine = Image::getImagine();
        $watermark = $imagine->open(Yii::getAlias('@webroot/fotos/logoGemarWater.png'));
        $image     = $imagine->open($path);
        $size      = $image->getSize();
        $wSize     = $watermark->getSize();        
        
        //Dimensões da imagem original
        $width = $size->getWidth();
        $height = $size->getHeight();
        
         //Redimensionamento
        $maxWidth = 470;
        $maxHeight = 350;
        
        $finalWidth = 0;
        $finalHeight = 0;        
        
        //Proporção
        $ratio = 0;
        
        if($width > $maxWidth)
        {
            $ratio = $maxWidth / $width;
            $finalWidth = $maxWidth;
            $finalHeight = $height * $ratio;
            $image->resize(new \Imagine\Image\Box($finalWidth, $finalHeight));
        }
        
        if($height > $maxHeight)
        {
            $ratio = $maxHeight / $height; 
            $finalHeight = $maxHeight;
            $finalWidth = $width * $ratio;
            
            $image->resize(new \Imagine\Image\Box($finalWidth, $finalHeight));
        }        
        
        //Dimensões da imagem redimensionada
        $size   = $image->getSize();
        $width  = $size->getWidth();
        $height = $size->getHeight();
        
        //Posição da marca d'água X e Y (centralizado)
        $x = ($width - $wSize->getWidth())/2;
        $y = ($height - $wSize->getHeight()) / 2;

        $center = new \Imagine\Image\Point($x, $y);  
        
        $image->paste($watermark, $center);        
        $image->save($path);
    }

    /**
     * Updates an existing FotosImovel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FotosImovel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->isGuest || Yii::$app->user->identity->perfil == User::ADMIN)
            return 'null';

        $model =  $this->findModel($id);

        $file = Yii::$app->params['upFotos'] . $model->nome_hash;
            
        if (!empty($file) && file_exists($file))
        {
            unlink($file);
        }
        
        return $model->delete();
    }
    
    public function actionDeleteMass()
    {
        if(Yii::$app->user->isGuest || Yii::$app->user->identity->perfil == User::ADMIN)
            return 0;

        $cont = 0;
        foreach(Yii::$app->request->post()['foto'] as $id)
        {
            $model =  $this->findModel($id);

            $file = Yii::$app->params['upFotos'] . $model->nome_hash;

            if (!empty($file) && file_exists($file))
            {
                unlink($file);
            }
            
             $cont += $model->delete();
        }
        
        return $cont;
    }

    /**
     * Finds the FotosImovel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FotosImovel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FotosImovel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
