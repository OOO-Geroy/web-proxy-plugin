<?
class WP_REST_Web_Proxy_Settings_Controller extends WP_REST_Controller
{
  static $ts_resource_name = 'settings';

  public function __construct()
  {
    $this->namespace = WEB_PROXY_API_NAMESPACE;
    $this->resource_name = self::$ts_resource_name;
  }

  public function register_routes()
  {
    register_rest_route($this->namespace, '/' . $this->resource_name, array(
      array(
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => array($this, 'get_settings'),
        'permission_callback' => array($this, 'get_items_permissions_check'),
      ),
      'schema' => array($this, 'get_schema'),
    ));
  }

  /**
   * Get site settings
   *
   * @param WP_REST_Request $request Current request.
   */
  public function get_settings($request)
  {

    $logo = $this->prepare_logo_settings();

    $response = rest_ensure_response($this->prepare_data_for_response($logo, $request));

    return $response;
  }


  private function prepare_logo_settings() {
    $logo = get_field('web_proxy_logo','options');

    return [
      'logo' => [
        'link' =>  $logo['image'] ? wp_get_attachment_image_url($logo['image'], 'large') : '',
        'image_src' => $logo['link'] ?: '',
      ]
     
    ];
  }

  /**
   * Check if a given request has access to get items
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool
   */
  public function get_items_permissions_check($request)
  {
    /* if (!current_user_can('read')) {
      return new WP_Error('rest_forbidden', esc_html__('You cannot view the post resource.'), array('status' => $this->authorization_status_code()));
    }*/
    return true;
  }

  /**
   * Check if a given request has access to get a specific item
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool
   */
  public function get_item_permissions_check($request)
  {
    /*if (!current_user_can('read')) {
      return new WP_Error('rest_forbidden', esc_html__('You cannot view the post resource.'), array('status' => $this->authorization_status_code()));
    }*/
    return true;
  }


  /**
   * Prepare and wrap the data for the REST response
   *
   * @param mixed $item WordPress representation of the item.
   * @param WP_REST_Request $request Request object.
   * @return mixed
   */
  public function prepare_data_for_response($data, $message = '')
  {
    require_once 'class-web-proxy-response.php';

    return new REST_Web_Proxy_Response($data,  $message);
  }

  /**
   * Get settings schema.
   *
   * @return array The schema
   */
  public function get_schema()
  {
    if ($this->schema) {
      // Since WordPress 5.3, the schema can be cached in the $schema property.
      return $this->schema;
    }

    $this->schema = array(
      // This tells the spec of JSON Schema we are using which is draft 4.
      '$schema'              => 'http://json-schema.org/draft-04/schema#',
      // The title property marks the identity of the resource.
      'title'                => 'web proxy ad',
      'type'                 => 'object',
      // In JSON Schema you can specify object properties in the properties attribute.
      'properties'           => array(
        'logo' => array(
          'description'  => esc_html__('Logo settings.', 'ppr'),
          'type'         => 'object',
          "properties" => array(
            'link' => array(
              'description'  => esc_html__('Unique identifier for the object.', 'ppr'),
              'type'         => 'string',
            ),
            'image_src' => array(
              'description'  => esc_html__('The label for the object.', 'ppr'),
              'type'         => 'string',
              'required'     => true,
            ),
          )
        )
      ),
    );

    return $this->schema;
  }
}
