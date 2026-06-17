/* كريبتو+ — Shared utilities */
window.CryptoShared = (function () {
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
    return CRYPTO_ARTICLES.find(a => a.id === Number(id)) || CRYPTO_ARTICLES[0];
  }

  function getByCat(cat, limit, excludeFeatured) {
    let list = CRYPTO_ARTICLES.filter(a => a.cat === cat);
    if (excludeFeatured) list = list.filter(a => !a.featured);
    return limit ? list.slice(0, limit) : list;
  }

  function getFeatured() { return CRYPTO_ARTICLES.filter(a => a.featured).slice(0, 4); }
  function getBreaking() { return CRYPTO_ARTICLES.filter(a => a.breaking); }

  function getTrending(count) {
    return [...CRYPTO_ARTICLES]
      .sort((a, b) => parseFloat(String(b.views).replace(/[^\d.]/g, '')) - parseFloat(String(a.views).replace(/[^\d.]/g, '')))
      .slice(0, count);
  }

  function getLatest(count) {
    return [...CRYPTO_ARTICLES].sort((a, b) => b.id - a.id).slice(0, count);
  }

  function cryptoCard(a) {
    const cat = CRYPTO_CATEGORIES[a.cat];
    return `<article class="crypto-card">
      <a href="single.html?id=${a.id}" class="crypto-card__img">
        <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
        <span class="crypto-card__cat" style="background:${cat.color}">${esc(cat.name)}</span>
      </a>
      <div class="crypto-card__body">
        <h3 class="crypto-card__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
        <p class="crypto-card__excerpt">${esc(a.excerpt)}</p>
        <div class="crypto-card__foot">
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
    const mainCat = CRYPTO_CATEGORIES[main.cat];
    const side = featured.slice(1, 3);

    el.innerHTML = `
      <div class="crypto-hero__grid">
        <a href="single.html?id=${main.id}" class="crypto-hero__lead">
          <img src="${heroImg(main.image)}" alt="${esc(main.title)}" loading="eager">
          <div class="crypto-hero__lead-overlay">
            <span class="crypto-hero__lead-cat" style="background:${mainCat.color}">${esc(mainCat.name)}</span>
            <h2>${esc(main.title)}</h2>
            <p>${esc(main.excerpt)}</p>
            <div class="crypto-hero__lead-meta">
              <span><i class="far fa-clock"></i> ${esc(main.time)}</span>
              <span><i class="far fa-eye"></i> ${esc(main.views)}</span>
            </div>
          </div>
        </a>
        <div class="crypto-hero__side">
          ${side.map(a => {
            const c = CRYPTO_CATEGORIES[a.cat];
            return `<a href="single.html?id=${a.id}" class="crypto-hero__side-card">
              <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
              <div class="crypto-hero__side-body">
                <span class="crypto-hero__side-cat" style="color:${c.color}">${esc(c.name)}</span>
                <h3>${esc(a.title)}</h3>
                <span class="crypto-hero__side-meta">${esc(a.time)} · ${esc(a.views)}</span>
              </div>
            </a>`;
          }).join('')}
        </div>
      </div>`;
  }

  function renderTicker() {
    const el = document.getElementById('tickerInner');
    if (!el) return;
    const html = getBreaking().map(a => `<span class="crypto-ticker__item"><a href="single.html?id=${a.id}">${esc(a.title)}</a></span>`).join('');
    el.innerHTML = html + html;
  }

  function renderSiteFooter() {
    const el = document.getElementById('siteFooter');
    if (!el) return;
    el.innerHTML = `
      <footer class="footer-main" style="background:#0f172a"><div class="wrap"><div class="footer-grid">
        <div class="footer-brand"><a href="index.html" class="logo"><i class="fab fa-bitcoin" style="color:#f7931a"></i> كريبتو<span style="color:#fff">+</span></a><p style="color:rgba(255,255,255,.65)">مصدرك العربي لأخبار البلوكشين والعملات الرقمية.</p></div>
        <div class="footer-col"><h4>الأقسام</h4><ul><li><a href="archive.html?cat=bitcoin">بيتكوين</a></li><li><a href="archive.html?cat=altcoins">عملات بديلة</a></li><li><a href="archive.html?cat=defi">DeFi</a></li><li><a href="archive.html?cat=nft">NFT</a></li></ul></div>
        <div class="footer-col"><h4>الموقع</h4><ul><li><a href="#">من نحن</a></li><li><a href="#">تواصل</a></li></ul></div>
      </div></div></footer>
      <div class="footer-bottom" style="background:#020617"><div class="wrap"><span style="color:rgba(255,255,255,.5)">© 2026 كريبتو+. جميع الحقوق محفوظة.</span></div></div>`;
  }

  function initCommon(options) {
    options = options || {};
    if (options.fullHeader !== false) renderHero();
    renderTicker();
    renderSiteFooter();
  }

  return { esc, getArticle, getByCat, getLatest, getTrending, cryptoCard, initCommon };
})();
