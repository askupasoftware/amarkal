module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                src: 'Assets/js/test.js',
                dest: '../build/test.min.js'
            }
        },
        copy: {
            main: {
                files: [
                    {
                        expand: true,
                        flatten: true,
                        src: ['test/src/**/*.scss'], 
                        dest: 'test/dest/', 
                        filter: 'isFile'
                    }
                ]
            }
        },
        compass: {                  // Task
            dist: {                   // Target
                options: {              // Target options
                    sassDir: '<%= pkg.directories.sass %>',
                    cssDir: '<%= pkg.directories.css %>',
                    environment: 'production',
                    raw: 'preferred_syntax = :sass\n', // Use `raw` since it's not directly available
                    outputStyle: 'expanded'
                }
            }
        }
    });

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-copy');
    
    // Default task(s).
    grunt.registerTask('default', ['copy','compass']);

};