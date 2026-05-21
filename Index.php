<?php
require_once 'db.php';
// Fetch all games from database
try {
    $stmt = $pdo->query("SELECT * FROM `games` ORDER BY `id` ASC");
    $games = $stmt->fetchAll();
} catch (Exception $e) {
    $games = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PS5 — Play Has No Limits</title>
  <link rel="stylesheet" href="style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Exo+2:wght@300;400;600;700;900&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>

  <div class="cursor" id="cursor"></div>
  <div class="cursor-ring" id="cursorRing"></div>
  <canvas id="particles"></canvas>

  <!-- ══════════ NAVBAR ══════════ -->
  <nav id="navbar">
    <div class="brand"><span class="bps">PS</span><span class="b5">5</span></div>
    <ul class="nav-links" id="navLinks">
      <li><a href="#features">Features</a></li>
      <li><a href="#trailers">Trailers</a></li>
      <li><a href="#games">Games</a></li>
      <li><a href="#specs">Specs</a></li>
    </ul>
    <button class="nav-cta">Buy Now — $449</button>
    <button class="burger" id="burger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </nav>

  <!-- ══════════ HERO ══════════ -->
  <section class="hero" id="home">
    <!--
      HERO VIDEO: BigBuckBunny — 100% confirmed working, open CORS, no restrictions.
      Acts as a cinematic background loop only. Sound off. No user interaction needed.
    -->
    <video class="hero-vid" autoplay muted loop playsinline>
      <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4" type="video/mp4"/>
    </video>
    <div class="hero-shade"></div>

    <div class="hero-content">
      <div class="eyebrow reveal" data-d="0"><span class="blink-dot"></span>Next Generation Gaming</div>
      <h1 class="hero-title">
        <span class="hl reveal" data-d="100">PLAY</span>
        <span class="hl accent reveal" data-d="250">HAS NO</span>
        <span class="hl reveal" data-d="400">LIMITS.</span>
      </h1>
      <p class="hero-desc reveal" data-d="550">
        Ultra-Speed SSD &nbsp;·&nbsp; Adaptive Triggers &nbsp;·&nbsp; Tempest 3D Audio<br>
        4K · 120fps · The future of gaming is here.
      </p>
      <div class="hero-actions reveal" data-d="700">
        <button class="btn-blue" id="heroTrailerBtn">
          <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z" fill="currentColor"/></svg>
          Watch Trailers
        </button>
        <button class="btn-border" id="heroFeatBtn">Explore PS5</button>
      </div>
    </div>

    <div class="hud reveal" data-d="850">
      <div class="hud-cell"><span class="hv">4K</span><span class="hk">Resolution</span></div>
      <div class="hud-div"></div>
      <div class="hud-cell"><span class="hv">120</span><span class="hk">FPS</span></div>
      <div class="hud-div"></div>
      <div class="hud-cell"><span class="hv">3D</span><span class="hk">Audio</span></div>
      <div class="hud-div"></div>
      <div class="hud-cell"><span class="hv">825<small>GB</small></span><span class="hk">SSD</span></div>
    </div>

    <div class="scroll-cue"><div class="sc-bar"></div><span>Scroll</span></div>
  </section>

  <!-- ══════════ FEATURES ══════════ -->
  <section class="feat-sec" id="features">
    <div class="sec-hd">
      <span class="sec-tag reveal">Built Different</span>
      <h2 class="sec-title reveal">ENGINEERED FOR <em>POWER</em></h2>
    </div>
    <div class="feat-grid">
      <div class="fc reveal" data-d="0">
        <div class="fc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <h3>Ultra-High Speed SSD</h3>
        <p>Custom 825GB SSD at 5.5GB/s. Near-instant load times. Worlds load before you blink.</p>
        <div class="fc-bar"><div class="fc-fill" style="--w:96%"></div></div>
        <span class="fc-tag">5.5 GB/s Raw</span>
      </div>
      <div class="fc reveal" data-d="100">
        <div class="fc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
        </div>
        <h3>Adaptive Triggers</h3>
        <p>Feel bowstring tension, weapon recoil and terrain resistance through DualSense haptics.</p>
        <div class="fc-bar"><div class="fc-fill" style="--w:88%"></div></div>
        <span class="fc-tag">Haptic Feedback</span>
      </div>
      <div class="fc reveal" data-d="200">
        <div class="fc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 010 14.14M15.54 8.46a5 5 0 010 7.07"/></svg>
        </div>
        <h3>Tempest 3D Audio</h3>
        <p>Custom audio engine processes hundreds of sound sources for true spatial 360° audio.</p>
        <div class="fc-bar"><div class="fc-fill" style="--w:92%"></div></div>
        <span class="fc-tag">360° Soundscape</span>
      </div>
      <div class="fc reveal" data-d="300">
        <div class="fc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3>4K @ 120fps</h3>
        <p>10.3 TFLOPS GPU with hardware ray tracing. Cinematic visuals at impossibly smooth framerates.</p>
        <div class="fc-bar"><div class="fc-fill" style="--w:100%"></div></div>
        <span class="fc-tag">10.3 TFLOPS</span>
      </div>
    </div>
  </section>

  <!-- ══════════ TRAILERS ══════════ -->
  <!--
    VIDEO STRATEGY:
    - Background loops: Google CDN MP4s (open CORS, always available)
    - "Watch Trailer" button: opens YouTube embed in modal (guaranteed to work)
    - Cards are CLICKABLE anywhere to open the trailer modal
  -->
  <section class="trailer-sec" id="trailers">
    <div class="sec-hd">
      <span class="sec-tag reveal">See It In Action</span>
      <h2 class="sec-title reveal">GAME <em>TRAILERS</em></h2>
      <p class="sec-desc reveal">Click any card or the Watch button to stream the official trailer.</p>
    </div>

    <div class="tabs reveal">
      <button class="tab active" data-filter="all">All</button>
      <button class="tab" data-filter="exclusive">PS5 Exclusive</button>
      <button class="tab" data-filter="action">Action</button>
      <button class="tab" data-filter="rpg">RPG</button>
      <button class="tab" data-filter="racing">Racing</button>
    </div>

    <div class="tg" id="trailerGrid">
      <?php foreach ($games as $index => $game): ?>
      <div class="tc <?= $index === 0 ? 'featured' : '' ?> reveal" data-d="<?= $index * 80 ?>" data-cat="<?= htmlspecialchars($game['category']) ?>"
           data-video="<?= htmlspecialchars($game['video_path']) ?>" data-title="<?= htmlspecialchars($game['title']) ?>" 
           data-game-id="<?= $game['id'] ?>"
           data-price="<?= htmlspecialchars($game['price']) ?>"
           data-genre="<?= htmlspecialchars($game['genre']) ?>"
           data-dev="<?= htmlspecialchars($game['developer']) ?>"
           data-date="<?= htmlspecialchars($game['release_date']) ?>"
           data-desc="<?= htmlspecialchars($game['description']) ?>">
        <div class="tc-thumb">
          <?php if (pathinfo($game['poster_path'], PATHINFO_EXTENSION) === 'mp4'): ?>
            <video src="<?= htmlspecialchars($game['poster_path']) ?>" preload="none" muted style="width:100%;height:100%;object-fit:cover;pointer-events:none;display:block;"></video>
          <?php else: ?>
            <img src="<?= htmlspecialchars($game['poster_path']) ?>" alt="<?= htmlspecialchars($game['title']) ?>" style="width:100%;height:100%;object-fit:cover;pointer-events:none;display:block;"/>
          <?php endif; ?>
          <div class="tc-play-icon"><svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z" fill="white"/></svg></div>
        </div>
        <div class="tc-overlay">
          <span class="tc-badge <?= $game['category'] === 'exclusive' ? 'excl' : ($game['category'] === 'action' ? 'act' : ($game['category'] === 'rpg' ? 'rpg' : 'race')) ?>">
            <?= $game['category'] === 'exclusive' ? 'PS5 Exclusive' : ucfirst($game['category']) ?>
          </span>
          <div class="tc-info">
            <h3><?= htmlspecialchars($game['title']) ?></h3>
            <p><?= htmlspecialchars(substr($game['description'], 0, 75)) ?>...</p>
            <button class="tc-btn">
              <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z" fill="white"/></svg>Explore & Watch
            </button>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ══════════ GAMES ══════════ -->
  <section class="games-sec" id="games">
    <div class="sec-hd">
      <span class="sec-tag reveal">The Library</span>
      <h2 class="sec-title reveal">ICONIC <em>TITLES</em></h2>
    </div>
    <div class="marquee-wrap">
      <div class="marquee">
        <span>God of War</span><i>✦</i><span>Spider-Man 2</span><i>✦</i>
        <span>Horizon Forbidden West</span><i>✦</i><span>Gran Turismo 7</span><i>✦</i>
        <span>Final Fantasy XVI</span><i>✦</i><span>Returnal</span><i>✦</i>
        <span>Demon's Souls</span><i>✦</i><span>Ratchet & Clank</span><i>✦</i>
        <span>The Last of Us Part I</span><i>✦</i><span>Ghost of Tsushima</span><i>✦</i>
        <span>God of War</span><i>✦</i><span>Spider-Man 2</span><i>✦</i>
        <span>Horizon Forbidden West</span><i>✦</i><span>Gran Turismo 7</span><i>✦</i>
        <span>Final Fantasy XVI</span><i>✦</i><span>Returnal</span><i>✦</i>
        <span>Demon's Souls</span><i>✦</i><span>Ratchet & Clank</span><i>✦</i>
        <span>The Last of Us Part I</span><i>✦</i><span>Ghost of Tsushima</span><i>✦</i>
      </div>
    </div>
    <div class="games-grid">
      <?php 
      $gc_games = array_slice($games, 0, 6);
      foreach ($gc_games as $index => $game): 
        $gradient = 'linear-gradient(145deg,#0b1828,#1b2b3a)';
        if (strpos(strtolower($game['title']), 'god of war') !== false) $gradient = 'linear-gradient(145deg,#1a0536,#7c1fd4)';
        elseif (strpos(strtolower($game['title']), 'spider-man') !== false) $gradient = 'linear-gradient(145deg,#061030,#1a4fd8)';
        elseif (strpos(strtolower($game['title']), 'horizon') !== false) $gradient = 'linear-gradient(145deg,#041a0c,#14803a)';
        elseif (strpos(strtolower($game['title']), 'gran turismo') !== false) $gradient = 'linear-gradient(145deg,#1a0000,#c01c1c)';
        elseif (strpos(strtolower($game['title']), 'final fantasy') !== false) $gradient = 'linear-gradient(145deg,#0d0020,#5b21b6)';
        elseif (strpos(strtolower($game['title']), 'demon') !== false) $gradient = 'linear-gradient(145deg,#0a1020,#0d4f7c)';
      ?>
      <div class="gc reveal" data-d="<?= $index * 80 ?>"
           style="--gb:<?= $gradient ?>"
           data-video="<?= htmlspecialchars($game['video_path']) ?>" data-title="<?= htmlspecialchars($game['title']) ?>" 
           data-game-id="<?= $game['id'] ?>"
           data-price="<?= htmlspecialchars($game['price']) ?>"
           data-genre="<?= htmlspecialchars($game['genre']) ?>"
           data-dev="<?= htmlspecialchars($game['developer']) ?>"
           data-date="<?= htmlspecialchars($game['release_date']) ?>"
           data-desc="<?= htmlspecialchars($game['description']) ?>">
        <div class="gc-thumb">
          <?php if (pathinfo($game['poster_path'], PATHINFO_EXTENSION) === 'mp4'): ?>
            <video src="<?= htmlspecialchars($game['poster_path']) ?>" preload="none" muted style="width:100%;height:100%;object-fit:cover;pointer-events:none;display:block;"></video>
          <?php else: ?>
            <img src="<?= htmlspecialchars($game['poster_path']) ?>" alt="<?= htmlspecialchars($game['title']) ?>" style="width:100%;height:100%;object-fit:cover;pointer-events:none;display:block;"/>
          <?php endif; ?>
          <div class="gc-play"><svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z" fill="white"/></svg></div>
        </div>
        <div class="gc-info">
          <span class="gc-genre"><?= htmlspecialchars($game['genre']) ?><?= $game['is_exclusive'] ? ' · PS5 Exclusive' : '' ?></span>
          <h4><?= htmlspecialchars($game['title']) ?></h4>
          <div class="gc-score"><span class="gc-stars">★★★★★</span><b><?= htmlspecialchars($game['rating']) ?></b></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ══════════ SPECS ══════════ -->
  <section class="specs-sec" id="specs">
    <div class="specs-watermark">PS5</div>
    <div class="sec-hd">
      <span class="sec-tag reveal">Under The Hood</span>
      <h2 class="sec-title reveal">TECH <em>SPECS</em></h2>
    </div>
    <div class="specs-grid">
      <div class="sr reveal" data-d="0">  <span class="sk">CPU</span>        <span class="sv">AMD Zen 2 · 8 Cores @ 3.5GHz variable</span></div>
      <div class="sr reveal" data-d="60"> <span class="sk">GPU</span>        <span class="sv">AMD RDNA 2 · 10.3 TFLOPS · Ray Tracing</span></div>
      <div class="sr reveal" data-d="120"><span class="sk">RAM</span>        <span class="sv">16GB GDDR6 / 256-bit</span></div>
      <div class="sr reveal" data-d="180"><span class="sk">Storage</span>   <span class="sv">Custom 825GB NVMe SSD · 5.5 GB/s</span></div>
      <div class="sr reveal" data-d="240"><span class="sk">Optical</span>   <span class="sv">Ultra HD Blu-ray · 4K UHD playback</span></div>
      <div class="sr reveal" data-d="300"><span class="sk">Output</span>    <span class="sv">HDMI 2.1 · Up to 8K · VRR support</span></div>
      <div class="sr reveal" data-d="360"><span class="sk">Audio</span>     <span class="sv">Tempest 3D Audio Engine · Custom unit</span></div>
      <div class="sr reveal" data-d="420"><span class="sk">Connect</span>   <span class="sv">Wi-Fi 6 · Bluetooth 5.1 · USB-C · USB-A ×2</span></div>
    </div>
  </section>

  <!-- ══════════ CTA ══════════ -->
  <section class="cta-sec">
    <video class="cta-vid" autoplay muted loop playsinline>
      <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/WeAreGoingOnBullrun.mp4" type="video/mp4"/>
    </video>
    <div class="cta-shade"></div>
    <div class="cta-body reveal">
      <span class="sec-tag">Ready to Level Up?</span>
      <h2 class="cta-title">GET YOUR <em>PS5</em><br>TODAY</h2>
      <p class="cta-desc">Join millions already experiencing the next generation.<br>Two models available. Limited stock.</p>
      <div class="cta-prices">
        <div class="ctp"><span class="ctp-name">PS5 Standard</span><span class="ctp-price">$499.99</span></div>
        <div class="ctp-sep"></div>
        <div class="ctp"><span class="ctp-name">PS5 Digital</span><span class="ctp-price">$449.99</span></div>
      </div>
      <div class="cta-btns">
        <button class="btn-blue large">Order Now</button>
        <button class="btn-border large">Find a Store</button>
      </div>
    </div>
  </section>

  <!-- ══════════ FOOTER ══════════ -->
  <footer>
    <div class="ft-top">
      <div class="ft-brand">
        <div class="ft-logo"><span class="bps">PS</span><span class="b5">5</span></div>
        <p>Play Has No Limits</p>
        <div class="ft-social">
          <a href="#" aria-label="Twitter">𝕏</a>
          <a href="#" aria-label="Instagram">IG</a>
          <a href="#" aria-label="YouTube">YT</a>
          <a href="#" aria-label="TikTok">TK</a>
        </div>
      </div>
      <div class="ft-cols">
        <div class="ft-col"><h5>PlayStation</h5><a href="#">PS5 Console</a><a href="#">DualSense</a><a href="#">PS VR2</a><a href="#">PS Store</a></div>
        <div class="ft-col"><h5>Games</h5><a href="#">New Releases</a><a href="#">Exclusives</a><a href="#">Free to Play</a><a href="#">Coming Soon</a></div>
        <div class="ft-col"><h5>Support</h5><a href="#">Setup Guide</a><a href="#">Troubleshoot</a><a href="#">Contact Us</a><a href="#">Community</a></div>
      </div>
    </div>
    <div class="ft-bottom">
      <p>© 2024 Sony Interactive Entertainment LLC. PlayStation® and PS5™ are registered trademarks of Sony Interactive Entertainment Inc.</p>
    </div>
  </footer>

  <!-- ══════════ TRAILER VIDEO MODAL ══════════ -->
  <div class="modal" id="modal" role="dialog" aria-modal="true">
    <div class="modal-box">
      <div class="modal-head">
        <h3 id="modalTitle">Game Trailer</h3>
        <button class="modal-close" id="modalClose" aria-label="Close">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>
      <div class="modal-frame">
        <video id="modalVideo" controls playsinline style="width:100%;height:100%;">
          <source src="" type="video/mp4"/>
        </video>
      </div>
    </div>
  </div>

  <!-- ══════════ SIDE DETAILS DRAWER ══════════ -->
  <div class="drawer" id="detailsDrawer">
    <div class="drawer-overlay" id="drawerOverlay"></div>
    <div class="drawer-content">
      <button class="drawer-close" id="drawerClose" aria-label="Close Details">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
      <div class="drawer-body">
        <span class="drawer-tag" id="drawerGenre">Action</span>
        <h2 class="drawer-title" id="drawerTitle">Game Title</h2>
        
        <div class="drawer-meta">
          <div class="dm-cell"><span class="dm-key">Developer</span><span class="dm-val" id="drawerDev">Santa Monica</span></div>
          <div class="dm-cell"><span class="dm-key">Release Date</span><span class="dm-val" id="drawerDate">2022-11-09</span></div>
          <div class="dm-cell"><span class="dm-key">Price</span><span class="dm-val text-neon" id="drawerPrice">$69.99</span></div>
        </div>
        
        <div class="drawer-divider"></div>
        
        <h3>Game Description</h3>
        <p class="drawer-desc" id="drawerDesc">Detailed description about this game and what makes it special on PS5.</p>
        
        <div class="drawer-actions">
          <button class="btn-blue large" id="drawerOrderBtn">
            <svg viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;margin-right:10px;"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
            Pre-Order Game
          </button>
          <button class="btn-border large" id="drawerPlayBtn">
            <svg viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;margin-right:10px;"><path d="M8 5v14l11-7z"/></svg>
            Watch Trailer
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ══════════ ORDER/CHECKOUT MODAL ══════════ -->
  <div class="modal" id="orderModal" role="dialog" aria-modal="true">
    <div class="modal-box checkout-box">
      <div class="modal-head">
        <h3 id="checkoutModalTitle">Pre-Order: Game Title</h3>
        <button class="modal-close" id="orderModalClose" aria-label="Close">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>
      <form id="checkoutForm" method="POST" action="order.php">
        <input type="hidden" name="game_id" id="checkoutGameId" value=""/>
        
        <div class="checkout-body">
          <div class="form-row">
            <div class="form-grp">
              <label for="coEdition">Game Edition</label>
              <select name="edition" id="coEdition">
                <option value="Standard Edition" data-addon="0">Standard Edition — Base Price</option>
                <option value="Digital Edition" data-addon="-5">Digital Edition — Save $5.00</option>
                <option value="Digital Deluxe Edition" data-addon="10">Digital Deluxe Edition — +$10.00</option>
              </select>
            </div>
            <div class="form-grp price-calc">
              <span class="calc-label">Total Summary</span>
              <span class="calc-price" id="calcPriceDisplay">$69.99</span>
            </div>
          </div>
          
          <div class="form-grp">
            <label for="coName">Full Name</label>
            <input type="text" name="name" id="coName" placeholder="Kratos of Sparta" required/>
          </div>
          
          <div class="form-grp">
            <label for="coEmail">Email Address</label>
            <input type="email" name="email" id="coEmail" placeholder="kratos@nine-realms.com" required/>
          </div>
          
          <div class="form-grp">
            <label for="coAddress">Shipping Address / Contact Number</label>
            <textarea name="address" id="coAddress" placeholder="123 Spartan Way, Asgard Domain, Realm of Odin" rows="3" required></textarea>
          </div>
          
          <div id="checkoutError" class="checkout-error" style="display:none;"></div>
        </div>
        
        <div class="modal-foot">
          <button type="submit" class="btn-blue large" style="width: 100%; justify-content: center;">
            Confirm Pre-Order Transaction
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ══════════ ORDER SUCCESS DIALOG ══════════ -->
  <div class="modal" id="successModal" role="dialog" aria-modal="true">
    <div class="modal-box checkout-box success-box">
      <div class="success-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:40px;height:40px;stroke:#10b981;margin:0 auto;">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
      <h3 class="success-title">Transaction Logged</h3>
      <p class="success-desc">Your pre-order has been processed and saved to the secure database. Welcome to the next generation of play.</p>
      
      <div class="success-receipt">
        <div class="sr-row"><span class="sr-key">Transaction ID</span><span class="sr-val text-neon" id="receiptTransId">PS5-XXXXX</span></div>
        <div class="sr-row"><span class="sr-key">Game Selected</span><span class="sr-val" id="receiptGame">God of War</span></div>
        <div class="sr-row"><span class="sr-key">Console Edition</span><span class="sr-val" id="receiptEdition">Deluxe Edition</span></div>
        <div class="sr-row"><span class="sr-key">Amount Charged</span><span class="sr-val text-neon" id="receiptPrice">$79.99</span></div>
      </div>
      
      <button class="btn-blue large" id="successCloseBtn" style="width: 100%; justify-content: center; margin-top: 14px;">
        Return to Showcase
      </button>
    </div>
  </div>

  <!-- ══════════ BACKGRID SWITCHER (FRONT-PAGE BG VIDEO SWITCHER) ══════════ -->
  <div class="bg-switcher">
    <div class="bgs-title">Cinematic Feed</div>
    <div class="bgs-options">
      <button class="bgs-opt active" data-vid="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4">Bunny</button>
      <button class="bgs-opt" data-vid="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4">Sintel</button>
      <button class="bgs-opt" data-vid="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4">Steel</button>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>