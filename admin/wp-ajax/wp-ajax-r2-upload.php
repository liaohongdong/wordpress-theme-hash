<?php
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
      $file = $_FILES['file'];
      $localTempPath = $file['tmp_name']; // 临时文件路径（必须用这个）
      $savePath = $_POST['suffPath'];
      try {
        $r2 = new CloudflareR2();
        // 后台上传
        // $uploadResult = $r2->upload($localTempPath, $savePath);
        // // 初始化响应数据
        // $response = array(
        //   'success' => false,
        //   'data' => '',
        //   'message' => ''
        // );
        // if (!$_POST['suffPath']) {
        //   $response['success'] = false;
        //   $response['message'] = 'suffPath 不能为空';
        // }
        // if ($uploadResult) {
        //   $response['success'] = true;
        //   $response['data'] = $r2->getPresignedDownloadUrl($savePath);
        //   $response['message'] = '上传成功';
        // }
        // 前端上传
        $uploadUrl = $r2->getPresignedUploadUrl($savePath, 600);
        $response['success'] = true;
        $response['data']['upload_url'] = $uploadUrl; // 前端用这个URL上传
        $response['data']['save_path'] = $savePath; // 保存到数据库的文件路径
        $response['message'] = '获取上传地址成功';
      } catch (Exception $e) {
        $response['success'] = false;
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