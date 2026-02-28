(function () {
  const prefersReducedMotion =
    typeof window.matchMedia === 'function' &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function stopTransition(panel) {
    panel.style.transition = 'none';
    // Force style flush so next transition applies reliably.
    void panel.offsetHeight;
  }

  function initializePanel(item) {
    const panel = item.querySelector('.da-panel');
    if (!panel) {
      return;
    }

    const isOpen = item.classList.contains('is-open');
    panel.style.overflow = 'hidden';

    if (isOpen) {
      panel.hidden = false;
      panel.style.opacity = '1';
      panel.style.height = 'auto';
      panel.style.overflow = 'visible';
    } else {
      panel.hidden = true;
      panel.style.opacity = '0';
      panel.style.height = '0px';
    }
  }

  function animatePanel(panel, isOpen) {
    if (prefersReducedMotion) {
      panel.hidden = !isOpen;
      panel.style.transition = '';
      panel.style.height = isOpen ? 'auto' : '0px';
      panel.style.opacity = isOpen ? '1' : '0';
      panel.style.overflow = isOpen ? 'visible' : 'hidden';
      return;
    }

    const token = String((Number(panel.dataset.daAnimToken || '0') + 1));
    panel.dataset.daAnimToken = token;

    stopTransition(panel);

    if (isOpen) {
      panel.hidden = false;
      panel.style.overflow = 'hidden';
      panel.style.height = '0px';
      panel.style.opacity = '0';

      requestAnimationFrame(function () {
        const endHeight = panel.scrollHeight;
        panel.style.transition = 'height 340ms cubic-bezier(0.22, 1, 0.36, 1), opacity 320ms ease';
        panel.style.height = endHeight + 'px';
        panel.style.opacity = '1';
      });

      panel.addEventListener(
        'transitionend',
        function onOpenEnd(event) {
          if (event.propertyName !== 'height' || panel.dataset.daAnimToken !== token) {
            return;
          }
          panel.style.transition = '';
          panel.style.height = 'auto';
          panel.style.opacity = '1';
          panel.style.overflow = 'visible';
        },
        { once: true }
      );
      return;
    }

    panel.hidden = false;
    panel.style.overflow = 'hidden';
    panel.style.height = panel.scrollHeight + 'px';
    panel.style.opacity = '1';

    requestAnimationFrame(function () {
      panel.style.transition = 'height 320ms cubic-bezier(0.4, 0, 0.2, 1), opacity 260ms ease';
      panel.style.height = '0px';
      panel.style.opacity = '0';
    });

    panel.addEventListener(
      'transitionend',
      function onCloseEnd(event) {
        if (event.propertyName !== 'height' || panel.dataset.daAnimToken !== token) {
          return;
        }
        panel.style.transition = '';
        panel.style.height = '0px';
        panel.style.opacity = '0';
        panel.hidden = true;
      },
      { once: true }
    );
  }

  function updateIcon(item, isOpen) {
    const collapsed = item.querySelector('.da-icon-collapsed');
    const expanded = item.querySelector('.da-icon-expanded');

    if (collapsed) {
      collapsed.classList.toggle('da-hidden', isOpen);
    }

    if (expanded) {
      expanded.classList.toggle('da-hidden', !isOpen);
    }
  }

  function setItemState(item, isOpen) {
    const button = item.querySelector('.da-header');
    const panel = item.querySelector('.da-panel');

    if (!button || !panel) {
      return;
    }

    item.classList.toggle('is-open', isOpen);
    button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    animatePanel(panel, isOpen);
    updateIcon(item, isOpen);
  }

  function initAccordion(accordion) {
    const items = Array.from(accordion.querySelectorAll('.da-item'));

    if (!items.length || accordion.dataset.ready === '1') {
      return;
    }

    accordion.dataset.ready = '1';

    const allowMultiple = accordion.dataset.multipleOpen === '1';
    const allowCollapse = accordion.dataset.allowCollapse === '1';

    items.forEach(function (item) {
      const button = item.querySelector('.da-header');

      if (!button) {
        return;
      }

      initializePanel(item);

      button.addEventListener('click', function () {
        const isOpen = item.classList.contains('is-open');
        const nextOpen = allowCollapse ? !isOpen : true;

        if (!allowMultiple && nextOpen) {
          items.forEach(function (other) {
            if (other !== item) {
              setItemState(other, false);
            }
          });
        }

        setItemState(item, nextOpen);
      });
    });
  }

  function boot() {
    document.querySelectorAll('.da-accordion').forEach(initAccordion);
  }

  if (window.elementorFrontend && window.elementorFrontend.hooks) {
    window.elementorFrontend.hooks.addAction('frontend/element_ready/dope_accordion.default', boot);
  }

  document.addEventListener('DOMContentLoaded', boot);
})();
