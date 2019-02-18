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
var LiveReloadPlugin = require('webpack-livereload-plugin');

/* Config code splitting */
mix.webpackConfig(webpack => {
    return {
        output: {
            publicPath: '/',
            chunkFilename: 'js/[name].js',
        },
        plugins: [new LiveReloadPlugin()]
    };
});

// css styles could be very well imported through sass, but we can just bundle up through
// laravel-mix for demo purposes 

mix.scripts([
        'node_modules/admin-lte/bower_components/jquery/dist/jquery.min.js',
        'node_modules/admin-lte/bower_components/bootstrap/dist/js/bootstrap.min.js',
        'node_modules/admin-lte/dist/js/adminlte.min.js'
        ], 'public/js/vendor.js')
    .styles([
        'node_modules/admin-lte/bower_components/bootstrap/dist/css/bootstrap.min.css',
        'node_modules/admin-lte/bower_components/font-awesome/css/font-awesome.min.css',
        'node_modules/admin-lte/bower_components/Ionicons/css/ionicons.min.css',
        'node_modules/admin-lte/dist/css/AdminLTE.min.css',
        'node_modules/admin-lte/dist/css/skins/skin-blue.min.css'
        ] , 'public/css/vendor.css')
    .copy(
        // this could be done differently if importing the styles in the scss files
        'node_modules/admin-lte/bower_components/font-awesome/fonts/',
        'public/fonts/'
        )
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/main.scss', 'public/css');
    mix.sourceMaps();
