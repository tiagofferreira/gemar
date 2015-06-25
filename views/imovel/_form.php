<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Imovel;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\money\MaskMoney;
    
/* @var $this yii\web\View */
/* @var $model app\models\Imovel */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['validateOnSubmit'=>false]); ?>

<div class="row">
    
  <div class="col-md-6">
    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true, 'style'=>'text-transform: uppercase;']) ?>
      
    <?= $form->field($model, 'tipo')->dropDownList($tipoImovel, ['prompt'=>'Selecione']) ?>

    <div class="form-group field-imovel-iptu">
        <?= Html::label('Cidade', 'cidade')  ?>    
        <?= Html::dropdownlist('cidade', isset($cidade) ? $cidade : '', $cidades, 
                               ['prompt'=>'Selecione', 'class'=>'form-control ',
                                'onchange'=>'
                                    $.get( "'.Url::toRoute('/bairro/get-bairros').'", { cidade: $(this).val() } )
                                        .done(function( data ) {     
                                            $("#imovel-bairro").html(data);
                                        }
                                    );
                                '
                               ])
        ?>
    </div>

    <?= $form->field($model, 'iptu')->widget(MaskMoney::classname()) ?>
    
    <?= $form->field($model, 'area_lote')->textInput(['placeholder'=>'m²']) ?>
    
    <?= $form->field($model, 'area_util')->textInput(['placeholder'=>'m²']) ?>

    <?= $form->field($model, 'banheiros')->textInput() ?>
    
    <?= $form->field($model, 'vagas')->textInput() ?>

    <?= $form->field($model, 'varandas')->textInput() ?>

  </div>
    
  <div class="col-md-6">
      
    <?= $form->field($model, 'valor')->widget(MaskMoney::classname()) ?>    

    <?= $form->field($model, 'situacao')->dropDownList([Imovel::TIPO_ALUGAR=>'Alugar', Imovel::TIPO_COMPRAR=>'Vender'], ['prompt'=>'Selecione']) ?>

    <?= $form->field($model, 'bairro')->dropdownlist(isset($bairros) ? $bairros : [],['prompt'=>'Selecione a cidade']) ?>

    <?= $form->field($model, 'condominio')->widget(MaskMoney::classname()) ?>    

    <?= $form->field($model, 'area_const')->textInput(['placeholder'=>'m²']) ?>

    <?= $form->field($model, 'quartos')->textInput() ?>

    <?= $form->field($model, 'suites')->textInput() ?>

    <?= $form->field($model, 'salas')->textInput() ?>

    
  </div>
    
</div>



    

    
    


    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Editar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        
        <?php 
                Modal::begin([
                            'header' => '<h3>Selecione as características para este imóvel</h3>',
                            'footer'=>'<button type="button" class="btn btn-success" data-dismiss="modal">Confirmar seleção</button>',
                            'toggleButton' => ['label' => '<span class="glyphicon glyphicon-list"></span>&nbsp;Características do Imóvel', 'class'=>'btn btn-info'],
                        ]);
        ?>
        <p>
            <div class="btn-group btn-group-xs" role="group" aria-label="Extra-small button group">
                <?= Html::button('<span class="glyphicon glyphicon-ok"></span>', ['class'=>'btn btn-primary btn-group btn-group-xs', 'role'=>'button', 'title'=>'Marcar todos', 'onclick'=>'js: $("input:checkbox").prop("checked", "checked");']) ?>
            </div>
            <div class="btn-group btn-group-xs" role="group" aria-label="Extra-small button group">
                <?= Html::button('<span class="glyphicon glyphicon-remove"></span>', ['class'=>'btn btn-danger btn-group btn-group-xs', 'role'=>'button', 'title'=>'Limpar seleção', 'onclick'=>'js: $("input:checkbox").removeAttr("checked");']) ?>
            </div>
        </p>
       <?php
                
                if(isset($caractSelected))
                    $caractImovel->caracteristica = $caractSelected;
            
                echo $form->field($caractImovel, 'caracteristica')->checkboxList($caracteristicas, ['class'=>'checkboxgroup'])->label("");

                Modal::end();

        ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>


