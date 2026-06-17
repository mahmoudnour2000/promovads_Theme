(function ($) {
  'use strict';

  var frames = {};

  function openMedia(target, previewId) {
    if (frames[target]) {
      frames[target].open();
      return;
    }
    frames[target] = wp.media({
      title: 'اختر الشعار',
      button: { text: 'استخدام هذه الصورة' },
      multiple: false
    });
    frames[target].on('select', function () {
      var attachment = frames[target].state().get('selection').first().toJSON();
      $('#pds_logo_' + target).val(attachment.id);
      var $preview = $('#preview-' + target);
      if ($preview.length) {
        $preview.html('<img src="' + attachment.url + '" alt="">');
      }
      syncLogoLivePreview();
    });
    frames[target].open();
  }

  $(document).on('click', '.pds-logo-upload', function (e) {
    e.preventDefault();
    openMedia($(this).data('target'));
  });

  $(document).on('click', '.pds-logo-remove', function (e) {
    e.preventDefault();
    var target = $(this).data('target');
    $('#pds_logo_' + target).val('');
    $('#preview-' + target).html('<span>لا توجد صورة</span>');
    syncLogoLivePreview();
  });

  function syncLogoLivePreview() {
    var headerId = $('#pds_logo_header_logo_id').val();
    var footerSame = $('#pds_logo_footer_use_same').is(':checked');
    var mobileSame = $('#pds_logo_mobile_use_same').is(':checked');
    var footerId = footerSame ? headerId : ($('#pds_logo_footer_logo_id').val() || headerId);
    var mobileId = mobileSame ? headerId : ($('#pds_logo_mobile_logo_id').val() || headerId);

    setPreviewImg('#pds-lp-header-img', '#pds-lp-header-ph', headerId);
    setPreviewImg('#pds-lp-footer-img', '#pds-lp-footer-ph', footerId);
    setPreviewImg('#pds-lp-mobile-img', '#pds-lp-mobile-ph', mobileId);

    var hh = $('input[name="pds_logo_header_height"]').val() || 52;
    var fh = $('input[name="pds_logo_footer_height"]').val() || 44;
    var mh = $('input[name="pds_logo_mobile_height"]').val() || 40;
    $('.pds-lp-img--header').css('max-height', hh + 'px');
    $('.pds-lp-img--footer').css('max-height', fh + 'px');
    $('.pds-lp-img--mobile').css('max-height', mh + 'px');
  }

  function setPreviewImg(imgSel, phSel, id) {
    var $img = $(imgSel);
    var $ph = $(phSel);
    if (!id) {
      $img.hide().attr('src', '');
      $ph.show();
      return;
    }
    wp.media.attachment(id).fetch().then(function () {
      var url = wp.media.attachment(id).get('url');
      $img.attr('src', url).show();
      $ph.hide();
    });
  }

  function toggleDepends() {
    $('[data-depends]').each(function () {
      var dep = $(this).data('depends');
      if (!dep) return;
      var parts = dep.split(':');
      var field = parts[0];
      var val = parts[1];
      var checked = $('#pds_logo_' + field).is(':checked');
      var show = (val === '0') ? !checked : checked;
      $(this).toggle(show);
    });
  }

  $(document).on('change', '.pds-logo-toggle', function () {
    toggleDepends();
    syncLogoLivePreview();
  });

  $(document).on('input', '.pds-logo-number', syncLogoLivePreview);

  toggleDepends();
  syncLogoLivePreview();

  var previewSite = document.getElementById('pds-preview-site');
  var tokenToPreview = {
    topbar_bg: '--prev-topbar-bg',
    header_bg: '--prev-header-bg',
    bg: '--prev-bg',
    surface: '--prev-surface',
    primary: '--prev-primary',
    secondary: '--prev-secondary',
    text_heading: '--prev-text-heading',
    text_muted: '--prev-text-muted',
    widget_title_bg: '--prev-widget-title-bg',
    widget_title_text: '--prev-widget-title-text',
    btn_bg: '--prev-btn-bg',
    btn_text: '--prev-btn-text',
    footer_bg: '--prev-footer-bg',
    footer_text: '--prev-footer-text',
    border: '--prev-border'
  };

  function syncColorPreview() {
    if (!previewSite) return;
    document.querySelectorAll('.pds-clr-input').forEach(function (input) {
      var key = input.name.replace('pds_clr_', '');
      var cssVar = tokenToPreview[key];
      if (cssVar) {
        previewSite.style.setProperty(cssVar, input.value);
      }
      if (key === 'primary') {
        previewSite.style.setProperty('--prev-btn-bg', input.value);
      }
      if (key === 'secondary') {
        previewSite.style.setProperty('--prev-topbar-bg', input.value);
        previewSite.style.setProperty('--prev-footer-bg', input.value);
        previewSite.style.setProperty('--prev-widget-title-bg', input.value);
      }
    });
  }

  document.querySelectorAll('.pds-clr-input').forEach(function (input) {
    input.addEventListener('input', syncColorPreview);
  });
  syncColorPreview();

  $('.pds-demo-switch, .pds-demo-reinstall').on('click', function (e) {
    var msg = $(this).data('reinstall')
      ? (window.promovadsAdmin && promovadsAdmin.confirmReinstall)
      : (window.promovadsAdmin && promovadsAdmin.confirmSwitch);
    if (msg && !window.confirm(msg)) {
      e.preventDefault();
    }
  });

  $(document).on('change', '.pds-skin-card input[type="radio"]', function () {
    var $card = $(this).closest('.pds-skin-card');
    var $group = $card.closest('.pds-skin-grid');
    var $section = $card.closest('.pds-skin-section');
    var label = $card.data('skin-label') || '';

    $group.find('.pds-skin-card').removeClass('is-selected');
    $card.addClass('is-selected');

    if ($section.length && label) {
      $section.find('[data-active-label] strong').text(label);
    }
  });

  $(document).on('click', '.pds-skin-card', function (e) {
    if ($(e.target).closest('a, button').length) {
      return;
    }
    var $radio = $(this).find('input[type="radio"]');
    if (!$radio.length || $radio.prop('disabled')) {
      return;
    }
    if (!$radio.prop('checked')) {
      $radio.prop('checked', true).trigger('change');
    }
  });

  // Vanilla fallback if jQuery change handler misses.
  document.addEventListener('change', function (e) {
    var input = e.target;
    if (!input.matches || !input.matches('.pds-skin-card input[type="radio"]')) {
      return;
    }
    var card = input.closest('.pds-skin-card');
    var group = input.closest('.pds-skin-grid');
    if (!card || !group) {
      return;
    }
    group.querySelectorAll('.pds-skin-card').forEach(function (el) {
      el.classList.remove('is-selected');
    });
    card.classList.add('is-selected');
    var section = card.closest('.pds-skin-section');
    var label = card.getAttribute('data-skin-label');
    if (section && label) {
      var strong = section.querySelector('[data-active-label] strong');
      if (strong) {
        strong.textContent = label;
      }
    }
  }, true);

  // Smooth scroll for jump nav (respect WP admin bar).
  $(document).on('click', '.pds-skins-jump__link', function (e) {
    var target = $(this).attr('href');
    if (!target || target.charAt(0) !== '#') return;
    var $el = $(target);
    if (!$el.length) return;
    e.preventDefault();
    var offset = 110;
    $('html, body').animate({ scrollTop: $el.offset().top - offset }, 320);
  });
})(jQuery);
