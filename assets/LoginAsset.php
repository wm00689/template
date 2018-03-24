<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/24
 * Time: 13:37
 */

namespace wm00689\template\assets;


use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $baseUrl = '@static';

    public $css = [
        'plugins/validform/css/style.css',
        'global/plugins/select2/css/select2.min.css',
        'global/plugins/select2/css/select2-bootstrap.min.css',
        'global/css/components-md.min.css',
        'global/css/plugins-md.min.css',
        'pages/css/login.min.css',
    ];

    public $depends = [
        'c\themes\metronic\assets\Layout3Asset'
    ];
}