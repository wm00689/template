<?php
/**
 * Created by PhpStorm.
 * User: feli
 * Date: 2018/1/28
 * Time: PM10:27
 */

return [
    [
        'id'=>'admin/user/permission',
        'text' => '权限管理',
        'icon' => 'icon-support',
        'children' => [
            [
                'id'=>'admin/user/permission/index',
                'text'=>'权限列表'
            ],
            [
                'id'=>'admin/user/permission/add',
                'text'=>'权限添加',
            ],
            [
                'id'=>'admin/user/permission/edit',
                'text'=>'权限编辑',
            ],
            [
                'id'=>'admin/user/permission/dell',
                'text'=>'权限删除',
            ],

        ],
    ],
    [
        'id'=>'admin/user/role',
        'text' => '角色管理',
        'icon' => 'icon-arrow-right',
        'children' => [
            [
                'id'=>'admin/user/role/index',
                'text'=>'角色列表'
            ],
            [
                'id'=>'admin/user/role/add',
                'text'=>'角色添加',
            ],
            [
                'id'=>'admin/user/role/edit',
                'text'=>'角色编辑',
            ],
            [
                'id'=>'admin/user/role/dell',
                'text'=>'角色删除',
            ],

        ],
    ],
    [
        'id'=>'admin/user/index',
        'text' => '用户管理',
        'icon' => 'icon-user',
        'children' => [
            [
                'id'=>'admin/user/index/index',
                'text'=>'用户列表'
            ],
            [
                'id'=>'admin/user/index/add',
                'text'=>'用户添加',
            ],
            [
                'id'=>'admin/user/index/edit',
                'text'=>'用户编辑',
            ],
            [
                'id'=>'admin/user/index/dell',
                'text'=>'用户删除',
            ],

        ],
    ],

];