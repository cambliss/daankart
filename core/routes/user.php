<?php

use Illuminate\Support\Facades\Route;

Route::namespace('User\Auth')->name('user.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::controller('LoginController')->group(function () {
            Route::get('/login', 'showLoginForm')->name('login');
            Route::post('/login', 'login');
            Route::get('logout', 'logout')->middleware('auth')->withoutMiddleware('guest')->name('logout');
        });

        Route::controller('RegisterController')->middleware(['guest'])->group(function () {
            Route::get('register', 'showRegistrationForm')->name('register');
            Route::post('register', 'register');
            Route::post('check-user', 'checkUser')->name('checkUser')->withoutMiddleware('guest');
        });

        Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
            Route::get('reset', 'showLinkRequestForm')->name('request');
            Route::post('email', 'sendResetCodeEmail')->name('email');
            Route::get('code-verify', 'codeVerify')->name('code.verify');
            Route::post('verify-code', 'verifyCode')->name('verify.code');
        });

        Route::controller('ResetPasswordController')->group(function () {
            Route::post('password/reset', 'reset')->name('password.update');
            Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
        });

        Route::controller('SocialiteController')->group(function () {
            Route::get('social-login/{provider}', 'socialLogin')->name('social.login');
            Route::get('social-login/callback/{provider}', 'callback')->name('social.login.callback');
        });
    });
});

Route::middleware('auth')->name('user.')->group(function () {

    Route::get('user-data', 'User\UserController@userData')->name('data');
    Route::post('user-data-submit', 'User\UserController@userDataSubmit')->name('data.submit');

    //authorization
    Route::middleware('registration.complete')->namespace('User')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify-g2fa', 'g2faVerification')->name('2fa.verify');
    });

    Route::middleware(['check.status', 'registration.complete'])->group(function () {

        Route::namespace('User')->group(function () {

            Route::controller('UserController')->group(function () {
                Route::get('dashboard', 'home')->name('home');
                Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');

                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                //KYC
                Route::get('kyc-form', 'kycForm')->name('kyc.form');
                Route::get('kyc-data', 'kycData')->name('kyc.data');
                Route::post('kyc-submit', 'kycSubmit')->name('kyc.submit');

                //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions', 'transactions')->name('transactions');

                Route::post('add-device-token', 'addDeviceToken')->name('add.device.token');
            });

            //Campaign Fundraise
            Route::controller('CampaignController')->prefix('campaign')->name('campaign.fundrise.')->group(function () {

                Route::get('fundrise', 'create')->name('create');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::post('store/{id?}', 'storeCampaign')->name('store');

                Route::get('approved', 'approvedCampaign')->name('approved');
                Route::get('pending', 'pendingCampaign')->name('pending');
                Route::get('success', 'completeCampaign')->name('complete');
                Route::get('expired', 'expiredCampaign')->name('expired');
                Route::get('rejected', 'rejectedCampaign')->name('rejected');
                Route::get('all', 'allCampaign')->name('all');


                Route::post('complete/{id}', 'complete')->name('make.complete');
                Route::post('stop/{id}', 'runAndStop')->name('stop');
                Route::post('delete/{id}', 'delete')->name('delete');
                Route::post('extended/{id}', 'extended')->name('extended');

                Route::get('update/{id}', 'campaignUpdation')->name('update');
                Route::post('update/store/{id}', 'campaignUpdationStore')->name('update.store');

                Route::get('seo/{id}', 'frontendSeo')->name('seo');
                Route::post('update/seo/{id}', 'frontendSeoUpdate')->name('update.seo');
            });

            Route::controller('FavoriteController')->name('favorite.')->prefix('favorite')->group(function () {
                Route::get('list', 'index')->name('index');
                Route::get('/add', 'add')->name('add');
            });

            Route::controller('DonationController')->prefix('campaign/donation')->name('campaign.donation.')->group(function () {
                Route::get('given/{campaignId?}', 'givenDonation')->name('given');
                Route::get('received/{campaignId?}', 'receivedDonation')->name('received');
                Route::get('details/{id}/{slug}', 'details')->name('details');

                Route::get('report/{campaignId}', 'donations')->name('report');
                Route::get('donor-report', 'donationReport')->name('donor.report');
            });


            //Profile setting
            Route::controller('ProfileController')->group(function () {
                Route::get('profile-setting', 'profile')->name('profile.setting');
                Route::post('profile-setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');

                //organization
                Route::get('profile-organization', 'organization')->name('profile.organization');
                Route::post('profile-organization', 'storeOrg')->name('profile.organization');

                //awards
                Route::get('organization-award', 'award')->name('org.award');
                Route::post('organization-award/{id?}', 'storeAward')->name('org.award');
                Route::post('org-award-delete/{id}', 'deleteAward')->name('org.award.delete');

                //Donor wall
                Route::get('organization-donor', 'donorWall')->name('org.donor');
                Route::post('organization-donor/{id?}', 'storeDonor')->name('org.donor');
                Route::post('award-delete/{id}', 'deleteDonor')->name('org.donor.delete');

                //Donor wall
                Route::get('org-update', 'organizationUpdate')->name('org.update');
                Route::post('org-update/{id?}', 'storeOrgUp')->name('org.update');
                Route::post('update/delete/{id}', 'deleteUpdate')->name('org.update.delete');
            });


            // Withdraw
            Route::controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function () {
                Route::middleware('kyc')->group(function () {
                    Route::get('/', 'withdrawMoney');
                    Route::post('/', 'withdrawStore')->name('.money');
                    Route::get('preview', 'withdrawPreview')->name('.preview');
                    Route::post('preview', 'withdrawSubmit')->name('.submit');
                });
                Route::get('history', 'withdrawLog')->name('.history');
            });
        });
    });
});
