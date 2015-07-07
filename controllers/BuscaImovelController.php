<?php

namespace app\controllers;

use app\models\Imovel;
use app\models\ImovelSearch;
use app\models\TipoImovel;
use Yii;
use  yii\web\Session;
use yii\web\NotFoundHttpException;

class BuscaImovelController extends \yii\web\Controller
{
        
    public function actionBuscar()
    {
        $searchModel = new ImovelSearch();
        $dataProvider = $searchModel->userSearch(Yii::$app->request->queryParams);
        
        $session = Yii::$app->session;
        $session['dadosBusca'] = Yii::$app->request->queryParams;
        
        return $this->render('busca', ['dataProvider'=>$dataProvider]);
        
        
    }

    public function actionBuscarCodigo($codigo)
    {

    	$imovel = Imovel::find()->where("codigo = '".strtoupper($codigo)."'")->one();

    	if(!empty($imovel))
    	{
    		$this->layout = 'main';
        
	        return $this->render('/imovel/guestView', [
	            'model' => $imovel,
	        ]);
    	}else {
            throw new NotFoundHttpException('Não existe imóvel com o código informado.');
        }

    }

}
