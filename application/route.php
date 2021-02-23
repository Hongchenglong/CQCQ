<?php

use think\Route;
// 缩短url路径
// Route::rule('login','index/login/index');
// Route::rule('column','index/column/index');
// Route::rule('user_setting','index/user/user_setting');
// Route::rule('user_password','index/user/user_password');
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
