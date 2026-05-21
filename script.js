/* ════════════════════════════════════════
   PS5 ADVERTISING PAGE — script.js
   Full rewrite — YouTube modal, all fixed
════════════════════════════════════════ */

'use strict';

/* ─── 1. CUSTOM CURSOR ─── */
(function () {
  const dot  = document.getElementById('cursor');
  const ring = document.getElementById('cursorRing');
  let mx = 0, my = 0, rx = 0, ry = 0;

  document.addEventListener('mousemove', e => {
    mx = e.clientX; my = e.clientY;
    dot.style.left = mx + 'px';
    dot.style.top  = my + 'px';
  });

  (function tick() {
    rx += (mx - rx) * 0.11;
    ry += (my - ry) * 0.11;
    ring.style.left = rx + 'px';
    ring.style.top  = ry + 'px';
    requestAnimationFrame(tick);
  })();

  const hoverEls = 'button,a,.tc,.gc,.tab,.ft-col a,.nav-links a';
  document.querySelectorAll(hoverEls).forEach(el => {
    el.addEventListener('mouseenter', () => {
      dot.style.width  = '18px';
      dot.style.height = '18px';
      ring.style.width  = '50px';
      ring.style.height = '50px';
    });
    el.addEventListener('mouseleave', () => {
      dot.style.width  = '10px';
      dot.style.height = '10px';
      ring.style.width  = '30px';
      ring.style.height = '30px';
    });
  });
})();


/* ─── 2. PARTICLE CANVAS ─── */
(function () {
  const canvas = document.getElementById('particles');
  const ctx    = canvas.getContext('2d');

  function resize() {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
  }
  resize();
  window.addEventListener('resize', resize);

  const pts = Array.from({ length: 70 }, () => ({
    x: Math.random() * canvas.width,
    y: Math.random() * canvas.height,
    r: Math.random() * 1.4 + 0.3,
    dx: (Math.random() - 0.5) * 0.22,
    dy: (Math.random() - 0.5) * 0.22,
    a: Math.random() * 0.6 + 0.1,
  }));

  (function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    pts.forEach(p => {
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
      ctx.fillStyle = `rgba(0,229,255,${p.a * 0.45})`;
      ctx.fill();
      p.x += p.dx; p.y += p.dy;
      if (p.x < 0) p.x = canvas.width;
      if (p.x > canvas.width) p.x = 0;
      if (p.y < 0) p.y = canvas.height;
      if (p.y > canvas.height) p.y = 0;
    });
    requestAnimationFrame(draw);
  })();
})();


/* ─── 3. NAVBAR SCROLL STICK ─── */
(function () {
  const nav = document.getElementById('navbar');
  const onScroll = () => nav.classList.toggle('stuck', window.scrollY > 55);
  window.addEventListener('scroll', onScroll, { passive: true });
})();


/* ─── 4. HAMBURGER MENU ─── */
(function () {
  const btn   = document.getElementById('burger');
  const links = document.getElementById('navLinks');

  btn.addEventListener('click', () => {
    const isOpen = links.classList.toggle('open');
    btn.setAttribute('aria-expanded', isOpen);
  });

  // Close on link click
  links.querySelectorAll('a').forEach(a =>
    a.addEventListener('click', () => links.classList.remove('open'))
  );
})();


/* ─── 5. SCROLL REVEAL ─── */
(function () {
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const delay = Number(entry.target.dataset.d || 0);
      setTimeout(() => entry.target.classList.add('in'), delay);
      obs.unobserve(entry.target);
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
})();


/* ─── 6. SPEC ROWS STAGGER ─── */
(function () {
  const rows = document.querySelectorAll('.sr');
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const idx = [...rows].indexOf(entry.target);
      setTimeout(() => entry.target.classList.add('in'), idx * 65);
      obs.unobserve(entry.target);
    });
  }, { threshold: 0.12 });

  rows.forEach(r => obs.observe(r));
})();


