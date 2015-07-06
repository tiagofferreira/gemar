<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Imovel */

$this->title = 'Imóvel '.$model->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Imóveis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imovel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <?php
            foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
            }
        ?>
    </div>
    
    <p>
        <?= Html::a('Editar Imóvel', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir Imóvel', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja excluir este imóvel?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('<span class="glyphicon glyphicon-camera" aria-hidden="true"></span> Gerenciar Fotos', ['fotos-imovel/create', 'imovel' => $model->id], 
                        ['class' => 'btn btn-default',
                        ]) 
        ?>
        
        <?php 
                Modal::begin([
                            'size'=>Modal::SIZE_LARGE,
                            'header' => '<h3>Fotos do imóvel</h3>',
                            'footer'=>'<button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>',
                            'toggleButton' => ['label' => '<span class="glyphicon glyphicon-picture">&nbsp;</span>Ver Fotos', 'class'=>'btn btn-success'],
                        ]);
        ?>
                       <div class="row" id="thumbs">
                            <?php foreach($model->fotosImovel as $foto): ?>

                                  <div class="col-sm-6 col-md-2">
                                    <div class="thumbnail">
                                          <div class="caption">   
                                            <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->perfil == User::MASTER): ?>     
                                                <p class="pull-right">

                                                    <?= Html::a('<span class="glyphicon glyphicon-trash text-danger"></span>', '#', 
                                                                ['title'=>'Excluir',  
                                                                 'onclick'=>'
                                                                    if(!confirm("Tem certeza que deseja escluir esta foto?"))
                                                                        return false;

                                                                    $.ajax({
                                                                        url: "'.Url::to(['fotos-imovel/delete', 'id'=>$foto->id]).'",
                                                                        type: "POST",
                                                                        success: function(data)
                                                                                 {                                                                                
                                                                                    if(data == null)
                                                                                        alert("Não foi possível excluir");
                                                                                    else
                                                                                    { 
                                                                                        location.reload();
                                                                                    }
                                                                                 }
                                                                    });
                                                                 ']) ?>
                                                </p>
                                            <?php endif; ?>
                                          </div>
                                          <img src=<?= Yii::$app->params['upFotos'] . $foto->nome_hash ?> 
                                               alt="<?= Yii::$app->params['upFotos'] . $foto->nome_arquivo ?>"
                                               style="height: 200px; width: 200px; display: block;"
                                               data-holder-rendered="true">
                                    </div>
                                  </div>

                            <?php endforeach; ?>
                        </div>

         <?php  Modal::end(); ?>
        
        
        
        <?php 
                Modal::begin([
                            'header' => '<h3>Características do imóvel</h3>',
                            'footer'=>'<button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>',
                            'toggleButton' => ['label' => '<span class="glyphicon glyphicon-list"></span>&nbsp;Características do Imóvel', 'class'=>'btn btn-info'],
                        ]);
        ?>
        
        <div  class="checkboxgroup">
            <ul class="list-inline">
                <?php foreach($model->caracteristicasImovel as $caracteristica): ?>         
                         <li><span class="glyphicon glyphicon-ok">&nbsp;</span> 
                             <?= $caracteristica->caracteristica0->nome ?>
                         </li>
                <?php endforeach; ?>
            </ul>
        </div>
    
        <?php Modal::end(); ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo',
            ['attribute'=>'destaque', 'value'=>$model->destaque == 1 ? 'Sim' : 'Não'],
            ['attribute'=>'tipo', 'value'=>$model->tipoImovel->nome],
            ['attribute'=>'cidade', 'value'=>$model->bairro0->cidade0->nome],
            ['attribute'=>'bairro', 'value'=>$model->bairro0->nome],
            ['attribute'=>'situacao', 'value'=>$model->situacaoNome],
            'valor', 
            'condominio',
            'iptu',
            'area_util',
            'area_lote',
            'area_const',
            'banheiros',
            'suites',
            'quartos',
            'salas',
            'vagas',
            'varandas',
            'descricao:ntext',
        ],
    ]) ?>

</div>

<?php $this->registerJs('
    $(document).ready(function() {
            $("#thumbs img").each(function() {
            var maxWidth = 150; // Max width for the image
            var maxHeight = 150;    // Max height for the image
            var ratio = 0;  // Used for aspect ratio
            var width = $(this).width();    // Current image width
            var height = $(this).height();  // Current image height

            // Check if the current width is larger than the max
            if(width > maxWidth){
                ratio = maxWidth / width;   // get ratio for scaling image
                $(this).css("width", maxWidth); // Set new width
                $(this).css("height", height * ratio);  // Scale height based on ratio
                height = height * ratio;    // Reset height to match scaled image
            }

            width = $(this).width();    // Current image width
            height = $(this).height();  // Current image height

            // Check if current height is larger than max
            if(height > maxHeight){
                ratio = maxHeight / height; // get ratio for scaling image
                $(this).css("height", maxHeight);   // Set new height
                $(this).css("width", width * ratio);    // Scale width based on ratio
                width = width * ratio;    // Reset width to match scaled image
            }
        });
    });'); ?>
