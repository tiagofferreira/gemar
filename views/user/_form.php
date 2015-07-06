<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'perfil')->dropDownList([User::ADMIN=>'Administrativo', User::MASTER=>'Gerência'], ['prompt'=>'Selecione']) ?>

    <?= $form->field($model, 'ativo')->dropDownList([1=>'Ativo', 0=>'Inativo'],['prompt'=>'Selecione']) ?>

    <?= $form->field($model, 'senha')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'senha_confirm')->passwordInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Editar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
