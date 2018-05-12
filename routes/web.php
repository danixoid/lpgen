<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'BuilderController@page')->name('page');

Route::get('/_token', function() {
    return response()->json([ '_token' => csrf_token() ]);
})->name('_token');

Route::group(['domain' => env('LPGEN_KZ','b-apps.kz')], function () {

    //
    Route::get('/home', 'HomeController@index')->name('home');


    Route::get('/upgrade/domain', 'HomeController@upgrade_domain')->name('upgrade.domain');


    // Управление доменом
    Route::resource('domain', 'DomainController');
    Route::resource('access', 'DomainAccessController');
    Route::resource('user', 'UserController');
    Route::resource('block','BlockController'); // Редактирование блоков

    // Блок-шаблон
    Route::get('/skeleton', 'BuilderController@skeleton')->name('builder.skeleton');
    Route::get('/content/{content}', 'BuilderController@content')->name('builder.content');

    // Главная страница PageBuilder
//    Route::get('/builder','BuilderController@index')->name('builder.index');

    // Загрузка файлов
    Route::post('/builder/iupload', 'BuilderController@iupload')->name('builder.iupload');

    // Предпросмотр страницы
    Route::get('/builder/preview/{domain_id}/{pagename}', 'BuilderController@preview')
        ->where('pagename', '(.*)')
        ->name('builder.preview.domain.get');

    // Получение по ИД
    Route::get('/builder/{id?}','BuilderController@show')->name('builder.show');

    // Сохранение мета данных
    Route::post('/builder/save', 'BuilderController@save')->name('builder.save');

    // Опубликовать страницы
    Route::get('/builder/publish/{domain_id}/{alias_id?}', 'BuilderController@publish')->name('builder.publish.get');

    // Сохранение черновика/проекта
    Route::post('/builder/project', 'BuilderController@project')->name('builder.project');

    // Получение блоков
    Route::post('/builder/blocks', 'BuilderController@blocks')->name('builder.blocks');

    // Получение метатагов по ИД домена
    Route::get('/builder/metas/{domain_id}','BuilderController@metas')->name('builder.metas');

});

// AJAX
Route::post('/post/{type}', 'HomeController@post')->name('post');

// Другие страницы
Route::get('/{page?}', 'BuilderController@page')
    ->where('page', '(.*)')
    ->name('page');

