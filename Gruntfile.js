module.exports = function(grunt) {

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.initConfig({

        /**
         * Less
         */
        less: {
            process_prod: {
                options: {
                    sourceMap: false
                },
                files: [{
                    expand: true,
                    cwd: 'public/less/map/',
                    src: [
                        '**/*.less',
                        '!**/_*.less'
                    ],
                    dest: 'public/css/',
                    ext: '.css'
                }]
            },
            process_itg: {
                options: {
                    sourceMap: true
                },
                files: [{
                    expand: true,
                    cwd: 'public/less/map/',
                    src: [
                        '**/*.less',
                        '!**/_*.less'
                    ],
                    dest: 'public/css',
                    ext: '.css',
                    extDot: 'last'
                }]
            }
        },

        watch: {
            less: {
                files: ['public/less/*.less', 'public/less/**/*.less'],
                tasks: ['less:process_itg']
            }

        }
    });

    grunt.registerTask('watch-less', ['less:process_itg', 'watch:less']);
};

