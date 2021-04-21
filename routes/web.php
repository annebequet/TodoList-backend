<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get(
    '/',
    [
        'uses' => 'MainController@home',
        'as'   => 'main-home'
    ]
);

$router->get(
    '/categories',
    [
        'uses' => 'CategoryController@list',
        'as'   => 'category-list'
    ]
);

$router->get(
    '/categories/{id:[1-9][0-9]*}',
    [
        'uses' => 'CategoryController@item',
        'as'   => 'category-item'
    ]
);

$router->get(
    '/tasks',
    [
        'uses' => 'TaskController@list',
        'as'   => 'task-list'
    ]
);

$router->post(
    '/tasks',
    [
        'uses' => 'TaskController@add',
        'as'   => 'task-create'
    ]
);

$router->put(
    '/tasks/{id}',
    [
        'uses' => 'TaskController@overwrite',
        'as'   => 'task-overwrite'
    ]
);

$router->patch(
    '/tasks/{id}',
    [
        'uses' => 'TaskController@update',
        'as'   => 'task-update'
    ]
);
