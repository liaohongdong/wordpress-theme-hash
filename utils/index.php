<?php

/**
 * 通用递归数据清理（HTML转义模式）
 * 保留所有标签的原始文本，转义为安全的纯文本显示
 * 100% 防止XSS，同时完整保留用户输入的所有内容
 */
function sanitize_deep_escape_html($data)
{
  // 空值直接返回
  if (empty($data)) {
    return $data;
  }

  // 数字和布尔值直接返回
  if (is_int($data) || is_float($data) || is_bool($data)) {
    return $data;
  }

  // 字符串：HTML转义（核心）
  if (is_string($data)) {
    return esc_html($data);
  }

  // 数组：递归清理每一项
  if (is_array($data)) {
    return array_map('sanitize_deep_escape_html', $data);
  }

  // 对象：转数组再递归
  if (is_object($data)) {
    return sanitize_deep_escape_html((array)$data);
  }

  return '';
}

/**
 * 安全的 esc_html 反转义函数
 * 还原 HTML 实体，同时过滤所有危险代码
 * @param string $str 被 esc_html 转义后的字符串
 * @return string 可安全输出的 HTML
 */
function esc_html_decode_safe($str)
{
  if (!is_string($str)) {
    return $str;
  }

  // 第一步：还原所有 HTML 实体
  $decoded = html_entity_decode($str, ENT_QUOTES, 'UTF-8');

  // 第二步：过滤危险标签和属性（核心安全防护）
  return wp_kses_post($decoded);
}

/**
 * 递归安全反转义（支持数组、嵌套数组）
 * 与 sanitize_deep_escape_html 完全配套使用
 */
function esc_html_decode_deep($data)
{
  if (empty($data)) {
    return $data;
  }

  if (is_string($data)) {
    return esc_html_decode_safe($data);
  }

  if (is_int($data) || is_float($data) || is_bool($data)) {
    return $data;
  }

  if (is_array($data)) {
    return array_map('esc_html_decode_deep', $data);
  }

  if (is_object($data)) {
    return esc_html_decode_deep((array)$data);
  }

  return '';
}
