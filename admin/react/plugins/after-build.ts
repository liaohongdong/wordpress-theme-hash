import type { RsbuildPlugin } from '@rsbuild/core'
const fs = require('fs').promises; // 使用 promise 版 fs，支持 async/await

export type PluginFooOptions = {
  message?: string
}

export const pluginAfterBuild = (options: PluginFooOptions = {}): RsbuildPlugin => ({
  name: 'plugin-foo',
  setup(api) {
    api.onAfterBuild(({ isFirstCompile, stats }) => {
      if (isFirstCompile) {
        // 读取dist目录 并把后缀html修改为php
        fs.readdir('dist').then(files => {
          files.forEach(file => {
            if (file.endsWith('.html')) {
              fs.rename(`dist/${file}`, `dist/${file.slice(0, -5)}.php`);
            }
          });
        });
      }
    })
  }
})
