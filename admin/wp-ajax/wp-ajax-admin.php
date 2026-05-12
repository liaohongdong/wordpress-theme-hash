<?php

// 保存设置
if (!function_exists('admin_save_callback')) {
  function admin_save_callback()
  {
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
    }
    $item = $data['item'] ?? [];
    // $item = $_POST['item'] ?? [];
    // $item = isset($_POST['item']) ? json_decode(stripslashes($_POST['item']), true) : [];
    error_log(print_r($item, true));
    // 初始化响应数据
    $response = array(
      'success' => false,
      'data' => $_POST['item'],
      'message' => 'haha'
    );
    wp_send_json($response);
  }
}
add_action('wp_ajax_admin_save', 'admin_save_callback');
add_action('wp_ajax_nopriv_admin_save', 'admin_save_callback');

/**
 * 解析查询字符串为数组
 * @param string $input 查询字符串或完整URL
 * @return array 解析后的关联数组
 */
function parseQueryToArray(string $input): array
{
  if (trim($input) === '') {
    return [];
  }

  $queryString = $input;
  if (str_contains($input, '?')) {
    $urlParts = parse_url($input);
    $queryString = $urlParts['query'] ?? '';
  }

  $result = [];
  parse_str($queryString, $result);

  return $result;
}

/**
 * 将数组转换为查询字符串
 * @param array $data 关联数组
 * @return string 标准查询字符串
 */
function arrayToQueryString(array $data): string
{
  return http_build_query($data);
}

/**
 * 解析查询字符串为JSON（基于数组函数封装）
 */
function parseQueryToJsonAdvanced(string $input): string
{
  $array = parseQueryToArray($input);
  return json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

// 双向转换示例
// $query = "action=admin_save&nonce=ae6653f359";
// $array = parseQueryToArray($query);
// $json = parseQueryToJsonAdvanced($query);
// $newQuery = arrayToQueryString($array);

// echo "数组：\n";
// print_r($array);
// echo "\nJSON：\n$json\n";
// echo "\n转回查询字符串：\n$newQuery\n";
