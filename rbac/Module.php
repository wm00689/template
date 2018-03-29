<?php
/**
 * Created by PhpStorm.
 * User: feli
 * Date: 2018/1/28
 * Time: PM10:48
 */

namespace wm00689\rbac;


use backend\classes\common;
use Yii;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\ForbiddenHttpException;

class Module extends \yii\base\Module
{

    public function init()
    {
        parent::init();
    }

    public function beforeAction($action)
    {
        if(\Yii::$app->user->isGuest){
            return header("Location: ".Url::to(['/']));
        }

        if(\Yii::$app->user->can(\Yii::$app->requestedAction->controller->getRoute())){
            if (!parent::beforeAction($action)) {
                return false;
            }
            return true;
        }else{
            //return true;
            throw new ForbiddenHttpException('你没有访问此页面的权限');
        }
    }

    public function getControllers($dir)
    {
        $m = require $dir.'/config/controllers.php';

        return $m;

    }

    public function getConfig($dir)
    {
        $c = require $dir.'/config/main.php';

        return $c;

    }





}