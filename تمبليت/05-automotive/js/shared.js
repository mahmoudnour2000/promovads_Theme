/* أوتو+ — Shared utilities */
window.AutoShared = (function () {
  'use strict';

  function esc(s) {
    if (s == null) return '';
    const d = document.createElement('div');
    d.textContent = String(s);
    return d.innerHTML;
  }

  function getArticle(id) {
    return AUTO_ARTICLES.find(a => a.id === Number(id)) || AUTO_ARTICLES[0];
  }

  function getByCat(cat, limit, excludeFeatured) {
    let list = AUTO_ARTICLES.filter(a => a.cat === cat);
    if (excludeFeatured) list = list.filter(a => !a.featured);
    return limit ? list.slice(0, limit) : list;
  }

  function getFeatured() { return AUTO_ARTICLES.filter(a => a.featured).slice(0, 4); }
  function getBreaking() { return AUTO_ARTICLES.filter(a => a.breaking); }

  function getTrending(count) {
    return [...AUTO_ARTICLES]
      .sort((a, b) => parseFloat(String(b.views).replace(/[^\d.]/g, '')) - parseFloat(String(a.views).replace(/[^\d.]/g, '')))
      .slice(0, count);
  }

  function getLatest(count) {
    return [...AUTO_ARTICLES].sort((a, b) => b.id - a.id).slice(0, count);
  }

  function autoCard(a) {
    const cat = AUTO_CATEGORIES[a.cat];
    return `<article class="auto-card">
      <a href="single.html?id=${a.id}" class="auto-card__img">
        <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
        <span class="auto-card__cat" style="background:${cat.color}">${esc(cat.name)}</span>
      </a>
      <div class="auto-card__body">
        <h3 class="auto-card__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
        <p class="auto-card__excerpt">${esc(a.excerpt)}</p>
        <div class="auto-card__foot">
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
    const main = pool[0];
    const mainCat = AUTO_CATEGORIES[main.cat];
    const row = pool.slice(1, 4);

    el.innerHTML = `
      <a href="single.html?id=${main.id}" class="auto-hero__cinema">
        <img src="${heroImg(main.image, 1200, 480)}" alt="${esc(main.title)}" loading="eager">
        <div class="auto-hero__overlay">
          <span class="auto-hero__badge"><i class="fas fa-fire"></i> خبر اليوم</span>
          <span class="auto-hero__cat" style="background:${mainCat.color}"><i class="fas ${mainCat.icon}"></i> ${esc(mainCat.name)}</span>
          <h2>${esc(main.title)}</h2>
          <p class="auto-hero__excerpt">${esc(main.excerpt)}</p>
          <div class="auto-hero__meta">
            <span><i class="fas fa-user"></i> ${esc(main.author)}</span>
            <span><i class="far fa-clock"></i> ${esc(main.time)}</span>
            <span><i class="far fa-eye"></i> ${esc(main.views)}</span>
          </div>
        </div>
      </a>
      <div class="auto-hero__filmstrip">
        ${row.map(a => {
          const c = AUTO_CATEGORIES[a.cat];
          return `<a href="single.html?id=${a.id}" class="auto-hero__film-card">
            <img src="${heroImg(a.image, 400, 240)}" alt="${esc(a.title)}" loading="lazy">
            <div class="auto-hero__film-body">
              <span class="auto-hero__film-cat" style="color:${c.color}">${esc(c.name)}</span>
              <h3>${esc(a.title)}</h3>
              <span class="auto-hero__film-meta">${esc(a.time)}</span>
            </div>
          </a>`;
        }).join('')}
      </div>`;
  }

  function renderShowcase() {
    const el = document.getElementById('showcaseGrid');
    if (!el) return;
    const items = getFeatured().slice(0, 3);
    el.innerHTML = items.map((a) => {
      const cat = AUTO_CATEGORIES[a.cat];
      return `<div class="showcase-card">
        <div class="showcase-card__img"><img src="${heroImg(a.image, 500, 280)}" alt="${esc(a.title)}"></div>
        <div class="showcase-card__body">
          <span class="showcase-card__cat" style="background:${cat.color}">${esc(cat.name)}</span>
          <h3 class="showcase-card__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
          <p class="showcase-card__excerpt">${esc(a.excerpt)}</p>
          <div class="showcase-card__meta"><span><i class="far fa-clock"></i> ${esc(a.time)}</span><span><i class="far fa-eye"></i> ${esc(a.views)}</span></div>
        </div>
      </div>`;
    }).join('');
  }

  function renderTicker() {
    const el = document.getElementById('tickerInner');
    if (!el) return;
    const html = getBreaking().map(a => `<span class="auto-ticker__item"><a href="single.html?id=${a.id}">${esc(a.title)}</a></span>`).join('');
    el.innerHTML = html + html;
  }

  function renderSiteFooter() {
    const el = document.getElementById('siteFooter');
    if (!el) return;
    el.innerHTML = `
      <footer class="footer-main" style="background:#0f172a"><div class="wrap"><div class="footer-grid">
        <div class="footer-brand"><a href="index.html" class="logo"><i class="fas fa-car" style="color:#ef4444"></i> أوتو<span style="color:#fff">+</span></a><p style="color:rgba(255,255,255,.65)">أخبار ومراجعات السيارات بالعربية — تقارير، دليل شراء وتحليلات.</p></div>
        <div class="footer-col"><h4>الأقسام</h4><ul><li><a href="archive.html?cat=reviews">مراجعات</a></li><li><a href="archive.html?cat=electric">كهربائية</a></li><li><a href="archive.html?cat=suv">SUV</a></li><li><a href="archive.html?cat=sports">رياضية</a></li></ul></div>
        <div class="footer-col"><h4>الموقع</h4><ul><li><a href="#">من نحن</a></li><li><a href="#">تواصل</a></li></ul></div>
      </div></div></footer>
      <div class="footer-bottom" style="background:#020617"><div class="wrap"><span style="color:rgba(255,255,255,.5)">© 2026 أوتو+ AutoDrive Arabic. جميع الحقوق محفوظة.</span></div></div>`;
  }

  function initCommon(options) {
    options = options || {};
    if (options.fullHeader !== false) {
      renderHero();
      renderShowcase();
    }
    renderTicker();
    renderSiteFooter();
  }

  return { esc, getArticle, getByCat, getLatest, getTrending, autoCard, initCommon };
})();
