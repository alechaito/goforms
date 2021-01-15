<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/searchuser', function () {
    return view('searchuser');
})->name('searchuser.view')->middleware('auth');


Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/logout', 'HomeController@logout')->name('logout')->middleware('auth');

Route::get('/search-allusers', 'HomeController@search_allusers');
Route::get('/back', 'HomeController@back')->name('redirect.back');
//--------------------------------------
// Teacher Routes
//------------------------------------

#Route::get('/teacher/edit/{id}', 'TeacherController@edit')->name('teacher.edit.view')->middleware('auth');
#Route::get('/teacher/delete/{id}', 'TeacherController@delete')->name('teacher.delete')->middleware('auth');

#Route::post('/teacher/edit', 'TeacherController@edit_post')->name('teacher.edit.post');
#Route::post('/teacher/edit/password', 'TeacherController@edit_password')->name('teacher.edit.password');

Route::group(['prefix' => 'user', 'middleware' => ['auth']], function(){
    // get routes
    Route::get('/edit', 'UserController@edit_get')->name('user.edit.get');

    // post routes
    Route::post('/edit', 'UserController@edit_post')->name('user.edit.post');
    Route::post('/edit/password', 'UserController@edit_password')->name('user.edit.password');
});

// Patient Routes
Route::group(['prefix' => 'patient', 'middleware' => ['auth']], function(){
    // get routes
    Route::get('/create', 'PatientController@create_get')->name('patient.create.get');
    Route::get('/make/table/evaluate/{id_quiz}', 'PatientController@make_table_evaluate');
    Route::get('/evaluate/{id_patient}/{id_quiz}', 'PatientController@evaluate_get')->name('patient.evaluate.get');
    Route::get('/search/{id_quiz}', 'PatientController@search_get')->name('patient.search.get');
    Route::get('/edit/{id}', 'PatientController@edit_get')->name('patient.edit.get');
    Route::get('/delete/{id}', 'PatientController@delete_get')->name('patient.delete.get');
    Route::get('/make/table/edit', 'PatientController@make_table_edit');
    Route::get('/all', 'PatientController@edit_all_get')->name('patient.edit.all.get');
    
    
    // post routes
    Route::post('/create', 'PatientController@create_post')->name('patient.create.post');
    Route::post('/evaluate', 'PatientController@evaluate_post')->name('patient.evaluate.post');
    Route::post('/edit', 'PatientController@edit_post')->name('patient.edit.post');
});


// Group Routes
Route::group(['prefix' => 'group', 'middleware' => ['auth']], function(){
    //get routes
    Route::get('/participants/{id}', 'GroupController@participants_get')->name('group.participants.get')->middleware('auth');
    Route::get('/view/{id}', 'GroupController@view_get')->name('group.view.get')->middleware('auth');
    Route::get('/delete/{id}', 'GroupController@delete_get')->name('group.delete.get')->middleware('auth');
    Route::get('/participants/search/{id_group}', 'GroupController@participants_search');
    Route::get('/participants/add/{id_group}', 'GroupController@search_participants_add');

    //post routes
    Route::post('/add/user', 'GroupController@add_user')->name('group.add.user');
});

//Route::get('/group/view/{id}', 'GroupController@preview')->name('group.preview.view')->middleware('auth');
Route::get('/search-user', 'GroupController@search_user');
Route::get('/search-participants/add/{id_group}', 'GroupController@search_participants_add');
#Route::get('/search-participants/{id_group}', 'GroupController@search_participants');
Route::get('/group/insert/participant/{id_group}/{id_participant}/{id_role}', 'GroupController@insert_participant')->name('group.insert.participant');
Route::get('/group/delete/participant/{id}', 'GroupController@delete_participant')->name('group.delete.participant');
//Route::get('/group/delete/{id}', 'GroupController@delete')->name('group.delete')->middleware('auth');
Route::get('/group/deleteall/{ids}', 'GroupController@delete_all')->name('group.deleteall')->middleware('auth');


