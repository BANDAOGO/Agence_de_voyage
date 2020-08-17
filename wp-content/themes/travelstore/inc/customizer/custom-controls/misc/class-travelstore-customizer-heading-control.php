<?php
/**
 * Custom heading control for the customizer to separate the controls.
 *
 * @package travelstore
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Exit if WP_Customize_Control does not exists.
 */
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

if ( ! class_exists( 'Travelstore_Customizer_Heading_Control' ) ) {

	/**
	 * Class for custom-heading control in customizer.
	 */
	class Travelstore_Customizer_Heading_Control extends WP_Customize_Control {

		/**
		 * The type of customize control.
		 *
		 * @access public
		 * @since  1.0.0
		 * @var    string
		 */
		public $type = 'heading';

		/**
		 * Enqueue scripts and styles.
		 *
		 * @access public
		 * @since  1.0.0
		 * @return void
		 */
		public function enqueue() {
			$path   = esc_url( TRAVELSTORE_CHILD_DIR_URI . '/inc/customizer/custom-controls/misc' );
			$handle = 'travelstore-customizer-heading-control';
		}

		/**
		 * Create control template.
		 *
		 * @access public
		 * @since  1.0.0
		 * @return void
		 */
		public function render_content() {
			$label       = ! empty( $this->label ) ? $this->label : '';
			$attrs       = ! empty( $this->input_attrs ) ? $this->input_attrs : array();
			$tag         = ! empty( $attrs['tag'] ) ? $attrs['tag'] : 'h2';
			$description = ! empty( $this->description ) ? $this->description : '';

			?>
			<label class="customizer-custom-heading">
				<div class="customizer-custom-heading--wrapper">
					<?php if ( $label ) { ?>
						<hr>
						<<?php echo esc_attr( $tag ); ?>><?php echo esc_html( $label ); ?></<?php echo esc_attr( $tag ); ?>>
						<hr>
					<?php } ?>
					<?php if ( ! empty( $description ) ) { ?>
						<span class="description customize-control-description"><?php echo esc_html( $description ); ?></span>
					<?php } ?>
				</div>
			</label>
			<?php
		}

	}
}
