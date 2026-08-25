<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($newsFeed)) $newsFeed = [];
if (!isset($app_version)) $app_version = '3.0';
?>
<footer style="position:relative;z-index:1;margin-top:3rem;padding:2.5rem 1.5rem 1.5rem;background:var(--bg-secondary);border-top:1px solid var(--border-color);">
  <div style="max-width:1200px;margin:0 auto;">
    <div style="display:grid;grid-template-columns:1.5fr 1fr 1fr;gap:2rem;margin-bottom:2rem;">
      <!-- Brand & Description -->
      <div>
        <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.75rem;">
          <img src="assets/svg/logo.svg" alt="Logo" style="height:28px;width:auto;">
          <span style="font-weight:700;font-size:0.95rem;background:linear-gradient(135deg,var(--accent-green),var(--accent-violet));-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Coach & Heal — Regen Med Health</span>
        </div>
        <p style="font-size:0.75rem;color:var(--text-secondary);line-height:1.6;margin-bottom:0.75rem;">Empowering growth in life, health, and wellness. Personalized coaching, regenerative medicine, and medical diagnostics — available online worldwide and in-person across Nigeria.</p>
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
        <h4 style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-primary);margin-bottom:0.75rem;">Challenges</h4>
        <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:0.4rem;">
          <li><a href="index.php?page=diagnostics&type=knee" style="font-size:0.73rem;color:var(--text-secondary);text-decoration:none;">Knee Joint MRI</a></li>
          <li><a href="index.php?page=diagnostics&type=retina" style="font-size:0.73rem;color:var(--text-secondary);text-decoration:none;">Retinal Imaging</a></li>
          <li><a href="index.php?page=diagnostics?type=male-fertility" style="font-size:0.73rem;color:var(--text-secondary);text-decoration:none;">Male Fertility</a></li>
          <li><a href="index.php?page=diagnostics?type=female-fertility" style="font-size:0.73rem;color:var(--text-secondary);text-decoration:none;">Female Fertility</a></li>
          <li><a href="index.php?page=diagnostics?type=prostate" style="font-size:0.73rem;color:var(--text-secondary);text-decoration:none;">Prostate Health</a></li>
        </ul>
      </div>

      <!-- Resources -->
      <div>
        <h4 style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-primary);margin-bottom:0.75rem;">Resources</h4>
        <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:0.4rem;">
          <li><a href="index.php?page=diagnostics" style="font-size:0.73rem;color:var(--text-secondary);text-decoration:none;">Imaging Protocols</a></li>
          <li><a href="index.php?page=protocols" style="font-size:0.73rem;color:var(--text-secondary);text-decoration:none;">Treatment Protocols</a></li>
          <li><a href="index.php?page=supplements" style="font-size:0.73rem;color:var(--text-secondary);text-decoration:none;">Supplement Database</a></li>
          <li><a href="index.php?page=vps" style="font-size:0.73rem;color:var(--text-secondary);text-decoration:none;">GPU Cloud Providers</a></li>
          <li><a href="index.php?page=references" style="font-size:0.73rem;color:var(--text-secondary);text-decoration:none;">Clinical References</a></li>
        </ul>
      </div>
    </div>

    <!-- News Feed -->
    <?php if (!empty($newsFeed)): ?>
    <div style="border-top:1px solid var(--border-color);padding-top:1.5rem;margin-bottom:1.5rem;">
      <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem;">
        <i class="lucide-newspaper" style="font-size:0.9rem;color:var(--accent-violet)"></i>
        <h4 style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-primary);">News & Best Practices</h4>
        <span style="font-size:0.65rem;color:var(--text-secondary);">· Latest in regenerative medicine</span>
      </div>
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:0.75rem;">
        <?php foreach (array_slice($newsFeed, 0, 6) as $news): ?>
        <a href="<?= htmlspecialchars($news['link'] ?? '#') ?>" target="_blank" rel="noopener" style="display:block;padding:0.85rem;border-radius:10px;background:var(--bg-tertiary);border:1px solid var(--border-color);text-decoration:none;transition:all 0.2s ease;">
          <p style="font-size:0.75rem;font-weight:600;color:var(--text-primary);margin-bottom:0.35rem;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"><?= htmlspecialchars($news['title'] ?? '') ?></p>
          <?php if (!empty($news['description'])): ?>
          <p style="font-size:0.68rem;color:var(--text-secondary);margin-bottom:0.35rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"><?= htmlspecialchars(mb_substr($news['description'], 0, 100)) ?>…</p>
          <?php endif; ?>
          <div style="display:flex;align-items:center;gap:0.4rem;">
            <span style="font-size:0.65rem;color:var(--accent-primary);font-weight:600;"><?= htmlspecialchars($news['source'] ?? '') ?></span>
            <?php if (!empty($news['date'])): ?>
            <span style="font-size:0.6rem;color:var(--text-secondary);">· <?= htmlspecialchars($news['date']) ?></span>
            <?php endif; ?>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Bottom bar -->
    <div style="border-top:1px solid var(--border-color);padding-top:1rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
      <p style="font-size:0.65rem;color:var(--text-secondary);">© <?= date('Y') ?> Coach & Heal — Regen Med Health by Coach Ibe / Ibereal Enterprise. For research and educational purposes only. Not a substitute for professional medical advice.</p>
      <p style="font-size:0.65rem;color:var(--text-secondary);">Version <?= $app_version ?> | Powered by Ibereal Enterprise</p>
    </div>
  </div>
</footer>
