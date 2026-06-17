import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const base = path.join(__dirname, '..');
const sportsCss = fs.readFileSync(path.join(base, '04-sports/css/sports-ar.css'), 'utf8');

const demos = [
  { dir: '05-automotive', prefix: 'auto', file: 'auto-ar.css', primary: '#ef4444', primaryDk: '#dc2626', rgb: '239,68,68', tint: '#fef2f2' },
  { dir: '06-real-estate', prefix: 're', file: 're-ar.css', primary: '#8b5cf6', primaryDk: '#7c3aed', rgb: '139,92,246', tint: '#f5f3ff' },
  { dir: '07-health', prefix: 'health', file: 'health-ar.css', primary: '#14b8a6', primaryDk: '#0f766e', rgb: '20,184,166', tint: '#f0fdfa' },
  { dir: '08-education', prefix: 'edu', file: 'edu-ar.css', primary: '#f59e0b', primaryDk: '#d97706', rgb: '245,158,11', tint: '#fffbeb' },
  { dir: '09-crypto', prefix: 'crypto', file: 'crypto-ar.css', primary: '#f7931a', primaryDk: '#ea580c', rgb: '247,147,26', tint: '#fff7ed' },
  { dir: '10-gaming', prefix: 'game', file: 'gaming-ar.css', primary: '#a855f7', primaryDk: '#9333ea', rgb: '168,85,247', tint: '#faf5ff' },
];

for (const d of demos) {
  let css = sportsCss
    .replace(/--sport-/g, `--${d.prefix}-`)
    .replace(/\.sport-/g, `.${d.prefix}-`)
    .replace(/sport-/g, `${d.prefix}-`)
    .replace(/#e63329/g, d.primary)
    .replace(/#c02820/g, d.primaryDk)
    .replace(/230,51,41/g, d.rgb)
    .replace(/#fff5f5/g, d.tint)
    .replace(/--c-primary: #ef4444/g, `--c-primary: ${d.primary}`)
    .replace(/--c-primary-dk: #dc2626/g, `--c-primary-dk: ${d.primaryDk}`);

  css += `\n.showcase-card,.highlight-card{background:var(--${d.prefix}-surface);border:1px solid var(--${d.prefix}-border);border-radius:14px;overflow:hidden;box-shadow:var(--${d.prefix}-shadow);}\n`;
  css += `.showcase-card__body,.highlight-card__body{padding:14px 16px;}\n`;
  css += `.showcase-card__title,.highlight-card__title{font-size:.9rem;font-weight:700;line-height:1.45;margin:8px 0;}\n`;
  css += `.showcase-card__excerpt{font-size:.8rem;color:var(--text-muted);margin-bottom:8px;}\n`;
  css += `.showcase-card__meta,.highlight-card__meta{font-size:.72rem;color:var(--text-muted);display:flex;gap:12px;}\n`;
  css += `.showcase-card__cat{display:inline-block;font-size:.65rem;font-weight:800;color:#fff;padding:3px 8px;border-radius:6px;margin-bottom:6px;}\n`;
  css += `.${d.prefix}-hero__live-alert,.${d.prefix}-hero__live-title{font-size:.85rem;font-weight:700;line-height:1.5;}\n`;
  css += `.${d.prefix}-hero__live-level{font-size:.72rem;color:rgba(255,255,255,.65);margin-top:6px;}\n`;
  css += `.${d.prefix}-stat-item,.${d.prefix}-news-item{display:flex;align-items:center;gap:10px;padding:0 22px;font-size:.75rem;border-left:1px solid var(--${d.prefix}-border);color:var(--text-body);white-space:nowrap;}\n`;
  css += `.archive-hd h1{color:var(--text-head);}\n`;
  css += `.${d.prefix}-section__name,.${d.prefix}-matches__title,.latest-${d.prefix}__title{color:var(--text-head);}\n`;

  const cssDir = path.join(base, d.dir, 'css');
  fs.mkdirSync(cssDir, { recursive: true });
  fs.writeFileSync(path.join(cssDir, d.file), css);
  console.log('Wrote', d.dir, d.file);
}
