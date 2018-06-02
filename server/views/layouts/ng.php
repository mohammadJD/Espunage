<?php

$content = file_get_contents(Yii::getAlias('@app') . '/../dist/index.html');

echo str_replace('base href="/"', 'base href="' . Yii::getAlias('@web') . '/"', $content);