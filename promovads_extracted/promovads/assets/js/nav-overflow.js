/**
 * Nav overflow — move extra categories under «المزيد».
 */
(function () {
  'use strict';

  function initNavOverflow(nav) {
    var list = nav.querySelector('.pds-cat-nav__list');
    var moreWrap = nav.querySelector('[data-nav-more]');
    var moreBtn = moreWrap && moreWrap.querySelector('.pds-cat-nav__more-btn');
    var dropdown = moreWrap && moreWrap.querySelector('.pds-cat-nav__dropdown');
    if (!list || !moreWrap || !moreBtn || !dropdown) return;

    var items = Array.prototype.slice.call(list.querySelectorAll('[data-nav-item]'));
    if (items.length < 2) return;

    function reset() {
      items.forEach(function (item) {
        item.style.display = '';
        if (item.parentNode === dropdown) {
          list.insertBefore(item, moreWrap);
        }
      });
      dropdown.innerHTML = '';
      moreWrap.hidden = true;
      moreBtn.setAttribute('aria-expanded', 'false');
    }

    function layout() {
      reset();

      var available = list.clientWidth - moreWrap.offsetWidth - 8;
      if (available <= 0) return;

      var used = 0;
      var overflow = [];

      items.forEach(function (item) {
        var w = item.offsetWidth;
        if (used + w <= available) {
          used += w;
        } else {
          overflow.push(item);
        }
      });

      if (!overflow.length) return;

      overflow.forEach(function (item) {
        item.style.display = '';
        dropdown.appendChild(item);
      });

      moreWrap.hidden = false;

      var activeInside = dropdown.querySelector('.active');
      if (activeInside) {
        moreWrap.classList.add('active');
      } else {
        moreWrap.classList.remove('active');
      }
    }

    moreBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = moreWrap.classList.toggle('is-open');
      moreBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    document.addEventListener('click', function () {
      moreWrap.classList.remove('is-open');
      moreBtn.setAttribute('aria-expanded', 'false');
    });

    layout();

    if ('ResizeObserver' in window) {
      new ResizeObserver(layout).observe(list);
    } else {
      window.addEventListener('resize', layout);
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-nav-overflow]').forEach(initNavOverflow);
  });
})();
