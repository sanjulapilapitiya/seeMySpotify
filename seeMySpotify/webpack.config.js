// webpack.config.js
const Encore = require('@symfony/webpack-encore');

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')
  .addEntry('app', './assets/main.ts')
  .enableVueLoader()
  .enableTypeScriptLoader()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSingleRuntimeChunk();

module.exports = Encore.getWebpackConfig();