/* ─── 7. HERO BUTTON SCROLL ─── */
(function () {
  const smoothTo = id => {
    const el = document.getElementById(id);
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
  };

  const trailerBtn = document.getElementById('heroTrailerBtn');
  const featBtn    = document.getElementById('heroFeatBtn');
  if (trailerBtn) trailerBtn.addEventListener('click', () => smoothTo('trailers'));
  if (featBtn)    featBtn.addEventListener('click',    () => smoothTo('features'));

  // All anchor links
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
    });
  });
})();


/* ─── 8. PARALLAX HERO ─── */
(function () {
  const content = document.querySelector('.hero-content');
  const hud     = document.querySelector('.hud');
  window.addEventListener('scroll', () => {
    const y = window.scrollY;
    if (y > window.innerHeight) return;
    if (content) content.style.transform = `translateY(${y * 0.22}px)`;
    if (hud)     hud.style.transform     = `translateY(${y * 0.12}px)`;
  }, { passive: true });
})();


/* ─── 9. VIDEO TRAILER MODAL, DETAILS DRAWER, AJAX CHECKOUT, AND BG SWITCHER ─── */
(function () {
  // Video Modal Elements
  const modal      = document.getElementById('modal');
  const modalVideo = document.getElementById('modalVideo');
  const modalIframe = document.getElementById('modalIframe');
  const modalTitle = document.getElementById('modalTitle');
  const modalClose = document.getElementById('modalClose');

  // Details Drawer Elements
  const drawer        = document.getElementById('detailsDrawer');
  const drawerOverlay = document.getElementById('drawerOverlay');
  const drawerClose   = document.getElementById('drawerClose');
  const drawerGenre   = document.getElementById('drawerGenre');
  const drawerTitle   = document.getElementById('drawerTitle');
  const drawerDev     = document.getElementById('drawerDev');
  const drawerDate    = document.getElementById('drawerDate');
  const drawerPrice   = document.getElementById('drawerPrice');
  const drawerDesc    = document.getElementById('drawerDesc');
  const drawerOrderBtn= document.getElementById('drawerOrderBtn');
  const drawerPlayBtn = document.getElementById('drawerPlayBtn');

  // Order/Checkout Modal Elements
  const orderModal      = document.getElementById('orderModal');
  const orderModalClose = document.getElementById('orderModalClose');
  const checkoutTitle   = document.getElementById('checkoutModalTitle');
  const checkoutForm    = document.getElementById('checkoutForm');
  const checkoutGameId  = document.getElementById('checkoutGameId');
  const coEdition       = document.getElementById('coEdition');
  const calcPrice       = document.getElementById('calcPriceDisplay');
  const checkoutError   = document.getElementById('checkoutError');

  // Success Modal Elements
  const successModal    = document.getElementById('successModal');
  const successCloseBtn = document.getElementById('successCloseBtn');
  const receiptTransId  = document.getElementById('receiptTransId');
  const receiptGame     = document.getElementById('receiptGame');
  const receiptEdition  = document.getElementById('receiptEdition');
  const receiptPrice    = document.getElementById('receiptPrice');

  // Background Video Switcher Elements
  const bgOpts = document.querySelectorAll('.bgs-opt');
  const heroVid = document.querySelector('.hero-vid');

  // Store clicked game data temporarily for drawer actions
  let activeGame = {
    id: 0,
    title: '',
    genre: '',
    price: 0.00,
    dev: '',
    date: '',
    desc: '',
    video: ''
  };

  /* --- Video Modal Actions --- */
  function openModal(videoPath, title) {
    if (!videoPath) return;
    modalTitle.textContent = title || 'Game Trailer';

    if (videoPath.includes('youtube.com') || videoPath.includes('youtu.be') || videoPath.includes('/embed/')) {
      // Hide video player, show iframe
      modalVideo.style.display = 'none';
      modalVideo.pause();
      modalIframe.style.display = 'block';

      // Ensure it is formatted as an embed URL with autoplay enabled
      let embedUrl = videoPath;
      if (videoPath.includes('watch?v=')) {
        embedUrl = videoPath.replace('watch?v=', 'embed/');
      }
      
      // Add autoplay parameters
      if (!embedUrl.includes('?')) {
        embedUrl += '?autoplay=1&mute=0';
      } else {
        if (!embedUrl.includes('autoplay=')) embedUrl += '&autoplay=1';
        if (!embedUrl.includes('mute=')) embedUrl += '&mute=0';
      }
      
      modalIframe.src = embedUrl;
    } else {
      // Hide iframe, show video player
      modalIframe.style.display = 'none';
      modalIframe.src = '';
      modalVideo.style.display = 'block';
      modalVideo.src = videoPath;
      modalVideo.muted = false; // Explicitly ensure the video is not muted
      modalVideo.volume = 1.0;  // Set volume to 100%
      modalVideo.load();
      modalVideo.play().catch(err => console.warn('Autoplay blocked:', err));
    }

    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    modal.classList.remove('open');
    modalVideo.pause();
    modalVideo.src = '';
    modalIframe.src = ''; // Clear iframe source to stop playback immediately
    if (!drawer.classList.contains('open') && !orderModal.classList.contains('open') && !successModal.classList.contains('open')) {
      document.body.style.overflow = '';
    }
  }

  if (modalClose) modalClose.addEventListener('click', closeModal);
  if (modal) modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });

  /* --- Details Drawer Actions --- */
  function openDrawer(card) {
    activeGame.id    = card.dataset.gameId;
    activeGame.title = card.dataset.title || '';
    activeGame.genre = card.dataset.genre || card.dataset.cat || '';
    activeGame.price = parseFloat(card.dataset.price || 0.00);
    activeGame.dev   = card.dataset.dev || '';
    activeGame.date  = card.dataset.date || '';
    activeGame.desc  = card.dataset.desc || '';
    activeGame.video = card.dataset.video || '';

    // Populate drawer elements
    if (drawerGenre) {
      drawerGenre.textContent = activeGame.genre;
      // Style badge based on category
      drawerGenre.className = 'drawer-tag';
      if (card.dataset.cat === 'exclusive') drawerGenre.classList.add('excl');
      else if (card.dataset.cat === 'action') drawerGenre.classList.add('act');
      else if (card.dataset.cat === 'rpg') drawerGenre.classList.add('rpg');
      else if (card.dataset.cat === 'racing') drawerGenre.classList.add('race');
    }
    if (drawerTitle) drawerTitle.textContent = activeGame.title;
    if (drawerDev) drawerDev.textContent = activeGame.dev;
    if (drawerDate) drawerDate.textContent = activeGame.date;
    if (drawerPrice) drawerPrice.textContent = '$' + activeGame.price.toFixed(2);
    if (drawerDesc) drawerDesc.textContent = activeGame.desc;

    // Show drawer
    if (drawer) drawer.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer() {
    if (drawer) drawer.classList.remove('open');
    if (!orderModal.classList.contains('open') && !successModal.classList.contains('open') && !modal.classList.contains('open')) {
      document.body.style.overflow = '';
    }
  }

  // Bind clicks on trailer cards (.tc) and game cards (.gc) to open drawer
  document.querySelectorAll('.tc').forEach(card => {
    card.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      openDrawer(card);
    });
  });

  document.querySelectorAll('.gc').forEach(card => {
    card.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      openDrawer(card);
    });
  });

  if (drawerClose) drawerClose.addEventListener('click', closeDrawer);
  if (drawerOverlay) drawerOverlay.addEventListener('click', closeDrawer);

  // Drawer Play Button -> Opens the video trailer modal
  if (drawerPlayBtn) {
    drawerPlayBtn.addEventListener('click', () => {
      openModal(activeGame.video, activeGame.title);
    });
  }

  // Drawer Order Button -> Closes drawer, opens Order Modal
  if (drawerOrderBtn) {
    drawerOrderBtn.addEventListener('click', () => {
      closeDrawer();
      openOrderModal();
    });
  }

  /* --- Order Modal & Checkout --- */
  function openOrderModal() {
    if (checkoutTitle) checkoutTitle.textContent = 'Pre-Order: ' + activeGame.title;
    if (checkoutGameId) checkoutGameId.value = activeGame.id;
    if (checkoutError) {
      checkoutError.style.display = 'none';
      checkoutError.textContent = '';
    }
    
    // Reset inputs
    if (checkoutForm) {
      checkoutForm.querySelector('#coName').value = '';
      checkoutForm.querySelector('#coEmail').value = '';
      checkoutForm.querySelector('#coAddress').value = '';
    }

    // Reset edition dropdown and compute base price
    if (coEdition) coEdition.selectedIndex = 0;
    updateCheckoutPrice();

    if (orderModal) orderModal.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeOrderModal() {
    if (orderModal) orderModal.classList.remove('open');
    if (!drawer.classList.contains('open') && !successModal.classList.contains('open') && !modal.classList.contains('open')) {
      document.body.style.overflow = '';
    }
  }

  function updateCheckoutPrice() {
    if (!coEdition || !calcPrice) return;
    const selectedOpt = coEdition.options[coEdition.selectedIndex];
    const addon = parseFloat(selectedOpt.dataset.addon || 0);
    const totalPrice = activeGame.price + addon;
    calcPrice.textContent = '$' + totalPrice.toFixed(2);
  }

  if (orderModalClose) orderModalClose.addEventListener('click', closeOrderModal);
  if (orderModal) {
    orderModal.addEventListener('click', e => {
      if (e.target === orderModal) closeOrderModal();
    });
  }

  if (coEdition) {
    coEdition.addEventListener('change', updateCheckoutPrice);
  }

  /* --- AJAX Checkout Form Submission --- */
  if (checkoutForm) {
    checkoutForm.addEventListener('submit', (e) => {
      e.preventDefault();
      
      if (checkoutError) {
        checkoutError.style.display = 'none';
        checkoutError.textContent = '';
      }

      const submitBtn = checkoutForm.querySelector('button[type="submit"]');
      const originalBtnText = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = `Processing Secure Order...`;

      const formData = new FormData(checkoutForm);

      fetch('order.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;

        if (data.success) {
          // Clear and Close Checkout
          checkoutForm.reset();
          closeOrderModal();

          // Populate and Open Success Modal
          if (receiptTransId) receiptTransId.textContent = data.details.transaction_id;
          if (receiptGame) receiptGame.textContent = data.details.game_title;
          if (receiptEdition) receiptEdition.textContent = data.details.edition;
          if (receiptPrice) receiptPrice.textContent = '$' + data.details.total_price;

          if (successModal) successModal.classList.add('open');
          document.body.style.overflow = 'hidden';
        } else {
          // Show error message
          if (checkoutError) {
            checkoutError.textContent = data.message || 'An error occurred while placing the order.';
            checkoutError.style.display = 'block';
          }
        }
      })
      .catch(err => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
        if (checkoutError) {
          checkoutError.textContent = 'Server Connection Error. Please verify your local XAMPP Apache & MySQL are online.';
          checkoutError.style.display = 'block';
        }
        console.error('AJAX Error:', err);
      });
    });
  }

  /* --- Success Modal Actions --- */
  function closeSuccessModal() {
    if (successModal) successModal.classList.remove('open');
    if (!drawer.classList.contains('open') && !orderModal.classList.contains('open') && !modal.classList.contains('open')) {
      document.body.style.overflow = '';
    }
  }

  if (successCloseBtn) successCloseBtn.addEventListener('click', closeSuccessModal);
  if (successModal) {
    successModal.addEventListener('click', e => {
      if (e.target === successModal) closeSuccessModal();
    });
  }

  /* --- Front-Page Cinematic Switcher --- */
  bgOpts.forEach(btn => {
    btn.addEventListener('click', () => {
      // Toggle Active States
      bgOpts.forEach(o => o.classList.remove('active'));
      btn.classList.add('active');

      const newVidSrc = btn.dataset.vid;
      if (heroVid && newVidSrc) {
        heroVid.src = newVidSrc;
        heroVid.load();
        heroVid.play().catch(err => console.warn('Background play blocked:', err));
      }
    });
  });

  // Global escape key listener to close anything open
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      closeModal();
      closeDrawer();
      closeOrderModal();
      closeSuccessModal();
    }
  });
})();


