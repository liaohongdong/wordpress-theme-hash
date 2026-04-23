// @ts-check
import { defineConfig, defaultAllowedOrigins } from '@rsbuild/core';
import { pluginBabel } from '@rsbuild/plugin-babel';
import { pluginReact } from '@rsbuild/plugin-react';
import { pluginSass } from '@rsbuild/plugin-sass';
import AutoImport from 'unplugin-auto-import/rspack';

import { pluginAfterBuild } from './plugins/after-build';

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
    pluginSass(),
    pluginAfterBuild(),
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
    rspack: {
      plugins: [
        // 自动导入 React Hooks
        AutoImport({
          imports: ['react'],
          resolvers: [
            (name) => {
              // if (name.startsWith('Ant')) {
              //   // 组件名格式：AntButton → Button
              //   const componentName = name.slice(3);
              //   return {
              //     name: componentName,
              //     from: 'antd',
              //   };
              // }
              // 首字母大写的组件名，直接从 antd 导入
              const antdComponents = new Set([
                'Button', 'Input', 'Form', 'Table', 'Modal', 'Card',
                'Space', 'Select', 'DatePicker', 'Drawer', 'Message',
                'Typography', 'Upload', 'Radio', 'List', 'Checkbox',
                'Tabs', 'Collapse', 'Tooltip', 'Popconfirm', 'Dropdown',
                'Menu', 'Breadcrumb', 'Pagination', 'Tag', 'Badge',
                'Avatar', 'Divider', 'Empty', 'Spin', 'Alert', 'Result'
              ]);
              if (antdComponents.has(name)) {
                return { name, from: 'antd' };
              }
            },
          ],
          // 生成类型声明文件（解决 TS 报错）
          dts: './auto-imports.d.ts',
        }),
      ],
    },
  },
  output: {
    // 与构建产物有关的选项
    assetPrefix: `<?php echo get_stylesheet_directory_uri() . '/admin/react/dist' ?>`,
    sourceMap: {
      js: 'source-map',
      css: true,
    },
  },
  resolve: {
    // 与模块解析相关的选项
    alias: {
      '@': './src',
      '@1': './src',
      'root': './',
    },
  },
  source: {
    // 与输入的源代码相关的选项
    entry: {
      admin: './src/pages/admin/index.jsx',
      options: './src/pages/options/index.jsx',
    },
    transformImport: [
      {
        libraryName: 'antd',
        libraryDirectory: 'es', // 使用 ES module
        // style: 'css', // 自动导入对应 CSS（v4/v5 通用）
        // style: true, // 若需导入 less 源码（需配置 less 编译）
      },
      {
        libraryName: '@ant-design/icons',
        libraryDirectory: 'es/icons',
        camelToDashComponentName: false,
      },
    ],
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
