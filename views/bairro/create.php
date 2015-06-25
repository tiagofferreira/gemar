<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Bairro */

$this->title = 'Create Bairro';
$this->params['breadcrumbs'][] = ['label' => 'Bairros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bairro-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
