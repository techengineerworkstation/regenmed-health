<?php
if (!VERCEL_MODE && session_status() === PHP_SESSION_NONE) { session_start(); }
ThemeManager::init();
$currentTheme = ThemeManager::getCurrentTheme();
$themeData = ThemeManager::getTheme($currentTheme);
$light = $themeData['light'] ?? [];
$waveColor1 = $light['--accent-green'] ?? '#16a34a';
$waveColor2 = $light['--accent-violet'] ?? '#7c3aed';
$waveOpacity = '0.08';
if (!isset($current_user)) $current_user = $_SESSION['user'] ?? null;
$allThemes = ThemeManager::getThemeNames();
?>
<!-- WAVE BACKGROUND -->
<div style="position:fixed;inset:0;z-index:0;pointer-events:none;overflow:hidden;">
  <svg viewBox="0 0 1440 320" preserveAspectRatio="none" style="position:absolute;width:200%;left:-50%;bottom:-10%;animation:waveShift 12s ease-in-out infinite;">
    <path fill="<?= $waveColor1 ?>" fill-opacity="<?= $waveOpacity ?>" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L0,320Z"></path>
    <path fill="<?= $waveColor2 ?>" fill-opacity="<?= $waveOpacity ?>" d="M0,256L48,240C96,224,192,192,288,186.7C384,181,480,203,576,218.7C672,235,768,245,864,229.3C960,213,1056,171,1152,154.7C1248,139,1344,149,1392,154.7L1440,160L1440,320L0,320Z"></path>
  </svg>
</div>

