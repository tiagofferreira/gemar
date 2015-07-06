<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->token]);
?>
<div class="password-reset">
    <p>Olá <?= Html::encode($user->nome) ?>,</p>

    <p>Siga o link abaixo para redefinir sua senha de acesso ao site:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
