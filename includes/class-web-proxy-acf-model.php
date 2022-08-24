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

			/*acf_add_local_field_group(array(
				'key' => 'group_62ec070ededb8',
				'title' => 'Web Proxy Ad',
				'fields' => array(
					array(
						'key' => 'field_62ec1a8944ad0',
						'label' => 'Label',
						'name' => 'label',
						'type' => 'text',
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
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62ec071d5171e',
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
			));*/

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
