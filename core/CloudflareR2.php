<?php

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class CloudflareR2
{
  protected $s3Client;
  protected $bucket;
  protected $endpoint;
  public function __construct()
  {
    // 你的 R2 信息
    $this->endpoint = endpoint;
    $this->bucket = 'wordpress';

    $this->s3Client = new S3Client([
      'region' => 'auto',
      'version' => 'latest',
      'endpoint' => $this->endpoint,
      'credentials' => [
        'key' => accessKeyId,
        'secret' => secretAccessKey,
      ],
      'use_path_style_endpoint' => true,
      'disable_host_prefix' => true,
      // 本地开发环境可禁用SSL验证
      'http' => [
        'verify' => false,
      ],
    ]);
  }

  /**
   * 上传文件到 R2
   * @param string $localPath 本地文件路径
   * @param string $savePath 云存储路径
   * @param string $contentType
   * @return bool
   */
  public function upload($localPath, $savePath, $contentType = null)
  {
    try {
      $this->s3Client->putObject([
        'Bucket' => $this->bucket,
        'Key' => $savePath,
        'SourceFile' => $localPath,
        'ContentType' => $contentType ?: mime_content_type($localPath),
      ]);
      return true;
    } catch (AwsException $e) {
      return false;
    }
  }

  /**
   * 生成 PUT 预签名上传 URL（前端直传专用）
   * @param string $key 保存路径
   * @param int $expires 秒
   * @return string
   */
  public function getPresignedUploadUrl($key, $expires = 600)
  {
    $cmd = $this->s3Client->getCommand('PutObject', [
      'Bucket' => $this->bucket,
      'Key' => $key,
    ]);

    $presigned = $this->s3Client->createPresignedRequest($cmd, "+$expires seconds");
    return (string)$presigned->getUri();
  }

  /**
   * 生成 GET 预签名 URL
   */
  public function getPresignedDownloadUrl($key, $expires = 3600)
  {
    $cmd = $this->s3Client->getCommand('GetObject', [
      'Bucket' => $this->bucket,
      'Key' => $key,
    ]);

    $presigned = $this->s3Client->createPresignedRequest($cmd, "+$expires seconds");
    return (string)$presigned->getUri();
  }

  /**
   * 删除文件
   */
  public function delete($key)
  {
    try {
      $this->s3Client->deleteObject([
        'Bucket' => $this->bucket,
        'Key' => $key,
      ]);
      return true;
    } catch (AwsException $e) {
      return false;
    }
  }
}
