<?php
/**
 * Created by PhpStorm.
 * User: wm
 * Date: 2016/3/27
 * Time: 17:58
 */

namespace wm00689\admin\user\controllers;


use backend\classes\common;


use wm00689\admin\user\models\PermissonForm;
use wm00689\admin\user\models\RoleForm;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

class RoleController extends Controller
{
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        return $this->render('index', ['roles' => $roles]);
    }

    public function actionAdd()
    {
       $permissions = PermissonForm::permissions();

        if (Yii::$app->request->isAjax) {

            $model = new RoleForm();

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                return $model->add_role_permissions();
            } else {
                $error = $model->getFirstErrors();
                return $this->renderPartial('add', ['permissions' => json_encode($permissions)]);
                return json_encode(['status' => 'n', 'info' => array_shift($error)]);
            }


        }


    }

    public function actionEdit()
    {
        $auth = Yii::$app->authManager;
        $role_id = Yii::$app->request->get('id') ? : Yii::$app->request->post('id');
        $items = array_keys($auth->getChildren($role_id));

        $editTreeByItems = PermissonForm::editTreeByItems($items);

        $auth = Yii::$app->authManager;

        $role = $auth->getRole($role_id);

        if (Yii::$app->request->isAjax) {

            $model = new RoleForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $role->name =$model->name;
                    $role->description =$model->description;
                    $auth->update($role_id,$role);
                    $permissions = explode(',', Yii::$app->request->post('ids'));
                    return $model->edit_role_permissions($auth,$role,$permissions);
                } else {
                    $error = $model->getFirstErrors();
                    return json_encode(['status' => 'n', 'info' => array_shift($error)]);
                }

            } else {
                return $this->renderPartial('edit', ['permissions' => json_encode($editTreeByItems), 'role' => $role]);
            }
        }
        return json_encode(['status' => 'n', 'info' => '请求错误']);

    }



    public function actionDell()
    {
        $role_name = Yii::$app->request->post('name');
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($role_name);

        if($auth->remove($role)){
            return json_encode(['status' => 'y', 'info' => '删除成功']);
        }
        return json_encode(['status' => 'n', 'info' => '请求错误']);
    }


    public function actionCreate()
    {
        $auth = Yii::$app->authManager;
        $model = new RoleForm();

        $permissions = $auth->getPermissions();

        $roles = $auth->getRoles();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //添加角色
            $role = $auth->createRole($model->name);
            $role->description = $model->description;
            $auth->add($role);

            //添加包含的权限
            $pers = Yii::$app->request->post('permission');
            if ($pers) {

                foreach ($pers as $per) {
                    $p = $auth->getPermission($per);
                    $auth->addChild($role, $p);

                }
            }

            //添加包含的角色
            $ros = Yii::$app->request->post('role');
            if ($ros) {
                foreach ($ros as $ro) {
                    $r = $auth->getRole($ro);

                    $auth->addChild($role, $r);

                }
            }
            return $this->redirect('index');
        } else {
            Yii::$app->session->setFlash('errors', $model->getFirstErrors());
        }
        return $this->render('create', ['permissions' => $permissions, 'roles' => $roles]);
    }

    public function actionUpdate()
    {
        $auth = Yii::$app->authManager;
        $model = new RoleForm();

        $role = $auth->getRole(Yii::$app->request->get('id'));
        $p = $auth->getChildren($role->name);
        $ps = array_keys($p);

        $permissions = $auth->getPermissions();

        $roles = $auth->getRoles();

        foreach (array_keys($roles) as $rol) {
            if ($rol == $role->name) {
                unset($roles[$rol]);
            }
        }

        $rs = array_keys($auth->getChildRoles($role->name));
        foreach ($rs as $key => $r) {
            if ($r == $role->name) {
                unset($rs[$key]);
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            //删除原有权限
            $auth->removeChildren($role);
            //修改角色
            $role->name = $model->name;
            $newRole = $auth->createRole($model->name);
            $newRole->description = $model->description;
            $auth->update($role->name, $newRole);


            //添加新权限
            $pers = Yii::$app->request->post('permission');
            foreach ($pers as $per) {
                $p = $auth->getPermission($per);
                $auth->addChild($role, $p);
            }


            //添加包含的角色
            $ros = Yii::$app->request->post('role');
            // var_dump($ros);exit;
            if ($ros) {
                foreach ($ros as $ro) {
                    $r = $auth->getRole($ro);

                    if (!$auth->hasChild($r, $role)) {

                        $auth->addChild($role, $r);
                    } else {
                        Yii::$app->session->setFlash('errors', ['错误' => '不能添加父级角色']);
                        return $this->render('update', ['model' => $role, 'permissions' => $permissions, 'ps' => $ps, 'roles' => $roles, 'rs' => $rs]);

                    }


                }
            }

            return $this->redirect('index');
        } else {
            Yii::$app->session->setFlash('errors', $model->getFirstErrors());
        }

        return $this->render('update', ['model' => $role, 'permissions' => $permissions, 'ps' => $ps, 'roles' => $roles, 'rs' => $rs]);
    }

    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($id);
        $auth->remove($role);
        return $this->redirect('index');

    }
}