<?php

use Illuminate\Support\Facades\Route;

Route::namespace('User\Auth')->name('user.')->middleware('guest')->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login'); // Normal Login
        Route::post('/login/ajax', 'loginAjax')->name('login.ajax'); // AJAX Login
        Route::get('logout', 'logout')->middleware('auth')->withoutMiddleware('guest')->name('logout');
    });

    Route::controller('RegisterController')->group(function () {
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

    Route::middleware(['check.status', 'registration.complete', 'set.user.type'])->group(function () {

        Route::namespace('User')->group(function () {

            Route::controller('UserController')->group(function () {
                Route::get('dashboard', 'home')->name('home');
                Route::get('success/{orderNumber}', 'success')->name('success');
                Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');

                // Work File Upload
                Route::post('work/file/upload/{orderNumberOrJobId}', 'workFileUpload')->name('work.upload');

                // Dispute
                Route::post('dispute/{orderNumberOrBidId}', 'dispute')->name('dispute');

                // Extra Image Remove
                Route::post('image-remove/{id}/{imageName}/{type}', 'removeExtraImage')->name('image.remove');


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

            //Profile setting
            Route::controller('ProfileController')->group(function () {
                Route::get('profile-setting', 'profile')->name('profile.setting');
                Route::post('profile-setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
                Route::get('referral-commission', 'referralCommission')->name('referral.commission');
            });

            Route::controller('ServiceBookingController')->name('service.')->prefix('service')->group(function () {
                Route::post('booking/booking/{id}', 'addBooking')->name('add.booking');
                Route::get('booking/confirm', 'confirmBooking')->name('confirm.booking');
                Route::get('coupon/apply', 'couponApply')->name('coupon.apply');
                Route::get('coupon/remove', 'couponRemove')->name('coupon.remove');
            });



            Route::controller('SoftwareBookingController')->name('software.')->prefix('software')->group(function () {
                Route::post('booking/booking/{id}', 'addBooking')->name('add.booking');
                Route::get('booking/confirm', 'confirmBooking')->name('confirm.booking');
                Route::get('coupon/apply', 'couponApply')->name('coupon.apply');
                Route::get('coupon/remove', 'couponRemove')->name('coupon.remove');
            });

            // Job Bid Store
            Route::post('job/bidding', 'JobBiddingController@store')->name('job.bidding.store');

            Route::prefix('chat')->name('chat.')->group(function () {
                Route::post('store', 'ChatController@store')->name('store');
                Route::get('refresh', 'ChatController@refresh')->name('refresh');
            });

            // Inbox Operation
            Route::controller('InboxController')->prefix('inbox')->name('inbox.')->group(function () {
                Route::get('messages/{uniqueId?}', 'messages')->name('messages');
                Route::post('create', 'create')->name('create');
                Route::post('message/store', 'storeMessage')->name('message.store');
                Route::get('messages/refresh/{uniqueId}', 'refreshMessages')->name('messages.refresh');
            });

            // Product Comment Operation
            Route::controller('CommentController')->prefix('comment')->name('comment.')->group(function () {
                Route::post('store', 'commentStore')->name('store');
                Route::post('reply/store', 'replyStore')->name('reply.store');
            });

            // Reviews
            Route::post('review/store', 'ReviewController@store')->name('review.store');
            Route::post('review/update/{id}', 'ReviewController@update')->name('review.update');
            Route::post('review/delete/{id}', 'ReviewController@delete')->name('review.delete');

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

        // Payment
        Route::prefix('deposit')->name('deposit.')->controller('Gateway\PaymentController')->group(function () {
            Route::any('/', 'deposit')->name('index');
            Route::post('insert/{orderNumber?}/{bookingId?}', 'depositInsert')->name('insert');
            Route::get('confirm', 'depositConfirm')->name('confirm');
            Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
            Route::post('manual', 'manualDepositUpdate')->name('manual.update');
        });

        // seller route
        Route::namespace('Seller')->name('seller.')->prefix('seller')->group(function () {
            Route::controller('SellerController')->group(function () {
                Route::get('dashboard', 'home')->name('home');
                Route::get('chartData', 'getTransactionChartData')->name('transactions.chartData');
                Route::get('job/list', 'jobList')->name('job.list');
                Route::get('job/details/{id}', 'jobDetails')->name('job.details');
            });


            //Seller - Service //
            Route::controller('ServiceController')->prefix('service')->name('service.')->group(function () {

                Route::get('basic/{id?}', 'basic')->name('basic');
                Route::post('store-basic/{id?}', 'storeBasic')->name('store.basic');

                Route::get('feature/{id?}', 'feature')->name('feature');
                Route::post('store-feature/{id?}', 'storeFeature')->name('store.feature');

                Route::get('gallery/{id}', 'gallery')->name('gallery');
                Route::post('store-gallery/{id}', 'storeGallery')->name('store.gallery');

                Route::get('extra/{id}', 'extra')->name('extra');
                Route::post('store-extra/{id}', 'storeExtraService')->name('store.extra');

                Route::get('index', 'index')->name('index');
                Route::post('extra-service/status/{serviceId}/{extraServiceId}', 'extraServiceStatus')->name('extra.service.status');
            });

            Route::controller('ServiceController')->name('booking.service.')->prefix('service/booking')->group(function () {
                Route::get('list', 'bookingList')->name('list');
                Route::post('confirm/{orderNumber}', 'bookingConfirm')->name('confirm');
                Route::post('cancel/{orderNumber}', 'bookingCancel')->name('cancel');
                Route::get('details/{orderNumber}', 'bookingDetails')->name('details');
            });


            // Seller Software Manage
            Route::controller('SoftwareController')->name('software.')->prefix('software')->group(function () {
                Route::get('basic/{id?}', 'basic')->name('basic');
                Route::post('store-basic/{id?}', 'storeBasic')->name('store.basic');

                Route::get('feature/{id?}', 'feature')->name('feature');
                Route::post('store-feature/{id?}', 'storeFeature')->name('store.feature');

                Route::get('gallery/{id}', 'gallery')->name('gallery');
                Route::post('store-gallery/{id}', 'storeGallery')->name('store.gallery');

                Route::get('document/{id}', 'document')->name('document');
                Route::post('store-document/{id}', 'storeDocument')->name('store.document');

                Route::get('index', 'index')->name('index');
            });

            // Softwares Sales Log
            Route::get('software/sale/logs', 'SoftwareController@salesLog')->name('sale.software.log');
        });


        // buyer route
        Route::namespace('Buyer')->name('buyer.')->prefix('buyer')->group(function () {
            Route::controller('BuyerController')->group(function () {
                Route::get('dashboard', 'home')->name('home');

                Route::name('booked.')->prefix('booked/services')->group(function () {
                    Route::get('/', 'bookedService')->name('services');
                    Route::get('details/{orderNumber}', 'bookedServiceDetails')->name('details');
                    Route::post('make/completed/{orderNumber}', 'serviceCompleted')->name('completed');
                });

                Route::get('software/purchase/log', 'softwarePurchase')->name('software.log');
            });


            // Buyer-job-create
            Route::controller('JobController')->name('job.')->prefix('job')->group(function () {
                Route::get('index', 'index')->name('index');

                Route::get('basic/{id?}', 'basic')->name('basic');
                Route::post('store-basic/{id?}', 'storeBasic')->name('store.basic');

                Route::get('gallery/{id?}', 'gallery')->name('gallery');
                Route::post('store-gallery/{id?}', 'storeGallery')->name('store.gallery');

                Route::get('skill/{id?}', 'skill')->name('skill');
                Route::post('store-skill/{id?}', 'storeSkill')->name('store.skill');

                Route::get('requirement/{id}', 'requirement')->name('requirement');
                Route::post('store-requirement/{id}', 'storeRequirement')->name('store.requirement');

                Route::post('close/{id}', 'close')->name('close');

                // Job Bidding List
                Route::get('bidding/list/{slug}/{id}', 'biddingList')->name('bidding.list');
                Route::post('approve/{id}', 'bidApprove')->name('bid.approve');
                Route::post('cancel/{id}', 'bidCancel')->name('bid.cancel');
            });


            Route::controller('JobController')->name('hiring.')->prefix('hiring')->group(function () {
                Route::get('list', 'hiringList')->name('list');
                Route::get('details/{id}', 'hiringDetails')->name('details');
                Route::post('make/completed/{id}', 'hiringCompleted')->name('completed');
            });

            // Favorite Products
            Route::controller('FavoriteController')->prefix('favorite')->name('favorite.')->group(function () {
                Route::get('store', 'store')->name('store');
                Route::get('service', 'service')->name('service');
                Route::get('software', 'software')->name('software');
            });
        });
    });
});
