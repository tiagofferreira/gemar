<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuários';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Criar Usuário', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nome',
            'email:email',
            ['attribute'=>'perfil', 'value'=>'perfilNome', 'filter'=>[User::MASTER=>'Gerente', User::ADMIN=>'Administrativo']],
            ['attribute'=>'ativo', 'value'=>'ativoNome', 'filter'=>[0=>'Inativo', 1=>'Ativo']],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
