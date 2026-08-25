<header class="sticky top-0 z-50 glass-panel dark:bg-slate-900/80 dark:border-slate-700/50 shadow-sm" style="animation: fadeIn 0.5s ease-in-out;">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center space-x-3">
                <a href="?page=dashboard" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #16a34a, #0d9488, #06b6d4, #7c3aed);">
                        <img src="/assets/svg/logo.svg" alt="Coach & Heal — Regen Med Health" class="w-8 h-8">
                    </div>
                    <div>
                        <h1 class="text-lg font-bold gradient-text"><?= APP_NAME ?></h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Empowering Growth in Life, Health & World Business</p>
                    </div>
                </a>
            </div>

            <div class="hidden lg:flex items-center space-x-1">
                <?php
                $navItems = [
                    'dashboard' => ['icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Main Screen', 'group' => 'main'],
                    'conditions' => ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'label' => 'Challenges', 'group' => 'main'],
                    'imaging' => ['icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 012-2V6a2 2 0 012-2H6a2 2 0 01-2 2v12a2 2 0 012 2z', 'label' => 'Imaging', 'group' => 'diagnostics'],
                    'protocols' => ['icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 01-1.806.547M8 4h8l-1 1v5.172a2 2 0 01.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'label' => 'Protocols', 'group' => 'diagnostics'],
                    'supplements' => ['icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 01-1.806.547M8 4h8l-1 1v5.172a2 2 0 01.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'label' => 'Supplements', 'group' => 'diagnostics'],
                    'pemf' => ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'label' => 'PEMF Therapy', 'group' => 'diagnostics'],
                    'stem-cells' => ['icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'label' => 'Stem Cells', 'group' => 'diagnostics'],
                    'vps-providers' => ['icon' => 'M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01', 'label' => 'GPU Providers', 'group' => 'tools'],
                    'data-manager' => ['icon' => 'M9 19V10a3 3 0 00-3-3H2m0 0v9a2 2 0 002 2h6a2 2 0 002-2V5a2 2 0 00-2-2H9a2 2 0 00-2 2v9z M9 19h6m-3 0v-6h3l3-3', 'label' => 'Data Manager', 'group' => 'tools'],
                    'case-study' => ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'label' => 'Case Study', 'group' => 'resources'],
                    'references' => ['icon' => 'M12 6.253v11.495m-9-5.747 9-9 9 9-9 9', 'label' => 'References', 'group' => 'resources'],
                ];
                $groups = [
                    'main' => 'Application',
                    'diagnostics' => 'Diagnostics & Therapy',
                    'tools' => 'Tools',
                    'resources' => 'References',
                ];
                $currentGroup = null;
                foreach ($navItems as $key => $item):
                    if ($item['group'] !== $currentGroup):
                        $currentGroup = $item['group'];
                        ?>
                        <?php if ($currentGroup !== reset($navItems)['group']): ?>
                            <div class="mx-1 h-4 w-px bg-slate-300 dark:bg-slate-600"></div>
                        <?php endif; ?>
                    <?php endif;
                    $active = $page === $key ? 'active text-medical-teal' : 'text-slate-600 dark:text-slate-400 hover:text-medical-teal dark:hover:text-medical-cyan';
                ?>
                <a href="?page=<?= $key ?>" class="nav-link <?= $active ?> sidebar-item group">
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $item['icon'] ?>"/>
                    </svg>
                    <span><?= $item['label'] ?></span>
                </a>
                <?php endforeach; ?>
            </div>

            <div class="flex items-center space-x-2">
                <button @click="openThemeModal = true"
                        class="p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200"
                        title="Select theme">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                </button>

                <button @click="darkMode = !darkMode"
                        class="p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200"
                        :title="darkMode ? 'Light mode' : 'Dark mode'">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>

                <?php if (SessionManager::isLoggedIn()): ?>
                <a href="?page=logout" class="p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200" title="Sign out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </a>
                <?php endif; ?>

                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Theme Picker Modal -->
    <div x-show="openThemeModal" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
         @click.self="openThemeModal = false">
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 w-80 max-w-full shadow-2xl border border-slate-200 dark:border-slate-700"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100">Select Theme</h3>
                <button @click="openThemeModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="space-y-3 mb-6">
                <?php foreach (ThemeManager::getThemeNames() as $key => $theme): ?>
                <?php $isCurrent = ($key === ThemeManager::getCurrentTheme()); ?>
                <button @click="selectTheme('<?= $key ?>'); openThemeModal = false"
                        class="w-full h-12 rounded-xl flex items-center gap-3 px-4 border-2 transition-all duration-200 hover:scale-[1.02] <?= $isCurrent ? 'border-medical-teal shadow-md shadow-medical-teal/20' : 'border-slate-200 dark:border-slate-600 hover:border-medical-teal/40' ?>"
                        style="background: var(--bg-card);">
                    <?= ThemeManager::themeColorSwatch($key) ?>
                    <span class="text-sm font-medium" style="color: var(--text-primary);"><?= htmlspecialchars($theme['name']) ?></span>
                    <?php if ($key === ThemeManager::getCurrentTheme()): ?>
                    <svg class="w-4 h-4 ml-auto text-medical-teal" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    <?php endif; ?>
                </button>
                <?php endforeach; ?>
            </div>
            <button @click="openThemeModal = false"
                    class="w-full py-2.5 rounded-lg bg-medical-teal text-white text-sm font-medium hover:bg-medical-teal/90 transition">
                Done
            </button>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div x-show="sidebarOpen" x-cloak x-transition class="lg:hidden bg-white dark:bg-slate-800 border-t dark:border-slate-700 shadow-lg">
        <div class="px-4 pt-2 pb-4 space-y-1">
            <?php foreach ($navItems as $key => $item): ?>
            <a href="?page=<?= $key ?>" @click="sidebarOpen = false"
               class="block p-2 rounded-lg sidebar-item <?= $page === $key ? 'bg-medical-teal/10 text-medical-teal' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50' ?>">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $item['icon'] ?>"/>
                </svg>
                <span><?= $item['label'] ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</header>
