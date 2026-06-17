/* سُفرة — صفحة خبر الطبخ */
(function () {
  'use strict';

  const { esc, getCookNews, getByCat, initCommon } = CookShared;

  function getParam(name) {
    return new URLSearchParams(window.location.search).get(name);
  }

  function buildBody(a) {
    const cat = COOK_CATEGORIES[a.cat];
    let html = `
      <p>${esc(a.excerpt)}</p>
      <p>هذا الخبر من قسم <strong>${esc(cat.name)}</strong> — جرّبنا الوصفة في مطبخ سُفرة ونشرنا لكم التفاصيل الكاملة. ${esc(a.author)} يشارك أسرار التحضير التي تجعل الطبق مميزاً.</p>
      <div class="info-box">
        <strong><i class="fas fa-info-circle"></i> معلومات سريعة</strong>
        <p>وقت التحضير: ${esc(a.readTime)} · ${esc(a.excerpt)}</p>
      </div>
      <h2>المكونات</h2>
      <ul>
        <li>مكونات طازجة حسب الوصفة — يُفضّل تحضيرها قبل البدء</li>
        <li>بهارات وتوابل مناسبة لـ ${esc(cat.name)}</li>
        <li>زيت زيتون بكر أو زبدة حسب نوع الطبق</li>
        <li>ملح وفلفل أسود — للتتبيل حسب الذوق</li>
      </ul>
      <h2>طريقة التحضير</h2>
      <p>ابدأ بتحضير جميع المكونات (mise en place) — هذا يوفّر الوقت ويمنع الأخطاء. اتبع الخطوات بالترتيب ولا تستعجل على النار.</p>
      <p>في الخطوة الأخيرة، قدّم الطبق ساخناً مع الإضافات المناسبة. ${esc(a.title)} تُقدَّم traditionally مع أطباق جانبية تكمل النكهة.</p>`;

    if (a.score) {
      const scoreColor = a.score >= 9 ? '#22c55e' : a.score >= 8 ? '#f59e0b' : '#ea580c';
      html += `
      <div class="review-box">
        <div class="review-box__title"><i class="fas fa-star" style="color:#f59e0b"></i> تقييم سُفرة</div>
        <div class="verdict" style="margin-top:12px">
          <div class="verdict-score"><div class="big">${a.score}</div><div class="small">/10</div></div>
          <div><h4>${esc(a.verdict)}</h4><p>${esc(a.excerpt)}</p></div>
        </div>
      </div>`;
    }

    html += `
      <blockquote>"${esc(a.title)} — خبر طبخ نجح معنا في المطبخ وننصح به لكل محبي ${esc(cat.name)}." — ${esc(a.author)}</blockquote>
      <h2>ملاحظات المحرر</h2>
      <p>احفظ الخبر في مفضلتك وشاركه مع العائلة. جرّب تعديل التوابل تدريجياً حتى تصل للنكهة المثالية لذوقك.</p>`;
    return html;
  }

  function renderCookNews() {
    const id = getParam('id') || 1;
    const a = getCookNews(id);
    const cat = COOK_CATEGORIES[a.cat];
    const el = document.getElementById('cookNewsContent');
    if (!el) return;

    document.title = `${a.title} — سُفرة`;
    const prev = COOK_ARTICLES.find(x => x.id === a.id - 1);
    const next = COOK_ARTICLES.find(x => x.id === a.id + 1);
    const related = getByCat(a.cat, 4).filter(x => x.id !== a.id).slice(0, 3);
    const sidebar = getByCat(a.cat, 4).filter(x => x.id !== a.id).slice(0, 3);

    el.innerHTML = `
      <nav class="breadcrumb"><a href="index.html">الرئيسية</a><span class="sep">›</span><a href="archive.html?cat=${cat.slug}">${esc(cat.name)}</a><span class="sep">›</span><span class="current">${esc(a.title.substring(0, 40))}…</span></nav>
      <div class="article-cats"><a href="archive.html?cat=${cat.slug}" style="background:${cat.color}">${esc(cat.name)}</a></div>
      <h1 class="article-title">${esc(a.title)}</h1>
      <p class="article-subtitle">${esc(a.excerpt)}</p>
      <div class="article-meta">
        <div class="author">
          <img src="https://i.pravatar.cc/80?img=${a.avatar}" alt="${esc(a.author)}">
          <div><strong>${esc(a.author)}</strong><div style="font-size:.72rem;color:#ea580c">شيف — ${esc(cat.name)}</div></div>
        </div>
        <span><i class="fas fa-calendar-alt"></i> ${esc(a.time)}</span>
        <span><i class="far fa-clock"></i> ${esc(a.readTime)}</span>
        <span><i class="far fa-eye"></i> ${esc(a.views)}</span>
        <div class="share">
          <a href="#" class="share-btn share-wa"><i class="fab fa-whatsapp"></i></a>
          <a href="#" class="share-btn share-fb"><i class="fab fa-facebook-f"></i></a>
          <button class="share-btn copy-url" style="background:#444;font-size:11px"><i class="fas fa-link"></i></button>
        </div>
      </div>
      <figure class="article-feat">
        <img src="${a.image.replace('/500/280', '/1200/640').replace('/300/170', '/1200/640').replace('/200/150', '/1200/640').replace('/600/375', '/1200/640')}" alt="${esc(a.title)}">
        <figcaption>${esc(a.title)} — سُفرة</figcaption>
      </figure>
      <div class="entry-content">${buildBody(a)}</div>
      <div class="article-tags"><h4>الوسوم</h4><div class="tags">${COOK_TAGS.slice(0, 4).map(t => `<a href="#" class="tag">${esc(t)}</a>`).join('')}</div></div>
      <div class="author-box">
        <img src="https://i.pravatar.cc/120?img=${a.avatar}" alt="" class="author-box__avatar">
        <div><h3 class="author-box__name">${esc(a.author)}</h3><div class="author-box__role">شيف — سُفرة</div>
        <p class="author-box__bio">محرر ${esc(cat.name)} في سُفرة — يغطي أخبار الطبخ ويشارك تجارب مجربة من المطبخ.</p></div>
      </div>
      <nav class="post-nav">
        ${prev ? `<a href="single.html?id=${prev.id}" class="post-nav__item"><img src="${prev.image}" alt=""><div><div class="post-nav__label"><i class="fas fa-arrow-right"></i> السابق</div><div class="post-nav__title">${esc(prev.title)}</div></div></a>` : '<div></div>'}
        ${next ? `<a href="single.html?id=${next.id}" class="post-nav__item post-nav__item--next"><img src="${next.image}" alt=""><div><div class="post-nav__label">التالي <i class="fas fa-arrow-left"></i></div><div class="post-nav__title">${esc(next.title)}</div></div></a>` : ''}
      </nav>
      <section class="related">
        <h3 class="section-title">أخبار طبخ <span>ذات صلة</span></h3>
        <div class="grid g3" style="margin-top:20px">${related.map(r => {
          const rc = COOK_CATEGORIES[r.cat];
          return `<article class="card"><a href="single.html?id=${r.id}" class="card__thumb"><img src="${r.image}" alt=""><span class="card__cat" style="background:${rc.color}">${esc(rc.name)}</span></a><div class="card__body"><h3 class="card__title"><a href="single.html?id=${r.id}">${esc(r.title)}</a></h3><div class="card__meta"><span>${esc(r.readTime)}</span></div></div></article>`;
        }).join('')}</div>
      </section>`;

    const sidebarEl = document.getElementById('singleSidebar');
    if (sidebarEl) {
      sidebarEl.innerHTML = `<div class="widget"><div class="widget__title">المزيد من أخبار ${esc(cat.name)}</div><div class="widget__body" style="padding:4px 12px">
        ${sidebar.map(r => `<div class="card--list" style="display:flex;gap:10px;padding:10px 0;border-bottom:1px dashed rgba(61,44,30,.1)"><a href="single.html?id=${r.id}" style="width:90px;aspect-ratio:4/3;border-radius:8px;overflow:hidden;flex-shrink:0"><img src="${r.image}" alt="" style="width:100%;height:100%;object-fit:cover"></a><div><h4 style="font-size:.82rem;margin-bottom:4px"><a href="single.html?id=${r.id}">${esc(r.title)}</a></h4><span style="font-size:.72rem;color:#7a6558">${esc(r.readTime)}</span></div></div>`).join('')}
      </div></div>`;
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    initCommon({ fullHeader: false });
    renderCookNews();
  });
})();
