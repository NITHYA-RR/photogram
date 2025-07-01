// Gruntfile.js
// This file is used to configure Grunt tasks for the project.
module.exports = function (grunt) {

var currentdate = new Date(); 
var datetime = "Last Sync: " + currentdate.getDate() + "/"
                  + (currentdate.getMonth()+1)  + "/" 
                  + currentdate.getFullYear() + " @ "  
                  + currentdate.getHours() + ":"  
                  + currentdate.getMinutes() + ":" 
                  + currentdate.getSeconds();


    grunt.initConfig({
        concat: {
          options: {
            separator: '\n',
            SourceMap: true,
            banner: "/* My Project last update on "+datetime+"*/\n",
          },
          css: {
            src: ['../css/**/*.css'
                ],
            dest: '/dist/style.css',
          },
          // scss: {
          //   src: ['../scss/**/*.scss'
          //       ],
          //   dest: '/dist/style.scss',
          // },
          js: {
            src: [
              '../js/**/*.css',
                ],
            dest: '/dist/app1.js',
          },
        },
        cssmin: {
          options: {
            mergeIntoShorthands: false,
            roundingPrecision: -1
          },
          css: {
            
            files: {
              '../../Htdocs/style.min.css': ['/dist/style.css']
            }
          },
          
        },
        sass: {                              // Task
          dist: {                            // Target
            options: {                       // Target options
              style: 'expanded'
            },
            files: {                         // Dictionary of files
              '../../Htdocs/style.min.css': '/dist/style.scss',       // 'destination': 'source'
              
            }
          }
        },
        uglify: {
          my_target: {
            options: {
              sourceMap: true,
              sourceMapName: 'path/to/sourcemap.map'
            },
            files: {
              '../../Htdocs/scriptfiles/app.min.js': ['/dist/app1.js']
            }
          }
        },
        copy: {
          bower: {
            files: [
              // includes files within path and its sub-directories
              {
                expand: true, 
                flatten: true,
                filter: 'isFile',
                src: ['bower_components/jquery/dist/jquery.js'], 
                dest: '../../Htdocs/scriptfiles/jquery.js'},
                
            ],
          },
        },
        
          watch: {
            css: {
              files: ['../css/**/*.css'
                    ],
              tasks: ['concat:css','uglify' ],
              options: {
                spawn: false,
            
            },
          },
        js: {
              files: [
                      
                '../js/**/*.js'
                    ],
              tasks: ['concat:js','uglify' ],
              options: {
                spawn: false,
            
            },
          },
        //   scss: {
        //     files: [
                    
        //       '../scss/**/*.scss'
        //           ],
        //     tasks: ['concat:scss','uglify' ],
        //     options: {
        //       spawn: false,
          
        //   },
        // },
          
          
         },
      });

grunt.loadNpmTasks('grunt-contrib-obfuscator');
grunt.loadNpmTasks('grunt-contrib-copy');
grunt.loadNpmTasks('grunt-contrib-cssmin');
grunt.loadNpmTasks('grunt-contrib-concat');
grunt.loadNpmTasks('grunt-contrib-uglify');
grunt.loadNpmTasks('grunt-contrib-watch');
grunt.loadNpmTasks('grunt-contrib-sass');
grunt.registerTask('css',['concat:css','cssmin']);
grunt.registerTask('js',['concat:js','uglify']);
grunt.registerTask('default',['copy','concat','cssmin','uglify','watch']);    


};

