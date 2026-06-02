import { watch } from 'node:fs';
import { execSync } from 'node:child_process';
import { resolve } from 'node:path';

const src = resolve('./src');
let timer = null;
let building = false;
let pending = false;

console.log(`Watching ${src} for changes...`);

const rebuild = () => {
  if (building) {
    pending = true;
    return;
  }
  building = true;
  const start = Date.now();
  try {
    execSync('npx rsbuild build', { stdio: 'inherit', cwd: resolve('.') });
    console.log(`\n✓ Rebuilt in ${Date.now() - start}ms`);
  } catch {
    console.error('\n✗ Build failed');
  }
  building = false;
  if (pending) {
    pending = false;
    rebuild();
  }
};

watch(src, { recursive: true }, (eventType, filename) => {
  if (filename && !filename.startsWith('.') && filename.endsWith('.jsx')) {
    clearTimeout(timer);
    timer = setTimeout(rebuild, 3000);
  }
});
