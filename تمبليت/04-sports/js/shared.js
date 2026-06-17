/* سبورت+ — Shared utilities */
window.SportShared = (function () {
  'use strict';

  function esc(s) {
    if (s == null) return '';
    const d = document.createElement('div');
    d.textContent = String(s);
    return d.innerHTML;
  }

  function getArticle(id) {
    return SPORT_ARTICLES.find(a => a.id === Number(id)) || SPORT_ARTICLES[0];
  }

  function getByCat(cat, limit, excludeFeatured) {
    let list = SPORT_ARTICLES.filter(a => a.cat === cat);
    if (excludeFeatured) list = list.filter(a => !a.featured);
    return limit ? list.slice(0, limit) : list;
  }

  function getFeatured() { return SPORT_ARTICLES.filter(a => a.featured).slice(0, 4); }
  function getBreaking() { return SPORT_ARTICLES.filter(a => a.breaking); }

  function getTrending(count) {
    return [...SPORT_ARTICLES]
      .sort((a, b) => parseFloat(String(b.views).replace(/[^\d.]/g, '')) - parseFloat(String(a.views).replace(/[^\d.]/g, '')))
      .slice(0, count);
  }

  function getLatest(count) {
    return [...SPORT_ARTICLES].sort((a, b) => b.id - a.id).slice(0, count);
  }

  function sportCard(a) {
    const cat = SPORT_CATEGORIES[a.cat];
    return `<article class="sport-card">
      <a href="single.html?id=${a.id}" class="sport-card__img">
        <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
        <span class="sport-card__cat" style="background:${cat.color}">${esc(cat.name)}</span>
      </a>
      <div class="sport-card__body">
        <h3 class="sport-card__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
        <p class="sport-card__excerpt">${esc(a.excerpt)}</p>
        <div class="sport-card__foot">
          <span><i class="far fa-clock"></i> ${esc(a.time)}</span>
          <span><i class="far fa-eye"></i> ${esc(a.views)}</span>
        </div>
      </div>
    </article>`;
  }

  function heroImg(url, w, h) {
    return url.replace('/300/170', `/${w}/${h}`).replace('/600/375', `/${w}/${h}`);
  }

  function renderHero() {
    const el = document.getElementById('headerHero');
    if (!el) return;
    const pool = getFeatured().length >= 4
      ? getFeatured()
      : [...getFeatured(), ...getLatest(6).filter(a => !getFeatured().some(f => f.id === a.id))].slice(0, 4);
    if (!pool.length) return;
    const [main, ...cells] = pool;
    const mainCat = SPORT_CATEGORIES[main.cat];

    function gridCell(a) {
      if (!a) return '';
      const c = SPORT_CATEGORIES[a.cat];
      return `<a href="single.html?id=${a.id}" class="sport-hero__cell">
        <img src="${heroImg(a.image, 420, 260)}" alt="${esc(a.title)}" loading="lazy">
        <div class="sport-hero__cell-body">
          <span class="sport-hero__cell-cat" style="color:${c.color}">${esc(c.name)}</span>
          <h3>${esc(a.title)}</h3>
          <span class="sport-hero__cell-meta">${esc(a.time)}</span>
        </div>
      </a>`;
    }

    el.innerHTML = `
      <a href="single.html?id=${main.id}" class="sport-hero__featured">
        <img src="${heroImg(main.image, 900, 560)}" alt="${esc(main.title)}" loading="eager">
        <div class="sport-hero__overlay">
          <span class="sport-hero__badge"><i class="fas fa-fire"></i> خبر اليوم</span>
          <span class="sport-hero__sport" style="background:${mainCat.color}"><i class="fas ${mainCat.icon}"></i> ${esc(mainCat.name)}</span>
          <h2>${esc(main.title)}</h2>
          <p class="sport-hero__excerpt">${esc(main.excerpt)}</p>
          <div class="sport-hero__meta">
            <span><i class="fas fa-user"></i> ${esc(main.author)}</span>
            <span><i class="far fa-clock"></i> ${esc(main.time)}</span>
            <span><i class="far fa-eye"></i> ${esc(main.views)}</span>
          </div>
        </div>
      </a>
      ${gridCell(cells[0])}
      ${gridCell(cells[1])}
      ${gridCell(cells[2])}`;
  }

  function renderTicker() {
    const el = document.getElementById('tickerInner');
    if (!el) return;
    const html = getBreaking().map(a => `<span class="sport-ticker__item"><a href="single.html?id=${a.id}">${esc(a.title)}</a></span>`).join('');
    el.innerHTML = html + html;
  }

  function renderSiteFooter() {
    const el = document.getElementById('siteFooter');
    if (!el) return;
    el.innerHTML = `
      <footer class="footer-main" style="background:#0f172a"><div class="wrap"><div class="footer-grid">
        <div class="footer-brand"><a href="index.html" class="logo"><i class="fas fa-futbol" style="color:#e63329"></i> سبورت<span style="color:#fff">+</span></a><p style="color:rgba(255,255,255,.65)">مصدرك الأول للأخبار الرياضية والتحليلات في العالم العربي.</p></div>
        <div class="footer-col"><h4>الرياضات</h4><ul><li><a href="archive.html?cat=football">كرة قدم</a></li><li><a href="archive.html?cat=basketball">كرة سلة</a></li><li><a href="archive.html?cat=tennis">تنس</a></li><li><a href="archive.html?cat=f1">فورمولا 1</a></li></ul></div>
        <div class="footer-col"><h4>الموقع</h4><ul><li><a href="#">من نحن</a></li><li><a href="#">تواصل</a></li></ul></div>
      </div></div></footer>
      <div class="footer-bottom" style="background:#020617"><div class="wrap"><span style="color:rgba(255,255,255,.5)">© 2026 سبورت+. جميع الحقوق محفوظة.</span></div></div>`;
  }

  function initCommon(options) {
    options = options || {};
    if (options.fullHeader !== false) renderHero();
    renderTicker();
    renderSiteFooter();
  }

  return { esc, getArticle, getByCat, getLatest, getTrending, sportCard, initCommon };
})();
