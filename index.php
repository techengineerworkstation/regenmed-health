<?php
declare(strict_types=1);

define('APP_NAME', 'Regen Med Health');
define('APP_VERSION', '2.0');
define('APP_DESCRIPTION', 'Medical Scans, Test, and Recommendations - Regen Med Health');

require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/database.php';
require_once __DIR__ . '/includes/themes.php';

SessionManager::start();
ThemeManager::init();

$data = [
    'themeManager' => $themeManager ?? null,
];

$userId = SessionManager::getUserId();
$page = InputValidator::deepSanitizeString($_GET['page'] ?? 'dashboard');

$allowedPages = ['dashboard', 'conditions', 'imaging', 'protocols', 'supplements', 'pemf', 'stem-cells', 'vps-providers', 'data-manager', 'case-study', 'references', 'login', 'register', 'logout'];
if (!in_array($page, $allowedPages, true)) {
    $page = 'dashboard';
}

RegenMedDatabase::logPageView(
    $userId,
    null,
    $page,
    $_SERVER['QUERY_STRING'] ?? null,
    $_SERVER['HTTP_REFERER'] ?? null
);

$conditions = [
    'knee_arthritis' => ['name' => 'Knee Osteoarthritis', 'icd10' => 'M17', 'imaging' => ['MRI', 'X-ray', 'Ultrasound'], 'severity_grades' => ['Grade 1: Minimal', 'Grade 2: Mild', 'Grade 3: Moderate', 'Grade 4: Severe'], 'key_findings' => ['Cartilage loss', 'Osteophytes', 'Subchondral sclerosis', 'Joint space narrowing', 'Bone marrow lesions'], 'window' => ['image' => 'knee-mri.svg', 'view' => 'Sagittal PD/T2', 'highlight' => 'Cartilage defect medial compartment']],
    'retinal_degeneration' => ['name' => 'Age-Related Macular Degeneration', 'icd10' => 'H35.30', 'imaging' => ['OCT', 'OCTA', 'Fundus Autofluorescence', 'Fluorescein Angiography'], 'severity_grades' => ['Early AMD', 'Intermediate AMD', 'Geographic Atrophy', 'Neovascular AMD'], 'key_findings' => ['Drusen', 'Pigment changes', 'Geographic atrophy', 'Subretinal fluid', 'CNV'], 'window' => ['image' => 'retina-oct.svg', 'view' => 'Macular OCT B-scan', 'highlight' => 'Drusen and RPE changes']],
    'male_factor_enhancing_fertility' => ['name' => 'Male Enhancing Fertility', 'icd10' => 'N46', 'imaging' => ['Scrotal Ultrasound', 'Scrotal MRI', 'Vasography'], 'severity_grades' => ['Oligospermia', 'Asthenospermia', 'Teratospermia', 'Azoospermia'], 'key_findings' => ['Varicocele', 'Testicular volume', 'Epididymal abnormalities', 'Semen analysis'], 'window' => ['image' => 'scrotal-us.svg', 'view' => 'Testicular Doppler US', 'highlight' => 'Pampiniform plexus dilation']],
    'female_factor_enhancing_fertility' => ['name' => 'Female Enhancing Fertility', 'icd10' => 'N97', 'imaging' => ['Transvaginal US', 'HSG', 'Saline Infusion US', 'Pelvic MRI'], 'severity_grades' => ['Ovulatory', 'Tubal', 'Uterine', 'Endometriosis', 'Diminished Ovarian Reserve'], 'key_findings' => ['Follicle count', 'Endometrial thickness', 'Uterine anomalies', 'Hydrosalpinx', 'Ovarian cysts'], 'window' => ['image' => 'uterine-us.svg', 'view' => 'Transvaginal US uterus/ovary', 'highlight' => 'Follicular tracking']],
    'prostate_disease' => ['name' => 'Prostate Disease (BPH/Prostatitis)', 'icd10' => 'N40/N41', 'imaging' => ['mpMRI', 'Transrectal US', 'Prostate CT'], 'severity_grades' => ['BPH I', 'BPH II', 'BPH III', 'BPH IV', 'Prostatitis'], 'key_findings' => ['Prostate volume', 'PSA levels', 'PI-RADS score', 'Transition zone', 'Lesions'], 'window' => ['image' => 'prostate-mri.svg', 'view' => 'mpMRI prostate T2/DWI', 'highlight' => 'Transition zone enlargement']]
];

