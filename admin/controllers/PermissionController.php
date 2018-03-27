<?php
/**
 * Created by PhpStorm.
 * User: wm
 * Date: 2016/3/27
 * Time: 17:58
 */

namespace wm00689\admin\controllers;


use backend\classes\common;
use wm00689\admin\models\PermissonForm;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

class PermissionController extends Controller
{
    public function actionIndex()
    {
        $permissions = common::allControllers();

        foreach ($permissions as $key=> $permission){
            $c[] = [
                'id'=>  $key,
                'text'=> $permission['text'],
                'state'=>['opened'=>true],
                'children'=>$permission['children']

            ];
        }

        $root = [
            'id'=>'root',
            'text'=>'root',
            'state'=>['opened'=>true],
            'children'=>$c
        ];

        //VarDumper::dump($permissions,10,true);exit;


        return $this->render('index',['permissions'=>json_encode($root)]);
    }

    public function actionAdd()
    {
        $ids = explode(',',Yii::$app->request->post('ids'));
        $permissions_arrays = common::allControllers();

        $this->add_permissions($permissions_arrays,$ids);

        return json_encode(['status'=>'y']);
    }

    private function add_permissions($permissions_arrays,$ids)
    {
        $auth = Yii::$app->authManager;

        foreach ($permissions_arrays as $permissions_array){

                if(in_array($permissions_array['id'],$ids)){
                    $permission = $auth->createPermission($permissions_array['id']);
                    $permission->description = $permissions_array['text'];
                    if(($auth->getPermission($permissions_array['id']))){
                        $auth->update($permissions_array['id'],$permission);
                    }else{
                        $auth->add($permission);
                    }
                }

            if(isset($permissions_array['children'])){

                $this->add_permissions($permissions_array['children'],$ids);
            }
        }


    }



    public function actionCreate()
    {
        $auth = Yii::$app->authManager;
        $model = new PermissonForm();

        $permissions = $auth->getPermissions();
        $rules = $auth->getRules();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            //dd($model);
            //添加当前权限
            $permission = $auth->createPermission($model->name);
            $permission->description = $model->description;
            //添加规则
            $permission->ruleName = $model->rule_name;
            $auth->add($permission);

            //添加包含的权限
            $post_permissions = Yii::$app->request->post('permission');
            if($post_permissions){
                foreach($post_permissions as $post_permission) {
                    $child = $auth->getPermission($post_permission);
                    $auth->addChild($permission,$child);
                }
            }



            return $this->redirect('index');
        }else{
            Yii::$app->session->setFlash('errors',$model->getFirstErrors());
        }
        return $this->render('create',['model'=>$model,'permissions'=>$permissions,'rules'=>$rules]);
    }

    public function actionUpdate()
    {
        $permission = new PermissonForm();
        $auth = Yii::$app->authManager;
        $model = $auth->getPermission(Yii::$app->request->get('id'));
        $old_name = $model->name;

        $permissions = $auth->getPermissions();
        $rules = $auth->getRules();

        $have_rule = $model->ruleName;
        $have_permissions = array_keys($auth->getChildren($model->name));

        if($permission->load(Yii::$app->request->post()) && $permission->validate()){

            $auth->removeChildren($model);

            $model->name = $permission->name;
            $model->description = $permission->description;
            $model->ruleName = $permission->rule_name;
            $auth->update($old_name,$model);

            //添加包含的权限
            $post_permissions = Yii::$app->request->post('permission');
            if($post_permissions){

                foreach($post_permissions as $post_permission) {
                    $child = $auth->getPermission($post_permission);
                    if($auth->canAddChild($permission,$child)){

                        $auth->addChild($permission,$child);
                    }else{
                        Yii::$app->session->setFlash('errors',['a'=>'不能包含本身权限']);
                        return $this->render('update',['model'=>$model,'permissions'=>$permissions,'rules'=>$rules,'have_permissions'=>$have_permissions,'have_rule'=>$have_rule]);

                    }
                }
            }


            return $this->redirect('index');
        }else{
            Yii::$app->session->setFlash('errors',$permission->getFirstErrors());
        }
        return $this->render('update',['model'=>$model,'permissions'=>$permissions,'rules'=>$rules,'have_permissions'=>$have_permissions,'have_rule'=>$have_rule]);
    }


    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($id);
        $auth->remove($permission);
        return $this->redirect('index');
    }
}