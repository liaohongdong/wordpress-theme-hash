import md5 from './md5';

export const genSuffPathByUploadFile = (file) => {
  // 1. 年月
  const now = new Date();
  const year = now.getUTCFullYear();
  const month = String(now.getUTCMonth() + 1).padStart(2, '0');
  // 2. 计算 MD5
  const md5Str = md5(file.name);
  // 3. 扩展名
  const ext = file.name.split('.').pop();
  // 4. 最终路径（严格格式）
  return `wordpress/${year}/${month}/${md5Str}.${ext}`;
}