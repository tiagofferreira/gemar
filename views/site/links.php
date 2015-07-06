<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Links Úteis';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-primary" style=" border-color: #003366;">
      <div class="panel-heading" style="background-color: #003366;"><span class="glyphicon glyphicon-link">&nbsp;</span><?= Html::encode($this->title) ?></div>
      <div class="panel-body">   
    
        <div class="row">
          <a href="http://portaldeservicos.pbh.gov.br/portalservicos/view/paginas/escolheHome.jsf;jsessionid=7204D954F5E7D72370554617DEDACB8E.portal1" target="_blank">        
              <div class="col-xs-6 col-md-3">          
                <div class="thumbnail">
                  <?= Html::img(Yii::$app->params['imgSite'] . 'pbh.gif') ?>
                <div class="caption" style="text-align: center;">
                    <p><strong>Portal de Informações</strong></p>
                </div>    
                </div>
              </div>
          </a>
        
          <a href="http://www.caixa.gov.br/voce/habitacao/Paginas/default.aspx" target="_blank">    
              <div class="col-xs-6 col-md-3">    
                <div class="thumbnail">
                  <?= Html::img(Yii::$app->params['imgSite'] . 'caixa.gif') ?>
                <div class="caption" style="text-align: center;">
                    <p><strong>Habitação - Financiamentos</strong></p>
                </div>    
                </div>
              </div>
          </a>

          <a href="http://www.cartorio24horas.com.br/" target="_blank"> 
              <div class="col-xs-6 col-md-3">    
                <div class="thumbnail">
                  <?= Html::img(Yii::$app->params['imgSite'] . 'cartorio24.gif') ?>
                <div class="caption" style="text-align: center;">
                    <p><strong>Serviços e Informações</strong></p>
                </div>    
                </div>        
              </div>
          </a>
          
        </div>

  </div>
</div>

    
