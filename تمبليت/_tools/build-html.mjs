import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const base = path.join(__dirname, '..');

const demos = [
  {
    dir: '05-automotive', prefix: 'auto', css: 'auto-ar.css', demoClass: 'auto', shared: 'AutoShared',
    title: 'أوتو+ — مراجعات وأخبار السيارات', brand: 'أوتو', brandIcon: 'fa-car', brandColor: '#ef4444',
    sub: 'مراجعات ودليل شراء', search: 'ابحث عن سيارة، ماركة، مراجعة…', btn: 'مقارنة سيارات',
    topLive: 'معرض ديتroit 2026', barLabel: 'أخبار السوق', barId: 'newsBarInner',
    heroTitle: 'أبرز أخبار السيارات', sectionTitle: 'سيارات مميزة', sectionId: 'showcaseGrid',
    defaultCat: 'reviews',
    cats: [
      ['reviews', 'مراجعات', 'fa-star', '#ef4444'],
      ['electric', 'كهربائية', 'fa-bolt', '#22c55e'],
      ['suv', 'SUV', 'fa-truck-pickup', '#f97316'],
      ['sports', 'رياضية', 'fa-gauge-high', '#6366f1'],
      ['guides', 'دليل', 'fa-book', '#0ea5e9'],
      ['industry', 'صناعة', 'fa-industry', '#64748b'],
    ],
    footerLinks: [['reviews', 'مراجعات'], ['electric', 'كهربائية'], ['suv', 'SUV'], ['sports', 'رياضية']],
    sidebarWidget: '🔥 الأكثر قراءة', tagsLabel: 'وسوم سيارات',
  },
  {
    dir: '06-real-estate', prefix: 're', css: 're-ar.css', demoClass: 'realestate', shared: 'ReShared',
    title: 'عقار+ — أخبار وعروض العقارات', brand: 'عقار', brandIcon: 'fa-building', brandColor: '#8b5cf6',
    sub: 'بيع · إيجار · استثمار', search: 'ابحث عن حي، مشروع، عقار…', btn: 'عروض اليوم',
    topLive: 'سوق عقاري نشط', barLabel: 'مؤشرات السوق', barId: 'statsBarInner',
    heroTitle: 'أبرز أخبار العقار', sectionTitle: 'عروض مميزة', sectionId: 'listingsGrid',
    defaultCat: 'sale',
    cats: [
      ['sale', 'بيع', 'fa-tag', '#8b5cf6'],
      ['rent', 'إيجار', 'fa-key', '#22c55e'],
      ['investment', 'استثمار', 'fa-chart-line', '#f97316'],
      ['luxury', 'فاخر', 'fa-gem', '#eab308'],
      ['commercial', 'تجاري', 'fa-store', '#0ea5e9'],
      ['tips', 'نصائح', 'fa-lightbulb', '#64748b'],
    ],
    footerLinks: [['sale', 'بيع'], ['rent', 'إيجار'], ['investment', 'استثمار'], ['luxury', 'فاخر']],
    sidebarWidget: '🔥 الأكثر قراءة', tagsLabel: 'وسوم عقارية',
  },
  {
    dir: '07-health', prefix: 'health', css: 'health-ar.css', demoClass: 'health', shared: 'HealthShared',
    title: 'صحة+ — أخبار صحية وإرشادات', brand: 'صحة', brandIcon: 'fa-heartbeat', brandColor: '#14b8a6',
    sub: 'طب · تغذية · لياقة', search: 'ابحث عن صحة، تغذية، طب…', btn: 'نصائح صحية',
    topLive: 'تنبيهات صحية نشطة', barLabel: 'تنبيهات', barId: 'liveBarInner',
    heroTitle: 'أبرز الأخبار الصحية', sectionTitle: 'تنبيهات مهمة', sectionId: 'highlightsGrid',
    defaultCat: 'nutrition',
    cats: [
      ['nutrition', 'تغذية', 'fa-apple-alt', '#22c55e'],
      ['fitness', 'لياقة', 'fa-dumbbell', '#f97316'],
      ['mental', 'نفسية', 'fa-brain', '#6366f1'],
      ['medicine', 'طب', 'fa-stethoscope', '#ef4444'],
      ['wellness', 'عافية', 'fa-spa', '#14b8a6'],
      ['research', 'أبحاث', 'fa-flask', '#0ea5e9'],
    ],
    footerLinks: [['nutrition', 'تغذية'], ['fitness', 'لياقة'], ['mental', 'صحة نفسية'], ['medicine', 'طب']],
    sidebarWidget: '🔥 الأكثر قراءة', tagsLabel: 'وسوم صحية',
  },
  {
    dir: '08-education', prefix: 'edu', css: 'edu-ar.css', demoClass: 'education', shared: 'EduShared',
    title: 'تعليم+ — منح وجامعات وتقنية تعليم', brand: 'تعليم', brandIcon: 'fa-graduation-cap', brandColor: '#f59e0b',
    sub: 'منح · جامعات · EdTech', search: 'ابحث عن منحة، جامعة، امتحان…', btn: 'منح اليوم',
    topLive: 'مواعيد قبول ومنح', barLabel: 'مواعيد مهمة', barId: 'liveBarInner',
    heroTitle: 'أبرز أخبار التعليم', sectionTitle: 'فعاليات ومواعيد', sectionId: 'highlightsGrid',
    defaultCat: 'scholarships',
    cats: [
      ['schools', 'مدارس', 'fa-school', '#3b82f6'],
      ['university', 'جامعات', 'fa-university', '#8b5cf6'],
      ['scholarships', 'منح', 'fa-award', '#22c55e'],
      ['edtech', 'EdTech', 'fa-laptop-code', '#06b6d4'],
      ['exams', 'امتحانات', 'fa-file-alt', '#ef4444'],
      ['careers', 'مسارات', 'fa-briefcase', '#f59e0b'],
    ],
    footerLinks: [['scholarships', 'منح'], ['university', 'جامعات'], ['exams', 'امتحانات'], ['edtech', 'EdTech']],
    sidebarWidget: '🔥 الأكثر قراءة', tagsLabel: 'وسوم تعليمية',
  },
  {
    dir: '09-crypto', prefix: 'crypto', css: 'crypto-ar.css', demoClass: 'crypto', shared: 'CryptoShared',
    title: 'كريبتو+ — أخبار العملات الرقمية', brand: 'كريبتو', brandIcon: 'fa-bitcoin-sign', brandColor: '#f7931a',
    sub: 'BTC · ETH · DeFi', search: 'ابحث عن عملة، DeFi، NFT…', btn: 'أسعار مباشرة',
    topLive: 'سوق كريبتو 24/7', barLabel: 'أسعار مباشرة', barId: 'liveBarInner',
    heroTitle: 'أبرز أخبار الكريبتو', sectionTitle: 'حركة السوق', sectionId: 'marketGrid',
    defaultCat: 'bitcoin',
    cats: [
      ['bitcoin', 'بيتكوين', 'fa-bitcoin-sign', '#f7931a'],
      ['altcoins', 'Alt', 'fa-coins', '#6366f1'],
      ['defi', 'DeFi', 'fa-layer-group', '#22c55e'],
      ['nft', 'NFT', 'fa-image', '#ec4899'],
      ['regulation', 'تنظيم', 'fa-gavel', '#0ea5e9'],
      ['analysis', 'تحليل', 'fa-chart-line', '#f97316'],
    ],
    footerLinks: [['bitcoin', 'بيتكوين'], ['defi', 'DeFi'], ['altcoins', 'Alt'], ['regulation', 'تنظيم']],
    sidebarWidget: '🔥 الأكثر قراءة', tagsLabel: 'وسوم كريبتو',
  },
  {
    dir: '10-gaming', prefix: 'game', css: 'gaming-ar.css', demoClass: 'gaming', shared: 'GameShared',
    title: 'جيمر+ — أخبار ألعاب وeSports', brand: 'جيمر', brandIcon: 'fa-gamepad', brandColor: '#a855f7',
    sub: 'PC · Console · eSports', search: 'ابحث عن لعبة، بطولة، مراجعة…', btn: 'نتائج eSports',
    topLive: '8 بطولات مباشرة', barLabel: 'eSports مباشر', barId: 'liveBarInner',
    heroTitle: 'أبرز أخبار الألعاب', sectionTitle: 'مباريات eSports', sectionId: 'matchesGrid',
    defaultCat: 'pc',
    cats: [
      ['pc', 'PC', 'fa-desktop', '#a855f7'],
      ['console', 'Console', 'fa-gamepad', '#6366f1'],
      ['mobile', 'موبايل', 'fa-mobile-screen', '#22c55e'],
      ['esports', 'eSports', 'fa-trophy', '#f97316'],
      ['reviews', 'مراجعات', 'fa-star', '#ec4899'],
      ['releases', 'إصدارات', 'fa-rocket', '#0ea5e9'],
    ],
    footerLinks: [['pc', 'PC'], ['console', 'Console'], ['esports', 'eSports'], ['reviews', 'مراجعات']],
    sidebarWidget: '🔥 الأكثر قراءة', tagsLabel: 'وسوم gaming',
  },
];

