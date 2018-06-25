<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeFormVariables();
        $this->composeThreeStageFilter();
        $this->composeInfinitePagination();
        $this->composeIndex();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Compose the variables for create/edit pages
     */
    private function composeFormVariables(): void
    {
        view()->composer('articles.partials._form', 'App\Http\Composers\ArticleFormComposer');
    }

    /**
     * Compose the competitions, clubs and players lists for filter block an /article page
     */
    private function composeThreeStageFilter(): void
    {
        view()->composer('articles.index', 'App\Http\Composers\threeStageFilterComposer');
    }

    private function composeInfinitePagination(): void
    {
        view()->composer('articles.index', 'App\Http\Composers\infinitePaginationComposer');
    }

    private function composeIndex(): void
    {
        view()->composer('index', 'App\Http\Composers\generalComposer');
    }
}
