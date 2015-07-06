<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use dosamigos\multiselect\MultiSelect;
    use kartik\money\MaskMoney;
    use  yii\web\Session;

    $session = Yii::$app->session;

    //Para popular os campos de múltiplas seleções
    if(!isset($session['dadosBusca']['bairro']))
       $bairros = [];
    else
        $bairros = $session['dadosBusca']['bairro'];

    if(!isset($session['dadosBusca']['tipo_imovel']))
        $tipos = [];
    else
        $tipos = $session['dadosBusca']['tipo_imovel'];

   if(!isset($session['dadosBusca']['quartos']))
        $quartos = [];
    else
        $quartos = $session['dadosBusca']['quartos'];

    if(!isset($session['dadosBusca']['vagas']))
        $vagas = [];
    else
        $vagas = $session['dadosBusca']['vagas'];

?>

    <div class="panel panel-primary" style=" border-color: #003366;">
      <div class="panel-heading" style="background-color: #003366;"><span class="glyphicon glyphicon-search">&nbsp;</span>Buscar Imóvel</div>
      <div class="panel-body">

        <?= Html::beginForm(['/busca-imovel/buscar'], 'get') ?>

          <div class="col-md-6">
            <div class="form-group">
                <?= Html::label('Finalidade', 'finalidade')  ?>
                <?= Html::dropdownlist('finalidade', $session['dadosBusca']['finalidade'], [0=>'Alugar', 1=>'Comprar'], ['prompt'=>'Selecione', 'class'=>'form-control input-sm'])  ?>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
                <?= Html::label('Tipo de imóvel', 'tipo_imovel')  ?><br>
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
                                'enableCaseInsensitiveFiltering' => true,
                                'filterPlaceholder' => 'Buscar',
                                'buttonClass'=>'form-control input-sm',
                                'nonSelectedText'=>'Selecione'


                            ],
                    ]) ?>
              </div>
            </div>

              <div class="form-group">
                <?= Html::label('Cidade', 'cidade')  ?>
                <?= Html::dropdownlist('cidade', $session['dadosBusca']['cidade'], $cidades,
                                       ['id'=>'cidade', 'prompt'=>'Selecione', 'class'=>'form-control input-sm',
                                        'onchange'=>'
                                            $.get( "'.Url::toRoute('/bairro/get-bairros').'", { cidade: $(this).val(), type: "json" } )
                                                .done(function( data ) {
                                                    $("#bairro").multiselect("dataprovider", data);
                                                }
                                            );
                                        '
                                       ])  ?>
              </div>

              <div class="form-group">
                  <?= Html::label('Bairros', 'bairro')  ?> <br>
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
                                  'enableCaseInsensitiveFiltering' => true,
                                  'filterPlaceholder' => 'Buscar',
                                  'buttonClass'=>'form-control input-sm'

                              ],
                      ]) ?>
              </div>

              <div class="col-md-5">
              <div class="form-group">

                <?= Html::label('Preço Mínimo', 'valorMin')  ?>
                <?=
                     MaskMoney::widget([
                        'name' => 'valorMin',
                        'id' => 'valorMin',
                        'value' => $session['dadosBusca']['valorMin'],
                        'options' => ['class'=>'form-control input-sm']
                    ]);
                ?>
              </div>
            </div>

              <div class="col-md-5">
                <div class="form-group">
                <?= Html::label('Preço Máximo', 'valorMax')  ?>
                <?=
                     MaskMoney::widget([
                        'name' => 'valorMax',
                        'id' => 'valorMax',
                         'value' => $session['dadosBusca']['valorMax'],
                        'options' => ['class'=>'form-control input-sm']
                    ]);
                ?>
              </div>
            </div>

              <div class="col-md-5">
                <div class="form-group">
                <?= Html::label('Quartos', 'quartos')  ?>
                <?= MultiSelect::widget([
                        'data' => ['1'=>'1', '2'=>'2', '3'=>'3', '4+'=>'4 ou mais'],
                        'name' => 'quartos',
                        'id' => 'quartos',
                        'options' => ['multiple'=>'multiple',
                                      'onChange'=> 'if($("#quartos").val() != null && $("#quartos").val().indexOf("4+") >= 0)
                                                    {
                                                        $("#quartos").multiselect("deselect", ["1", "2", "3"]);
                                                    }'
                                     ],
                        'clientOptions' =>
                            [
                                'numberDisplayed' => 0,
                                'buttonClass'=>'form-control input-sm',
                                'nonSelectedText'=>'Selecione'

                            ],
                    ]) ?>

                </div>
              </div>

                <div class="col-md-5">
                  <div class="form-group">
                <?= Html::label('Vagas', 'vagas')  ?>
                <?= MultiSelect::widget([
                        'data' => ['1'=>'1', '2'=>'2', '3'=>'3', '4+'=>'4 ou mais'],
                        'name' => 'vagas',
                        'id' => 'vagas',
                        'options' => ['multiple'=>'multiple',
                                      'onChange'=> 'if($("#vagas").val() != null && $("#vagas").val().indexOf("4+") >= 0)
                                                    {
                                                        $("#vagas").multiselect("deselect", ["1", "2", "3"]);
                                                    }'
                                     ],
                        'clientOptions' =>
                            [
                                'numberDisplayed' => 0,
                                'buttonClass'=>'form-control input-sm',
                                'nonSelectedText'=>'Selecione'


                            ],
                    ]) ?>
                  </div>
              </div>

              <div class="form-group">
                <?= Html::submitButton('Buscar Imóveis', ['class' => 'btn btn-default', 'style'=>'background-color: lightgrey;']) ?>
              </div>
        <?= Html::endForm() ?>

      </div>
    </div>

<?php $this->registerJs("
    $(document).ready(function() {

        if($('#cidade').val() != '')
        {
             $.get( '".Url::toRoute('/bairro/get-bairros')."', { cidade: $('#cidade').val(), type: 'json' } )
                                                .done(function( data ) {
                                                    $('#bairro').multiselect('dataprovider', data);

                                                   $('#bairro').multiselect('select', ['".implode('\',\'', $bairros)."']);

                                                }
                                            );
        }

        $('#tipo_imovel').multiselect('select', ['".implode('\',\'', $tipos)."']);
        $('#quartos').multiselect('select', ['".implode('\',\'', $quartos)."']);
        $('#vagas').multiselect('select', ['".implode('\',\'', $vagas)."']);

    });"); ?>
