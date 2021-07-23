const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.js([
        'resources/js/app.js',
        'resources/js/admin.js',
    ], 'public/js')
    .js('resources/js/client/home.js', 'public/js/client')
    .js('resources/js/admin/home.js', 'public/js/admin')
    .js(['resources/js/client/lib/popper.min.js',
        'resources/js/client/lib/isotope.min.js',
        'resources/js/client/lib/baguetteBox.min.js',
        'resources/js/client/lib/jquery.superslides.min.js',
        'resources/js/client/lib/images-loded.min.js',
        'resources/js/client/lib/custom.js',
        'resources/js/client/lib/form-validator.min.js',
    ], 'public/js/client/alllib.js')
    .copy('resources/js/client/lib/tiny-slider.js', 'public/js/client/')
    .copy('resources/js/client/lib/jquery.min.js', 'public/js/client/')
    .copy('resources/js/client/lib/bootstrap.min.js', 'public/js/client/')
    .sass('resources/sass/app.scss', 'public/css')
    .styles([
        'resources/css/base.css',
        'resources/css/main.css',
        'resources/css/dashboard.css',
    ], 'public/css/style.css')
    .copy('resources/css/lib/tiny-slider.css', 'public/css/client/')
    .styles([
        'resources/css/lib/animate.css',
        'resources/css/lib/baguetteBox.min.css',
        'resources/css/lib/custom.css',
        'resources/css/lib/classic.css',
        'resources/css/lib/responsive.css',
        'resources/css/lib/style.css',
        'resources/css/lib/superslides.css',
    ], 'public/css/client/alllib.css')
    .copy('resources/img/', 'public/storage/img');
