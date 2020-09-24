<?php
/**
 * The main class that handles frontend forms.
 *
 * @package    Meta Box
 * @subpackage MB Frontend Form Submission
 */

/**
 * Frontend form class.
 */
class MB_Frontend_Form {
	/**
	 * Meta box object.
	 *
	 * @var RW_Meta_Box
	 */
	public $meta_box;

	/**
	 * The object model that meta box is for. Default is post.
	 *
	 * @var MB_Frontend_Object_Model
	 */
	public $object;

	/**
	 * Form configuration.
	 *
	 * @var array
	 */
	public $config;

	/**
	 * Constructor.
	 *
	 * @param RW_Meta_Box              $meta_box Meta box object.
	 * @param MB_Frontend_Object_Model $object   Object model where the custom fields belong to.
	 * @param array                    $config   Form configuration.
	 */
	public function __construct( RW_Meta_Box $meta_box, MB_Frontend_Object_Model $object, $config ) {
		$this->meta_box = $meta_box;
		$this->object   = $object;
		$this->config   = $config;
	}

	/**
	 * Output the form.
	 */
	public function render() {
		$this->enqueue();

		if ( $this->is_processed() ) {
			do_action( 'rwmb_frontend_before_display_confirmation', $this->config );
			$this->display_confirmation();
			do_action( 'rwmb_frontend_after_display_confirmation', $this->config );

			return;
		}

		echo '<form class="rwmb-form" method="post" enctype="multipart/form-data" encoding="multipart/form-data">';
		$this->render_hidden_fields();

		// Register wp color picker scripts for frontend.
		$this->register_scripts();

		$this->meta_box->enqueue();

		wp_localize_jquery_ui_datepicker();

		$this->object->render();
		$this->meta_box->show();

		echo '<div class="rwmb-field rwmb-button-wrapper rwmb-form-submit"><button class="rwmb-button" name="rwmb_submit" value="1">', esc_html( $this->config['submit_button'] ), '</button></div>';
		echo '</form>';
	}

	/**
	 * Process the form.
	 * Meta box auto hooks to 'save_post' action to save its data, so we only need to save the post.
	 */
	public function process() {
		if ( $this->meta_box->validate() ) {
			$this->object->save();
			do_action( 'rwmb_frontend_after_process', $this->config );
		}
	}

	/**
	 * Register scripts.
	 */
	private function register_scripts() {
		if ( wp_script_is( 'iris', 'registered' ) ) {
			return;
		}
		wp_register_script( 'iris', admin_url( 'js/iris.min.js' ), array(
			'jquery-ui-draggable',
			'jquery-ui-slider',
			'jquery-touch-punch',
		), '1.0.7', true );
		wp_register_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), '', true );

		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', array(
			'clear'         => __( 'Clear', 'mb-frontend-submission' ),
			'defaultString' => __( 'Default', 'mb-frontend-submission' ),
			'pick'          => __( 'Select Color', 'mb-frontend-submission' ),
			'current'       => __( 'Current Color', 'mb-frontend-submission' ),
		) );
	}

	/**
	 * Enqueue scripts and styles for the forms.
	 */
	private function enqueue() {
		wp_enqueue_style( 'mb-frontend-form', MB_FRONTEND_SUBMISSION_URL . 'css/style.css', '', '1.0' );

		wp_enqueue_script( 'mb-frontend-form', MB_FRONTEND_SUBMISSION_URL . 'js/script.js', array(), '1.0', true );
		wp_localize_script( 'mb-frontend-form', 'mbFrontendForm', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		) );
	}

	/**
	 * Render hidden fields for form configuration.
	 */
	private function render_hidden_fields() {
		foreach ( $this->config as $key => $value ) {
			echo '<input type="hidden" name="rwmb_form_config[', esc_attr( $key ), ']" value="', esc_attr( $value ), '">';
		}
	}

	/**
	 * Check if the form is processed and process it if necessary.
	 *
	 * @return bool True if the form has been processed, false otherwise.
	 */
	private function is_processed() {
		return filter_input( INPUT_GET, 'rwmb-form-submitted' ) === $this->meta_box->id;
	}

	/**
	 * Display confirmation message.
	 */
	private function display_confirmation() {
		MB_Frontend_Helpers::load_template( 'confirmation', '', $this->config );
	}
}
