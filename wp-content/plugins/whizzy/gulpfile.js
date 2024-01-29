const gulp        = require('gulp');
const strip       = require('gulp-strip-comments');
const babel       = require('gulp-babel');
const browserSync = require('browser-sync').create();

const sourcemaps   = require('gulp-sourcemaps');

// need to sass
const sass         = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const notify       = require('gulp-notify');

const uglify   = require('gulp-uglify');
const rename   = require('gulp-rename');
const cleanCSS = require('gulp-clean-css');

const plumber = require('gulp-plumber');
//
// // browserSync
// gulp.task('browser-sync', function () {
// 	browserSync.init({
// 		proxy: 'http://localhost:8888/whizzy.loc',
// 	});
// });

gulp.task('scripts', function () {
	return gulp.src(['./assets/js/*.js', '!./assets/js/*.min.js'])
        .pipe(sourcemaps.init())
        .pipe(babel({
            presets: ['@babel/env']
        }))
		.pipe(uglify())
		.pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write('.'))
        .pipe(strip())
		.pipe(gulp.dest('./assets/js/'))
});

gulp.task('sass', function () {
	return gulp.src('./assets/css/*.scss')
        .pipe(sourcemaps.init())
		.pipe(plumber())
		.pipe(sass({
			outputStyle: 'expanded',
			includePaths: ['node_modules'],
		})
			.on('error', function (err) {
				this.emit('end');
				return notify().write(err);
			}))
		.pipe(autoprefixer({
			browsers: ['> 1%', 'last 5 versions'],
			cascade: true,
		}))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('./assets/css/'))
		// .pipe(browserSync.stream()); // inject css
});

//watcher
gulp.task('watch', function () {
	gulp.watch('./assets/css/*.scss', ['sass']);
	gulp.watch(['./assets/js/*.js', '!./assets/js/*.min.js'], ['scripts']);
});

gulp.task('default', ['watch']);
