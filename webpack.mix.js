let mix = require("laravel-mix");

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

var assetsDir = "resources/assets";
var nodeDir = "node_modules/";
var cssDir = assetsDir + "/css/";
var jsDir = assetsDir + "/js/";
var lessDir = assetsDir + "/less/";

mix.less(lessDir + "shiftmgr.less", "../resources/assets/css/shiftmgr.css"); //compiled to shiftmgr.css

mix.styles(
    [
        nodeDir + "bootstrap/dist/css/bootstrap.min.css",
        nodeDir + "font-awesome/css/font-awesome.min.css",
        nodeDir + "ionicons/dist/css/ionicons.min.css"
    ],
    "public/css/vendor.min.css"
);

mix.styles(
    [
        nodeDir + "adminlte/dist/css/AdminLTE.min.css",
        cssDir + "shiftmgr.css", //from less
        cssDir + "styles.css"
    ],
    "public/css/app.min.css"
);

mix.scripts(
    [
        nodeDir + "jquery/dist/jquery.min.js",
        nodeDir + "bootstrap/dist/js/bootstrap.min.js"
    ],
    "public/js/vendor.min.js"
);

mix.scripts(
    [
        nodeDir + "adminlte/dist/js/adminlte.min.js",
        nodeDir + "initial-js/dist/initial.min.js",
        jsDir + "scripts.js"
    ],
    "public/js/app.min.js"
);

//copy fonts
mix.copy(nodeDir + "bootstrap/fonts", "public/fonts");
mix.copy(nodeDir + "ionicons/dist/fonts", "public/fonts");
mix.copy(nodeDir + "font-awesome/fonts", "public/fonts");

//version files
//mix.version(['css/vendor.min.css', 'js/vendor.min.js', 'css/app.min.css', 'js/app.min.js']);
