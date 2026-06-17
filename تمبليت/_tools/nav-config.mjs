/** Nav config — standard HTML structure, unique variant per demo */
export const NAV_DEMOS = [
  {
    dir: '01-tech-ai', prefix: 'tech', variant: 'pills', aria: 'أقسام التقنية',
    catKeys: ['ai', 'hw', 'sw', 'sec', 'st', 'rev'],
    cats: {
      ai: { icon: 'fa-brain', name: 'ذكاء اصطناعي' },
      hw: { icon: 'fa-microchip', name: 'أجهزة' },
      sw: { icon: 'fa-code', name: 'برمجيات' },
      sec: { icon: 'fa-shield-alt', name: 'أمن' },
      st: { icon: 'fa-rocket', name: 'شركات ناشئة' },
      rev: { icon: 'fa-star', name: 'مراجعات' },
    },
  },
  {
    dir: '02-cooking', prefix: 'cook', variant: 'pills-solid', aria: 'أقسام الطبخ', noIcons: true,
    catKeys: ['main', 'dessert', 'soup', 'salad', 'fast', 'tips'],
    cats: {
      main: { icon: 'fa-drumstick-bite', name: 'أطباق رئيسية' },
      dessert: { icon: 'fa-cookie-bite', name: 'حلويات' },
      soup: { icon: 'fa-bowl-food', name: 'شوربات' },
      salad: { icon: 'fa-leaf', name: 'سلطات' },
      fast: { icon: 'fa-bolt', name: 'وجبات سريعة' },
      tips: { icon: 'fa-lightbulb', name: 'أخبار المطبخ' },
    },
  },
  {
    dir: '03-finance', prefix: 'fin', variant: 'pills-solid', aria: 'أقسام مالية',
    catKeys: ['mk', 'biz', 'eco', 'bank', 'energy', 'analysis'],
    cats: {
      mk: { icon: 'fa-chart-line', name: 'أسواق' },
      biz: { icon: 'fa-building', name: 'أعمال' },
      eco: { icon: 'fa-globe', name: 'اقتصاد' },
      bank: { icon: 'fa-university', name: 'بنوك' },
      energy: { icon: 'fa-gas-pump', name: 'طاقة' },
      analysis: { icon: 'fa-chart-pie', name: 'تحليلات' },
    },
  },
  {
    dir: '04-sports', prefix: 'sport', variant: 'underline', aria: 'الرياضات', noIcons: true,
    catKeys: ['football', 'basketball', 'tennis', 'f1', 'boxing', 'cricket'],
    cats: {
      football: { icon: 'fa-futbol', name: 'كرة قدم', color: '#e63329' },
      basketball: { icon: 'fa-basketball-ball', name: 'كرة سلة', color: '#f97316' },
      tennis: { icon: 'fa-table-tennis', name: 'تنس', color: '#22c55e' },
      f1: { icon: 'fa-flag-checkered', name: 'فورمولا 1', color: '#ef4444' },
      boxing: { icon: 'fa-fist-raised', name: 'ملاكمة', color: '#6366f1' },
      cricket: { icon: 'fa-baseball-ball', name: 'كريكيت', color: '#0ea5e9' },
    },
  },
  {
    dir: '05-automotive', prefix: 'auto', variant: 'underline', aria: 'أقسام السيارات',
    catKeys: ['reviews', 'electric', 'suv', 'sports', 'guides', 'industry'],
    cats: {
      reviews: { icon: 'fa-star', name: 'مراجعات' },
      electric: { icon: 'fa-bolt', name: 'كهربائية' },
      suv: { icon: 'fa-truck-pickup', name: 'SUV' },
      sports: { icon: 'fa-gauge-high', name: 'رياضية' },
      guides: { icon: 'fa-book', name: 'دليل الشراء' },
      industry: { icon: 'fa-industry', name: 'صناعة' },
    },
  },
  {
    dir: '06-real-estate', prefix: 're', variant: 'bar', aria: 'أقسام العقار',
    catKeys: ['sale', 'rent', 'investment', 'luxury', 'commercial', 'tips'],
    cats: {
      sale: { icon: 'fa-tag', name: 'بيع' },
      rent: { icon: 'fa-key', name: 'إيجار' },
      investment: { icon: 'fa-chart-line', name: 'استثمار' },
      luxury: { icon: 'fa-gem', name: 'فاخر' },
      commercial: { icon: 'fa-store', name: 'تجاري' },
      tips: { icon: 'fa-lightbulb', name: 'نصائح' },
    },
  },
  {
    dir: '07-health', prefix: 'health', variant: 'chips', aria: 'الأقسام الصحية',
    catKeys: ['nutrition', 'fitness', 'mental', 'medicine', 'wellness', 'research'],
    cats: {
      nutrition: { icon: 'fa-apple-alt', name: 'تغذية', color: '#22c55e' },
      fitness: { icon: 'fa-dumbbell', name: 'لياقة', color: '#f97316' },
      mental: { icon: 'fa-brain', name: 'نفسية', color: '#6366f1' },
      medicine: { icon: 'fa-stethoscope', name: 'طب', color: '#ef4444' },
      wellness: { icon: 'fa-spa', name: 'عافية', color: '#14b8a6' },
      research: { icon: 'fa-flask', name: 'أبحاث', color: '#0ea5e9' },
    },
  },
  {
    dir: '08-education', prefix: 'edu', variant: 'segments', aria: 'أقسام التعليم',
    catKeys: ['schools', 'university', 'scholarships', 'edtech', 'exams', 'careers'],
    cats: {
      schools: { icon: 'fa-school', name: 'مدارس' },
      university: { icon: 'fa-university', name: 'جامعات' },
      scholarships: { icon: 'fa-award', name: 'منح' },
      edtech: { icon: 'fa-laptop-code', name: 'EdTech' },
      exams: { icon: 'fa-file-alt', name: 'امتحانات' },
      careers: { icon: 'fa-briefcase', name: 'مسارات' },
    },
  },
  {
    dir: '09-crypto', prefix: 'crypto', variant: 'dark', aria: 'أقسام الكريبتو',
    catKeys: ['bitcoin', 'altcoins', 'defi', 'nft', 'regulation', 'analysis'],
    cats: {
      bitcoin: { icon: 'fab fa-bitcoin', name: 'بيتكوين' },
      altcoins: { icon: 'fa-coins', name: 'عملات بديلة' },
      defi: { icon: 'fa-layer-group', name: 'DeFi' },
      nft: { icon: 'fa-image', name: 'NFT' },
      regulation: { icon: 'fa-gavel', name: 'تنظيم' },
      analysis: { icon: 'fa-chart-line', name: 'تحليل' },
    },
  },
  {
    dir: '10-gaming', prefix: 'game', variant: 'skew', aria: 'أقسام الألعاب',
    catKeys: ['pc', 'console', 'mobile', 'esports', 'reviews', 'releases'],
    cats: {
      pc: { icon: 'fa-desktop', name: 'PC' },
      console: { icon: 'fa-gamepad', name: 'كونsole' },
      mobile: { icon: 'fa-mobile-screen', name: 'موبايل' },
      esports: { icon: 'fa-trophy', name: 'eSports' },
      reviews: { icon: 'fa-star', name: 'مراجعات' },
      releases: { icon: 'fa-rocket', name: 'إصدارات' },
    },
  },
];

