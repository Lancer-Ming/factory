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
//const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
mix.webpackConfig({
    // plugins: [
    //     new BundleAnalyzerPlugin(),
    // ],
    devtool: "source-map",
    output: {
        publicPath: "/",
        //chunkFilename: 'js/lazy/[name].[chunkhash].js'
        chunkFilename: 'js/lazy/[name].js'
    },
    entry: {
        main: ["babel-polyfill", "./resources/assets/js/main.js"]

    }
    // externals: {
    //     'element-ui': 'Element',
    //     'axios': 'axios',
    //     'vue': 'Vue',
    //     'vuex': 'Vuex',
    //     'vue-router': 'VueRouter',
    //     'vue-chartjs': 'VueChartJs',
    //     'lodash': '_',
    // }
}).js('resources/assets/js/main.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/page/page.scss', 'public/css')
    .sass('resources/assets/sass/login.scss', 'public/css')
    .sourceMaps()
//.version()
//.extract(['vue','vue-router','axios','element-ui'])

