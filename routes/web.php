<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'HomeController@logout')->name('logout');

Route::get('chart', 'EvaluateChartController@index');

// User Routes
Route::group(['prefix' => 'user', 'middleware' => ['auth']], function(){
    Route::get('/edit', 'UserController@edit_get')->name('user.edit.get');

    Route::post('/edit', 'UserController@edit_post')->name('user.edit.post');
    Route::post('/edit/password', 'UserController@edit_password')->name('user.edit.password');
});

// Patient Routes
Route::group(['prefix' => 'patient', 'middleware' => ['auth']], function(){
    Route::get('/create', 'PatientController@create_get')->name('patient.create.get');
    Route::get('/make/table/evaluate/{id_quiz}', 'PatientController@make_table_evaluate');
    Route::get('/evaluate/{id_patient}/{id_quiz}', 'PatientController@evaluate_get')->name('patient.evaluate.get');
    Route::get('/search/{id_quiz}', 'PatientController@search_get')->name('patient.search.get');
    Route::get('/edit/{id}', 'PatientController@edit_get')->name('patient.edit.get');
    Route::get('/delete/{id}', 'PatientController@delete_get')->name('patient.delete.get');
    Route::get('/make/table/edit', 'PatientController@make_table_edit');
    Route::get('/all', 'PatientController@edit_all_get')->name('patient.edit.all.get');
    
    Route::post('/create', 'PatientController@create_post')->name('patient.create.post');
    Route::post('/evaluate', 'PatientController@evaluate_post')->name('patient.evaluate.post');
    Route::post('/edit', 'PatientController@edit_post')->name('patient.edit.post');
});

// Group Routes
Route::group(['prefix' => 'group', 'middleware' => ['auth']], function(){
    Route::get('/participants/{id}', 'GroupController@participants_get')->name('group.participants.get');
    Route::get('/view/{id}', 'GroupController@view_get')->name('group.view.get');
    Route::get('/delete/{id}', 'GroupController@delete_get')->name('group.delete.get');
    Route::get('/participants/search/{id_group}', 'GroupController@participants_search');
    Route::get('/participants/add/{id_group}', 'GroupController@search_participants_add');
    Route::get('/group/delete/{id}', 'GroupController@delete_participant')->name('group.delete.participant');

    Route::post('/add/user', 'GroupController@add_user')->name('group.add.user');
    Route::post('/edit', 'GroupController@edit')->name('group.edit.post');
    Route::post('/create', 'GroupController@create')->name('group.create.post');
});

// Quiz Routes
Route::group(['prefix' => 'quiz', 'middleware' => ['auth']], function(){
    Route::get('/view/{id}', 'QuizController@view_get')->name('quiz.view.get');
    Route::get('/edit/{id}', 'QuizController@edit_get')->name('quiz.edit.get');
    Route::get('/preview/{id}', 'QuizController@preview_get')->name('quiz.preview.get');
    Route::get('/apply/{id}', 'QuizController@quiz_apply')->name('quiz.apply.get');
    Route::get('/move/{id}/{id_group}', 'QuizController@move')->name('quiz.move');
    Route::get('/analyze/{id}', 'QuizController@analyze_get')->name('quiz.analyze.get');
    Route::get('/export/{id}', 'QuizController@export_get')->name('quiz.export.get');
    Route::get('/chart/{id}', 'QuizController@chart_get')->name('quiz.chart.get');
    Route::get('/exportcsv/{id}', 'QuizController@export_csv')->name('quiz.exportcsv.get');

    Route::post('/changestatus', 'QuizController@changestatus')->name('quiz.changestatus.post');
    Route::post('/create', 'QuizController@create')->name('quiz.create.post');
    Route::post('/edit', 'QuizController@edit_post')->name('quiz.edit.post');
    Route::post('/delete', 'QuizController@delete')->name('quiz.delete.post');
});

// Block Routes
Route::group(['prefix' => 'block', 'middleware' => ['auth']], function(){
    Route::get('/preview/{id}', 'BlockController@preview')->name('block.preview.view');
    Route::get('/view/{id}', 'BlockController@view_get')->name('block.view.get');
    Route::get('/delete/{id}', 'BlockController@delete')->name('block.delete');

    Route::post('/block/update/index', 'BlockController@update_index')->name('block.update.index');
    Route::post('/block/updatename', 'BlockController@update_name')->name('block.updatename.post');
    Route::post('/block/create', 'BlockController@create')->name('block.create.post');
});

// Question Routes
Route::group(['prefix' => 'question', 'middleware' => ['auth']], function(){
    Route::get('/create/{id}', 'QuestionController@create_get')->name('question.create.get');
    Route::get('/choices/{id}', 'QuestionController@question_choices')->name('question.choice.view');
    Route::get('/preview/{id}', 'QuestionController@preview')->name('question.preview');
    Route::get('/edit/{id}', 'QuestionController@edit_get')->name('question.edit.get');
    Route::get('/move/{id}', 'QuestionController@move')->name('question.move');
    Route::get('/delete/{id}', 'QuestionController@delete')->name('question.delete');
    Route::get('/deleteall/{id}', 'QuestionController@delete_all')->name('question.deleteall');
    Route::get('/update/index/{id_question}/{type}', 'QuestionController@update_index')->name('question.index.update');
    Route::get('/choices/{id}', 'QuestionController@question_choices')->name('question.choice.view');

    Route::post('/create', 'QuestionController@create_post')->name('question.create.post');
    Route::post('/edit', 'QuestionController@edit_post')->name('question.edit.post');

});

Auth::routes();
