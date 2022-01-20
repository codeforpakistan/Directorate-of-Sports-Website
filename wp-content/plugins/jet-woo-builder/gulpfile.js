'use strict';

let gulp         = require('gulp'),
	rename       = require('gulp-rename'),
	notify       = require('gulp-notify'),
	autoprefixer = require('gulp-autoprefixer'),
	uglify       = require('gulp-uglify-es').default,
	sass         = require('gulp-sass'),
	plumber      = require('gulp-plumber'),
	checktextdomain = require('gulp-checktextdomain');

let sassSettings = {
	outputStyle: 'compressed',
	linefeed:    'crlf',
	indentType:  'tab',
	indentWidth: 1
};

//css
gulp.task('css-frontend', () => {
	return gulp.src('./assets/scss/jet-woo-builder.scss')
		.pipe(
			plumber( {
				errorHandler: function ( error ) {
					console.log('=================ERROR=================');
					console.log(error.message);
					this.emit( 'end' );
				}
			})
		)
		.pipe(sass( sassSettings ))
		.pipe(autoprefixer({
				browsers: ['last 10 versions'],
				cascade: false
		}))

		.pipe(rename('jet-woo-builder.css'))
		.pipe(gulp.dest('./assets/css/'))
		.pipe(notify('Compile Sass Done!'));
});

// for integrated theme styles
gulp.task('css-frontend-theme', () => {
	return gulp.src('./includes/integrations/themes/kava/assets/scss/style.scss')
		.pipe(
			plumber( {
				errorHandler: function ( error ) {
					console.log('=================ERROR=================');
					console.log(error.message);
					this.emit( 'end' );
				}
			})
		)
		.pipe(sass( sassSettings ))
		.pipe(autoprefixer({
			browsers: ['last 10 versions'],
			cascade: false
		}))

		.pipe(rename('style.css'))
		.pipe(gulp.dest('./includes/integrations/themes/kava/assets/css/'))
		.pipe(notify('Compile Sass Done!'));
});

gulp.task('css-admin', () => {
	return gulp.src('./assets/scss/admin.scss')
		.pipe(
			plumber( {
				errorHandler: function ( error ) {
					console.log('=================ERROR=================');
					console.log(error.message);
					this.emit( 'end' );
				}
			})
		)
		.pipe(sass( sassSettings ))
		.pipe(autoprefixer({
				browsers: ['last 10 versions'],
				cascade: false
		}))

		.pipe(rename('admin.css'))
		.pipe(gulp.dest('./assets/css/'))
		.pipe(notify('Compile Sass Done!'));
});

gulp.task('css-editor', () => {
	return gulp.src('./assets/scss/editor.scss')
		.pipe(
			plumber( {
				errorHandler: function ( error ) {
					console.log('=================ERROR=================');
					console.log(error.message);
					this.emit( 'end' );
				}
			})
		)
		.pipe(sass( sassSettings ))
		.pipe(autoprefixer({
				browsers: ['last 10 versions'],
				cascade: false
		}))

		.pipe(rename('editor.css'))
		.pipe(gulp.dest('./assets/css/'))
		.pipe(notify('Compile Sass Done!'));
});

gulp.task('css-template-styles', () => {
	return gulp.src('./assets/scss/template-styles.scss')
		.pipe(
			plumber( {
				errorHandler: function ( error ) {
					console.log('=================ERROR=================');
					console.log(error.message);
					this.emit( 'end' );
				}
			})
		)
		.pipe(sass( sassSettings ))
		.pipe(autoprefixer({
			browsers: ['last 10 versions'],
			cascade: false
		}))

		.pipe(rename('template-styles.css'))
		.pipe(gulp.dest('./assets/css/'))
		.pipe(notify('Compile Sass Done!'));
});

//css-icons
gulp.task( 'css-icons', () => {
	return gulp.src( './assets/scss/jet-woo-builder-icons.scss' )
		.pipe(
			plumber( {
				errorHandler: function( error ) {
					console.log( '=================ERROR=================' );
					console.log( error.message );
					this.emit( 'end' );
				}
			} )
		)
		.pipe( sass( sassSettings ) )
		.pipe( autoprefixer( {
			browsers: ['last 10 versions'],
			cascade:  false
		} ) )

		.pipe( rename( 'jet-woo-builder-icons.css' ) )
		.pipe( gulp.dest( './assets/css/' ) )
		.pipe( notify( 'Compile Sass Done!' ) );
} );

// Minify JS
gulp.task( 'admin-vue-js-minify', function() {
	return gulp.src( './assets/js/admin-vue-components.js' )
		.pipe( uglify() )
		.pipe( rename( { extname: '.min.js' } ) )
		.pipe( gulp.dest( './assets/js/' ) )
		.pipe( notify( 'js Minify Done!' ) );
} );

gulp.task( 'ajax-handler-js-minify', function() {
	return gulp.src( './assets/js/ajax-single-add-to-cart.js' )
		.pipe( uglify() )
		.pipe( rename( { extname: '.min.js' } ) )
		.pipe( gulp.dest( './assets/js/' ) )
		.pipe( notify( 'js Minify Done!' ) );
} );

gulp.task( 'admin-js-minify', function() {
	return gulp.src( './assets/js/jet-woo-builder-admin.js' )
		.pipe( uglify() )
		.pipe( rename( { extname: '.min.js' } ) )
		.pipe( gulp.dest( './assets/js/' ) )
		.pipe( notify( 'js Minify Done!' ) );
} );

gulp.task( 'frontend-js-minify', function() {
	return gulp.src( './assets/js/jet-woo-builder.js' )
		.pipe( uglify() )
		.pipe( rename( { extname: '.min.js' } ) )
		.pipe( gulp.dest( './assets/js/' ) )
		.pipe( notify( 'js Minify Done!' ) );
} );

gulp.task( 'popup-js-minify', function() {
	return gulp.src( './assets/js/template-popup.js' )
		.pipe( uglify() )
		.pipe( rename( { extname: '.min.js' } ) )
		.pipe( gulp.dest( './assets/js/' ) )
		.pipe( notify( 'js Minify Done!' ) );
} );

//watch
gulp.task('watch', () => {
	gulp.watch( './assets/scss/**', gulp.series( ...[ 'css-frontend', 'css-admin', 'css-editor', 'css-template-styles', 'css-icons' ] ) );
	gulp.watch( './assets/js/**', gulp.series( ...[ 'admin-vue-js-minify', 'ajax-handler-js-minify', 'admin-js-minify', 'frontend-js-minify', 'popup-js-minify' ] ) );
});

gulp.task( 'checktextdomain', () => {
	return gulp.src( ['**/*.php', '!cherry-framework/**/*.php'] )
		.pipe( checktextdomain( {
			text_domain: 'jet-woo-builder',
			keywords:    [
				'__:1,2d',
				'_e:1,2d',
				'_x:1,2c,3d',
				'esc_html__:1,2d',
				'esc_html_e:1,2d',
				'esc_html_x:1,2c,3d',
				'esc_attr__:1,2d',
				'esc_attr_e:1,2d',
				'esc_attr_x:1,2c,3d',
				'_ex:1,2c,3d',
				'_n:1,2,4d',
				'_nx:1,2,4c,5d',
				'_n_noop:1,2,3d',
				'_nx_noop:1,2,3c,4d',
				'translate_nooped_plural:1,2c,3d'
			]
		} ) );
} );
