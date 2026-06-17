import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { NAV_DEMOS } from './nav-config.mjs';

const root = path.join(path.dirname(fileURLToPath(import.meta.url)), '..');

const VARIANT_CSS = {
  pills: (p) => `
/* Site Nav — pills (${p}) */
.${p}-nav.site-nav--pills .site-nav__item a { padding: 9px 16px; border-radius: 999px; border: 1px solid transparent; }
.${p}-nav.site-nav--pills .site-nav__item a:hover { background: rgba(99,102,241,.08); border-color: rgba(99,102,241,.15); }
.${p}-nav.site-nav--pills .site-nav__item.active a { background: #eef2ff; border-color: rgba(99,102,241,.25); color: var(--c-primary); box-shadow: 0 2px 8px rgba(99,102,241,.12); }
`,

  'pills-solid': (p) => `
/* Site Nav — pills solid (${p}) */
.${p}-nav.site-nav--pills-solid .site-nav__list { gap: 4px; padding-bottom: 16px; }
.${p}-nav.site-nav--pills-solid .site-nav__item a { padding: 10px 18px; border-radius: 10px; background: var(--fin-bg, #f0fdf4); border: 1px solid var(--fin-border, rgba(15,23,42,.08)); }
.${p}-nav.site-nav--pills-solid .site-nav__item a:hover { border-color: rgba(22,163,74,.25); color: var(--c-primary); }
.${p}-nav.site-nav--pills-solid .site-nav__item.active a { background: var(--c-primary); border-color: var(--c-primary); color: #fff; box-shadow: 0 4px 14px rgba(22,163,74,.25); }
.${p}-nav.site-nav--pills-solid .site-nav__item.active a i { opacity: 1; }
`,

  tiles: (p) => `
/* Site Nav — tiles (${p}) */
.${p}-nav.site-nav--tiles .site-nav__list { gap: 8px; }
.${p}-nav.site-nav--tiles .site-nav__item a { flex-direction: column; gap: 6px; min-width: 88px; padding: 12px 14px; border-radius: 14px; background: var(--cook-bg, #fff7ed); border: 1px solid var(--cook-border, rgba(15,23,42,.08)); text-align: center; font-size: .72rem; }
.${p}-nav.site-nav--tiles .site-nav__item a i { font-size: 1.1rem; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: var(--c-primary); color: #fff; opacity: 1; }
.${p}-nav.site-nav--tiles .site-nav__item[data-cat="main"] a i { background: #ea580c; }
.${p}-nav.site-nav--tiles .site-nav__item[data-cat="dessert"] a i { background: #db2777; }
.${p}-nav.site-nav--tiles .site-nav__item[data-cat="soup"] a i { background: #ca8a04; }
.${p}-nav.site-nav--tiles .site-nav__item[data-cat="salad"] a i { background: #16a34a; }
.${p}-nav.site-nav--tiles .site-nav__item[data-cat="fast"] a i { background: #2563eb; }
.${p}-nav.site-nav--tiles .site-nav__item[data-cat="tips"] a i { background: #9333ea; }
.${p}-nav.site-nav--tiles .site-nav__item.active a { background: #fff; border-color: rgba(232,93,4,.35); box-shadow: var(--cook-shadow, 0 4px 16px rgba(232,93,4,.12)); color: var(--c-primary); }
.${p}-nav.site-nav--tiles .site-nav__item.active a i { background: #0f172a; }
`,

  circles: (p) => `
/* Site Nav — circles (${p}) */
.${p}-nav.site-nav--circles .site-nav__list { gap: 8px; }
.${p}-nav.site-nav--circles .site-nav__item a { flex-direction: column; gap: 6px; min-width: 88px; padding: 12px 16px; border-radius: 14px; background: var(--sport-bg, #f4f5f7); border: 1px solid var(--sport-border, rgba(15,23,42,.08)); text-align: center; font-size: .72rem; color: var(--text-head); }
.${p}-nav.site-nav--circles .site-nav__item a i { font-size: 1rem; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: var(--nav-accent, var(--c-primary)); color: #fff; opacity: 1; }
.${p}-nav.site-nav--circles .site-nav__item.active a { background: #fff5f5; border-color: rgba(230,51,41,.35); box-shadow: 0 4px 16px rgba(230,51,41,.1); }
.${p}-nav.site-nav--circles .site-nav__item.active a i { background: var(--c-primary); }
`,

  underline: (p) => `
/* Site Nav — underline tabs (${p}) */
.${p}-nav.site-nav--underline .site-nav__list { gap: 0; border-bottom: 2px solid var(--auto-border, rgba(15,23,42,.08)); padding-bottom: 0; }
.${p}-nav.site-nav--underline .site-nav__item a { padding: 12px 18px; border-radius: 0; border-bottom: 2px solid transparent; margin-bottom: -2px; font-size: .84rem; }
.${p}-nav.site-nav--underline .site-nav__item a:hover { color: var(--c-primary); background: rgba(239,68,68,.04); }
.${p}-nav.site-nav--underline .site-nav__item.active a { color: var(--c-primary); border-bottom-color: var(--c-primary); background: transparent; font-weight: 800; }
`,

  bar: (p) => `
/* Site Nav — bar links (${p}) */
.${p}-nav.site-nav--bar { background: var(--re-bg, #faf5ff); border: 1px solid var(--re-border, rgba(15,23,42,.08)); border-radius: 12px; padding: 4px 8px; margin-bottom: 4px; }
.${p}-nav.site-nav--bar .site-nav__list { gap: 0; padding-bottom: 4px; flex-wrap: wrap; justify-content: center; }
.${p}-nav.site-nav--bar .site-nav__item a { padding: 10px 16px; font-size: .84rem; border-radius: 8px; }
.${p}-nav.site-nav--bar .site-nav__item:not(:last-child) a { border-left: 1px solid var(--re-border, rgba(15,23,42,.1)); }
.${p}-nav.site-nav--bar .site-nav__item a:hover { color: var(--c-primary); background: rgba(139,92,246,.06); }
.${p}-nav.site-nav--bar .site-nav__item.active a { color: var(--c-primary); background: #fff; box-shadow: 0 2px 8px rgba(139,92,246,.15); font-weight: 800; }
`,

  chips: (p) => `
/* Site Nav — chips (${p}) */
.${p}-nav.site-nav--chips .site-nav__list { gap: 8px; }
.${p}-nav.site-nav--chips .site-nav__item a { padding: 8px 16px; border-radius: 999px; border: 1px solid var(--health-border, rgba(15,23,42,.08)); background: var(--health-surface, #fff); font-size: .8rem; }
.${p}-nav.site-nav--chips .site-nav__item a:hover { border-color: var(--nav-accent, var(--c-primary)); color: var(--nav-accent, var(--c-primary)); }
.${p}-nav.site-nav--chips .site-nav__item.active a { background: var(--nav-accent, var(--c-primary)); border-color: var(--nav-accent, var(--c-primary)); color: #fff; box-shadow: 0 4px 12px color-mix(in srgb, var(--nav-accent, var(--c-primary)) 35%, transparent); }
.${p}-nav.site-nav--chips .site-nav__item.active a i { opacity: 1; }
`,

  segments: (p) => `
/* Site Nav — segments (${p}) */
.${p}-nav.site-nav--segments { background: var(--edu-bg, #fffbeb); border: 1px solid var(--edu-border, rgba(15,23,42,.08)); border-radius: 12px; padding: 4px; margin-bottom: 4px; }
.${p}-nav.site-nav--segments .site-nav__list { gap: 2px; padding-bottom: 4px; }
.${p}-nav.site-nav--segments .site-nav__item a { padding: 10px 14px; border-radius: 8px; font-size: .78rem; }
.${p}-nav.site-nav--segments .site-nav__item a:hover { background: rgba(245,158,11,.08); color: var(--c-primary); }
.${p}-nav.site-nav--segments .site-nav__item.active a { background: #fff; color: var(--c-primary); box-shadow: 0 2px 8px rgba(245,158,11,.15); font-weight: 800; }
`,

  dark: (p) => `
/* Site Nav — dark band (${p}) */
.${p}-nav.site-nav--dark { background: transparent; margin: 0; padding: 0; border: none; }
.${p}-nav.site-nav--dark .site-nav__list { gap: 0; padding-bottom: 0; }
.${p}-nav.site-nav--dark .site-nav__item a { font-family: 'Courier New', Courier, monospace; font-size: .76rem; letter-spacing: .03em; text-transform: uppercase; color: rgba(255,255,255,.55); padding: 12px 16px; border-left: 1px solid rgba(255,255,255,.08); border-radius: 0; }
.${p}-nav.site-nav--dark .site-nav__item:first-child a { border-left: none; }
.${p}-nav.site-nav--dark .site-nav__item a:hover { color: #fdba74; background: rgba(247,147,26,.08); }
.${p}-nav.site-nav--dark .site-nav__item.active a { color: var(--c-primary); background: rgba(247,147,26,.12); box-shadow: inset 0 -2px 0 var(--c-primary); }
.${p}-header--compact .${p}-nav.site-nav--dark { margin-bottom: 0; }
`,

  skew: (p) => `
/* Site Nav — skew tabs (${p}) */
.${p}-nav.site-nav--skew .site-nav__list { gap: 6px; }
.${p}-nav.site-nav--skew .site-nav__item a { transform: skewX(-8deg); padding: 0; border-radius: 0; background: var(--game-bg, #faf5ff); border: 1px solid var(--game-border, rgba(15,23,42,.08)); overflow: hidden; }
.${p}-nav.site-nav--skew .site-nav__item a i,
.${p}-nav.site-nav--skew .site-nav__item a span { transform: skewX(8deg); display: inline-block; }
.${p}-nav.site-nav--skew .site-nav__item a { padding: 10px 18px; gap: 6px; }
.${p}-nav.site-nav--skew .site-nav__item a:hover { border-color: var(--c-primary); color: var(--c-primary); }
.${p}-nav.site-nav--skew .site-nav__item.active a { background: linear-gradient(135deg, #a855f7, #7c3aed); border-color: #7c3aed; color: #fff; box-shadow: 0 4px 16px rgba(168,85,247,.35); transform: skewX(-8deg); }
.${p}-nav.site-nav--skew .site-nav__item.active a i { opacity: 1; }
`,
};

