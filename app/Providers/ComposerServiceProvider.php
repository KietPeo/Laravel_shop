<?php

namespace App\Providers;

use App\Composers\CartComposer;
use App\Composers\CategoryComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Đăng ký dịch vụ.
     */
    public function register()
    {
        //
    }

    /**
     * Khởi động dịch vụ.
     */
    public function boot()
    {
        //kích hoạt biến cho view
        View::composer('client.layouts.app', CategoryComposer::class );
        View::composer('client2.layouts.nav', CategoryComposer::class );
        View::composer('client.layouts.app', CartComposer::class );
        View::composer('client2.layouts.index', CartComposer::class );
        View::composer('client2.layouts.index2', CartComposer::class );
    }
}
