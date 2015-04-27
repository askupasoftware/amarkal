module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        copy: {
            main: {
                files: [
                    {   // Copy UI script files to the js dir
                        expand: true,
                        cwd: 'UI/Components/',
                        src: ['**/*.js'],
                        dest: '<%= pkg.directories.js %>/UI/Components/', 
                        filter: 'isFile',
                        rename: function(dest, src) {
                            return dest + src.split("/")[src.split("/").length-2] + '.js';
                        }
                    },
                    {   // Copy UI style files to the js dir
                        expand: true,
                        cwd: 'UI/Components/',
                        src: ['**/*.scss'],
                        dest: '<%= pkg.directories.sass %>/UI/Components/', 
                        filter: 'isFile',
                        rename: function(dest, src) {
                            return dest + '_' + src.split("/")[src.split("/").length-2] + '.scss';
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
                    'Assets/sass/amarkal.min.scss': [
                        'Assets/sass/_tooltip.scss',
                        'Assets/sass/UI/_ui.scss',
                        'Assets/sass/UI/Components/*.scss',
                        'Extensions/WordPress/Assets/sass/options/options.scss',
                        'Extensions/WordPress/Assets/sass/editor/editor.scss',
                        'Extensions/WordPress/Assets/sass/editor/form.scss',
                        'Extensions/WordPress/Assets/sass/metabox/metabox.scss',
                        'Extensions/WordPress/Assets/sass/widget/widget.scss'
                    ],
                    'Assets/js/amarkal.min.js': [
                        'Assets/js/transition.js',
                        'Assets/js/tooltip.js',
                        'Assets/js/Intro.js',
                        'Assets/js/Utility.js',
                        'Assets/js/Notifier.js',
                        'Assets/js/Options/Options.js',
                        'Assets/js/Options/Section.js',
                        'Assets/js/Options/Sections.js',
                        'Assets/js/Options/State.js',
                        'Assets/js/UI/UI.js',
                        'Assets/js/UI/Components/*.js',
                        'Assets/js/Editor/Editor.js',
                        'Assets/js/Editor/FloatingToolbar.js',
                        'Assets/js/Editor/Form.js',
                        'Assets/js/Widget/Widget.js',
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
                    'Assets/js/amarkal.min.js': ['Assets/js/amarkal.min.js']
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