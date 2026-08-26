<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($app_version)) $app_version = '3.0';
if (!isset($theme_manager)) { include __DIR__ . '/theme-manager.php'; $theme_manager = ThemeManager::getInstance(); }
$set = $theme_manager->getSettings();
if (!isset($current_user)) $current_user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?= $theme_manager->getThemeName() ?>" data-color-scheme="<?= $theme_manager->getColorScheme() ?>" data-density="<?= $theme_manager->getDensity() ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coach & Heal — Regen Med Health</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide-static@0.263.1/font/lucide.min.css">
  <link rel="stylesheet" href="assets/css/animations.css">
  <link rel="icon" type="image/svg+xml" href="assets/svg/logo.svg">
  <style>
    :root {
      --accent-primary: <?= $set['accent_primary'] ?>;
      --accent-secondary: <?= $set['accent_secondary'] ?>;
      --accent-green: <?= $set['accent_green'] ?>;
      --accent-violet: <?= $set['accent_violet'] ?>;
      --text-primary: <?= $set['text_primary'] ?>;
      --text-secondary: <?= $set['text_secondary'] ?>;
      --bg-primary: <?= $set['bg_primary'] ?>;
      --bg-secondary: <?= $set['bg_secondary'] ?>;
      --bg-tertiary: <?= $set['bg_tertiary'] ?>;
      --border-color: <?= $set['border_color'] ?>;
      --shadow-sm: <?= $set['shadow_sm'] ?>;
      --shadow-md: <?= $set['shadow_md'] ?>;
      --shadow-lg: <?= $set['shadow_lg'] ?>;
      --radius: <?= $set['radius'] ?>;
      --font-heading: <?= $set['font_heading'] ?>;
      --font-body: <?= $set['font_body'] ?>;
      --wave-color-1: <?= $set['wave_color_1'] ?>;
      --wave-color-2: <?= $set['wave_color_2'] ?>;
      --wave-opacity: <?= $set['wave_opacity'] ?>;
      --header-height: 64px;
    }
    [data-theme="greenspectrum"] { --wave-color-1: #22c55e; --wave-color-2: #16a34a; }
    [data-theme="oceanbreeze"] { --wave-color-1: #06b6d4; --wave-color-2: #0891b2; }
    [data-theme="violetwave"] { --wave-color-1: #8b5cf6; --wave-color-2: #7c3aed; }
    [data-theme="aurora"] { --wave-color-1: #22c55e; --wave-color-2: #8b5cf6; }

    body { font-family: var(--font-body), sans-serif; color: var(--text-primary); background: var(--bg-primary); margin: 0; padding: 0; }
    h1,h2,h3,h4,h5,h6 { font-family: var(--font-heading), sans-serif; margin: 0; }

    /* === HEADER === */
    .header {
      position: sticky; top: 0; z-index: 100;
      height: var(--header-height);
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 1.5rem;
      background: var(--bg-secondary);
      border-bottom: 1px solid var(--border-color);
      box-shadow: var(--shadow-sm);
      backdrop-filter: blur(12px);
    }
    .header-left { display: flex; align-items: center; gap: 1rem; }
    .header-brand { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: var(--text-primary); }
    .header-brand img { height: 36px; width: auto; }
    .header-brand-text { display: flex; flex-direction: column; line-height: 1.2; }
    .header-brand-name { font-weight: 700; font-size: 1rem; background: linear-gradient(135deg, var(--accent-green), var(--accent-violet)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .header-brand-sub { font-size: 0.65rem; color: var(--text-secondary); letter-spacing: 0.05em; }

    .header-center { flex: 1; display: flex; justify-content: center; }
    .nav-links { display: flex; gap: 0.25rem; list-style: none; margin: 0; padding: 0; flex-wrap: nowrap; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .nav-links li a {
      display: flex; align-items: center; gap: 0.35rem;
      padding: 0.45rem 0.75rem; border-radius: 8px;
      font-size: 0.78rem; font-weight: 500; white-space: nowrap;
      color: var(--text-secondary); text-decoration: none;
      transition: all 0.2s ease;
    }
    .nav-links li a:hover { background: var(--bg-tertiary); color: var(--text-primary); }
    .nav-links li a.active { background: var(--accent-primary); color: #fff; }
    .nav-links li a i { font-size: 1rem; }

    .header-right { display: flex; align-items: center; gap: 0.75rem; }
    .header-btn {
      display: flex; align-items: center; justify-content: center;
      width: 36px; height: 36px; border-radius: 8px;
      border: 1px solid var(--border-color); background: var(--bg-secondary);
      color: var(--text-secondary); cursor: pointer; font-size: 1rem;
      transition: all 0.2s ease;
    }
    .header-btn:hover { background: var(--bg-tertiary); color: var(--text-primary); }
    .header-btn.active { background: var(--accent-primary); color: #fff; border-color: var(--accent-primary); }
    .hamburger { display: none; }

    /* === MOBILE === */
    @media (max-width: 1024px) {
      .nav-links { display: none; }
      .hamburger { display: flex; }
      .header-center { display: none; }
    }

    /* === THEME PICKER MODAL === */
    .theme-modal {
      position: fixed; inset: 0; z-index: 9999;
      display: none; align-items: center; justify-content: center;
      background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);
    }
    .theme-modal.open { display: flex; }
    .theme-modal-box {
      background: var(--bg-secondary); border: 1px solid var(--border-color);
      border-radius: 16px; padding: 2rem; width: 90%; max-width: 480px;
      box-shadow: var(--shadow-lg);
    }
    .theme-modal-box h3 { margin-bottom: 1.25rem; font-size: 1.1rem; }
    .theme-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
    .theme-card {
      padding: 1rem; border-radius: 12px; border: 2px solid var(--border-color);
      cursor: pointer; transition: all 0.2s ease; background: var(--bg-tertiary);
    }
    .theme-card:hover { border-color: var(--accent-primary); }
    .theme-card.selected { border-color: var(--accent-primary); background: color-mix(in srgb, var(--accent-primary) 10%, var(--bg-tertiary)); }
    .theme-card-name { font-weight: 600; font-size: 0.9rem; margin-bottom: 0.35rem; }
    .theme-card-desc { font-size: 0.75rem; color: var(--text-secondary); }
    .theme-card-colors { display: flex; gap: 6px; margin-top: 0.5rem; }
    .theme-card-swatch { width: 18px; height: 18px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.1); }
    .theme-modal-close {
      margin-top: 1rem; width: 100%; padding: 0.6rem;
      border: none; border-radius: 8px; background: var(--bg-tertiary);
      color: var(--text-primary); cursor: pointer; font-weight: 500;
    }
  </style>
</head>
<body>
  <!-- WAVE BACKGROUND -->
  <div class="wave-bg-container animated">
    <div class="wave-layer wave-layer-1">
      <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
        <path fill="var(--wave-color-1)" fill-opacity="var(--wave-opacity)" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L0,320Z"></path>
        <path fill="var(--wave-color-2)" fill-opacity="var(--wave-opacity)" d="M0,256L48,240C96,224,192,192,288,186.7C384,181,480,203,576,218.7C672,235,768,245,864,229.3C960,213,1056,171,1152,154.7C1248,139,1344,149,1392,154.7L1440,160L1440,320L0,320Z"></path>
        <path fill="var(--wave-color-1)" fill-opacity="var(--wave-opacity)" d="M0,288L48,272C96,256,192,224,288,213.3C384,203,480,213,576,229.3C672,245,768,267,864,261.3C960,256,1056,224,1152,208C1248,192,1344,192,1392,192L1440,192L1440,320L0,320Z"></path>
      </svg>
    </div>
    <div class="wave-spectrum-overlay"></div>
  </div>

  <!-- HEADER -->
  <header class="header">
    <div class="header-left">
      <a href="index.php" class="header-brand">
        <img src="assets/svg/logo.svg" alt="Coach & Heal Logo">
        <div class="header-brand-text">
          <span class="header-brand-name">Coach & Heal</span>
          <span class="header-brand-sub">Regen Med Health</span>
        </div>
      </a>
    </div>

    <nav class="header-center">
      <ul class="nav-links">
        <li><a href="index.php?page=dashboard" class="<?= ($_GET['page'] ?? 'dashboard') === 'dashboard' ? 'active' : '' ?>"><i class="lucide-home"></i> Main Screen</a></li>
        <li><a href="index.php?page=conditions" class="<?= ($_GET['page'] ?? '') === 'conditions' ? 'active' : '' ?>"><i class="lucide-activity"></i> Challenges</a></li>
        <li><a href="index.php?page=diagnostics" class="<?= ($_GET['page'] ?? '') === 'diagnostics' ? 'active' : '' ?>"><i class="lucide-scan"></i> Imaging</a></li>
        <li><a href="index.php?page=protocols" class="<?= ($_GET['page'] ?? '') === 'protocols' ? 'active' : '' ?>"><i class="lucide-file-text"></i> Protocols</a></li>
        <li><a href="index.php?page=supplements" class="<?= ($_GET['page'] ?? '') === 'supplements' ? 'active' : '' ?>"><i class="lucide-capsule"></i> Supplements</a></li>
        <li><a href="index.php?page=pemf" class="<?= ($_GET['page'] ?? '') === 'pemf' ? 'active' : '' ?>"><i class="lucide-zap"></i> PEMF</a></li>
        <li><a href="index.php?page=stemcells" class="<?= ($_GET['page'] ?? '') === 'stemcells' ? 'active' : '' ?>"><i class="lucide-dna"></i> Stem Cells</a></li>
        <li><a href="index.php?page=vps" class="<?= ($_GET['page'] ?? '') === 'vps' ? 'active' : '' ?>"><i class="lucide-server"></i> VPS</a></li>
        <li><a href="index.php?page=data" class="<?= ($_GET['page'] ?? '') === 'data' ? 'active' : '' ?>"><i class="lucide-database"></i> Data</a></li>
        <li><a href="index.php?page=case-study" class="<?= ($_GET['page'] ?? '') === 'case-study' ? 'active' : '' ?>"><i class="lucide-file"></i> Case Study</a></li>
        <li><a href="index.php?page=references" class="<?= ($_GET['page'] ?? '') === 'references' ? 'active' : '' ?>"><i class="lucide-book-open"></i> References</a></li>
        <li><a href="index.php?page=team" class="<?= ($_GET['page'] ?? '') === 'team' ? 'active' : '' ?>"><i class="lucide-users"></i> Team</a></li>
        <li><a href="index.php?page=faq" class="<?= ($_GET['page'] ?? '') === 'faq' ? 'active' : '' ?>"><i class="lucide-help-circle"></i> FAQ</a></li>
      </ul>
    </nav>

    <div class="header-right">
      <button class="header-btn" id="themeToggle" title="Choose Theme" onclick="document.getElementById('themeModal').classList.add('open')"><i class="lucide-palette"></i></button>
      <button class="header-btn" id="darkModeToggle" title="Toggle Dark Mode"><i class="lucide-moon"></i></button>
      <button class="header-btn hamburger" id="menuToggle" title="Menu"><i class="lucide-menu"></i></button>
      <?php if ($current_user): ?>
        <span style="font-size:0.8rem;color:var(--text-secondary)"><?= htmlspecialchars($current_user['name'] ?? $current_user['email']) ?></span>
        <a href="index.php?action=logout" class="header-btn" title="Logout" style="text-decoration:none"><i class="lucide-log-out"></i></a>
      <?php endif; ?>
    </div>
  </header>

  <!-- THEME PICKER MODAL -->
  <div class="theme-modal" id="themeModal">
    <div class="theme-modal-box">
      <h3>Choose Your Wave</h3>
      <div class="theme-grid">
        <?php
        $themes = [
          ['name' => 'Emerald Tide', 'key' => 'emerald', 'desc' => 'Classic green diagnostic waves', 'colors' => ['#16a34a','#0d9488','#7c3aed','#f97316']],
          ['name' => 'Green Spectrum', 'key' => 'greenspectrum', 'desc' => 'Vibrant green energy spectrum', 'colors' => ['#22c55e','#16a34a','#7c3aed','#f59e0b']],
          ['name' => 'Ocean Breeze', 'key' => 'oceanbreeze', 'desc' => 'Calming ocean-inspired tones', 'colors' => ['#06b6d4','#0891b2','#7c3aed','#f97316']],
          ['name' => 'Violet Wave', 'key' => 'violetwave', 'desc' => 'Deep violet wellness waves', 'colors' => ['#8b5cf6','#7c3aed','#16a34a','#f97316']],
        ];
        $current = $theme_manager->getThemeName();
        foreach ($themes as $t): ?>
          <div class="theme-card <?= $t['key'] === $current ? 'selected' : '' ?>" onclick="selectTheme('<?= $t['key'] ?>')">
            <div class="theme-card-name"><?= $t['name'] ?></div>
            <div class="theme-card-desc"><?= $t['desc'] ?></div>
            <div class="theme-card-colors">
              <?php foreach ($t['colors'] as $c): ?>
                <div class="theme-card-swatch" style="background:<?= $c ?>;border-color:<?= $c ?>"></div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="theme-modal-close" onclick="document.getElementById('themeModal').classList.remove('open')">Done</button>
    </div>
  </div>

  <script>
    function selectTheme(theme) {
      fetch('includes/theme-switch.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'theme=' + theme
      }).then(r => r.json()).then(d => {
        if (d.status === 'ok') { document.documentElement.setAttribute('data-theme', theme); document.querySelectorAll('.theme-card').forEach(c => c.classList.remove('selected')); event.currentTarget.classList.add('selected'); }
      });
    }

    document.getElementById('darkModeToggle')?.addEventListener('click', () => {
      const html = document.documentElement;
      const isDark = html.getAttribute('data-color-scheme') === 'dark';
      html.setAttribute('data-color-scheme', isDark ? 'light' : 'dark');
      fetch('includes/theme-switch.php', { method: 'POST', headers: {'Content-Type':'application/x-www-form-urlencoded'}, body: 'color_scheme=' + (isDark ? 'light' : 'dark') });
    });

    document.getElementById('menuToggle')?.addEventListener('click', () => {
      let sidebar = document.getElementById('mobileSidebar');
      if (!sidebar) {
        sidebar = document.createElement('div');
        sidebar.id = 'mobileSidebar';
        sidebar.style.cssText = 'position:fixed;inset:0;z-index:9998;background:var(--bg-secondary);padding:2rem;overflow-y:auto;display:flex;flex-direction:column;gap:0.5rem;';
        const links = <?= json_encode([
          ['page'=>'dashboard','label'=>'Main Screen','icon'=>'lucide-home'],
          ['page'=>'conditions','label'=>'Challenges','icon'=>'lucide-activity'],
          ['page'=>'diagnostics','label'=>'Imaging','icon'=>'lucide-scan'],
          ['page'=>'protocols','label'=>'Protocols','icon'=>'lucide-file-text'],
          ['page'=>'supplements','label'=>'Supplements','icon'=>'lucide-capsule'],
          ['page'=>'pemf','label'=>'PEMF','icon'=>'lucide-zap'],
          ['page'=>'stemcells','label'=>'Stem Cells','icon'=>'lucide-dna'],
          ['page'=>'vps','label'=>'VPS Providers','icon'=>'lucide-server'],
          ['page'=>'data','label'=>'Data Manager','icon'=>'lucide-database'],
          ['page'=>'case-study','label'=>'Case Study','icon'=>'lucide-file'],
          ['page'=>'references','label'=>'References','icon'=>'lucide-book-open'],
          ['page'=>'team','label'=>'Team / About','icon'=>'lucide-users'],
          ['page'=>'faq','label'=>'FAQ','icon'=>'lucide-help-circle'],
        ]) ?>;
        let html = '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem"><strong style="font-size:1rem;background:linear-gradient(135deg,var(--accent-green),var(--accent-violet));-webkit-background-clip:text;-webkit-text-fill-color:transparent">Coach & Heal</strong><button onclick="document.getElementById(\'mobileSidebar\').remove()" style="background:none;border:none;color:var(--text-primary);font-size:1.5rem;cursor:pointer">&times;</button></div>';
        links.forEach(l => { html += '<a href="index.php?page=' + l.page + '" style="display:flex;align-items:center;gap:0.75rem;padding:0.85rem 1rem;border-radius:10px;color:var(--text-primary);text-decoration:none;font-size:0.9rem;background:var(--bg-tertiary)"><i class="lucide-' + l.icon + '"></i>' + l.label + '</a>'; });
        html += '<div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--border-color);font-size:0.7rem;color:var(--text-secondary);text-align:center">Powered by Ibereal Enterprise<br>Regenerative Health Intelligence Platform<br>© <?= date('Y') ?> Coach & Heal</div>';
        sidebar.innerHTML = html;
        document.body.appendChild(sidebar);
      }
    });

    document.getElementById('themeModal')?.addEventListener('click', e => { if (e.target === e.currentTarget) e.currentTarget.classList.remove('open'); });
  </script>
</body>
</html>
