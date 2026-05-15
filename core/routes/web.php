<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::post('pusher/auth', 'SiteController@pusher')->name('pusher.auth');

Route::get('cron', 'CronController@cron')->name('cron');

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{id}', 'replyTicket')->name('reply');
    Route::post('close/{id}', 'closeTicket')->name('close');
    Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
});


Route::controller('SearchController')->group(function () {
    Route::get('search', 'search')->name('search');
    Route::get('filter', 'filter')->name('filter');
});


// Fetch More Operations
Route::controller('FetchController')->prefix('fetch')->name('fetch.')->group(function () {
    Route::get('reviews/{id}', 'fetchReviews')->name('reviews');
    Route::get('comments/{id}', 'fetchComments')->name('comments');
    Route::get('featured/services', 'fetchFeaturedServices')->name('featured.services');
    Route::get('products', 'fetchProducts')->name('products');
});

Route::controller('ItemController')->group(function () {

    // Services
    Route::get('service', 'service')->name('service');
    Route::get('service/details/{slug}/{id}', 'serviceDetails')->name('service.details');

    // Software
    Route::get('software', 'software')->name('software');
    Route::get('software/details/{slug}/{id}', 'softwareDetails')->name('software.details');

    // Job
    Route::get('job', 'job')->name('job');
    Route::get('job/details/{slug}/{id}', 'jobDetails')->name('job.details');

    Route::get('user/{username}', 'publicProfile')->name('public.profile');
    Route::get('category/{slug}/{id}', 'categoryWiseProduct')->name('category.wise.product');
    Route::get('subcategory/{slug}/{id}', 'subcategoryWiseProduct')->name('subcategory.wise.product');
});



Route::controller('SiteController')->group(function () {
    Route::get('adRedirect/{id}', 'adRedirect')->name('adRedirect');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');

    Route::post('subscriber', 'subscriberStore')->name('subscriber.store');


    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('blog', 'blogs')->name('blogs');
    Route::get('blog/{slug}', 'blogDetails')->name('blog.details');

    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image')->withoutMiddleware('maintenance');

    Route::get('file-download/{fileName}/{type}', 'fileDownload')->name('file.download');
    Route::get('maintenance-mode', 'maintenance')->withoutMiddleware('maintenance')->name('maintenance');
    Route::get('/', 'index')->name('home');
});
