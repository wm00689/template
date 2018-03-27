<?php
/**
 * Created by PhpStorm.
 * User: feli
 * Date: 2018/3/27
 * Time: PM9:51
 */

namespace wm00689\admin\controllers;

use yii\web\Controller;

class RbacController extends Controller
{
    public function init()
    {
        parent::init();
        $this->layout = '@vendor/wm00689/template/admin/views/layouts/admin';
        $this->viewPath = '@vendor/wm00689/template/admin/views';
    }
}