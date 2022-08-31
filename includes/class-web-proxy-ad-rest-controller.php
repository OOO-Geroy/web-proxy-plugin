<?
class WP_REST_Web_Proxy_Ad_Controller extends WP_REST_Controller
{
  static $ts_resource_name = 'wpad';

  public function __construct()
  {
    $this->namespace = WEB_PROXY_API_NAMESPACE;
    $this->resource_name = self::$ts_resource_name;
  }

  static function request($method, $params)
  {
    $request = new WP_REST_Request($method, '/' .  WEB_PROXY_API_NAMESPACE . '/' . self::$ts_resource_name);

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

    $query_props = $this->prepare_search_query_for_database($request);

    $post_ids = get_posts($query_props);

    $response = rest_ensure_response($this->prepare_data_for_response(array_map(fn ($id) => $this->prepare_item($id), $post_ids), $request));

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

  protected function prepare_item($id)
  {
    $ad_type = get_field('ad_type', $id);

    $data = [
      'id' => $id,
      'title' => get_the_title($id),
      'ad_type' => $ad_type,
      'content' =>  apply_filters('the_content', get_post_field('post_content', $id))
    ];

    if ($ad_type ===   'header_inline') {
    } elseif ($ad_type ===   'popup') {
      $logo = wp_get_attachment_image_src(get_field('logo', $id), 'large');
      $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'large');
      

      $btn = get_field('button', $id);

      $data['cookies_max_age'] = (int) get_field('cookies_max_age', $id);
      $data['show_delay'] = (int) get_field('show_delay', $id);
      $data['tricks_type'] = get_field('tricks_type', $id);

      if ($logo)
        $data['logo'] = [
          'url' => $logo[0],
          'width' => (float) $logo[1],
          'height' => (float) $logo[2]
        ];
      if ($thumb)
        $data['background'] = [
          'url' => $thumb[0],
          'width' => (float) $thumb[1],
          'height' => (float) $thumb[2]
        ];

      if ($btn['link'])
        $data['button'] = [
          'label' =>  $btn['label'],
          'href' => $btn['link']
        ];

      $data['tricks_type'] =  get_field('tricks_type', $id);
    }

    return $data;
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
    $req_data = $request->get_query_params();
    $data = [
      'post_type'    => 'web-proxy-ad',
      'fields' => 'ids',
      'meta_query' => [
        'relation' => 'AND'
      ]
    ];

    foreach ($schema as $key => $property) {
      if (!isset($req_data[$key]) && !isset($property['default'])) continue;

      switch ($key) {
        case 'type':
          $data['meta_query'][] = [
            'key' => 'ad_type',
            'value' => isset($req_data[$key]) ? $req_data[$key] : $property['default'],
            'compare'   => '=',
          ];
          break;
        case 'per_page':
          $data['posts_per_page'] = isset($req_data[$key]) ? $req_data[$key] : 15;
          break;
        case 'page':
          $data['offset'] = isset($req_data[$key]) ? ($req_data[$key] - 1) * (isset($data['posts_per_page']) ? $data['posts_per_page'] : 1) : 0;
          break;
        default:
          $data[$key] = isset($req_data[$key]) ? $req_data[$key] : $property['default'];
          break;
      }
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
  private function prepare_data_for_response($item, $request)
  {
    require_once 'class-web-proxy-response.php';
    $message = '';
    if (strpos(WP_REST_Server::CREATABLE, $request->get_method()) !== false  && !$request->get_param('id'))
      $message = __('Ad successfully created', 'ppr');
    elseif (strpos(WP_REST_Server::EDITABLE, $request->get_method())  !== false)
      $message = __('Ad successfully updated', 'ppr');
    else
      $message = __('Ad successfully finded', 'ppr');

    return new REST_Web_Proxy_Response($item,  $message);
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
      'per_page' => [
        'description'       => __('Maximum number of items to be returned in result set.'),
        'type'              => 'integer',
        'default'           => 10,
        'minimum'           => 1,
        'sanitize_callback' => 'absint',
      ],
      'exclude' => array(
        'description'       => __('Excluded ad ids.'),
        'type'        => 'array',
        'items' => array(
          'type' => ['string', 'number']
        )
      ),
      'type' => array(
        'description'       => __('Ad type.'),
        'type'        => 'array',
        'items' => array(
          'type'   => 'string',
          'enum'        => ['header_inline', 'popup'],
        ),
      ),
      'order' => [
        'description' => __('Order sort attribute ascending or descending.'),
        'type'        => 'string',
        'default'     => 'desc',
        'enum'        => ['asc', 'desc'],
      ],
      'orderby' => array(
        'description'  => __('orderby as wp_query'),
        'type'        => 'string',
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
          'description'       => __('Ad id.'),
          'type'        => 'number'
        ),
        'tricks_type'  => array(
          'description'       => __('Trick type.'),
          'type'        => 'string',
          'enum'        => ['small', 'full', 'usual']
        ),
        'title' => array(
          'description'       => __('Ad title.'),
          'type'        => 'string'
        ),
        'ad_type' => array(
          'description'       => __('Ad type.'),
          'type'        => ['string', 'array'],
          'enum'        => ['header_inline', 'popup'],
          'items' => array([
            'type'   => 'string',
            'enum'        => ['header_inline', 'popup'],
          ]),
        ),
        'content' => array(
          'description'  => esc_html__('The label for the object.', 'ppr'),
          'type'         => 'string',
        ),
        'cookies_max_age' => array(
          'description'  => esc_html__('Cookie max age in seconds.', 'ppr'),
          'type'         => 'number',
        ),
        'show_delay' => array(
          'description'  => esc_html__('Show delay in seconds.', 'ppr'),
          'type'         => 'number',
        ),
        'logo' => array(
          'description'  => esc_html__('Show delay in seconds.', 'ppr'),
          'type'         => 'object',
          "properties" => array(
            "url" => array(
              "type" => "number"
            ),
            "width" => array(
              "type" => "number"
            ),
            "height" => array(
              "type" => "number"
            ),
          )
        ),
        'background' => array(
          'description'  => esc_html__('Show delay in seconds.', 'ppr'),
          'type'         => 'object',
          "properties" => array(
            "url" => array(
              "type" => "number"
            ),
            "width" => array(
              "type" => "number"
            ),
            "height" => array(
              "type" => "number"
            ),
          )
        ),
        'button' => array(
          'description'  => esc_html__('Show delay in seconds.', 'ppr'),
          'type'         => 'object',
          'required' => true,
          "properties" => array(
            "href" => array(
              "type" => "string",
              'required' => true
            ),
            "label" => array(
              "type" => "string",
              'required' => true
            ),
          )
        ),
      ),
    );

    return $this->schema;
  }
}
