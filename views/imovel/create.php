<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Imovel */

$this->title = 'Adicionar Imóvel';
$this->params['breadcrumbs'][] = ['label' => 'Imóveis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imovel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipoImovel' => $tipoImovel,
        'cidades'=>$cidades,
        'caracteristicas'=>$caracteristicas,
        'caractImovel'=>$caractImovel
    ]) ?>

</div>
