class BigDreams_API {

  $version = 1.0;
  $controller = '';
  $action = '';


  public static function register() {
    add_action('admin_init', array($this, 'add_rewrite_rule'));
    add_action('query_vars', array($this, 'register_query_vars'));
    add_action('template_include', array($this, 'include_template'), 99 );
  }

  public function add_rewrite_rule() {
    $regex = 'bigdreams-api/v1/([^/]*)/([^/]*)/?';
    $location = 'index.php?_api_controller=$matches[1]&_api_action=$matches[2]';
    $priority = 'top';
    add_rewrite_rule( $regex, $location, $priority );
  }

  public function register_query_vars($vars) {
    array_push($vars, '_api_controller');
    array_push($vars, '_api_action');
    return $vars;
  }

  public function use_this() {
    $this->controller = get_query_var('_api_controller', null);
    $this->action = get_query_var('_api_action', null);

    if($this->controller && $this->action) {
      return true;
    }
    return false;
  }

  public function include_template($template) {
    if($this->use_this()) {
      $this->process_endpoint_data();
    }

    return $template;
  }


  private function process_endpoint_data() {
    wp_send_json(['api' => $_REQUEST] );
  }
}



BigDreams_API::register();
