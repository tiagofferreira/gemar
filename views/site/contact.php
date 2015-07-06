<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Contato';
?>
<div class="panel panel-primary" style=" border-color: #003366;">
      <div class="panel-heading" style="background-color: #003366;"><span class="glyphicon glyphicon-send">&nbsp;</span><?= Html::encode($this->title) ?></div>
      <div class="panel-body"> 

        <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Agradecemos o seu contato. Responderemos assim que possível.
        </div>

        <?php else: ?>

        <p>
            Caso tenha qualquer dúvida, crítica ou sugestão entre em contato conosco. Obrigado!
        </p>

        <div class="row">
            <div class="col-lg-8">
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                    <?= $form->field($model, 'name') ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'subject') ?>
                    <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <?php endif; ?>
    </div>
</div>
