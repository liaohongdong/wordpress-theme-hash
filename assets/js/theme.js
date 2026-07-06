(function() {
    var html = document.documentElement;
    var themeMode = html.getAttribute('data-theme-mode') || 'light';
    var changeTheme = html.getAttribute('data-change-theme') || 'N';

    function setTheme(theme) {
      html.setAttribute('data-theme', theme);
      try { localStorage.setItem('hash_theme', theme); } catch(e) {}
      var btn = document.getElementById('theme-toggle');
      if (btn) { btn.classList.toggle('is-dark', theme === 'dark'); }
    }

    function getPreferredTheme() {
      try {
        var saved = localStorage.getItem('hash_theme');
        if (saved) return saved;
      } catch(e) {}
      return themeMode;
    }

    if (changeTheme === 'Y') {
      var themeBtn = document.getElementById('theme-toggle');
      if (themeBtn) {
        themeBtn.classList.remove('hidden');
        setTheme(getPreferredTheme());
        themeBtn.addEventListener('click', function() {
          var current = html.getAttribute('data-theme') || 'light';
          setTheme(current === 'dark' ? 'light' : 'dark');
        });
      }
    } else {
      setTheme(themeMode);
    }

    var menuBtn = document.getElementById('menu-btn');
    var mobileNav = document.getElementById('mobile-nav');
    function toggleMenu(open) {
      if (open === undefined) open = !mobileNav.classList.contains('open');
      mobileNav.classList.toggle('open', open);
    }
    if (menuBtn && mobileNav) {
      menuBtn.addEventListener('click', function(e) { e.stopPropagation(); toggleMenu(); });
      mobileNav.addEventListener('click', function(e) { if (e.target === this) toggleMenu(false); });
      mobileNav.querySelectorAll('.menu-item-has-children > details > summary > a').forEach(function(link) {
        link.addEventListener('click', function(e) {
          if (window.innerWidth > 767) return;
          e.preventDefault();
        });
      });
      mobileNav.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function(e) {
          if (window.innerWidth > 767) return;
          if (this.closest('summary')) return;
          toggleMenu(false);
        });
      });
    }

    var nav = document.querySelector('.menu-horizontal');
    if (nav) {
      nav.querySelectorAll('.menu-item-has-children > details').forEach(function(d) {
        d.addEventListener('mouseenter', function() {
          clearTimeout(this._closeTimer);
          this.open = true;
          var p = this.parentElement.closest('.menu-item-has-children > details');
          while (p) { clearTimeout(p._closeTimer); p = p.parentElement.closest('.menu-item-has-children > details'); }
        });
        d.addEventListener('mouseleave', function() {
          var self = this;
          self._closeTimer = setTimeout(function() { self.open = false; }, 120);
        });
      });
    }

    var searchBtn = document.getElementById('search-btn');
    var searchOverlay = document.getElementById('search-overlay');
    var searchInput = document.getElementById('search-input');
    function openSearch() { searchOverlay.classList.add('open'); setTimeout(function() { searchInput && searchInput.focus(); }, 150); }
    function closeSearch() { searchOverlay.classList.remove('open'); }
    if (searchBtn && searchOverlay) {
      searchBtn.addEventListener('click', openSearch);
      searchOverlay.addEventListener('click', function(e) { if (e.target === this) closeSearch(); });
      document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeSearch(); });
    }
  })();
