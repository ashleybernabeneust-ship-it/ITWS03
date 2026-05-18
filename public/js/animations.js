document.addEventListener('DOMContentLoaded', function () {
  try {
    const nodes = document.querySelectorAll('[data-animate]');
    if (nodes.length) {
      const observer = new IntersectionObserver(function (entries, obs) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            const el = entry.target;
            const name = el.getAttribute('data-animate') || 'fade';
            el.classList.add('is-visible', 'animate-' + name);
            obs.unobserve(el);
          }
        });
      }, { threshold: 0.12 });

      nodes.forEach(function (n) { observer.observe(n); });
    }

    // Slide-down header on first paint
    const header = document.querySelector('.site-header');
    if (header) {
      header.classList.add('is-visible', 'animate-slide-down');
    }
  } catch (e) {
    // Fail silently — animations are progressive enhancement
    console.warn('Animations init failed:', e);
  }
});
