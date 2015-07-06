<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Caracteristicas */

$this->title = 'Adicionar Característica de Imóvel';
$this->params['breadcrumbs'][] = ['label' => 'Características de Imóvel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caracteristicas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
