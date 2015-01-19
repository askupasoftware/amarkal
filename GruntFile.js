module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        copy: {
            main: {
                files: [
                    {   // Copy UI .js files to the js dir
                        expand: true,
                        cwd: 'UI/Components/',
                        src: ['**/*.js'],
                        dest: '<%= pkg.directories.js %>/UI/Components/', 
                        filter: 'isFile',
                        rename: function(dest, src) {
                            return dest + src.split("/")[src.split("/").length-2] + '.js';
                        }
                    }
                ]
            }
        },
        concat: {
            options: {
                separator: "\n",
            },
            dist: {
                files: {
                    //'Assets/sass/widget.min.scss': ['Assets/sass/_widget_core.scss','Assets/sass/_widget_field_*.scss'],
                    'Assets/sass/options.min.scss': [
                        'Extensions/WordPress/Assets/sass/options/options.scss',
                        'Extensions/WordPress/Assets/sass/options/components/*.scss'
                    ],
                    'Assets/js/amarkal.min.js': [
                        'Assets/js/Intro.js',
                        'Assets/js/Notifier.js',
                        'Assets/js/Options/Options.js',
                        'Assets/js/Options/Section.js',
                        'Assets/js/Options/Sections.js',
                        'Assets/js/Options/State.js',
                        'Assets/js/UI/UI.js',
                        'Assets/js/UI/Components/*.js',
                        //'Assets/js/Widget/Widget.js',
                        //'Assets/js/Widget/fields/*.js',
                        'Assets/js/Outro.js'
                    ]
                }
            }
        },
        compass: {
            dist: {
                options: {
                    sassDir: '<%= pkg.directories.sass %>',
                    cssDir: '<%= pkg.directories.css %>',
                    environment: 'production',
                    raw: 'preferred_syntax = :sass\n', // Use `raw` since it's not directly available
                    outputStyle: 'compressed'
                }
            }
        },
        uglify: {
            options: {
                banner: '/**\n * Package: <%= pkg.name %>\n * Version: <%= pkg.version %>\n * Date: <%= grunt.template.today("yyyy-mm-dd") %>\n */\n'
            },
            dist: {
                files: {
                    'Assets/js/amarkal.min.js': ['Assets/js/amarkal.min.js'],
                    'Assets/js/tooltip.min.js': ['Assets/js/tooltip.js']
                }
            }
        }
    });

    // Load grunt plugins
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    
    // Default task(s).
    grunt.registerTask('default', ['copy','concat','compass','uglify']);
};