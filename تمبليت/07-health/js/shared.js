/* صحة+ — Shared utilities */
window.HealthShared = (function () {
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
    return HEALTH_ARTICLES.find(a => a.id === Number(id)) || HEALTH_ARTICLES[0];
  }

  function getByCat(cat, limit, excludeFeatured) {
    let list = HEALTH_ARTICLES.filter(a => a.cat === cat);
    if (excludeFeatured) list = list.filter(a => !a.featured);
    return limit ? list.slice(0, limit) : list;
  }

  function getFeatured() { return HEALTH_ARTICLES.filter(a => a.featured).slice(0, 4); }
  function getBreaking() { return HEALTH_ARTICLES.filter(a => a.breaking); }

  function getTrending(count) {
    return [...HEALTH_ARTICLES]
      .sort((a, b) => parseFloat(String(b.views).replace(/[^\d.]/g, '')) - parseFloat(String(a.views).replace(/[^\d.]/g, '')))
      .slice(0, count);
  }

  function getLatest(count) {
    return [...HEALTH_ARTICLES].sort((a, b) => b.id - a.id).slice(0, count);
  }

  function healthCard(a) {
    const cat = HEALTH_CATEGORIES[a.cat];
    return `<article class="health-card">
      <a href="single.html?id=${a.id}" class="health-card__img">
        <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
        <span class="health-card__cat" style="background:${cat.color}">${esc(cat.name)}</span>
      </a>
      <div class="health-card__body">
        <h3 class="health-card__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
        <p class="health-card__excerpt">${esc(a.excerpt)}</p>
        <div class="health-card__foot">
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
    const mainCat = HEALTH_CATEGORIES[main.cat];
    const listItems = getLatest(8).filter(a => a.id !== main.id).slice(0, 5);

    el.innerHTML = `
      <div class="health-hero__split">
        <a href="single.html?id=${main.id}" class="health-hero__main">
          <img src="${heroImg(main.image)}" alt="${esc(main.title)}" loading="eager">
          <div class="health-hero__overlay">
            <span class="health-hero__pill" style="background:${mainCat.color}">${esc(mainCat.name)}</span>
            <h2>${esc(main.title)}</h2>
            <p class="health-hero__excerpt">${esc(main.excerpt)}</p>
            <div class="health-hero__meta">
              <span><i class="fas fa-user-md"></i> ${esc(main.author)}</span>
              <span><i class="far fa-clock"></i> ${esc(main.time)}</span>
            </div>
          </div>
        </a>
        <aside class="health-hero__aside">
          <div class="health-hero__aside-head"><i class="fas fa-newspaper"></i> آخر الأخبار</div>
          <ol class="health-hero__numbered">
            ${listItems.map((a, i) => {
              const c = HEALTH_CATEGORIES[a.cat];
              return `<li>
                <a href="single.html?id=${a.id}" class="health-hero__numbered-item">
                  <span class="health-hero__num">${i + 1}</span>
                  <div>
                    <span class="health-hero__list-cat" style="color:${c.color}">${esc(c.name)}</span>
                    <h4>${esc(a.title)}</h4>
                    <span class="health-hero__list-meta">${esc(a.time)}</span>
                  </div>
                </a>
              </li>`;
            }).join('')}
          </ol>
        </aside>
      </div>`;
  }

  function renderTicker() {
    const el = document.getElementById('tickerInner');
    if (!el) return;
    const html = getBreaking().map(a => `<span class="health-ticker__item"><a href="single.html?id=${a.id}">${esc(a.title)}</a></span>`).join('');
    el.innerHTML = html + html;
  }

  function renderSiteFooter() {
    const el = document.getElementById('siteFooter');
    if (!el) return;
    el.innerHTML = `
      <footer class="footer-main" style="background:#0f172a"><div class="wrap"><div class="footer-grid">
        <div class="footer-brand"><a href="index.html" class="logo"><i class="fas fa-heartbeat" style="color:#14b8a6"></i> صحة<span style="color:#fff">+</span></a><p style="color:rgba(255,255,255,.65)">مصدرك الموثوق للأخبار الصحية والطبية بالعربية.</p></div>
        <div class="footer-col"><h4>الأقسام</h4><ul><li><a href="archive.html?cat=nutrition">تغذية</a></li><li><a href="archive.html?cat=fitness">لياقة</a></li><li><a href="archive.html?cat=mental">صحة نفسية</a></li><li><a href="archive.html?cat=medicine">طب</a></li></ul></div>
        <div class="footer-col"><h4>الموقع</h4><ul><li><a href="#">من نحن</a></li><li><a href="#">تواصل</a></li></ul></div>
      </div></div></footer>
      <div class="footer-bottom" style="background:#020617"><div class="wrap"><span style="color:rgba(255,255,255,.5)">© 2026 صحة+. جميع الحقوق محفوظة.</span></div></div>`;
  }

  function initCommon(options) {
    options = options || {};
    if (options.fullHeader !== false) renderHero();
    renderTicker();
    renderSiteFooter();
  }

  return { esc, getArticle, getByCat, getLatest, getTrending, healthCard, initCommon };
})();
