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
		.pipe(gulp.dest('./Resources/Public/Css/'));
});

gulp.task('sass-lint', function () {
	gulp.src(config.paths.sass)
		.pipe(cached('scsslint'))
		.pipe(scsslint({
			'config': 'Build/.scss-lint.yml',
			'maxBuffer': 9999999
		}));
});

gulp.task('coffee', function () {
	gulp.src(config.paths.coffee)
		.pipe(coffee({bare: true}))
		.pipe(gulp.dest('./Resources/Private/Js/'))
});

gulp.task('uglify', function () {
	gulp.src(config.paths.javascript)
		.pipe(concat('production.js'))
		.pipe(uglify())
		.pipe(rename('Site.min.js'))
		.pipe(gulp.dest('Resources/Public/Js/'));
});

gulp.task('compile', ['bower', 'coffee', 'sass'], function () {
	gulp.start('copy-fonts', 'sass-lint', 'uglify');
});

gulp.task('prod', ['copy-fonts', 'coffee', 'sass'], function () {
	gulp.start('uglify');
});

gulp.task('watch', function () {
	gulp.watch(config.paths.sass, ['sass-lint', 'sass']);
	gulp.watch(config.paths.coffee, ['coffee', 'uglify']);
});

gulp.task('bower', function () {
	return bower()
		.pipe(gulp.dest('Build/bower/'));
});

gulp.task('copy-fonts', ['bower'], function () {
	return gulp.src(config.paths.fonts)
		.pipe(gulp.dest('Resources/Public/Fonts/fontawesome/'));
});

gulp.task('default', function () {
	gulp.start('compile', 'watch')
});
