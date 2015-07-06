<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;

use app\components\BuscaWidget;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Gemar Imóveis',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'A empresa', 'url' => ['/site/about']],
                    ['label' => 'Contato', 'url' => ['/site/contact']],
                    ['label' => 'Administração', 'url' => '', 'visible'=>!Yii::$app->user->isGuest,
                         'items'=>[
                            ['label' => 'Gerenciar Imóveis', 'url' => ['/imovel/']],
                            ['label' => 'Tipos de Imóvel', 'url' => ['/tipo-imovel/'], 'visible'=>(!Yii::$app->user->isGuest && Yii::$app->user->identity->perfil == User::MASTER)],
                            ['label' => 'Características', 'url' => ['/caracteristicas/'], 'visible'=>(!Yii::$app->user->isGuest && Yii::$app->user->identity->perfil == User::MASTER)],
                            ['label' => 'Gerenciar Usuários', 'url' => ['/user/'], 'visible'=>(!Yii::$app->user->isGuest && Yii::$app->user->identity->perfil == User::MASTER)],
                         ]
                    ],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->nome . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container" style="padding: 7px;">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>                        
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
