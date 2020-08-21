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

mix
    .js('resources/js/user/role/index.js', 'public/js/user/role/index.js')
    .js('resources/js/user/menu/index.js', 'public/js/user/menu/index.js')
    .js('resources/js/user/user/index.js', 'public/js/user/user/index.js')
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
