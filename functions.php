<?php
if (!defined('ABSPATH')) {
  exit;
}

function custom_login_expiry_time($expiration)
{
  return 30 * 24 * 60 * 60; // 24小时的秒数
}
add_filter('auth_cookie_expiration', 'custom_login_expiry_time');

if (function_exists('get_theme_file_path')) {
  require_once get_theme_file_path('/core/index.php');
  require_once get_theme_file_path('/admin/admin.php');
  require_once get_theme_file_path('/admin/index.php');
  require_once get_theme_file_path('/admin/wp-ajax.php');
}

// /**
//  * 打印 WordPress Action 钩子的执行顺序
//  * 仅用于调试，上线前请删除
//  */
// function log_hook_execution_order($tag)
// {
//   // 排除重复输出和部分高频钩子，减少日志冗余
//   static $logged_hooks = array();
//   if (in_array($tag, $logged_hooks) || strpos($tag, 'do_action') !== false) {
//     return;
//   }
//   $logged_hooks[] = $tag;
//   // 输出钩子名称 + 优先级
//   error_log('Hook Executed: ' . $tag);
//   // 也可以直接打印到页面（仅适合前端调试）
//   echo '<div style="background:#f5f5f5; padding:2px; font-size:12px;">Hook: ' . $tag . '</div>';
// }
// // 监听所有 Action 钩子的添加，记录执行顺序
// add_action('all', 'log_hook_execution_order', 1);


// 打印WordPress所有内置权限标识
function show_all_wp_caps()
{
  global $wp_roles;
  $all_caps = array();
  foreach ($wp_roles->roles as $role => $details) {
    foreach ($details['capabilities'] as $cap => $bool) {
      $all_caps[$cap] = $cap;
    }
  }
  sort($all_caps);
  echo '<pre>WordPress所有权限标识：';
  print_r($all_caps);
  echo '</pre>';
}
// add_action( 'wp_head', 'show_all_wp_caps' );

// add_action('init', 'print_all_wp_filter', 999); // 确保所有过滤器已注册后执行
function print_all_wp_filter()
{
  global $wp_filter;

  // 方法1：print_r 强制递归（depth=-1 表示无限深度）
  // echo '<pre>'; // 格式化输出
  // print_r( $wp_filter, true ); // true 表示返回字符串，避免直接输出乱码
  // echo '</pre>';

  // 方法2：var_export 更清晰的结构（推荐）
  // echo '<pre>';
  // var_export( $wp_filter );
  // echo '</pre>';

  // 方法3：针对 WP_Hook 对象，拆解 callbacks 属性（精准打印回调）
  foreach ($wp_filter as $filter_name => $hook_obj) {
    echo "<h3>过滤器：{$filter_name}</h3>";
    if (isset($hook_obj->callbacks)) {
      echo '<pre>';
      print_r($hook_obj->callbacks); // 直接打印 优先级→回调 结构
      echo '</pre>';
    }
  }
}

// function custom_admin_localize_scripts()
// {
//   var_dump('functions');
//   // 1. 定义JS文件路径（以主题目录为例）
//   $admin_js_path = get_template_directory_uri() . '/assets/js/admin-custom.js';
//   // wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery4.0.js', array(), '4.0.2', true);
//   // 2. 注册并入队后台JS脚本（handle名称要唯一，这里用custom-admin-script）
//   wp_enqueue_script(
//     'custom-admin-script', // 脚本handle（核心标识，后续localize要用到）
//     $admin_js_path,       // JS文件URL
//     array('jquery'),      // 依赖（比如依赖jQuery，WordPress后台默认加载jQuery）
//     '1.0.0',              // 版本号
//     true                  // 是否在</body>前加载（推荐true，优化加载）
//   );

//   // 3. 使用wp_localize_script传递PHP数据到JS
//   wp_localize_script(
//     'custom-admin-script', // 必须和上面的handle完全一致
//     'AdminLocalData',      // JS中访问的全局对象名（自定义，比如AdminLocalData）
//     array(                 // 要传递的PHP数据（键值对）
//       'ajax_url' => admin_url('admin-ajax.php'), // 后台AJAX请求地址（常用）
//       'site_name' => get_bloginfo('name'),       // 网站名称
//       'nonce' => wp_create_nonce('custom-admin-nonce'), // 安全验证nonce
//       'admin_page' => get_current_screen()->id,   // 当前后台页面ID
//       'message' => __('操作成功！', 'text-domain') // 多语言文本
//     )
//   );

//   // 可选：只在特定后台页面加载（比如仅文章编辑页）
//   $current_screen = get_current_screen();
//   if ($current_screen->id !== 'post') {
//     return; // 非文章编辑页则不加载
//   }
// }
// // 后台入队脚本的专用钩子：admin_enqueue_scripts
// add_action('admin_enqueue_scripts', 'custom_admin_localize_scripts');
