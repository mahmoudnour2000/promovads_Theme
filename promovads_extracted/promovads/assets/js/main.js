/**
 * PromovaDS News - Main JavaScript
 * @package PromovaDS_News
 */

(function () {
  'use strict';

  // ── Utility ────────────────────────────────────────────────────────────────
  const $ = (sel, ctx = document) => ctx.querySelector(sel);
  const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];
  const on = (el, ev, fn, opts) => el && el.addEventListener(ev, fn, opts);
  const off = (el, ev, fn) => el && el.removeEventListener(ev, fn);

  function debounce(fn, ms = 300) {
    let t;
    return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); };
  }

  // ── Dark Mode ──────────────────────────────────────────────────────────────
  const DarkMode = {
    key: 'pds-dark-mode',

    init() {
      const stored = localStorage.getItem(this.key);
      const defaultDark = document.documentElement.dataset.darkDefault === '1';
      const isDark = stored !== null ? stored === '1' : defaultDark;

      if (isDark) document.body.classList.add('dark-mode');
      this.updateIcon(isDark);

      on($('.pds-dark-mode-btn'), 'click', () => this.toggle());
    },

    toggle() {
      const isDark = document.body.classList.toggle('dark-mode');
      localStorage.setItem(this.key, isDark ? '1' : '0');
      this.updateIcon(isDark);
    },

    updateIcon(isDark) {
      const btn = $('.pds-dark-mode-btn');
      if (!btn) return;
      const icon = btn.querySelector('i');
      if (icon) {
        icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
      }
    }
  };

  // ── Sticky Header ──────────────────────────────────────────────────────────
  const StickyHeader = {
    header: null,
    lastY: 0,

    init() {
      this.header = $('#masthead');
      if (!this.header) return;
      on(window, 'scroll', () => this.onScroll(), { passive: true });
    },

    onScroll() {
      const y = window.scrollY;
      this.header.classList.toggle('is-scrolled', y > 50);
      this.lastY = y;
    }
  };

  // ── Mobile Menu ────────────────────────────────────────────────────────────
  const MobileMenu = {
    toggle: null,
    nav: null,

    init() {
      this.toggle = $('#pds-menu-toggle');
      this.nav    = $('#pds-primary-nav');
      if (!this.toggle || !this.nav) return;

      on(this.toggle, 'click', () => this.toggleMenu());
      on(document, 'keydown', e => { if (e.key === 'Escape') this.close(); });
      on(document, 'click', e => {
        if (!this.nav.contains(e.target) && !this.toggle.contains(e.target)) {
          this.close();
        }
      });
    },

    toggleMenu() {
      const open = this.nav.classList.toggle('is-open');
      this.toggle.setAttribute('aria-expanded', String(open));
      document.body.style.overflow = open ? 'hidden' : '';
    },

    close() {
      this.nav.classList.remove('is-open');
      this.toggle.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    }
  };

  // ── Breaking News Ticker ────────────────────────────────────────────────────
  const Ticker = {
    init() {
      const inner  = $('#pds-ticker-inner');
      const pause  = $('.pds-ticker__pause');
      const play   = $('.pds-ticker__play');

      if (!inner) return;

      let paused = false;

      on(pause, 'click', () => {
        inner.style.animationPlayState = 'paused';
        paused = true;
        pause.classList.add('pds-hidden');
        play.classList.remove('pds-hidden');
      });

      on(play, 'click', () => {
        inner.style.animationPlayState = 'running';
        paused = false;
        play.classList.add('pds-hidden');
        pause.classList.remove('pds-hidden');
      });
    }
  };

  // ── Ajax Search ────────────────────────────────────────────────────────────
  const Search = {
    overlay: null,
    input: null,
    results: null,
    controller: null,

    init() {
      this.overlay = $('#pds-search-overlay');
      this.input   = $('#pds-search-input');
      this.results = $('#pds-search-results');

      if (!this.overlay) return;

      $$('.pds-search-trigger').forEach(btn => {
        on(btn, 'click', () => this.open());
      });

      on($('.pds-search-overlay__close'), 'click', () => this.close());

      on(document, 'keydown', e => {
        if (e.key === 'Escape') this.close();
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
          e.preventDefault();
          this.open();
        }
      });

      on(this.overlay, 'click', e => {
        if (e.target === this.overlay) this.close();
      });

      on(this.input, 'input', debounce(() => this.query(this.input.value), 300));
    },

    open() {
      this.overlay.classList.add('is-open');
      document.body.style.overflow = 'hidden';
      setTimeout(() => this.input?.focus(), 100);
    },

    close() {
      this.overlay.classList.remove('is-open');
      document.body.style.overflow = '';
      if (this.input) this.input.value = '';
      if (this.results) this.results.innerHTML = '';
    },

    async query(q) {
      if (!q || q.length < 2) {
        this.results.innerHTML = '';
        return;
      }

      if (this.controller) this.controller.abort();
      this.controller = new AbortController();

      this.results.innerHTML = '<div class="pds-search-loading" style="padding:1rem;text-align:center"><i class="fas fa-spinner fa-spin"></i></div>';

      const body = new FormData();
      body.append('action', 'promovads_search');
      body.append('nonce', promovaDS.nonce);
      body.append('query', q);

      try {
        const res  = await fetch(promovaDS.ajaxUrl, { method: 'POST', body, signal: this.controller.signal });
        const data = await res.json();

        if (!data.success || !data.data.results.length) {
          this.results.innerHTML = `<div style="padding:1rem;text-align:center;color:#999">${promovaDS.i18n.noResults}</div>`;
          return;
        }

        this.results.innerHTML = data.data.results.map(p => `
          <a href="${p.url}" class="pds-search-result-item">
            ${p.thumbnail ? `<img src="${p.thumbnail}" alt="${p.title}" loading="lazy">` : ''}
            <div>
              <h4>${p.title}</h4>
              <span>${p.category} · ${p.date}</span>
            </div>
          </a>
        `).join('');
      } catch (e) {
        if (e.name !== 'AbortError') {
          this.results.innerHTML = '';
        }
      }
    }
  };

  // ── Category Tabs ──────────────────────────────────────────────────────────
  const CategoryTabs = {
    init() {
      const nav = $('.pds-tabs__nav');
      if (!nav) return;

      on(nav, 'click', async e => {
        const btn = e.target.closest('.pds-tabs__btn');
        if (!btn) return;

        $$('.pds-tabs__btn', nav).forEach(b => {
          b.classList.remove('is-active');
          b.setAttribute('aria-selected', 'false');
        });
        btn.classList.add('is-active');
        btn.setAttribute('aria-selected', 'true');

        const cat = btn.dataset.cat;
        if (!cat) return; // Latest tab

        const panel = $('#tab-dynamic');
        if (!panel) return;

        $$('.pds-tabs__panel').forEach(p => p.classList.remove('is-active'));
        panel.classList.add('is-active');
        panel.innerHTML = '<div style="text-align:center;padding:2rem"><i class="fas fa-spinner fa-spin fa-2x"></i></div>';

        const body = new FormData();
        body.append('action', 'promovads_load_more');
        body.append('nonce', promovaDS.nonce);
        body.append('page', '1');
        body.append('per_page', '6');
        body.append('cat', cat);

        try {
          const res  = await fetch(promovaDS.ajaxUrl, { method: 'POST', body });
          const data = await res.json();
          if (data.success) {
            panel.innerHTML = `<div class="pds-grid pds-grid--3">${data.data.html}</div>`;
          }
        } catch (_) {
          panel.innerHTML = '';
        }
      });
    }
  };

  // ── Load More Posts ────────────────────────────────────────────────────────
  const LoadMore = {
    init() {
      on(document, 'click', async e => {
        const btn = e.target.closest('.pds-load-more');
        if (!btn) return;

        const page    = parseInt(btn.dataset.page, 10) + 1;
        const max     = parseInt(btn.dataset.max, 10);
        const cat     = btn.dataset.cat || '0';
        const grid    = btn.closest('.pds-tabs__panel')?.querySelector('.pds-grid') || $('#pds-posts-grid');

        if (!grid) return;

        btn.disabled = true;
        btn.classList.add('is-loading');

        const body = new FormData();
        body.append('action', 'promovads_load_more');
        body.append('nonce', promovaDS.nonce);
        body.append('page', page);
        body.append('per_page', '6');
        body.append('cat', cat);

        try {
          const res  = await fetch(promovaDS.ajaxUrl, { method: 'POST', body });
          const data = await res.json();

          if (data.success && data.data.html) {
            grid.insertAdjacentHTML('beforeend', data.data.html);
            btn.dataset.page = page;

            if (!data.data.has_more) {
              btn.parentElement.remove();
            }
          }
        } catch (_) {}

        btn.disabled = false;
        btn.classList.remove('is-loading');
      });
    }
  };

  // ── Newsletter Forms ────────────────────────────────────────────────────────
  const Newsletter = {
    init() {
      on(document, 'submit', async e => {
        const form = e.target.closest('.pds-newsletter-form');
        if (!form) return;
        e.preventDefault();

        const email = form.querySelector('[name="email"]')?.value;
        const btn   = form.querySelector('button[type="submit"]');

        if (!email) return;

        if (btn) { btn.disabled = true; btn.textContent = promovaDS.i18n.loading; }

        const body = new FormData();
        body.append('action', 'promovads_newsletter');
        body.append('nonce', promovaDS.nonce);
        body.append('email', email);

        try {
          const res  = await fetch(promovaDS.ajaxUrl, { method: 'POST', body });
          const data = await res.json();

          const msg = form.querySelector('.pds-nl-message') || Object.assign(document.createElement('p'), { className: 'pds-nl-message' });
          msg.textContent = data.success ? data.data.message : data.data.message;
          msg.style.color = data.success ? '#22c55e' : '#ef4444';
          form.appendChild(msg);

          if (data.success) form.reset();
        } catch (_) {}

        if (btn) btn.disabled = false;
      });
    }
  };

  // ── Copy URL ────────────────────────────────────────────────────────────────
  const CopyUrl = {
    init() {
      on(document, 'click', async e => {
        const btn = e.target.closest('.pds-copy-url');
        if (!btn) return;

        const url = btn.dataset.url || location.href;

        try {
          await navigator.clipboard.writeText(url);
          const icon = btn.querySelector('i');
          if (icon) { icon.className = 'fas fa-check'; setTimeout(() => (icon.className = 'fas fa-link'), 2000); }
        } catch (_) {}
      });
    }
  };

  // ── Lazy Images ────────────────────────────────────────────────────────────
  const LazyLoad = {
    init() {
      if ('loading' in HTMLImageElement.prototype) return; // native support

      const imgs = $$('img[loading="lazy"]');
      const io = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            if (img.dataset.src) img.src = img.dataset.src;
            io.unobserve(img);
          }
        });
      });

      imgs.forEach(img => io.observe(img));
    }
  };

  // ── Back to Top ────────────────────────────────────────────────────────────
  const BackToTop = {
    btn: null,

    init() {
      this.btn = Object.assign(document.createElement('button'), {
        className:   'pds-back-top',
        innerHTML:   '<i class="fas fa-chevron-up" aria-hidden="true"></i>',
        ariaLabel:   'Back to top',
      });
      this.btn.style.cssText = [
        'position:fixed', 'bottom:2rem', promovaDS.isRtl ? 'left:2rem' : 'right:2rem',
        'width:44px', 'height:44px', 'background:var(--color-primary)',
        'color:#fff', 'border-radius:50%', 'display:none',
        'align-items:center', 'justify-content:center',
        'cursor:pointer', 'z-index:199', 'transition:opacity .2s',
        'border:none', 'box-shadow:0 4px 12px rgba(0,0,0,.2)',
      ].join(';');

      document.body.appendChild(this.btn);

      on(window, 'scroll', debounce(() => {
        this.btn.style.display = window.scrollY > 400 ? 'flex' : 'none';
      }, 100), { passive: true });

      on(this.btn, 'click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }
  };

  // ── Track Post Views ────────────────────────────────────────────────────────
  const ViewTracker = {
    init() {
      const postId = document.body.dataset.postId;
      if (!postId || !document.body.classList.contains('single')) return;

      setTimeout(() => {
        const body = new FormData();
        body.append('action', 'promovads_track_view');
        body.append('post_id', postId);
        fetch(promovaDS.ajaxUrl, { method: 'POST', body }).catch(() => {});
      }, 3000);
    }
  };

  // ── Reading Progress Bar ────────────────────────────────────────────────────
  const ProgressBar = {
    bar: null,

    init() {
      if (!document.body.classList.contains('single')) return;

      this.bar = Object.assign(document.createElement('div'), { className: 'pds-progress' });
      this.bar.style.cssText = 'position:fixed;top:0;left:0;height:3px;background:var(--color-primary);width:0%;z-index:9999;transition:width .1s;';
      document.body.prepend(this.bar);

      on(window, 'scroll', () => this.update(), { passive: true });
    },

    update() {
      const el  = document.querySelector('.entry-content');
      if (!el) return;
      const scrollTop = window.scrollY;
      const docH = document.documentElement.scrollHeight - window.innerHeight;
      const pct  = docH > 0 ? Math.min(100, (scrollTop / docH) * 100) : 0;
      this.bar.style.width = pct + '%';
    }
  };

  // ── Init All ────────────────────────────────────────────────────────────────
  document.addEventListener('DOMContentLoaded', () => {
    document.body.classList.remove('pds-preload');

    DarkMode.init();
    StickyHeader.init();
    MobileMenu.init();
    Ticker.init();
    Search.init();
    CategoryTabs.init();
    LoadMore.init();
    Newsletter.init();
    CopyUrl.init();
    LazyLoad.init();
    BackToTop.init();
    ViewTracker.init();
    ProgressBar.init();
  });

})();
