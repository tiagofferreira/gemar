<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use dosamigos\multiselect\MultiSelect;
?>

<div class="col-md-4">
    <div class="panel panel-danger">
      <div class="panel-heading"><span class="glyphicon glyphicon-search">&nbsp;</span>Buscar Imóvel</div>
      <div class="panel-body">

        <?= Html::beginForm() ?>
        <div class="row col-md-8">
            <div class="form-group">
                <?= Html::label('Finalidade', 'finalidade')  ?>
                <?= Html::dropdownlist('finalidade', '', [0=>'Alugar', 1=>'Comprar'], ['prompt'=>'Selecione', 'class'=>'form-control'])  ?>
            </div>          
        </div>
        
        <div class="row col-md-8">
            <div class="form-group">
                <?= Html::label('Tipo de imóvel', 'tipo_imovel')  ?>
                <?= MultiSelect::widget([
                        'data' => $tipoImovel,
                        'name' => 'tipo_imovel',
                        'options' => ['multiple'=>'multiple'],
                        'id'=>'tipo_imovel',
                        'clientOptions' => 
                            [
                                'numberDisplayed' => 0,
                                'maxHeight'=>200,
                                'buttonClass'=> 'form-control',
                                
                                
                            ], 
                    ]) ?>
            </div>  
        </div> 
          
        <div class="row">
            <div class="form-group col-md-11">
                <?= Html::label('Cidade', 'cidade')  ?>
                <?= Html::dropdownlist('cidade', '', $cidades, 
                                       ['prompt'=>'Selecione', 'class'=>'form-control ',
                                        'onchange'=>'
                                            $.get( "'.Url::toRoute('/bairro/get-bairros').'", { cidade: $(this).val(), type: "json" } )
                                                .done(function( data ) {     
                                                    $("#bairro").multiselect("dataprovider", data);
                                                }
                                            );
                                        '
                                       ])  ?>
            </div>  
        </div>  
        
        <div class="row">
            <div class="form-group col-md-7">
                <?= Html::label('Bairros', 'bairro')  ?>
                <?= MultiSelect::widget([
                        //'data' => [''=>''],
                        'name' => 'bairro',
                        'id' => 'bairro',
                        'options' => ['multiple'=>'multiple'],
                        'clientOptions' => 
                            [
                                'numberDisplayed' => 0,
                                'maxHeight'=>200,
                                'class'=>'form-control ',
                                
                            ], 
                    ]) ?>
            </div>          
        </div>    
          
        <div class="row">
            <div class="form-group col-md-4">
                <?= Html::label('Preço Mínimo', 'valorMin')  ?>
                <?= Html::textInput('valorMin', '',["class"=>"form-control form-group-sm"])  ?>
            </div>
            
             <div class="form-group col-md-4">
                <?= Html::label('Preço Máximo', 'valorMax')  ?>
                <?= Html::textInput('valorMax', '',["class"=>"form-control form-group-sm"])  ?>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-md-7">
                <?= Html::label('Quartos', 'quartos')  ?>
                <?= MultiSelect::widget([
                        'data' => ['1'=>'1', '2'=>'2', '3'=>'3', '4+'=>'4 ou mais'],
                        'name' => 'quartos',
                        'id' => 'quartos',
                        'options' => ['multiple'=>'multiple'],
                        'clientOptions' => 
                            [
                                'numberDisplayed' => 0,
                                'maxHeight'=>100,
                                
                            ], 
                    ]) ?>
            </div>          
        </div>      
          
        <div class="row">
            <div class="form-group col-md-7">
                <?= Html::label('Vagas', 'vagas')  ?>
                <?= MultiSelect::widget([
                        'data' => ['1'=>'1', '2'=>'2', '3'=>'3', '4+'=>'4 ou mais'],
                        'name' => 'vagas',
                        'id' => 'vagas',
                        'options' => ['multiple'=>'multiple'],
                        'clientOptions' => 
                            [
                                'numberDisplayed' => 0,
                                'maxHeight'=>100,
                                
                            ], 
                    ]) ?>
            </div>          
        </div> 
        
        <?= Html::endForm() ?>  
          
      </div>
    </div>
</div>
