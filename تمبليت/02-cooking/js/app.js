/* سُفرة — الصفحة الرئيسية لأخبار الطبخ */
(function () {
  'use strict';

  const { esc, getByCat, getLatest, getTrending, recipeCard, initCommon } = CookShared;
  const catKeys = ['main', 'dessert', 'soup', 'salad', 'fast', 'tips'];

  function renderCategorySection(catKey, limit, isTips) {
    const cat = COOK_CATEGORIES[catKey];
    const articles = getByCat(catKey, limit, true);
    return `<section class="recipe-section recipe-section--${catKey}">
      <div class="recipe-section__head">
        <div>
          <div class="recipe-section__label"><i class="fas ${cat.icon}"></i> ${esc(cat.name)}</div>
          <h2 class="recipe-section__name">${esc(cat.name)}</h2>
          <p class="recipe-section__desc">${esc(cat.desc)}</p>
        </div>
        <a href="archive.html?cat=${cat.slug}" class="recipe-section__btn"><i class="fas fa-arrow-left"></i> ${esc(cat.btnText)}</a>
      </div>
      <div class="recipe-grid">${articles.map(a => recipeCard(a, isTips)).join('')}</div>
    </section>`;
  }

  function renderSections() {
    const el = document.getElementById('categorySections');
    if (!el) return;
    el.innerHTML = catKeys.map(key => renderCategorySection(key, 3, key === 'tips')).join('');
  }

  function renderLatest() {
    const el = document.getElementById('latestList');
    if (!el) return;
    el.innerHTML = getLatest(8).map(a => {
      const cat = COOK_CATEGORIES[a.cat];
      return `<article class="latest-item">
        <a href="single.html?id=${a.id}" class="latest-item__img"><img src="${a.image}" alt="${esc(a.title)}" loading="lazy"></a>
        <div>
          <div class="latest-item__cat" style="color:${cat.color}">${esc(cat.name)}</div>
          <h3 class="latest-item__title"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
          <div class="latest-item__meta">
            <span><i class="far fa-clock"></i> ${esc(a.readTime)}</span>
            <span><i class="far fa-eye"></i> ${esc(a.views)}</span>
          </div>
        </div>
        <span class="latest-item__pill">${esc(a.time)}</span>
      </article>`;
    }).join('');
  }

  function renderTrending() {
    const el = document.getElementById('trendingList');
    if (!el) return;
    el.innerHTML = getTrending(5).map((a, i) => {
      const n = String(i + 1).padStart(2, '0');
      return `<div class="trending-item" style="display:flex;gap:10px;padding:10px 0;border-bottom:1px dashed rgba(61,44,30,.1)"><span class="n">${n}</span><div><h4><a href="single.html?id=${a.id}">${esc(a.title)}</a></h4><span>${esc(a.views)} · ${esc(a.readTime)}</span></div></div>`;
    }).join('');
  }

  function renderTags() {
    const sidebar = document.getElementById('sidebarTags');
    if (sidebar) sidebar.innerHTML = COOK_TAGS.map(t => `<a href="#" class="tag">${esc(t)}</a>`).join('');
  }

  function renderSearchPreview() {
    const el = document.getElementById('searchPreview');
    if (!el) return;
    el.innerHTML = COOK_ARTICLES.slice(0, 3).map(a => {
      const cat = COOK_CATEGORIES[a.cat];
      return `<div class="search-result"><img src="${a.image.replace('/500/280', '/80/60').replace('/600/375', '/80/60').replace('/300/170', '/80/60').replace('/200/150', '/80/60')}" alt=""><div><h4>${esc(a.title)}</h4><span>${esc(cat.name)} · ${esc(a.readTime)}</span></div></div>`;
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
