/* صحة+ — Archive page */
(function () {
  'use strict';

  const { esc, getByCat, getTrending, healthCard, initCommon } = HealthShared;
  const catKeys = ['nutrition', 'fitness', 'mental', 'medicine', 'wellness', 'research'];

  function getParam(name) {
    return new URLSearchParams(window.location.search).get(name);
  }

  function renderArchiveHeader(catKey) {
    const cat = HEALTH_CATEGORIES[catKey];
    const count = getByCat(catKey).length;
    const el = document.getElementById('archiveHeader');
    if (!el) return;
    el.innerHTML = `
      <div class="wrap">
        <span class="label"><i class="fas ${cat.icon}"></i> قسم صحي</span>
        <h1>${esc(cat.name)}</h1>
        <p>${esc(cat.desc)}</p>
        <span class="count">${count} خبر · تحديث مستمر</span>
      </div>`;
    document.title = `${cat.name} — صحة+`;
  }

  function renderGrid(catKey) {
    const el = document.getElementById('archiveGrid');
    if (!el) return;
    el.className = 'grid g3';
    el.innerHTML = getByCat(catKey).map(a => healthCard(a)).join('');
  }

  function renderSidebar(catKey) {
    const el = document.getElementById('archiveSidebar');
    if (!el) return;
    const trending = getTrending(5);
    el.innerHTML = `
      <div class="widget"><div class="widget__title">الأقسام</div><div class="widget__body" style="padding:8px 12px">
        ${catKeys.map(k => {
          const c = HEALTH_CATEGORIES[k];
          const n = getByCat(k).length;
          const active = k === catKey ? 'color:var(--c-primary);font-weight:800' : 'color:var(--text-muted)';
          return `<a href="archive.html?cat=${k}" style="display:flex;justify-content:space-between;padding:10px 6px;border-bottom:1px dashed var(--health-border);font-size:.84rem;${active}"><span>${esc(c.name)}</span><span style="background:${c.color};color:#fff;padding:2px 8px;border-radius:999px;font-size:.68rem;font-weight:700">${n}</span></a>`;
        }).join('')}
      </div></div>
      <div class="widget"><div class="widget__title">🔥 الأكثر قراءة</div><div class="widget__body" style="padding:8px 16px">
        ${trending.map((a, i) => `<div style="display:flex;gap:10px;padding:8px 0;border-bottom:1px dashed var(--health-border)"><span style="font-weight:900;color:var(--c-primary)">${String(i + 1).padStart(2, '0')}</span><div><h4 style="font-size:.82rem;margin-bottom:3px"><a href="single.html?id=${a.id}">${esc(a.title)}</a></h4><span style="font-size:.72rem;color:var(--text-muted)">${esc(a.views)}</span></div></div>`).join('')}
      </div></div>`;
  }

  function setActiveNav(catKey) {
    document.querySelectorAll('.health-nav__item').forEach(el => el.classList.remove('active'));
    const item = document.querySelector(`.health-nav__item[data-cat="${catKey}"]`);
    if (item) item.classList.add('active');
  }

  document.addEventListener('DOMContentLoaded', () => {
    const catKey = catKeys.includes(getParam('cat')) ? getParam('cat') : 'nutrition';
    initCommon({ fullHeader: false });
    renderArchiveHeader(catKey);
    renderGrid(catKey);
    renderSidebar(catKey);
    setActiveNav(catKey);
  });
})();