/* ─── 10. TRAILER FILTER TABS ─── */
(function () {
  const tabs  = document.querySelectorAll('.tab');
  const cards = document.querySelectorAll('.tc');
  const grid  = document.getElementById('trailerGrid');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');

      const filter = tab.dataset.filter;

      cards.forEach(card => {
        const match = filter === 'all' || card.dataset.cat === filter;
        card.classList.toggle('hidden', !match);
      });

      // Re-apply featured class to first visible card
      const visible = [...cards].filter(c => !c.classList.contains('hidden'));
      cards.forEach(c => c.classList.remove('featured'));
      if (visible.length >= 3 && visible[0]) {
        visible[0].classList.add('featured');
      }
    });
  });
})();


/* ─── 11. MARQUEE PAUSE ON HOVER ─── */
(function () {
  const m = document.querySelector('.marquee');
  if (!m) return;
  m.addEventListener('mouseenter', () => m.style.animationPlayState = 'paused');
  m.addEventListener('mouseleave', () => m.style.animationPlayState = 'running');
})();


/* ─── 12. FEATURE CARD TILT ─── */
(function () {
  document.querySelectorAll('.fc').forEach(card => {
    card.addEventListener('mousemove', e => {
      const r = card.getBoundingClientRect();
      const x = (e.clientX - r.left) / r.width  - 0.5;
      const y = (e.clientY - r.top)  / r.height - 0.5;
      card.style.transform = `perspective(700px) rotateX(${-y * 5}deg) rotateY(${x * 5}deg) translateY(-4px)`;
    });
    card.addEventListener('mouseleave', () => { card.style.transform = ''; });
  });
})();