function catNav(d, compact = false) {
  const home = compact
    ? `<a href="index.html" class="${d.prefix}-cat ${d.prefix}-cat--home"><span class="${d.prefix}-cat__icon" style="background:#0f172a"><i class="fas fa-home"></i></span><span class="${d.prefix}-cat__name">الرئيسية</span></a>`
    : `<a href="index.html" class="${d.prefix}-cat ${d.prefix}-cat--home active"><span class="${d.prefix}-cat__icon" style="background:#0f172a"><i class="fas fa-home"></i></span><span class="${d.prefix}-cat__name">الرئيسية</span></a>`;
  const items = d.cats.map(([slug, name, icon, color]) => {
    const active = compact ? '' : '';
    return `<a href="archive.html?cat=${slug}" class="${d.prefix}-cat ${d.prefix}-cat--${slug}" data-cat="${slug}"><span class="${d.prefix}-cat__icon" style="background:${color}"><i class="fas ${icon}"></i></span><span class="${d.prefix}-cat__name">${name}</span></a>`;
  }).join('\n      ');
  return `<nav class="${d.prefix}-cats" aria-label="الأقسام">\n      ${home}\n      ${items}\n    </nav>`;
}

function indexHtml(d) {
  return `<!DOCTYPE html>
<html lang="ar" dir="rtl" class="demo-${d.demoClass}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>${d.title}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../assets/css/pds-core.css">
<link rel="stylesheet" href="css/${d.css}">
</head>
<body>
<div class="progress-bar" id="progress"></div>
<div class="${d.prefix}-live-bar">
  <div class="${d.prefix}-live-bar__label"><i class="fas fa-circle" style="font-size:7px"></i> ${d.barLabel}</div>
  <div class="${d.prefix}-live-bar__track"><div class="${d.prefix}-live-bar__inner" id="${d.barId}"></div></div>
</div>
<div class="${d.prefix}-topbar">
  <div class="wrap">
    <div class="${d.prefix}-topbar__left">
      <span class="${d.prefix}-topbar__live"><i class="fas fa-broadcast-tower"></i> ${d.topLive}</span>
      <span><i class="fas fa-calendar-alt" style="color:var(--c-primary);margin-left:5px;opacity:.7"></i> الاثنين، 15 يونيو 2026</span>
    </div>
    <div class="${d.prefix}-topbar__social">
      <a href="#"><i class="fab fa-x-twitter"></i></a>
      <a href="#"><i class="fab fa-youtube"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
    </div>
  </div>
</div>
<header class="${d.prefix}-header">
  <div class="wrap">
    <div class="${d.prefix}-header__bar">
      <a href="index.html" class="${d.prefix}-logo">
        <div class="${d.prefix}-logo__icon"><i class="fas ${d.brandIcon}"></i></div>
        <div>${d.brand}<span>+</span><span class="${d.prefix}-logo__sub">${d.sub}</span></div>
      </a>
      <div class="${d.prefix}-search search-trigger" role="button" tabindex="0">
        <i class="fas fa-search"></i>
        <input type="search" placeholder="${d.search}" readonly>
      </div>
      <div class="${d.prefix}-header__actions">
        <button class="${d.prefix}-btn-icon search-trigger" title="بحث"><i class="fas fa-search"></i></button>
        <a href="archive.html" class="${d.prefix}-btn-live"><i class="fas fa-bolt"></i> ${d.btn}</a>
      </div>
    </div>
    ${catNav(d)}
  </div>
</header>
<section class="${d.prefix}-hero-zone">
  <div class="wrap">
    <div class="${d.prefix}-hero-zone__head">
      <div class="${d.prefix}-hero-zone__title"><i class="fas fa-star"></i> ${d.heroTitle}</div>
      <a href="archive.html" style="font-size:.82rem;font-weight:700;color:var(--c-primary)">عرض الكل <i class="fas fa-arrow-left"></i></a>
    </div>
    <div class="${d.prefix}-hero" id="headerHero"></div>
  </div>
</section>
<div class="${d.prefix}-ticker">
  <div class="${d.prefix}-ticker__label"><span class="${d.prefix}-ticker__dot"></span>عاجل</div>
  <div class="${d.prefix}-ticker__track"><div class="${d.prefix}-ticker__inner ticker__inner" id="tickerInner"></div></div>
</div>
<main style="padding:36px 0 60px"><div class="wrap">
  <section class="${d.prefix}-matches">
    <div class="${d.prefix}-matches__head">
      <h2 class="${d.prefix}-matches__title">${d.sectionTitle.split(' ')[0]} <span>${d.sectionTitle.split(' ').slice(1).join(' ') || 'اليوم'}</span></h2>
      <a href="archive.html" class="${d.prefix}-section__btn"><i class="fas fa-newspaper"></i> عرض الكل</a>
    </div>
    <div class="grid g3" id="${d.sectionId}"></div>
  </section>
  <div class="grid g-main" style="gap:32px">
    <div>
      <div id="categorySections"></div>
      <section class="latest-${d.prefix}" id="latestSection">
        <div class="latest-${d.prefix}__head">
          <h2 class="latest-${d.prefix}__title">آخر <span style="color:var(--c-primary)">الأخبار</span></h2>
          <a href="archive.html" class="${d.prefix}-section__btn"><i class="fas fa-newspaper"></i> عرض الكل</a>
        </div>
        <div id="latestList"></div>
      </section>
    </div>
    <aside class="sidebar">
      <div class="widget"><div class="widget__title">${d.sidebarWidget}</div><div class="widget__body" style="padding:8px 16px"><div id="trendingList"></div></div></div>
      <div class="widget"><div class="widget__title">${d.tagsLabel}</div><div class="widget__body" style="padding:12px 16px"><div class="tags" id="sidebarTags"></div></div></div>
    </aside>
  </div>
</div></main>
<div id="siteFooter"></div>
<button class="back-top" id="backTop"><i class="fas fa-chevron-up"></i></button>
<div class="search-overlay" id="searchOverlay">
  <button class="search-close" style="position:absolute;top:20px;left:20px;color:#fff;font-size:1.5rem;background:none;border:none;cursor:pointer"><i class="fas fa-times"></i></button>
  <div class="search-box">
    <div class="search-input-wrap" style="background:#fff;border:1px solid var(--${d.prefix}-border);border-radius:12px;padding:4px 12px">
      <i class="fas fa-search" style="color:var(--c-primary)"></i>
      <input type="search" placeholder="${d.search}" style="font-size:1.05rem;background:transparent;color:#0f172a">
    </div>
    <div class="search-results" id="searchPreview" style="background:#fff;border:1px solid var(--${d.prefix}-border);border-radius:12px;margin-top:12px"></div>
  </div>
</div>
<script src="data/articles.js"></script>
<script src="js/shared.js"></script>
<script src="js/app.js"></script>
<script src="../assets/js/pds-main.js"></script>
</body></html>`;
}

