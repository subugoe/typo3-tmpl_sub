/*global module:false*/
module.exports = function(grunt) {

	grunt.initConfig({

						 // concatenation of files
						 concat: {
							 js: {
								 src: ['Resources/Public/Js/modernizr.js', 'Resources/Public/Js/underscore-min.js', 'Resources/Public/Js/backbone-min.js', 'Resources/Public/Js/SUB.js', 'Resources/Public/Js/ClassNames.js'],
								 dest: 'Resources/Public/Js/Site.js'
							 }
						 },

						 uglify: {
							 my_target: {
								 files: {
									 'Resources/Public/Js/Site.min.js': ['Resources/Public/Js/Site.js']
								 }
							 }
						 },
						 // watcher task
						 watch: {
							 files: ['<config:lint.files>', '<config:coffee.app.src>', '<config.compass.prod.src>', 'Resources/Private/Sass/Sections/*'],
							 tasks: 'compass coffee concat uglify'},

						 compass: {
							 prod: {
								 src: 'Resources/Private/Sass',
								 dest: 'Resources/Public/Css',
								 linecomments: false,
								 outputstyle: 'expanded',
								 forcecompile: true,
								 debugsass: false,
								 relativeassets: true
							 }
						 },
						 coffee: {
							 glob_to_multiple: {
								 expand: true,
								 flatten: true,
								 cwd: 'Resources/Private/CoffeeScript',
								 src: ['*.coffee'],
								 dest: 'Resources/Public/Js/',
								 ext: '.js'
							 }
						 }
					 });
	// register tasks
	grunt.registerTask('default', ['coffee', 'compass', 'concat', 'uglify']);
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-coffee');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
};