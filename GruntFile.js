module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        copy: {
            main: {
                files: [
                    {   // Copy widget UI .scss files to the sass dir
                        expand: true,
                        cwd: 'Widget/UI/',
                        src: ['**/*.scss'], 
                        dest: '<%= pkg.directories.sass %>/', 
                        filter: 'isFile',
                        rename: function(dest, src) {
                            // File names starting with "_" are ignored by compass
                            return dest + "_widget_field_" + src.split("/")[src.split("/").length-2] + '.scss';
                        }
                    },
                    {   // Copy widget UI .js files to the js dir
                        expand: true,
                        cwd: 'Widget/UI/',
                        src: ['**/*.js'],
                        dest: '<%= pkg.directories.js %>/', 
                        filter: 'isFile',
                        rename: function(dest, src) {
                            return dest + "_widget_field_" + src.split("/")[src.split("/").length-2] + '.js';
                        }
                    },
                    {   // Copy options UI .scss files to the sass dir
                        expand: true,
                        cwd: 'Options/UI/',
                        src: ['**/*.scss'], 
                        dest: '<%= pkg.directories.sass %>/', 
                        filter: 'isFile',
                        rename: function(dest, src) {
                            // File names starting with "_" are ignored by compass
                            return dest + "_options_field_" + src.split("/")[src.split("/").length-2] + '.scss';
                        }
                    },
                    {   // Copy options UI .js files to the js dir
                        expand: true,
                        cwd: 'Options/UI/',
                        src: ['**/*.js'],
                        dest: '<%= pkg.directories.js %>/', 
                        filter: 'isFile',
                        rename: function(dest, src) {
                            return dest + "_options_field_" + src.split("/")[src.split("/").length-2] + '.js';
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
                    'Assets/sass/widget.min.scss': ['Assets/sass/_widget_core.scss','Assets/sass/_widget_field_*.scss'],
                    'Assets/js/widget.min.js': ['Assets/js/_widget_core.js','Assets/js/_widget_field_*.js'],
                    'Assets/sass/options.min.scss': ['Assets/sass/_options_core.scss','Assets/sass/_options_field_*.scss'],
                    'Assets/js/options.min.js': ['Assets/js/_options_core.js','Assets/js/_options_field_*.js']
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
                    'Assets/js/widget.min.js': ['Assets/js/widget.min.js'],
                    'Assets/js/options.min.js': ['Assets/js/options.min.js'],
                    'Assets/js/tooltip.min.js': ['Assets/js/_tooltip.js']
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