function archiveHtml(d) {
  const cats = d.cats.map(([slug, name, icon, color]) =>
    `<a href="archive.html?cat=${slug}" class="${d.prefix}-cat ${d.prefix}-cat--${slug}" data-cat="${slug}"><span class="${d.prefix}-cat__icon" style="background:${color}"><i class="fas ${icon}"></i></span><span class="${d.prefix}-cat__name">${name}</span></a>`
  ).join('\n      ');
  return `<!DOCTYPE html>
<html lang="ar" dir="rtl" class="demo-${d.demoClass}">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>أرشيف — ${d.brand}+</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../assets/css/pds-core.css">
<link rel="stylesheet" href="css/${d.css}">
</head>
<body class="page-inner">
<div class="${d.prefix}-topbar"><div class="wrap"><div class="${d.prefix}-topbar__left"><span class="${d.prefix}-topbar__live"><i class="fas fa-broadcast-tower"></i> ${d.topLive}</span></div><div class="${d.prefix}-topbar__social"><a href="#"><i class="fab fa-x-twitter"></i></a></div></div></div>
<header class="${d.prefix}-header ${d.prefix}-header--compact">
  <div class="wrap">
    <div class="${d.prefix}-header__bar">
      <a href="index.html" class="${d.prefix}-logo"><div class="${d.prefix}-logo__icon"><i class="fas ${d.brandIcon}"></i></div><div>${d.brand}<span>+</span></div></a>
      <div class="${d.prefix}-header__actions">
        <button class="${d.prefix}-btn-icon search-trigger"><i class="fas fa-search"></i></button>
        <a href="archive.html" class="${d.prefix}-btn-live"><i class="fas fa-bolt"></i> ${d.btn}</a>
      </div>
    </div>
    <nav class="${d.prefix}-cats" aria-label="الأقسام">
      <a href="index.html" class="${d.prefix}-cat ${d.prefix}-cat--home"><span class="${d.prefix}-cat__icon" style="background:#0f172a"><i class="fas fa-home"></i></span><span class="${d.prefix}-cat__name">الرئيسية</span></a>
      ${cats}
    </nav>
  </div>
</header>
<div class="archive-hd" id="archiveHeader"></div>
<div class="${d.prefix}-ticker"><div class="${d.prefix}-ticker__label"><span class="${d.prefix}-ticker__dot"></span>عاجل</div><div class="${d.prefix}-ticker__track"><div class="${d.prefix}-ticker__inner ticker__inner" id="tickerInner"></div></div></div>
<main style="padding:0 0 60px"><div class="wrap"><div class="grid g-main" style="gap:32px;margin-top:8px">
  <div><div id="archiveGrid"></div><nav class="pagination" style="margin-top:32px"><a href="#" style="width:auto;padding:0 14px;color:var(--text-muted)"><i class="fas fa-arrow-right"></i> السابق</a><span class="current">1</span><a href="#" style="color:var(--text-muted)">2</a><a href="#" style="width:auto;padding:0 14px;color:var(--text-muted)">التالي <i class="fas fa-arrow-left"></i></a></nav></div>
  <aside class="sidebar" id="archiveSidebar"></aside>
</div></div></main>
<div id="siteFooter"></div><button class="back-top" id="backTop"><i class="fas fa-chevron-up"></i></button>
<script src="data/articles.js"></script><script src="js/shared.js"></script><script src="js/archive.js"></script><script src="../assets/js/pds-main.js"></script>
</body></html>`;
}

