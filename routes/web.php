<?php
  
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\AssignCompanyController;
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
    return redirect('/login');
});
  
Auth::routes();
  
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/view-question-forms/{id}', [FormController::class, 'viewquestionform'])->name('view-question-forms');
Route::get('/get_question/{id}', [FormController::class, 'getquestion'])->name('get_question');
Route::post('/submit-answer', [ResultController::class, 'store'])->name('submit-answer');


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('question', QuestionController::class);
    Route::resource('form', FormController::class);
    Route::resource('companys', CompanyController::class);
    Route::resource('results', ResultController::class);
    Route::resource('assign', AssignCompanyController::class);

    Route::post('/store2/{id}', [QuestionController::class, 'store2'])->name('store2');
    Route::post('/update-question', [QuestionController::class, 'updateQuestion'])->name('update-question');
    Route::get('/get-my-info', [UserController::class, 'getMyInfo'])->name('get-my-info');
    Route::get('/get-report-info', [ResultController::class, 'getReportInfo'])->name('get-report-info');
    Route::post('/submit-my-info', [UserController::class, 'updateMyInfo'])->name('submit-my-info');
    Route::post('update-password', [UserController::class,'updatePassword'])->name('update-password');
    Route::get('/getuserid/{id}', [RoleController::class, 'getuserid']);
    Route::get('/add-announcements', [AssignCompanyController::class, 'addannouncement'])->name('add-announcements');
    Route::get('/view-announcements', [AssignCompanyController::class, 'viewannouncement'])->name('view-announcements');
    Route::get('/getannouncementuser/{lid}/{did}', [AssignCompanyController::class, 'getannouncementuser']);
    Route::get('/getannouncementrole/{id}', [AssignCompanyController::class, 'getannouncementrole']);
    Route::get('/getlocationid/{id}', [AssignCompanyController::class, 'getlocationid']);
    





});