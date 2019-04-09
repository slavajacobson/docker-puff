'use strict';
var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglifycss = require('gulp-uglifycss');
var browserSync = require('browser-sync').create();
sass.compiler = require('node-sass');
 gulp.task('browser-sync', function() {
        browserSync.init({
        proxy: "localhost",
        watchTask: true,
        notify: false,
        scrollProportionally: false,
    });
});
gulp.task('sass', function () {
  return gulp.src('./nickzack/build/css/*/*.sass')
    .pipe(sass().on('error', sass.logError))
    .pipe(concat('main.css'))
    .pipe(gulp.dest('./nickzack/build/css/compiled'))
    .pipe(browserSync.reload({stream:true}));
});
gulp.task('watch',function(){
    gulp.watch('./nickzack/build/css/*/*.sass', gulp.series('sass'));
    gulp.watch('./nickzack/build/css/partials/loader.css', gulp.series('sass'));
    gulp.watch('./nickzack/build/css/*/*.sass',browserSync.reload);
    gulp.watch('./nickzack/build/html/*/*.php',browserSync.reload);
    gulp.watch('./nickzack/build/js/*.js',browserSync.reload);
})

gulp.task('minify', function () {
  gulp.src('./nickzack/build/css/compiled/main.css')
    .pipe(uglifycss({
      "maxLineLen": 1,
      "uglyComments": true
    }))
    .pipe(gulp.dest('./build/css/compiled/minified/'));
    
});


gulp.task('watchAll', gulp.parallel('browser-sync','watch'));
gulp.task('min', gulp.series('minify'));