<?php
/*
 * Followig class handling textarea input control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Textarea_wooproduct extends PPOM_Inputs {

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

		$this->title    = __( 'Textarea Input', 'woocommerce-product-addon' );
		$this->desc     = __( 'regular textarea input', 'woocommerce-product-addon' );
		$this->icon     = '<i class="fa fa-file-text-o" aria-hidden="true"></i>';
		$this->settings = self::get_settings();

	}


	private function get_settings() {

		$input_meta = array(
			'title'           => array(
				'type'  => 'text',
				'title' => __( 'Title', 'woocommerce-product-addon' ),
				'desc'  => __( 'It will be shown as field label', 'woocommerce-product-addon' ),
			),
			'data_name'       => array(
				'type'  => 'text',
				'title' => __( 'Data name', 'woocommerce-product-addon' ),
				'desc'  => __( 'REQUIRED: The identification name of this field, that you can insert into body email configuration. Note:Use only lowercase characters and underscores.', 'woocommerce-product-addon' ),
			),
			'description'     => array(
				'type'  => 'textarea',
				'title' => __( 'Description', 'woocommerce-product-addon' ),
				'desc'  => __( 'Small description, it will be display near name title.', 'woocommerce-product-addon' ),
			),
			'placeholder'     => array(
				'type'  => 'text',
				'title' => __( 'Placeholder', 'woocommerce-product-addon' ),
				'desc'  => __( 'Optional.', 'woocommerce-product-addon' ),
			),
			'error_message'   => array(
				'type'  => 'text',
				'title' => __( 'Error message', 'woocommerce-product-addon' ),
				'desc'  => __( 'Insert the error message for validation.', 'woocommerce-product-addon' ),
			),
			'default_value'   => array(
				'type'  => 'text',
				'title' => __( 'Post ID', 'woocommerce-product-addon' ),
				'desc'  => __( 'It will pull content from post. e.g: 22', 'woocommerce-product-addon' ),
			),
			'max_length'      => array(
				'type'        => 'text',
				'title'       => __( 'Max. Length', 'woocommerce-product-addon' ),
				'desc'        => __( 'Max. characters allowed, leave blank for default', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'price'           => array(
				'type'        => 'text',
				'title'       => __( 'Add-on Price', 'woocommerce-product-addon' ),
				'desc'        => __( 'Price will be added as Add-on if text provided', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'class'           => array(
				'type'        => 'text',
				'title'       => __( 'Class', 'woocommerce-product-addon' ),
				'desc'        => __( 'Insert an additional class(es) (separated by comma) for more personalization.', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'width'           => array(
				'type'        => 'select',
				'title'       => __( 'Width', 'woocommerce-product-addon' ),
				'desc'        => __( 'Select width column', 'woocommerce-product-addon' ),
				'options'     => ppom_get_input_cols(),
				'default'     => 12,
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'visibility'      => array(
				'type'    => 'select',
				'title'   => __( 'Visibility', 'woocommerce-product-addon' ),
				'desc'    => __( 'Set field visibility based on user.', 'woocommerce-product-addon' ),
				'options' => ppom_field_visibility_options(),
				'default' => 'everyone',
			),
			'visibility_role' => array(
				'type'   => 'text',
				'title'  => __( 'User Roles', 'woocommerce-product-addon' ),
				'desc'   => __( 'Role separated by comma.', 'woocommerce-product-addon' ),
				'hidden' => true,
			),
			'rich_editor'     => array(
				'type'        => 'checkbox',
				'title'       => __( 'Rich Editor', 'woocommerce-product-addon' ),
				'desc'        => __( 'Enable WordPress rich editor.', 'woocommerce-product-addon' ),
				'link'        => '<a target="_blank" href="https://codex.wordpress.org/Function_Reference/wp_editor">' . __( 'Editor', 'woocommerce-product-addon' ) . '</a>',
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'desc_tooltip'    => array(
				'type'        => 'checkbox',
				'title'       => __( 'Show tooltip', 'woocommerce-product-addon' ),
				'desc'        => __( 'Show Description in Tooltip with Help Icon', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'required'        => array(
				'type'        => 'checkbox',
				'title'       => __( 'Required', 'woocommerce-product-addon' ),
				'desc'        => __( 'Select this if it must be required.', 'woocommerce-product-addon' ),
				'col_classes' => array( 'col-md-3', 'col-sm-12' ),
			),
			'logic'           => array(
				'type'  => 'checkbox',
				'title' => __( 'Enable Conditions', 'woocommerce-product-addon' ),
				'desc'  => __( 'Tick it to turn conditional logic to work below', 'woocommerce-product-addon' ),
			),
			'conditions'      => array(
				'type'  => 'html-conditions',
				'title' => __( 'Conditions', 'woocommerce-product-addon' ),
				'desc'  => __( 'Set rules to show or hide the field based on specific conditions', 'woocommerce-product-addon' ),
			),
		);

		$type = 'textarea';

		return apply_filters( "poom_{$type}_input_setting", $input_meta, $this );
	}
}
