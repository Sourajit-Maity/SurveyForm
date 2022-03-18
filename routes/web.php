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
use App\Http\Controllers\CommentController;
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

    Route::get('/get-report-info', [ResultController::class, 'index'])->name('get-report-info');
    Route::get('/my-report/{id}', [ResultController::class, 'show'])->name('my-report');

    Route::get('/get-company-user/{id}', [CompanyController::class, 'getCompanyUser'])->name('get-company-user');
    Route::get('/get-company-manager/{id}', [UserController::class, 'getCompanyManager'])->name('get-company-manager');

    Route::get('/get-my-info', [UserController::class, 'getMyInfo'])->name('get-my-info');  
    Route::post('/submit-my-info', [UserController::class, 'updateMyInfo'])->name('submit-my-info');
    Route::post('update-password', [UserController::class,'updatePassword'])->name('update-password');

    Route::get('/getuserid/{id}', [RoleController::class, 'getuserid']);

    Route::get('/add-announcements', [AssignCompanyController::class, 'addannouncement'])->name('add-announcements');
    Route::get('/view-announcements', [AssignCompanyController::class, 'viewannouncement'])->name('view-announcements');
    Route::get('/getannouncementuser/{lid}/{did}', [AssignCompanyController::class, 'getannouncementuser']);
    Route::get('/getannouncementrole/{id}', [AssignCompanyController::class, 'getannouncementrole']);
    Route::get('/getlocationid/{id}', [AssignCompanyController::class, 'getlocationid']);
    Route::get('/forward-assign', [AssignCompanyController::class, 'forwardindex'])->name('forward-assign');
    Route::get('/forward-show/{id}', [AssignCompanyController::class, 'forwardshow'])->name('forward-show');
    Route::get('/assign-form-show/{id}', [AssignCompanyController::class, 'assignFormShow'])->name('assign-form-show');
    Route::post('/comment/store', [CommentController::class,'store'])->name('comment.add');
    Route::post('/reply/store', [CommentController::class,'replyStore'])->name('reply.add');
    Route::post('forward-messgae-store', [ResultController::class,'forwardmessagestore'])->name('forward-messgae-store');
    Route::get('my-info-details', [AssignCompanyController::class,'myinfodetails'])->name('my-info-details');
    Route::get('assign-form-details/{id}', [AssignCompanyController::class,'assignformdetails'])->name('assign-form-details');

    Route::post('result-message-store', [ResultController::class,'resultMessageStore'])->name('result-message-store');

    Route::get('get-share-report', [ResultController::class,'getShareReport'])->name('get-share-report');
    Route::get('get-share-report-user', [ResultController::class,'getShareReportuser'])->name('get-share-report-user');
    Route::get('get-share-report-details/{id}', [ResultController::class,'getShareReportDetails'])->name('get-share-report-details');
    Route::get('report-share/{id}', [ResultController::class,'reportShare'])->name('report-share');
    Route::get('/getemployee/{id}', [AssignCompanyController::class, 'getEmployee']);

    Route::get('file-export', [ResultController::class, 'fileExport'])->name('file-export');


});