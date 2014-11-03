'use strict';
module.exports = function (grunt) {

    // load all grunt tasks
    require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

    grunt.initConfig({

        // Define watch tasks
        watch: {
            options: {
                livereload: true
            },
            sass: {
                files: ['assets/scss/**/*.scss'],
                tasks: ['sass', 'autoprefixer']
            },
            js: {
                files: ['assets/js/source/*.js'],
                tasks: ['uglify']
            },
            livereload: {
                files: ['**/*.html', '**/*.php', 'assets/images/**/*.{png,jpg,jpeg,gif,webp,svg}']
            }
        },

        // SASS
        sass: {
            options: {
                style: 'compressed'
            },
            dist: {
                files: {
                    'assets/css/thepowerbarn.main.min.css': 'assets/scss/main.scss'
                }
            },
        },

        // Auto prefix our CSS with vendor prefixes
        autoprefixer: {
            dist: {
                expand: true,
                flatten: true,
                src: 'assets/css/**/*.css',
                dest: 'assets/css',
                options: {
                    browsers: ['last 2 version', 'ie 8', 'ie 9']
                }
            }
        },

        // Minify and concatenate scripts
        uglify: {
            dist: {
                options: {
                    sourceMap: true
                },
                files: {
                    'assets/js/thepowerbarn.min.js': [
                        'assets/js/source/deps/modernizr.js',
                        'assets/js/source/deps/jquery.cookie.js',
                        'assets/js/source/deps/placeholder.js',
                        'assets/js/source/deps/fastclick.js',
                        'assets/js/source/deps/foundation/foundation.js',
                        'assets/js/source/deps/foundation/foundation.equalizer.js',
                        'assets/js/source/deps/foundation/foundation.accordion.js',
                        'assets/js/source/deps/foundation/foundation.alert.js',
                        'assets/js/source/*.js'
                    ]
                }
            }
        }
    });

    // Register our main task
    grunt.registerTask('Watch', ['watch']);

};