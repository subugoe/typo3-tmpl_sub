/*global module:false*/
module.exports = function(grunt) {

	grunt.initConfig({

						 // concatenation of files
						 concat: {
							 js: {
								 src: ['Resources/Public/Js/modernizr.js', 'Resources/Public/Js/SUB.js', 'Resources/Public/Js/ClassNames.js', 'Resources/Public/Js/jquery.dataTables.min.js'],
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
							 files: ['<config:lint.files>', '<config:coffee.app.src>', 'Resources/Private/CoffeeScript/*', 'Resources/Private/Sass/Sections/*'],
							 tasks: ['compass', 'postcss', 'coffee', 'concat', 'uglify']
						 },

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
						 },
						 postcss: {
							 options: {
								 map: true,
								 processors: [
									 require('autoprefixer')({browsers: 'last 2 versions'})
								 ]
							 },
							 dist: {
								 src: 'Resources/Public/Css/*.css'
							 }
						 }
					 });
	// register tasks
	grunt.registerTask('default', ['coffee', 'postcss', 'compass', 'concat', 'uglify']);
	grunt.registerTask('compassProduction', ['compass:prod']);
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-coffee');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-postcss');
};
