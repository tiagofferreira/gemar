<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * FormBusca é o model por trás do form de busca 
 */
class FormBusca extends Model
{
    public $finalidade;
    public $tipo_imovel;
    public $cidade;
    public $bairro;
    public $valorMin;
    public $valorMax;
    public $quartos;
    public $vagas;
}