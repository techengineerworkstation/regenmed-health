<?php
if (!VERCEL_MODE && session_status() === PHP_SESSION_NONE) { session_start(); }

// Fetch tips for ticker
$rss = new RssFeedManager();
$tips = $rss->getTips(12);
$tipItems = [];
if (!empty($tips)) {
  foreach ($tips as $tip) {
    $tipItems[] = htmlspecialchars($tip['title']);
  }
}
// Fallback tips
if (empty($tipItems)) {
  $tipItems = [
    'Regenerative medicine harnesses your body\'s own healing power',
    'PEMF therapy supports cellular repair and reduces inflammation',
    'Stem cell therapy is revolutionizing orthopedic recovery',
    'Cognitive counselling improves focus, memory, and decision-making',
    'Nutritional optimization is the foundation of wellness',
    'Chronic stress accelerates aging — mindfulness reverses it',
    'Growth mindset counselling increases resilience by 40%',
    'Lab scans detect issues before symptoms appear',
    'Sleep quality is the #1 predictor of recovery speed',
    'Holistic wellness combines mind, body, and spirit healing',
  ];
}
$duplicatedTips = array_merge($tipItems, $tipItems);
$tipJson = json_encode($duplicatedTips);
?>
<style>
/* === DASHBOARD LAYOUT === */
.dashboard-hero { position: relative; overflow: hidden; border-radius: var(--radius); margin-bottom: 2.5rem; }
.hero-carousel { position: relative; height: 380px; overflow: hidden; border-radius: var(--radius); }
.hero-slide { position: absolute; inset: 0; display: flex; align-items: flex-end; padding: 2.5rem; opacity: 0; transition: opacity 0.8s ease; }
.hero-slide.active { opacity: 1; }
.hero-slide-bg { position: absolute; inset: 0; background-size: cover; background-position: center; }
.hero-slide-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.1) 100%); }
.hero-slide-content { position: relative; z-index: 1; color: #fff; max-width: 620px; }
.hero-slide-content h1 { font-family: var(--font-heading), 'DM Sans', sans-serif; font-size: 2rem; font-weight: 800; margin-bottom: 0.75rem; line-height: 1.15; letter-spacing: -0.025em; text-shadow: 0 2px 8px rgba(0,0,0,0.3); }
.hero-slide-content p { font-size: 0.95rem; font-weight: 400; opacity: 0.92; margin-bottom: 1.25rem; line-height: 1.6; text-shadow: 0 1px 4px rgba(0,0,0,0.2); }
.hero-cta { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.75rem; background: var(--accent-green); color: #fff; border: none; border-radius: 10px; font-family: var(--font-heading), 'DM Sans', sans-serif; font-weight: 700; font-size: 0.9rem; cursor: pointer; text-decoration: none; transition: all 0.25s ease; letter-spacing: 0.01em; box-shadow: 0 4px 14px rgba(22,163,74,0.35); }
.hero-cta:hover { background: var(--accent-violet); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(124,58,237,0.4); }

/* === STATS BAR === */
.stats-bar { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2.5rem; }
.stat-item { display: flex; align-items: center; gap: 0.85rem; padding: 1.15rem 1.35rem; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 14px; transition: all 0.25s ease; }
.stat-item:hover { border-color: var(--accent-primary); box-shadow: var(--shadow-md); transform: translateY(-2px); }
.stat-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
.stat-icon.green { background: color-mix(in srgb, var(--accent-green) 14%, transparent); color: var(--accent-green); }
.stat-icon.violet { background: color-mix(in srgb, var(--accent-violet) 14%, transparent); color: var(--accent-violet); }
.stat-icon.teal { background: color-mix(in srgb, var(--accent-primary) 14%, transparent); color: var(--accent-primary); }
.stat-icon.amber { background: color-mix(in srgb, #f59e0b 14%, transparent); color: #f59e0b; }
.stat-value { font-family: var(--font-heading), 'DM Sans', sans-serif; font-size: 1.65rem; font-weight: 800; color: var(--text-primary); line-height: 1; letter-spacing: -0.025em; }
.stat-label { font-size: 0.73rem; color: var(--text-secondary); margin-top: 0.2rem; font-weight: 500; letter-spacing: 0.01em; }

/* === SECTIONS === */
.section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--border-color); }
.section-title { font-family: var(--font-heading), 'DM Sans', sans-serif; font-size: 1.3rem; font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 0.6rem; letter-spacing: -0.02em; }
.section-title i { color: var(--accent-green); font-size: 1.25rem; }

/* === COUNSELLING CARDS (5 cards) === */
.counselling-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.15rem; margin-bottom: 3rem; }
.counselling-card {
  position: relative; overflow: hidden;
  padding: 1.6rem; border-radius: 16px;
  border: 1.5px solid var(--border-color);
  background: var(--bg-secondary);
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
}
.counselling-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px -8px rgba(0,0,0,0.15); border-color: var(--accent-primary); }
.counselling-card-image { position: absolute; top: 0; right: 0; width: 110px; height: 110px; object-fit: cover; opacity: 0.12; border-radius: 0 16px 0 60px; pointer-events: none; }
.counselling-card-icon { width: 48px; height: 48px; border-radius: 13px; display: flex; align-items: center; justify-content: center; font-size: 1.35rem; margin-bottom: 1rem; }
.counselling-card-title { font-family: var(--font-heading), 'DM Sans', sans-serif; font-size: 1.05rem; font-weight: 700; margin-bottom: 0.45rem; color: var(--text-primary); letter-spacing: -0.01em; }
.counselling-card-desc { font-size: 0.8rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 0.85rem; }
.counselling-card-tags { display: flex; flex-wrap: wrap; gap: 0.4rem; }
.counselling-tag { padding: 0.25rem 0.65rem; border-radius: 7px; font-size: 0.67rem; font-weight: 600; background: var(--bg-tertiary); color: var(--text-secondary); letter-spacing: 0.01em; }
.counselling-tag.green { background: color-mix(in srgb, var(--accent-green) 12%, transparent); color: var(--accent-green); }
.counselling-tag.violet { background: color-mix(in srgb, var(--accent-violet) 12%, transparent); color: var(--accent-violet); }
.counselling-tag.teal { background: color-mix(in srgb, var(--accent-primary) 12%, transparent); color: var(--accent-primary); }
.counselling-tag.amber { background: color-mix(in srgb, #f59e0b 12%, transparent); color: #f59e0b; }

/* === TESTS & THERAPIES (CHALLENGE CARDS) === */
.challenge-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; margin-bottom: 3rem; }
.challenge-card {
  position: relative; overflow: hidden;
  border-radius: 14px; border: 1.5px solid var(--border-color);
  background: var(--bg-secondary);
  transition: all 0.3s ease; cursor: pointer;
}
.challenge-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px -8px rgba(0,0,0,0.12); border-color: var(--accent-primary); }
.challenge-card-image { width: 100%; height: 120px; object-fit: cover; display: block; }
.challenge-card-body { padding: 1rem 1.1rem 1.1rem; }
.challenge-card-title { font-family: var(--font-heading), 'DM Sans', sans-serif; font-size: 0.88rem; font-weight: 700; margin-bottom: 0.3rem; color: var(--text-primary); letter-spacing: -0.01em; line-height: 1.3; }
.challenge-card-sub { font-size: 0.7rem; color: var(--text-secondary); margin-bottom: 0.6rem; line-height: 1.5; }
.challenge-card-cta { display: inline-flex; align-items: center; gap: 0.35rem; font-family: var(--font-heading), 'DM Sans', sans-serif; font-size: 0.72rem; font-weight: 700; color: var(--accent-primary); text-decoration: none; letter-spacing: 0.01em; }
.challenge-card-cta:hover { color: var(--accent-green); }

