/* مال+ — Shared utilities */
window.FinanceShared = (function () {
  'use strict';

  function esc(s) {
    if (s == null) return '';
    const d = document.createElement('div');
    d.textContent = String(s);
    return d.innerHTML;
  }

  function getArticle(id) {
    return FIN_ARTICLES.find(a => a.id === Number(id)) || FIN_ARTICLES[0];
  }

  function getByCat(cat, limit, excludeFeatured) {
    let list = FIN_ARTICLES.filter(a => a.cat === cat);
    if (excludeFeatured) list = list.filter(a => !a.featured);
    return limit ? list.slice(0, limit) : list;
  }

  function getFeatured() { return FIN_ARTICLES.filter(a => a.featured).slice(0, 4); }
  function getBreaking() { return FIN_ARTICLES.filter(a => a.breaking); }

  function getTrending(count) {
    return [...FIN_ARTICLES]
      .sort((a, b) => parseFloat(String(b.views).replace(/[^\d.]/g, '')) - parseFloat(String(a.views).replace(/[^\d.]/g, '')))
      .slice(0, count);
  }

  function getLatest(count) {
    return [...FIN_ARTICLES].sort((a, b) => b.id - a.id).slice(0, count);
  }

  function articleCard(a, isAnalysis) {
    const cat = FIN_CATEGORIES[a.cat];
    if (isAnalysis && a.score) {
      const scoreColor = a.score >= 9 ? '#16a34a' : a.score >= 8 ? '#eab308' : '#15803d';
      return `<article class="card">
        <a href="single.html?id=${a.id}" class="card__thumb" style="position:relative">
          <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
          <span class="review-score" style="background:${scoreColor};position:absolute;bottom:10px;left:10px;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:.9rem;color:#fff">${a.score}</span>
          <span class="card__cat" style="background:${cat.color};color:#fff">تحليل</span>
        </a>
        <div class="card__body">
          <h3 class="card__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
          <div class="card__meta"><span>الحكم:</span><span style="color:${scoreColor};font-weight:700">${esc(a.verdict)}</span></div>
        </div>
      </article>`;
    }
    return `<article class="card">
      <a href="single.html?id=${a.id}" class="card__thumb">
        <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
        <span class="card__cat" style="background:${cat.color};color:#fff">${esc(cat.name)}</span>
      </a>
      <div class="card__body">
        <div class="card__meta"><span>${esc(a.time)}</span><span class="dot">${esc(a.readTime)}</span></div>
        <h3 class="card__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
        <p class="card__excerpt">${esc(a.excerpt)}</p>
        <div class="card__foot">
          <div class="card__author"><img src="https://i.pravatar.cc/40?img=${a.avatar}" alt="">${esc(a.author)}</div>
          <div class="card__stats"><span><i class="far fa-eye"></i> ${esc(a.views)}</span></div>
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
    const mainCat = FIN_CATEGORIES[main.cat];
    const minis = pool.slice(1, 4);

    el.innerHTML = `
      <a href="single.html?id=${main.id}" class="fin-hero__editorial">
        <img src="${heroImg(main.image, 900, 560)}" alt="${esc(main.title)}" loading="eager">
        <div class="fin-hero__overlay">
          <span class="fin-hero__badge"><i class="fas fa-newspaper"></i> تحليل مميز</span>
          <h2>${esc(main.title)}</h2>
          <div class="fin-hero__meta">
            <span><i class="fas ${mainCat.icon}"></i> ${esc(mainCat.name)}</span>
            <span><i class="far fa-clock"></i> ${esc(main.time)}</span>
            <span><i class="far fa-eye"></i> ${esc(main.views)}</span>
          </div>
        </div>
      </a>
      <div class="fin-hero__minis">
        ${minis.map(a => {
          const c = FIN_CATEGORIES[a.cat];
          return `<a href="single.html?id=${a.id}" class="fin-hero__hmini">
            <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
            <div class="fin-hero__hmini-body">
              <span class="fin-hero__hmini-cat" style="color:${c.color}">${esc(c.name)}</span>
              <h3>${esc(a.title)}</h3>
              <span class="fin-hero__hmini-meta">${esc(a.time)} · ${esc(a.views)}</span>
            </div>
          </a>`;
        }).join('')}
      </div>`;
  }

  function renderTicker() {
    const el = document.getElementById('tickerInner');
    if (!el) return;
    const html = getBreaking().map(a => `<span class="fin-ticker__item"><a href="single.html?id=${a.id}">${esc(a.title)}</a></span>`).join('');
    el.innerHTML = html + html;
  }

  function renderSiteFooter() {
    const el = document.getElementById('siteFooter');
    if (!el) return;
    el.innerHTML = `
      <footer class="footer-main" style="background:#0f172a"><div class="wrap"><div class="footer-grid">
        <div class="footer-brand"><a href="index.html" class="logo"><i class="fas fa-chart-line" style="color:#22c55e"></i> مال<span style="color:#fff">+</span></a><p style="color:rgba(255,255,255,.65)">مصدرك الأول لأخبار الأسواق والاقتصاد والأعمال في العالم العربي.</p></div>
        <div class="footer-col"><h4>الأقسام</h4><ul><li><a href="archive.html?cat=mk">أسواق مالية</a></li><li><a href="archive.html?cat=biz">أعمال</a></li><li><a href="archive.html?cat=eco">اقتصاد</a></li><li><a href="archive.html?cat=bank">بنوك</a></li></ul></div>
        <div class="footer-col"><h4>الموقع</h4><ul><li><a href="#">من نحن</a></li><li><a href="#">تواصل</a></li></ul></div>
      </div></div></footer>
      <div class="footer-bottom" style="background:#020617"><div class="wrap"><span style="color:rgba(255,255,255,.5)">© 2026 مال+. جميع الحقوق محفوظة.</span></div></div>`;
  }

  function initCommon(options) {
    options = options || {};
    if (options.fullHeader !== false) renderHero();
    renderTicker();
    renderSiteFooter();
  }

  return { esc, getArticle, getByCat, getLatest, getTrending, articleCard, initCommon };
})();
