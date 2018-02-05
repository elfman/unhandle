<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Observers\AnswerObserver;
use App\Observers\QuestionObserver;
use App\Observers\UserObserver;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Question::observe(QuestionObserver::class);
        Answer::observe(AnswerObserver::class);

        Carbon::setLocale('zh');
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
}