Route::post('/group/insert/participant', 'GroupController@insert_participant_post')->name('group.insert.participant.post');
Route::post('/group/create', 'GroupController@create')->name('group.create.post');
Route::post('/group/edit', 'GroupController@edit')->name('group.edit.post');
Route::post('/group/add/user', 'GroupController@add_user')->name('group.add.user');
//--------------------------------------
// Quiz Routes
//------------------------------------
#view quiz and can edit them
Route::prefix('quiz')->group(function () {
    Route::get('/view/{id}', 'QuizController@view_get')->name('quiz.view.get')->middleware('auth');
    Route::get('/edit/{id}', 'QuizController@edit_get')->name('quiz.edit.get')->middleware('auth');

    #preview form just only show
    Route::get('/preview/{id}', 'QuizController@preview_get')->name('quiz.preview.get')->middleware('auth');
    Route::get('/apply/{id}', 'QuizController@quiz_apply')->name('quiz.apply.get')->middleware('auth');
    Route::get('/move/{id}/{id_group}', 'QuizController@move')->name('quiz.move')->middleware('auth');
    #generate and process data from quiz
    Route::get('/analyze/{id}', 'QuizController@analyze_get')->name('quiz.analyze.get')->middleware('auth');


    Route::post('/changestatus', 'QuizController@changestatus')->name('quiz.changestatus.post')->middleware('auth');
    Route::post('/create', 'QuizController@create')->name('quiz.create.post');
    Route::post('edit', 'QuizController@edit_post')->name('quiz.edit.post');
    Route::post('delete', 'QuizController@delete')->name('quiz.delete.post');
});
//Route::post('/quiz/preview', 'QuizController@preview')->name('quiz.preview.post')->middleware('auth');
//--------------------------------------
// Block Routes
//------------------------------------
Route::prefix('block')->group(function () {
    //get routes
    Route::get('/preview/{id}', 'BlockController@preview')->name('block.preview.view')->middleware('auth');
    Route::get('/view/{id}', 'BlockController@view_get')->name('block.view.get')->middleware('auth');


    //post routes
});
//Route::get('/block/preview/{id}', 'BlockController@preview')->name('block.preview.view')->middleware('auth');
//Route::get('/block/preview/{id_block}/{id_question}', 'BlockController@preview_question')->name('block.preview.question.view')->middleware('auth');
//Route::get('/block/edit/{id}', 'BlockController@edit')->name('block.edit.view')->middleware('auth');
Route::get('/block/delete/{id}', 'BlockController@delete')->name('block.delete')->middleware('auth');
Route::get('/block/deleteall/{ids}', 'BlockController@delete_all')->name('block.deleteall')->middleware('auth');

Route::post('/block/update/index', 'BlockController@update_index')->name('block.update.index')->middleware('auth');
Route::post('/block/updatename', 'BlockController@update_name')->name('block.updatename.post')->middleware('auth');
Route::post('/block/create', 'BlockController@create')->name('block.create.post')->middleware('auth');
//--------------------------------------
// Question Routes
//------------------------------------
Route::prefix('question')->group(function () {
    //get routes
    Route::get('/create/{id}', 'QuestionController@create_get')->name('question.create.get')->middleware('auth');
    Route::get('/choices/{id}', 'QuestionController@question_choices')->name('question.choice.view')->middleware('auth');
    Route::get('/preview/{id}', 'QuestionController@preview')->name('question.preview')->middleware('auth');
    Route::get('/edit/{id}', 'QuestionController@edit_get')->name('question.edit.get')->middleware('auth');
    Route::get('/move/{id}', 'QuestionController@move')->name('question.move')->middleware('auth');
    Route::get('/delete/{id}', 'QuestionController@delete')->name('question.delete')->middleware('auth');
    Route::get('/deleteall/{id}', 'QuestionController@delete_all')->name('question.deleteall')->middleware('auth');
    Route::get('/update/index/{id_question}/{type}', 'QuestionController@update_index')->name('question.index.update')->middleware('auth');
    Route::get('/choices/{id}', 'QuestionController@question_choices')->name('question.choice.view')->middleware('auth');


    //post routes
    Route::post('/create', 'QuestionController@create_post')->name('question.create.post')->middleware('auth');
    Route::post('/edit', 'QuestionController@edit_post')->name('question.edit.post')->middleware('auth');

});


// AUthenticated routhes
Auth::routes();
