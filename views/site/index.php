<?php
/* @var $this yii\web\View */
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Gemar Imobiliária';
?>

<div class="panel panel-primary" style=" border-color: #003366;">
      <div class="panel-heading" style="background-color: #003366;"><span class="glyphicon glyphicon-home">&nbsp;</span>Imóveis em destaque</div>
      <div class="panel-body">
      
      	<?php if(empty($dataProvider->getModels())): ?>

		    <div class="alert alert-warning" role="alert">Nenhum imóvel encontrado</div>

		<?php else: ?>

		<ul class="list-group">
		<?php foreach($dataProvider->getModels() as $imovel): ?>


		      <li class="list-group-item">
		           <div class="row">
		                <div class="col-md-2">
		                <a href="<?= Url::to(['/imovel/guest-view', 'id'=>$imovel->id]) ?>" class="thumbnail">
		            <?php
		                  $src = $imovel->fotosImovel ? Yii::$app->params['upFotos'] . $imovel->fotosImovel[0]->nome_hash : Yii::$app->params['imgSite'] . 'semfoto.jpg';
		                     echo Html::img($src,['style'=>'max-height:100px;']);
		                    ?> </a>
		                </div>
		                <div class="col-md-8">
		                    <div class="row">
		                        <div class="col-md-4">
		                            <h4><?= $imovel->tipoImovel->nome ?></h4>
		                        </div>
		                        <div class="col-md-4">
		                            <h4><?= $imovel->valor ?> </h4>
		                        </div>
		                        <div class="col-md-4">
		                            <?= $imovel->quartos.' quarto(s)&nbsp;'.$imovel->vagas.' vaga(s)'; ?>
		                        </div>
		                    </div>
		                    <div class="row">
		                        <div class="col-md-4"><?= $imovel->bairro0->nome ?></div>
		                        <div class="col-md-4"><?= $imovel->bairro0->cidade0->nome.'/'.$imovel->bairro0->cidade0->uf0->sigla ?></div>
		                        <div class="col-md-4"><?= 'Código: '.$imovel->codigo ?></div>
		                    </div>
		                </div>
		            </div>
		      </li>


		<?php endforeach; ?>
		</ul>

		<?= LinkPager::widget([
		        'pagination' => $dataProvider->pagination,
		    ]);
		?>

		<?php endif; ?>

      </div>
</div>
    