<?php

namespace app\controllers;

use app\models\Imovel;
use app\models\ImovelSearch;
use app\models\TipoImovel;
use Yii;
use  yii\web\Session;

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

}
