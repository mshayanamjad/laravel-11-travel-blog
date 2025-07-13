<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\admin\RegisterController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\TagController;
use App\Http\Controllers\admin\AdPanelCommentController;
// Editor Controllers
use App\Http\Controllers\editor\EditorCategoryController;
use App\Http\Controllers\editor\EditorController;
use App\Http\Controllers\editor\EditorPostController;
use App\Http\Controllers\editor\EditorSubCategoryController;
use App\Http\Controllers\editor\EditorTagController;
use App\Http\Controllers\editor\EdPanelCommentController;
// Home Controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;


// Route::get('/', function () {
//     return view('welcome');
// });


// Slug Generation Route
Route::get('/getSlug', function (Request $request) {
    $slug = $request->title ? Str::slug($request->title) : '';
    return response()->json([
        'status' => true,
        'slug' => $slug
    ]);
})->name('getSlug');


Route::get('forgot-password', [AccountController::class, 'showForgotPassword'])->name('account.forgotPassword');
Route::post('process-forgot-password', [AccountController::class, 'processForgotPassword'])->name('account.processForgotPassword');
Route::get('reset-password/{token}', [AccountController::class, 'resetPassword'])->name('account.resetPassword');
Route::post('process-reset-password', [AccountController::class, 'processResetPassword'])->name('account.processResetPassword');

/* ------------------------------ FrontEnd Routes ---------------------------------- */

Route::group(['prefix' => 'travel-blog'], function () {

    Route::name('front.')->group(function () {
        Route::get('/', [HomeController::class, 'home'])->name('home');
        Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
        Route::get('/blog/{slug}', [HomeController::class, 'singlePost'])->name('singlePost');
        Route::post('/add-to-fav', [HomeController::class, 'addToFav'])->name('addToFav');
        Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
        Route::get('/about', [HomeController::class, 'about'])->name('about');
        Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
        Route::get('/my-travel-gear', [HomeController::class, 'travelGear'])->name('travelGear');
        Route::post('/subscribe', [ContactController::class, 'subscribe'])->name('subscribe');
        Route::get('/unsubscribe/{email}', [ContactController::class, 'unsubscribe'])->name('unsubscribe');
    });

    Route::group(['middleware' => 'guest'], function () {

        Route::name('front.')->group(function () {
            Route::get('/login', [AuthController::class, 'login'])->name('login');
            Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
            Route::get('/register', [AuthController::class, 'register'])->name('register');
            Route::post('/register-process', [AuthController::class, 'userRegisteration'])->name('userRegisteration');
        });
    });

    Route::group(['middleware' => 'auth'], function () {

        Route::name('front.')->group(function () {
            Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
            Route::put('/update-profile/{user}', [AuthController::class, 'updateProfile'])->name('updateProfile');
            Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/user-change-password', [AuthController::class, 'ChangeUserPassword'])->name('ChangeUserPassword');
            Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
            Route::get('/my-favourite-post', [AuthController::class, 'favPost'])->name('favPost');
            Route::post('/remove-favourite-post', [AuthController::class, 'removeFavPosts'])->name('removeFavPosts');
            Route::get('/delete-user', [AuthController::class, 'deleteUser'])->name('deleteUser'); // Link to delete user account form Account Page
            Route::get('/show-deletion-form', [AuthController::class, 'showDeleteForm'])->name('showDeleteForm');
            Route::post('process-delete-account', [AuthController::class, 'processDeleteAcc'])->name('processDeleteAcc');
            Route::post('store-comment', [CommentController::class, 'storeComment'])->name('storeComment');
            Route::get('/comments', [AuthController::class, 'userComment'])->name('userComment');
            Route::post('/submit-contact-form', [ContactController::class, 'submitForm'])->name('submitForm');
        });
    });
});

