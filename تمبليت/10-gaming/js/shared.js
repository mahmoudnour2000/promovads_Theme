/* جيمر+ — Shared utilities */
window.GameShared = (function () {
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
    return GAME_ARTICLES.find(a => a.id === Number(id)) || GAME_ARTICLES[0];
  }

  function getByCat(cat, limit, excludeFeatured) {
    let list = GAME_ARTICLES.filter(a => a.cat === cat);
    if (excludeFeatured) list = list.filter(a => !a.featured);
    return limit ? list.slice(0, limit) : list;
  }

  function getFeatured() { return GAME_ARTICLES.filter(a => a.featured).slice(0, 4); }
  function getBreaking() { return GAME_ARTICLES.filter(a => a.breaking); }

  function getTrending(count) {
    return [...GAME_ARTICLES]
      .sort((a, b) => parseFloat(String(b.views).replace(/[^\d.]/g, '')) - parseFloat(String(a.views).replace(/[^\d.]/g, '')))
      .slice(0, count);
  }

  function getLatest(count) {
    return [...GAME_ARTICLES].sort((a, b) => b.id - a.id).slice(0, count);
  }

  function gameCard(a) {
    const cat = GAME_CATEGORIES[a.cat];
    return `<article class="game-card">
      <a href="single.html?id=${a.id}" class="game-card__img">
        <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
        <span class="game-card__cat" style="background:${cat.color}">${esc(cat.name)}</span>
      </a>
      <div class="game-card__body">
        <h3 class="game-card__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
        <p class="game-card__excerpt">${esc(a.excerpt)}</p>
        <div class="game-card__foot">
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
    const mainCat = GAME_CATEGORIES[main.cat];
    const tiles = featured.slice(1, 4);

    el.innerHTML = `
      <a href="single.html?id=${main.id}" class="game-hero__featured">
        <div class="game-hero__featured-media">
          <img src="${heroImg(main.image)}" alt="${esc(main.title)}" loading="eager">
        </div>
        <div class="game-hero__featured-content">
          <div class="game-hero__featured-tags">
            <span class="game-hero__featured-badge"><i class="fas fa-fire"></i> خبر مميز</span>
            <span class="game-hero__featured-cat" style="background:${mainCat.color}">${esc(mainCat.name)}</span>
          </div>
          <h2>${esc(main.title)}</h2>
          <p>${esc(main.excerpt)}</p>
          <div class="game-hero__featured-meta">
            <span><i class="far fa-clock"></i> ${esc(main.time)}</span>
            <span><i class="far fa-eye"></i> ${esc(main.views)}</span>
          </div>
        </div>
      </a>
      <div class="game-hero__tiles">
        ${tiles.map(a => {
          const c = GAME_CATEGORIES[a.cat];
          return `<a href="single.html?id=${a.id}" class="game-hero__tile">
            <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
            <div class="game-hero__tile-overlay">
              <span class="game-hero__tile-cat" style="color:${c.color}">${esc(c.name)}</span>
              <h3>${esc(a.title)}</h3>
              <span class="game-hero__tile-meta">${esc(a.time)} · ${esc(a.views)}</span>
            </div>
          </a>`;
        }).join('')}
      </div>`;
  }

  function renderTicker() {
    const el = document.getElementById('tickerInner');
    if (!el) return;
    const html = getBreaking().map(a => `<span class="game-ticker__item"><a href="single.html?id=${a.id}">${esc(a.title)}</a></span>`).join('');
    el.innerHTML = html + html;
  }

  function renderSiteFooter() {
    const el = document.getElementById('siteFooter');
    if (!el) return;
    el.innerHTML = `
      <footer class="footer-main" style="background:#0f172a"><div class="wrap"><div class="footer-grid">
        <div class="footer-brand"><a href="index.html" class="logo"><i class="fas fa-gamepad" style="color:#a855f7"></i> جيمر<span style="color:#fff">+</span></a><p style="color:rgba(255,255,255,.65)">مصدرك لأخبار الألعاب والمراجعات وeSports بالعربية.</p></div>
        <div class="footer-col"><h4>الأقسام</h4><ul><li><a href="archive.html?cat=pc">PC</a></li><li><a href="archive.html?cat=console">كونsole</a></li><li><a href="archive.html?cat=esports">eSports</a></li><li><a href="archive.html?cat=reviews">مراجعات</a></li></ul></div>
        <div class="footer-col"><h4>الموقع</h4><ul><li><a href="#">من نحن</a></li><li><a href="#">تواصل</a></li></ul></div>
      </div></div></footer>
      <div class="footer-bottom" style="background:#020617"><div class="wrap"><span style="color:rgba(255,255,255,.5)">© 2026 جيمر+. جميع الحقوق محفوظة.</span></div></div>`;
  }

  function initCommon(options) {
    options = options || {};
    if (options.fullHeader !== false) renderHero();
    renderTicker();
    renderSiteFooter();
  }

  return { esc, getArticle, getByCat, getLatest, getTrending, gameCard, initCommon };
})();
