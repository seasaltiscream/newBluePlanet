<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'homePage']);
// Route::get('/', [HomeController::class, 'homePage'])->name('home');
Route::get('/home', [PostController::class, 'homePage'])->name('homePage');
Route::get('/adminhome', [AdminController::class, 'adminhome']);
// Route::get('/homePage', [HomeController::class, 'index'])->name('homePage');



// Middleware for authenticated routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Ensure this view exists
    })->name('dashboard');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Other routes
Route::get('/post_page', [AdminController::class, 'post_page']);    //add post page
Route::post('/add_post', [AdminController::class, 'add_post']);
Route::get('/show_post', [AdminController::class, 'show_post']);
Route::get('/delete_post/{id}', [AdminController::class, 'delete_post']);
Route::get('/edit_post/{id}', [AdminController::class, 'edit_post']);
Route::post('/update_post/{id}', [AdminController::class, 'update_post']);
Route::get('/accept_post/{id}', [AdminController::class, 'accept_post']);
Route::get('/reject_post/{id}', [AdminController::class, 'reject_post']);

// Routes for managing forms
Route::get('/form_page', [AdminController::class, 'form_page']); // Show form page
Route::post('/add_form', [AdminController::class, 'add_form']); // Add new form
Route::get('/show_form', [AdminController::class, 'show_form']); // Display all forms
Route::get('/delete_form/{id}', [AdminController::class, 'delete_form']); // Delete form
Route::get('/edit_form_page/{id}', [AdminController::class, 'edit_form_page']); // Edit form page
Route::post('/update_form/{id}', [AdminController::class, 'update_form']); // Update form details
Route::get('/accept_form/{id}', [AdminController::class, 'accept_form']); // Accept form
Route::get('/reject_form/{id}', [AdminController::class, 'reject_form']); // Reject form
Route::get('/admin_profile', [ProfileController::class, 'admin_profile'])->middleware('auth');
Route::get('/edit_admin', [ProfileController::class, 'edit_admin'])->middleware('auth');
Route::post('/updateAdmin', [ProfileController::class, 'updateAdmin'])->middleware('auth');



Route::get('/post_details/{id}', [HomeController::class, 'post_details']);
Route::get('/create_post', [HomeController::class, 'create_post'])->middleware('auth');
Route::post('/user_post', [HomeController::class, 'user_post']);
Route::get('/my_post', [HomeController::class, 'my_post'])->middleware('auth');
Route::get('/deleteUserPost/{id}', [HomeController::class, 'deleteUserPost'])->middleware('auth');
Route::get('/update_user_post/{id}', [HomeController::class, 'update_user_post'])->middleware('auth');
Route::post('/update_postData/{id}', [HomeController::class, 'update_postData'])->middleware('auth');
Route::get('/about_us', [HomeController::class, 'about_us']);
Route::get('/blog_posts', [HomeController::class, 'blog_posts']);
Route::get('/volunteer_posts', [HomeController::class, 'volunteer_posts']);
Route::get('/create_form', [HomeController::class, 'create_form'])->middleware('auth');
Route::get('/my_form', [HomeController::class, 'my_form'])->middleware('auth');
Route::post('/user_form', [HomeController::class, 'user_form']);
Route::get('/deleteForm/{id}', [HomeController::class, 'deleteForm'])->middleware('auth');
Route::get('/update_user_form/{id}', [HomeController::class, 'update_user_form'])->middleware('auth');
Route::post('/update_formData/{id}', [HomeController::class, 'update_formData'])->middleware('auth');
Route::get('delete_youtube_link/{id}', [HomeController  ::class, 'deleteYoutubeLink']);
Route::get('resetThumb/{id}', [AdminController::class, 'resetThumb']);
Route::get('/resetFormImage/{id}', [AdminController::class, 'resetFormImage']);
Route::get('/resetThumb/{id}', [HomeController::class, 'resetThumb']);
Route::get('/deleteYoutubeLink/{id}', [HomeController::class, 'deleteYoutubeLink']);




Route::get('/user_profile', [ProfileController::class, 'user_profile'])->middleware('auth');
Route::get('/edit_profile', [ProfileController::class, 'edit_profile'])->middleware('auth');
Route::post('/update_profile', [ProfileController::class, 'update_profile'])->middleware('auth');
