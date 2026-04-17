<?php



// $env = parse_ini_file(get_theme_file_path('.env'));
// define('endpoint', $env['endpoint']);
// define('accessKeyId', $env['accessKeyId']);
// define('secretAccessKey', $env['secretAccessKey']);

# 打印上面三个变量

require_once get_theme_file_path('/core/CloudflareR2.php');

use Aws\Exception\AwsException;

if (!function_exists('r2_upload_callback')) {
  function r2_upload_callback()
  {
    if (!check_ajax_referer('ajax', 'nonce', false)) {
      wp_send_json(array(
        'success' => false,
        'data' => '',
        'message' => '安全验证失败，请刷新页面重试'
      ));
    }
    try {
      var_dump($_POST);
      var_dump($_FILES['file']);
      $r2 = new CloudflareR2();
      // $r2->getPresignedUploadUrl();
      // $this->s3Client->putObject([
      //   'Bucket' => $this->bucket,
      //   'Key' => $savePath,
      //   'SourceFile' => $localPath,
      //   'ContentType' => $contentType ?: 'application/octet-stream',
      // ]);
      // 初始化响应数据
      $response = array(
        'success' => false,
        'data' => '',
        'message' => ''
      );
      try {
        $response['success'] = true;
        $response['data'] = 'aaaaa1';
        $response['message'] = '上传成功';
      } catch (Exception $e) {
        $response['message'] = $e->getMessage();
      }
      wp_send_json($response);
    } catch (AwsException $e) {
      echo "AWS 错误: " . $e->getAwsErrorMessage() . "\n";
      echo "错误详情: " . $e->getMessage() . "\n";
      return false;
    }
  }
}
add_action('wp_ajax_r2_upload', 'r2_upload_callback');
add_action('wp_ajax_nopriv_r2_upload', 'r2_upload_callback');