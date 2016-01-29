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

    elixir.config.js.browserify.transformers.push({
        name: 'browserify-shim',
        options: {}
    });

    function buildJsModule(moduleName, coffeeFiles) {
        var compiledName = 'resources/assets/js/compiled/'+moduleName+'.js';
        mix.coffee(coffeeFiles.map(function (name) { return name + ".coffee"}), compiledName);
        mix.browserify(compiledName);
    }

    mix.coffee('abbrevs', 'resources/assets/js/compiled/abbrevs.js');
    buildJsModule('app', ['common', 'displayChapter','menu','messageBoard','moderate', 'technical']);
    buildJsModule('convert', ['convert']);

    mix.version(['css/all.css', 'js/app.js', 'js/convert.js']);

    mix.copy('resources/assets/img', 'public/build/img');
    mix.copy('resources/assets/fonts', 'public/build/fonts');
    mix.copy('bower_components/bootstrap-sass/assets/fonts/bootstrap', 'public/build/fonts/bootstrap');
    mix.copy('bower_components/dropzone/downloads/css', 'public/build/dropzone/css')
    mix.copy('bower_components/dropzone/downloads/images', 'public/build/dropzone/images')

});
