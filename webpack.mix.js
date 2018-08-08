let mix = require('laravel-mix');

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

/*mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');*/

var assetsDir = 'resources/assets';
var bowerDir = assetsDir + '/bower/';
var cssDir = assetsDir + '/css/';
var jsDir = assetsDir + '/js/';
var lessDir = assetsDir + '/less/';

mix.less(lessDir + 'shiftmgr.less', '../resources/assets/css/shiftmgr.css'); //compiled to shiftmgr.css

mix.styles([
        bowerDir + 'bootstrap/dist/css/bootstrap.min.css',
        bowerDir + 'font-awesome/css/font-awesome.min.css',
        bowerDir + 'Ionicons/css/ionicons.min.css'
    ], 'public/css/vendor.min.css');

    mix.styles([        
        bowerDir + 'admin-lte/dist/css/AdminLTE.min.css',
        cssDir + 'shiftmgr.css',//from less
        cssDir + 'styles.css'
    ], 'public/css/app.min.css');

    mix.scripts([
        bowerDir + 'jquery/dist/jquery.min.js',
        bowerDir + 'bootstrap/dist/js/bootstrap.min.js'
    ], 'public/js/vendor.min.js');

    mix.scripts([
        bowerDir + 'admin-lte/dist/js/adminlte.min.js',
        bowerDir + 'initial.js/dist/initial.min.js',
        jsDir + 'scripts.js'
    ], 'public/js/app.min.js');

    //copy fonts
    mix.copy(bowerDir + 'bootstrap/fonts', 'public/fonts');
    mix.copy(bowerDir + 'Ionicons/fonts', 'public/fonts');
    mix.copy(bowerDir + 'font-awesome/fonts', 'public/fonts');

    //version files
    //mix.version(['css/vendor.min.css', 'js/vendor.min.js', 'css/app.min.css', 'js/app.min.js']);