function singleHtml(d) {
  const cats = d.cats.map(([slug, name, icon, color]) =>
    `<a href="archive.html?cat=${slug}" class="${d.prefix}-cat ${d.prefix}-cat--${slug}" data-cat="${slug}"><span class="${d.prefix}-cat__icon" style="background:${color}"><i class="fas ${icon}"></i></span><span class="${d.prefix}-cat__name">${name}</span></a>`
  ).join('\n      ');
  return `<!DOCTYPE html>
<html lang="ar" dir="rtl" class="demo-${d.demoClass}">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>مقال — ${d.brand}+</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../assets/css/pds-core.css">
<link rel="stylesheet" href="css/${d.css}">
</head>
<body class="page-inner">
<div class="progress-bar" id="progress"></div>
<div class="${d.prefix}-topbar"><div class="wrap"><div class="${d.prefix}-topbar__left"><span class="${d.prefix}-topbar__live">${d.topLive}</span></div></div></div>
<header class="${d.prefix}-header ${d.prefix}-header--compact">
  <div class="wrap">
    <div class="${d.prefix}-header__bar">
      <a href="index.html" class="${d.prefix}-logo"><div class="${d.prefix}-logo__icon"><i class="fas ${d.brandIcon}"></i></div><div>${d.brand}<span>+</span></div></a>
      <div class="${d.prefix}-header__actions"><button class="${d.prefix}-btn-icon search-trigger"><i class="fas fa-search"></i></button><a href="archive.html" class="${d.prefix}-btn-live">${d.btn}</a></div>
    </div>
    <nav class="${d.prefix}-cats">${cats}</nav>
  </div>
</header>
<div class="${d.prefix}-ticker"><div class="${d.prefix}-ticker__label"><span class="${d.prefix}-ticker__dot"></span>عاجل</div><div class="${d.prefix}-ticker__track"><div class="${d.prefix}-ticker__inner ticker__inner" id="tickerInner"></div></div></div>
<main style="padding:36px 0 60px"><div class="wrap"><div class="grid g-main" style="gap:36px"><article id="articleContent"></article><aside class="sidebar" id="singleSidebar"></aside></div></div></main>
<div id="siteFooter"></div><button class="back-top" id="backTop"><i class="fas fa-chevron-up"></i></button>
<script src="data/articles.js"></script><script src="js/shared.js"></script><script src="js/single.js"></script><script src="../assets/js/pds-main.js"></script>
</body></html>`;
}

for (const d of demos) {
  const dir = path.join(base, d.dir);
  fs.writeFileSync(path.join(dir, 'index.html'), indexHtml(d));
  fs.writeFileSync(path.join(dir, 'archive.html'), archiveHtml(d));
  fs.writeFileSync(path.join(dir, 'single.html'), singleHtml(d));
  console.log('HTML', d.dir);
}
