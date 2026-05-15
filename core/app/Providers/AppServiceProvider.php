<?php

namespace App\Providers;

use App\Constants\Status;
use App\Lib\Searchable;
use App\Models\AdminNotification;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\Job;
use App\Models\JobBid;
use App\Models\Service;
use App\Models\Software;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Builder::mixin(new Searchable);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!cache()->get('SystemInstalled')) {
            $envFilePath = base_path('.env');
            if (!file_exists($envFilePath)) {
                header('Location: install');
                exit;
            }
            $envContents = file_get_contents($envFilePath);
            if (empty($envContents)) {
                header('Location: install');
                exit;
            } else {
                cache()->put('SystemInstalled', true);
            }
        }


        $viewShare['emptyMessage'] = 'Data not found';
        view()->share($viewShare);


        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'             => User::banned()->count(),
                'emailUnverifiedUsersCount'    => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'   => User::mobileUnverified()->count(),
                'kycUnverifiedUsersCount'      => User::kycUnverified()->count(),
                'kycPendingUsersCount'         => User::kycPending()->count(),
                'pendingTicketCount'           => SupportTicket::whereIN('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])->count(),
                'pendingDepositsCount'         => Deposit::pending()->count(),
                'pendingWithdrawCount'         => Withdrawal::pending()->count(),
                'pendingServiceCount'          => Service::pending()->count(),
                'pendingJobCount'              => Job::pending()->count(),
                'pendingSoftwareCount'         => Software::pending()->count(),
                'pendingServiceBookingCount'   => Booking::where('service_id', '!=', 0)->pending()->count(),
                'disputedServiceBookingCount'  => Booking::where('service_id', '!=', 0)->disputed()->count(),
                'pendingJobBookingCount'       => 0,
                'disputedJobBookingCount'      => JobBid::disputed()->count(),

                'updateAvailable'    => version_compare(gs('available_version'), systemDetails()['version'], '>') ? 'v' . gs('available_version') : false,
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications' => AdminNotification::where('is_read', Status::NO)->with('user')->orderBy('id', 'desc')->take(10)->get(),
                'adminNotificationCount' => AdminNotification::where('is_read', Status::NO)->count(),
            ]);
        });

        view()->composer(
            [
                "Template::partials.filter",
                "Template::partials.footer",
                "Template::partials.header"
            ],
            function ($view) {
                $view->with([
                    'categories' => Category::active()
                        ->orderBy('name')
                        ->get()
                ]);
            }
        );

        view()->composer("Template::partials.seller_sidebar", function ($view) {
            if (Auth::check()) {
                $pendingServiceBookingCount = Booking::paid()->where('seller_id', Auth::id())
                    ->where('service_id', '!=', 0)
                    ->pending()
                    ->count();
            } else {
                $pendingServiceBookingCount = 0;
            }

            $view->with([
                'pendingServiceBookingCount' => $pendingServiceBookingCount,
            ]);
        });


        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if (gs('force_ssl')) {
            \URL::forceScheme('https');
        }


        Paginator::useBootstrapFive();
    }
}
