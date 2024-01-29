const gulp            = require('gulp');
const strip           = require('gulp-strip-comments');

const sass         = require('gulp-sass');
const sourcemaps   = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const notify       = require('gulp-notify');

const rename   = require('gulp-rename');
const cleanCSS = require('gulp-clean-css');

const plumber = require('gulp-plumber');

const babel  = require('gulp-babel');
const uglify = require('gulp-uglify');

// sass
const pathShortcodes = './shortcodes/';


// task for shorcodes
gulp.task('sass', function () {
    return gulp.src(pathShortcodes + '*/assets/css/*.scss')
        .pipe(sourcemaps.init())
        .pipe(plumber())
        .pipe(sass({
                outputStyle: 'expanded',
                includePaths: ['node_modules'],
            })
                .on('error', function (err) {
                    this.emit('end');
                    return notify().write(err);
                })
        )
        .pipe(autoprefixer({
            browsers: ['> 1%', 'last 5 versions'],
            cascade: true,
        }))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(pathShortcodes))
});

gulp.task('shortcodes-js', function () {
    return gulp.src([pathShortcodes + '*/assets/js/*.js', '!' + pathShortcodes + '*/assets/js/*.min.js'])
        .pipe(sourcemaps.init())
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write('.'))
        .pipe(strip())
        .pipe(gulp.dest(pathShortcodes));
});

gulp.task('watch', function () {
    gulp.watch(pathShortcodes + '*/assets/css/*.scss', ['sass']);
    gulp.watch(pathShortcodes + '*/assets/js/*.js', ['shortcodes-js']);
});

gulp.task('default', ['watch']);

