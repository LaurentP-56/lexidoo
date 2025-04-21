<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\JeuController;
use App\Http\Controllers\LevelsController;
use App\Http\Controllers\MotsController;
use App\Http\Controllers\ProbabilitiesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TarifsController;
use App\Http\Controllers\ThemesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GoogleTextToSpeechController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\GarAuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SamlController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route pour l'utilisateur authentifié
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes d'authentification
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

// Routes GAR
Route::prefix('gar')->group(function () {
    Route::get('/redirect', [GarAuthController::class, 'initiateGarLogin']);
    Route::get('/auth', [GarAuthController::class, 'handleAuth']);
    Route::match(['get', 'post'], '/logout', [GarAuthController::class, 'logout']);
});

// Routes pour l'authentification sociale
Route::prefix('auth')->group(function () {
    Route::get('/redirect/{provider}', [App\Http\Controllers\SocialController::class, 'redirect']);
    Route::get('/callback/{provider}', [App\Http\Controllers\SocialController::class, 'callback']);
});

// Routes pour les abonnements (uniquement utilisateurs non-GAR)
Route::middleware(['auth:sanctum', 'non.gar'])->prefix('subscriptions')->group(function () {
    Route::get('/', [SubscriptionController::class, 'index']);
    Route::get('/{id}', [SubscriptionController::class, 'show']);
    Route::post('/', [SubscriptionController::class, 'create']);
    Route::delete('/{id}', [SubscriptionController::class, 'delete']);
});

// Routes protégées par authentification
Route::middleware('auth:sanctum')->group(function () {
    // Routes du profil (uniquement utilisateurs non-GAR)
    Route::middleware('non.gar')->prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::get('/edit', [ProfileController::class, 'edit']);
        Route::patch('/', [ProfileController::class, 'update']);
        Route::delete('/', [ProfileController::class, 'destroy']);
    });

    // Routes des statistiques et du jeu
    Route::get('/statistics', [StatisticsController::class, 'index']);
    Route::prefix('game')->group(function () {
        Route::post('/submit', [JeuController::class, 'submit']);
        Route::post('/get-words', [JeuController::class, 'getWords']);
    });
    Route::get('/word-details/{id}', [MotsController::class, 'getWordDetails']);
});

// Routes d'administration
Route::middleware(['auth:sanctum', 'isAdmin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    
    // Gestion des utilisateurs
    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index']);
        Route::post('/update-premium/{user}', [UsersController::class, 'updatePremiumStatus']);
    });
    
    // Gestion des tarifs
    Route::prefix('tarifs')->group(function () {
        Route::get('/', [TarifsController::class, 'index']);
        Route::post('/', [TarifsController::class, 'store']);
        Route::get('/{tarif}', [TarifsController::class, 'show']);
        Route::put('/{tarif}', [TarifsController::class, 'update']);
        Route::delete('/{tarif}', [TarifsController::class, 'destroy']);
    });
    
    // Gestion des niveaux
    Route::prefix('levels')->group(function () {
        Route::get('/', [LevelsController::class, 'index']);
        Route::post('/', [LevelsController::class, 'store']);
        Route::get('/{level}', [LevelsController::class, 'show']);
        Route::put('/{level}', [LevelsController::class, 'update']);
        Route::delete('/{level}', [LevelsController::class, 'destroy']);
    });
    
    // Gestion des probabilités
    Route::prefix('probabilities')->group(function () {
        Route::get('/', [ProbabilitiesController::class, 'index']);
        Route::post('/', [ProbabilitiesController::class, 'store']);
        Route::post('/reset', [ProbabilitiesController::class, 'reset']);
    });
    
    // Gestion des thèmes
    Route::prefix('themes')->group(function () {
        Route::get('/', [ThemesController::class, 'index']);
        Route::post('/', [ThemesController::class, 'store']);
        Route::get('/{theme}', [ThemesController::class, 'show']);
        Route::put('/{theme}', [ThemesController::class, 'update']);
        Route::delete('/{theme}', [ThemesController::class, 'destroy']);
    });
    
    // Gestion des catégories
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoriesController::class, 'index']);
        Route::post('/', [CategoriesController::class, 'store']);
        Route::get('/{category}', [CategoriesController::class, 'show']);
        Route::put('/{category}', [CategoriesController::class, 'update']);
        Route::delete('/{category}', [CategoriesController::class, 'destroy']);
    });
    
    // Gestion des sous-catégories
    Route::prefix('sub-categories')->group(function () {
        Route::get('/', [SubCategoryController::class, 'index']);
        Route::post('/', [SubCategoryController::class, 'store']);
        Route::get('/{subCategory}', [SubCategoryController::class, 'show']);
        Route::put('/{subCategory}', [SubCategoryController::class, 'update']);
        Route::delete('/{subCategory}', [SubCategoryController::class, 'destroy']);
        Route::post('/get-categories', [SubCategoryController::class, 'getCategory']);
    });
    
    // Gestion des mots
    Route::prefix('mots')->group(function () {
        Route::get('/', [MotsController::class, 'index']);
        Route::post('/', [MotsController::class, 'store']);
        Route::get('/{mot}', [MotsController::class, 'show']);
        Route::put('/{mot}', [MotsController::class, 'update']);
        Route::delete('/{mot}', [MotsController::class, 'destroy']);
        Route::post('/import', [MotsController::class, 'import']);
        Route::get('/search', [MotsController::class, 'search']);
    });
    
    // Routes AJAX
    Route::prefix('ajax')->group(function () {
        Route::post('/get-categories', [AjaxController::class, 'getCategory']);
        Route::post('/get-sub-categories', [AjaxController::class, 'getSubCategory']);
    });
});

// Routes pour générer des fichiers audio
Route::get('/generate-audios', [GoogleTextToSpeechController::class, 'generateMissingAudios']);
Route::get('/download-audio/{id}', [MotsController::class, 'downloadAudio']);

// Routes pour les pages de contact et légales
Route::post('/contact', [ContactController::class, 'send']);
Route::get('/tarifs', [TarifsController::class, 'index'])->middleware('non.gar');

// Routes SAML
Route::prefix('saml')->group(function () {
    Route::get('/metadata', [SamlController::class, 'metadata']);
    Route::get('/verify', [SamlController::class, 'verifyMetadata']);
    Route::get('/sso', [SamlController::class, 'sso']);
    Route::post('/acs', [SamlController::class, 'acs']);
    Route::get('/sls', [SamlController::class, 'sls']);
    Route::get('/check-entity-id', [SamlController::class, 'checkEntityId']);
    Route::get('/verify-cert/{fichier?}', [SamlController::class, 'verifierCertificats']);
}); 