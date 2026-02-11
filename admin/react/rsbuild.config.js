// @ts-check
import { defineConfig, defaultAllowedOrigins } from '@rsbuild/core';
import { pluginBabel } from '@rsbuild/plugin-babel';
import { pluginReact } from '@rsbuild/plugin-react';

// Docs: https://rsbuild.rs/config/
export default defineConfig({
  plugins: [
    // 配置 Rsbuild 插件
    pluginReact(),
    pluginBabel({
      include: /\.(?:jsx|tsx)$/,
      babelLoaderOptions(opts) {
        opts.plugins?.unshift('babel-plugin-react-compiler');
        // opts.plugins?.unshift(['babel-plugin-react-compiler', {
        // compilationMode: 'annotation',
        // }]);
      },
    }),
  ],
  dev: {
    // 与本地开发有关的选项
  },
  html: {
    // 与 HTML 生成有关的选项
    crossorigin: 'anonymous',
    // inject: 'body',
    template(e) {
      return `./public/${e.entryName}.html`;
    }
  },
  tools: {
    // 与底层工具有关的选项
  },
  output: {
    // 与构建产物有关的选项
    assetPrefix: '<?php echo get_stylesheet_directory_uri() . "/admin/react/dist" ?>',
  },
  resolve: {
    // 与模块解析相关的选项
  },
  source: {
    // 与输入的源代码相关的选项
    entry: {
      admin: './src/pages/admin/index.jsx',
      options: './src/pages/options/index.jsx',
    },
  },
  server: {
    // 与 Rsbuild 服务器有关的选项
    // 在本地开发和预览时都会生效
    // 等价于 `{ origin: '*' }`
    // cors: true,
    cors: {
      // 配置 `Access-Control-Allow-Origin` CORS 响应头
      // origin: 'https://example.com',
      origin: [defaultAllowedOrigins, 'https://example.com'],
    },
  },
  security: {
    // 与 Web 安全有关的选项
  },
  performance: {
    // 与构建性能、运行时性能有关的选项
  },
  // moduleFederation: {
  //   // 与模块联邦有关的选项
  //   options: {
  //     name: '',
  //   },
  // },
  environments: {
    // 为每个环境定义不同的 Rsbuild 配置
  },
});
