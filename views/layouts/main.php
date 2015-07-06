<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

use app\components\BuscaWidget;
use app\models\User;

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

<!-- Adicionando a imagem de cabeçalho com bootstrap -->
<header>
    <div class="row">
        <div class="col-md-3">
        <?= Html::img("imagens/site/logoGemar.gif", ['class'=>'img-responsive', 'style'=>'position: relative; margin: 5px 5px;']); ?>
        </div>
        <div class="col-md-4 col-md-offset-4">
        <h3><p></p><span class="glyphicon glyphicon-earphone text-danger">&nbsp;Telfax: (31) 2516-8288</span></p>
            <p></p><span class="glyphicon glyphicon-envelope text-danger">&nbsp;<a class="text-danger" href="mailto:gemarimobiliaria@gmail.com" target="_blank">gemarimobiliaria@gmail.com</a></span></p>
            </h3>
        </div>
    </div>
</header>

<body>

<?php $this->beginBody() ?>
    <div class="wrap" style="background-image: url(imagens/site/background.jpg);
  background-repeat: no-repeat;
  background-size: 100% 100%">
        <?php
            NavBar::begin([
                'brandLabel' => 'Gemar Imóveis',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'A empresa', 'url' => ['/site/about']],
                    ['label' => 'Links', 'url' => ['/site/links']],
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

        <div class="container-fluid">
            <div class="col-md-4">
                <!-- Form de busca -->
                <?= BuscaWidget::widget() ?>
            </div>
        
            <div class="col-md-8" style="background-color: transparent; height: 100%; margin: 0; padding: 0;">

                <?= $content ?>
            </div>
        </div>
    </div>

    <footer class="footer" style="background-color: #003366; padding-top: 10px; height: auto;">
            <div class="row" style="font-weight: bold;">
                <div class="col-md-2 text-muted">&copy; GEMAR Imóveis  <?= date('Y') ?></div>
                <div class="col-md-8 col-md-offset-2  text-muted">
                    <span class="text-muted">Avenida Abílio Machado, 1.264 - Sl. 610 - B. Alípio de Melo, Belo Horizonte/MG - CEP: 30.820-272</span>
                    <p class="text-muted">Telfax: (31) 2516-8288 - E-mail: gemarimobiliaria@gmail.com</p>
                </div>
            </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
