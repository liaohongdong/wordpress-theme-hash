<?php

if (!function_exists('admin_options')) {
  function admin_options()
  {
    $params = _js_parameters();
    var_dump('admin_options44');
    wp_localize_script('hash-admin-js', '__params', $params);

    do_action('admin_js');
  }
}

add_action('admin_enqueue_scripts', 'admin_options', 15);

if (!function_exists('_js_parameters')) {
  function _js_parameters()
  {
    var_dump('js_parameters33');
    $registered_settings = get_registered_settings(); // 获取所有已注册的合法设置项
    $params = array(
      'ajax_url' => admin_url('admin-ajax.php'),
      'theme_url' => get_template_directory_uri(),
      'site_url' => get_site_url(),
      'home_url' => get_home_url(),
      'is_logged_in' => is_user_logged_in(),
      'user_info' => is_user_logged_in() ? wp_get_current_user() : null,
      'test_me_nonce' => wp_create_nonce('test_me'),
      'ajaxNonce' => wp_create_nonce('custom_ajax_nonce'),
    );
    if (isset($registered_settings[Admin::get_admin_options_name()])) {
      $data = get_option(Admin::get_admin_options_name());
      if ($data) {
        $params[Admin::get_admin_options_name()] = get_option(Admin::get_admin_options_name());
      } else {
        $params[Admin::get_admin_options_name()] = Admin::_admin_options();
      }
    }
    return $params;
  }
}


add_action('admin_custom_scripts11111', 'save');
function save()
{
  var_dump('xxx function called');
}

if (!function_exists('test_me_callback')) {
  function test_me_callback()
  {
    // 安全验证：验证 nonce 令牌（必须！防止恶意请求）
    if (!check_ajax_referer('test_me', 'nonce', false)) {
      wp_send_json(array(
        'success' => false,
        'data' => '',
        'message' => '安全验证失败，请刷新页面重试1'
      ));
    }
    // if (!wp_verify_nonce($_POST['nonce'], 'test_me_nonce')) {
    //   // wp_send_json_error(array('msg' => '安全验证失败，请刷新页面重试'));
    //   wp_send_json(array(
    //     'success' => false,
    //     'data' => '',
    //     'message' => '安全验证失败，请刷新页面重试2'
    //   ));
    // }
    // 初始化响应数据
    $response = array(
      'success' => false,
      'data' => '',
      'message' => ''
    );
    try {
      // 1. 获取前端传递的参数（示例：获取名为 'user_input' 的参数）
      $input = isset($_POST['input']) ? sanitize_text_field($_POST['input']) : '';

      // 验证参数（可选，根据业务需求）
      if (empty($input)) {
        throw new Exception('请输入有效内容');
      }

      // 2. 核心业务逻辑（示例：处理用户输入，返回处理结果）
      $processed_data = '你输入的内容是：' . $input;

      // 3. 组装成功响应
      $response['success'] = true;
      $response['data'] = $processed_data;
      $response['message'] = 'successMsg'; // 也可直接写字符串

    } catch (Exception $e) {
      // 捕获异常，返回错误响应
      $response['message'] = $e->getMessage();
    }

    // 4. 返回 JSON 响应（WordPress 专用函数，自动设置 JSON 头并终止请求）
    wp_send_json($response);
    // wp_send_json_success(array('message' => 'Test me AJAX response'));
  }
}

add_action('wp_ajax_test_me', 'test_me_callback');
add_action('wp_ajax_nopriv_test_me', 'test_me_callback');

// 保存设置
if (!function_exists('admin_save_callback')) {
  function admin_save_callback() {

  }
}
add_action('wp_ajax_admin_save', 'admin_save_callback');
add_action('wp_ajax_nopriv_admin_save', 'admin_save_callback');
