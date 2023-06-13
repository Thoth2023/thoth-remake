<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PlanningOverallInformationController;
use App\Http\Controllers\SearchStrategyController;
    // projects routes

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index')->middleware('auth');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create')->middleware('auth');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit')->middleware('auth');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy')->middleware('auth');
    // end of the projects routes

	// planning routes
	Route::get('/planning/{id}', [PlanningOverallInformationController::class, 'index'])->name('planning.index')->middleware('auth');
	Route::post('/planning/domain', [PlanningOverallInformationController::class, 'domainUpdate'])->name('planning_overall.domainUpdate');
	Route::put('/planning/domain/{id}', [PlanningOverallInformationController::class, 'domainEdit'])->name('planning_overall.domainEdit');
	Route::delete('/planning/domain/{id}', [PlanningOverallInformationController::class, 'domainDestroy'])->name('planning_overall.domainDestroy');

	Route::post('/planning/language', [PlanningOverallInformationController::class, 'languageAdd'])->name('planning_overall.languageAdd');
	Route::delete('/planning/language/{id}', [PlanningOverallInformationController::class, 'languageDestroy'])->name('planning_overall.languageDestroy');

    Route::post('/planning/database', [PlanningOverallInformationController::class, 'databaseAdd'])->name('planning_overall.databaseAdd');
	Route::delete('/planning/database/{id}', [PlanningOverallInformationController::class, 'databaseDestroy'])->name('planning_overall.databaseDestroy');

	Route::post('/planning/study_type', [PlanningOverallInformationController::class, 'studyTAdd'])->name('planning_overall.studyTAdd');
	Route::delete('/planning/study_type/{id}', [PlanningOverallInformationController::class, 'studyTDestroy'])->name('planning_overall.studyTDestroy');

	Route::post('/planning/keyword', [PlanningOverallInformationController::class, 'keywordAdd'])->name('planning_overall.keywordAdd');
	Route::put('/planning/keyword/{id}', [PlanningOverallInformationController::class, 'keywordEdit'])->name('planning_overall.keywordEdit');
	Route::delete('/planning/keyword/{id}', [PlanningOverallInformationController::class, 'keywordDestroy'])->name('planning_overall.keywordDestroy');

    Route::get('/search-strategy/{projectId}', [SearchStrategyController::class, 'index'])->name('search-strategy.index');
    Route::post('/search-strategy/{projectId}/update', [SearchStrategyController::class, 'update'])->name('search-strategy.update');

	//end of the planning routes

    //Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
	Route::get('/', [HomeController::class, 'guest_home'])->name('home');
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
	Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');

});
