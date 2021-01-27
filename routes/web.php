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

// Get controllers
Route::get('/', 'ProjectController@index');
Route::get('/project/{project}/sprints/dashboard', 'SprintController@index')->name('sprint.dashboard');
Route::get('/project/{project}/sprints/{sprint}', 'SprintController@show')->name('sprints.show');
Route::get('/project/{project}/sprints/{sprint}/retrospective', 'RetrospectiveController@index')->name('retrospectives.index');
Route::get('/project/{project}/dashboard', 'ProjectController@show')->name('project.dashboard');
Route::get('/project/{project}/members', 'ProjectTeamController@show')->name('project.team');
Route::get('/project/{project}/backlog', 'BacklogItemController@show')->name('project.backlog');
Route::post('/project/{project}/members', 'ProjectTeamController@store')->name('member.store');
Route::get('/profile/{profile}', 'UserController@show')->name('profile.show');

// Resource controllers
Route::resources(
    [
        'project' => 'ProjectController',
        'members' => "ProjectTeamController",
        'backlogItem' => 'backlogItemController',
        'profile' => 'UserController',
        'sprint' => 'SprintController',
        'admin' => 'AdminController',
        'retrospective' => 'RetrospectiveController'
    ]
);
