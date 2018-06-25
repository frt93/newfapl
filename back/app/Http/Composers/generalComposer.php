<?php namespace App\Http\Composers;

use Illuminate\Support\Facades\Lang;

class generalComposer {

    public function compose($view)
    {
        $providers = collect([
            ['name' => 'vk', 'route' => route('socialite.auth', 'vkontakte') ],
            ['name' => 'google', 'route' => route('socialite.auth', 'google') ],
            ['name' => 'facebook', 'route' => route('socialite.auth', 'facebook') ],
            ['name' => 'twitter', 'route' => route('socialite.auth', 'twitter') ],
            ['name' => 'yandex', 'route' => route('socialite.auth', 'yandex') ],
        ]);

        $authLabels = collect([
            'login' => Lang::get('auth.loginLabel'),
            'pass' => Lang::get('auth.passwordLabel'),
            'remember' => Lang::get('auth.rememberLabel'),
            'signin' => Lang::get('auth.signInLabel'),
            'forgot' => Lang::get('auth.forgotPasswordLabel'),
            'show' => Lang::get('auth.showPasswordLabel'),
            'wait' => Lang::get('auth.waitLabel'),
            'retry' => Lang::get('auth.retry'),
            'shortPass' => Lang::get('auth.shortPassword'),
            'shortUser' => Lang::get('auth.shortUsername'),
        ]);

        $authRoutes = collect ([
            'signin' => route('ajax.signin'),
            'signup' => route('signup'),
            'forgot' => route('password.request'),
            'check' => route('check.auth'),
        ]);

        $view->with([
            'providers' => $providers,
            'labels' => $authLabels,
            'authRoutes' => $authRoutes
        ]);
    }
}