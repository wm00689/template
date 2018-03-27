<?php
use yii\helpers\Html;

$this->title = '添加角色';
$this->params['breadcrumbs'][] = $this->title;
$errors = Yii::$app->session->getFlash('errors');
?>
<div class="row">
    <form class="form-horizontal" role="form" method="post">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <?php if($errors):?>
                <div class="alert alert-danger fade in radius-bordered alert-shadowed">
                    <button class="close" data-dismiss="alert">
                        ×
                    </button>
                    <i class="fa-fw fa fa-times"></i>
                    <strong>Error!</strong>
                    <?= implode('<br>',$errors)?>
                </div>
            <?php endif;?>
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-lightred">
                    <span class="widget-caption">Horizontal Form</span>
                </div>
                <div class="widget-body">
                    <div id="horizontal-form">
                        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken()?>">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label no-padding-right">名称</label>
                            <div class="col-sm-10">
                                <input type="text" name="RoleForm[name]" class="form-control" id="name" placeholder="名称">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label no-padding-right">描述</label>
                            <div class="col-sm-10">
                                <input type="text" name="RoleForm[description]" class="form-control" id="mobile" placeholder="描述">

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">提交</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-lightred">
                    <span class="widget-caption">权限选择</span>
                </div>
                <div class="widget-body">
                    <div id="horizontal-form">
                        <div class="form-horizontal" >
                            <div class="form-group">
                                <!--<label for="description" class="col-sm-2 control-label no-padding-right">描述</label>-->
                                <?php foreach($permissions as $permission):?>
                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="<?= $permission->name?>" class="colored-success">
                                            <span class="text"><?= $permission->description?></span>
                                        </label>
                                    </div>
                                </div>
                                <?php endforeach;;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget">
                <div class="widget-header bordered-bottom bordered-lightred">
                    <span class="widget-caption">角色选择</span>
                </div>
                <div class="widget-body">
                    <div id="horizontal-form">
                        <div class="form-horizontal" >
                            <div class="form-group">
                                <!--<label for="description" class="col-sm-2 control-label no-padding-right">描述</label>-->
                                <?php foreach($roles as $role):?>
                                    <div class="col-sm-3">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="role[]" value="<?= $role->name?>" class="colored-success">
                                                <span class="text"><?= $role->description?></span>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach;;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
