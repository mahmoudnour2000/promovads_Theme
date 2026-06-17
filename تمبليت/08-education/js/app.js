/* تعليم+ — Home page */
(function () {
  'use strict';

  const { esc, getByCat, getLatest, getTrending, eduCard, initCommon } = EduShared;
  const catKeys = ['schools', 'university', 'scholarships', 'edtech', 'exams', 'careers'];
  const sectionColors = {
    schools: '#3b82f6', university: '#8b5cf6', scholarships: '#22c55e',
    edtech: '#06b6d4', exams: '#ef4444', careers: '#f59e0b'
  };

  function renderCategorySection(catKey, limit) {
    const cat = EDU_CATEGORIES[catKey];
    const articles = getByCat(catKey, limit, true);
    return `<section class="edu-section">
      <div class="edu-section__head">
        <div class="edu-section__info">
          <div class="edu-section__icon" style="background:${sectionColors[catKey]}"><i class="fas ${cat.icon}"></i></div>
          <div>
            <h2 class="edu-section__name">${esc(cat.name)}</h2>
            <p class="edu-section__desc">${esc(cat.desc)}</p>
          </div>
        </div>
        <a href="archive.html?cat=${cat.slug}" class="edu-section__btn"><i class="fas fa-arrow-left"></i> ${esc(cat.btnText)}</a>
      </div>
      <div class="grid g3">${articles.map(a => eduCard(a)).join('')}</div>
    </section>`;
  }

  function renderSections() {
    const el = document.getElementById('categorySections');
    if (!el) return;
    el.innerHTML = catKeys.map(key => renderCategorySection(key, 3)).join('');
  }

  function renderLatest() {
    const el = document.getElementById('latestList');
    if (!el) return;
    el.innerHTML = getLatest(8).map(a => {
      const cat = EDU_CATEGORIES[a.cat];
      return `<article class="latest-item">
        <a href="single.html?id=${a.id}" class="latest-item__img"><img src="${a.image}" alt="${esc(a.title)}" loading="lazy"></a>
        <div>
          <div style="font-size:.68rem;font-weight:800;color:${cat.color};margin-bottom:4px">${esc(cat.name)}</div>
          <h3 style="font-size:.9rem;font-weight:700;line-height:1.5;margin-bottom:6px"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h3>
          <div style="font-size:.72rem;color:var(--text-muted);display:flex;gap:12px"><span><i class="far fa-clock"></i> ${esc(a.time)}</span><span><i class="far fa-eye"></i> ${esc(a.views)}</span></div>
        </div>
        <span style="font-size:.72rem;color:var(--text-subtle);white-space:nowrap">${esc(a.time)}</span>
      </article>`;
    }).join('');
  }

  function renderTrending() {
    const el = document.getElementById('trendingList');
    if (!el) return;
    el.innerHTML = getTrending(5).map((a, i) =>
      `<div style="display:flex;gap:10px;padding:10px 0;border-bottom:1px dashed var(--edu-border)"><span style="font-size:1rem;font-weight:900;color:var(--c-primary)">${String(i + 1).padStart(2, '0')}</span><div><h4 style="font-size:.82rem;margin-bottom:4px"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h4><span style="font-size:.72rem;color:var(--text-muted)">${esc(a.views)} · ${esc(a.time)}</span></div></div>`
    ).join('');
  }

  function renderTags() {
    const el = document.getElementById('sidebarTags');
    if (el) el.innerHTML = EDU_TAGS.map(t => `<a href="#" class="tag">${esc(t)}</a>`).join('');
  }

  function renderSearchPreview() {
    const el = document.getElementById('searchPreview');
    if (!el) return;
    el.innerHTML = EDU_ARTICLES.slice(0, 3).map(a => {
      const cat = EDU_CATEGORIES[a.cat];
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