<!-- HEADER -->
<header style="position:sticky;top:0;z-index:100;height:64px;display:flex;align-items:center;justify-content:space-between;padding:0 1.5rem;background:var(--bg-secondary);border-bottom:1px solid var(--border-color);box-shadow:var(--shadow-sm);backdrop-filter:blur(12px);">
  <div style="display:flex;align-items:center;gap:1rem;">
    <a href="index.php" style="display:flex;align-items:center;gap:0.75rem;text-decoration:none;color:var(--text-primary);">
      <img src="assets/svg/logo.svg" alt="Logo" style="height:36px;width:auto;">
      <div style="display:flex;flex-direction:column;line-height:1.2;">
        <span style="font-weight:800;font-size:1.15rem;background:linear-gradient(135deg,var(--accent-green),var(--accent-violet));-webkit-background-clip:text;-webkit-text-fill-color:transparent;letter-spacing:-0.02em;">Coach & Heal</span>
        <span style="font-size:0.68rem;color:var(--text-secondary);letter-spacing:0.06em;font-weight:500;">Regen Med Health</span>
      </div>
    </a>
  </div>

  <nav style="flex:1;display:flex;justify-content:center;">
    <ul style="display:flex;gap:0.25rem;list-style:none;margin:0;padding:0;flex-wrap:nowrap;overflow-x:auto;">
      <?php
      $navItems = [
        ['page'=>'dashboard','label'=>'Main Screen','icon'=>'lucide-home'],
        ['page'=>'conditions','label'=>'Challenges','icon'=>'lucide-activity'],
        ['page'=>'diagnostics','label'=>'Imaging','icon'=>'lucide-scan'],
        ['page'=>'protocols','label'=>'Protocols','icon'=>'lucide-file-text'],
        ['page'=>'supplements','label'=>'Supplements','icon'=>'lucide-capsule'],
        ['page'=>'pemf','label'=>'PEMF','icon'=>'lucide-zap'],
        ['page'=>'stem-cells','label'=>'Stem Cells','icon'=>'lucide-dna'],
        ['page'=>'vps-providers','label'=>'VPS','icon'=>'lucide-server'],
        ['page'=>'data-manager','label'=>'Data','icon'=>'lucide-database'],
        ['page'=>'case-study','label'=>'Case Study','icon'=>'lucide-file'],
        ['page'=>'references','label'=>'References','icon'=>'lucide-book-open'],
        ['page'=>'team','label'=>'Team','icon'=>'lucide-users'],
        ['page'=>'faq','label'=>'FAQ','icon'=>'lucide-help-circle'],
      ];
      $activePage = $_GET['page'] ?? 'dashboard';
      foreach ($navItems as $n):
        $isActive = $n['page'] === $activePage;
        $bg = $isActive ? 'background:var(--accent-primary);color:#fff;' : 'background:transparent;color:var(--text-secondary);';
        $hover = $isActive ? '' : 'onmouseover="this.style.background=\'var(--bg-tertiary)\';this.style.color=\'var(--text-primary)\'" onmouseout="this.style.background=\'transparent\';this.style.color=\'var(--text-secondary)\'"';
      ?>
        <li><a href="index.php?page=<?= $n['page'] ?>" style="display:flex;align-items:center;gap:0.35rem;padding:0.45rem 0.75rem;border-radius:8px;font-size:0.8rem;font-weight:600;white-space:nowrap;text-decoration:none;transition:all 0.2s ease;letter-spacing:0.005em;<?= $bg ?>" <?= $hover ?>><i class="<?= $n['icon'] ?>" style="font-size:1.05rem;"></i> <?= $n['label'] ?></a></li>
      <?php endforeach; ?>
    </ul>
  </nav>

  <div style="display:flex;align-items:center;gap:0.75rem;">
    <button onclick="document.getElementById('themeModal').style.display='flex'" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:8px;border:1px solid var(--border-color);background:var(--bg-secondary);color:var(--text-secondary);cursor:pointer;font-size:1rem;"><i class="lucide-palette"></i></button>
    <button id="darkModeToggle" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:8px;border:1px solid var(--border-color);background:var(--bg-secondary);color:var(--text-secondary);cursor:pointer;font-size:1rem;"><i class="lucide-moon"></i></button>
    <button id="menuToggle" style="display:none;align-items:center;justify-content:center;width:36px;height:36px;border-radius:8px;border:1px solid var(--border-color);background:var(--bg-secondary);color:var(--text-secondary);cursor:pointer;font-size:1rem;"><i class="lucide-menu"></i></button>
    <?php if ($current_user): ?>
      <span style="font-size:0.8rem;color:var(--text-secondary)"><?= htmlspecialchars($current_user['name'] ?? $current_user['email']) ?></span>
      <a href="index.php?action=logout" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:8px;border:1px solid var(--border-color);background:var(--bg-secondary);color:var(--text-secondary);cursor:pointer;font-size:1rem;text-decoration:none;"><i class="lucide-log-out"></i></a>
    <?php endif; ?>
  </div>
</header>

<!-- THEME PICKER MODAL -->
<div id="themeModal" style="position:fixed;inset:0;z-index:9999;display:none;align-items:center;justify-content:center;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);" onclick="if(event.target===this)this.style.display='none'">
  <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:16px;padding:2rem;width:90%;max-width:480px;box-shadow:var(--shadow-lg);">
    <h3 style="margin-bottom:1.25rem;font-size:1.2rem;font-weight:700;color:var(--text-primary);letter-spacing:-0.02em;">Choose Your Wave</h3>
    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:0.75rem;">
      <?php
      foreach ($allThemes as $key => $info):
        $tData = ThemeManager::getTheme($key);
        $tLight = $tData['light'] ?? [];
        $c1 = $tLight['--accent-green'] ?? '#16a34a';
        $c2 = $tLight['--accent-primary'] ?? '#0d9488';
        $c3 = $tLight['--accent-violet'] ?? '#7c3aed';
        $c4 = $tLight['--accent-secondary'] ?? '#06b6d4';
        $sel = $key === $currentTheme;
        $border = $sel ? 'border-color:var(--accent-primary);' : '';
      ?>
        <div onclick="selectTheme('<?= $key ?>')" style="padding:1rem;border-radius:12px;border:2px solid var(--border-color);<?= $border ?>cursor:pointer;background:var(--bg-tertiary);transition:all 0.2s ease;">
          <div style="font-weight:700;font-size:0.92rem;margin-bottom:0.2rem;color:var(--text-primary);letter-spacing:-0.01em;"><?= $info['name'] ?></div>
          <div style="font-size:0.73rem;color:var(--text-secondary);margin-bottom:0.4rem;line-height:1.5;"><?= $info['description'] ?? '' ?></div>
          <div style="display:flex;gap:5px;">
            <?php foreach ([$c1,$c2,$c3,$c4] as $c): ?>
              <span style="width:16px;height:16px;border-radius:50%;background:<?= $c ?>;display:inline-block;border:1px solid rgba(0,0,0,0.1);"></span>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <button onclick="document.getElementById('themeModal').style.display='none'" style="margin-top:1rem;width:100%;padding:0.6rem;border:none;border-radius:8px;background:var(--bg-tertiary);color:var(--text-primary);cursor:pointer;font-weight:500;">Done</button>
  </div>
