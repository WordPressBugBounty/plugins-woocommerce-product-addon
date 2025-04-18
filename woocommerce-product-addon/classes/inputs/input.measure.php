<?php
/*
 * Followig class handling Measuremnts input control and their
* dependencies. Do not make changes in code
* Create on: 21 May, 2014
*/

class NM_Measure_wooproduct extends PPOM_Inputs {

	/*
	 * input control settings
	 */
	var $title, $desc, $settings;

	/*
	 * this var is pouplated with current plugin meta
	*/
	var $plugin_meta;

	function __construct() {

		$this->plugin_meta = ppom_get_plugin_meta();

		$this->title    = __( 'Measure Input', 'woocommerce-product-addon' );
		$this->desc     = __( 'Measuremnts', 'woocommerce-product-addon' );
		$this->icon     = '<i class="fa fa-building-o" aria-hidden="true"></i>';
		$this->settings = self::get_settings();

		add_filter( 'ppom_option_label', array( $this, 'change_option_label' ), 15, 4 );
	}

	function change_option_label( $label, $option, $meta, $product ) {

		if ( $meta['type'] != 'measure' ) {
			return $label;
		}

		$price = isset( $option['price'] ) ? $option['price'] : 0;
		$price = wc_price( $price );
		$label = $price . '/' . $option['option'];

		return $label;
	}

	private function get_settings() {

		$input_meta = array(
			'title'            => array(
				'type'  => 'text',
				'title' => __( 'Title', 'woocommerce-product-addon' ),
				'desc'  => __( 'It will be shown as field label', 'woocommerce-product-addon' ),
			),
			'data_name'        => array(
				'type'  => 'text',
				'title' => __( 'Data name', 'woocommerce-product-addon' ),
				'desc'  => __( 'REQUIRED: The identification name of this field, that you can insert into body email configuration. Note:Use only lowercase characters and underscores.', 'woocommerce-product-addon' ),
			),
			'description'      => array(
				'type'  => 'textarea',
				'title' => __( 'Description', 'woocommerce-product-addon' ),
				'desc'  => __( 'Small description, it will be display near name title.', 'woocommerce-product-addon' ),
			),
			'error_message'    => array(
				'type'  => 'text',
				'title' => __( 'Error message', 'woocommerce-product-addon' ),
				'desc'  => __( 'Insert the error message for validation.', 'woocommerce-product-addon' ),
			),
			'max'              => array(
				'type'        => 'text',
				'title'       => __( 'Max. values', 'woocommerce-product-addon' ),
				'desc'        => __( 'Max. values allowed, leave blank for default', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'min'              => array(
				'type'        => 'text',
				'title'       => __( 'Min. values', 'woocommerce-product-addon' ),
				'desc'        => __( 'Min. values allowed, leave blank for default', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'step'             => array(
				'type'        => 'text',
				'title'       => __( 'Steps', 'woocommerce-product-addon' ),
				'desc'        => __( 'specified legal number intervals', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'default_value'    => array(
				'type'        => 'text',
				'title'       => __( 'Set default value', 'woocommerce-product-addon' ),
				'desc'        => __( 'Pre-defined value for measure input', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'price-multiplier' => array(
				'type'        => 'text',
				'title'       => __( 'Price Multiplier', 'woocommerce-product-addon' ),
				'desc'        => __( 'Enter a value to adjust the price based on the input measurement. For example, if your price is set per meter but the measurement is entered in centimeters, you might use a multiplier of 0.01 to convert it. These multipliers ensure that the final price accurately reflects the unit of measurement entered.', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
				'default'     => 1,
			),
			'price'            => array(
				'type'        => 'text',
				'title'       => __( 'Add-on Price', 'woocommerce-product-addon' ),
				'desc'        => __( 'Price will be added as Add-on if text provided', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'class'            => array(
				'type'        => 'text',
				'title'       => __( 'Class', 'woocommerce-product-addon' ),
				'desc'        => __( 'Insert an additional class(es) (separated by comma) for more personalization.', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'width'            => array(
				'type'        => 'select',
				'title'       => __( 'Width', 'woocommerce-product-addon' ),
				'desc'        => __( 'Select width column.', 'woocommerce-product-addon' ),
				'options'     => ppom_get_input_cols(),
				'default'     => 12,
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'visibility'       => array(
				'type'        => 'select',
				'title'       => __( 'Visibility', 'woocommerce-product-addon' ),
				'desc'        => __( 'Set field visibility based on user.', 'woocommerce-product-addon' ),
				'options'     => ppom_field_visibility_options(),
				'default'     => 'everyone',
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'visibility_role'  => array(
				'type'   => 'text',
				'title'  => __( 'User Roles', 'woocommerce-product-addon' ),
				'desc'   => __( 'Role separated by comma.', 'woocommerce-product-addon' ),
				'hidden' => true,
			),
			'desc_tooltip'     => array(
				'type'        => 'checkbox',
				'title'       => __( 'Show tooltip', 'woocommerce-product-addon' ),
				'desc'        => __( 'Show Description in Tooltip with Help Icon', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'required'         => array(
				'type'        => 'checkbox',
				'title'       => __( 'Required', 'woocommerce-product-addon' ),
				'desc'        => __( 'Select this if it must be required.', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'logic'            => array(
				'type'  => 'checkbox',
				'title' => __( 'Enable Conditions', 'woocommerce-product-addon' ),
				'desc'  => __( 'Tick it to turn conditional logic to work below', 'woocommerce-product-addon' ),
			),
			'conditions'       => array(
				'type'  => 'html-conditions',
				'title' => __( 'Conditions', 'woocommerce-product-addon' ),
				'desc'  => __( 'Set rules to show or hide the field based on specific conditions', 'woocommerce-product-addon' ),
			),

		);

		$type = 'measure';

		return apply_filters( "poom_{$type}_input_setting", $input_meta, $this );
	}
}
