/* تعليم+ — Shared utilities */
window.EduShared = (function () {
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
    return EDU_ARTICLES.find(a => a.id === Number(id)) || EDU_ARTICLES[0];
  }

  function getByCat(cat, limit, excludeFeatured) {
    let list = EDU_ARTICLES.filter(a => a.cat === cat);
    if (excludeFeatured) list = list.filter(a => !a.featured);
    return limit ? list.slice(0, limit) : list;
  }

  function getFeatured() { return EDU_ARTICLES.filter(a => a.featured).slice(0, 4); }
  function getBreaking() { return EDU_ARTICLES.filter(a => a.breaking); }

  function getTrending(count) {
    return [...EDU_ARTICLES]
      .sort((a, b) => parseFloat(String(b.views).replace(/[^\d.]/g, '')) - parseFloat(String(a.views).replace(/[^\d.]/g, '')))
      .slice(0, count);
  }

  function getLatest(count) {
    return [...EDU_ARTICLES].sort((a, b) => b.id - a.id).slice(0, count);
  }

  function eduCard(a) {
    const cat = EDU_CATEGORIES[a.cat];
    return `<article class="edu-card">
      <a href="single.html?id=${a.id}" class="edu-card__img">
        <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
        <span class="edu-card__cat" style="background:${cat.color}">${esc(cat.name)}</span>
      </a>
      <div class="edu-card__body">
        <h3 class="edu-card__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
        <p class="edu-card__excerpt">${esc(a.excerpt)}</p>
        <div class="edu-card__foot">
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
    const mainCat = EDU_CATEGORIES[main.cat];
    const timeline = getLatest(8).filter(a => a.id !== main.id).slice(0, 4);

    el.innerHTML = `
      <div class="edu-hero__layout">
        <a href="single.html?id=${main.id}" class="edu-hero__main">
          <span class="edu-hero__ribbon"><i class="fas fa-graduation-cap"></i> خبر مميز</span>
          <img src="${heroImg(main.image)}" alt="${esc(main.title)}" loading="eager">
          <div class="edu-hero__overlay">
            <span class="edu-hero__cat" style="background:${mainCat.color}">${esc(mainCat.name)}</span>
            <h2>${esc(main.title)}</h2>
            <p class="edu-hero__excerpt">${esc(main.excerpt)}</p>
            <div class="edu-hero__meta">
              <span><i class="fas fa-user-graduate"></i> ${esc(main.author)}</span>
              <span><i class="far fa-clock"></i> ${esc(main.time)}</span>
            </div>
          </div>
        </a>
        <div class="edu-hero__timeline">
          <div class="edu-hero__timeline-head">آخر الأخبار</div>
          ${timeline.map((a, i) => {
            const c = EDU_CATEGORIES[a.cat];
            const last = i === timeline.length - 1;
            return `<a href="single.html?id=${a.id}" class="edu-hero__timeline-item${last ? ' edu-hero__timeline-item--last' : ''}">
              <span class="edu-hero__timeline-dot" style="border-color:${c.color}"></span>
              <div class="edu-hero__timeline-body">
                <span class="edu-hero__timeline-cat" style="color:${c.color}">${esc(c.name)}</span>
                <h4>${esc(a.title)}</h4>
                <span class="edu-hero__timeline-meta">${esc(a.time)} · ${esc(a.views)}</span>
              </div>
            </a>`;
          }).join('')}
        </div>
      </div>`;
  }

  function renderTicker() {
    const el = document.getElementById('tickerInner');
    if (!el) return;
    const html = getBreaking().map(a => `<span class="edu-ticker__item"><a href="single.html?id=${a.id}">${esc(a.title)}</a></span>`).join('');
    el.innerHTML = html + html;
  }

  function renderSiteFooter() {
    const el = document.getElementById('siteFooter');
    if (!el) return;
    el.innerHTML = `
      <footer class="footer-main" style="background:#0f172a"><div class="wrap"><div class="footer-grid">
        <div class="footer-brand"><a href="index.html" class="logo"><i class="fas fa-graduation-cap" style="color:#f59e0b"></i> تعليم<span style="color:#fff">+</span></a><p style="color:rgba(255,255,255,.65)">مصدرك لأخبار التعليم والمنح والجامعات بالعربية.</p></div>
        <div class="footer-col"><h4>الأقسام</h4><ul><li><a href="archive.html?cat=schools">مدارس</a></li><li><a href="archive.html?cat=university">جامعات</a></li><li><a href="archive.html?cat=scholarships">منح</a></li><li><a href="archive.html?cat=edtech">EdTech</a></li></ul></div>
        <div class="footer-col"><h4>الموقع</h4><ul><li><a href="#">من نحن</a></li><li><a href="#">تواصل</a></li></ul></div>
      </div></div></footer>
      <div class="footer-bottom" style="background:#020617"><div class="wrap"><span style="color:rgba(255,255,255,.5)">© 2026 تعليم+. جميع الحقوق محفوظة.</span></div></div>`;
  }

  function initCommon(options) {
    options = options || {};
    if (options.fullHeader !== false) renderHero();
    renderTicker();
    renderSiteFooter();
  }

  return { esc, getArticle, getByCat, getLatest, getTrending, eduCard, initCommon };
})();
