document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-print]').forEach(button => button.addEventListener('click', () => window.print()));
  document.querySelectorAll('form[data-confirm]').forEach(form => form.addEventListener('submit', event => {
    if (!window.confirm(form.dataset.confirm)) event.preventDefault();
  }));
  const toggle = document.getElementById('menuToggle');
  const sidebar = document.getElementById('navigation');
  toggle?.addEventListener('click', () => {
    const expanded = toggle.getAttribute('aria-expanded') !== 'true';
    toggle.setAttribute('aria-expanded', String(expanded)); sidebar.classList.toggle('is-open', expanded);
  });
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && toggle && sidebar) { sidebar.classList.remove('is-open'); toggle.setAttribute('aria-expanded', 'false'); }
  });
});
