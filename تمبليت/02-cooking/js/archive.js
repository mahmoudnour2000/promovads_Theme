/* سُفرة — صفحة أرشيف أخبار الطبخ */
(function () {
  'use strict';

  const { esc, getByCat, getTrending, recipeCard, initCommon } = CookShared;
  const catKeys = ['main', 'dessert', 'soup', 'salad', 'fast', 'tips'];

  function getParam(name) {
    return new URLSearchParams(window.location.search).get(name);
  }

  function renderArchiveHeader(catKey) {
    const cat = COOK_CATEGORIES[catKey];
    const count = getByCat(catKey).length;
    const el = document.getElementById('archiveHeader');
    if (!el) return;
    el.innerHTML = `
      <div class="wrap">
        <span class="label"><i class="fas ${cat.icon}"></i> قسم أخبار الطبخ</span>
        <h1>${esc(cat.name)}</h1>
        <p>${esc(cat.desc)}</p>
        <span class="count">${count} خبر · تحديث مستمر</span>
      </div>`;
    document.title = `${cat.name} — أخبار الطبخ | سُفرة`;
  }

  function renderGrid(catKey) {
    const el = document.getElementById('archiveGrid');
    if (!el) return;
    el.className = 'recipe-grid';
    el.innerHTML = getByCat(catKey).map(a => recipeCard(a, catKey === 'tips')).join('');
  }

  function renderSidebar(catKey) {
    const el = document.getElementById('archiveSidebar');
    if (!el) return;
    const trending = getTrending(5);
    el.innerHTML = `
      <div class="widget"><div class="widget__title">🍽️ أقسام أخبار الطبخ</div><div class="widget__body" style="padding:8px 12px">
        ${catKeys.map(k => {
          const c = COOK_CATEGORIES[k];
          const n = getByCat(k).length;
          const active = k === catKey ? 'color:#c2410c;font-weight:800' : 'color:#7a6558';
          return `<a href="archive.html?cat=${k}" style="display:flex;justify-content:space-between;padding:10px 6px;border-bottom:1px dashed rgba(61,44,30,.1);font-size:.84rem;${active}"><span>${esc(c.name)}</span><span style="background:${c.color};color:#fff;padding:2px 8px;border-radius:999px;font-size:.68rem">${n}</span></a>`;
        }).join('')}
      </div></div>
      <div class="widget"><div class="widget__title">🔥 الأكثر قراءة</div><div class="widget__body" style="padding:8px 16px">
        ${trending.map((a, i) => `<div class="trending-item" style="display:flex;gap:10px;padding:8px 0;border-bottom:1px dashed rgba(61,44,30,.08)"><span class="n">${String(i + 1).padStart(2, '0')}</span><div><h4 style="font-size:.82rem;margin-bottom:3px"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h4><span style="font-size:.72rem;color:#7a6558">${esc(a.views)} · ${esc(a.time)}</span></div></div>`).join('')}
      </div></div>`;
  }

  function setActiveNav(catKey) {
    document.querySelectorAll('.cook-nav__item').forEach(el => el.classList.remove('active'));
    const item = document.querySelector(`.cook-nav__item[data-cat="${catKey}"]`);
    if (item) item.classList.add('active');
  }

  document.addEventListener('DOMContentLoaded', () => {
    const catKey = catKeys.includes(getParam('cat')) ? getParam('cat') : 'main';
    initCommon({ fullHeader: false });
    renderArchiveHeader(catKey);
    renderGrid(catKey);
    renderSidebar(catKey);
    setActiveNav(catKey);
  });
})();
