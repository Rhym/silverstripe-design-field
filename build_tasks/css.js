module.exports = function (grunt) {
  'use strict';

  var config = grunt.config;

  /** =========================================
   * CSS
   ===========================================*/

  /** -----------------------------------------
   * Sass
   * ----------------------------------------*/

  config.set('sass.all', {
    files: [{
      '<%= directories.silverstripeDesignField %>/css/main.css': '<%= directories.silverstripeDesignField %>/scss/main.scss'
    }]
  });

  /** -----------------------------------------
   * Combine Media Queries
   * ----------------------------------------*/

  config.set('cmq.all', {
    options: {
      log: false
    },
    files: [{
      '<%= directories.silverstripeDesignField %>/css/': ['<%= directories.silverstripeDesignField %>/css/main.css']
    }]
  });

  /** -----------------------------------------
   * PostCSS
   * ----------------------------------------*/

  config.set('postcss.all', {
    options: {
      map: true,
      processors: [
        require('pixrem')(),
        require('autoprefixer-core')({
          browsers: 'last 3 versions'
        }),
        require('cssnano')()
      ]
    },
    dist: {
      src: '<%= directories.silverstripeDesignField %>/css/*.css'
    }
  });

  /** -----------------------------------------
   * CSS Lint
   * ----------------------------------------*/

  config.set('csslint.strict', {
    options: {
      import: 2
    },
    src: ['<%= directories.silverstripeDesignField %>/css/main.css']
  });

  config.set('csslint.lax', {
    options: {
      import: false
    },
    src: ['<%= directories.silverstripeDesignField %>/css/main.css']
  });

  /** =========================================
   * Watch
   ===========================================*/

  config.set('watch', {
    files: ['<%= directories.silverstripeDesignField %>/scss/**/*.scss'],
    tasks: ['sass', 'cmq', 'postcss'],
    options: {
      spawn: false
    }
  });

};
