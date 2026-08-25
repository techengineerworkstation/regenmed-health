<footer class="bg-slate-900 dark:bg-slate-950 text-slate-300 dark:text-slate-400 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-medical-teal to-medical-cyan flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold gradient-text"><?= APP_NAME ?></span>
                </div>
                <p class="text-sm text-slate-400 dark:text-slate-500 max-w-md mb-4">Empowering growth in life, health, career, and world business. Personalized coaching and medical diagnostics to help you achieve balance, confidence, and lasting success — available online worldwide and across Nigeria.</p>
                <div class="flex space-x-2 mb-4">
                    <span class="px-3 py-1 bg-medical-teal/20 text-medical-teal text-xs rounded-full font-medium">HIPAA Aware</span>
                    <span class="px-3 py-1 bg-medical-cyan/20 text-medical-cyan text-xs rounded-full font-medium">100% Confidential</span>
                    <span class="px-3 py-1 bg-medical-indigo/20 text-medical-indigo text-xs rounded-full font-medium">AI-Powered</span>
                </div>
                <div class="flex items-center space-x-4 text-sm">
                    <a href="tel:+2347010744142" class="flex items-center space-x-1 text-slate-400 hover:text-medical-teal transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>+234 701 074 4142</span>
                    </a>
                    <a href="mailto:Ibe@coachandheal.store" class="flex items-center space-x-1 text-slate-400 hover:text-medical-teal transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Ibe@coachandheal.store</span>
                    </a>
                </div>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Challenges</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="?page=conditions&condition=knee_arthritis" class="hover:text-medical-teal transition">Knee Osteoarthritis</a></li>
                    <li><a href="?page=conditions&condition=retinal_degeneration" class="hover:text-medical-teal transition">Macular Degeneration</a></li>
                    <li><a href="?page=conditions&condition=male_factor_enhancing_fertility" class="hover:text-medical-teal transition">Male Enhancing Fertility</a></li>
                    <li><a href="?page=conditions&condition=female_factor_enhancing_fertility" class="hover:text-medical-teal transition">Female Enhancing Fertility</a></li>
                    <li><a href="?page=conditions&condition=prostate_disease" class="hover:text-medical-teal transition">Prostate Disease</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Resources</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="?page=imaging" class="hover:text-medical-teal transition">Imaging Protocols</a></li>
                    <li><a href="?page=protocols" class="hover:text-medical-teal transition">Treatment Protocols</a></li>
                    <li><a href="?page=supplements" class="hover:text-medical-teal transition">Supplement Database</a></li>
                    <li><a href="?page=vps-providers" class="hover:text-medical-teal transition">GPU Cloud Providers</a></li>
                    <li><a href="?page=references" class="hover:text-medical-teal transition">Clinical References</a></li>
                </ul>
            </div>
        </div>
        <!-- News & Best Practices Feed -->
        <?php if (!empty($newsFeed)): ?>
        <div class="border-t border-slate-800 dark:border-slate-800/50 mt-8 pt-8 mb-8">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-medical-indigo to-medical-violet flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider">News & Best Practices</h4>
                <span class="text-xs text-slate-500">· Latest developments in regenerative medicine</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach (array_slice($newsFeed, 0, 6) as $news): ?>
                <a href="<?= htmlspecialchars($news['link'] ?? '#') ?>" target="_blank" rel="noopener"
                   class="block p-4 rounded-xl bg-slate-800/50 hover:bg-slate-800 border border-slate-700/50 transition group">
                    <p class="text-sm font-medium text-white group-hover:text-medical-teal transition line-clamp-2 mb-2"><?= htmlspecialchars($news['title'] ?? '') ?></p>
                    <?php if (!empty($news['description'])): ?>
                    <p class="text-xs text-slate-400 line-clamp-2 mb-2"><?= htmlspecialchars(mb_substr($news['description'], 0, 120)) ?>…</p>
                    <?php endif; ?>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-medical-teal font-medium"><?= htmlspecialchars($news['source'] ?? '') ?></span>
                        <?php if (!empty($news['date'])): ?>
                        <span class="text-xs text-slate-500">· <?= htmlspecialchars($news['date']) ?></span>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="border-t border-slate-800 dark:border-slate-800/50 mt-8 pt-8 flex flex-col md:flex-row items-center justify-between">
            <p class="text-xs text-slate-500 dark:text-slate-600">&copy; <?= date('Y') ?> <?= APP_NAME ?> by Coach Ibe / Ibereal Enterprise. For research and educational purposes only. Not a substitute for professional medical advice.</p>
            <p class="text-xs text-slate-500 dark:text-slate-600 mt-2 md:mt-0">Version <?= APP_VERSION ?> | PHP <?= phpversion() ?></p>
        </div>
    </div>
</footer>
