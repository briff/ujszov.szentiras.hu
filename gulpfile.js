var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix
        .less(['app.less'], 'resources/assets/css/compiled/less.css')
        .sass(['app.scss'], 'resources/assets/css/compiled/sass.css');
    mix.styles(['compiled/sass.css', 'compiled/less.css']);
    // compile coffee scripts
    mix.coffee(
        [
            'abbrevs.coffee',
            'common.coffee',
            'convert.coffee',
            'displayChapter.coffee',
            'menu.coffee',
            'messageBoard.coffee',
            'moderate.coffee']
        , 'resources/assets/js/compiled/coffee.js');
    // concat coffee scripts with other js (if any)
    mix.scripts(['compiled/coffee.js'], 'resources/assets/js/compiled/app.js');

    // now browserify
    elixir.config.js.browserify.transformers.push({
        name: 'browserify-shim',
        options: {}
    });
    mix.browserify('resources/assets/js/compiled/app.js')

    mix.version(['css/all.css', 'js/app.js']);

    mix.copy('resources/assets/img', 'public/build/img');
    mix.copy('resources/assets/fonts', 'public/build/fonts');
    mix.copy('bower_components/bootstrap-sass/assets/fonts/bootstrap', 'public/build/fonts/bootstrap');


});
