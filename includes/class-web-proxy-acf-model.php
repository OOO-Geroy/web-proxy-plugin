<?php

/**
 * Post Model and ACF Group
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Web_Proxy
 * @subpackage Web_Proxy/includes
 */

/**
 * Post Model and ACF Group
 *.
 *
 * @since      1.0.0
 * @package    Web_Proxy
 * @subpackage Web_Proxy/includes
 * @author     Your Name <email@example.com>
 */
class Web_Proxy_Acf_Model
{

	function __construct()
	{
	}

	public function register_acf_groups()
	{
		$this->register_acf_ad_groups();
		$this->register_acf_settings_groups();
	}

	private function register_acf_ad_groups()
	{
		if (function_exists('acf_add_local_field_group')) :

			acf_add_local_field_group(array(
				'key' => 'group_62ec070ededb8',
				'title' => 'Web Proxy',
				'fields' => array(
					array(
						'key' => 'field_6304ffc8af393',
						'label' => 'Ad Type',
						'name' => 'ad_type',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'header_inline' => 'Header Inline',
							'popup' => 'Popup',
						),
						'default_value' => 'header_unline',
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'return_format' => 'value',
						'ajax' => 0,
						'placeholder' => '',
					),
					array(
						'key' => 'field_630500605c8fb',
						'label' => 'Cookie\'s max age',
						'name' => 'cookies_max_age',
						'type' => 'select',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_6304ffc8af393',
									'operator' => '==',
									'value' => 'popup',
								),
							),
						),
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							3600 => '1 hour',
							7200 => '2 hours',
							21600 => '6 hours',
							43200 => '12 hours',
							86400 => '24 hours',
							172800 => '2 days',
							604800 => '1 week',
						),
						'default_value' => 86400,
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'return_format' => 'value',
						'ajax' => 0,
						'placeholder' => '',
					),
					array(
						'key' => 'field_6305027c5c8fc',
						'label' => 'Delay in seconds before popup appears',
						'name' => 'show_delay',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_6304ffc8af393',
									'operator' => '==',
									'value' => 'popup',
								),
							),
						),
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							0 => '0s',
							2 => '2s',
							5 => '5s',
							7 => '7s',
							10 => '10s',
							20 => '20s',
							30 => '30s',
							60 => '60s',
							90 => '90s',
						),
						'default_value' => 0,
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'return_format' => 'value',
						'ajax' => 0,
						'placeholder' => '',
					),
					array(
						'key' => 'field_630504555c8fd',
						'label' => 'Logo',
						'name' => 'logo',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_6304ffc8af393',
									'operator' => '==',
									'value' => 'popup',
								),
							),
						),
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'id',
						'preview_size' => 'medium',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					),
					array(
						'key' => 'field_630504825c8fe',
						'label' => 'Tricks type',
						'name' => 'tricks_type',
						'type' => 'radio',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_6304ffc8af393',
									'operator' => '==',
									'value' => 'popup',
								),
							),
						),
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'small' => 'Affiliate\'s website opens in new small browser\'s tab, then it dissapears after a while',
							'full' => 'Affiliate\'s website opens in the same browser\'s tab and in new tab opens the same page',
							'usual' => 'Typical popup, which appears without any tricks',
						),
						'allow_null' => 0,
						'other_choice' => 0,
						'default_value' => 'type_3',
						'layout' => 'vertical',
						'return_format' => 'value',
						'save_other_choice' => 0,
					),
					array(
						'key' => 'field_6306a70e03b83',
						'label' => 'Button',
						'name' => 'button',
						'type' => 'group',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_6304ffc8af393',
									'operator' => '==',
									'value' => 'popup',
								),
							),
						),
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'layout' => 'block',
						'sub_fields' => array(
							array(
								'key' => 'field_6306a71903b84',
								'label' => 'Label',
								'name' => 'label',
								'type' => 'text',
								'instructions' => '',
								'required' => 1,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'field_6306a72003b85',
								'label' => 'Link',
								'name' => 'link',
								'type' => 'url',
								'instructions' => '',
								'required' => 1,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
							),
						),
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'web-proxy-ad',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));

		endif;
	}

	private function register_acf_settings_groups()
	{
		if (function_exists('acf_add_local_field_group')) :

			acf_add_local_field_group(array(
				'key' => 'group_62fe9061d504a',
				'title' => 'Web Proxy Settings',
				'fields' => array(
					array(
						'key' => 'field_62fe906755e01',
						'label' => 'Logo',
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array(
						'key' => 'field_62fe9f4389d2d',
						'label' => 'Logo',
						'name' => 'web_proxy_logo',
						'type' => 'group',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'sub_fields' => array(
							array(
								'key' => 'field_62fe923c55e03',
								'label' => 'Image',
								'name' => 'image',
								'type' => 'image',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'return_format' => 'id',
								'preview_size' => 'medium',
								'library' => 'all',
								'min_width' => '',
								'min_height' => '',
								'min_size' => '',
								'max_width' => '',
								'max_height' => '',
								'max_size' => '',
								'mime_types' => '',
							),
							array(
								'key' => 'field_62fe921555e02',
								'label' => 'Link',
								'name' => 'link',
								'type' => 'url',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
							),
						),
						'layout' => 'block',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'web-proxy-plugin-options',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));

		endif;
	}
}
