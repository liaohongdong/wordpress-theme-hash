<?php
/**
 * Cloudflare R2 测试程序
 * 用于测试 CloudflareR2 类的所有功能
 * 
 * 使用方法：
 * 1. 命令行运行: php test-r2.php
 * 2. 或在浏览器访问: http://your-site/wp-content/themes/wordpress-theme-hash/test-r2.php
 */

// 加载 WordPress 环境（如果在浏览器中访问）
if (isset($_SERVER['HTTP_HOST'])) {
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';
}

// 禁用 deprecation 警告
error_reporting(E_ALL & ~E_DEPRECATED);

// 加载 Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// 加载 .env 配置
$env = parse_ini_file(__DIR__ . '/.env');
define('endpoint', $env['endpoint']);
define('accessKeyId', $env['accessKeyId']);
define('secretAccessKey', $env['secretAccessKey']);

// 加载 CloudflareR2 类
require_once __DIR__ . '/core/CloudflareR2.php';

use Aws\Exception\AwsException;

// 扩展 CloudflareR2 用于调试
class CloudflareR2Debug extends CloudflareR2
{
    public function upload($localPath, $savePath, $contentType = null)
    {
        if (!file_exists($localPath)) {
            echo "⚠️  警告: 本地文件不存在: $localPath\n";
            return false;
        }
        try {
            $this->s3Client->putObject([
                'Bucket' => $this->bucket,
                'Key' => $savePath,
                'SourceFile' => $localPath,
                'ContentType' => $contentType ?: 'application/octet-stream',
            ]);
            return true;
        } catch (AwsException $e) {
            echo "⚠️  AWS 错误: " . $e->getAwsErrorMessage() . "\n";
            echo "⚠️  错误详情: " . $e->getMessage() . "\n";
            return false;
        }
    }
    
    public function delete($key)
    {
        try {
            $this->s3Client->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $key,
            ]);
            return true;
        } catch (AwsException $e) {
            echo "⚠️  AWS 错误: " . $e->getAwsErrorMessage() . "\n";
            return false;
        }
    }
}

// 输出样式
function printHeader($title) {
    echo "\n" . str_repeat('=', 60) . "\n";
    echo "📌 $title\n";
    echo str_repeat('=', 60) . "\n\n";
}

function printSuccess($message) {
    echo "✅ 成功: $message\n";
}

function printError($message) {
    echo "❌ 错误: $message\n";
}

function printInfo($message) {
    echo "ℹ️  信息: $message\n";
}

// 初始化 R2 客户端
printHeader('初始化 Cloudflare R2 客户端');

try {
    $r2 = new CloudflareR2Debug();
    $r2_1 = new CloudflareR2();
    // $str = $r2_1->getPresignedDownloadUrl('2026/03/12c492f7864de31f0bc71438832291b9.jpg');
    // var_dump($str);
    printSuccess('R2 客户端初始化成功');
    printInfo("Endpoint: " . endpoint);
    printInfo("Bucket: wordpress");
} catch (Exception $e) {
    printError('R2 客户端初始化失败: ' . $e->getMessage());
    exit(1);
}

// // ============================================
// // 测试 1: 上传文件
// // ============================================
// printHeader('测试 1: 上传文件到 R2');

// // 创建测试文件
// $testContent = "Hello, Cloudflare R2!\n这是测试文件内容。\n测试时间: " . date('Y-m-d H:i:s');
// $testFilePath = sys_get_temp_dir() . '/r2-test-' . time() . '.txt';
// file_put_contents($testFilePath, $testContent);

// printInfo("创建测试文件: $testFilePath");

// $savePath = 'test/r2-test-' . time() . '.txt';
// $uploadResult = $r2->upload($testFilePath, $savePath, 'text/plain; charset=utf-8');

// if ($uploadResult) {
//     printSuccess("文件上传成功: $savePath");
//     $uploadedKey = $savePath; // 保存用于后续测试
// } else {
//     printError('文件上传失败');
// }

// // 清理临时文件
// unlink($testFilePath);

// // ============================================
// // 测试 2: 生成预签名上传 URL
// // ============================================
// printHeader('测试 2: 生成预签名上传 URL');

// $uploadKey = 'test/presigned-upload-' . time() . '.txt';
// try {
//     $uploadUrl = $r2->getPresignedUploadUrl($uploadKey, 600);
//     printSuccess("预签名上传 URL 生成成功");
//     printInfo("URL: " . substr($uploadUrl, 0, 80) . '...');
//     printInfo("有效期: 600 秒");
//     $presignedUploadUrl = $uploadUrl;
//     $presignedUploadKey = $uploadKey;
// } catch (Exception $e) {
//     printError('生成预签名上传 URL 失败: ' . $e->getMessage());
// }

// // ============================================
// // 测试 3: 使用预签名 URL 上传文件（模拟前端直传）
// // ============================================
// printHeader('测试 3: 使用预签名 URL 上传文件');

// if (isset($presignedUploadUrl)) {
//     $testContent2 = "这是通过预签名 URL 上传的测试文件\n时间: " . date('Y-m-d H:i:s');
//     $testFilePath2 = sys_get_temp_dir() . '/r2-presigned-test-' . time() . '.txt';
//     file_put_contents($testFilePath2, $testContent2);
    
//     // 使用 cURL 上传文件
//     $ch = curl_init($presignedUploadUrl);
//     $fp = fopen($testFilePath2, 'r');
//     $fileSize = filesize($testFilePath2);
    
