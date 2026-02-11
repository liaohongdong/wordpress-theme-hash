<?php

/**
 * PHP 统一读取 JSON/INI/YAML 配置文件的工具类
 * 支持自动识别文件格式、完整异常处理、统一返回关联数组
 * 无任何第三方依赖，PHP5.6+ 兼容
 */

class ConfigReader
{
  /**
   * 统一读取配置文件入口方法
   * @param string $filePath 配置文件路径（相对/绝对）
   * @return array 解析后的关联数组
   * @throws Exception
   */
  public static function read(string $filePath): array
  {
    // 校验文件基础信息
    self::checkFile($filePath);
    // 获取文件后缀，自动识别格式
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    // 根据后缀选择解析方法
    switch ($ext) {
      case 'json':
        return self::parseJson($filePath);
      case 'ini':
        return self::parseIni($filePath);
      case 'yaml':
      case 'yml':
        return self::parseYaml($filePath);
      default:
        throw new Exception("不支持的配置文件格式：{$ext}，仅支持 json/ini/yaml/yml");
    }
  }

  /**
   * 校验文件是否存在、是否可读
   */
  private static function checkFile(string $filePath): void
  {
    if (!file_exists($filePath)) {
      throw new Exception("配置文件不存在：{$filePath}");
    }
    if (!is_readable($filePath)) {
      throw new Exception("配置文件无读取权限：{$filePath}");
    }
  }

  /**
   * 解析JSON文件
   */
  private static function parseJson(string $filePath): array
  {
    $content = file_get_contents($filePath);
    $data = json_decode($content, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new Exception("JSON解析失败：" . json_last_error_msg());
    }
    return $data ?: [];
  }

  /**
   * 解析INI文件
   */
  private static function parseIni(string $filePath): array
  {
    $data = parse_ini_file($filePath, true);
    if ($data === false) {
      throw new Exception("INI文件解析失败，语法格式错误");
    }
    return $data ?: [];
  }

  /**
   * 解析YAML/YML文件
   */
  private static function parseYaml(string $filePath): array
  {
    if (!function_exists('yaml_parse_file')) {
      throw new Exception("解析YAML失败：未开启PHP yaml扩展，请先安装");
    }
    $data = yaml_parse_file($filePath);
    if ($data === false) {
      throw new Exception("YAML文件解析失败，语法格式错误（冒号后必须加空格）");
    }
    return $data ?: [];
  }
}
