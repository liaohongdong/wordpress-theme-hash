<?php
if (is_admin() && !function_exists('_admin_init')):
  function _admin_init()
  {
    if (!current_user_can('manage_options')) {
      return;
    }
    $admin = new Admin();
    $admin->init();
    // var_dump($options);
    // echo json_encode($options, JSON_UNESCAPED_UNICODE);
  }

  add_action('init', '_admin_init', 20);
endif;
