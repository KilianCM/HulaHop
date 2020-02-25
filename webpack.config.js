var Encore = require('@symfony/webpack-encore');

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
    .addStyleEntry('css/style', './assets/scss/app.scss')
    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();