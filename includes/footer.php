<?php
if (!VERCEL_MODE && session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($newsFeed)) $newsFeed = [];
if (!isset($app_version)) $app_version = '3.0';

// Prepare news items for marquee (duplicate for seamless loop)
$marqueeItems = [];
if (!empty($newsFeed)) {
  foreach (array_slice($newsFeed, 0, 8) as $news) {
    $marqueeItems[] = [
      'title' => htmlspecialchars($news['title'] ?? ''),
      'link' => htmlspecialchars($news['link'] ?? '#'),
      'source' => htmlspecialchars($news['source'] ?? ''),
      'date' => htmlspecialchars($news['date'] ?? ''),
    ];
  }
}
// Fallback health news if RSS hasn't loaded yet
if (empty($marqueeItems)) {
  $fallbackNews = [
    ['title' => 'New study shows PEMF therapy reduces chronic pain by 60%', 'source' => 'Medical News Today', 'link' => '#'],
    ['title' => 'Stem cell therapy shows promise for knee osteoarthritis recovery', 'source' => 'ScienceDaily', 'link' => '#'],
    ['title' => 'AI-assisted retinal screening detects diabetic retinopathy early', 'source' => 'WHO', 'link' => '#'],
    ['title' => 'Regenerative medicine advances in fertility treatment', 'source' => 'Mayo Clinic', 'link' => '#'],
    ['title' => 'Nutritional medicine: How diet impacts chronic disease recovery', 'source' => 'Healthline', 'link' => '#'],
    ['title' => 'Mental health counselling improves post-surgical recovery outcomes', 'source' => 'NIH', 'link' => '#'],
    ['title' => 'New MRI techniques enhance prostate cancer detection accuracy', 'source' => 'The Lancet', 'link' => '#'],
    ['title' => 'Biofeedback devices show effectiveness in stress reduction', 'source' => 'WebMD', 'link' => '#'],
  ];
  foreach ($fallbackNews as $n) {
    $marqueeItems[] = [
      'title' => htmlspecialchars($n['title']),
      'link' => $n['link'],
      'source' => htmlspecialchars($n['source']),
      'date' => '',
    ];
  }
}
$marqueeJson = json_encode($marqueeItems);
?>
<style>
.footer-marquee-wrap {
  position: relative;
  overflow: hidden;
  border-top: 1px solid var(--border-color);
  border-bottom: 1px solid var(--border-color);
  background: var(--bg-tertiary);
  padding: 0.5rem 0;
  margin-bottom: 1.5rem;
}
.footer-marquee-wrap::before,
.footer-marquee-wrap::after {
  content: '';
  position: absolute;
  top: 0;
  bottom: 0;
  width: 40px;
  z-index: 2;
  pointer-events: none;
}
.footer-marquee-wrap::before { left: 0; background: linear-gradient(to right, var(--bg-tertiary), transparent); }
.footer-marquee-wrap::after { right: 0; background: linear-gradient(to left, var(--bg-tertiary), transparent); }

.footer-marquee-track {
  display: flex;
  gap: 2rem;
  animation: footerMarqueeScroll var(--footer-marquee-duration, 35s) linear infinite;
  will-change: transform;
  width: max-content;
}
.footer-marquee-track:hover { animation-play-state: paused; }

.footer-marquee-item {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.3rem 0.85rem;
  border-radius: 8px;
  font-size: 0.72rem;
  color: var(--text-secondary);
  white-space: nowrap;
  background: var(--bg-secondary);
  border: 1px solid transparent;
  transition: all 0.2s ease;
  flex-shrink: 0;
  text-decoration: none;
}
.footer-marquee-item:hover {
  border-color: var(--accent-primary);
  color: var(--text-primary);
}
.footer-marquee-item::before {
  content: '';
  width: 5px;
  height: 5px;
  border-radius: 50%;
  background: var(--accent-green);
  flex-shrink: 0;
}
.footer-marquee-source {
  font-size: 0.6rem;
  font-weight: 600;
  color: var(--accent-primary);
  margin-left: 0.25rem;
}

