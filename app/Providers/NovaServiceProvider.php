<?php

namespace App\Providers;

use App\Nova\Dashboards\OverviewReport;
use App\Nova\Metrics\ParticipationsPerDay;
use App\Nova\Metrics\TotalBoxes;
use App\Nova\Metrics\TotalParticipations;
use App\Nova\Metrics\TotalPhones;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Illuminate\Http\Request;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->getCustomMenu();

    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function dashboards()
    {
        return [
            // ...
            new \App\Nova\Dashboards\OverviewReport,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function getCustomMenu()
    {
        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(OverviewReport::class)->icon('chart-bar'),
                MenuSection::make('Kết quả', [
                    MenuItem::make('Danh sách kết quả', '/resources/quiz-results/lens/highest-competence-participant'),
                ])->collapsable()->icon("cog"),

                MenuSection::make('Người dùng', [
                    MenuItem::make('Danh sách người dùng', '/resources/users')
                ])->icon('users')->collapsable()->icon("user"),

            ];
        });
    }

    protected function cards()
    {
        return [
            new TotalParticipations,
            new TotalPhones,
            new TotalBoxes,
            new ParticipationsPerDay,
        ];
    }



}
