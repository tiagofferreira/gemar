<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FotosImovel */

$this->title = 'Gerenciar Fotos do Imóvel '.$imovel->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Imóveis', 'url' => ['imovel/index']];
$this->params['breadcrumbs'][] = ['label' => $imovel->codigo, 'url' => ['imovel/view', 'id'=>$imovel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fotos-imovel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'imovel' => $imovel->id,
        'fotos' => $fotos
    ]) ?>

</div>
