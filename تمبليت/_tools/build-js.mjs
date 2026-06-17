import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const base = path.join(__dirname, '..');

const transforms = [
  { from: '07-health', to: '08-education', rules: [
    ['HealthShared', 'EduShared'], ['HEALTH_', 'EDU_'], ['healthCard', 'eduCard'],
    ['health-', 'edu-'], ['HEALTH_LIVE_ALERTS', 'EDU_LIVE_EVENTS'],
    ['صحة+', 'تعليم+'], ['صحية', 'تعليمية'], ['fa-heartbeat', 'fa-graduation-cap'],
    ['#14b8a6', '#f59e0b'], ['تنبيه صحي', 'موعد تعليمي'], ['المستوى', 'الموعد'],
    ['alert.level', 'alert.deadline'], ['alert.status', 'alert.status'],
    ['fa-user-md', 'fa-user-graduate'], ['nutrition', 'scholarships'],
    ['catKeys = [\'nutrition\'', 'catKeys = [\'schools\''],
    ["'nutrition', 'fitness', 'mental', 'medicine', 'wellness', 'research'", "'schools', 'university', 'scholarships', 'edtech', 'exams', 'careers'"],
    ['getParam(\'cat\')) ? getParam(\'cat\') : \'nutrition\'', "getParam('cat')) ? getParam('cat') : 'scholarships'"],
    ['healthCard', 'eduCard'], ['HealthShared', 'EduShared'],
  ]},
  { from: '09-crypto', to: '09-crypto', rules: [] }, // only fill missing
  { from: '05-automotive', to: '09-crypto', files: ['archive.js', 'single.js'], rules: [
    ['AutoShared', 'CryptoShared'], ['AUTO_', 'CRYPTO_'], ['autoCard', 'cryptoCard'],
    ['auto-', 'crypto-'], ['autoCard', 'cryptoCard'], ["'reviews'", "'bitcoin'"],
    ["'reviews', 'electric', 'suv', 'sports', 'guides', 'industry'", "'bitcoin', 'altcoins', 'defi', 'nft', 'regulation', 'analysis'"],
    ['أوتو+', 'كريبتو+'], ['السيارات', 'الكريبتو'], ['fa-car', 'fa-bitcoin-sign'],
  ]},
  { from: '04-sports', to: '10-gaming', files: ['archive.js', 'single.js'], rules: [
    ['SportShared', 'GameShared'], ['SPORT_', 'GAME_'], ['sportCard', 'gameCard'],
    ['sport-', 'game-'], ['SPORT_LIVE_MATCHES', 'GAME_LIVE_MATCHES'],
    ["'football', 'basketball', 'tennis', 'f1', 'boxing', 'cricket'", "'pc', 'console', 'mobile', 'esports', 'reviews', 'releases'"],
    ['سبورت+', 'جيمر+'], ['رياضي', 'gaming'], ['fa-futbol', 'fa-gamepad'],
    ['getParam(\'cat\')) ? getParam(\'cat\') : \'football\'', "getParam('cat')) ? getParam('cat') : 'pc'"],
    ['.sport-cat', '.game-cat'], ['league-table', 'league-table'],
  ]},
];

function applyRules(content, rules) {
  let out = content;
  for (const [a, b] of rules) out = out.split(a).join(b);
  return out;
}

// 08-education: copy all js from 07-health
const eduRules = transforms[0].rules;
for (const file of ['shared.js', 'app.js', 'archive.js', 'single.js']) {
  const src = fs.readFileSync(path.join(base, '07-health/js', file), 'utf8');
  let out = applyRules(src, eduRules);
  if (file === 'shared.js') {
    out = out.replace(/m\.status === 'نشط'/g, "m.status === 'عاجل' || m.status === 'جاري'");
    out = out.replace(/health-live-item__region/g, 'edu-live-item__type');
    out = out.replace(/esc\(m\.region\)/g, 'esc(m.type)');
    out = out.replace(/esc\(alert\.region\)/g, 'esc(alert.type)');
    out = out.replace(/esc\(alert\.level\)/g, 'esc(alert.deadline)');
  }
  const jsDir = path.join(base, '08-education/js');
  fs.mkdirSync(jsDir, { recursive: true });
  fs.writeFileSync(path.join(jsDir, file), out);
  console.log('Wrote 08-education/js/' + file);
}

// 09-crypto archive + single from 05
for (const file of ['archive.js', 'single.js']) {
  if (fs.existsSync(path.join(base, '09-crypto/js', file))) continue;
  const src = fs.readFileSync(path.join(base, '05-automotive/js', file), 'utf8');
  fs.mkdirSync(path.join(base, '09-crypto/js'), { recursive: true });
  fs.writeFileSync(path.join(base, '09-crypto/js', file), applyRules(src, transforms[2].rules));
  console.log('Wrote 09-crypto/js/' + file);
}

// 10-gaming archive + single from 04-sports
for (const file of ['archive.js', 'single.js']) {
  if (fs.existsSync(path.join(base, '10-gaming/js', file))) continue;
  const src = fs.readFileSync(path.join(base, '04-sports/js', file), 'utf8');
  fs.mkdirSync(path.join(base, '10-gaming/js'), { recursive: true });
  fs.writeFileSync(path.join(base, '10-gaming/js', file), applyRules(src, transforms[3].rules));
  console.log('Wrote 10-gaming/js/' + file);
}

// Ensure 09 app.js exists - copy from 05
if (!fs.existsSync(path.join(base, '09-crypto/js/app.js'))) {
  const src = fs.readFileSync(path.join(base, '05-automotive/js/app.js'), 'utf8');
  fs.writeFileSync(path.join(base, '09-crypto/js/app.js'), applyRules(src, transforms[2].rules));
  console.log('Wrote 09-crypto/js/app.js');
}

if (!fs.existsSync(path.join(base, '10-gaming/js/app.js'))) {
  const src = fs.readFileSync(path.join(base, '04-sports/js/app.js'), 'utf8');
  fs.writeFileSync(path.join(base, '10-gaming/js/app.js'), applyRules(src, transforms[3].rules));
  console.log('Wrote 10-gaming/js/app.js');
}
