<header class="sticky top-0 z-50 glass-panel dark:bg-slate-900/80 dark:border-slate-700/50 shadow-sm" style="animation: fadeIn 0.5s ease-in-out;">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-medical-teal to-medical-cyan flex items-center justify-center shadow-lg shadow-medical-teal/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold gradient-text"><?= APP_NAME ?></h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">v<?= APP_VERSION ?></p>
                </div>

            <!-- Theme Picker -->
            <div class="hidden lg:flex items-center space-x-2">
                <button @click="openThemeModal = true"
                        class="p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200"
                        :title="select theme">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2-2v6a2 2 0 002 2h2a2 2 0 002 2v-6a2 2 0 012-2zm0 0v-6a2 2 0 00-2-2H5a2 2 0 00-2-2v6a2 2 0 002 2h2a2 2 0 002 2vz6zm9-11a2 2 0 11-4 0 2 2 0 014 0zm2.875 5.875a2.125 2.125 0 11-3.389 1.827L18.5 16.188l-1.675 2.093a2.125 2.125 0 01-2.125 1.673H14l1.75 5.5a2.125 2.125 0 01-2.125 1.673H5.125a2.125 2.125 0 11-2.125-1.673L8.31 9.35a2.125 2.125 0 011.875-2.753h4.375a2.125 2.125 0 012.125 1.673l1.675 2.092L21.875 12z"/>
                    </svg>
                </button>
            </div>

            <!-- Theme Modal (mobile) -->
            <div x-show="openThemeModal" x-cloak x-transition class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm items-center justify-center">
                <div class="bg-white dark:bg-slate-800 rounded-lg p-6 w-80 max-w-full shadow-xl transform scale-95 opacity-0"
                     @click.away="openThemeModal = false"
                     @click.self.stop>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4 text-center">Select Theme</h3>
                    <div class="space-y-3 mb-6">
                        <?php foreach (ThemeManager::getThemeNames() as $key => $theme): ?>
                        <button @click="selectTheme('<?= $key ?>'); openThemeModal = false"
                                class="w-full h-12 rounded-xl flex items-center justify-center border-2 <?= $key === ThemeManager::getCurrentTheme() ? 'border-medical-teal' : 'border-slate-300 dark:border-slate-600' ?> hover:border-medical-teal/30 transition-colors"
                                style="background: var(--bg-primary); color: var(--text-primary);">
                            <span class="text-sm font-medium"><?= $theme['name'] ?></span>
                        </button>
                        <?php endforeach; ?>
                    </div>
                    <button @click="openThemeModal = false"
                            class="w-full py-2 rounded-lg bg-medical-teal text-white text-sm font-medium hover:bg-medical-teal/90 transition">
                        Apply & Close
                    </button>
                </div>
            </div>



            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1">
                <?php
                $navItems = [
                    'dashboard' => ['icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Dashboard', 'group' => 'main'],
                    'conditions' => ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'label' => 'Conditions', 'group' => 'main'],
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

            <!-- Dark Mode & Mobile Menu -->
            <div class="flex items-center space-x-2">
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
                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar -->
    <div x-show="sidebarOpen" x-cloak x-transition class="lg:hidden bg-white dark:bg-slate-800 border-t dark:border-slate-700 shadow-lg">
        <div class="px-4 pt-2 pb-4 space-y-1">
            <?php foreach ($navItems as $key => $item): ?>
            <a href="?page=<?= $key ?>" @click="sidebarOpen = false"
               class="block sidebar-item <?= $page === $key ? 'bg-medical-teal/10 text-medical-teal' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50' ?>">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $item['icon'] ?>"/>
                </svg>
                <span><?= $item['label'] ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</header>