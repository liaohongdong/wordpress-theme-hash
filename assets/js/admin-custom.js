// 后台JS中直接访问wp_localize_script传递的数据
jQuery(document).ready(function ($) {
  // 1. 访问传递的PHP数据（全局对象AdminLocalData）
  console.log('网站名称：', AdminLocalData.site_name);
  console.log('当前后台页面ID：', AdminLocalData.admin_page);
  console.log('AJAX请求地址：', AdminLocalData.ajax_url);
  console.log('提示信息：', AdminLocalData.message);
});