<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

  /**
   * All of the container bindings that should be registered.
   *
   * @var array
   */
    public $bindings = [

    ];

    /**
    * Indicates if loading of the provider is deferred.
    *
    * @var bool
    */
    protected $defer = false;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->when('App\Services\AuthorService')
          ->needs('App\Eloquent\Contracts\PersonInterface')
          ->give('App\Eloquent\Repositories\AuthorRepository');

        $this->app->when('App\Services\NarratorService')
          ->needs('App\Eloquent\Contracts\PersonInterface')
          ->give('App\Eloquent\Repositories\NarratorRepository');

        $this->app->when('App\Services\HadithService')
          ->needs('App\Eloquent\Contracts\PersonInterface')
          ->give('App\Eloquent\Repositories\NarratorRepository');

        $this->app->when('App\Services\BioAuthorService')
          ->needs('App\Eloquent\Contracts\PersonInterface')
          ->give('App\Eloquent\Repositories\BioAuthorRepository');

        $this->app->when('App\Services\CommentatorService')
          ->needs('App\Eloquent\Contracts\PersonInterface')
          ->give('App\Eloquent\Repositories\CommentatorRepository');

        $this->app->bind(
          'App\Eloquent\Contracts\BookInterface',
          'App\Eloquent\Repositories\BookRepository'
        );

        $this->app->bind(
          'App\Eloquent\Contracts\BioBookInterface',
          'App\Eloquent\Repositories\BioBookRepository'
        );

        $this->app->bind(
          'App\Eloquent\Contracts\HadithInterface',
          'App\Eloquent\Repositories\HadithRepository'
        );

        $this->app->bind(
          'App\Eloquent\Contracts\HadithCommentInterface',
          'App\Eloquent\Repositories\HadithCommentRepository'
        );

        $this->app->bind(
          'App\Eloquent\Contracts\HadithTranslationInterface',
          'App\Eloquent\Repositories\HadithTranslationRepository'
        );

        $this->app->bind(
          'App\Eloquent\Contracts\BioInterface',
          'App\Eloquent\Repositories\BioRepository'
        );

        $this->app->bind(
          'App\Eloquent\Contracts\CommentaryInterface',
          'App\Eloquent\Repositories\CommentaryRepository'
        );

        $this->app->bind(
          'App\Eloquent\Contracts\SectionInterface',
          'App\Eloquent\Repositories\SectionRepository'
        );

        $this->app->bind(
          'App\Eloquent\Contracts\LanguageInterface',
          'App\Eloquent\Repositories\LanguageRepository'
        );
    }

}
