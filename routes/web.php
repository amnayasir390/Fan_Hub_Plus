<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\MultimediaController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminContentController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminMediaController;
use App\Http\Controllers\Admin\AdminCharacterController;
use App\Http\Controllers\Admin\AdminMerchandiseController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminFeedbackController;
use App\Http\Controllers\Admin\AdminChatbotController;
use App\Http\Controllers\Admin\AdminUserController;

// ─── Public Routes ────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// Content Explorer
Route::get('/explore', [ContentController::class, 'index'])->name('content.index');
Route::get('/explore/{slug}', [ContentController::class, 'show'])->name('content.show');
Route::get('/category/{slug}', [ContentController::class, 'byCategory'])->name('content.category');

// Multimedia Center
Route::get('/multimedia', [MultimediaController::class, 'index'])->name('multimedia.index');
Route::get('/multimedia/{id}', [MultimediaController::class, 'show'])->name('multimedia.show');

// Characters
Route::get('/characters', [CharacterController::class, 'index'])->name('characters.index');
Route::get('/characters/{slug}', [CharacterController::class, 'show'])->name('characters.show');

// Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Merchandise
Route::get('/merchandise', [MerchandiseController::class, 'index'])->name('merchandise.index');
Route::get('/merchandise/{slug}', [MerchandiseController::class, 'show'])->name('merchandise.show');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// Feedback (public form)
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

// ─── Authentication Routes ─────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

// ─── Email Verification ────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

// ─── Authenticated Routes ──────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Bookmarks
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks/toggle', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::delete('/bookmarks/{id}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::patch('/bookmarks/{id}/note', [BookmarkController::class, 'updateNote'])->name('bookmarks.note');

    // Media ratings
    Route::post('/multimedia/{id}/rate', [MultimediaController::class, 'rate'])->name('multimedia.rate');

    // Fan submissions
    Route::get('/articles/submit', [ArticleController::class, 'submitForm'])->name('articles.submit');
    Route::post('/articles/submit', [ArticleController::class, 'submitStore'])->name('articles.submit.store');

    // Chatbot
    Route::post('/chatbot/message', [ChatbotController::class, 'message'])->name('chatbot.message');
    Route::get('/chatbot/history', [ChatbotController::class, 'history'])->name('chatbot.history');
});

// ─── Admin Routes ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Content
    Route::resource('content', AdminContentController::class);

    // Articles + Fan Submissions
    Route::resource('articles', AdminArticleController::class);
    Route::get('submissions', [AdminArticleController::class, 'submissions'])->name('submissions.index');
    Route::post('submissions/{submission}/approve', [AdminArticleController::class, 'approveSubmission'])->name('submissions.approve');
    Route::post('submissions/{submission}/reject', [AdminArticleController::class, 'rejectSubmission'])->name('submissions.reject');

    // Media
    Route::resource('media', AdminMediaController::class);

    // Characters
    Route::resource('characters', AdminCharacterController::class);

    // Merchandise
    Route::resource('merchandise', AdminMerchandiseController::class);

    // Events
    Route::resource('events', AdminEventController::class);

    // Feedback
    Route::get('feedback', [AdminFeedbackController::class, 'index'])->name('feedback.index');
    Route::get('feedback/{feedback}', [AdminFeedbackController::class, 'show'])->name('feedback.show');
    Route::patch('feedback/{feedback}', [AdminFeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('feedback/{feedback}', [AdminFeedbackController::class, 'destroy'])->name('feedback.destroy');

    // Chatbot FAQs
    Route::resource('chatbot', AdminChatbotController::class);

    // Users
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.role');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});