const OLD_NAV_PATTERNS = [
  /\/\* ── Site Nav \(standard\) ── \*\/[\s\S]*?(?=\n\/\* ──|\n\.[a-z]+-header--compact|\n@media|$)/,
];

for (const demo of NAV_DEMOS) {
  const cssPath = path.join(root, demo.dir, 'css', demo.dir === '01-tech-ai' ? 'tech-ar.css'
    : demo.dir === '02-cooking' ? 'cook-ar.css'
    : demo.dir === '03-finance' ? 'finance-ar.css'
    : demo.dir === '04-sports' ? 'sports-ar.css'
    : demo.dir === '05-automotive' ? 'auto-ar.css'
    : demo.dir === '06-real-estate' ? 're-ar.css'
    : demo.dir === '07-health' ? 'health-ar.css'
    : demo.dir === '08-education' ? 'edu-ar.css'
    : demo.dir === '09-crypto' ? 'crypto-ar.css'
    : 'game-ar.css');

  let css = fs.readFileSync(cssPath, 'utf8');
  for (const re of OLD_NAV_PATTERNS) {
    css = css.replace(re, '');
  }

  const block = VARIANT_CSS[demo.variant](demo.prefix);
  const marker = '/* ── Site Nav (standard) ── */';
  if (css.includes(marker)) {
    css = css.replace(new RegExp(`${marker}[\\s\\S]*?(?=\\n/\\* ──|\\n@media|$)`), marker + block);
  } else {
    css = css.trimEnd() + `\n\n${marker}${block}\n`;
  }

  const compactRule = `
.${demo.prefix}-header--compact .${demo.prefix}-nav .site-nav__list { padding-bottom: 10px; }
`;
  if (!css.includes(`${demo.prefix}-header--compact .${demo.prefix}-nav`)) {
    css += compactRule;
  }

  fs.writeFileSync(cssPath, css);
  console.log('css updated', cssPath);
}

console.log('Done.');