$protocols = [
    'knee_arthritis' => ['stem_cell' => ['source' => 'BMC/UC-MSC', 'delivery' => 'Intra-articular', 'cells' => '1x10^7 - 1x10^8'], 'pemf' => ['frequency' => '15 Hz', 'intensity' => '2 mT', 'duration' => '30 min/day'], 'supplements' => ['Glucosamine 1500mg', 'Curcumin 1000mg', 'Vitamin D3 4000IU', 'Collagen Type II'], 'herbs' => ['Turmeric', 'Boswellia', 'Ashwagandha', 'Ginger']],
    'retinal_degeneration' => ['stem_cell' => ['source' => 'iPSC-RPE/UC-MSC', 'delivery' => 'Subretinal', 'cells' => '1x10^5 - 5x10^5'], 'pemf' => ['frequency' => 'N/A (Use PBMT)', 'intensity' => 'Red/NIR light', 'duration' => 'Daily sessions'], 'supplements' => ['AREDS2', 'Lutein 10mg', 'Zeaxanthin 2mg', 'Omega-3 1000mg'], 'herbs' => ['Saffron 20mg', 'Bilberry', 'Ginkgo biloba']],
    'male_factor_enhancing_fertility' => ['stem_cell' => ['source' => 'MSC', 'delivery' => 'Intratesticular/IV', 'cells' => '1x10^6 - 1x10^7'], 'pemf' => ['frequency' => '5 Hz', 'intensity' => '3 mT', 'duration' => '30 min/day'], 'supplements' => ['CoQ10 200mg', 'L-Carnitine 2000mg', 'Zinc 30mg', 'Vitamin D3 4000IU'], 'herbs' => ['Tongkat Ali', 'Ashwagandha', 'Maca Root', 'Fenugreek']],
    'female_factor_enhancing_fertility' => ['stem_cell' => ['source' => 'UC-MSC/BMC', 'delivery' => 'Intrauterine/Ovarian', 'cells' => '1x10^7 - 5x10^7'], 'pemf' => ['frequency' => '10 Hz', 'intensity' => '3 mT', 'duration' => '30 min/day'], 'supplements' => ['Myo-Inositol 4g', 'CoQ10 200mg', 'Folate 800mcg', 'Vitamin D3 4000IU'], 'herbs' => ['Vitex', 'Maca Root', 'Ashwagandha', 'Shatavari']],
    'prostate_disease' => ['stem_cell' => ['source' => 'MSC', 'delivery' => 'Transperineal/IV', 'cells' => '1x10^7'], 'pemf' => ['frequency' => '10 Hz', 'intensity' => '3 mT', 'duration' => '30 min/day'], 'supplements' => ['Saw Palmetto 320mg', 'Beta-sitosterol 60mg', 'Zinc 30mg', 'Lycopene 15mg'], 'herbs' => ['Saw Palmetto', 'Stinging Nettle', 'Pygeum', 'Pumpkin Seed Oil']]
];

$vpsProviders = [
    // === FREE TIER ===
    'google_colab' => ['name' => 'Google Colab', 'tier' => 'Free', 'gpu' => 'T4 (16GB)', 'cost' => '$0/month', 'best' => 'Prototyping', 'url' => 'colab.research.google.com', 'weekly_limit' => '~20-30 hrs', 'session_limit' => '12 hrs'],
    'sagemaker_lab' => ['name' => 'SageMaker Studio Lab', 'tier' => 'Free', 'gpu' => 'T4 (16GB)', 'cost' => '$0/month', 'best' => 'Notebooks', 'url' => 'studiolab.sagemaker.aws', 'weekly_limit' => 'Unlimited total', 'session_limit' => '4 hrs'],
    'lightning_ai' => ['name' => 'Lightning AI', 'tier' => 'Free', 'gpu' => 'T4/A10G', 'cost' => '$0/month', 'best' => 'PyTorch Lightning', 'url' => 'lightning.ai', 'weekly_limit' => '~10-15 hrs/mo', 'session_limit' => '~3 hrs'],
    'oracle_free' => ['name' => 'Oracle Cloud (Always Free)', 'tier' => 'Free', 'gpu' => 'ARM Ampere A1', 'cost' => '$0/month', 'best' => 'Always-on workloads', 'url' => 'cloud.oracle.com', 'weekly_limit' => 'Always free', 'session_limit' => 'Unlimited'],
    'ngc' => ['name' => 'NVIDIA NGC', 'tier' => 'Free (Research)', 'gpu' => 'A100 (40/80GB)', 'cost' => '$0/month', 'best' => 'Medical AI research', 'url' => 'ngc.nvidia.com', 'weekly_limit' => '90-day trial', 'session_limit' => 'Unlimited'],
    // === PAID TIER ===
    'runpod' => ['name' => 'RunPod', 'tier' => 'Paid', 'gpu' => 'RTX 4090/A100', 'cost' => '$0.44/hr', 'best' => 'Training', 'url' => 'runpod.io'],
    'lambda' => ['name' => 'Lambda Labs', 'tier' => 'Paid', 'gpu' => 'A100 40GB', 'cost' => '$0.56/hr', 'best' => 'Research', 'url' => 'lambdalabs.com'],
    'vastai' => ['name' => 'Vast.ai', 'tier' => 'Paid', 'gpu' => 'Various', 'cost' => '$0.30/hr+', 'best' => 'Budget', 'url' => 'vast.ai'],
    'coreweave' => ['name' => 'CoreWeave', 'tier' => 'Paid', 'gpu' => 'H100 SXM', 'cost' => '$2.20-$4.25/hr', 'best' => 'Scale', 'url' => 'coreweave.com'],
];

