/* عقار+ — Single article page */
(function () {
  'use strict';

  const { esc, getArticle, getByCat, reCard, initCommon } = ReShared;

  function getParam(name) {
    return new URLSearchParams(window.location.search).get(name);
  }

  function buildBody(a) {
    const cat = RE_CATEGORIES[a.cat];
    return `
      <p>${esc(a.excerpt)}</p>
      <p>في تغطية <strong>عقار+</strong>، نتابع كل تفاصيل <strong>${esc(cat.name)}</strong> — من السوق إلى الإجراءات القانونية. ${esc(a.author)} يقدّم تحليلاً شاملاً للفرصة وتداعياتها على المستثمر والمشتري.</p>
      <div class="info-box" style="background:#f5f3ff;border-right:4px solid #8b5cf6;border-radius:8px 0 0 8px;padding:16px 20px;margin:24px 0">
        <strong style="color:#7c3aed;display:block;margin-bottom:4px"><i class="fas fa-building"></i> ملخص العقار</strong>
        <p style="color:#64748b;margin:0;font-size:.88rem">${esc(a.excerpt)}</p>
      </div>
      <h2>تفاصيل العرض</h2>
      <p>البيانات والتحليل يؤكدان أن ${esc(a.title)} من أبرز فرص ${esc(cat.name)} في السوق حالياً. المشترون والمستثمرون يتفاعلون بقوة مع ما يُعرض.</p>
      <ul>
        <li>الموقع والبنية التحتية المحيطة</li>
        <li>السعر مقارنة بالسوق المحلي</li>
        <li>إجراءات التملك والتمويل المتاحة</li>
        <li>توقعات العائد على الاستثمار</li>
      </ul>
      <blockquote style="background:#f8fafc;border-right:4px solid #8b5cf6;padding:16px 20px;border-radius:8px 0 0 8px;color:#334155">"${esc(a.title)} — فرصة تستحق المتابعة في سوق ${esc(cat.name)}." — ${esc(a.author)}</blockquote>
      <h2>الخلاصة</h2>
      <p>تابع عقار+ للحصول على آخر العروض وتحليلات السوق. ${esc(a.author)} يعد بتغطية مستمرة لكل ما هو جديد في ${esc(cat.name)}.</p>`;
  }

  function renderArticle() {
    const id = getParam('id') || 1;
    const a = getArticle(id);
    const cat = RE_CATEGORIES[a.cat];
    const el = document.getElementById('articleContent');
    if (!el) return;

    document.title = `${a.title} — عقار+`;
    const prev = RE_ARTICLES.find(x => x.id === a.id - 1);
    const next = RE_ARTICLES.find(x => x.id === a.id + 1);
    const related = getByCat(a.cat, 4).filter(x => x.id !== a.id).slice(0, 3);
    const sidebar = getByCat(a.cat, 4).filter(x => x.id !== a.id).slice(0, 3);

    el.innerHTML = `
      <nav class="breadcrumb"><a href="index.html">الرئيسية</a><span class="sep">›</span><a href="archive.html?cat=${cat.slug}">${esc(cat.name)}</a><span class="sep">›</span><span class="current">${esc(a.title.substring(0, 40))}…</span></nav>
      <div class="article-cats"><a href="archive.html?cat=${cat.slug}" style="background:${cat.color};color:#fff">${esc(cat.name)}</a></div>
      <h1 class="article-title">${esc(a.title)}</h1>
      <p class="article-subtitle">${esc(a.excerpt)}</p>
      <div class="article-meta">
        <div class="author">
          <img src="https://i.pravatar.cc/80?img=${a.avatar}" alt="${esc(a.author)}">
          <div><strong>${esc(a.author)}</strong><div style="font-size:.72rem;color:#8b5cf6">مراسل — ${esc(cat.name)}</div></div>
        </div>
        <span><i class="fas fa-calendar-alt"></i> ${esc(a.time)}</span>
        <span><i class="far fa-clock"></i> ${esc(a.readTime)}</span>
        <span><i class="far fa-eye"></i> ${esc(a.views)}</span>
        <div class="share">
          <a href="#" class="share-btn share-wa"><i class="fab fa-whatsapp"></i></a>
          <a href="#" class="share-btn share-tw"><i class="fab fa-x-twitter"></i></a>
          <button class="share-btn copy-url" style="background:#444;font-size:11px"><i class="fas fa-link"></i></button>
        </div>
      </div>
      <figure class="article-feat">
        <img src="${a.image.replace('/500/280', '/1200/640').replace('/300/170', '/1200/640').replace('/200/150', '/1200/640').replace('/600/375', '/1200/640')}" alt="${esc(a.title)}">
        <figcaption>${esc(a.title)} — عقار+</figcaption>
      </figure>
      <div class="entry-content">${buildBody(a)}</div>
      <div class="article-tags"><h4>الوسوم</h4><div class="tags">${RE_TAGS.slice(0, 4).map(t => `<a href="#" class="tag">${esc(t)}</a>`).join('')}</div></div>
      <div class="author-box">
        <img src="https://i.pravatar.cc/120?img=${a.avatar}" alt="" class="author-box__avatar">
        <div><h3 class="author-box__name">${esc(a.author)}</h3><div class="author-box__role">مراسل عقاري — عقار+</div>
        <p class="author-box__bio">يغطي ${esc(a.author)} ${esc(cat.name)} منذ سنوات — تحليلات سوق وتقارير ميدانية.</p></div>
      </div>
      <nav class="post-nav">
        ${prev ? `<a href="single.html?id=${prev.id}" class="post-nav__item"><img src="${prev.image}" alt=""><div><div class="post-nav__label"><i class="fas fa-arrow-right"></i> السابق</div><div class="post-nav__title">${esc(prev.title)}</div></div></a>` : '<div></div>'}
        ${next ? `<a href="single.html?id=${next.id}" class="post-nav__item post-nav__item--next"><img src="${next.image}" alt=""><div><div class="post-nav__label">التالي <i class="fas fa-arrow-left"></i></div><div class="post-nav__title">${esc(next.title)}</div></div></a>` : ''}
      </nav>
      <section class="related">
        <h3 class="section-title">عقارات <span>ذات صلة</span></h3>
        <div class="grid g3" style="margin-top:20px">${related.map(r => reCard(r)).join('')}</div>
      </section>`;

    const sidebarEl = document.getElementById('singleSidebar');
    if (sidebarEl) {
      sidebarEl.innerHTML = `<div class="widget"><div class="widget__title">المزيد من ${esc(cat.name)}</div><div class="widget__body" style="padding:4px 12px">
        ${sidebar.map(r => `<div style="display:flex;gap:10px;padding:10px 0;border-bottom:1px dashed var(--re-border)"><a href="single.html?id=${r.id}" style="width:90px;aspect-ratio:4/3;border-radius:8px;overflow:hidden;flex-shrink:0"><img src="${r.image}" alt="" style="width:100%;height:100%;object-fit:cover"></a><div><h4 style="font-size:.82rem;margin-bottom:4px"><a href="single.html?id=${r.id}">${esc(r.title)}</a></h4><span style="font-size:.72rem;color:var(--text-muted)">${esc(r.readTime)}</span></div></div>`).join('')}
      </div></div>`;
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    initCommon({ fullHeader: false });
    renderArticle();
  });
})();
