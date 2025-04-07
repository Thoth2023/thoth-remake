<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\DatabaseManagerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionManagerController;
use App\Http\Controllers\Project\ExportController;
use App\Http\Controllers\UserManagerController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Project\Conducting\ConductingController;
use App\Http\Controllers\Project\Conducting\DataExtractionController;
use App\Http\Controllers\Project\Planning\CriteriaController;
use App\Http\Controllers\Project\Planning\Overall\OverallController;
use App\Http\Controllers\Project\conducting\OverallController as OverallConductingController;
use App\Http\Controllers\Project\Conducting\StudySelectionController;
use App\Http\Controllers\Project\Planning\Overall\StudyTypeController;
use App\Http\Controllers\Project\Planning\ResearchQuestionsController;
use App\Http\Controllers\Project\Planning\SearchStrategyController;
use App\Http\Controllers\Project\Planning\SearchStringController;
use App\Http\Controllers\Project\Planning\DataExtraction\OptionController;
use App\Http\Controllers\Project\Planning\DataExtraction\QuestionController;
use App\Http\Controllers\Project\Planning\QualityAssessment\GeneralScoreController;
use App\Http\Controllers\Project\Planning\QualityAssessment\QuestionController as QualityAssessmentQuestionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Project\ReportingController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\SearchProjectController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\Localization;
use App\Livewire\Planning\Databases\DatabaseManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//analisar esta 2 próximas linhas
use App\Livewire\Planning\Databases\Databases;
use App\Http\Controllers\ThemeController;


//use App\Http\Controllers\Auth\LoginController;
//use Illuminate\Support\Facades\Route;

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

Route::middleware(Localization::class)->get('/', function () {
    return view('welcome');
});

Route::get('/message', function () {
    return view('message');
})->name('message');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(Localization::class);



// Pages controllers

// Auth Controllers

Route::get('/localization/{locale}', LocalizationController::class)->name('localization');

// About routes
Route::get('/' . __('about'), [AboutController::class, 'index'])->name('about')->middleware(Localization::class);

// Help routes
Route::get('/' . __('help'), [HelpController::class, 'index'])->name('help')->middleware(Localization::class);
// Route::get('/help', [HelpController::class, 'index'])->name('help');
// end of about and help routes

// Sidenav routes
Route::get('/' . __('sidenav'))->name('sidenav')->middleware(Localization::class);

// Profile routes
// Route::get('/profile', [UserProfileController::class, 'show'])->name('profile')->middleware(Localization::class);
// Route::get('/' . __('profile'), [UserProfileController::class, 'index'])->name('profile')->middleware(Localization::class);

// Terms routes
Route::get('/' . __('terms'), [TermsController::class, 'index'])->name('terms')->middleware(Localization::class);

Route::get('/search-project', [SearchProjectController::class, 'searchByTitleOrCreated'])->name('search-project')->middleware(Localization::class);

//Theme routes
Route::get('/themes', [ThemeController::class, 'readCookie']);

// Projects Routes
Route::get('/projects/{id}' . __('header'))->name('header')->middleware(Localization::class);


Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index')->middleware('auth')->middleware(Localization::class);
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create')->middleware('auth')->middleware(Localization::class);
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show')->middleware(Localization::class);
Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit')->middleware('auth')->middleware(Localization::class);
Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update')->middleware(Localization::class);
Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy')->middleware('auth');
Route::get('/projects/{id}/add-member', [ProjectController::class, 'add_member'])->name('projects.add')->middleware('auth')->middleware(Localization::class);
Route::put('/projects/{id}/add-member', [ProjectController::class, 'add_member_project'])->name('projects.add_member');
Route::delete('/projects/{idProject}/add-member/{idMember}', [ProjectController::class, 'destroy_member'])->name('projects.destroy_member');
Route::put('/projects/{idProject}/members/{idMember}/update-level', [ProjectController::class, 'update_member_level'])->name('projects.update_member_level');
// End of the Projects Routes
Route::get('/project/{idProject}/accept-invitation', [ProjectController::class, 'acceptInvitation'])->name('projects.accept_invitation');


