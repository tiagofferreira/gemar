<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ImovelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Imóveis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imovel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Adicionar um Imóvel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'codigo',
            ['attribute'=>'tipo', 'value'=>'tipoImovel.nome'],
            ['attribute'=>'cidade', 'value'=>'bairro0.cidade0.nome'],
            ['attribute'=>'bairro', 'value'=>'bairro0.nome'],
            ['attribute'=>'situacao', 'value'=>'situacaoNome'],
            // 'valor',
            // 'condominio',
            // 'iptu',
            // 'area_util',
            // 'area_lote',
            // 'area_const',
            // 'banheiros',
            // 'suites',
            // 'quartos',
            // 'salas',
            // 'vagas',
            // 'varandas',
            // 'descricao:ntext',

            ['class' => 'yii\grid\ActionColumn',
                'header'=>'Ações',
             'template' => '{view} {update} {delete} {add-fotos}',
                'buttons' => [
                    //Adicionar fotos
                    'add-fotos' => function ($url, $model, $key) {                        
                            return Html::a('<span class="glyphicon glyphicon-camera"></span>', 
                                ['/fotos-imovel/create', 'imovel'=>$model->id], ['title'=>'Gerenciar Fotos']);
                    },
                ]
            ],
        ],
    ]); ?>

</div>
