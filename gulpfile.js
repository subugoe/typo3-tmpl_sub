var gulp = require('gulp'),
    bower = require('gulp-bower'),
    cached = require('gulp-cached'),
    coffee = require('gulp-coffee'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    rename = require('gulp-rename'),
    sass = require('gulp-sass'),
    sassGlob = require('gulp-sass-glob'),
    scsslint = require('gulp-scss-lint'),
    postcss = require('gulp-postcss'),
    uglify = require('gulp-uglify');

var browserSync = require('browser-sync').create();

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

var processors = [
    require('autoprefixer')(config.autoprefixer)
];

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
        .pipe(postcss(processors))
        .pipe(gulp.dest('./Resources/Public/Css/'))
        .pipe(browserSync.stream());
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
        .pipe(concat('production.js'))
        .pipe(uglify())
        .pipe(rename('Site.min.js'))
        .pipe(gulp.dest('Resources/Public/Js/'))
        .pipe(browserSync.stream());
});

gulp.task('compile', ['bower', 'coffee', 'sass'], function () {
    gulp.start('copy-fonts', 'sass-lint');
});

gulp.task('prod', ['copy-fonts', 'coffee', 'sass']);

gulp.task('watch', function () {
    // Browse to http://localhost:3000/sub-aktuell/
    browserSync.init({
        open: false,
        proxy: 'www.dev'
    });
    gulp.watch(config.paths.sass, ['sass-lint', 'sass']);
    gulp.watch(config.paths.coffee, ['coffee']);
});

gulp.task('bower', function () {
    return bower()
        .pipe(gulp.dest('Build/bower/'));
});

gulp.task('copy-fonts', ['bower'], function () {
    return gulp.src(config.paths.fonts)
        .pipe(gulp.dest('Resources/Public/Fonts/fontawesome/'));
});

gulp.task('default', ['compile', 'watch']);
