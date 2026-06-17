/* Tech AI — Single article page */
(function () {
  'use strict';

  const { esc, getArticle, getByCat, getTrending, initCommon } = TechShared;

  function getParam(name) {
    return new URLSearchParams(window.location.search).get(name);
  }

  function buildBody(a) {
    const cat = TECH_CATEGORIES[a.cat];
    let html = `
      <p>${esc(a.excerpt)}</p>
      <p>في تحليلنا المعمّق، رصدنا تطورات مهمة تؤثر على مستقبل <strong>${esc(cat.name)}</strong> في عام 2026. الشركات الكبرى تتسارع في تقديم حلول جديدة، بينما يتابع المختصون بدقة التفاصيل التقنية والأثر على المستخدمين والمطورين على حد سواء.</p>
      <div class="info-box">
        <strong><i class="fas fa-info-circle"></i> ملخص سريع</strong>
        <p>${esc(a.excerpt)} — تقرير شامل يغطي أهم النقاط والتداعيات المتوقعة على القطاع.</p>
      </div>
      <h2>ما الجديد؟</h2>
      <p>على عكس التحديثات التدريجية السابقة، يقدّم هذا التطور تغييرات جوهرية في البنية والأداء. وفقاً للمصادر التقنية، النظام يعتمد على آليات استدلال متقدمة تمنحه قدرة أعلى على حل المشكلات متعددة الخطوات.</p>
      <p>من الناحية العملية، يظهر ذلك في مهام تتطلب تفكيراً مستمراً عبر خطوات متعددة — من البرمجة والتحليل إلى البحث والكتابة الإبداعية.</p>`;

    if (a.score) {
      const scoreColor = a.score >= 9 ? '#22c55e' : a.score >= 8 ? '#f59e0b' : '#6366f1';
      html += `
      <div class="review-box">
        <div class="review-box__title"><i class="fas fa-star" style="color:#f59e0b"></i> تقييم تك AI</div>
        <div class="review-scores">
          <div class="score-item"><div class="label">الأداء</div><div class="val" style="color:${scoreColor}">${a.score}</div><div class="score-bar-wrap"><div class="score-bar" style="width:${a.score * 10}%;background:${scoreColor}"></div></div></div>
          <div class="score-item"><div class="label">القيمة</div><div class="val" style="color:#6366f1">${(a.score - 0.3).toFixed(1)}</div><div class="score-bar-wrap"><div class="score-bar" style="width:${(a.score - 0.3) * 10}%;background:#6366f1"></div></div></div>
          <div class="score-item"><div class="label">التصميم</div><div class="val" style="color:#a855f7">${(a.score - 0.1).toFixed(1)}</div><div class="score-bar-wrap"><div class="score-bar" style="width:${(a.score - 0.1) * 10}%;background:#a855f7"></div></div></div>
        </div>
        <div class="verdict">
          <div class="verdict-score"><div class="big">${a.score}</div><div class="small">/10</div></div>
          <div><h4>${esc(a.verdict)} — اختيار المحرر 2026</h4><p>${esc(a.excerpt)}</p></div>
        </div>
      </div>`;
    }

    html += `
      <h2>الاختبار العملي</h2>
      <p>أجرينا اختبارات مكثفة على سيناريوهات واقعية. النتائج تؤكد أن ${esc(a.title)} يقدّم أداءً ملحوظاً في:</p>
      <ul>
        <li>المهام التقنية المعقدة والبرمجة متعددة الملفات</li>
        <li>تحليل المحتوى الطويل واستخراج النقاط الرئيسية</li>
        <li>الاستدلال المنطقي وحل المشكلات متعددة الخطوات</li>
        <li>الكتابة الإبداعية والترجمة السياقية</li>
      </ul>
      <blockquote>"${esc(a.title)} يمثل نقلة نوعية في ${esc(cat.name)} — ما نشهده اليوم يغيّر قواعد المنافسة." — ${esc(a.author)}</blockquote>
      <h2>الخلاصة</h2>
      <p>بناءً على تحليلنا الشامل، يستحق هذا الموضوع المتابعة عن كثب. ${esc(a.author)} يؤكد أن الصناعة تمر بمرحلة تحول حاسمة، والمستخدمون الذين يتبنون هذه التقنيات مبكراً سيحصلون على ميزة تنافسية واضحة.</p>`;

    return html;
  }

  function renderArticle() {
    const id = getParam('id') || 1;
    const a = getArticle(id);
    const cat = TECH_CATEGORIES[a.cat];
    const el = document.getElementById('articleContent');
    if (!el) return;

    document.title = `${a.title} — تك AI`;

    const prev = TECH_ARTICLES.find(x => x.id === a.id - 1);
    const next = TECH_ARTICLES.find(x => x.id === a.id + 1);
    const related = getByCat(a.cat, 4).filter(x => x.id !== a.id).slice(0, 3);
    const sidebar = getByCat(a.cat, 4).filter(x => x.id !== a.id).slice(0, 3);

    el.innerHTML = `
      <nav class="breadcrumb"><a href="index.html">الرئيسية</a><span class="sep">›</span><a href="archive.html?cat=${cat.slug}">${esc(cat.name)}</a><span class="sep">›</span><span class="current">${esc(a.title.substring(0, 40))}…</span></nav>
      <div class="article-cats">
        <a href="archive.html?cat=${cat.slug}" style="background:${cat.color}">${esc(cat.name)}</a>
        ${a.score ? '<a href="archive.html?cat=rev" style="background:#f59e0b;color:#000">مراجعة</a>' : ''}
      </div>
      <h1 class="article-title">${esc(a.title)}</h1>
      <p class="article-subtitle">${esc(a.excerpt)}</p>
      <div class="article-meta">
        <div class="author">
          <img src="https://i.pravatar.cc/80?img=${a.avatar}" alt="${esc(a.author)}">
          <div>
            <strong>${esc(a.author)}</strong>
            <div style="font-size:.72rem;color:#6366f1">محرر — ${esc(cat.name)}</div>
          </div>
        </div>
        <span><i class="fas fa-calendar-alt"></i> ${esc(a.time)}</span>
        <span><i class="far fa-clock"></i> ${esc(a.readTime)}</span>
        <span><i class="far fa-eye"></i> ${esc(a.views)} مشاهدة</span>
        <div class="share">
          <a href="#" class="share-btn share-fb"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="share-btn share-tw"><i class="fab fa-x-twitter"></i></a>
          <a href="#" class="share-btn share-wa"><i class="fab fa-whatsapp"></i></a>
          <a href="#" class="share-btn share-li"><i class="fab fa-linkedin-in"></i></a>
          <button class="share-btn copy-url" style="background:#444;font-size:11px"><i class="fas fa-link"></i></button>
        </div>
      </div>
      <figure class="article-feat">
        <img src="${a.image.replace('/500/280', '/1200/640').replace('/300/170', '/1200/640').replace('/200/150', '/1200/640').replace('/600/375', '/1200/640')}" alt="${esc(a.title)}">
        <figcaption>صورة توضيحية — ${esc(a.title)}</figcaption>
      </figure>
      <div class="entry-content">${buildBody(a)}</div>
      <div class="article-tags">
        <h4>الوسوم</h4>
        <div class="tags">${TECH_TAGS.slice(0, 4).map(t => `<a href="#" class="tag">${esc(t)}</a>`).join('')}</div>
      </div>
      <div class="author-box">
        <img src="https://i.pravatar.cc/120?img=${a.avatar}" alt="${esc(a.author)}" class="author-box__avatar">
        <div>
          <h3 class="author-box__name">${esc(a.author)}</h3>
          <div class="author-box__role">محرر — تك AI · ${esc(cat.name)}</div>
          <p class="author-box__bio">يغطي ${esc(a.author)} أخبار ${esc(cat.name)} منذ سنوات، مع تركيز على التحليل العميق والاختبار العملي للتقنيات الجديدة.</p>
        </div>
      </div>
      <nav class="post-nav">
        ${prev ? `<a href="single.html?id=${prev.id}" class="post-nav__item"><img src="${prev.image}" alt=""><div><div class="post-nav__label"><i class="fas fa-arrow-right"></i> السابق</div><div class="post-nav__title">${esc(prev.title)}</div></div></a>` : '<div></div>'}
        ${next ? `<a href="single.html?id=${next.id}" class="post-nav__item post-nav__item--next"><img src="${next.image}" alt=""><div><div class="post-nav__label">التالي <i class="fas fa-arrow-left"></i></div><div class="post-nav__title">${esc(next.title)}</div></div></a>` : ''}
      </nav>
      <section class="related">
        <h3 class="section-title">مقالات <span>ذات صلة</span></h3>
        <div class="grid g3" style="margin-top:20px">${related.map(r => {
          const rc = TECH_CATEGORIES[r.cat];
          return `<article class="card"><a href="single.html?id=${r.id}" class="card__thumb"><img src="${r.image}" alt="" loading="lazy"><span class="card__cat" style="background:${rc.color}">${esc(rc.name)}</span></a><div class="card__body"><h3 class="card__title"><a href="single.html?id=${r.id}">${esc(r.title)}</a></h3><div class="card__meta"><span>${esc(r.time)}</span><span class="dot">${esc(r.readTime)}</span></div></div></article>`;
        }).join('')}</div>
      </section>`;

    const sidebarEl = document.getElementById('singleSidebar');
    if (sidebarEl) {
      sidebarEl.innerHTML = `
        <div class="widget"><div class="widget__title">المزيد من ${esc(cat.name)}</div><div class="widget__body" style="padding:4px 12px">
          ${sidebar.map(r => `<div class="card--list" style="display:flex;gap:10px;padding:10px 0;border-bottom:1px solid rgba(99,102,241,.12)"><a href="single.html?id=${r.id}" class="card__thumb" style="width:90px;aspect-ratio:4/3;border-radius:6px;overflow:hidden;flex-shrink:0"><img src="${r.image}" alt="" loading="lazy"></a><div style="display:flex;flex-direction:column;justify-content:center"><h4 style="font-size:.82rem;line-height:1.4;margin-bottom:3px;color:#f4f4fc"><a href="single.html?id=${r.id}">${esc(r.title)}</a></h4><span style="font-size:.72rem;color:#c0c0dc">${esc(r.time)} · ${esc(r.readTime)}</span></div></div>`).join('')}
        </div></div>`;
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    initCommon({ fullHeader: false });
    renderArticle();
  });
})();
