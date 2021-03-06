<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TipoImovelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos de Imóvel';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-imovel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Adicionar Tipo de Imóvel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',

            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Ações',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>

</div>
