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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
   mix.js('resources/js/admin.js', 'public/js/admin.js');
   mix.js('resources/js/dashboard.js','public/js/dashboard.js');
   mix.js('resources/js/demo.js','public/js/demo.js');
   mix.js('resources/js/adminlte.js','public/js/adminlte.js');
   mix.sass('resources/sass/admin.scss','public/css/admin.css');
  // mix.sass('resources/sass/adminlte.scss','public/css/adminlt.css');
   mix.js('resources/js/DataTables.js','public/js/DataTables.js');

   // mix.js('resources/js/BootStrapDataTables.js','public/js/BootStrapDataTables.js');
   //
   // mix.sass('resources/sass/all.sass','public/css/all.css');

