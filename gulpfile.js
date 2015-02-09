var gulp = require('gulp'),
		sass = require('gulp-sass'),
		notify = require('gulp-notify'),
		scsslint = require('gulp-scss-lint'),
		concat = require('gulp-concat'),
		uglify = require('gulp-uglify'),
		rename = require('gulp-rename'),
		autoprefixer = require('gulp-autoprefixer'),
		cached = require('gulp-cached'),
		coffee = require('gulp-coffee'),
		bower = require('gulp-bower');

var config = {
	paths: {
		sass: ['./Resources/Private/Scss/**/*.scss', './Resources/Private/Scss/*.scss', '!./Resources/Private/Scss/vendors/**/*.scss'],
		fonts: ['./Build/bower/fontawesome/fonts/*'],
		coffee: ['.Resources/Private/CoffeeScript/*.coffee']
	},
	autoprefixer: {
		browsers: [
			'last 2 versions',
			'safari 5',
			'ie 8',
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
			.pipe(sass({
				style: 'compressed',
				errLogToConsole: true,
				sourcemaps: true
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
			.pipe(gulp.dest('./Resources/Public/Js/'))
});

gulp.task('compile', function () {
	gulp.start('bower', 'copy-fonts', 'sass', 'coffee', 'uglify')
});

gulp.task('watch', function () {
	gulp.watch(config.paths.sass, ['lint', 'compile'])
});

gulp.task('bower', function () {
	return bower()
			.pipe(gulp.dest('Build/bower/'))
});

gulp.task('uglify', function () {
	gulp.src('Resources/Private/Js/*.js')
			.pipe(concat('production.js'))
			.pipe(uglify())
			.pipe(rename('Site.min.js'))
			.pipe(gulp.dest('Resources/Public/Js/'))
});

gulp.task('copy-fonts', function () {
	return gulp.src(config.paths.fonts)
			.pipe(gulp.dest('Resources/Public/Fonts/'));
});

gulp.task('default', function () {
	gulp.start('lint', 'compile', 'watch')
});