var Encore = require('@symfony/webpack-encore');
var CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()                     // empties the outputPath dir before each build
    .enableSourceMaps(!Encore.isProduction())       // enables source maps for Dev
    // .enableVersioning(Encore.isProduction())     // uncomment to create hashed filenames (e.g. app.abc123.css)

    // define the assets of the project
    .addEntry('js/app', './assets/js/main.js')
    .addEntry('js/locate', './assets/js/locate.js')
    .addStyleEntry('css/style', './assets/scss/app.scss')
    .enableSassLoader()
    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/images', to: 'images' }
    ]))
;

module.exports = Encore.getWebpackConfig();