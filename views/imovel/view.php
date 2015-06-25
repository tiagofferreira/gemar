<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Imovel */

$this->title = 'Imóvel '.$model->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Imóveis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imovel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar Imóvel', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir Imóvel', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja excluir este imóvel?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo',
            ['attribute'=>'tipo', 'value'=>$model->tipoImovel->nome],
            ['attribute'=>'cidade', 'value'=>$model->bairro0->cidade0->nome],
            ['attribute'=>'bairro', 'value'=>$model->bairro0->nome],
            ['attribute'=>'situacao', 'value'=>$model->situacaoNome],
            ['attribute'=>'valor', 'value'=> !is_null($model->valor) ? 'R$ '.$model->valor : null],
            ['attribute'=>'condominio', 'value'=> !is_null($model->condominio) ? 'R$ '.$model->condominio : null],
            ['attribute'=>'iptu', 'value'=> !is_null($model->iptu) ? 'R$ '.$model->iptu : null],
            ['attribute'=>'area_util', 'value'=> !is_null($model->area_util) ? $model->area_util.' m²' : null],
            ['attribute'=>'area_lote', 'value'=> !is_null($model->area_lote) ? $model->area_lote.' m²' : null],
            ['attribute'=>'area_const', 'value'=> !is_null($model->area_const) ? $model->area_const.' m²' : null],
            'banheiros',
            'suites',
            'quartos',
            'salas',
            'vagas',
            'varandas',
            'descricao:ntext',
        ],
    ]) ?>

</div>
