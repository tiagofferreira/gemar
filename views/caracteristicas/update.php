<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Caracteristicas */

$this->title = 'Editar Característica de Imóvel: ' . ' ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Características de Imóvel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->nome;
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="caracteristicas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
