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
                <p class="text-sm text-slate-400 dark:text-slate-500 max-w-md mb-4"><?= APP_DESCRIPTION ?>. Integrating medical imaging, regenerative medicine, and AI-assisted diagnostics for evidence-based treatment planning.</p>
                <div class="flex space-x-2">
                    <span class="px-3 py-1 bg-medical-teal/20 text-medical-teal text-xs rounded-full font-medium">HIPAA Aware</span>
                    <span class="px-3 py-1 bg-medical-cyan/20 text-medical-cyan text-xs rounded-full font-medium">Research Use</span>
                    <span class="px-3 py-1 bg-medical-indigo/20 text-medical-indigo text-xs rounded-full font-medium">AI-Powered</span>
                </div>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Conditions</h4>
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
        <div class="border-t border-slate-800 dark:border-slate-800/50 mt-8 pt-8 flex flex-col md:flex-row items-center justify-between">
            <p class="text-xs text-slate-500 dark:text-slate-600">&copy; <?= date('Y') ?> <?= APP_NAME ?>. For research and educational purposes only. Not a substitute for professional medical advice.</p>
            <p class="text-xs text-slate-500 dark:text-slate-600 mt-2 md:mt-0">Version <?= APP_VERSION ?> | PHP <?= phpversion() ?></p>
        </div>
    </div>
</footer>
