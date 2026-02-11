<?php

// // 调试信息（仅开发环境显示）
// if (WP_DEBUG) {
//     echo '<pre style="background:#f0f0f0; padding:15px; margin:20px; border-left:3px solid #f00;">';
//     // 模板信息
//     global $template;
//     echo '【模板信息】' . PHP_EOL;
//     echo '当前文件：' . basename(__FILE__) . PHP_EOL;
//     echo 'WP 最终模板：' . basename($template) . PHP_EOL . PHP_EOL;

//     echo '【当前时间】' . date('Y-m-d H:i:s') . PHP_EOL;
//     // 查询信息
//     global $wp_query;
//     echo '【查询信息】' . PHP_EOL;
//     echo '文章总数：' . $wp_query->found_posts . PHP_EOL;
//     echo '当前页文章数：' . $wp_query->post_count . PHP_EOL;
//     echo '是否有内容：' . (have_posts() ? '是' : '否') . PHP_EOL . PHP_EOL;

//     // 页面类型
//     echo '【页面类型】' . PHP_EOL;
//     $page_type = [];
//     is_home() && $page_type[] = '首页';
//     is_single() && $page_type[] = '文章详情';
//     is_page() && $page_type[] = '静态页面';
//     is_category() && $page_type[] = '分类页';
//     is_tag() && $page_type[] = '标签页';
//     is_404() && $page_type[] = '404页面';
//     echo implode(', ', $page_type) ?: '未知类型';
//     echo '</pre>';
// }
?>
<?php get_header() ?>

<?php get_footer() ?>