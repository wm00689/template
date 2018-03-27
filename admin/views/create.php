<?php
use yii\helpers\Html;

$this->title = '添加用户';
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
                        <!-- <div class="form-group">
                             <label for="username" class="col-sm-2 control-label no-padding-right">用户名</label>
                             <div class="col-sm-10">
                                 <input type="text" name="User[username]" class="form-control" id="username" placeholder="用户名">
                                 <p class="help-block">Example block-level help text here.</p>
                             </div>
                         </div>-->
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label no-padding-right">姓名</label>
                            <div class="col-sm-10">
                                <input type="text" name="User[name]" value="<?= $model->name?>" class="form-control" id="name" placeholder="姓名">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label no-padding-right">性别</label>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label>
                                        <input name="User[sex]" value="男" type="radio" <?php if($model->sex=='男') echo 'checked'?> >
                                        <span class="text">男 </span>
                                    </label>
                                    <label>
                                        <input name="User[sex]" value="女" type="radio" <?php if($model->sex=='女') echo 'checked'?> >
                                        <span class="text">女 </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="col-sm-2 control-label no-padding-right">手机</label>
                            <div class="col-sm-10">
                                <input type="text" name="User[mobile]" value="<?= $model->mobile?>" class="form-control" id="mobile" placeholder="手机">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label no-padding-right">邮箱</label>
                            <div class="col-sm-10">
                                <input type="email" name="User[email]" value="<?= $model->email?>" class="form-control" id="email" placeholder="Email">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="role" class="col-sm-2 control-label no-padding-right">分组</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="User[group]" >
                                    <option value="">选择分组</option>
                                    <?php foreach($groups as  $group):?>
                                        <option value="<?= $group->id?>" <?php if($model->group == $group->id) echo 'selected'?>><?= $group->name?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label no-padding-right">密码</label>
                            <div class="col-sm-10">
                                <input type="password" name="User[password]" class="form-control" id="password" placeholder="密码">
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