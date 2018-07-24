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
mix.webpackConfig({
    devtool: "#cheap-module-eval-source-map",
    output: {
        publicPath: "/",
        //chunkFilename: 'js/lazy/[name].[chunkhash].js'
        chunkFilename: 'js/lazy/[name].js'
    },
})
mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/page/page.scss', 'public/css')
   .sourceMaps()
   //.version()
   //.extract(['vue','vue-router','axios','element-ui'])

