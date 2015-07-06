<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">

    <div class="panel panel-primary" style=" border-color: #003366;">
      <div class="panel-heading" style="background-color: #003366;"><span class="glyphicon glyphicon-warning-sign">&nbsp;</span><?= Html::encode($this->title) ?></div>
      <div class="panel-body">
            <div class="alert alert-danger">
                <?= nl2br(Html::encode($message)) ?>
            </div>

            <p>
                O erro acima ocorreu quando o servidor tentou processar sua requisição.
            </p>
            <p>
                Contate o desenvolvedor ou provedor do serviço em caso de dúvidas.
            </p>
        </div>
    </div>

</div>
