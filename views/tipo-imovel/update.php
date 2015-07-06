<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TipoImovel */

$this->title = 'Alterar Tipo de Imóvel: ' . ' ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Imóvel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->nome;
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="tipo-imovel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
