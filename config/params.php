<?php

return [
    'adminEmail' => 'admin@example.com',
    'upFotos' =>Yii::$app->basePath . 'imagens/fotos/',
    'imgSite' =>Yii::$app->basePath . 'imagens/site/',
    'user.passwordResetTokenExpire' => 3600,
    'maskMoneyOptions' => [
        'prefix' => 'R$ ',
        'suffix' => '',
        //'affixesStay' => true,
        'thousands' => '.',
        'decimal' => ',',
        'precision' => 2, 
        //'allowZero' => false,
        //'allowNegative' => false,
    ]
];
