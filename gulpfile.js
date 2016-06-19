var gulp = require('gulp');
	sass = require('gulp-sass');
	browserSync = require('browser-sync');
	watch = require('gulp-watch');
	util = require('gulp-util');
	notify = require('gulp-notify');
	sourcemaps = require('gulp-sourcemaps');
	plumber = require('gulp-plumber');

gulp.task('sass', function(){
	return gulp.src('resources/assets/sass/style.scss')
	.pipe(plumber())
	.pipe(sourcemaps.init())
	.pipe(sass({ outputStyle: 'compressed' }))
	.pipe(sourcemaps.write('maps/'))
	.pipe(gulp.dest('public/css/'))
	.pipe(browserSync.stream())
	.pipe(notify('sass complete'));
});

gulp.task('serve', ['sass'], function() {
	browserSync.init({
		proxy: "laradoku.dev"
	});
	gulp.watch('resources/assets/sass/*.scss', ['sass']);
	gulp.watch('resources/views/**/**').on('change', browserSync.reload);

});

gulp.task('default', ['serve']);