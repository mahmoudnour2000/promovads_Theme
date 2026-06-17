/* Tech AI — Archive / category page */
(function () {
  'use strict';

  const { esc, getByCat, getTrending, articleCard, initCommon } = TechShared;
  const catKeys = ['ai', 'hw', 'sw', 'sec', 'st', 'rev'];

  function getParam(name) {
    return new URLSearchParams(window.location.search).get(name);
  }

  function renderArchiveHeader(catKey) {
    const cat = TECH_CATEGORIES[catKey];
    const count = getByCat(catKey).length;
    const el = document.getElementById('archiveHeader');
    if (!el) return;
    el.innerHTML = `
      <div class="wrap">
        <span class="label"><i class="fas ${cat.icon}"></i> قسم</span>
        <h1>${esc(cat.name)}</h1>
        <p>${esc(cat.desc)}</p>
        <span class="count">${count} مقالة · تحديث مستمر</span>
      </div>`;
    document.title = `${cat.name} — أرشيف تك AI`;
  }

  function renderGrid(catKey) {
    const el = document.getElementById('archiveGrid');
    if (!el) return;
    el.className = 'grid g3';
    el.innerHTML = getByCat(catKey).map(a => articleCard(a, catKey === 'rev')).join('');
  }

  function renderSidebar(catKey) {
    const el = document.getElementById('archiveSidebar');
    if (!el) return;
    const trending = getTrending(5);
    el.innerHTML = `
      <div class="widget"><div class="widget__title">الأقسام</div><div class="widget__body" style="padding:8px 12px">
        ${catKeys.map(k => {
          const c = TECH_CATEGORIES[k];
          const n = getByCat(k).length;
          const active = k === catKey ? 'color:#4f46e5;font-weight:800' : 'color:var(--text-muted)';
          return `<a href="archive.html?cat=${k}" style="display:flex;justify-content:space-between;padding:10px 6px;border-bottom:1px dashed var(--tech-border);font-size:.84rem;${active}"><span>${esc(c.name)}</span><span style="background:${c.color};color:#fff;padding:2px 8px;border-radius:999px;font-size:.68rem;font-weight:700">${n}</span></a>`;
        }).join('')}
      </div></div>
      <div class="widget"><div class="widget__title">🔥 الأكثر قراءة</div><div class="widget__body" style="padding:8px 16px">
        ${trending.map((a, i) => `<div class="trending-item" style="display:flex;gap:10px;padding:8px 0;border-bottom:1px dashed var(--tech-border)"><span class="n">${String(i + 1).padStart(2, '0')}</span><div><h4 style="font-size:.82rem;margin-bottom:3px"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h4><span style="font-size:.72rem;color:var(--text-muted)">${esc(a.views)} · ${esc(a.time)}</span></div></div>`).join('')}
      </div></div>`;
  }

  function setActiveNav(catKey) {
    document.querySelectorAll('.tech-nav__item').forEach(el => el.classList.remove('active'));
    const item = document.querySelector(`.tech-nav__item[data-cat="${catKey}"]`);
    if (item) item.classList.add('active');
  }

  document.addEventListener('DOMContentLoaded', () => {
    const catKey = catKeys.includes(getParam('cat')) ? getParam('cat') : 'ai';
    initCommon({ fullHeader: false });
    renderArchiveHeader(catKey);
    renderGrid(catKey);
    renderSidebar(catKey);
    setActiveNav(catKey);
  });
})();
