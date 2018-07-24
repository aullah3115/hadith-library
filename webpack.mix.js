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
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/assets/js')
    }
  }
});

 mix.extend( 'i18n', function( webpackConfig, ...args ) {
     webpackConfig.module.rules.forEach( ( module ) => {
         // Search for the "vue-loader" component, which handles .vue files.
         if( module.loader !== 'vue-loader' ) {
             return;
         }

         // Within this module, add the vue-i18n-loader for the i18n tag.
         module.options.loaders.i18n = '@kazupon/vue-i18n-loader';
     } );
 } );

mix.i18n()
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');
