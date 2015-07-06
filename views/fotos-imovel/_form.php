<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\FotosImovel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
<h2 class="page-header">Adicionar Fotos</h2>
<?php    

	$form = ActiveForm::begin([
	    'options'=>['enctype'=>'multipart/form-data'] // important
	]);
	
    echo $form->field($model, 'imovel')->hiddenInput(['value'=>$imovel])->label('');

	echo FileInput::widget([
	    'model' => $model,
	    'attribute' => 'arquivo[]',        
        'language' => 'fr',
	    'options' => ['accept'=>'image/*', 'multiple' => true],
	    'pluginOptions'=>['allowedFileExtensions'=>['jpg','jpeg','png'],
		    			  'previewFileType' => 'image',
                          'maxFileCount' => 7
		]
	]);
	

	ActiveForm::end();
?>
</div>

<?php if(!empty($fotos)): ?>

<div class="row" id="fotos">
    
    <h2 class="page-header">Fotos existentes</h2>
    
    
    
    <?= Html::beginForm(['/fotos-imovel/delete-mass'],'post', ['id'=>'formDelete']) ?>

    <?php foreach($fotos as $foto): ?>
        
        <div class="col-md-2">
            <div class="thumbnail">
                  <div class="caption">                
                    <p class="pull-right">
                        <?= Html::checkbox('foto[]', false, ['value'=>$foto->id]) ?>
                    </p>
                </div>
                <img src=<?= Yii::$app->params['upFotos'] . $foto->nome_hash ?> 
                                               alt="<?= Yii::$app->params['upFotos'] . $foto->nome_arquivo ?>"
                                               class="img-responsive"
                                               data-holder-rendered="true">
            </div>
        </div>
    
    <?php endforeach; ?>
</div>

    <div class="row">
        <?= Html::button('Excluir fotos selecionadas', ['class'=>'btn btn-danger', 
                'onclick' =>
                    'if($("#fotos :checkbox:checked").length == 0)
                    {
                        alert("Selecione as fotos para excluir!");
                        return;
                    }
                    else
                        if(!confirm("Tem certeza que deseja excluir as fotos selecionadas?"))
                                    return;
                         else
                         {
                            $.post("'.Url::to(['/fotos-imovel/delete-mass']).'", $("#formDelete").serialize())
                                .done(function(data){
                                    if(data == 0)
                                        alert("Não foi possível excluir");
                                    else
                                    {
                                        alert("Fotos excluídas com sucesso");
                                        location.reload();
                                    }
                                });
                         }
                '
                                                             
        ]) ?>
    </div>
    
    <?= Html::endForm() ?>

    <?php endif; ?>

    
