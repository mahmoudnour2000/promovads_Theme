/* Tech AI — Shared utilities */
window.TechShared = (function () {
  'use strict';

  function esc(s) {
    if (s == null) return '';
    const d = document.createElement('div');
    d.textContent = String(s);
    return d.innerHTML;
  }

  function getArticle(id) {
    return TECH_ARTICLES.find(a => a.id === Number(id)) || TECH_ARTICLES[0];
  }

  function getByCat(cat, limit, excludeFeatured) {
    let list = TECH_ARTICLES.filter(a => a.cat === cat);
    if (excludeFeatured) list = list.filter(a => !a.featured);
    return limit ? list.slice(0, limit) : list;
  }

  function getFeatured() {
    return TECH_ARTICLES.filter(a => a.featured).slice(0, 4);
  }

  function getBreaking() {
    return TECH_ARTICLES.filter(a => a.breaking);
  }

  function getTrending(count) {
    return [...TECH_ARTICLES]
      .sort((a, b) => parseFloat(String(b.views).replace(/[^\d.]/g, '')) - parseFloat(String(a.views).replace(/[^\d.]/g, '')))
      .slice(0, count);
  }

  function getLatest(count) {
    return [...TECH_ARTICLES].sort((a, b) => b.id - a.id).slice(0, count);
  }

  function articleCard(a, isReview) {
    const cat = TECH_CATEGORIES[a.cat];
    if (isReview && a.score) {
      const scoreColor = a.score >= 9 ? '#22c55e' : a.score >= 8 ? '#f59e0b' : '#6366f1';
      return `<article class="card">
        <a href="single.html?id=${a.id}" class="card__thumb" style="position:relative">
          <img src="${a.image}" alt="${esc(a.title)}" loading="lazy">
          <span class="review-score" style="background:${scoreColor};position:absolute;bottom:10px;left:10px;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:.9rem;color:#fff">${a.score}</span>
          <span class="card__cat" style="background:${cat.color};color:#fff">مراجعة</span>
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
    const pool = getFeatured().length >= 3
      ? getFeatured()
      : [...getFeatured(), ...getLatest(6).filter(a => !getFeatured().some(f => f.id === a.id))].slice(0, 3);
    if (!pool.length) return;
    const [main, ...side] = pool;
    const mainCat = TECH_CATEGORIES[main.cat];
    const breaking = getBreaking();
    const pulsePool = (breaking.length >= 2
      ? breaking
      : [...breaking, ...getLatest(5).filter(a => a.id !== main.id && !breaking.some(b => b.id === a.id))])
      .slice(0, 3);

    function sideCard(a, idx) {
      if (!a) return '';
      const c = TECH_CATEGORIES[a.cat];
      return `<a href="single.html?id=${a.id}" class="tech-hero__side-card">
        <span class="tech-hero__side-num">${String(idx + 1).padStart(2, '0')}</span>
        <img src="${heroImg(a.image, 220, 150)}" alt="${esc(a.title)}" loading="lazy">
        <div class="tech-hero__side-body">
          <span class="tech-hero__side-cat" style="color:${c.color}"><i class="fas ${c.icon}"></i> ${esc(c.name)}</span>
          <h3>${esc(a.title)}</h3>
          <span class="tech-hero__side-meta">${esc(a.time)} · ${esc(a.readTime)}</span>
        </div>
      </a>`;
    }

    const pulseHtml = pulsePool.length
      ? `<div class="tech-hero__pulse">
          <span class="tech-hero__pulse-label"><i class="fas fa-bolt"></i> الآن</span>
          <div class="tech-hero__pulse-track">
            ${pulsePool.map(a => {
              const c = TECH_CATEGORIES[a.cat];
              return `<a href="single.html?id=${a.id}" class="tech-hero__pulse-item" style="--pulse-color:${c.color}">
                <span class="tech-hero__pulse-cat">${esc(c.name)}</span>
                <span class="tech-hero__pulse-title">${esc(a.title)}</span>
              </a>`;
            }).join('')}
          </div>
        </div>`
      : '';

    el.innerHTML = `
      <div class="tech-hero__shell">
        <div class="tech-hero__grid">
          <a href="single.html?id=${main.id}" class="tech-hero__lead">
            <img src="${heroImg(main.image, 900, 560)}" alt="${esc(main.title)}" loading="eager">
            <div class="tech-hero__lead-overlay">
              ${main.breaking
                ? '<span class="tech-hero__live"><span class="tech-hero__live-dot"></span> عاجل</span>'
                : '<span class="tech-hero__badge"><i class="fas fa-microchip"></i> خبر مميز</span>'}
              <span class="tech-hero__cat" style="--cat-color:${mainCat.color}"><i class="fas ${mainCat.icon}"></i> ${esc(mainCat.name)}</span>
              <h2>${esc(main.title)}</h2>
              <p class="tech-hero__excerpt">${esc(main.excerpt)}</p>
              <div class="tech-hero__meta">
                <span><i class="far fa-clock"></i> ${esc(main.time)}</span>
                <span><i class="far fa-bookmark"></i> ${esc(main.readTime)}</span>
                <span><i class="far fa-eye"></i> ${esc(main.views)}</span>
              </div>
              <span class="tech-hero__cta">اقرأ المزيد <i class="fas fa-arrow-left"></i></span>
            </div>
          </a>
          <div class="tech-hero__side">
            ${sideCard(side[0], 0)}
            ${sideCard(side[1], 1)}
          </div>
        </div>
        ${pulseHtml}
      </div>`;
  }

  function renderTicker() {
    const el = document.getElementById('tickerInner');
    if (!el) return;
    const html = getBreaking().map(a => `<span class="tech-ticker__item"><a href="single.html?id=${a.id}">${esc(a.title)}</a></span>`).join('');
    el.innerHTML = html + html;
  }

  function renderSiteFooter() {
    const el = document.getElementById('siteFooter');
    if (!el) return;
    el.innerHTML = `
      <footer class="footer-main" style="background:#0f172a"><div class="wrap"><div class="footer-grid">
        <div class="footer-brand"><a href="index.html" class="logo"><i class="fas fa-microchip" style="color:#6366f1"></i> تك<span style="color:#fff">AI</span></a><p style="color:rgba(255,255,255,.65)">مصدرك الأول لأخبار الذكاء الاصطناعي والأجهزة والبرمجيات.</p></div>
        <div class="footer-col"><h4>الأقسام</h4><ul><li><a href="archive.html?cat=ai">ذكاء اصطناعي</a></li><li><a href="archive.html?cat=hw">أجهزة</a></li><li><a href="archive.html?cat=sw">برمجيات</a></li><li><a href="archive.html?cat=sec">أمن</a></li></ul></div>
        <div class="footer-col"><h4>الموقع</h4><ul><li><a href="#">من نحن</a></li><li><a href="#">تواصل</a></li></ul></div>
      </div></div></footer>
      <div class="footer-bottom" style="background:#020617"><div class="wrap"><span style="color:rgba(255,255,255,.5)">© 2026 تك AI. جميع الحقوق محفوظة.</span></div></div>`;
  }

  function initCommon(options) {
    options = options || {};
    if (options.fullHeader !== false) renderHero();
    renderTicker();
    renderSiteFooter();
  }

  return { esc, getArticle, getByCat, getLatest, getTrending, articleCard, initCommon };
})();