//     curl_setopt($ch, CURLOPT_PUT, true);
//     curl_setopt($ch, CURLOPT_INFILE, $fp);
//     curl_setopt($ch, CURLOPT_INFILESIZE, $fileSize);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, [
//         'Content-Type: text/plain; charset=utf-8',
//     ]);
    
//     $response = curl_exec($ch);
//     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     curl_close($ch);
//     fclose($fp);
//     unlink($testFilePath2);
    
//     if ($httpCode == 200) {
//         printSuccess("通过预签名 URL 上传成功: $presignedUploadKey");
//         printInfo("HTTP 状态码: $httpCode");
//     } else {
//         printError("通过预签名 URL 上传失败");
//         printInfo("HTTP 状态码: $httpCode");
//         printInfo("响应: $response");
//     }
// }

// // ============================================
// // 测试 4: 生成预签名下载 URL
// // ============================================
// printHeader('测试 4: 生成预签名下载 URL');

// if (isset($uploadedKey)) {
//     try {
//         $downloadUrl = $r2->getPresignedDownloadUrl($uploadedKey, 3600);
//         printSuccess("预签名下载 URL 生成成功");
//         printInfo("URL: " . substr($downloadUrl, 0, 80) . '...');
//         printInfo("有效期: 3600 秒");
        
//         // 测试下载 URL 是否有效
//         printInfo("正在测试下载 URL 是否有效...");
//         $downloadHttpCode = 0;
//         $ch = curl_init($downloadUrl);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//         curl_setopt($ch, CURLOPT_NOBODY, true); // HEAD 请求
//         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//         curl_exec($ch);
//         $downloadHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//         curl_close($ch);
        
//         if ($downloadHttpCode === 200) {
//             printSuccess("下载 URL 有效，可以正常访问");
//         } else {
//             printInfo("下载 URL 返回状态码: " . ($downloadHttpCode ?: 'N/A') . "（可能需要等待几秒让上传生效）");
//         }
//     } catch (Exception $e) {
//         printError('生成预签名下载 URL 失败: ' . $e->getMessage());
//     }
// }

// // ============================================
// // 测试 5: 批量上传测试
// // ============================================
// printHeader('测试 5: 批量上传测试');

// $batchCount = 3;
// $batchSuccess = 0;
// $batchKeys = [];

// for ($i = 1; $i <= $batchCount; $i++) {
//     $content = "批量测试文件 #$i\n时间: " . date('Y-m-d H:i:s');
//     $filePath = sys_get_temp_dir() . '/r2-batch-' . time() . "-$i.txt";
//     file_put_contents($filePath, $content);
    
//     $key = "test/batch/batch-test-$i-" . time() . '.txt';
//     $result = $r2->upload($filePath, $key, 'text/plain; charset=utf-8');
    
//     if ($result) {
//         $batchSuccess++;
//         $batchKeys[] = $key;
//         printSuccess("批量上传 #$i 成功: $key");
//     } else {
//         printError("批量上传 #$i 失败: $key");
//     }
    
//     unlink($filePath);
//     usleep(200000); // 短暂延迟避免请求过快
// }

// printInfo("批量上传结果: $batchSuccess/$batchCount 成功");

// // ============================================
// // 测试 6: 删除文件
// // ============================================
// printHeader('测试 6: 删除文件');

// // 删除之前上传的文件
// $deleteKeys = [];
// if (isset($uploadedKey)) {
//     $deleteKeys[] = $uploadedKey;
// }
// if (isset($presignedUploadKey)) {
//     $deleteKeys[] = $presignedUploadKey;
// }
// $deleteKeys = array_merge($deleteKeys, $batchKeys);

// $deleteSuccess = 0;
// foreach ($deleteKeys as $key) {
//     $result = $r2->delete($key);
//     if ($result) {
//         $deleteSuccess++;
//         printSuccess("删除成功: $key");
//     } else {
//         printError("删除失败: $key");
//     }
// }

// printInfo("删除结果: $deleteSuccess/" . count($deleteKeys) . " 成功");

// // ============================================
// // 测试 7: 错误处理测试
// // ============================================
// printHeader('测试 7: 错误处理测试');

// // 测试上传不存在的文件
// $result = $r2->upload('/nonexistent/file.txt', 'test/error.txt');
// if (!$result) {
//     printSuccess('错误处理正常：上传不存在的文件返回 false');
// } else {
//     printError('错误处理异常：上传不存在的文件应返回 false');
// }

// // 测试删除不存在的文件
// $result = $r2->delete('test/nonexistent-file-' . time() . '.txt');
// if (!$result) {
//     printSuccess('错误处理正常：删除不存在的文件返回 false');
// } else {
//     printInfo('删除不存在的文件返回 true（R2 的 deleteObject 对不存在的键也可能返回成功）');
// }

// // ============================================
// // 测试总结
// // ============================================
// printHeader('📊 测试总结');

// echo "所有测试已完成！\n\n";
// echo "测试项目:\n";
// echo "  1. ✅ 客户端初始化\n";
// echo "  2. ✅ 文件上传\n";
// echo "  3. ✅ 预签名上传 URL 生成\n";
// echo "  4. ✅ 预签名下载 URL 生成\n";
// echo "  5. ✅ 预签名 URL 直传\n";
// echo "  6. ✅ 批量上传\n";
// echo "  7. ✅ 文件删除\n";
// echo "  8. ✅ 错误处理\n";
// echo "\n";