/* Tech AI — Render articles from data (home page) */
(function () {
  'use strict';

  const { esc, getByCat, getLatest, getTrending, articleCard, initCommon } = TechShared;
  const catClass = { ai: 'cat-section--ai', hw: 'cat-section--hw', sw: 'cat-section--sw', sec: 'cat-section--sec', st: 'cat-section--st', rev: 'cat-section--ai' };

  function renderCategorySection(catKey, limit, isReview) {
    const cat = TECH_CATEGORIES[catKey];
    const articles = getByCat(catKey, limit, true);
    const cls = catClass[catKey] || 'cat-section--ai';
    return `<section class="cat-section ${cls}">
      <div class="cat-section__head">
        <div class="cat-section__info">
          <div class="cat-section__icon"><i class="fas ${cat.icon}"></i></div>
          <div>
            <h2 class="cat-section__name">${esc(cat.name)}</h2>
            <p class="cat-section__desc">${esc(cat.desc)}</p>
          </div>
        </div>
        <a href="archive.html?cat=${cat.slug}" class="cat-section__btn"><i class="fas fa-arrow-left"></i> ${esc(cat.btnText)}</a>
      </div>
      <div class="grid g3">${articles.map(a => articleCard(a, isReview)).join('')}</div>
    </section>`;
  }

  function renderSections() {
    const el = document.getElementById('categorySections');
    if (!el) return;
    el.innerHTML = ['ai', 'hw', 'sw', 'sec', 'st', 'rev'].map(key => renderCategorySection(key, 3, key === 'rev')).join('');
  }

  function renderLatest() {
    const el = document.getElementById('latestList');
    if (!el) return;
    el.innerHTML = getLatest(8).map(a => {
      const cat = TECH_CATEGORIES[a.cat];
      return `<article class="latest-item">
        <a href="single.html?id=${a.id}" class="latest-item__img"><img src="${a.image}" alt="${esc(a.title)}" loading="lazy"></a>
        <div>
          <div class="latest-item__cat" style="color:${cat.color}">${esc(cat.name)}</div>
          <h3 class="latest-item__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
          <div class="latest-item__meta">
            <span><i class="far fa-clock"></i> ${esc(a.time)}</span>
            <span><i class="far fa-eye"></i> ${esc(a.views)}</span>
            <span><i class="far fa-comment"></i> ${a.comments || 0}</span>
          </div>
        </div>
        <div class="latest-item__time">${esc(a.time)}</div>
      </article>`;
    }).join('');
  }

  function renderTrending() {
    const el = document.getElementById('trendingList');
    if (!el) return;
    el.innerHTML = getTrending(5).map((a, i) => {
      const n = String(i + 1).padStart(2, '0');
      return `<div class="trending-item"><span class="n">${n}</span><div><h4><a href="single.html?id=${a.id}">${esc(a.title)}</a></h4><span>${esc(a.views)} مشاهدة · ${esc(a.time)}</span></div></div>`;
    }).join('');
  }

  function renderTags() {
    const sidebar = document.getElementById('sidebarTags');
    if (sidebar) sidebar.innerHTML = TECH_TAGS.map(t => `<a href="#" class="tag">${esc(t)}</a>`).join('');
  }

  function renderSearchPreview() {
    const el = document.getElementById('searchPreview');
    if (!el) return;
    el.innerHTML = TECH_ARTICLES.slice(0, 3).map(a => {
      const cat = TECH_CATEGORIES[a.cat];
      return `<div class="search-result"><img src="${a.image.replace('/500/280', '/80/60').replace('/600/375', '/80/60').replace('/300/170', '/80/60').replace('/200/150', '/80/60')}" alt=""><div><h4>${esc(a.title)}</h4><span>${esc(cat.name)} · ${esc(a.time)}</span></div></div>`;
    }).join('');
  }

  document.addEventListener('DOMContentLoaded', () => {
    initCommon();
    renderTags();
    renderSections();
    renderLatest();
    renderTrending();
    renderSearchPreview();
  });
})();
