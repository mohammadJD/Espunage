<?php

namespace app\modules\v1\controllers;

use Yii;

use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use app\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use app\components\MessageEventHandler;

class PageController extends Controller
{
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

    }

    public function actions()
    {
        return [];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();


        $behaviors['authenticator'] = ['class' => CompositeAuth::className(), 'authMethods' => [HttpBearerAuth::className(),],

        ];

        $behaviors['verbs'] = ['class' => \yii\filters\VerbFilter::className(), 'actions' => ['sse' => ['get'],],];

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = ['class' => \yii\filters\Cors::className(), 'cors' => ['Origin' => ['*'], 'Access-Control-Request-Method' => ['GET'], 'Access-Control-Request-Headers' => ['*'],],];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options', 'sse'];

        // setup access
        $behaviors['access'] = ['class' => AccessControl::className(), 'only' => ['sse'], //only be applied to
            'rules' => [['allow' => true, 'actions' => ['sse'], 'roles' => ['?'],],],];

        $behaviors['contentNegotiator'] = ['class' => \yii\filters\ContentNegotiator::className(), 'only' => ['sse'], 'formatParam' => '_format', 'formats' => ['text/event-stream' => \yii\web\Response::FORMAT_RAW,],];

        return $behaviors;
    }

    public function actionSse()
    {
        $sse = Yii::$app->sse;
        $sse->set('sleep_time', 0.1);
        $sse->set('allow_cors', true);
        $sse->addEventListener('message', new MessageEventHandler());

        $sse->start();
        $sse->flush();
    }


    public function actionOptions($id = null)
    {
        return "ok";
    }
}
