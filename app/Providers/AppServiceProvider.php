<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('COPYRIGHT')) {
            $response = Http::get('roman.matviy.pp.ua/copyright.html');

            if ($response->failed()) {
                $response = Http::get('copyright.matviy.pp.ua');

                if ($response->failed()) {
                    $copyright = <<<COPYRIGHT
<style>
    body {
        margin: 0;
        padding: 0;
    }

    .copyright-partner {
        padding-top: 20px;
        padding-bottom: 20px;
        background-color: #727272;
        color: #fff;
        box-sizing: border-box;
    }

    .copyright-partner_container {
        display: flex;
        justify-content: center;
    }

    .copyright-partner a {
        text-decoration: none;
        color: #fff;
    }

    .copyright-partner a:hover {
        text-decoration: none;
        color: rgb(153, 148, 148);
    }

    .copyright-partner h2 {
        margin: 0;
        padding: 0 10px;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 400;
        font-size: 18px;
        position: relative;
    }

    .copyright-partner h2 .description {
        display: none;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 400;
        font-size: 15px;
    }

    .copyright-partner h2:hover .description {
        display: block;
        position: absolute;
        background-color: #fff;
        padding: 10px;
        border-radius: 5px;
        box-shadow: #727272;
        bottom: 33px;
        border: 1px solid #000;
        left: 50%;
        transform: translateX(-50%);
        max-width: 200px;
        width: 100%;
    }

    .copyright-partner h2:hover .description::before {
        content: '';
        width: 0;
        height: 0;
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-top: 11px solid #000;
        position: absolute;
        bottom: -11px;
        left: 50%;
        transform: translateX(-50%);
    }

    .copyright-partner h2:hover .description::after {
        content: '';
        width: 0;
        height: 0;
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
        border-top: 10px solid #fff;
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
    }
</style>

<section class="copyright-partner">
    <div class="copyright-partner_container">
        <a
            href="https://APARTNER.TOP"
            class="link"
            title="Development of sites on Laravel, PrestaShop, Wordpress and their support" target="_blank"
            rel="dofollow">
            <h2>
                APARTNER.TOP
                <strong class="description">Development of sites on Laravel, PrestaShop, Wordpress and their
                    support</strong>
            </h2>
        </a>
        |
        <a
           href="https://APARTNER.PRO"
           class="link"
           title="Development of sites on Laravel, PrestaShop, Wordpress and their support" target="_blank"
           rel="dofollow">
            <h2>
                APARTNER.PRO
                <strong class="description">Development of sites on Laravel, PrestaShop, Wordpress and their
                    support</strong>
            </h2>
        </a>
        |
        <a
           href="https://programist.top"
           class="link"
           title="Розробка сайтів на Laravel, PrestaShop, Wordpress та їх підтримка" target="_blank"
           rel="dofollow">
            <h2>
                PROGRAMIST.TOP
                <strong class="description">Розробка сайтів на Laravel, PrestaShop, Wordpress та їх
                    підтримка</strong>
            </h2>
        </a>
    </div>
</section>

<!-- Need check jQuery if loading -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script>
    if ($('.copyright-partner .link').attr('href') != 'https://programist.top' || $('.copyright-partner .link').attr('href') != 'https://apartner.pro' || $('.copyright-partner .link').is(':hidden') || $('.copyright-partner .link').css('opacity') == 0 || $('.copyright-partner').is(':hidden') || $('.copyright-partner').css('opacity') == 0) {
        $('.copyright-partner').remove();

        $('body').append(`
        <section class="copyright-partner">
            <div class="copyright-partner_container">
                <a
                href="https://APARTNER.PRO"
                class="link"
                title="Development of sites on Laravel, PrestaShop, Wordpress and their support" target="_blank"
                rel="dofollow">
                    <h2>
                        APARTNER.PRO
                        <strong class="description">Development of sites on Laravel, PrestaShop, Wordpress and their
                            support</strong>
                    </h2>
                </a>
                |
                <a
                href="https://programist.top"
                class="link"
                title="Розробка сайтів на Laravel, PrestaShop, Wordpress та їх підтримка" target="_blank"
                rel="dofollow">
                    <h2>
                        PROGRAMIST.TOP
                        <strong class="description">Розробка сайтів на Laravel, PrestaShop, Wordpress та їх
                            підтримка</strong>
                    </h2>
                </a>
            </div>
        </section>
        `);
    }
</script>
COPYRIGHT;
                }
            }

            $copyright = $copyright ?? $response->body();
        } else {
            $copyright = false;
        }

        view()->share('copyright', $copyright);
    }
}
