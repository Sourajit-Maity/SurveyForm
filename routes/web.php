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
    Route::get('/deletequestion/{id}', [QuestionController::class, 'deleteQuestion'])->name('deletequestion');

});