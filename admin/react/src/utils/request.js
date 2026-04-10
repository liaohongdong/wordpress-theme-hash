import axios from 'axios';

// 1. 创建 axios 实例
const service = axios.create({
  baseURL: '/api', // 你的统一接口前缀，可改成 http://xxx.com
  timeout: 30000, // 超时时间
});

// 2. 请求拦截器（统一加 token、请求头）
service.interceptors.request.use(
  (config) => {
    // 比如统一加 token
    // const token = localStorage.getItem('token');
    // if (token) config.headers.Authorization = 'Bearer ' + token;
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// 3. 响应拦截器（统一剥壳、统一报错）
service.interceptors.response.use(
  (response) => {
    // 统一返回 data，页面直接拿结果
    return response.data;
  },
  (error) => {
    console.error('请求异常：', error);
    // 可在这里统一提示：消息弹窗、登录过期等
    return Promise.reject(error);
  }
);

export default service;