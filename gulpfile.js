
const { src, dest, watch } = require('gulp');
const sass = require('gulp-sass');
const minifyCSS = require('gulp-csso');
const babel = require('gulp-babel');
const concat = require('gulp-concat');
const browserSync = require('browser-sync').create();
const sass_glob  = require( 'gulp-sass-glob' )

function css() {
  return src('./assets/scss/*.scss', { sourcemaps: true })
      .pipe(sass_glob())
      .pipe(sass())
      .pipe(minifyCSS())
      .pipe(dest('./assets/css'), { sourcemaps: true })
      .pipe(browserSync.stream());
}

function js() {
  return src('./assets/js/site/*.js', { sourcemaps: true })
      .pipe(babel({
          presets: ['@babel/env']
      }))
      .pipe(concat('site.js'))
      .pipe(dest('./assets/js', { sourcemaps: true }));
}


function browser() {
  browserSync.init({
      proxy: 'https://meentadevelop.local',
      files: [
          '*.php',
          '**/*.php'
      ]
  });

  // /* Copy fontawesome webfonmts into dist dir - otherwise we will need to update font paths in fontawesome every time we update the assets */
  // src('./assets/scss/fontawesome/webfonts/*')
  //   .pipe(dest('./dist/webfonts'));

  watch('./assets/scss/**/*.scss', css);
  watch('./assets/js/*.js', js).on('change', browserSync.reload);
}

exports.css = css;
exports.js = js;
exports.default = browser;