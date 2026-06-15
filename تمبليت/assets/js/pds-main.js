/* PromovaDS News — Shared Frontend JS */
(function(){
  'use strict';

  // Dark Mode
  const darkBtn = document.querySelector('.dark-toggle');
  const prefersDark = localStorage.getItem('pds-dark') === '1';
  if (prefersDark || document.body.dataset.darkDefault) document.body.classList.add('dark');
  darkBtn?.addEventListener('click', () => {
    document.body.classList.toggle('dark');
    localStorage.setItem('pds-dark', document.body.classList.contains('dark') ? '1' : '0');
    darkBtn.querySelector('i')?.classList.toggle('fa-moon');
    darkBtn.querySelector('i')?.classList.toggle('fa-sun');
  });

  // Sticky Header
  const header = document.querySelector('.site-header');
  window.addEventListener('scroll', () => header?.classList.toggle('scrolled', scrollY > 60), {passive:true});

  // Search Overlay
  const overlay = document.querySelector('.search-overlay');
  document.querySelectorAll('.search-trigger').forEach(b => b.addEventListener('click', () => overlay?.classList.add('open')));
  document.querySelector('.search-close')?.addEventListener('click', () => overlay?.classList.remove('open'));
  overlay?.addEventListener('click', e => { if(e.target===overlay) overlay.classList.remove('open'); });
  document.addEventListener('keydown', e => { if(e.key==='Escape') overlay?.classList.remove('open'); });

  // Back to Top
  const top = document.querySelector('.back-top');
  window.addEventListener('scroll', () => top?.classList.toggle('show', scrollY > 400), {passive:true});
  top?.addEventListener('click', () => window.scrollTo({top:0,behavior:'smooth'}));

  // Progress Bar
  const bar = document.querySelector('.progress-bar');
  if(bar) window.addEventListener('scroll', () => {
    const pct = scrollY / (document.documentElement.scrollHeight - innerHeight) * 100;
    bar.style.width = Math.min(pct, 100) + '%';
  }, {passive:true});

  // Ticker pause
  const ticker = document.querySelector('.ticker__inner');
  document.querySelector('.ticker__pause')?.addEventListener('click', () => {
    ticker && (ticker.style.animationPlayState = 'paused');
  });
  document.querySelector('.ticker__play')?.addEventListener('click', () => {
    ticker && (ticker.style.animationPlayState = 'running');
  });

  // Tabs
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const target = btn.dataset.tab;
      btn.closest('.tabs').querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      btn.closest('.tabs').querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
      btn.classList.add('active');
      document.getElementById(target)?.classList.add('active');
    });
  });

  // Mobile Menu
  document.querySelector('.menu-toggle')?.addEventListener('click', () => {
    document.querySelector('.site-nav')?.classList.toggle('open');
  });

  // Copy URL
  document.querySelectorAll('.copy-url').forEach(btn => {
    btn.addEventListener('click', async () => {
      await navigator.clipboard.writeText(location.href).catch(()=>{});
      btn.querySelector('i')?.setAttribute('class','fas fa-check');
      setTimeout(() => btn.querySelector('i')?.setAttribute('class','fas fa-link'), 1500);
    });
  });

  // Lazy Load fallback
  if(!('loading' in HTMLImageElement.prototype)){
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => { if(e.isIntersecting){ e.target.src = e.target.dataset.src; io.unobserve(e.target); } });
    });
    document.querySelectorAll('img[data-src]').forEach(img => io.observe(img));
  }

})();
