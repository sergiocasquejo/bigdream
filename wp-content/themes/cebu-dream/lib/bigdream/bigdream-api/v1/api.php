<?php
//https://php-built.com/making-an-api-endpoint-in-wordpress-using-add_rewrite_rule/
add_action('admin_init', function() {
  $regex = 'bigdreams-api/v1/([^/]*)/([^/]*)/?';
  $location = 'index.php?_api_controller=$matches[1]&_api_action=$matches[2]';
  $priority = 'top';
  add_rewrite_rule( $regex, $location, $priority );
});

add_filter( 'query_vars', function($vars) {
  array_push($vars, '_api_controller');
  array_push($vars, '_api_action');
  return $vars;
} );

add_filter( 'template_include', function($template) {
  $controller = get_query_var('_api_controller', null);
  $action = get_query_var('_api_action', null);
  if($controller && $action) {
    wp_send_json(['api' => 'v1'] );
  }
  return $template;
}, 99 );
