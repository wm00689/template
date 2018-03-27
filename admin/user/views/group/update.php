<?php
use yii\helpers\Html;

$this->title = '修改分组';
$this->params['breadcrumbs'][] = ['label' => '分组', 'url' => ['index']];
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
                                <input type="text" name="Group[name]" value="<?= $model->name?>" class="form-control" id="name" placeholder="名称">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label no-padding-right">类型</label>
                            <div class="col-sm-10">
                                <select name="Group[type]">
                                    <?php foreach(Yii::$app->params['group'] as $key => $group):?>
                                        <option value="<?= $key?>" <?php if($model->type==$key) echo 'selected'?>><?= $group?></option>
                                    <?php endforeach;?>
                                </select>
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

    </form>
</div>
