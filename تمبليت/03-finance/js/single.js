/* مال+ — Single article page */
(function () {
  'use strict';

  const { esc, getArticle, getByCat, initCommon } = FinanceShared;

  function getParam(name) {
    return new URLSearchParams(window.location.search).get(name);
  }

  function buildBody(a) {
    const cat = FIN_CATEGORIES[a.cat];
    let html = `
      <p>${esc(a.excerpt)}</p>
      <p>في تقرير من <strong>مال+</strong>، نرصد تطورات مهمة في قطاع <strong>${esc(cat.name)}</strong> وتأثيرها على المستثمرين والاقتصاد العربي والعالمي. ${esc(a.author)} يحلّل السياق الاقتصادي وراء هذا الخبر.</p>
      <div class="info-box">
        <strong><i class="fas fa-info-circle"></i> ملخص سريع</strong>
        <p>${esc(a.excerpt)} — تقرير يغطي الأرقام الرئيسية والتداعيات على المحافظ الاستثمارية.</p>
      </div>
      <h2>ما الذي يحدث؟</h2>
      <p>البيانات الأخيرة تشير إلى تحولات ملحوظة في ${esc(cat.name)}، مع تفاعل سريع من الأسواق والمؤسسات المالية. المحللون يراقبون عن كثب مؤشرات السيولة والتضخم والسياسات النقدية.</p>
      <p>من المتوقع أن تستمر هذه التطورات في التأثير على قرارات الاستثمار خلال الأسابيع القادمة، خاصة في ظل تقلبات العملات وأسعار السلع.</p>`;

    if (a.score) {
      const scoreColor = a.score >= 9 ? '#22c55e' : a.score >= 8 ? '#eab308' : '#16a34a';
      html += `
      <div class="review-box">
        <div class="review-box__title"><i class="fas fa-chart-pie" style="color:#22c55e"></i> تقييم مال+</div>
        <div class="verdict" style="margin-top:12px">
          <div class="verdict-score"><div class="big">${a.score}</div><div class="small">/10</div></div>
          <div><h4>${esc(a.verdict)} — تحليل المحرر</h4><p>${esc(a.excerpt)}</p></div>
        </div>
      </div>`;
    }

    html += `
      <h2>الآثار على الأسواق</h2>
      <ul>
        <li>تأثير واضح على قرارات الاستثمار المحلية والإقليمية</li>
        <li>تغيرات محتملة في أسعار الفائدة والسندات</li>
        <li>إعادة توزيع تدفقات رأس المال بين القطاعات</li>
        <li>فرص وتحديات للمستثمرين على المدى القصير والمتوسط</li>
      </ul>
      <blockquote>"${esc(a.title)} — خبر مالي يستحق المتابعة لكل مهتم بـ ${esc(cat.name)}." — ${esc(a.author)}</blockquote>
      <h2>الخلاصة</h2>
      <p>نوصي بمتابعة التحديثات القادمة والبيانات الرسمية. ${esc(a.author)} يؤكد أن فهم السياق الكلي أهم من ردود الفعل العاطفية في الأسواق.</p>`;
    return html;
  }

  function renderArticle() {
    const id = getParam('id') || 1;
    const a = getArticle(id);
    const cat = FIN_CATEGORIES[a.cat];
    const el = document.getElementById('articleContent');
    if (!el) return;

    document.title = `${a.title} — مال+`;
    const prev = FIN_ARTICLES.find(x => x.id === a.id - 1);
    const next = FIN_ARTICLES.find(x => x.id === a.id + 1);
    const related = getByCat(a.cat, 4).filter(x => x.id !== a.id).slice(0, 3);
    const sidebar = getByCat(a.cat, 4).filter(x => x.id !== a.id).slice(0, 3);

    el.innerHTML = `
      <nav class="breadcrumb"><a href="index.html">الرئيسية</a><span class="sep">›</span><a href="archive.html?cat=${cat.slug}">${esc(cat.name)}</a><span class="sep">›</span><span class="current">${esc(a.title.substring(0, 40))}…</span></nav>
      <div class="article-cats"><a href="archive.html?cat=${cat.slug}" style="background:${cat.color};color:#fff">${esc(cat.name)}</a>${a.score ? '<a href="archive.html?cat=analysis" style="background:#eab308;color:#422006">تحليل</a>' : ''}</div>
      <h1 class="article-title">${esc(a.title)}</h1>
      <p class="article-subtitle">${esc(a.excerpt)}</p>
      <div class="article-meta">
        <div class="author">
          <img src="https://i.pravatar.cc/80?img=${a.avatar}" alt="${esc(a.author)}">
          <div><strong>${esc(a.author)}</strong><div style="font-size:.72rem;color:#22c55e">محرر — ${esc(cat.name)}</div></div>
        </div>
        <span><i class="fas fa-calendar-alt"></i> ${esc(a.time)}</span>
        <span><i class="far fa-clock"></i> ${esc(a.readTime)}</span>
        <span><i class="far fa-eye"></i> ${esc(a.views)}</span>
        <div class="share">
          <a href="#" class="share-btn share-wa"><i class="fab fa-whatsapp"></i></a>
          <a href="#" class="share-btn share-li"><i class="fab fa-linkedin-in"></i></a>
          <button class="share-btn copy-url" style="background:#444;font-size:11px"><i class="fas fa-link"></i></button>
        </div>
      </div>
      <figure class="article-feat">
        <img src="${a.image.replace('/500/280', '/1200/640').replace('/300/170', '/1200/640').replace('/200/150', '/1200/640').replace('/600/375', '/1200/640')}" alt="${esc(a.title)}">
        <figcaption>${esc(a.title)} — مال+</figcaption>
      </figure>
      <div class="entry-content">${buildBody(a)}</div>
      <div class="article-tags"><h4>الوسوم</h4><div class="tags">${FIN_TAGS.slice(0, 4).map(t => `<a href="#" class="tag">${esc(t)}</a>`).join('')}</div></div>
      <div class="author-box">
        <img src="https://i.pravatar.cc/120?img=${a.avatar}" alt="" class="author-box__avatar">
        <div><h3 class="author-box__name">${esc(a.author)}</h3><div class="author-box__role">محرر مالي — مال+</div>
        <p class="author-box__bio">يغطي ${esc(a.author)} أخبار ${esc(cat.name)} ويقدّم تحليلات للمستثمرين العرب منذ سنوات.</p></div>
      </div>
      <nav class="post-nav">
        ${prev ? `<a href="single.html?id=${prev.id}" class="post-nav__item"><img src="${prev.image}" alt=""><div><div class="post-nav__label"><i class="fas fa-arrow-right"></i> السابق</div><div class="post-nav__title">${esc(prev.title)}</div></div></a>` : '<div></div>'}
        ${next ? `<a href="single.html?id=${next.id}" class="post-nav__item post-nav__item--next"><img src="${next.image}" alt=""><div><div class="post-nav__label">التالي <i class="fas fa-arrow-left"></i></div><div class="post-nav__title">${esc(next.title)}</div></div></a>` : ''}
      </nav>
      <section class="related">
        <h3 class="section-title">أخبار <span>ذات صلة</span></h3>
        <div class="grid g3" style="margin-top:20px">${related.map(r => {
          const rc = FIN_CATEGORIES[r.cat];
          return `<article class="card"><a href="single.html?id=${r.id}" class="card__thumb"><img src="${r.image}" alt=""><span class="card__cat" style="background:${rc.color};color:#fff">${esc(rc.name)}</span></a><div class="card__body"><h3 class="card__title"><a href="single.html?id=${r.id}">${esc(r.title)}</a></h3><div class="card__meta"><span>${esc(r.readTime)}</span></div></div></article>`;
        }).join('')}</div>
      </section>`;

    const sidebarEl = document.getElementById('singleSidebar');
    if (sidebarEl) {
      sidebarEl.innerHTML = `<div class="widget"><div class="widget__title">المزيد من ${esc(cat.name)}</div><div class="widget__body" style="padding:4px 12px">
        ${sidebar.map(r => `<div style="display:flex;gap:10px;padding:10px 0;border-bottom:1px dashed var(--fin-border)"><a href="single.html?id=${r.id}" style="width:90px;aspect-ratio:4/3;border-radius:6px;overflow:hidden;flex-shrink:0"><img src="${r.image}" alt="" style="width:100%;height:100%;object-fit:cover"></a><div><h4 style="font-size:.82rem;margin-bottom:4px"><a href="single.html?id=${r.id}">${esc(r.title)}</a></h4><span style="font-size:.72rem;color:var(--text-muted)">${esc(r.readTime)}</span></div></div>`).join('')}
      </div></div>`;
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    initCommon({ fullHeader: false });
    renderArticle();
  });
})();
