/* سُفرة — أدوات مشتركة لأخبار الطبخ */
window.CookShared = (function () {
  'use strict';

  function esc(s) {
    if (s == null) return '';
    const d = document.createElement('div');
    d.textContent = String(s);
    return d.innerHTML;
  }

  function getDifficulty(readTime) {
    const m = parseInt(String(readTime), 10) || 30;
    if (m <= 20) return { cls: 'easy', label: 'سهل' };
    if (m <= 50) return { cls: 'mid', label: 'متوسط' };
    return { cls: 'hard', label: 'تحدي' };
  }

  function getCookNews(id) {
    return COOK_ARTICLES.find(a => a.id === Number(id)) || COOK_ARTICLES[0];
  }

  function getByCat(cat, limit, excludeFeatured) {
    let list = COOK_ARTICLES.filter(a => a.cat === cat);
    if (excludeFeatured) list = list.filter(a => !a.featured);
    return limit ? list.slice(0, limit) : list;
  }

  function getFeatured() { return COOK_ARTICLES.filter(a => a.featured).slice(0, 4); }
  function getHotNews() { return COOK_ARTICLES.filter(a => a.breaking); }

  function getTrending(count) {
    return [...COOK_ARTICLES]
      .sort((a, b) => parseFloat(String(b.views).replace(/[^\d.]/g, '')) - parseFloat(String(a.views).replace(/[^\d.]/g, '')))
      .slice(0, count);
  }

  function getLatest(count) {
    return [...COOK_ARTICLES].sort((a, b) => b.id - a.id).slice(0, count);
  }

  function recipeCard(a, isTips) {
    const cat = COOK_CATEGORIES[a.cat];
    const diff = getDifficulty(a.readTime);
    const scoreHtml = isTips && a.score
      ? `<span class="recipe-card__score">${a.score}</span>`
      : '';
    const verdictHtml = isTips && a.verdict
      ? `<div class="recipe-card__foot"><span class="recipe-card__diff recipe-card__diff--easy">${esc(a.verdict)}</span></div>`
      : `<div class="recipe-card__foot">
          <div class="recipe-card__author"><img src="https://i.pravatar.cc/40?img=${a.avatar}" alt="">${esc(a.author)}</div>
          <span class="recipe-card__diff recipe-card__diff--${diff.cls}">${diff.label}</span>
        </div>`;

    return `<article class="recipe-card">
      <a href="single.html?id=${a.id}" class="recipe-card__img">
        <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
        ${scoreHtml}
        <span class="recipe-card__cat" style="background:${cat.color}">${isTips && a.score ? 'مراجعة' : esc(cat.name)}</span>
        <span class="recipe-card__time"><i class="far fa-clock"></i> ${esc(a.readTime)}</span>
      </a>
      <div class="recipe-card__body">
        <h3 class="recipe-card__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
        <p class="recipe-card__excerpt">${esc(a.excerpt)}</p>
        ${verdictHtml}
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
    const mainCat = COOK_CATEGORIES[main.cat];
    const stack = pool.slice(1, 4);

    el.innerHTML = `
      <a href="single.html?id=${main.id}" class="cook-hero__featured">
        <img src="${heroImg(main.image, 900, 620)}" alt="${esc(main.title)}" loading="eager">
        <div class="cook-hero__overlay">
          <span class="cook-badge"><i class="fas fa-fire"></i> خبر اليوم</span>
          <h2>${esc(main.title)}</h2>
          <div class="cook-hero__meta">
            <span><i class="far fa-clock"></i> ${esc(main.readTime)}</span>
            <span><i class="far fa-eye"></i> ${esc(main.views)}</span>
            <span><i class="fas fa-user"></i> ${esc(main.author)}</span>
            <span style="background:${mainCat.color};padding:2px 10px;border-radius:999px;font-size:.7rem">${esc(mainCat.name)}</span>
          </div>
        </div>
      </a>
      <div class="cook-hero__stack">
        ${stack.map(a => {
          const c = COOK_CATEGORIES[a.cat];
          return `<a href="single.html?id=${a.id}" class="cook-hero__round">
            <span class="cook-hero__round-thumb"><img src="${a.image}" alt="${esc(a.title)}" loading="lazy"></span>
            <div class="cook-hero__round-body">
              <span class="cook-hero__round-cat" style="color:${c.color}">${esc(c.name)}</span>
              <h3>${esc(a.title)}</h3>
              <span class="cook-hero__round-meta">${esc(a.readTime)} · ${esc(a.views)}</span>
            </div>
          </a>`;
        }).join('')}
      </div>`;
  }

  function renderTicker() {
    const el = document.getElementById('tickerInner');
    if (!el) return;
    const html = getHotNews().map(a =>
      `<span class="cook-ticker__item"><a href="single.html?id=${a.id}">${esc(a.title)}</a></span>`
    ).join('');
    el.innerHTML = html + html;
  }

  function renderSiteFooter() {
    const el = document.getElementById('siteFooter');
    if (!el) return;
    el.innerHTML = `
      <footer class="footer-main" style="background:#1a0f06"><div class="wrap"><div class="footer-grid">
        <div class="footer-brand"><a href="index.html" class="logo"><i class="fas fa-utensils" style="color:#fdba74"></i> سُ<span style="color:#fff">فرة</span></a><p style="color:rgba(255,255,255,.65)">أخبار الطبخ العربي — وصفات، مراجعات ونصائح من كل العالم.</p></div>
        <div class="footer-col"><h4>الأقسام</h4><ul><li><a href="archive.html?cat=main">أطباق رئيسية</a></li><li><a href="archive.html?cat=dessert">حلويات</a></li><li><a href="archive.html?cat=soup">شوربات</a></li></ul></div>
        <div class="footer-col"><h4>الموقع</h4><ul><li><a href="#">من نحن</a></li><li><a href="#">تواصل</a></li></ul></div>
      </div></div></footer>
      <div class="footer-bottom" style="background:#1a0f06;color:rgba(255,255,255,.5)"><div class="wrap"><span>© 2026 سُفرة — أخبار الطبخ</span></div></div>`;
  }

  function initCommon(options) {
    options = options || {};
    if (options.fullHeader !== false) renderHero();
    renderTicker();
    renderSiteFooter();
  }

  return { esc, getCookNews, getByCat, getLatest, getTrending, getDifficulty, recipeCard, initCommon };
})();