export function buildNavHtml(demo) {
  const { prefix, variant, aria, catKeys, cats, noIcons } = demo;
  const home = noIcons
    ? `<li class="${prefix}-nav__item site-nav__item active"><a href="index.html">الرئيسية</a></li>`
    : `<li class="${prefix}-nav__item site-nav__item active"><a href="index.html"><i class="fas fa-home" aria-hidden="true"></i><span>الرئيسية</span></a></li>`;
  const items = catKeys.map(key => {
    const c = cats[key];
    const colorAttr = (!noIcons && c.color) ? ` style="--nav-accent:${c.color}"` : '';
    const link = noIcons
      ? `<a href="archive.html?cat=${key}">${c.name}</a>`
      : `<a href="archive.html?cat=${key}"><i class="${c.icon.startsWith('fab') ? c.icon : 'fas ' + c.icon}" aria-hidden="true"></i><span>${c.name}</span></a>`;
    return `<li class="${prefix}-nav__item site-nav__item" data-cat="${key}"${colorAttr}>${link}</li>`;
  }).join('\n      ');
  return `<nav class="${prefix}-nav site-nav site-nav--${variant}" aria-label="${aria}">
      <ul class="${prefix}-nav__list site-nav__list">
      ${home}
      ${items}
      </ul>
    </nav>`;
}