$pemfParams = [
    'knee_arthritis' => ['frequency' => '1-50 Hz', 'intensity' => '1-5 mT', 'waveform' => 'Square/Sine', 'duration' => '30-60 min/day', 'sessions' => '8-12 weeks'],
    'osteoporosis' => ['frequency' => '15-75 Hz', 'intensity' => '0.5-2 mT', 'waveform' => 'Asymmetric', 'duration' => '60 min/day', 'sessions' => 'Ongoing'],
    'retinal' => ['frequency' => 'N/A (PBMT)', 'intensity' => 'Red/NIR', 'waveform' => 'Continuous', 'duration' => 'Daily', 'sessions' => 'Ongoing'],
    'male_fertility' => ['frequency' => '1-10 Hz', 'intensity' => '1-5 mT', 'waveform' => 'Sine', 'duration' => '30 min/day', 'sessions' => '12 weeks'],
    'female_fertility' => ['frequency' => '5-25 Hz', 'intensity' => '1-3 mT', 'waveform' => 'Square', 'duration' => '30 min/day', 'sessions' => '8-12 weeks'],
    'prostate' => ['frequency' => '10-50 Hz', 'intensity' => '1-3 mT', 'waveform' => 'Square/Sine', 'duration' => '30 min/day', 'sessions' => '4-8 weeks']
];

if ($page === 'logout') {
    SessionManager::logout();
    header('Location: ?page=dashboard');
    exit;
}

$csrfToken = SessionManager::generateCSRFToken();
$nonce = SecurityManager::getNonce();

$errors = [];
$lockoutRemaining = 0;

if ($page === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!SecurityManager::validateCSRF($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid CSRF token';
    } elseif (!SecurityManager::checkHoneypot()) {
        $errors[] = 'Bot detected';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $errors[] = 'Username and password are required';
        } else {
            $user = RegenMedDatabase::authenticateUser($username, $password);
            if ($user) {
                SessionManager::setUserId((int)$user['id']);
                SessionManager::regenerateSession();
                header('Location: ?page=dashboard');
                exit;
            } else {
                $errors[] = 'Invalid username or password';
            }
        }
    }
}