/* === RSS TICKER === */
.ticker-section { margin-bottom: 2.5rem; overflow: hidden; border-radius: 12px; border: 1px solid var(--border-color); background: var(--bg-secondary); }
.ticker-label { padding: 0.6rem 1rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--accent-green); background: var(--bg-tertiary); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: 0.5rem; }
.ticker-viewport { overflow: hidden; padding: 0.6rem 0; position: relative; }
.ticker-viewport::before, .ticker-viewport::after {
  content: ''; position: absolute; top: 0; bottom: 0; width: 40px; z-index: 2; pointer-events: none;
}
.ticker-viewport::before { left: 0; background: linear-gradient(to right, var(--bg-secondary), transparent); }
.ticker-viewport::after { right: 0; background: linear-gradient(to left, var(--bg-secondary), transparent); }
.ticker-item { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3rem 0.85rem; margin-right: 2.5rem; border-radius: 8px; font-size: 0.78rem; color: var(--text-secondary); white-space: nowrap; background: var(--bg-tertiary); border: 1px solid transparent; transition: all 0.2s ease; flex-shrink: 0; }
.ticker-item:hover { border-color: var(--accent-primary); color: var(--text-primary); }
.ticker-item::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: var(--accent-green); flex-shrink: 0; }

/* === HOW IT WORKS === */
.how-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 3rem; }
.how-step { text-align: center; padding: 1.5rem 1.25rem; border-radius: 16px; background: var(--bg-secondary); border: 1.5px solid var(--border-color); transition: all 0.3s ease; }
.how-step:hover { border-color: var(--accent-primary); box-shadow: var(--shadow-md); transform: translateY(-2px); }
.how-step-icon { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #16a34a, #7c3aed); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.6rem; box-shadow: 0 4px 14px rgba(22,163,74,0.3); }
.how-step-icon svg { width: 26px; height: 26px; }
.how-step-num { font-family: var(--font-heading), 'DM Sans', sans-serif; font-size: 0.68rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #16a34a; margin-bottom: 0.35rem; }
.how-step-title { font-family: var(--font-heading), 'DM Sans', sans-serif; font-size: 0.92rem; font-weight: 700; margin-bottom: 0.4rem; color: var(--text-primary); letter-spacing: -0.01em; }
.how-step-desc { font-size: 0.76rem; color: var(--text-secondary); line-height: 1.6; }

/* === TESTIMONIALS === */
.testimonial-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; margin-bottom: 3rem; }
.testimonial-card { padding: 1.35rem; border-radius: 14px; background: var(--bg-secondary); border: 1.5px solid var(--border-color); transition: all 0.3s ease; }
.testimonial-card:hover { border-color: var(--accent-primary); box-shadow: var(--shadow-md); }
.testimonial-stars { color: #f59e0b; font-size: 0.85rem; margin-bottom: 0.6rem; letter-spacing: 0.05em; }
.testimonial-text { font-size: 0.8rem; color: var(--text-secondary); line-height: 1.65; margin-bottom: 0.85rem; font-style: italic; }
.testimonial-author { display: flex; align-items: center; gap: 0.65rem; }
.testimonial-avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, var(--accent-green), var(--accent-violet)); color: #fff; display: flex; align-items: center; justify-content: center; font-family: var(--font-heading), 'DM Sans', sans-serif; font-weight: 700; font-size: 0.75rem; flex-shrink: 0; }
.testimonial-name { font-family: var(--font-heading), 'DM Sans', sans-serif; font-size: 0.8rem; font-weight: 600; color: var(--text-primary); }
.testimonial-role { font-size: 0.68rem; color: var(--text-secondary); }

/* === CTA SECTION === */
.cta-section { padding: 2.5rem; border-radius: 18px; background: linear-gradient(135deg, var(--accent-green), var(--accent-violet)); color: #fff; text-align: center; margin-bottom: 3rem; box-shadow: 0 8px 32px rgba(22,163,74,0.25); }
.cta-section h2 { font-family: var(--font-heading), 'DM Sans', sans-serif; font-size: 1.5rem; font-weight: 800; margin-bottom: 0.6rem; letter-spacing: -0.025em; }
.cta-section p { font-size: 0.9rem; opacity: 0.92; margin-bottom: 1.35rem; max-width: 550px; margin-left: auto; margin-right: auto; line-height: 1.6; }
.cta-links { display: flex; justify-content: center; gap: 0.85rem; flex-wrap: wrap; }
.cta-link { display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.65rem 1.35rem; border-radius: 11px; font-family: var(--font-heading), 'DM Sans', sans-serif; font-size: 0.82rem; font-weight: 600; text-decoration: none; transition: all 0.25s ease; letter-spacing: 0.01em; }
.cta-whatsapp { background: #25d366; color: #fff; }
.cta-whatsapp:hover { background: #1da851; transform: translateY(-1px); }
.cta-telegram { background: #0088cc; color: #fff; }
.cta-telegram:hover { background: #006fa3; transform: translateY(-1px); }
.cta-email { background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3); }
.cta-email:hover { background: rgba(255,255,255,0.3); transform: translateY(-1px); }

/* === PRIVACY BAR === */
.privacy-bar { display: flex; align-items: center; justify-content: center; gap: 0.6rem; padding: 0.85rem; margin-bottom: 2.5rem; border-radius: 12px; background: color-mix(in srgb, var(--accent-green) 6%, var(--bg-secondary)); border: 1px solid color-mix(in srgb, var(--accent-green) 20%, var(--border-color)); font-family: var(--font-heading), 'DM Sans', sans-serif; font-size: 0.8rem; color: var(--accent-green); font-weight: 600; letter-spacing: 0.01em; }

/* === INFO CARDS === */
.info-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1rem; margin-bottom: 3rem; }
.info-card { padding: 1.4rem; border-radius: 14px; background: var(--bg-secondary); border: 1.5px solid var(--border-color); transition: all 0.3s ease; overflow: hidden; }
.info-card-image { width: 100%; height: 120px; object-fit: cover; border-radius: 10px; margin-bottom: 0.9rem; display: block; }
.info-card:hover { border-color: var(--accent-primary); box-shadow: var(--shadow-md); }
.info-card h4 { font-family: var(--font-heading), 'DM Sans', sans-serif; font-size: 0.9rem; font-weight: 700; margin-bottom: 0.55rem; color: var(--text-primary); display: flex; align-items: center; gap: 0.45rem; letter-spacing: -0.01em; }
.info-card p { font-size: 0.77rem; color: var(--text-secondary); line-height: 1.65; }
.info-card ul { list-style: none; padding: 0; margin: 0.6rem 0 0; }
.info-card ul li { font-size: 0.74rem; color: var(--text-secondary); padding: 0.25rem 0; display: flex; align-items: center; gap: 0.4rem; line-height: 1.5; }
.info-card ul li::before { content: '→'; color: var(--accent-green); font-weight: 700; }

/* === RESPONSIVE === */
@media (max-width: 1100px) {
  .challenge-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 900px) {
  .stats-bar { grid-template-columns: repeat(2, 1fr); }
  .how-grid { grid-template-columns: repeat(2, 1fr); }
  .counselling-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 700px) {
  .challenge-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 600px) {
  .stats-bar { grid-template-columns: 1fr; }
  .counselling-grid { grid-template-columns: 1fr; }
  .how-grid { grid-template-columns: 1fr; }
  .challenge-grid { grid-template-columns: 1fr; }
  .hero-carousel { height: 300px; }
  .hero-slide-content h1 { font-size: 1.4rem; }
}
</style>

<div class="main-content" style="position:relative;z-index:1;padding:1.5rem;max-width:1200px;margin:0 auto;">

  <!-- PRIVACY BAR -->
  <div class="privacy-bar">
    <i class="lucide-shield-check" style="font-size:1rem"></i>
    Complete Privacy — Your Data Stays Yours. We never sell, share, or store your health information.
  </div>

  <!-- HERO CAROUSEL -->
  <div class="dashboard-hero">
    <div class="hero-carousel" id="heroCarousel">
      <div class="hero-slide active">
        <div class="hero-slide-bg" style="background-image:url('assets/images/mri-brain.jpg')"></div>
        <div class="hero-slide-overlay"></div>
        <div class="hero-slide-content">
          <h1>Advanced Lab Scans & Diagnostics</h1>
          <p>Upload MRI, CT, X-ray, or retinal scans — get AI-assisted insights and specialist review within minutes. Early detection saves lives.</p>
          <a href="index.php?page=lab-scans" class="hero-cta"><i class="lucide-scan"></i> Run Diagnostics</a>
        </div>
      </div>
      <div class="hero-slide">
        <div class="hero-slide-bg" style="background-image:url('assets/images/doctor-consult.jpg')"></div>
        <div class="hero-slide-overlay"></div>
        <div class="hero-slide-content">
          <h1>Personalized Health Consultation</h1>
          <p>One-on-one sessions with health professionals who understand your unique needs. From diagnosis to recovery, we guide you every step.</p>
          <a href="https://wa.me/2347010744142?text=Hi%20Coach%20Ibe!%20I%27d%20like%20to%20arrange%20a%20health%20consultation." class="hero-cta"><i class="lucide-message-circle"></i> Arrange a Consultation</a>
        </div>
      </div>
      <div class="hero-slide">
        <div class="hero-slide-bg" style="background-image:url('assets/images/wellness.jpg')"></div>
        <div class="hero-slide-overlay"></div>
        <div class="hero-slide-content">
          <h1>Regenerative Medicine & Healing</h1>
          <p>PEMF therapy, stem cell protocols, and cutting-edge regenerative technologies that accelerate recovery, reduce pain, and restore cellular health.</p>
          <a href="index.php?page=pemf" class="hero-cta"><i class="lucide-zap"></i> Discover PEMF Therapy</a>
        </div>
      </div>
      <div class="hero-slide">
        <div class="hero-slide-bg" style="background-image:url('assets/images/detox-water.jpg')"></div>
        <div class="hero-slide-overlay"></div>
        <div class="hero-slide-content">
          <h1>Cleanse & Cellular Renewal</h1>
          <p>Medical-grade cleanse programs that flush toxins, restore gut health, and rejuvenate your body from the inside out. Feel lighter, think clearer.</p>
          <a href="index.php?page=conditions" class="hero-cta"><i class="lucide-droplets"></i> Explore Cleanse Programs</a>
        </div>
      </div>
      <div class="hero-slide">
        <div class="hero-slide-bg" style="background-image:url('assets/images/meditation.jpg')"></div>
        <div class="hero-slide-overlay"></div>
        <div class="hero-slide-content">
          <h1>Mental Health & Emotional Well-being</h1>
          <p>Professional counselling for stress, anxiety, recovery mindset, and emotional resilience. Your mental health is as important as your physical health.</p>
          <a href="https://wa.me/2347010744142?text=Hi%20Coach%20Ibe!%20I%27d%20like%20to%20arrange%20a%20counselling%20session." class="hero-cta"><i class="lucide-brain"></i> Arrange a Session</a>
        </div>
      </div>
    </div>
  </div>

  <!-- STATS -->
  <div class="stats-bar">
    <div class="stat-item"><div class="stat-icon green"><i class="lucide-users"></i></div><div><div class="stat-value">500+</div><div class="stat-label">People Transformed</div></div></div>
    <div class="stat-item"><div class="stat-icon violet"><i class="lucide-heart-pulse"></i></div><div><div class="stat-value">5</div><div class="stat-label">Counselling Programs</div></div></div>
    <div class="stat-item"><div class="stat-icon teal"><i class="lucide-scan"></i></div><div><div class="stat-value">5</div><div class="stat-label">Medical Challenges</div></div></div>
    <div class="stat-item"><div class="stat-icon amber"><i class="lucide-shield-check"></i></div><div><div class="stat-value">100%</div><div class="stat-label">Confidential</div></div></div>
  </div>

  <!-- COACHING SERVICES (4 cards) -->
  <div class="section-header">
    <h2 class="section-title"><i class="lucide-heart-handshake"></i> Counselling & Wellness Programs</h2>
  </div>
  <div class="counselling-grid">
    <!-- LIFE COACHING -->
    <div class="counselling-card" onclick="window.location='index.php?page=conditions'">
      <img src="assets/images/life-counselling.jpg" alt="" class="counselling-card-image" loading="lazy">
      <div class="counselling-card-icon" style="background:color-mix(in srgb, var(--accent-green) 12%, transparent);color:var(--accent-green)"><i class="lucide-sun"></i></div>
      <div class="counselling-card-title">Life Counselling</div>
      <div class="counselling-card-desc">Discover your purpose, overcome limiting beliefs, and build a life aligned with your deepest values. Sessions cover goal-setting, confidence, relationships, and personal growth.</div>
      <div class="counselling-card-tags">
        <span class="counselling-tag green">Goal Setting</span>
        <span class="counselling-tag green">Mindset Shift</span>
        <span class="counselling-tag green">Confidence</span>
        <span class="counselling-tag green">Purpose</span>
      </div>
    </div>
    <!-- HEALTH COACHING -->
    <div class="counselling-card" onclick="window.location='index.php?page=conditions'">
      <img src="assets/images/health-counselling.jpg" alt="" class="counselling-card-image" loading="lazy">
      <div class="counselling-card-icon" style="background:color-mix(in srgb, var(--accent-primary) 12%, transparent);color:var(--accent-primary)"><i class="lucide-heart-pulse"></i></div>
      <div class="counselling-card-title">Health Counselling</div>
      <div class="counselling-card-desc">Regain control of your health with personalized nutrition plans, lifestyle optimization, and regenerative therapy guidance. We address root causes, not just symptoms.</div>
      <div class="counselling-card-tags">
        <span class="counselling-tag teal">Nutrition</span>
        <span class="counselling-tag teal">Lifestyle</span>
        <span class="counselling-tag teal">Recovery</span>
        <span class="counselling-tag teal">Prevention</span>
      </div>
    </div>
    <!-- WELLNESS TECH -->
    <div class="counselling-card" onclick="window.location='index.php?page=pemf'">
      <img src="assets/images/wellness.jpg" alt="" class="counselling-card-image" loading="lazy">
      <div class="counselling-card-icon" style="background:color-mix(in srgb, var(--accent-violet) 12%, transparent);color:var(--accent-violet)"><i class="lucide-zap"></i></div>
      <div class="counselling-card-title">Wellness Tech</div>
      <div class="counselling-card-desc">Experience PEMF therapy, red light therapy, and biofeedback devices — cutting-edge wellness technology that accelerates healing, reduces pain, and boosts cellular energy.</div>
      <div class="counselling-card-tags">
        <span class="counselling-tag violet">PEMF</span>
        <span class="counselling-tag violet">Red Light</span>
        <span class="counselling-tag violet">Biofeedback</span>
        <span class="counselling-tag violet">Cellular</span>
      </div>
    </div>
    <!-- MEDICAL DIAGNOSTICS -->
    <div class="counselling-card" onclick="window.location='index.php?page=lab-scans'">
      <img src="assets/images/mri-brain.jpg" alt="" class="counselling-card-image" loading="lazy">
      <div class="counselling-card-icon" style="background:color-mix(in srgb, #f59e0b 12%, transparent);color:#f59e0b"><i class="lucide-scan"></i></div>
      <div class="counselling-card-title">Medical Diagnostics</div>
      <div class="counselling-card-desc">Upload MRI, CT, X-ray, retinal, prostate, or fertility scans for AI-assisted analysis and specialist review. Get actionable insights within minutes, not days.</div>
      <div class="counselling-card-tags">
        <span class="counselling-tag amber">MRI</span>
        <span class="counselling-tag amber">CT Scan</span>
        <span class="counselling-tag amber">X-Ray</span>
        <span class="counselling-tag amber">Retinal</span>
      </div>
    </div>
    <!-- DETOXIFICATION -->
    <div class="counselling-card" onclick="window.location='index.php?page=conditions'">
      <img src="assets/images/detox-water.jpg" alt="" class="counselling-card-image" loading="lazy">
      <div class="counselling-card-icon" style="background:color-mix(in srgb, #10b981 12%, transparent);color:#10b981"><i class="lucide-droplets"></i></div>
      <div class="counselling-card-title">Cleanse</div>
      <div class="counselling-card-desc">Medical-grade cleanse programs that flush toxins, restore gut health, and rejuvenate your body. Includes IV therapy, herbal cleanses, and nutritional support for cellular renewal.</div>
      <div class="counselling-card-tags">
        <span class="counselling-tag green">IV Therapy</span>
        <span class="counselling-tag green">Gut Reset</span>
        <span class="counselling-tag green">Herbal Cleanse</span>
        <span class="counselling-tag green">Cellular</span>
      </div>
    </div>
  </div>

  <!-- TESTS & THERAPIES -->
  <div class="section-header">
    <h2 class="section-title"><i class="lucide-stethoscope"></i> Tests & Therapies</h2>
    <a href="index.php?page=conditions" style="font-size:0.78rem;color:var(--accent-primary);text-decoration:none;font-weight:600">View All →</a>
  </div>
  <div class="challenge-grid">
    <div class="challenge-card" onclick="window.location='index.php?page=lab-scans&type=knee'">
      <img src="assets/images/mri-knee.jpg" alt="Knee MRI Analysis" class="challenge-card-image" loading="lazy">
      <div class="challenge-card-body">
        <div class="challenge-card-title">Knee Joint MRI</div>
        <div class="challenge-card-sub">Meniscus, ligament, cartilage & alignment analysis</div>
        <span class="challenge-card-cta">Run Analysis →</span>
      </div>
    </div>
    <div class="challenge-card" onclick="window.location='index.php?page=lab-scans&type=retina'">
      <img src="assets/images/retina-scan.jpg" alt="Retinal Lab Scans" class="challenge-card-image" loading="lazy">
      <div class="challenge-card-body">
        <div class="challenge-card-title">Retinal Lab Scans</div>
        <div class="challenge-card-sub">Optical coherence & diabetic retinopathy screening</div>
        <span class="challenge-card-cta">Run Analysis →</span>
      </div>
    </div>
    <div class="challenge-card" onclick="window.location='index.php?page=lab-scans?type=male-fertility'">
      <img src="assets/images/fertility-male.jpg" alt="Male Fertility Assessment" class="challenge-card-image" loading="lazy">
      <div class="challenge-card-body">
        <div class="challenge-card-title">Male Fertility</div>
        <div class="challenge-card-sub">Sperm analysis, hormonal profiling & motility scoring</div>
        <span class="challenge-card-cta">Run Analysis →</span>
      </div>
    </div>
    <div class="challenge-card" onclick="window.location='index.php?page=lab-scans?type=female-fertility'">
      <img src="assets/images/fertility-female.jpg" alt="Female Fertility Assessment" class="challenge-card-image" loading="lazy">
      <div class="challenge-card-body">
        <div class="challenge-card-title">Female Fertility</div>
        <div class="challenge-card-sub">Ovarian reserve, follicular tracking & hormonal balance</div>
        <span class="challenge-card-cta">Run Analysis →</span>
      </div>
    </div>
    <div class="challenge-card" onclick="window.location='index.php?page=lab-scans?type=prostate'">
      <img src="assets/images/prostate-scan.jpg" alt="Prostate Health Assessment" class="challenge-card-image" loading="lazy">
      <div class="challenge-card-body">
        <div class="challenge-card-title">Prostate Health</div>
        <div class="challenge-card-sub">PSA correlation, volumetric analysis & risk stratification</div>
        <span class="challenge-card-cta">Run Analysis →</span>
      </div>
    </div>
  </div>

  <!-- RSS TICKER (smooth L→R marquee) -->
  <div class="ticker-section">
    <div class="ticker-label"><i class="lucide-rss" style="font-size:0.85rem"></i> Health & Wellness Tips</div>
    <div class="ticker-viewport">
      <div class="ticker-track" id="tickerTrack"></div>
    </div>
  </div>

  <!-- HOW IT WORKS -->
  <div class="section-header">
    <h2 class="section-title"><i class="lucide-route"></i> How It Works</h2>
  </div>
  <div class="how-grid">
    <div class="how-step">
      <div class="how-step-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg></div>
      <div class="how-step-num">Step 1</div>
      <div class="how-step-title">Let's Talk</div>
      <div class="how-step-desc">Arrange a free discovery call via WhatsApp or Telegram. We listen to your goals, challenges, and health history.</div>
    </div>
    <div class="how-step">
      <div class="how-step-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg></div>
      <div class="how-step-num">Step 2</div>
      <div class="how-step-title">Find Your Direction</div>
      <div class="how-step-desc">Whether it's counselling, diagnostics, or regenerative therapy — we design a personalized plan just for you.</div>
    </div>
    <div class="how-step">
      <div class="how-step-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg></div>
      <div class="how-step-num">Step 3</div>
      <div class="how-step-title">Grow at Your Pace</div>
      <div class="how-step-desc">Weekly sessions, progress tracking, and continuous support. We move with you, not against you.</div>
    </div>
    <div class="how-step">
      <div class="how-step-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/><path d="M3.22 12H9.5l.5-1 2 4.5 2-7 1.5 3.5h5.27"/></svg></div>
      <div class="how-step-num">Step 4</div>
      <div class="how-step-title">Thrive in Every Area</div>
      <div class="how-step-desc">From mindset to physical health — experience lasting transformation that touches every part of your life.</div>
    </div>
  </div>

  <!-- EDUCATIONAL INFO CARDS -->
  <div class="section-header">
    <h2 class="section-title"><i class="lucide-book-open"></i> Learn About Regenerative Health</h2>
  </div>
  <div class="info-grid">
    <div class="info-card">
      <img class="info-card-image" src="assets/svg/pemf-waves.svg" alt="PEMF wave illustration">
      <h4><i class="lucide-zap" style="color:var(--accent-violet)"></i> PEMF Therapy</h4>
      <p>Pulsed Electromagnetic Field therapy stimulates cellular repair by delivering low-frequency electromagnetic pulses. Used for chronic pain, bone healing, inflammation, and post-surgical recovery.</p>
      <ul>
        <li>Reduces chronic pain by up to 60%</li>
        <li>Accelerates bone fracture healing</li>
        <li>FDA-cleared for depression treatment</li>
        <li>Zero side effects, non-invasive</li>
      </ul>
    </div>
    <div class="info-card">
      <img class="info-card-image" src="assets/svg/stem-cell.svg" alt="Stem cell illustration">
      <h4><i class="lucide-dna" style="color:var(--accent-green)"></i> Stem Cell Therapy</h4>
      <p>Regenerative medicine uses your body's own stem cells to repair damaged tissue. Effective for joint injuries, degenerative conditions, and autoimmune disorders.</p>
      <ul>
        <li>Autologous — uses your own cells</li>
        <li>Treats osteoarthritis without surgery</li>
        <li>Repairs cartilage and ligament damage</li>
        <li>Minimal downtime, outpatient procedure</li>
      </ul>
    </div>
    <div class="info-card">
      <img class="info-card-image" src="assets/images/meditation.jpg" alt="Cognitive wellness">
      <h4><i class="lucide-brain" style="color:var(--accent-primary)"></i> Cognitive Counselling</h4>
      <p>Neuroscience-backed techniques to improve focus, memory, emotional regulation, and decision-making. Ideal for executives, students, and anyone seeking mental optimization.</p>
      <ul>
        <li>Improves working memory by 30%</li>
        <li>Reduces anxiety and mental fog</li>
        <li>Builds resilient thinking patterns</li>
        <li>Personalized brain-training protocols</li>
      </ul>
    </div>
    <div class="info-card">
      <img class="info-card-image" src="assets/images/healthy-food.jpg" alt="Nutritional medicine">
      <h4><i class="lucide-apple" style="color:#f59e0b"></i> Nutritional Medicine</h4>
      <p>Food is medicine. We create personalized nutrition plans based on your lab results, genetics, and health goals — addressing deficiencies at the cellular level.</p>
      <ul>
        <li>Blood panel-guided recommendations</li>
        <li>Gut health optimization</li>
        <li>Anti-inflammatory diet protocols</li>
        <li>Supplement stacking guidance</li>
      </ul>
    </div>
    <div class="info-card">
      <img class="info-card-image" src="assets/images/detox-water.jpg" alt="Cleanse therapy">
      <h4><i class="lucide-leaf" style="color:#16a34a"></i> Cleanse Sessions</h4>
      <p>Guided detox programs that cleanse the body at the cellular level — flushing accumulated toxins, resetting the gut, and restoring natural energy flow for full-body renewal.</p>
      <ul>
        <li>IV vitamin &amp; mineral therapy</li>
        <li>Gut microbiome reset protocols</li>
        <li>Herbal liver &amp; kidney cleanse</li>
        <li>Heavy-metal chelation support</li>
      </ul>
    </div>
  </div>

  <!-- TESTIMONIALS -->
  <div class="section-header">
    <h2 class="section-title"><i class="lucide-message-circle"></i> Real Stories, Real Results</h2>
  </div>
  <div class="testimonial-grid">
    <div class="testimonial-card">
      <div class="testimonial-stars">★★★★★</div>
      <div class="testimonial-text">"Coach Ibe helped me rediscover my purpose after a devastating knee injury. The combination of life counselling and regenerative therapy got me back on my feet — literally and figuratively."</div>
      <div class="testimonial-author"><div class="testimonial-avatar">AO</div><div><div class="testimonial-name">Adaeze O.</div><div class="testimonial-role">Entrepreneur, Lagos</div></div></div>
    </div>
    <div class="testimonial-card">
      <div class="testimonial-stars">★★★★★</div>
      <div class="testimonial-text">"I was skeptical about PEMF therapy, but after 6 sessions my chronic back pain went from 8/10 to 2/10. The AI diagnostic report was incredibly detailed and gave my doctor real insights."</div>
      <div class="testimonial-author"><div class="testimonial-avatar">KA</div><div><div class="testimonial-name">Kemi A.</div><div class="testimonial-role">Teacher, Abuja</div></div></div>
    </div>
    <div class="testimonial-card">
      <div class="testimonial-stars">★★★★★</div>
      <div class="testimonial-text">"The health counselling transformed my relationship with food. I lost 15kg in 4 months, my blood pressure normalized, and I have energy I haven't felt since my 20s."</div>
      <div class="testimonial-author"><div class="testimonial-avatar">TM</div><div><div class="testimonial-name">Tunde M.</div><div class="testimonial-role">Engineer, Port Harcourt</div></div></div>
    </div>
    <div class="testimonial-card">
      <div class="testimonial-stars">★★★★★</div>
      <div class="testimonial-text">"After years of fertility struggles, the male fertility assessment gave us answers no other clinic could. The team was professional, compassionate, and the analysis was thorough."</div>
      <div class="testimonial-author"><div class="testimonial-avatar">NE</div><div><div class="testimonial-name">Ngozi E.</div><div class="testimonial-role">Nurse, Enugu</div></div></div>
    </div>
    <div class="testimonial-card">
      <div class="testimonial-stars">★★★★★</div>
      <div class="testimonial-text">"Coach Ibe's approach to wellness is holistic — mind, body, spirit. The stem cell therapy for my knee was painless and I was walking normally within weeks. Truly life-changing."</div>
      <div class="testimonial-author"><div class="testimonial-avatar">CU</div><div><div class="testimonial-name">Chidi U.</div><div class="testimonial-role">Business Owner, Owerri</div></div></div>
    </div>
    <div class="testimonial-card">
      <div class="testimonial-stars">★★★★★</div>
      <div class="testimonial-text">"The retinal scan picked up early signs of diabetic retinopathy that my optometrist missed. Early detection saved my vision. This platform is a miracle for healthcare in Nigeria."</div>
      <div class="testimonial-author"><div class="testimonial-avatar">FB</div><div><div class="testimonial-name">Fatima B.</div><div class="testimonial-role">Civil Servant, Kaduna</div></div></div>
    </div>
  </div>

  <!-- CTA -->
  <div class="cta-section">
    <h2>Ready to Transform Your Health & Life?</h2>
    <p>Connect with Coach Ibe — available online worldwide and in-person across Nigeria. Your first discovery session is free.</p>
    <div class="cta-links">
      <a href="https://wa.me/2347010744142?text=Hi%20Coach%20Ibe!%20I%27m%20interested%20in%20your%20counselling%20and%20regenerative%20health%20services." class="cta-link cta-whatsapp"><i class="lucide-message-circle"></i> WhatsApp (+234 701 074 4142)</a>
      <a href="https://t.me/coachandheal" class="cta-link cta-telegram"><i class="lucide-send"></i> Telegram</a>
      <a href="mailto:Ibe@coachandheal.store" class="cta-link cta-email"><i class="lucide-mail"></i> Ibe@coachandheal.store</a>
    </div>
  </div>

</div>

<script>
// Hero carousel
(function(){
  const slides = document.querySelectorAll('#heroCarousel .hero-slide');
  if (!slides.length) return;
  let current = 0;
  setInterval(() => {
    slides[current].classList.remove('active');
    current = (current + 1) % slides.length;
    slides[current].classList.add('active');
  }, 5000);
})();

// RSS Ticker — smooth continuous marquee
(function(){
  const track = document.getElementById('tickerTrack');
  if (!track) return;
  const tips = <?= $tipJson ?>;
  // Render items twice for seamless loop
  function renderItems() {
    let html = '';
    tips.forEach(tip => {
      html += '<span class="ticker-item">' + tip + '</span>';
    });
    track.innerHTML = html;
  }
  renderItems();

  // Calculate duration based on content width
  function calcDuration() {
    const w = track.scrollWidth / 2;
    return Math.max(20, w / 40); // ~40px per second
  }
  function applyDuration() {
    const dur = calcDuration();
    track.style.setProperty('--ticker-duration', dur + 's');
    track.style.animationDuration = dur + 's';
  }
  // Apply after render
  requestAnimationFrame(() => { requestAnimationFrame(applyDuration); });
  window.addEventListener('resize', applyDuration);
})();
</script>