// Project Routes
Route::prefix('project/{projectId}')->middleware(['auth', Localization::class])->group(function () {

        // // Start of the conducting routes
        // Route::prefix('/conducting')->group(function () {
        //     Route::get('/', [OverallConductingController::class, 'index'])->name('conducting.index')->middleware('auth')->middleware(Localization::class);;
        // });


     // Planning Routes

    Route::prefix('/planning')->group(function () {
        Route::get('/', [OverallController::class, 'index'])
            ->name('project.planning.index')
            ->middleware('auth')
            ->middleware(Localization::class);

        // Database Route
        Route::get('/databases', [Databases::class, 'render']);

        // Search Strategy Route
        Route::put('/search-strategy', [SearchStrategyController::class, 'update'])
            ->name('project.planning.search-strategy.update');

        // Search String
        Route::get('/search-string', [SearchStringController::class, 'index'])->name('search_string');
        Route::post('/search-string/term', [SearchStringController::class, 'store_term'])->name('planning_search_string.add_term');
        Route::post('/search-string/synonym', [SearchStringController::class, 'store_synonym'])->name('planning_search_string.add_synonym');
        Route::post('/generate-string/{id_project}/{database_id}', [SearchStringController::class, 'generateString'])->name('generate-string');

        Route::put('/search-string/term/{id}', [SearchStringController::class, 'update_term'])->name('planning_search_string.update_term');
        Route::put('/search-string/synonym/{id}', [SearchStringController::class, 'update_synonym'])->name('planning_search_string.update_synonym');
        Route::delete('/search-string/term/{id}', [SearchStringController::class, 'destroy_term'])->name('planning_search_string.destroy_term');
        Route::delete('/search-string/synonym/{id}', [SearchStringController::class, 'destroy_synonym'])->name('planning_search_string.destroy_synonym');

        // Research Questions Routes
        Route::resource('/research-questions', ResearchQuestionsController::class)
            ->only(['store', 'update', 'destroy'])
            ->names([
                'store' => 'project.planning.research-questions.store',
                'update' => 'project.planning.research-questions.update',
                'destroy' => 'project.planning.research-questions.destroy',
            ]);

        // Criteria Routes
        Route::resource('/criteria', CriteriaController::class)
            ->only(['store', 'update', 'destroy'])
            ->names([
                'store' => 'project.planning.criteria.store',
                'update' => 'project.planning.criteria.update',
                'destroy' => 'project.planning.criteria.destroy',
            ]);

        Route::put('/criteria/{criteriaId}/change-preselected', [CriteriaController::class, 'change_preselected'])
            ->name('project.planning.criteria.change-preselected');

        // Quality Assessment Routes
        Route::prefix('/quality-assessment')->group(function () {
            Route::resource('/general-score', GeneralScoreController::class)
                ->only(['store', 'update', 'destroy'])
                ->names([
                    'store' => 'project.planning.quality-assessment.general-score.store',
                    'update' => 'project.planning.quality-assessment.general-score.update',
                    'destroy' => 'project.planning.quality-assessment.general-score.destroy',
                ]);
            Route::resource('/question', QualityAssessmentQuestionController::class)
                ->only(['store', 'update', 'destroy'])
                ->names([
                    'store' => 'project.planning.quality-assessment.question.store',
                    'update' => 'project.planning.quality-assessment.question.update',
                    'destroy' => 'project.planning.quality-assessment.question.destroy',
                ]);
        });

        // Data Extraction Routes
        Route::prefix('/data-extraction/')->group(function () {

            Route::resource('/option', OptionController::class)
                ->only(['store', 'update', 'destroy'])
                ->names([
                    'store' => 'project.planning.data-extraction.option.store',
                    'update' => 'project.planning.data-extraction.option.update',
                    'destroy' => 'project.planning.data-extraction.option.destroy',
                ]);

            Route::resource('/question', QuestionController::class)
                ->only(['store', 'update', 'destroy'])
                ->names([
                    'store' => 'project.planning.data-extraction.question.store',
                    'update' => 'project.planning.data-extraction.question.update',
                    'destroy' => 'project.planning.data-extraction.question.destroy',
                ]);
        });
    });
    // End of the Planning Routes


    Route::prefix('/conducting')->group(function () {

        Route::get('/', [ConductingController::class, 'index'])
            ->name('project.conducting.index')
            ->middleware('auth')
            ->middleware(Localization::class);

        // Data Extraction Routes
        Route::prefix('/data-extraction/')->group(function () {
            Route::resource('/extraction', DataExtractionController::class)
                ->only(['index'])
                ->names(['index' => 'project.planning.data-extraction.data-extraction.index']);
        });

    });

    // start of the reporting routes
    Route::get('/reporting/', [ReportingController::class, 'index'])->name('project.reporting.index')->middleware('auth')->middleware(Localization::class);


    Route::get('/export/', [ExportController::class, 'index'])->name('project.export.index')->middleware('auth')->middleware(Localization::class);
    // Star of Conducting routes

});

