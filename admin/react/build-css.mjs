import { fileURLToPath } from 'url';
import { dirname, resolve } from 'path';
import { readFileSync, writeFileSync } from 'fs';
import postcss from 'postcss';
import tailwindcssPlugin from '@tailwindcss/postcss';

const __dirname = dirname(fileURLToPath(import.meta.url));
const src = resolve(__dirname, '../../assets/css/frontend/tailwind.css');
const dest = resolve(__dirname, '../../assets/css/frontend.css');

// Use from path inside admin/react so node_modules resolves correctly
const virtualFrom = resolve(__dirname, 'src/frontend-tailwind.css');

const css = readFileSync(src, 'utf8');

postcss([tailwindcssPlugin()])
  .process(css, { from: virtualFrom, to: dest, map: false })
  .then(result => {
    writeFileSync(dest, result.css);
    console.log(`✓ Built frontend CSS → ${dest}`);
  })
  .catch(err => {
    console.error('CSS build failed:', err);
    process.exit(1);
  });