@keyframes footerMarqueeScroll {
  0% { transform: translate3d(0, 0, 0); }
  100% { transform: translate3d(-50%, 0, 0); }
}
</style>

<footer style="position:relative;z-index:1;margin-top:3rem;padding:2.5rem 1.5rem 1.5rem;background:var(--bg-secondary);border-top:1px solid var(--border-color);">
  <div style="max-width:1200px;margin:0 auto;">

    <!-- STREAMING RSS NEWS MARQUEE -->
    <div class="footer-marquee-wrap">
      <div class="footer-marquee-track" id="footerMarquee"></div>
    </div>

    <div style="display:grid;grid-template-columns:1.5fr 1fr 1fr;gap:2rem;margin-bottom:2rem;">
      <!-- Brand & Description -->
      <div>
        <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.75rem;">
          <img src="assets/svg/logo.svg" alt="Logo" style="height:28px;width:auto;">
          <span style="font-weight:800;font-size:1rem;background:linear-gradient(135deg,var(--accent-green),var(--accent-violet));-webkit-background-clip:text;-webkit-text-fill-color:transparent;letter-spacing:-0.02em;">Regen Med Health</span>
        </div>
        <div style="font-size:0.7rem;color:var(--text-secondary);margin-bottom:0.6rem;letter-spacing:0.04em;font-weight:500;">A Coach &amp; Heal App — Ibereal Enterprise</div>
        <p style="font-size:0.78rem;color:var(--text-secondary);line-height:1.65;margin-bottom:0.75rem;">Empowering growth in life, health, and wellness. Personalized counselling, regenerative medicine, and medical diagnostics — available online worldwide and in-person across Nigeria.</p>
        <div style="display:flex;gap:0.5rem;margin-bottom:0.75rem;flex-wrap:wrap;">
          <span style="padding:0.2rem 0.6rem;background:color-mix(in srgb,var(--accent-green) 10%,transparent);color:var(--accent-green);font-size:0.65rem;border-radius:6px;font-weight:600;">HIPAA Aware</span>
          <span style="padding:0.2rem 0.6rem;background:color-mix(in srgb,var(--accent-primary) 10%,transparent);color:var(--accent-primary);font-size:0.65rem;border-radius:6px;font-weight:600;">100% Confidential</span>
          <span style="padding:0.2rem 0.6rem;background:color-mix(in srgb,var(--accent-violet) 10%,transparent);color:var(--accent-violet);font-size:0.65rem;border-radius:6px;font-weight:600;">AI-Powered</span>
        </div>
        <div style="display:flex;flex-direction:column;gap:0.35rem;">
          <a href="https://wa.me/2347010744142" style="font-size:0.73rem;color:var(--text-secondary);text-decoration:none;display:flex;align-items:center;gap:0.4rem;"><i class="lucide-phone" style="font-size:0.85rem;color:var(--accent-green)"></i> +234 701 074 4142 (WhatsApp)</a>
          <a href="mailto:Ibe@coachandheal.store" style="font-size:0.73rem;color:var(--text-secondary);text-decoration:none;display:flex;align-items:center;gap:0.4rem;"><i class="lucide-mail" style="font-size:0.85rem;color:var(--accent-primary)"></i> Ibe@coachandheal.store</a>
          <a href="https://t.me/coachandheal" style="font-size:0.73rem;color:var(--text-secondary);text-decoration:none;display:flex;align-items:center;gap:0.4rem;"><i class="lucide-send" style="font-size:0.85rem;color:var(--accent-violet)"></i> Telegram: @coachandheal</a>
        </div>
      </div>

      <!-- Challenges -->
      <div>
        <h4 style="font-size:0.78rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-primary);margin-bottom:0.75rem;">Challenges</h4>
        <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:0.4rem;">
          <li><a href="index.php?page=diagnostics&type=knee" style="font-size:0.75rem;color:var(--text-secondary);text-decoration:none;transition:color 0.2s;">Knee Joint MRI</a></li>
          <li><a href="index.php?page=diagnostics&type=retina" style="font-size:0.75rem;color:var(--text-secondary);text-decoration:none;transition:color 0.2s;">Retinal Imaging</a></li>
          <li><a href="index.php?page=diagnostics?type=male-fertility" style="font-size:0.75rem;color:var(--text-secondary);text-decoration:none;transition:color 0.2s;">Male Fertility</a></li>
          <li><a href="index.php?page=diagnostics?type=female-fertility" style="font-size:0.75rem;color:var(--text-secondary);text-decoration:none;transition:color 0.2s;">Female Fertility</a></li>
          <li><a href="index.php?page=diagnostics?type=prostate" style="font-size:0.75rem;color:var(--text-secondary);text-decoration:none;transition:color 0.2s;">Prostate Health</a></li>
        </ul>
      </div>

      <!-- Resources -->
      <div>
        <h4 style="font-size:0.78rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-primary);margin-bottom:0.75rem;">Resources</h4>
        <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:0.4rem;">
          <li><a href="index.php?page=diagnostics" style="font-size:0.75rem;color:var(--text-secondary);text-decoration:none;transition:color 0.2s;">Imaging Protocols</a></li>
          <li><a href="index.php?page=protocols" style="font-size:0.75rem;color:var(--text-secondary);text-decoration:none;transition:color 0.2s;">Treatment Protocols</a></li>
          <li><a href="index.php?page=supplements" style="font-size:0.75rem;color:var(--text-secondary);text-decoration:none;transition:color 0.2s;">Supplement Database</a></li>
          <li><a href="index.php?page=pemf" style="font-size:0.75rem;color:var(--text-secondary);text-decoration:none;transition:color 0.2s;">PEMF Therapy</a></li>
          <li><a href="index.php?page=stem-cells" style="font-size:0.75rem;color:var(--text-secondary);text-decoration:none;transition:color 0.2s;">Stem Cell Therapy</a></li>
          <li><a href="index.php?page=references" style="font-size:0.75rem;color:var(--text-secondary);text-decoration:none;transition:color 0.2s;">Clinical References</a></li>
          <li><a href="index.php?page=team" style="font-size:0.75rem;color:var(--text-secondary);text-decoration:none;transition:color 0.2s;">Team / About</a></li>
          <li><a href="index.php?page=faq" style="font-size:0.75rem;color:var(--text-secondary);text-decoration:none;transition:color 0.2s;">FAQ</a></li>
        </ul>
      </div>
    </div>

    <!-- Bottom bar -->
    <div style="border-top:1px solid var(--border-color);padding-top:1rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
      <p style="font-size:0.65rem;color:var(--text-secondary);">© <?= date('Y') ?> Regen Med Health — A Coach & Heal App by Coach Ibe / Ibereal Enterprise. For research and educational purposes only. Not a substitute for professional medical advice.</p>
      <p style="font-size:0.65rem;color:var(--text-secondary);">Version <?= $app_version ?> | Powered by Ibereal Enterprise</p>
    </div>
  </div>
</footer>

<script>
(function(){
  var track = document.getElementById('footerMarquee');
  if (!track) return;
  var items = <?= $marqueeJson ?>;
  // Render items twice for seamless infinite loop
  function render() {
    var html = '';
    var allItems = items.concat(items);
    allItems.forEach(function(item) {
      var label = item.title;
      if (item.source) label += ' <span class="footer-marquee-source">· ' + item.source + '</span>';
      html += '<a href="' + item.link + '" target="_blank" rel="noopener" class="footer-marquee-item">' + label + '</a>';
    });
    track.innerHTML = html;
  }
  render();
  // Calculate duration based on content width
  function calcDuration() {
    var w = track.scrollWidth / 2;
    return Math.max(25, w / 35);
  }
  function applyDuration() {
    var dur = calcDuration();
    track.style.setProperty('--footer-marquee-duration', dur + 's');
    track.style.animationDuration = dur + 's';
  }
  requestAnimationFrame(function(){ requestAnimationFrame(applyDuration); });
  window.addEventListener('resize', applyDuration);
})();
</script>