//SUPER USER ROUTES
Route::middleware(['auth', 'role:is_super_user'])->group(function () {
Route::get('/database-manager', [DatabaseManagerController::class, 'index'])->name('database-manager')->middleware('auth');
Route::get('/user-manager', [UserManagerController::class, 'index'])->name('user-manager')->middleware('auth');
Route::get('/users/{user}/edit', [UserManagerController::class, 'edit'])->name('user.edit');
Route::post('/users/{user}', [UserManagerController::class, 'update'])->name('user.update');
Route::get('/user/create', [UserManagerController::class, 'create'])->name('user.create');
Route::post('/user', [UserManagerController::class, 'store'])->name('user.store');
Route::get('/user/{user}', [UserManagerController::class, 'deactivate'])->name('user.deactivate');

Route::get('levels', [LevelController::class, 'index'])->name('levels.index')->middleware('auth');
Route::get('levels/create', [LevelController::class, 'create'])->name('levels.create')->middleware('auth');
Route::post('levels', [LevelController::class, 'store'])->name('levels.store')->middleware('auth');
Route::get('levels/{level}', [LevelController::class, 'show'])->name('levels.show')->middleware('auth');
Route::get('levels/{level}/edit', [LevelController::class, 'edit'])->name('levels.edit')->middleware('auth');
Route::put('levels/{level}', [LevelController::class, 'update'])->name('levels.update')->middleware('auth');
Route::post('levels/{level}', [LevelController::class, 'update'])->name('levels.update')->middleware('auth');
Route::delete('levels/{level}', [LevelController::class, 'destroy'])->name('levels.destroy')->middleware('auth');



Route::resource('permissions', PermissionController::class);
});

//Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
Route::middleware(['locale', 'guest'])->group(function () {
    Route::get('/', [HomeController::class, 'guest_home'])->name('home');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.perform');
    Route::get('/login', [LoginController::class, 'show'])->name('login')->middleware(Localization::class);
    Route::post('/login', [LoginController::class, 'login'])->name('login.perform')->middleware(Localization::class);
    Route::get('/reset-password', [ResetPassword::class, 'show'])->name('reset-password');
    Route::post('/reset-password', [ResetPassword::class, 'send'])->name('reset.perform');
    Route::get('/change-password/{id}', [ChangePassword::class, 'show'])->name('change-password');
    Route::post('/change-password/{id}', [ChangePassword::class, 'update'])->name('change.perform');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');

});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
    Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile')->middleware(Localization::class);
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update')->middleware(Localization::class);
    Route::post('/profile/delete-data', [UserProfileController::class, 'requestDataDeletion'])->name('user.requestDataDeletion')->middleware(Localization::class);
    Route::get('/confirm-delete-account/{id}', [UserProfileController::class, 'confirmDeleteAccount'])->name('confirm-delete-account')->middleware('signed');
    Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
    Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
    Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
    Route::get('/{page}', [PageController::class, 'index'])->name('page');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/accept-lgpd', [LoginController::class, 'acceptLgpd'])->name('accept.lgpd');
});





Route::get('auth/google', [RegisterController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [RegisterController::class, 'handleGoogleCallback']);
Route::get('auth/facebook', [RegisterController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [RegisterController::class, 'handleFacebookCallback']);
Route::get('auth/apple', [RegisterController::class, 'redirectToApple'])->name('auth.apple');
Route::get('auth/apple/callback', [RegisterController::class, 'handleAppleCallback']);
