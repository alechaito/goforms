<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function () {
    return view('apply');
});


Route::get('/storequestion/home', function () {
    return view('storequestion.home');
})->name('storequestion.view')->middleware('auth');

Route::get('/searchuser', function () {
    return view('searchuser');
})->name('searchuser.view')->middleware('auth');

Route::get('/searchpatient', function () {
    return view('searchpatient');
})->name('searchpatient.view')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/logout', 'HomeController@logout')->name('logout')->middleware('auth');
//Route::get('/manifest.json', 'HomeController@manifest')->name('manifest');

Route::get('/search-allusers', 'HomeController@search_allusers');
Route::get('/back', 'HomeController@back')->name('redirect.back');
//--------------------------------------
// Teacher Routes
//------------------------------------
Route::get('/teacher/create', function () {
    return view('teacher.create');
})->name('teacher.create');
Route::get('/teacher/edit/{id}', 'TeacherController@edit')->name('teacher.edit.view')->middleware('auth');
Route::get('/teacher/delete/{id}', 'TeacherController@delete')->name('teacher.delete')->middleware('auth');

Route::post('/teacher/edit', 'TeacherController@edit_post')->name('teacher.edit.post');
Route::post('/teacher/edit/password', 'TeacherController@edit_password')->name('teacher.edit.password');
//--------------------------------------
// Student Routes
//------------------------------------
Route::get('/student/create', function () {
    return view('student.create');
})->name('student.create');
Route::get('/student/edit/{id}', 'StudentController@edit')->name('student.edit.view')->middleware('auth');
Route::get('/student/delete/{id}', 'StudentController@delete')->name('student.delete')->middleware('auth');

Route::post('/student/edit', 'StudentController@edit_post')->name('student.edit.post');
Route::post('/student/edit/password', 'StudentController@edit_password')->name('student.edit.password');
//--------------------------------------
// Patient Routes
//------------------------------------
Route::prefix('patient')->group(function () {
    // get routes
    Route::get('/create', 'PatientController@create_get')->name('patient.create.get')->middleware('auth');
    Route::get('/find/{id_quiz}', 'PatientController@find_get')->middleware('auth');
    Route::get('/evaluate/{id_patient}/{id_quiz}', 'PatientController@evaluate_get')->name('patient.evaluate.get')->middleware('auth');

    // post routes
    Route::post('/create', 'PatientController@create_post')->name('patient.create.post');
    Route::post('/evaluate', 'PatientController@evaluate_post')->name('patient.evaluate.post');
});

Route::get('/search-patients', 'PatientController@search_patients');
Route::get('/patient/edit/{id}', 'PatientController@edit')->name('patient.edit.view')->middleware('auth');
Route::get('/patient/delete/{id}', 'PatientController@delete')->name('patient.delete')->middleware('auth');

Route::post('/patient/edit', 'PatientController@edit_post')->name('patient.edit.post');
//--------------------------------------
// Group Routes
//------------------------------------
Route::prefix('group')->group(function () {
    //get routes
    Route::get('/participants/{id}', 'GroupController@participants_get')->name('group.participants.get')->middleware('auth');
    Route::get('/view/{id}', 'GroupController@view_get')->name('group.view.get')->middleware('auth');
    Route::get('/delete/{id}', 'GroupController@delete_get')->name('group.delete.get')->middleware('auth');

    //post routes
});

//Route::get('/group/view/{id}', 'GroupController@preview')->name('group.preview.view')->middleware('auth');
Route::get('/search-user', 'GroupController@search_user');
Route::get('/search-participants/add/{id_group}', 'GroupController@search_participants_add');
Route::get('/search-participants/{id_group}', 'GroupController@search_participants');
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
    
    //post routes
    Route::post('/create', 'QuestionController@create_post')->name('question.create.post')->middleware('auth');
});

Route::get('/question/choices/{id}', 'QuestionController@question_choices')->name('question.choice.view')->middleware('auth');
Route::get('/question/preview/{id}', 'QuestionController@preview')->name('question.preview')->middleware('auth');
Route::get('/question/edit/{id}', 'QuestionController@edit')->name('question.edit')->middleware('auth');
Route::get('/question/move/{id}', 'QuestionController@move')->name('question.move')->middleware('auth');
Route::get('/question/delete/{id}', 'QuestionController@delete')->name('question.delete')->middleware('auth');
Route::get('/question/deleteall/{id}', 'QuestionController@delete_all')->name('question.deleteall')->middleware('auth');
Route::get('/question/update/index/{id_question}/{type}', 'QuestionController@update_index')->name('question.index.update')->middleware('auth');
Route::get('/question/choices/{id}', 'QuestionController@question_choices')->name('question.choice.view')->middleware('auth');

Route::post('/question/edit/post', 'QuestionController@edit_post')->name('question.edit.post')->middleware('auth');
//--------------------------------------
//Store Question Routes
//------------------------------------
/*Route::get('/search-storequestion', 'StoreQuestionController@search_storequestion');
Route::get('/search-storequestion/block/{id_block}', 'StoreQuestionController@search_storequestion_block');
Route::get('/search-categories', 'StoreQuestionController@search_categories');
Route::get('/storequestion/delete/{id}', 'StoreQuestionController@delete')->name('storequestion.delete')->middleware('auth');
Route::get('/storequestion/preview/{id}', 'StoreQuestionController@preview')->name('storequestion.preview')->middleware('auth');
Route::get('/storequestion/copy/{id}', 'StoreQuestionController@copy')->name('storequestion.copy')->middleware('auth');
Route::get('/storequestion/edit/{id}', 'StoreQuestionController@edit')->name('storequestion.edit.get')->middleware('auth');
Route::get('/storequestion/categories/', 'StoreQuestionController@category_view')->name('storequestion.category.view')->middleware('auth');
Route::get('/storequestion/category.delete/{id}', 'StoreQuestionController@category_delete')->name('storequestion.category.delete')->middleware('auth');
Route::get('/storequestion/move/{id}/{id_block}', 'StoreQuestionController@move')->name('storequestion.move')->middleware('auth');
Route::get('/storequestion/moveall/{ids}/{id_block}', 'StoreQuestionController@move_all')->name('storequestion.moveall')->middleware('auth');


Route::post('/storequestion/create', 'StoreQuestionController@create')->name('storequestion.create.post')->middleware('auth');
Route::post('/storequestion/create/category', 'StoreQuestionController@create_category')->name('storequestion.category.create')->middleware('auth');
Route::post('/storequestion/edit/', 'StoreQuestionController@edit_post')->name('storequestion.edit.post')->middleware('auth');
*/
// AUthenticated routhes
Auth::routes();
