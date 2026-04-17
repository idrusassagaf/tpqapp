<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;



use App\Models\Santri;
use App\Models\Guru;
use App\Models\Orangtua;
use App\Models\Berita;



class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('sidebarCounts', [
                'santri'   => Santri::count(),
                'guru'     => Guru::count(),
                'orangtua' => Orangtua::count(),
                'berita'   => Berita::count(),
            ]);
        });
    }
}
