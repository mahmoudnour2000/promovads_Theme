import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { NAV_DEMOS, buildNavHtml } from './nav-config.mjs';

const root = path.join(path.dirname(fileURLToPath(import.meta.url)), '..');

const NAV_RE = /<nav[^>]*class="[^"]*"[^>]*>[\s\S]*?<\/nav>/;
const CRYPTO_BAND_RE = /<div class="crypto-header-band">[\s\S]*?<\/div>\s*(?=<\/div>\s*<\/header>)/;

for (const demo of NAV_DEMOS) {
  const navHtml = buildNavHtml(demo);
  for (const file of ['index.html', 'archive.html', 'single.html']) {
    const fp = path.join(root, demo.dir, file);
    if (!fs.existsSync(fp)) continue;
    let html = fs.readFileSync(fp, 'utf8');

    if (demo.prefix === 'crypto' && html.includes('crypto-header-band')) {
      html = html.replace(CRYPTO_BAND_RE, navHtml + '\n    ');
    } else if (NAV_RE.test(html)) {
      html = html.replace(NAV_RE, navHtml);
    } else {
      console.warn('No nav found:', fp);
      continue;
    }
    fs.writeFileSync(fp, html);
    console.log('patched', fp);
  }

  const archiveJs = path.join(root, demo.dir, 'js', 'archive.js');
  if (fs.existsSync(archiveJs)) {
    let js = fs.readFileSync(archiveJs, 'utf8');
    const prefix = demo.prefix;
    js = js.replace(
      /function setActiveNav\(catKey\) \{[\s\S]*?\n  \}/,
      `function setActiveNav(catKey) {
    document.querySelectorAll('.${prefix}-nav__item').forEach(el => el.classList.remove('active'));
    const item = document.querySelector(\`.${prefix}-nav__item[data-cat="\${catKey}"]\`);
    if (item) item.classList.add('active');
  }`
    );
    fs.writeFileSync(archiveJs, js);
    console.log('patched', archiveJs);
  }
}

console.log('Done.');
