<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// use think\Request;

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});
// Route::get('get', function (Request $request) {
//     return $request;
// });
Route::get('allProducts', 'index/allProducts');
Route::get('get', 'index/get');
Route::post('get', 'index/get');
Route::post('image', 'index/image');
Route::post('post', 'index/post');
Route::get('post', 'index/post');
Route::delete('delete', 'index/delete');
// Route::get('delete', 'index/delete');
Route::put('put', 'index/put');

Route::get('hello/:name', 'index/hello');

return [

];
