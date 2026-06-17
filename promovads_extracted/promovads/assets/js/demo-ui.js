/**
 * Demo UI — search, share copy, back-to-top, ticker, progress.
 */
(function () {
  'use strict';

  var ds = window.promovaDS || {};

  function debounce(fn, ms) {
    var t;
    return function () {
      var args = arguments;
      clearTimeout(t);
      t = setTimeout(function () { fn.apply(null, args); }, ms);
    };
  }

  function toast(msg) {
    var el = document.getElementById('pds-toast');
    if (!el) {
      el = document.createElement('div');
      el.id = 'pds-toast';
      el.className = 'pds-toast';
      el.setAttribute('role', 'status');
      el.setAttribute('aria-live', 'polite');
      document.body.appendChild(el);
    }
    el.textContent = msg;
    el.classList.add('is-visible');
    clearTimeout(el._t);
    el._t = setTimeout(function () { el.classList.remove('is-visible'); }, 2200);
  }

  function copyText(text) {
    if (navigator.clipboard && window.isSecureContext) {
      return navigator.clipboard.writeText(text);
    }
    return new Promise(function (resolve, reject) {
      var ta = document.createElement('textarea');
      ta.value = text;
      ta.style.cssText = 'position:fixed;left:-9999px;top:0;opacity:0';
      document.body.appendChild(ta);
      ta.focus();
      ta.select();
      try {
        document.execCommand('copy') ? resolve() : reject();
      } catch (err) {
        reject(err);
      }
      document.body.removeChild(ta);
    });
  }

  var overlay = document.getElementById('searchOverlay') || document.getElementById('pds-search-overlay');
  var triggers = document.querySelectorAll('.pds-search-trigger, .search-trigger');
  var closeBtn = overlay && overlay.querySelector('.search-close, .pds-search-overlay__close');
  var searchForm = overlay && overlay.querySelector('form[role="search"]');
  var searchInput = document.getElementById('pds-search-input-demo') || document.getElementById('pds-search-input');
  var resultsEl = document.getElementById('searchPreview') || document.getElementById('pds-search-results');
  var searchBox = overlay && overlay.querySelector('.search-box, .pds-search-overlay__box');
  var searchController = null;

  function openSearch() {
    if (!overlay) return;
    overlay.classList.add('is-open', 'active');
    overlay.style.display = 'flex';
    overlay.setAttribute('aria-hidden', 'false');
    if (searchInput) {
      setTimeout(function () { searchInput.focus(); }, 80);
    }
  }

  function closeSearch() {
    if (!overlay) return;
    overlay.classList.remove('is-open', 'active');
    overlay.style.display = '';
    overlay.setAttribute('aria-hidden', 'true');
    if (searchInput) searchInput.value = '';
    if (resultsEl) resultsEl.innerHTML = '';
  }

  triggers.forEach(function (el) {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      openSearch();
    });
    el.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        openSearch();
      }
    });
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', function (e) {
      e.preventDefault();
      closeSearch();
    });
  }

  if (overlay) {
    overlay.addEventListener('click', function (e) {
      if (e.target === overlay) closeSearch();
    });
  }

  if (searchBox) {
    searchBox.addEventListener('click', function (e) {
      e.stopPropagation();
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeSearch();
    if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
      e.preventDefault();
      openSearch();
    }
  });

  function renderResults(items) {
    if (!resultsEl) return;
    if (!items.length) {
      resultsEl.innerHTML = '<div class="search-result search-result--empty">' +
        (ds.i18n && ds.i18n.noResults ? ds.i18n.noResults : 'لا توجد نتائج.') +
        '</div>';
      return;
    }
    resultsEl.innerHTML = items.map(function (p) {
      return '<a href="' + p.url + '" class="search-result">' +
        (p.thumbnail ? '<img src="' + p.thumbnail + '" alt="" loading="lazy">' : '') +
        '<div><h4>' + p.title + '</h4><span>' + p.category + ' · ' + p.date + '</span></div></a>';
    }).join('');
  }

  function runSearch(q) {
    if (!resultsEl || !ds.ajaxUrl) return;

    if (!q || q.length < 2) {
      resultsEl.innerHTML = '';
      return;
    }

    if (searchController) searchController.abort();
    searchController = new AbortController();

    resultsEl.innerHTML = '<div class="search-result search-result--empty"><i class="fas fa-spinner fa-spin"></i></div>';

    var body = new FormData();
    body.append('action', 'promovads_search');
    body.append('nonce', ds.nonce || '');
    body.append('query', q);

    fetch(ds.ajaxUrl, { method: 'POST', body: body, signal: searchController.signal })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (!data.success || !data.data || !data.data.results) {
          renderResults([]);
          return;
        }
        renderResults(data.data.results);
      })
      .catch(function (err) {
        if (err.name !== 'AbortError' && resultsEl) resultsEl.innerHTML = '';
      });
  }

  if (searchInput) {
    searchInput.addEventListener('input', debounce(function () {
      runSearch(searchInput.value.trim());
    }, 300));

    searchInput.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        var q = searchInput.value.trim();
        if (!q) {
          e.preventDefault();
          return;
        }
        if (resultsEl && resultsEl.querySelector('.search-result:not(.search-result--empty)')) {
          return;
        }
        e.preventDefault();
        window.location.href = (ds.homeUrl || '/') + '?s=' + encodeURIComponent(q);
      }
    });
  }

  if (searchForm) {
    searchForm.addEventListener('submit', function (e) {
      var q = searchInput ? searchInput.value.trim() : '';
      if (!q) {
        e.preventDefault();
        if (searchInput) searchInput.focus();
      }
    });
  }

  document.addEventListener('click', function (e) {
    var copyBtn = e.target.closest('.pds-copy-url');
    if (!copyBtn) return;
    e.preventDefault();
    var url = copyBtn.getAttribute('data-url') || window.location.href;
    copyText(url).then(function () {
      toast((ds.i18n && ds.i18n.copied) || 'تم نسخ الرابط');
      var icon = copyBtn.querySelector('i');
      if (icon) {
        var prev = icon.className;
        icon.className = 'fas fa-check';
        setTimeout(function () { icon.className = prev; }, 2000);
      }
    }).catch(function () {
      toast((ds.i18n && ds.i18n.copyFailed) || 'تعذّر نسخ الرابط');
    });
  });

  var backTop = document.getElementById('backTop');
  if (backTop) {
    window.addEventListener('scroll', function () {
      backTop.classList.toggle('visible', window.scrollY > 400);
    }, { passive: true });
    backTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  var pauseBtn = document.querySelector('.ticker__pause');
  var tickerInner = document.getElementById('tickerInner');
  if (pauseBtn && tickerInner) {
    pauseBtn.addEventListener('click', function () {
      var paused = tickerInner.style.animationPlayState === 'paused';
      tickerInner.style.animationPlayState = paused ? 'running' : 'paused';
      pauseBtn.innerHTML = paused ? '<i class="fas fa-pause"></i>' : '<i class="fas fa-play"></i>';
    });
  }

  var bar = document.getElementById('progress');
  if (bar) {
    window.addEventListener('scroll', function () {
      var h = document.documentElement.scrollHeight - window.innerHeight;
      bar.style.width = h > 0 ? ((window.scrollY / h) * 100) + '%' : '0';
    }, { passive: true });
  }

  if (overlay) {
    overlay.setAttribute('aria-hidden', 'true');
  }
})();
