<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Project\DataBasesController;
use App\Http\Controllers\Project\DataExtractionController;
use App\Http\Controllers\Project\PlanningCriteriaController;
use App\Http\Controllers\Project\PlanningOverallInformationController;
use App\Http\Controllers\Project\PlanningResearchQuestionsController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Project\ReportingController;
use App\Http\Controllers\Project\SearchProjectController;
use App\Http\Controllers\Project\SearchStrategyController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\UserProfileController;
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

Route::get('/', function ()
{
    return view('welcome');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// about and help routes
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/help', [HelpController::class, 'index'])->name('help');
// end of about and help routes
Route::get('/search-project', [SearchProjectController::class, 'searchByTitleOrCreated'])->name('search-project');

// projects routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index')->middleware('auth');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create')->middleware('auth');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit')->middleware('auth');
Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy')->middleware('auth');
Route::get('/projects/{id}/add-member', [ProjectController::class, 'add_member'])->name('projects.add');
Route::put('/projects/{id}/add-member', [ProjectController::class, 'add_member_project'])->name('projects.add_member');
Route::delete('/projects/{idProject}/add-member/{idMember}', [ProjectController::class, 'destroy_member'])->name('projects.destroy_member');
Route::put('/projects/{idProject}/members/{idMember}/update-level', [ProjectController::class, 'update_member_level'])->name('projects.update_member_level');
// end of the projects routes

// planning routes
Route::get('/planning/{id}', [PlanningOverallInformationController::class, 'index'])->name('project.planning.index')->middleware('auth');
Route::post('/planning/domain', [PlanningOverallInformationController::class, 'domainUpdate'])->name('project.planning_overall.domainUpdate');
Route::put('/planning/domain/{id}', [PlanningOverallInformationController::class, 'domainEdit'])->name('project.planning_overall.domainEdit');
Route::delete('/planning/domain/{id}', [PlanningOverallInformationController::class, 'domainDestroy'])->name('project.planning_overall.domainDestroy');

Route::post('/planning/database', [PlanningOverallInformationController::class, 'databaseAdd'])->name('project.planning_overall.databaseAdd');
Route::delete('/planning/database/{id}', [PlanningOverallInformationController::class, 'databaseDestroy'])->name('project.planning_overall.databaseDestroy');

Route::post('/planning/study_type', [PlanningOverallInformationController::class, 'studyTAdd'])->name('project.planning_overall.studyTAdd');
Route::delete('/planning/study_type/{id}', [PlanningOverallInformationController::class, 'studyTDestroy'])->name('project.planning_overall.studyTDestroy');

Route::post('/planning/keyword', [PlanningOverallInformationController::class, 'keywordAdd'])->name('project.planning_overall.keywordAdd');
Route::put('/planning/keyword/{id}', [PlanningOverallInformationController::class, 'keywordEdit'])->name('project.planning_overall.keywordEdit');
Route::delete('/planning/keyword/{id}', [PlanningOverallInformationController::class, 'keywordDestroy'])->name('project.planning_overall.keywordDestroy');

Route::get('/search-strategy/{projectId}', [SearchStrategyController::class, 'index'])->name('project.search-strategy.index');
Route::post('/search-strategy/{projectId}/update', [SearchStrategyController::class, 'update'])->name('project.search-strategy.update');
Route::get('/search-strategy', function ()
{
    return view('search_strategy');
});

//end of the planning routes
Route::post('/planning/language', [PlanningOverallInformationController::class, 'languageAdd'])->name('project.planning_overall.languageAdd');
Route::delete('/planning/language/{id}', [PlanningOverallInformationController::class, 'languageDestroy'])->name('project.planning_overall.languageDestroy');

Route::post('/planning/study_type', [PlanningOverallInformationController::class, 'studyTAdd'])->name('project.planning_overall.studyTAdd');
Route::delete('/planning/study_type/{id}', [PlanningOverallInformationController::class, 'studyTDestroy'])->name('project.planning_overall.studyTDestroy');

Route::post('/planning/keyword', [PlanningOverallInformationController::class, 'keywordAdd'])->name('project.planning_overall.keywordAdd');
Route::put('/planning/keyword/{id}', [PlanningOverallInformationController::class, 'keywordEdit'])->name('project.planning_overall.keywordEdit');
Route::delete('/planning/keyword/{id}', [PlanningOverallInformationController::class, 'keywordDestroy'])->name('project.planning_overall.keywordDestroy');
Route::post('/planning/study_type', [PlanningOverallInformationController::class, 'studyTAdd'])->name('project.planning_overall.studyTAdd');
Route::delete('/planning/study_type/{id}', [PlanningOverallInformationController::class, 'studyTDestroy'])->name('project.planning_overall.studyTDestroy');

Route::get('/planning/{id}/research_questions', [PlanningResearchQuestionsController::class, 'index'])->name('project.planning.research_questions')->middleware('auth');
Route::post('/planning/research_questions/add', [PlanningResearchQuestionsController::class, 'add'])->name('project.planning_research.Add');
Route::put('/planning/research_questions/{id}', [PlanningResearchQuestionsController::class, 'edit'])->name('project.planning_research.Edit');
Route::delete('research_questions/{id}', [PlanningResearchQuestionsController::class, 'destroy'])->name('project.planning_research.Destroy');

Route::get('/planning/{id}/criteria', [PlanningCriteriaController::class, 'index'])->name('project.planning.criteria')->middleware('auth');
Route::post('/planning/criteria/add', [PlanningCriteriaController::class, 'add'])->name('project.planning_criteria.Add');
Route::put('/planning/criteria/{id}', [PlanningCriteriaController::class, 'edit'])->name('project.planning_criteria.Edit');
Route::put('/planning/criteria/change/{id}', [PlanningCriteriaController::class, 'change_preselected'])->name('project.planning_criteria.ChangeSelect');
Route::delete('criteria/{id}', [PlanningCriteriaController::class, 'destroy'])->name('project.planning_criteria.Destroy');

Route::get('/projects/{projectId}/planning/search-strategy', [SearchStrategyController::class, 'edit'])->name('project.search-strategy.edit');
Route::post('/projects/{projectId}/planning/search-strategy/update', [SearchStrategyController::class, 'update'])->name('project.search-strategy.update');

Route::post('/projects/{projectId}/planning/add-date', [PlanningOverallInformationController::class, 'addDate'])->name('project.planning_overall.add-date');
Route::get('/projects/{projectId}/planning/data-bases', [DataBasesController::class, 'index'])->name('project.planning.databases')->middleware('auth');
Route::post('/projects/{projectId}/planning/data-bases/add', [DataBasesController::class, 'add_database'])->name('project.planning.databasesAdd')->middleware('auth');
Route::post('/projects/{projectId}/planning/data-bases/{databaseId}/remove', [DataBasesController::class, 'remove_database'])->name('project.planning.databasesRemove')->middleware('auth');
Route::post('/projects/{projectId}/planning/data-bases/create', [DataBasesController::class, 'create_database'])->name('project.planning.databasesCreate')->middleware('auth');

Route::get('projects/{projectId}/planning/data-extraction', [DataExtractionController::class, 'index'])->name('project.planning.dataExtraction')->middleware('auth');
Route::post('projects/{projectId}/planning/data-extraction/create', [DataExtractionController::class, 'add_extraction'])->name('project.planning.dataExtractionCreate')->middleware('auth');
Route::post('projects/{projectId}/planning/data-extraction/option/create', [DataExtractionController::class, 'add_option'])->name('project.planning.dataExtractionOptionCreate')->middleware('auth');
Route::delete('projects/{projectId}/planning/data-extraction/{questionId}/remove', [DataExtractionController::class, 'delete_question'])->name('project.planning.dataExtractionDeleteQuestion')->middleware('auth');
Route::delete('projects/{projectId}/planning/data-extraction/option/{optionId}/remove', [DataExtractionController::class, 'delete_option'])->name('project.planning.dataExtractionDeleteOption')->middleware('auth');
Route::put('projects/{projectId}/planning/data-extraction/{questionId}/update', [DataExtractionController::class, 'edit_question'])->name('project.planning.dataExtractionUpdateQuestion')->middleware('auth');
Route::put('projects/{projectId}/planning/data-extraction/option/{optionId}/update', [DataExtractionController::class, 'edit_option'])->name('project.planning.dataExtractionUpdateOption')->middleware('auth');

//end of the planning routes

// start of the reporting routes
Route::get('/projects/{projectId}/reporting/', [ReportingController::class, 'index'])->name('reporting.index')->middleware('auth');

//Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
Route::get('/', [HomeController::class, 'guest_home'])->middleware('guest')->name('home');
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');

Route::group(['middleware' => 'auth'], function ()
{
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
