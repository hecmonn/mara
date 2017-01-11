var gulp=require('gulp'),
    compass=require('gulp-compass'),
    gutil=require('gulp-util');

var sassSource='components/sass/*',
    basepath= '/Applications/XAMPP/htdocs/gpomara_prod/gpomara_admin',
    css_path=basepath+'/builds/development/public/css';
////TASKS
gulp.task('testing',function(){
    console.log("test gulp");
});
gulp.task('compass',function(){
    gulp.src(sassSource)
    .pipe(compass({
        sass:'components/sass',
        images:'builds/development/public/images',
        style:'expanded'
    }))
    .on('error',gutil.log)
    .pipe(gulp.dest('builds/development/public/css'))
});

//WATCH
gulp.task('watch',function(){
    gulp.watch(sassSource,['compass']);
});

///DEFAULT
gulp.task('default', ['compass']);
