
var gulp            = require('gulp');
var uglify          = require('gulp-uglify');
var cleanCSS        = require('gulp-clean-css');
var sass            = require('gulp-sass');
var concat          = require('gulp-concat');
var rename          = require('gulp-rename');
var merge           = require('merge-stream');
var globImporter    = require('sass-glob-importer');
var autoprefixer    = require('gulp-autoprefixer');
var del             = require('del');
var runSequence     = require('gulp4-run-sequence');

/** 
 * *****************************
 * ******** minitoring *********
 * *****************************
 */ 

/* --- css --- */
gulp.task('clean-dist-css-minitoring', function() {
    return del(['build/css/minitoring*', '!build/css'], {force: true})
});

gulp.task('build-css-minitoring', function () {
    return gulp.src(['scss/build.scss'])
    .pipe(sass({ importer: globImporter() }).on('error', sass.logError))
    .pipe(autoprefixer())    
    .pipe(cleanCSS({compatibility: '*', format: 'beautify'}))
    .pipe(rename("minitoring.css"))
    .pipe(gulp.dest('build/css'));
});
gulp.task('min-css-minitoring', function () {
    return gulp.src('build/css/minitoring.css')
    .pipe(cleanCSS({compatibility: '*'}))
    .pipe(rename({extname: ".min.css"}))
    .pipe(gulp.dest('build/css'));
});
gulp.task('copy-minitoring-css', function () {
    return gulp.src([
        'build/css/minitoring*.css',
    ])
    .pipe(gulp.dest('../../public/assets/css'));
});

/* --- js --- */
gulp.task('clean-dist-js-minitoring', function() {
    return del(['build/js/minitoring*', '!build/js'], {force: true})
});

gulp.task('merge-js-minitoring-setup', function () {
    return gulp.src([
        'js/core.js', 
        'js/setup/*.js',
    ])
    .pipe(concat('minitoring.setup.js'))
    .pipe(gulp.dest('build/js'));
});
gulp.task('merge-js-minitoring-core', function () {
    return gulp.src([
        'js/core.js', 
        'js/app/*.js',
        'js/system/*.js',
    ])
    .pipe(concat('minitoring.js'))
    .pipe(gulp.dest('build/js'));
});
gulp.task('merge-js-minitoring-config', function () {
    return gulp.src([
        'js/core.js', 
        'js/admin/*.js',
    ])
    .pipe(concat('minitoring.config.js'))
    .pipe(gulp.dest('build/js'));
});
gulp.task('merge-js-minitoring-auth', function () {
    return gulp.src([
        'js/core.js', 
        'js/auth.js',
    ])
    .pipe(concat('minitoring.auth.js'))
    .pipe(gulp.dest('build/js'));
});

gulp.task('min-js-minitoring', function () {
    return gulp.src('build/js/minitoring*.js')
    .pipe(uglify().on('error', function(e){
            console.log(e);
     }))
     .pipe(rename({extname: ".min.js"}))
     .pipe(gulp.dest('build/js'));
});

gulp.task('copy-minitoring-js', function () {
    return gulp.src([
        'build/js/minitoring*.js', 
    ])
    .pipe(gulp.dest('../../public/assets/js'));
});

// ------------------------------------
gulp.task('build-minitoring', function(log) {
    runSequence(
        ['clean-dist-css-minitoring', 'clean-dist-js-minitoring'],
        ['build-css-minitoring', 'merge-js-minitoring-core', 'merge-js-minitoring-auth', 'merge-js-minitoring-setup', 'merge-js-minitoring-config'],
        ['min-css-minitoring', 'min-js-minitoring'],
        ['copy-minitoring-css', 'copy-minitoring-js'],
//        ['copy-minikit-css-to-minitoring', 'copy-minikit-js-to-minitoring'],
        log
    );
});