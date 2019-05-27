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

//shifts-index

mix.styles(
  [
    nodeDir + "datatables.net-bs/css/dataTables.bootstrap.min.css",
    nodeDir + "chosen-js/chosen.min.css",
    nodeDir + "bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css",
    nodeDir + "jquery-confirm/dist/jquery-confirm.min.css"
  ],
  "public/css/shifts/index.min.css"
);

//copy css images
mix.copy(nodeDir + "chosen-js/chosen-sprite.png", "public/css/shifts");
mix.copy(nodeDir + "chosen-js/chosen-sprite@2x.png", "public/css/shifts");

mix.scripts(
  [
    nodeDir + "datatables.net/js/jquery.dataTables.min.js",
    nodeDir + "datatables.net-bs/js/dataTables.bootstrap.min.js",
    nodeDir + "moment/min/moment.min.js",
    nodeDir + "datatable-sorting-datetime-moment/index.js",
    nodeDir + "chosen-js/chosen.jquery.min.js",
    nodeDir + "bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js",
    nodeDir + "jquery-confirm/dist/jquery-confirm.min.js",
    nodeDir + "jquery-validation/dist/jquery.validate.min.js",
    jsDir + "ext/jquery.validate.bootstrap.js",
    jsDir + "/shifts/index.js"
  ],
  "public/js/shifts/index.min.js"
);

//shifts-show

mix.styles(
  [
    nodeDir + "datatables.net-bs/css/dataTables.bootstrap.min.css",
    nodeDir + "chosen-js/chosen.min.css",
    nodeDir + "vis/dist/vis.min.css",
    nodeDir + "jquery-ui/themes/base/datepicker.css",
    nodeDir + "jquery-confirm/dist/jquery-confirm.min.css",
    nodeDir +
      "jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.min.css"
  ],
  "public/css/shifts/show.min.css"
);

mix.scripts(
  [
    nodeDir + "datatables.net/js/jquery.dataTables.min.js",
    nodeDir + "datatables.net-bs/js/dataTables.bootstrap.min.js",
    nodeDir + "moment/min/moment.min.js",
    nodeDir + "datatable-sorting-datetime-moment/index.js",
    nodeDir + "chosen-js/chosen.jquery.min.js",
    nodeDir + "vis/dist/vis.min.js",
    nodeDir +
      "jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.min.js",
    nodeDir + "jquery-confirm/dist/jquery-confirm.min.js",
    nodeDir + "jquery-validation/dist/jquery.validate.min.js",
    nodeDir + "lodash/lodash.min.js",
    jsDir + "ext/jquery.validate.bootstrap.js",
    jsDir + "/shifts/show.js"
  ],
  "public/js/shifts/show.min.js"
);
