/*global module:false*/
module.exports = function (grunt) {

	grunt.initConfig({

						// Liste der Dateien, deren Syntax mit JSHint geprüft werden soll
						lint:{files:['grunt.js', 'Resources/Public/Js/menu.js'] },

						// Liste der Dateien, die zusammengefasst werden sollen (Quell- und Zieldateien)
						concat:{
							js:{
								src:['Resources/Public/Js/modernizr.js', 'Resources/Public/Js/underscore-min.js', 'Resources/Public/Js/backbone-min.js', 'Resources/Public/Js/SUB.js', 'Resources/Public/Js/ClassNames.js'],
								dest:'Resources/Public/Js/Site.js'
							}
						},

						// Liste der Dateien, die minifiziert werden sollen (Quell- und Zieldateien)
						min:{
							dist:{
								src:['<config:concat.js.dest>'],
								dest:'Resources/Public/Js/Site.min.js'
							}},

						// Tasks, die mit 'grunt watch' ausgeführt werden sollen
						watch:{
							files:['<config:lint.files>', '<config:coffee.app.src>', '<config.compass.prod.src>', 'Resources/Private/Sass/Sections/*'],
							tasks:'compass coffee lint concat'},

						// Konfigurationsoptionen für JSHint
						// Siehe: http://www.jshint.com/docs/
						jshint:{},

						// Konfigurationsoptionen für UglifyJS (wird zur Minifizierung verwendet)
						// Siehe: https://github.com/mishoo/UglifyJS#usage
						//
						// Zusätzliche Einstellungen werden in der Regel nicht benötigt.
						uglify:{},
						compass:{
							prod:{
								src:'Resources/Private/Sass',
								dest:'Resources/Public/Css',
								linecomments:false,
								outputstyle:'expanded',
								forcecompile:true,
								debugsass:false,
								relativeassets:true
							}
						},
						coffee:{
							app: {
								src: ['Resources/Private/CoffeeScript/*.coffee'],
								dest: 'Resources/Public/Js',
								options: {
									bare: true
								}
							}
						}
					});

	// Default task, der ausgeführt wird, wenn man Grunt ohne weitere Parameter aufruft.
	grunt.registerTask('default', 'coffee compass lint concat min');
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-coffee');
	grunt.loadNpmTasks('grunt-contrib-watch');
};