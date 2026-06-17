/* عقار+ — Shared utilities */
window.ReShared = (function () {
  'use strict';

  function esc(s) {
    if (s == null) return '';
    const d = document.createElement('div');
    d.textContent = String(s);
    return d.innerHTML;
  }

  function heroImg(url) {
    return url.replace('/300/170', '/900/520').replace('/600/375', '/900/520');
  }

  function getArticle(id) {
    return RE_ARTICLES.find(a => a.id === Number(id)) || RE_ARTICLES[0];
  }

  function getByCat(cat, limit, excludeFeatured) {
    let list = RE_ARTICLES.filter(a => a.cat === cat);
    if (excludeFeatured) list = list.filter(a => !a.featured);
    return limit ? list.slice(0, limit) : list;
  }

  function getFeatured() { return RE_ARTICLES.filter(a => a.featured).slice(0, 4); }
  function getBreaking() { return RE_ARTICLES.filter(a => a.breaking); }

  function getTrending(count) {
    return [...RE_ARTICLES]
      .sort((a, b) => parseFloat(String(b.views).replace(/[^\d.]/g, '')) - parseFloat(String(a.views).replace(/[^\d.]/g, '')))
      .slice(0, count);
  }

  function getLatest(count) {
    return [...RE_ARTICLES].sort((a, b) => b.id - a.id).slice(0, count);
  }

  function reCard(a) {
    const cat = RE_CATEGORIES[a.cat];
    return `<article class="re-card">
      <a href="single.html?id=${a.id}" class="re-card__img">
        <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
        <span class="re-card__cat" style="background:${cat.color}">${esc(cat.name)}</span>
      </a>
      <div class="re-card__body">
        <h3 class="re-card__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
        <p class="re-card__excerpt">${esc(a.excerpt)}</p>
        <div class="re-card__foot">
          <span><i class="far fa-clock"></i> ${esc(a.time)}</span>
          <span><i class="far fa-eye"></i> ${esc(a.views)}</span>
        </div>
      </div>
    </article>`;
  }

  function renderHero() {
    const el = document.getElementById('headerHero');
    if (!el) return;
    const featured = getFeatured();
    if (!featured.length) return;
    const main = featured[0];
    const mainCat = RE_CATEGORIES[main.cat];
    const row = featured.slice(1, 4);

    el.innerHTML = `
      <a href="single.html?id=${main.id}" class="re-hero__mosaic-main">
        <img src="${heroImg(main.image)}" alt="${esc(main.title)}" loading="eager">
        <div class="re-hero__mosaic-overlay">
          <span class="re-hero__tag" style="background:${mainCat.color}">${esc(mainCat.name)}</span>
          <h2>${esc(main.title)}</h2>
          <p>${esc(main.excerpt)}</p>
          <div class="re-hero__mosaic-meta">
            <span><i class="far fa-clock"></i> ${esc(main.time)}</span>
            <span><i class="far fa-eye"></i> ${esc(main.views)}</span>
          </div>
        </div>
      </a>
      <div class="re-hero__mosaic-row">
        ${row.map(a => {
          const c = RE_CATEGORIES[a.cat];
          return `<a href="single.html?id=${a.id}" class="re-hero__mosaic-card">
            <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
            <div class="re-hero__mosaic-card-body">
              <span class="re-hero__tag re-hero__tag--sm" style="background:${c.color}">${esc(c.name)}</span>
              <h3>${esc(a.title)}</h3>
              <span class="re-hero__mosaic-time">${esc(a.time)}</span>
            </div>
          </a>`;
        }).join('')}
      </div>`;
  }

  function renderListings() {
    const el = document.getElementById('listingsGrid');
    if (!el) return;
    const items = getFeatured().slice(0, 3);
    el.innerHTML = items.map(a => {
      const cat = RE_CATEGORIES[a.cat];
      return `<div class="listing-card">
        <div class="listing-card__img"><img src="${a.image.replace('/300/170', '/500/280').replace('/600/375', '/500/280')}" alt="${esc(a.title)}"></div>
        <div class="listing-card__body">
          <span class="listing-card__cat" style="background:${cat.color}">${esc(cat.name)}</span>
          <h3 class="listing-card__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
          <p class="listing-card__excerpt">${esc(a.excerpt)}</p>
          <div class="listing-card__meta"><span><i class="far fa-clock"></i> ${esc(a.time)}</span><span><i class="far fa-eye"></i> ${esc(a.views)}</span></div>
        </div>
      </div>`;
    }).join('');
  }

  function renderTicker() {
    const el = document.getElementById('tickerInner');
    if (!el) return;
    const html = getBreaking().map(a => `<span class="re-ticker__item"><a href="single.html?id=${a.id}">${esc(a.title)}</a></span>`).join('');
    el.innerHTML = html + html;
  }

  function renderSiteFooter() {
    const el = document.getElementById('siteFooter');
    if (!el) return;
    el.innerHTML = `
      <footer class="footer-main" style="background:#0f172a"><div class="wrap"><div class="footer-grid">
        <div class="footer-brand"><a href="index.html" class="logo"><i class="fas fa-building" style="color:#8b5cf6"></i> عقار<span style="color:#fff">+</span></a><p style="color:rgba(255,255,255,.65)">مصدرك لأخبار العقار والسوق العقاري بالعربية.</p></div>
        <div class="footer-col"><h4>الأقسام</h4><ul><li><a href="archive.html?cat=sale">بيع</a></li><li><a href="archive.html?cat=rent">إيجار</a></li><li><a href="archive.html?cat=investment">استثمار</a></li><li><a href="archive.html?cat=luxury">فاخر</a></li></ul></div>
        <div class="footer-col"><h4>الموقع</h4><ul><li><a href="#">من نحن</a></li><li><a href="#">تواصل</a></li></ul></div>
      </div></div></footer>
      <div class="footer-bottom" style="background:#020617"><div class="wrap"><span style="color:rgba(255,255,255,.5)">© 2026 عقار+. جميع الحقوق محفوظة.</span></div></div>`;
  }

  function initCommon(options) {
    options = options || {};
    if (options.fullHeader !== false) {
      renderHero();
      renderListings();
    }
    renderTicker();
    renderSiteFooter();
  }

  return { esc, getArticle, getByCat, getLatest, getTrending, reCard, initCommon };
})();