/* ------------------------------ Admin Routes ---------------------------------- */

Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });


    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('dashboard', [AdminLoginController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


        Route::prefix('account')->name('accounts.')->group(function () {
            Route::get('/change-password', [AdminLoginController::class, 'showChangePassword'])->name('changePassword');
            Route::post('/process-change-password', [AdminLoginController::class, 'changePassword'])->name('processChangePassword');
        });


        // Users Routes
        Route::prefix('user')->name('users.')->group(function () {
            Route::get('/', [AdminLoginController::class, 'show'])->name('show');
            Route::get('/create', [RegisterController::class, 'create'])->name('create');
            Route::post('/', [RegisterController::class, 'processRegister'])->name('register');
            Route::get('/{user}/edit', [RegisterController::class, 'edit'])->name('edit');
            Route::put('/{user}/update', [RegisterController::class, 'update'])->name('update');
            Route::delete('/{user}', [RegisterController::class, 'destroy'])->name('delete');
        });

        // Category Routes
        Route::prefix('category')->name('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}/update', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('delete');
        });

        // Sub Category Routes
        Route::prefix('sub-category')->name('sub-categories.')->group(function () {
            Route::get('/', [SubCategoryController::class, 'index'])->name('index');
            Route::get('/create', [SubCategoryController::class, 'create'])->name('create');
            Route::post('/', [SubCategoryController::class, 'store'])->name('store');
            Route::get('/{subCategory}/edit', [SubCategoryController::class, 'edit'])->name('edit');
            Route::put('/{subCategory}/update', [SubCategoryController::class, 'update'])->name('update');
            Route::delete('/{subCategory}', [SubCategoryController::class, 'destroy'])->name('delete');
        });


        // Tag Routes
        Route::prefix('tag')->name('tags.')->group(function () {
            Route::get('/create', [TagController::class, 'create'])->name('create');
            Route::post('/', [TagController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [TagController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [TagController::class, 'update'])->name('update');
            Route::delete('/{id}', [TagController::class, 'destroy'])->name('delete');
        });


        // Post Routes
        Route::prefix('post')->name('posts.')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('index');
            Route::get('/create', [PostController::class, 'create'])->name('create');
            Route::post('/', [PostController::class, 'store'])->name('store');
            Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
            Route::put('/{post}/update', [PostController::class, 'update'])->name('update');
            Route::delete('/{post}', [PostController::class, 'destroy'])->name('delete');
        });

        // Comments Routes
        Route::prefix('comments')->name('comment.')->group(function () {
            Route::get('/', [AdPanelCommentController::class, 'AdminComments'])->name('AdminComments');
            Route::get('/{comment}/edit', [AdPanelCommentController::class, 'editComment'])->name('editComment');
            Route::post('/{comment}/update', [AdPanelCommentController::class, 'updateComment'])->name('updateComment');
            Route::delete('/{comment}', [AdPanelCommentController::class, 'destroyComment'])->name('destroyComment');
        });
    });
});


/* ------------------------------ Editor Routes ---------------------------------- */

Route::group(['prefix' => 'editor'], function () {
    Route::group(['middleware' => 'editor.guest'], function () {
        Route::get('login', [EditorController::class, 'index'])->name('editor.login');
        Route::post('authenticate', [EditorController::class, 'authenticate'])->name('editor.authenticate');
    });

    Route::group(['middleware' => 'editor.auth'], function () {

        // Auth Route
        Route::name('editor.')->group(function () {
            Route::get('dashboard', [EditorController::class, 'dashboard'])->name('dashboard');
            Route::get('/{user}/edit', [EditorController::class, 'edit'])->name('edit');
            Route::put('/{user}/update', [EditorController::class, 'update'])->name('update');
            Route::get('logout', [EditorController::class, 'logout'])->name('logout');
            Route::get('/change-password', [EditorController::class, 'showChangePassword'])->name('changePassword');
            Route::post('/process-change-password', [EditorController::class, 'changePassword'])->name('processChangePassword');
        });

        // Category Routes
        Route::prefix('category')->name('ed-categories.')->group(function () {
            Route::get('/create', [EditorCategoryController::class, 'create'])->name('create');
            Route::post('/', [EditorCategoryController::class, 'store'])->name('store');
            Route::get('/{category}/edit', [EditorCategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}/update', [EditorCategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [EditorCategoryController::class, 'destroy'])->name('delete');
        });

        // Sub Category Routes
        Route::prefix('sub-category')->name('editor-sub-categories.')->group(function () {
            Route::get('/', [EditorSubCategoryController::class, 'index'])->name('index');
            Route::get('/create', [EditorSubCategoryController::class, 'create'])->name('create');
            Route::post('/', [EditorSubCategoryController::class, 'store'])->name('store');
            Route::get('/{subCategory}/edit', [EditorSubCategoryController::class, 'edit'])->name('edit');
            Route::put('/{subCategory}/update', [EditorSubCategoryController::class, 'update'])->name('update');
            Route::delete('/{subCategory}', [EditorSubCategoryController::class, 'destroy'])->name('delete');
        });


        // Tag Routes
        Route::prefix('tag')->name('editor-tags.')->group(function () {
            Route::get('/create', [EditorTagController::class, 'create'])->name('create');
            Route::post('/', [EditorTagController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [EditorTagController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [EditorTagController::class, 'update'])->name('update');
            Route::delete('/{id}', [EditorTagController::class, 'destroy'])->name('delete');
        });



        // Post Routes
        Route::prefix('post')->name('editor-posts.')->group(function () {
            Route::get('/', [EditorPostController::class, 'index'])->name('index');
            Route::get('/create', [EditorPostController::class, 'create'])->name('create');
            Route::post('/', [EditorPostController::class, 'store'])->name('store');
            Route::get('/{post}/edit', [EditorPostController::class, 'edit'])->name('edit');
            Route::put('/{post}/update', [EditorPostController::class, 'update'])->name('update');
            Route::delete('/{post}', [EditorPostController::class, 'destroy'])->name('delete');
        });

        // Comments Routes
        Route::prefix('comments')->name('comment.')->group(function () {
            Route::get('/', [EdPanelCommentController::class, 'index'])->name('index');
            Route::get('/{comment}/edit', [EdPanelCommentController::class, 'edit'])->name('edit');
            Route::post('/{comment}/update', [EdPanelCommentController::class, 'update'])->name('update');
            Route::delete('/{comment}', [EdPanelCommentController::class, 'destroy'])->name('destroy');
        });
    });
});