if ($page === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!SecurityManager::validateCSRF($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid CSRF token';
    } elseif (!SecurityManager::checkHoneypot()) {
        $errors[] = 'Bot detected';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        
        if (empty($username) || empty($password)) {
            $errors[] = 'All fields are required';
        } elseif ($password !== $passwordConfirm) {
            $errors[] = 'Passwords do not match';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        } else {
            try {
                RegenMedDatabase::createUser($username, $username . '@regenmed.local', $password, $username);
                $user = RegenMedDatabase::authenticateUser($username, $password);
                if ($user) {
                    SessionManager::setUserId((int)$user['id']);
                    SessionManager::regenerateSession();
                    header('Location: ?page=dashboard');
                    exit;
                }
            } catch (Exception $e) {
                $errors[] = 'Username already exists';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= SecurityManager::sanitizeOutput($csrfToken) ?>">
    <link rel="stylesheet" href="/assets/css/animations.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Regen Med Health Diagnostic Platform</title>
    <meta name="description" content="Medical Imaging & Regenerative Medicine Diagnostic Presentation System">
    <script src="/assets/js/tailwind-browser.js"></script>
    <?php echo ThemeManager::injectThemeScript(); ?>
    <script nonce="<?= $nonce ?>">
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        medical: {
                            50: '#f0fdfa', 100: '#ccfbf1', 200: '#99f6e4',
                            300: '#5eead4', 400: '#2dd4bf', 500: '#14b8a6', 600: '#0d9488',
                            700: '#0f766e', 800: '#115e59', 900: '#134e4a',
                            teal: '#0d9488', cyan: '#06b6d4', indigo: '#4f46e5',
                            violet: '#7c3aed', rose: '#e11d48', amber: '#d97706',
                        },
                    },
                    animation: {
                        fadeIn: 'fadeIn 0.5s ease-in-out',
                        fadeInUp: 'fadeInUp 0.6s ease-out',
                        slideIn: 'slideIn 0.4s ease-out',
                        float: 'float 3s ease-in-out infinite',
                        pulse: 'pulse 2s cubic-bezier(0,0,0.2,0.9) infinite',
                        'spin-slow': 'spin 3s linear infinite',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        fadeInUp: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        slideIn: { '0%': { opacity: '0', transform: 'translateX(-20px)' }, '100%': { opacity: '1', transform: 'translateX(0)' } },
                        float: { '0%,100%': { transform: 'translateY(0px)' }, '50%': { transform: 'translateY(-10px)' } },
                        pulse: { '0%,100%': { opacity: '1' }, '50%': { opacity: '.5' } },
                    },
                    backdropBlur: { xs: '2px' },
                }
            }
        }
        document.documentElement.setAttribute('data-theme', '<?= ThemeManager::getCurrentTheme() ?>');
        document.documentElement.setAttribute('data-mode', '<?= (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light") ?>');
        if (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) document.documentElement.classList.add('dark');
        else document.documentElement.classList.remove('dark');
    </script>
    <style>
        <?php echo ThemeManager::generateFullCSS(); ?>
        :root {
            --border-radius: 1.25rem;
            --card-shadow: 0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px 0 rgba(0,0,0,0.06);
            --card-shadow-hover: 0 10px 25px -5px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.1);
        }
        [x-cloak] { display: none !important; }
        .glass-panel {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.3);
        }
        .glass-panel-dark {
            background: rgba(15,23,42,0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.05);
        }
        .gradient-text {
            background: linear-gradient(135deg, var(--medical-teal) 0%, var(--medical-cyan) 50%, var(--medical-indigo) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .medical-grid {
            background-image: linear-gradient(rgba(13,148,136,0.05) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(13,148,136,0.05) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow-hover);
        }
        .diagnostic-window {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border: 2px solid #334155;
        }
        .nav-link { position: relative; transition: all 0.25s ease; }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--medical-teal), var(--medical-cyan));
            transition: width 0.3s ease;
        }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }
        .card-border {
            border: 1px solid rgba(148, 163, 184, 0.2);
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        .sidebar-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--medical-teal);
            transform: scaleY(0);
            transform-origin: center;
            transition: transform 0.2s ease;
        }
        .sidebar-item.active::before, .sidebar-item:hover::before {
            transform: scaleY(1);
        }
        body {
            <?php
            $themeKey = ThemeManager::getCurrentTheme();
            $theme = $themeManager['themes'][$themeKey] ?? $themeManager['themes']['beige-cream'] ?? [];
            $light = $theme['light'] ?? [];
            echo 'background: var(--bg-primary, ' . ($light['--bg-primary'] ?? '#faf8f5') . ');
                      radial-gradient(circle at 10% 10%, color-mix(in srgb, ' . ($light['--accent-primary'] ?? '#0d9488') . ' 0.03%) 0%, transparent 20%),
                      radial-gradient(circle at 90% 80%, color-mix(in srgb, ' . ($light['--accent-secondary'] ?? '#06b6d4') . ' 0.03%) 0%, transparent 20%);';
            ?>
        }
        /* Dark mode custom styles */
        .dark .glass-panel {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .dark .diagnostic-window { border-color: #1e293b; }
        .dark .card-border { border-color: rgba(148, 163, 184, 0.1); }
        .dark .medical-grid {
            background-image: linear-gradient(rgba(13,148,136,0.08) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(13,148,136,0.08) 1px, transparent 1px);
        }
</style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900 transition-colors duration-300"
      x-data="{ sidebarOpen: false, darkMode: (localStorage.getItem('darkMode') === 'true') }"
      x-init="$watch('darkMode', val => { localStorage.setItem('darkMode', val); if(val) document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark'); }"
      x-bind:class="darkMode ? 'dark bg-slate-900 text-slate-100' : 'bg-slate-50 text-slate-900'"
      data-theme="<?= ThemeManager::getCurrentTheme() ?>"
      data-mode="<?= (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') ?>">
    
    <?php require_once __DIR__ . '/includes/header.php'; ?>
    
    <?php
    $pageFile = __DIR__ . "/pages/{$page}.php";
    if (file_exists($pageFile)) {
        require_once $pageFile;
    } else {
        echo '<main class="max-w-7xl mx-auto px-4 py-20 text-center"><h1 class="text-2xl font-bold text-slate-900">Page Not Found</h1><p class="text-slate-500 mt-2">The requested page could not be found.</p></main>';
    }
    ?>
    
    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    
    <script nonce="<?= $nonce ?>">
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            document.querySelectorAll('form').forEach(function(form) {
                if (form.method.toLowerCase() === 'post') {
                    let csrfInput = form.querySelector('input[name="csrf_token"]');
                    if (!csrfInput) {
                        csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = 'csrf_token';
                        form.appendChild(csrfInput);
                    }
                    csrfInput.value = csrfToken;
                }
            });
        });
    </script>
</body>
</html>
