<?php

// 保存设置
if (!function_exists('admin_save_callback')) {
  function admin_save_callback()
  {
    if (!current_user_can('manage_options')) {
      wp_send_json_error('你没有权限执行此操作');
    }

    $json = file_get_contents('php://input');
    $json = parseQueryToJsonAdvanced($json);
    $json = json_decode($json, true);
    $json = sanitize_deep_escape_html($json);
    $_POST = $json ?? []; // check_ajax_referer 只能从 $_POST 读取 nonce，
    if (!check_ajax_referer('admin_save', 'nonce', false)) {
      // $nonce = $json['nonce'] ?? '';
      // if (!wp_verify_nonce($nonce, 'admin_save')) {
      wp_send_json(array(
        'success' => false,
        'data' => '',
        'message' => '安全验证失败，请刷新页面重试'
      ));
      return;
    }
    if (json_last_error() !== JSON_ERROR_NONE) {
      wp_send_json_error('数据格式错误');
      return;
    }
    $errors = get_settings_errors('admin_options');
    if (!empty($errors)) {
      // 提取错误消息
      $error_messages = array_column($errors, 'message');
      wp_send_json_error([
        'message' => implode(', ', $error_messages)
      ]);
      return;
    }
    update_option('my_plugin_settings', $_POST['item']);
    wp_send_json_success([
      'message' => '保存成功',
      'data' => '',
    ]);
  }
}
add_action('wp_ajax_admin_save', 'admin_save_callback');
add_action('wp_ajax_nopriv_admin_save', 'admin_save_callback');
