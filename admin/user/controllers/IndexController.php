<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/8
 * Time: 13:18
 */

namespace wm00689\admin\user\controllers;

use backend\classes\common;

use wm00689\admin\user\models\AdminUser;
use wm00689\admin\user\models\PermissonForm;
use wm00689\admin\user\models\RoleForm;
use common\models\User;
use Yii;

use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class IndexController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $users = User::find()->where(['status'=>10])->all();
        return $this->render('index', ['users' => $users]);
    }

    public function actionAdd()
    {
        $permissions = PermissonForm::permissions();
        $auth = Yii::$app->authManager;

        $roles = $auth->getRoles();

        if (Yii::$app->request->isAjax) {
            if (Yii::$app->request->isPost) {
                $user = new AdminUser();

                $post = Yii::$app->request;

                if ($user->load($post->post()) && $u = $user->signup()) {

                    $user->add_roles($u->id, $post->post('name'));

                    $user->add_permissions($u->id, $post->post('permissions'));

                    return json_encode(['status' => 'y', 'info' => '添加用户成功']);

                } else {
                    $error = $user->getFirstErrors();
                    return json_encode(['status' => 'n', 'info' => array_shift($error)]);
                }
            } else {
                return $this->renderPartial('add', ['permissions' => json_encode($permissions), 'roles' => $roles]);
            }
        }
    }

    public function actionEdit()
    {
        $auth = Yii::$app->authManager;
        $user_id = Yii::$app->request->get('id')?: Yii::$app->request->post('id');
        $items = array_keys($auth->getPermissionsByUser($user_id));
        $editTreeByItems = PermissonForm::editTreeByItems($items);
        $roles = RoleForm::getMixedRolesByUserId($user_id);

        if (Yii::$app->request->isAjax) {

            $user = AdminUser::findOne($user_id);
            $request = Yii::$app->request;
            if ($post = $request->post()) {
                if ($user->load($post) && $user->validate() && $user->save()) {
                    $auth = Yii::$app->authManager;
                    $auth->revokeAll($user->id);
                    AdminUser::add_roles($user->id, $request->post('name'));
                    AdminUser::add_permissions($user->id, $request->post('permissions'));

                    return json_encode(['status' => 'y', 'info' => '编辑用户成功'.$request->post('permissions')]);
                } else {
                    $error = $user->getFirstErrors();
                    return json_encode(['status' => 'n', 'info' => array_shift($error)]);
                }

            } else {
                return $this->renderPartial('edit', ['permissions' => json_encode($editTreeByItems), 'user' => $user, 'roles' => $roles]);
            }
        }
        return json_encode(['status' => 'n', 'info' => '请求错误']);
    }


    public function actionDell()
    {
        $uid = Yii::$app->request->post('uid');
        $user = User::findOne($uid);

        $auth = Yii::$app->authManager;
        $auth->revokeAll($uid);
        common::dell($user);
        return json_encode(['status' => 'y', 'info' => '删除成功']);
    }
}