var gulp = require('gulp'),
	autoprefixer = require('gulp-autoprefixer'),
	bower = require('gulp-bower');
	cached = require('gulp-cached'),
	coffee = require('gulp-coffee'),
	concat = require('gulp-concat'),
	notify = require('gulp-notify'),
	rename = require('gulp-rename'),
	sass = require('gulp-sass'),
	sassGlob = require('gulp-sass-glob'),
	scsslint = require('gulp-scss-lint'),
	uglify = require('gulp-uglify');

var config = {
	paths: {
		sass: [
			'./Resources/Private/Scss/**/*.scss',
			'./Resources/Private/Scss/*.scss',
			'!./Resources/Private/Scss/Vendor/**/*.scss',
			'!./Resources/Private/Scss/Extern/**/*.scss'
		],
		fonts: ['./Build/bower/fontawesome/fonts/*'],
		coffee: ['./Resources/Private/CoffeeScript/*.coffee'],
		javascript: [
			'./Build/bower/modernizr/modernizr.js',
			'./Build/bower/bootstrap-sass-twbs/assets/javascripts/bootstrap.js',
			'./Build/bower/jasny-bootstrap/js/offcanvas.js',
			'./Resources/Private/Js/*.js'
		]
	},
	autoprefixer: {
		browsers: [
			'last 2 versions',
			'safari 6',
			'ie 9',
			'opera 12.1',
			'ios 6',
			'android 4'
		],
		cascade: true
	}
};

gulp.task('sass', function () {
	gulp.src(config.paths.sass)
		.pipe(sassGlob())
		.pipe(sass({
			outputStyle: 'compressed'
		}))
		.on('error', notify.onError({
			title: 'Sass Error',
			message: '<%= error.message %>'
		}))
		.pipe(autoprefixer(
			config.autoprefixer
		))
		.pipe(gulp.dest('./Resources/Public/Css/'))
});

gulp.task('lint', function () {
	gulp.src(config.paths.sass)
		.pipe(cached('scsslint'))
		.pipe(scsslint({
			'config': 'Build/.scss-lint.yml',
			'maxBuffer': 9999999
		}))
});

gulp.task('coffee', function () {
	gulp.src(config.paths.coffee)
		.pipe(coffee({bare: true}))
		.pipe(gulp.dest('./Resources/Private/Js/'))
});

gulp.task('compile', function () {
	gulp.start('bower', 'copy-fonts', 'lint', 'sass', 'coffee', 'uglify')
});

gulp.task('watch', function () {
	gulp.watch(config.paths.sass, ['compile'])
});

gulp.task('bower', function () {
	return bower()
			.pipe(gulp.dest('Build/bower/'))
});

gulp.task('uglify', function () {
	gulp.src(config.paths.javascript)
			.pipe(concat('production.js'))
			.pipe(uglify())
			.pipe(rename('Site.min.js'))
			.pipe(gulp.dest('Resources/Public/Js/'))
});

gulp.task('copy-fonts', function () {
	return gulp.src(config.paths.fonts)
			.pipe(gulp.dest('Resources/Public/Fonts/fontawesome/'));
});

gulp.task('copy-bootstrap-js', function () {
	return gulp.src('./Build/bower/bootstrap-sass-twbs/assets/javascripts/bootstrap.min.js')
		.pipe(gulp.dest('Resources/Private/Js/'));
});

gulp.task('default', function () {
	gulp.start('lint', 'compile', 'watch')
});
