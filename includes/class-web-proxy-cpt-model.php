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
class Web_Proxy_Cpt_Model
{

	function __construct()
	{
	}

	public function register_cpt()
	{
		register_post_type('web-proxy-ad', [
			'label'  => null,
			'labels' => [
				'name'               => 'Web Proxy Ad',
				'singular_name'      => 'Web Proxy Ad',
			],
			'description'         => '',
			'public'              => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'show_in_menu'        => 'web-proxy-plugin',
			'show_in_rest'        => false,
			'menu_icon'           => null,
			'hierarchical'        => false,
			'supports'            => ['title'],
			'taxonomies'          => [],
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
		]);
	}
}
