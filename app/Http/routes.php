<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'Home\HomeController@index');
    Route::get('login', 'Home\HomeController@login');
    Route::get('/home', 'Home\HomeController@index');
    Route::get('resetAdmin', 'Home\HomeController@resetAdmin');
    Route::get('roles', 'Home\HomeController@roles');
    Route::get('shutdown', 'Home\HomeController@shutdown');
    Route::get('/install', 'InstallController@install');
    Route::get('/admin', 'Admin\HomeController@index');
    Route::post('setEnv', 'InstallController@setEnv');
    Route::post('doInstall', 'InstallController@doInstall');
    Route::get('vrcode', 'Home\HomeController@vrcode');
    Route::group(['prefix' => 'home', 'middleware' => ['authUser', 'setting']], function() {
        //显示部分路由
        Route::get('paner', 'Home\HomeController@paner');
        Route::get('project-edit', 'Home\HomeController@editShow');
        Route::get('page-show', 'Home\HomeController@pageShow');
        Route::get('page-edit', 'Home\HomeController@pageDetail');
        Route::get('page-add', 'Home\HomeController@pageAdd');
        //用户相关操作接口
        Route::get('logout', 'Home\UserController@logout');
        Route::post('update-password', 'Home\UserController@updatePassword');
        //项目相关操作接口
        Route::get('project-list', 'Home\ProjectController@projectList');
        Route::post('project-doEdit', 'Home\ProjectController@edit');
        Route::post('addProject', 'Home\ProjectController@add');
        Route::get('member-list', 'Home\ProjectController@showMemberList');
        Route::post('edit_Private', 'Home\ProjectController@editMemberPriv');
        Route::get('delete-privalidge', 'Home\ProjectController@deletePriv');
        Route::post('add-member', 'Home\ProjectController@addMember');
        Route::get('join-list', 'Home\ProjectController@joinList');
        //文件夹相关操作接口
        Route::post('folder-add', 'Home\FolderController@add');
        Route::get('folder-list', 'Home\FolderController@folderList');
        Route::post('folder-edit', 'Home\FolderController@edit');
        Route::post('folder-delete', 'Home\FolderController@delete');
        Route::get('export-word', 'Home\FolderController@exportWord');
        //文章相关操作接口
        Route::post('add-page', 'Home\PageController@add');
        Route::get('page-detail', 'Home\PageController@pageDetail');
        Route::post('edit-page', 'Home\PageController@edit');
        Route::get('delete-page', 'Home\PageController@delete');
        Route::get('search-page', 'Home\PageController@searchPage');
        //运行接口测试
        Route::get('showApiTest', 'Home\ApiController@page');
        Route::post('run-test', 'Home\ApiController@test');
        //模板相关接口
        Route::get('tpl-detail', 'TemplateController@getTplDetail');
    }
    );
    Route::group(['prefix' => 'auth', 'middleware' => ['setting']], function () {
        Route::get('regist', 'Home\HomeController@regist');
        Route::post('doRegist', 'Home\UserController@doRegist');
        Route::post('doLogin', 'Home\UserController@doLogin');
        Route::post('admin/doLogin', 'Admin\AdminController@doLogin');
    });
    Route::group(['prefix' => 'admin', 'middleware' => ['authAdmin']], function() {
        //页面显示部分
        Route::get('paner', 'Admin\HomeController@memberList');
        Route::get('psw-edit', 'Admin\HomeController@pswEdit');
        Route::get('project-list', 'Admin\HomeController@projectList');
        Route::get('sys-setting', 'Admin\HomeController@sysSetting');
        //管理员操作部分
        Route::get('logout', 'Admin\AdminController@logout');
        Route::post('updatePsw', 'Admin\AdminController@updatePassword');
        //用户管理部分
        Route::get('user-list', 'Admin\UserController@userList');
        Route::get('reset', 'Admin\UserController@reset');
        Route::get('toggle', 'Admin\UserController@toggle');
        //系统操作部分
        Route::get('show-function', 'Admin\SystemController@showFunction');
        Route::get('set-function', 'Admin\SystemController@setFunction');
        //项目操作部分
        Route::get('project-listInf', 'Admin\ProjectController@projectList');
        Route::get('delete-project', 'Admin\ProjectController@delete');
        Route::get('member-list', 'Admin\ProjectController@memberList');
        Route::post('add-member', 'Admin\ProjectController@addMember');
        Route::post('edit-privalidge', 'Admin\ProjectController@editPrivalidge');
        Route::post('transfer-project', 'Admin\ProjectController@transferProject');
       //模板操作
        Route::get('template-list', 'Admin\HomeController@template');
        Route::get('tpl-add', 'Admin\HomeController@tplAdd');
        Route::get('tpl-edit', 'Admin\HomeController@tplEdit');
        Route::get('tpl-list', 'TemplateController@tplList');
        Route::post('add-tpl', 'TemplateController@addTpl');
        Route::post('edit-tpl', 'TemplateController@editTpl');
        Route::get('del-tpl', 'TemplateController@delTpl');
        //邮箱服务配置
        Route::get('email-config', 'Admin\HomeController@emailConfig');
        Route::post('update-email', 'Admin\SystemController@updateEmail');
    }
    );
});
