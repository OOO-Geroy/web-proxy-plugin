<?
class WP_REST_Apartments_Controller extends WP_REST_Controller
{
  static $ts_resource_name = 'ad';
  static $ts_namespace = 'webproxy/v1';

  public function __construct()
  {
    $this->namespace = self::$ts_namespace;
    $this->resource_name = self::$ts_resource_name;
  }

  static function request($method, $params)
  {
    $request = new WP_REST_Request($method, '/' . self::$ts_namespace . '/' . self::$ts_resource_name);

    if (isset($params['body']))
      $request->set_body_params($params['body']);
    elseif (isset($params['query']))
      $request->set_query_params($params['query']);

    $response = rest_do_request($request);
    $server = rest_get_server();
    $data = $server->response_to_data($response, false);

    return [$data, $response];
  }

  public function register_routes()
  {
    register_rest_route($this->namespace, '/' . $this->resource_name, array(
      array(
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => array($this, 'get_items'),
        'permission_callback' => array($this, 'get_items_permissions_check'),
        'args'                => $this->get_collection_params(),
      ),
      'schema' => array($this, 'get_item_schema'),
    ));

    register_rest_route($this->namespace, '/' . $this->resource_name . '/schema', array(
      'methods'  => WP_REST_Server::READABLE,
      'callback' => array($this, 'get_item_schema'),
      'permission_callback' => '__return_true'
    ));
  }

  /**
   * Grabs the five most recent posts and outputs them as a rest response.
   *
   * @param WP_REST_Request $request Current request.
   */
  public function get_items($request)
  {

    $ads = get_posts([
      'post_type'   => 'web-proxy-ad',
      'posts_per_page' => 1,
      'orderby' => 'rand'
    ]);


    $ads_arr = array_map(fn ($ad) => [
      'id' => $ad->ID,
      'label' => get_field('label', $ad->ID),
      'link' => get_field('link', $ad->ID),
    ], $ads);

    $response = rest_ensure_response($this->prepare_data_for_response($ads_arr, $request));

    return $response;
  }

  /**
   * Get one item from the collection
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Response
   */
  public function get_item($request)
  {
    //get parameters from request
    $params = $request->get_params();
    $item = array(); //do a query, call another class, etc
    $data = $this->prepare_data_for_response($item, $request);
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
   * Prepare search query for db.
   *
   * @param WP_REST_Request $request Request object
   * @return array $prepared_array
   */
  protected function prepare_search_query_for_database($request)
  {
    $schema = $this->get_collection_params();
    $req_data = $request->get_params();
    $data = [];

    foreach ($schema as $key => $property) {
      if (!isset($req_data[$key])) continue;
      $data[$key] = $req_data[$key];
    }

    return $data;
  }

  /**
   * Prepare and wrap the data for the REST response
   *
   * @param mixed $item WordPress representation of the item.
   * @param WP_REST_Request $request Request object.
   * @return mixed
   */
  public function prepare_data_for_response($item, $request)
  {
    $message = '';
    if (str_contains(WP_REST_Server::CREATABLE, $request->get_method())  && !$request->get_param('id'))
      $message = __('Ad successfully created', 'ppr');
    elseif (str_contains(WP_REST_Server::EDITABLE, $request->get_method()))
      $message = __('Ad successfully updated', 'ppr');
    else
      $message = __('Ad successfully finded', 'ppr');

    return ['data' => $item, 'message' => $message];
  }

  public function authorization_status_code()
  {

    $status = 401;

    if (is_user_logged_in()) {
      $status = 403;
    }

    return $status;
  }

  /**
   * Get the query params for collections
   *
   * @return array
   */
  public function get_collection_params()
  {
    return  array(
      'page'     => array(
        'description'       => 'Current page of the collection.',
        'type'              => 'integer',
        'default'           => 1,
        'sanitize_callback' => 'absint',
      ),
      'per_page' => array(
        'description'       => 'Maximum number of items to be returned in result set.',
        'type'              => 'integer',
        'default'           => 10,
        'sanitize_callback' => 'absint',
      ),
    );;
  }

  /**
   * Get our schema.
   *
   * @return array The schema
   */
  public function get_item_schema()
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
        'id' => array(
          'description'  => esc_html__('Unique identifier for the object.', 'ppr'),
          'type'         => 'integer',
          'context'      => array('view', 'edit'),
          'readonly'     => true,
        ),
        'label' => array(
          'description'  => esc_html__('The label for the object.', 'ppr'),
          'type'         => 'string',
          'required'     => true,
        ),
        'link' => array(
          'description'  => esc_html__('The link for the object.', 'ppr'),
          'type'         => 'string',
          'required'     => true,
        ),
      ),
    );

    return $this->schema;
  }
}
