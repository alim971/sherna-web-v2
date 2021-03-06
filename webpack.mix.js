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

mix.less('resources/assets/less/bootstrap/bootstrap.less', '../resources/assets/css')
    .less('resources/assets/less/admin.less', '../resources/assets/css')
    .less('resources/assets/less/client.less', '../resources/assets/css');

mix.combine([
    'resources/assets/css/bootstrap.css',
    'resources/assets/css/admin.css',
    'resources/assets/css/font-awesome.css'
], 'public/css/admin.css');

mix.combine([
    'resources/assets/css/bootstrap.css',
    'resources/assets/css/mdb.css',
    'public/css/flag-icon.min.css',
    'resources/assets/css/client.css',
    'resources/assets/css/jquery-ui.min.css',
    'resources/assets/css/font-awesome.css'
], 'public/css/client.css');

// exec('php artisan js:translate', function (err, stdout, stderr) {
//     console.log(stdout);
//     if (stderr != '') {
//         console.log('errors: ', stderr);
//     }
// });

mix.combine([
    'resources/assets/js/jquery.js',
    'resources/assets/js/bootstrap.js',
    'resources/assets/js/jquery-ui.min.js',
    'resources/assets/gentelella/vendors/moment/min/moment.min.js',
    // 'resources/assets/gentelella/vendors/fullcalendar/dist/fullcalendar.min.js',
    // 'resources/assets/gentelella/vendors/fullcalendar/dist/locale-all.js',
    'resources/assets/js/datetimepicker/js/bootstrap-datetimepicker.js',
    'resources/assets/js/datetimepicker/js/locales/bootstrap-datetimepicker.sk.js',
    'resources/assets/js/datetimepicker/js/locales/bootstrap-datetimepicker.cs.js',
    // 'resources/assets/js/reservation.js',
    // 'resources/assets/js/renew-reservation.js',
    'resources/assets/js/app.js',
    'resources/assets/js/trans.js'
], 'public/js/app.js');

if (mix.config.inProduction) {
    mix.version();
}
mix.
    // gentelella
    copy('resources/assets/gentelella/build/css/custom.css', 'public/gentellela/custom.css').
    copy('resources/assets/gentelella/build/js/custom.js', 'public/gentellela/custom.js').
    copy('resources/assets/gentelella/vendors/fullcalendar/dist/fullcalendar.min.css',
    'public/gentellela/vendors/fullcalendar/dist/fullcalendar.min.css').
    copy('resources/assets/gentelella/vendors/fullcalendar/dist/fullcalendar.print.css',
    'public/gentellela/vendors/fullcalendar/dist/fullcalendar.print.css').
    copy('resources/assets/gentelella/vendors/switchery/dist/switchery.min.js',
    'public/gentellela/vendors/switchery/dist/switchery.min.js').
    copy('resources/assets/gentelella/vendors/switchery/dist/switchery.min.css',
    'public/gentellela/vendors/switchery/dist/switchery.min.css').
    copy('resources/assets/gentelella//vendors/nprogress/nprogress.js',
    'public/gentellela/vendors/nprogress/nprogress.js').
    copy('resources/assets/gentelella/vendors/jquery.tagsinput/dist/jquery.tagsinput.min.css',
    'public/gentellela/jquery.tagsinput.min.css').
    copy('resources/assets/gentelella/vendors/jquery.tagsinput/src/jquery.tagsinput.js',
    'public/gentellela/jquery.tagsinput.js').
    copy('resources/assets/gentelella/vendors/fullcalendar/dist/fullcalendar.min.js',
    'public/gentellela/fullcalendar.js').
    copy('resources/assets/gentelella/vendors/fullcalendar/dist/lang/cs.js',
    'public/gentellela/fullcalendar-locale.js');

mix.
    // sortable
    copy('resources/js/jquery-sortable.js', 'public/js/jquery-sortable.js');
