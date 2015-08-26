module.exports = function (grunt) {
  'use strict';
  require('time-grunt')(grunt);

  grunt.initConfig({
    directories: {
      silverstripeDesignField: './'
    },
    pkg: grunt.file.readJSON('./package.json')
  });

  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);
  grunt.loadTasks('build_tasks');
  grunt.registerTask('default', ['watch']);
  grunt.registerTask('build', ['build']);
}
