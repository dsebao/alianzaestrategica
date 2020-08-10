"use strict";

// Load plugins
const autoprefixer = require("gulp-autoprefixer");
const browsersync = require("browser-sync").create();
const cleanCSS = require("gulp-clean-css");
const del = require("del");
const gulp = require("gulp");
const merge = require("merge-stream");
const concat = require("gulp-concat");
const plumber = require("gulp-plumber");
const rename = require("gulp-rename");
const sass = require("gulp-sass");
const uglify = require("gulp-uglify");
const terser = require('gulp-terser');

function errorLog(error) {
  console.error(error);
  this.emit('end');
}

// BrowserSync
function browserSync(done) {
  browsersync.init({
    proxy: "alianza.local",
  });
  done();
}

// BrowserSync reload
function browserSyncReload(done) {
  browsersync.reload();
  done();
}

// Clean vendor
function clean() {
  return del(["./vendor/"]);
}

// Bring third party dependencies from node_modules into vendor directory
function modules() {
  // Bootstrap JS
  var bootstrapJS = gulp.src('./node_modules/bootstrap/dist/js/*')
    .pipe(gulp.dest('./vendor/bootstrap/js'));

  // Validation JS
  var validatorJS = gulp.src('./node_modules/jquery-validation/dist/*')
    .pipe(gulp.dest('./vendor/validation'));

  // Bootstrap SCSS
  var bootstrapSCSS = gulp.src('./node_modules/bootstrap/scss/**/*')
    .pipe(gulp.dest('./vendor/bootstrap/scss'));

  // Select2
  var select2 = gulp.src('./node_modules/select2/dist/**/*')
    .pipe(gulp.dest('./vendor/select2'));

  // ChartJS
  //var chartJS = gulp.src('./node_modules/chart.js/dist/*.js')
  //.pipe(gulp.dest('./vendor/chart.js'));
  // dataTables
  var dataTables = gulp.src([
    './node_modules/datatables.net/js/*.js',
    './node_modules/datatables.net-bs4/js/*.js',
    './node_modules/datatables.net-bs4/css/*.css'
  ])
    .pipe(gulp.dest('./vendor/datatables'));
  // Font Awesome
  var fontAwesome = gulp.src('./node_modules/@fortawesome/**/*')
    .pipe(gulp.dest('./vendor'));

  // Notie
  var notie = gulp.src('./node_modules/notie/dist/**/*')
    .pipe(gulp.dest('./vendor/notie'));

  // jQuery Easing
  var jqueryEasing = gulp.src('./node_modules/jquery.easing/*.js')
    .pipe(gulp.dest('./vendor/jquery-easing'));

  // BS tags input
  var bstagsinput = gulp.src('./node_modules/bootstrap4-tagsinput/**/*')
    .pipe(gulp.dest('./vendor/bs4tagsinput'));

  // jQuery
  var jquery = gulp.src([
    './node_modules/jquery/dist/*',
    '!./node_modules/jquery/dist/core.js'
  ])
    .pipe(gulp.dest('./vendor/jquery'));

  //Removed ChartJs const
  return merge(bootstrapJS, bootstrapSCSS, dataTables, notie, validatorJS, select2, fontAwesome, jquery, jqueryEasing, bstagsinput);
}


// CSS task
function css() {
  return gulp
    .src("./scss/**/*.scss")
    .pipe(plumber())
    .pipe(sass({
      outputStyle: "expanded",
      includePaths: "./node_modules",
    }))
    .on("error", sass.logError)
    .pipe(autoprefixer({
      cascade: false
    }))
    .pipe(gulp.dest("./"))
    .pipe(rename({
      suffix: ".min"
    }))
    .pipe(cleanCSS())
    .pipe(gulp.dest("./"))
    .pipe(browsersync.stream());
}

// JS task
function js() {
  var libs = gulp
    .src([
      './js/libs/**/*.js',
    ])
    .pipe(concat('./libs.js'))
    .pipe(gulp.dest('./js'))
    .pipe(terser())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('./js'));
  //.pipe(browsersync.stream());

  var app = gulp
    .src([
      './js/*.js',
      '!./js/*.min.js',
    ])
    .pipe(terser())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('./js'));
  //.pipe(browsersync.stream());

  return merge(libs, app).pipe(browsersync.stream());
}

// Watch files
function watchFiles() {
  gulp.watch("./scss/**/*", css);
  gulp.watch(["./js/**/*", "!./js/**/*.min.js", "!./js/main.js"], js);
  gulp.watch("./**/*.php", browserSyncReload);
}

// Define complex tasks
const vendor = gulp.series(clean, modules);
const build = gulp.series(vendor, gulp.parallel(css, js));
const watch = gulp.series(build, gulp.parallel(watchFiles, browserSync));

// Export tasks
exports.css = css;
exports.js = js;
exports.clean = clean;
exports.vendor = vendor;
exports.build = build;
exports.watch = watch;
exports.default = build;