</div>

<script>
function selectTheme(themeKey) {
  document.documentElement.setAttribute('data-theme', themeKey);
  localStorage.setItem('regenmed_theme', themeKey);
  fetch('/includes/theme-switch.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'theme=' + encodeURIComponent(themeKey)
  });
  document.querySelectorAll('#themeModal > div > div > div').forEach(c => c.style.borderColor = 'var(--border-color)');
  event.currentTarget.style.borderColor = 'var(--accent-primary)';
}

document.getElementById('darkModeToggle')?.addEventListener('click', () => {
  const html = document.documentElement;
  const isDark = html.getAttribute('data-mode') === 'dark';
  const newMode = isDark ? 'light' : 'dark';
  html.setAttribute('data-mode', newMode);
  if (newMode === 'dark') html.classList.add('dark');
  else html.classList.remove('dark');
  localStorage.setItem('regenmed_mode', newMode);
  fetch('/includes/theme-switch.php', { method: 'POST', headers: {'Content-Type':'application/x-www-form-urlencoded'}, body: 'mode=' + newMode });
});

document.getElementById('menuToggle')?.addEventListener('click', () => {
  let sidebar = document.getElementById('mobileSidebar');
  if (!sidebar) {
    sidebar = document.createElement('div');
    sidebar.id = 'mobileSidebar';
    sidebar.style.cssText = 'position:fixed;inset:0;z-index:9998;background:var(--bg-secondary);padding:2rem;overflow-y:auto;display:flex;flex-direction:column;gap:0.5rem;';
    const links = <?= json_encode($navItems) ?>;
    let html = '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem"><strong style="font-size:1rem;background:linear-gradient(135deg,var(--accent-green),var(--accent-violet));-webkit-background-clip:text;-webkit-text-fill-color:transparent">Coach & Heal</strong><button onclick="document.getElementById(\'mobileSidebar\').remove()" style="background:none;border:none;color:var(--text-primary);font-size:1.5rem;cursor:pointer">&times;</button></div>';
    links.forEach(l => { html += '<a href="index.php?page=' + l.page + '" style="display:flex;align-items:center;gap:0.75rem;padding:0.85rem 1rem;border-radius:10px;color:var(--text-primary);text-decoration:none;font-size:0.9rem;background:var(--bg-tertiary)"><i class="lucide-' + l.icon + '"></i>' + l.label + '</a>'; });
    html += '<div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--border-color);font-size:0.7rem;color:var(--text-secondary);text-align:center">Powered by Ibereal Enterprise<br>© <?= date('Y') ?> Coach & Heal</div>';
    sidebar.innerHTML = html;
    document.body.appendChild(sidebar);
  }
});

if (window.innerWidth <= 1024) {
  document.getElementById('menuToggle').style.display = 'flex';
}
window.addEventListener('resize', () => {
  document.getElementById('menuToggle').style.display = window.innerWidth <= 1024 ? 'flex' : 'none';
});
</script>
