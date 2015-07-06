<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Imovel */

$this->title = 'Editar dados do Imóvel: ' . ' ' . $model->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Imóveis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codigo, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar dados';
?>
<div class="imovel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipoImovel' => $tipoImovel,
        'cidades'=>$cidades,
        'caracteristicas'=>$caracteristicas,
        'caractSelected'=>$caractSelected,
        'caractImovel'=>$caractImovel,    
        'cidade'=>$cidade,
        'bairros'=>$bairros
    ]) ?>

</div>

