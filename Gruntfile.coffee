module.exports = (grunt) ->
  grunt.initConfig
    requirejs:
      compile:
        options:
          baseUrl: 'app/assets/js/build'
          mainConfigFile: 'app/assets/js/build/common.js'
          keepBuildDir: true
          dir: 'public/js'
          paths: {
            jquery: "empty:"
            bootstrap: "empty:"
          }
          modules: [
            {
              name: 'common'
            }
            {
              name: 'messageBoard'
              exclude: ['common']
            }
            {
              name: 'displayChapter'
              exclude: ['common']
            }
          ]
    clean: ["public/js", "public/img", "public/css"]
    coffee:
      compile:
        expand: true
        cwd: 'app/assets/js'
        src: ['**/*.coffee']
        dest: 'app/assets/js/build'
        ext: '.js'
    less:
      main:
        files:
          'public/css/style.css': 'app/assets/css/style.less'
    copy:
      dev:
       files:
          [
            {
              expand: true
              cwd: 'app/assets/js/build'
              src: ['**/*.js']
              dest: 'public/js'
            }
          ]
      main:
        files: [
          {
            expand: true
            cwd: 'app/assets/css'
            src: ['**/*.css']
            dest: 'public/css'
          }
          {
            expand: true
            cwd: 'app/assets/fonts'
            src: ['**/*.*']
            dest: 'public/fonts'
          }
          {
            expand: true
            flatten: true
            src: [
              'bower_components/bootstrap/dist/css/bootstrap.min.css'
            ]
            dest: 'public/css'
          }
          {
            expand: true
            flatten: true
            src: [
              'app/assets/css/images/*'
            ]
            dest: 'public/css/images'
          }
          {
            expand: true
            flatten: true
            src: [
              'bower_components/bootstrap/dist/js/bootstrap.min.js'
              'bower_components/requirejs/require.js'
              'bower_components/jquery/dist/jquery.min.js'
              'bower_components/jquery/dist/jquery.min.map'
              'bower_components/hogan/web/builds/3.0.2/hogan-3.0.2.min.amd.js'
            ]
            dest: 'public/js/lib'
          }
          {
            expand: true
            cwd: 'app/assets/img'
            src: [ '*' ]
            dest: 'public/img'
          }
        ]

  grunt.loadNpmTasks task for task in [
    'grunt-contrib-uglify'
    'grunt-contrib-requirejs'
    'grunt-contrib-clean'
    'grunt-contrib-coffee'
    'grunt-contrib-copy'
    'grunt-contrib-less'
  ]

  grunt.registerTask 'default', ['clean', 'coffee', 'less', 'copy:main' ]
  grunt.registerTask 'dev', ['clean', 'coffee', 'less', 'copy:main', 'copy:dev']