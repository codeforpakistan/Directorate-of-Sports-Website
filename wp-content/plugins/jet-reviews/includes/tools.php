<?php
/**
 * Cherry addons tools class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Reviews_Tools' ) ) {

	/**
	 * Define Jet_Reviews_Tools class
	 */
	class Jet_Reviews_Tools {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Get post types options list
		 *
		 * @return array
		 */
		public function get_post_types() {

			$post_types = get_post_types( array( 'public' => true ), 'objects' );

			$deprecated = apply_filters(
				'jet-reviews/post-types-list/deprecated',
				array(
					'attachment',
					'elementor_library',
					'jet-theme-core',
					'jet-menu',
					'jet-engine',
					'jet-engine-booking',
					'jet-popup',
					'jet-smart-filters',
					'jet-woo-builder',
				)
			);

			$result = array();

			if ( empty( $post_types ) ) {
				return $result;
			}

			foreach ( $post_types as $slug => $post_type ) {

				if ( in_array( $slug, $deprecated ) ) {
					continue;
				}

				$result[ $slug ] = $post_type->label;

			}

			return $result;

		}

		/**
		 * [get_post_types_options description]
		 * @return [type] [description]
		 */
		public function get_post_types_options() {

			$post_types = $this->get_post_types();

			$post_types_options = array(
				array(
					'label' => esc_html__( 'All', 'jet-reviews' ),
					'value' => '',
				)
			);

			foreach ( $post_types as $slug => $name ) {
				$post_types_options[] = array(
					'label' => $name,
					'value' => $slug,
				);
			}

			return $post_types_options;
		}

		/**
		 * Get categories list.
		 *
		 * @return array
		 */
		public function get_categories() {

			$categories = get_categories();

			if ( empty( $categories ) || ! is_array( $categories ) ) {
				return array();
			}

			return wp_list_pluck( $categories, 'name', 'term_id' );

		}

		/**
		 * [get_content_allowed_html description]
		 * @return [type] [description]
		 */
		public function get_content_allowed_html() {
			return array(
				'a' => array(
					'href'  => true,
					'title' => true,
				),
				'br'     => array(),
				'em'     => array(),
				'strong' => array()
			);
		}

		/**
		 * [get_editable_roles description]
		 * @return [type] [description]
		 */
		public function get_roles_options() {
			global $wp_roles;

			$all_roles = $wp_roles->roles;

			$roles_options = array();

			foreach ( $all_roles as $role_slug => $role_data ) {
				$roles_options[] = array(
					'label' => $role_data['name'],
					'value' => $role_slug,
				);
			}

			$roles_options[] = array(
				'label' => esc_html__( 'Guest', 'jet-reviews' ),
				'value' => 'guest',
			);

			return $roles_options;
		}

		/**
		 * [human_time_diff_by_date description]
		 * @param  boolean $date [description]
		 * @return [type]        [description]
		 */
		public function human_time_diff_by_date( $date = false ) {

			if ( ! $date ) {
				return false;
			}

			$date_time = strtotime( $date );

			$after = esc_html__( ' ago', 'jet-reviews' );

			return human_time_diff( $date_time, current_time( 'timestamp' ) ) . $after;
		}

		/**
		 * [get_post_review_type_data description]
		 * @return [type] [description]
		 */
		public function get_post_review_type_data() {

			$post_type = get_post_type( get_the_ID() );

			$post_type_data = jet_reviews()->settings->get_post_type_data( $post_type );

			$is_exist = jet_reviews()->reviews_manager->data->is_review_type_exist( $post_type_data['review_type'] );

			if ( $is_exist ) {
				$review_type = $post_type_data['review_type'];
			} else {
				$review_type = 'default';
			}

			$review_type_data = \Jet_Reviews\Reviews\Data::get_instance()->get_review_type( $post_type_data['review_type'] );

			if ( ! empty( $review_type_data ) ) {

				$review_type_data = $review_type_data[0];

				$review_type_data['fields'] = maybe_unserialize( $review_type_data['fields'] );

				return $review_type_data;
			}

			return false;
		}

		/**
		 * Returns columns classes string
		 * @param  [type] $columns [description]
		 * @return [type]          [description]
		 */
		public function col_classes( $columns = array() ) {

			$columns = wp_parse_args( $columns, array(
				'desk' => 1,
				'tab'  => 1,
				'mob'  => 1,
			) );

			$classes = array();

			foreach ( $columns as $device => $cols ) {
				if ( ! empty( $cols ) ) {
					$classes[] = sprintf( 'col-%1$s-%2$s', $device, $cols );
				}
			}

			return implode( ' ' , $classes );
		}

		/**
		 * Returns disable columns gap nad rows gap classes string
		 *
		 * @param  string $use_cols_gap [description]
		 * @param  string $use_rows_gap [description]
		 * @return [type]               [description]
		 */
		public function gap_classes( $use_cols_gap = 'yes', $use_rows_gap = 'yes' ) {

			$result = array();

			foreach ( array( 'cols' => $use_cols_gap, 'rows' => $use_rows_gap ) as $element => $value ) {
				if ( 'yes' !== $value ) {
					$result[] = sprintf( 'disable-%s-gap', $element );
				}
			}

			return implode( ' ', $result );

		}

		/**
		 * Returns image size array in slug => name format
		 *
		 * @return  array
		 */
		public function get_image_sizes() {

			global $_wp_additional_image_sizes;

			$sizes  = get_intermediate_image_sizes();
			$result = array();

			foreach ( $sizes as $size ) {
				if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
					$result[ $size ] = ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) );
				} else {
					$result[ $size ] = sprintf(
						'%1$s (%2$sx%3$s)',
						ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
						$_wp_additional_image_sizes[ $size ]['width'],
						$_wp_additional_image_sizes[ $size ]['height']
					);
				}
			}

			return array_merge( array( 'full' => esc_html__( 'Full', 'jet-reviews' ), ), $result );
		}

		/**
		 * Returns icons data list.
		 *
		 * @return array
		 */
		public function get_theme_icons_data() {

			$default = array(
				'icons'  => false,
				'format' => 'fa %s',
				'file'   => false,
			);

			/**
			 * Filter default icon data before useing
			 *
			 * @var array
			 */
			$icon_data = apply_filters( 'jet-reviews/controls/icon/data', $default );
			$icon_data = array_merge( $default, $icon_data );

			return $icon_data;
		}

		/**
		 * Returns allowed order by fields for options
		 *
		 * @return array
		 */
		public function orderby_arr() {
			return array(
				'none'          => esc_html__( 'None', 'jet-reviews' ),
				'ID'            => esc_html__( 'ID', 'jet-reviews' ),
				'author'        => esc_html__( 'Author', 'jet-reviews' ),
				'title'         => esc_html__( 'Title', 'jet-reviews' ),
				'name'          => esc_html__( 'Name (slug)', 'jet-reviews' ),
				'date'          => esc_html__( 'Date', 'jet-reviews' ),
				'modified'      => esc_html__( 'Modified', 'jet-reviews' ),
				'rand'          => esc_html__( 'Rand', 'jet-reviews' ),
				'comment_count' => esc_html__( 'Comment Count', 'jet-reviews' ),
				'menu_order'    => esc_html__( 'Menu Order', 'jet-reviews' ),
			);
		}

		/**
		 * Returns allowed order fields for options
		 *
		 * @return array
		 */
		public function order_arr() {

			return array(
				'desc' => esc_html__( 'Descending', 'jet-reviews' ),
				'asc'  => esc_html__( 'Ascending', 'jet-reviews' ),
			);

		}

		/**
		 * Returns allowed order by fields for options
		 *
		 * @return array
		 */
		public function verrtical_align_attr() {
			return array(
				'baseline'    => esc_html__( 'Baseline', 'jet-reviews' ),
				'top'         => esc_html__( 'Top', 'jet-reviews' ),
				'middle'      => esc_html__( 'Middle', 'jet-reviews' ),
				'bottom'      => esc_html__( 'Bottom', 'jet-reviews' ),
				'sub'         => esc_html__( 'Sub', 'jet-reviews' ),
				'super'       => esc_html__( 'Super', 'jet-reviews' ),
				'text-top'    => esc_html__( 'Text Top', 'jet-reviews' ),
				'text-bottom' => esc_html__( 'Text Bottom', 'jet-reviews' ),
			);
		}

		/**
		 * Returns array with numbers in $index => $name format for numeric selects
		 *
		 * @param  integer $to Max numbers
		 * @return array
		 */
		public function get_select_range( $to = 10 ) {
			$range = range( 1, $to );

			return array_combine( $range, $range );
		}

		/**
		 * Returns badge placeholder URL
		 *
		 * @return void
		 */
		public function get_badge_placeholder() {
			return jet_reviews()->plugin_url( 'assets/images/placeholder-badge.svg' );
		}

		/**
		 * Rturns image tag or raw SVG
		 *
		 * @param  string $url  image URL.
		 * @param  array  $attr [description]
		 * @return string
		 */
		public function get_image_by_url( $url = null, $attr = array() ) {

			$url = esc_url( $url );

			if ( empty( $url ) ) {
				return;
			}

			$ext  = pathinfo( $url, PATHINFO_EXTENSION );
			$attr = array_merge( array( 'alt' => '' ), $attr );

			if ( 'svg' !== $ext ) {
				return sprintf( '<img src="%1$s"%2$s>', $url, $this->get_attr_string( $attr ) );
			}

			$base_url = network_site_url( '/' );
			$svg_path = str_replace( $base_url, ABSPATH, $url );
			$key      = md5( $svg_path );
			$svg      = get_transient( $key );

			if ( ! $svg ) {
				$svg = file_get_contents( $svg_path );
			}

			if ( ! $svg ) {
				return sprintf( '<img src="%1$s"%2$s>', $url, $this->get_attr_string( $attr ) );
			}

			set_transient( $key, $svg, DAY_IN_SECONDS );

			unset( $attr['alt'] );

			return sprintf( '<div%2$s>%1$s</div>', $svg, $this->get_attr_string( $attr ) ); ;
		}

		/**
		 * Return attributes string from attributes array.
		 *
		 * @param  array  $attr Attributes string.
		 * @return string
		 */
		public function get_attr_string( $attr = array() ) {

			if ( empty( $attr ) || ! is_array( $attr ) ) {
				return;
			}

			$result = '';

			foreach ( $attr as $key => $value ) {
				$result .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( $value ) );
			}

			return $result;
		}

		/**
		 * Returns carousel arrow
		 *
		 * @param  array $classes Arrow additional classes list.
		 * @return string
		 */
		public function get_carousel_arrow( $classes ) {

			$format = apply_filters( 'jet_reviews/carousel/arrows_format', '<i class="%s jet-arrow"></i>', $classes );

			return sprintf( $format, implode( ' ', $classes ) );
		}

		/**
		 * Return availbale arrows list
		 * @return [type] [description]
		 */
		public function get_available_prev_arrows_list() {

			return apply_filters(
				'jet_reviews/carousel/available_arrows/prev',
				array(
					'fa fa-angle-left'          => __( 'Angle', 'jet-reviews' ),
					'fa fa-chevron-left'        => __( 'Chevron', 'jet-reviews' ),
					'fa fa-angle-double-left'   => __( 'Angle Double', 'jet-reviews' ),
					'fa fa-arrow-left'          => __( 'Arrow', 'jet-reviews' ),
					'fa fa-caret-left'          => __( 'Caret', 'jet-reviews' ),
					'fa fa-long-arrow-left'     => __( 'Long Arrow', 'jet-reviews' ),
					'fa fa-arrow-circle-left'   => __( 'Arrow Circle', 'jet-reviews' ),
					'fa fa-chevron-circle-left' => __( 'Chevron Circle', 'jet-reviews' ),
					'fa fa-caret-square-o-left' => __( 'Caret Square', 'jet-reviews' ),
				)
			);

		}

		/**
		 * Return availbale arrows list
		 * @return [type] [description]
		 */
		public function get_available_next_arrows_list() {

			return apply_filters(
				'jet_reviews/carousel/available_arrows/next',
				array(
					'fa fa-angle-right'          => __( 'Angle', 'jet-reviews' ),
					'fa fa-chevron-right'        => __( 'Chevron', 'jet-reviews' ),
					'fa fa-angle-double-right'   => __( 'Angle Double', 'jet-reviews' ),
					'fa fa-arrow-right'          => __( 'Arrow', 'jet-reviews' ),
					'fa fa-caret-right'          => __( 'Caret', 'jet-reviews' ),
					'fa fa-long-arrow-right'     => __( 'Long Arrow', 'jet-reviews' ),
					'fa fa-arrow-circle-right'   => __( 'Arrow Circle', 'jet-reviews' ),
					'fa fa-chevron-circle-right' => __( 'Chevron Circle', 'jet-reviews' ),
					'fa fa-caret-square-o-right' => __( 'Caret Square', 'jet-reviews' ),
				)
			);

		}

		/**
		 * Render structured data
		 * @param  [type] $data [description]
		 * @return [type]       [description]
		 */
		public function render_structured_data( $data ) {

			$data = wp_parse_args( $data, array(
				'item_name'     => '',
				'item_image'    => '',
				'item_desc'     => '',
				'item_rating'   => '',
				'review_date'   => '',
				'review_author' => '',
			) );

			$sdata = array(
				'@context' => 'https://schema.org',
				'@type' => 'Review',
				'itemReviewed' => array(
					'@type' => 'Thing',
					'name' => $data['item_name'],
				),
				'reviewRating' => array(
					'@type' => 'Rating',
					'ratingValue' => $data['item_rating'],
				),
				'description' => $data['item_desc'],
				'datePublished' => date( 'c', strtotime( $data['review_date'] ) ),
				'author' => array(
					'@type' => 'Person',
					'name' => $data['review_author']
				)
			);

			if ( ! empty( $data['item_image'] ) ) {
				$sdata['itemReviewed']['image'] = array(
					'@type'  => 'ImageObject',
					'url'    => $data['item_image']['url'],
					'width'  => $data['item_image']['width'],
					'height' => $data['item_image']['height'],
				);
			}

			$json_data = json_encode( $sdata );

			printf( '<script type="application/ld+json">%s</script>', $json_data );

		}


		/**
		 * [get_icon_html description]
		 * @param  boolean $icon_setting [description]
		 * @return [type]                [description]
		 */
		public function get_elementor_icon_html( $icon_setting = false, $attr = array(), $default = false ) {

			if ( ! $icon_setting || empty( $icon_setting[ 'value' ] ) ) {
				return $default;
			}

			ob_start();
			\Elementor\Icons_Manager::render_icon( $icon_setting, $attr );
			return ob_get_clean();
		}

		/**
		 * [is_demo_mode description]
		 * @return boolean [description]
		 */
		public function is_demo_mode() {
			$demo_mode = apply_filters( 'jet-reviews/demo-mode/enabled', false );

			return $demo_mode;
		}

		/**
		 * [get_default_reviews_dataset description]
		 * @return [type] [description]
		 */
		public function get_default_reviews_dataset() {
			return array(
				array(
					'label'   => __( 'Jan', 'jet-reviews' ),
					'month'   => 1,
				),
				array(
					'label'   => __( 'Feb', 'jet-reviews' ),
					'month'   => 2,
				),
				array(
					'label'   => __( 'Mar', 'jet-reviews' ),
					'month'   => 3,
				),
				array(
					'label'   => __( 'Apr', 'jet-reviews' ),
					'month'   => 4,
				),
				array(
					'label'   => __( 'May', 'jet-reviews' ),
					'month'   => 5,
				),
				array(
					'label'   => __( 'Jun', 'jet-reviews' ),
					'month'   => 6,
				),
				array(
					'label'   => __( 'Jul', 'jet-reviews' ),
					'month'   => 7,
				),
				array(
					'label'   => __( 'Aug', 'jet-reviews' ),
					'month'   => 8,
				),
				array(
					'label'   => __( 'Sep', 'jet-reviews' ),
					'month'   => 9,
				),
				array(
					'label'   => __( 'Oct', 'jet-reviews' ),
					'month'   => 10,
				),
				array(
					'label'   => __( 'Nov', 'jet-reviews' ),
					'month'   => 11,
				),
				array(
					'label'   => __( 'Dec', 'jet-reviews' ),
					'month'   => 12,
				),
			);
		}

		/**
		 * @return array[]
		 */
		public function get_structure_data_types() {
			return apply_filters( 'jet-reviews/structure-data/types', [
				[
					'label'   => __( 'Thing', 'jet-reviews' ),
					'value'   => 'Thing',
				],
				[
					'label'   => __( 'Product', 'jet-reviews' ),
					'value'   => 'Product',
				],
				[
					'label'   => __( 'Place', 'jet-reviews' ),
					'value'   => 'Place',
				],
				[
					'label'   => __( 'Service', 'jet-reviews' ),
					'value'   => 'Service',
				],
				[
					'label'   => __( 'Organization', 'jet-reviews' ),
					'value'   => 'Organization',
				],
				[
					'label'   => __( 'Event', 'jet-reviews' ),
					'value'   => 'Event',
				],
				[
					'label'   => __( 'CreativeWork', 'jet-reviews' ),
					'value'   => 'CreativeWork',
				],
			] );
		}

		/**
		 * [rand_hex_color description]
		 * @return [type] [description]
		 */
		function rand_hex_color() {
			return '#' . str_pad( dechex( mt_rand( 0, 0xFFFFFF ) ), 6, '0', STR_PAD_LEFT );
		}

		/**
		 * @param int $length
		 *
		 * @return string
		 */
		public function generate_rand_string( $length = 10 ) {
			return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance( $shortcodes = array() ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $shortcodes );
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of Jet_Reviews_Tools
 *
 * @return object
 */
function jet_reviews_tools() {
	return Jet_Reviews_Tools::get_instance();
}
