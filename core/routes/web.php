<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

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

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');


Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    Route::post('subscribe', 'subscribe')->name('subscribe');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->withoutMiddleware('maintenance')->name('placeholder.image');
    Route::get('maintenance-mode', 'maintenance')->withoutMiddleware('maintenance')->name('maintenance');

    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});


//campaigns
Route::controller('CampaignController')->prefix('campaign')->name('campaign.')->group(function () {
    Route::get('index', 'index')->name('index');
    Route::get('campaign', 'filterCampaign')->name('filter');
    Route::get('explore/{slug}', 'details')->name('details');
    Route::get('widget/{id}', 'widget')->name('widget');
    Route::get('details/{id}', 'daanDetails')->name('daan_details');
    Route::get('all', 'getAllCampaigns')->name('all');
    // API route to fetch donation progress dynamically
    Route::get('progress/{id}', 'getCampaignProgress')->name('progress');

    // Store Campaign (Handles Video Upload)
    Route::post('store', 'store')->name('store');

    // Comment
    Route::post('comment', 'comment')->name('comment');
    Route::get('thanks/{slug}', 'thanksMessage')->name('thanks');
});

//user-org-profile//
Route::controller('ProfileController')->prefix('profile')->name('profile.')->group(function () {
    Route::get('{username}', 'index')->name('index');
    Route::get('info/{username}', 'info')->name('info');
    Route::get('award/{username}', 'award')->name('award');
    Route::get('donor/{username}', 'donor')->name('donor');
    Route::get('update/{username}', 'update')->name('update');
});


Route::controller('SuccessStoryController')->prefix('success-story')->name('success.story.')->group(function () {
    Route::get('stories', 'index')->name('archive');
    Route::get('details/{slug}/{id}', 'details')->name('details');
    Route::post('comment/{storyId}', 'comment')->name('comment');
});


Route::controller('VolunteerController')->prefix('volunteer')->name('volunteer.')->group(function () {
    Route::get('join-as/volunteer', 'form')->name('form');
    Route::post('store', 'store')->name('store');
    Route::get('index', 'index')->name('index');
    Route::get('search/filter', 'filter')->name('filter');
});

// Payment
Route::prefix('deposit')->name('deposit.')->controller('Gateway\PaymentController')->group(function () {
    Route::any('/index', 'deposit')->name('index');
    Route::post('insert', 'depositInsert')->name('insert');
    Route::get('confirm', 'depositConfirm')->name('confirm');
    Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
    Route::post('manual', 'manualDepositUpdate')->name('manual.update');
});

Route::controller('DonationController')->prefix('campaign/donation')->name('campaign.donation.')->group(function () {
    Route::post('/{slug?}/{id?}', 'donation')->name('process');
});
