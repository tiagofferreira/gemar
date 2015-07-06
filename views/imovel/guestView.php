<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Carousel;
use yii\bootstrap\Modal;

?>
<div class="panel panel-primary" style=" border-color: #003366;">
      <div class="panel-heading" style="background-color: #003366;"><span class="glyphicon glyphicon-info-sign">&nbsp;</span>Detalhes do Imóvel <?= $model->codigo ?></div>
      <div class="panel-body">

    
    <div class="col-md-7">
        <h4>Imagens</h4>

        <div class="row">
            <div class="thumbnail">
                <?php $src = $model->fotosImovel ? Yii::$app->params['upFotos'] . $model->fotosImovel[0]->nome_hash : Yii::$app->params['imgSite'] . 'semfoto.jpg'; ?>
                <?= Html::img($src, ['id'=>'mainPhoto', 'class'=>'img-responsive']) ?>
            </div>
        </div>

        <div class="row">

            <?php foreach($model->fotosImovel as $key=>$foto): ?>
                <div class="col-md-3">
                    <?php $href = Html::img(Yii::$app->params['upFotos'] . $foto->nome_hash,
                                  ['class'=>'img-responsive',
                                   'style'=>'height: 92px;',
                                   'onmouseover'=>'js: $("#mainPhoto").attr("src", $(this).attr("src"))'
                                  ])
                     ?>
                    <?= Html::a($href, '',['class'=>"thumbnail", 'onclick'=>'$("#carouselFotos").carousel('.$key.');', 'data' => [
                                        'toggle' => 'modal',
                                        'target' => '#slideFotos']]);
                   ?>
                </div>
            <?php endforeach; ?>

        </div>

    </div>

    <div class="col-md-5">
        <h4>Resumo</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                    <th><?= $model->getAttributeLabel('tipo') ?></th>
                    <td><?= $model->tipoImovel->nome ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('codigo') ?></th>
                    <td><?= $model->codigo ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('bairro') ?></th>
                    <td><?= $model->bairro0->nome ?></td>
                </tr>
                <tr>
                    <th><?= $model->bairro0->getAttributeLabel('cidade') ?></th>
                    <td><?= $model->bairro0->cidade0->nome ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('valor') ?></th>
                    <td><?= $model->valor ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('quartos') ?></th>
                    <td><?= $model->quartos ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('banheiros') ?></th>
                    <td><?= $model->banheiros ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('salas') ?></th>
                    <td><?= $model->salas ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('vagas') ?></th>
                    <td><?= $model->vagas ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('condominio') ?></th>
                    <td><?= $model->condominio ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('iptu') ?></th>
                    <td><?= $model->iptu ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('area_util') ?></th>
                    <td><?= $model->area_util ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('area_const') ?></th>
                    <td><?= $model->area_const ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('area_lote') ?></th>
                    <td><?= $model->area_lote ?></td>
                </tr>
            </table>
        </div>

    </div>

     <div class="col-md-12">
        <div class="row">
            <div class="panel panel-primary">
            <div class="panel-heading">Descrição</div>
              <div class="panel-body">
                <?= $model->descricao ?>
              </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Características do Imóvel</div>
                  <div class="panel-body">
                    <div  class="checkboxgroup">
                        <ul class="list-inline">
                            <?php foreach($model->caracteristicasImovel as $caracteristica): ?>
                                     <li><span class="glyphicon glyphicon-ok">&nbsp;</span>
                                         <?= $caracteristica->caracteristica0->nome ?>
                                     </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

    <?php
            $content = [];
            foreach($model->fotosImovel as $foto)
            {
              array_push( $content, '<div class="thumbnail"><img style="width: 50%;" src="'.Yii::$app->params['upFotos'] . $foto->nome_hash.'" class="img-responsive"></div>');
            }

            Modal::begin([
                        //'size'=>Modal::SIZE_LARGE,
                        'id'=>'slideFotos',
                        ]);
    ?>

        <?= 

            Carousel::widget(
              ['items' => $content,
               'id'=>'carouselFotos',
               'clientOptions'=>['interval'=>false]
              ]
              ); 
        ?>

    

    <?php Modal::end(); ?>