/* ─── 13. ACTIVE NAV HIGHLIGHT ─── */
(function () {
  const sections = document.querySelectorAll('section[id]');
  const links    = document.querySelectorAll('.nav-links a');

  const obs = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      links.forEach(link => {
        link.style.color = link.getAttribute('href') === `#${entry.target.id}`
          ? 'var(--sky)' : '';
      });
    });
  }, { threshold: 0.45 });

  sections.forEach(s => obs.observe(s));
})();


/* ─── 14. HERO VIDEO MUTE TOGGLE ─── */
(function () {
  const vid = document.querySelector('.hero-vid');
  if (!vid) return;

  // Create a subtle mute hint
  const hint = Object.assign(document.createElement('div'), {
    textContent: '🔇 Click video to unmute',
  });
  Object.assign(hint.style, {
    position: 'absolute', bottom: '148px', right: '64px',
    fontFamily: "'Exo 2',sans-serif", fontSize: '10px',
    letterSpacing: '.15em', textTransform: 'uppercase',
    color: 'rgba(255,255,255,.35)', zIndex: '3',
    pointerEvents: 'none', transition: 'opacity .5s',
  });
  document.querySelector('.hero').appendChild(hint);

  vid.addEventListener('click', () => {
    vid.muted = !vid.muted;
    hint.textContent = vid.muted ? '🔇 Click video to unmute' : '🔊 Click video to mute';
  });

  setTimeout(() => { hint.style.opacity = '0'; }, 6000);
})();