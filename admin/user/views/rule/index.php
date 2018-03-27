<?php
use yii\helpers\Html;

$this->title = '权限规则';
$this->params['breadcrumbs'][] = $this->title;
?>
<h5 class="row-title"><?= Html::a('添加规则',['rule/create'])?></h5>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="well with-header  with-footer">
            <div class="header bg-blue">
                Simple Table With Hover
            </div>
            <table class="table table-hover">
                <thead class="bordered-darkorange">
                <tr>
                    <th>#</th>
                    <th>名称</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($rules as $key=>$rule):?>
                    <?php
                    $auth = Yii::$app->authManager;
                    $ps = $auth->getChildren($rule->name);
                    ?>
                    <tr>
                        <td><?= $key+1?></td>
                        <td><?= $rule->name?></td>
                        <td>
                            <?= Html::a('编辑', ['update','id'=>$rule->name], ['class' => 'btn btn-success']) ?>
                            <?= Html::a('删除', ['delete','id'=>$rule->name], [
                                'class' => 'btn btn-darkorange',
                                'data' => [
                                    'confirm' => '确认删除这条记录?',
                                    'method' => 'post',
                                ]
                            ])
                            ?>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>

            <div class="footer">

            </div>
        </div>

    </div>

</div>