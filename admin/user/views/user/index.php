<?php
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>


<p>
    <?= Html::a('添加用户', ['/rbac/user/create'], ['class' => 'btn btn-blue']) ?>
    <?= Html::a('缓存用户', ['/rbac/user/cache-all'], ['class' => 'btn btn-warning']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'layout' => "\n{items}<br>\n<div style='float: right'>{pager}</div>\n{summary}",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => 'yii\grid\CheckboxColumn',
            'checkboxOptions' => [
                'style' => 'opacity: 1;
                        position: static;
                        left: -9999px;
                        z-index: 12;
                        width: 18px;
                        height: 18px;
                        cursor: pointer; '
            ],
            'header' => '<input type="checkbox" id="s"   class="select-on-check-all" name="selection_all" value="1" style="opacity: 1;
                        position: static;
                        left: -9999px;
                        z-index: 12;
                        width: 18px;
                        height: 18px;
                        cursor: pointer; ">'

        ],

        'name',
        'username',
        'mobile',
        'email',
        'role',
        [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['style' => 'width:120px'],
            'template' => '{update} {delete}',
            'header' => '操作',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('编辑 ', $url, [
                        'class' => 'btn btn-sm btn-azure',
                        'style' => 'float:left'
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('删除', $url, [
                        'title' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                        'class' => 'btn btn-sm btn-danger',
                        'style' => 'float:left;margin-left:3px'
                    ]);
                }
            ]
        ],
    ],
]); ?>

<!-- <div class="footer">

 </div>
</div>

</div>

</div>-->