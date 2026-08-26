    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Stem Cell Therapy Protocols</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Evidence-based stem cell sources, delivery methods, and cell counts for each condition.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
            <?php
            $stemCellProtocols = [
                ['condition' => 'Knee Osteoarthritis', 'sources' => ['Bone Marrow Concentrate (BMC)', 'Umbilical Cord MSC', 'Adipose-derived SVF'], 'delivery' => 'Intra-articular injection under ultrasound/fluoroscopy guidance', 'cells' => '1x10^7 to 1x10^8', 'sessions' => '1-2 injections, 6-12 months apart'],
                ['condition' => 'Macular Degeneration', 'sources' => ['iPSC-derived RPE cells', 'UC-MSC', 'Retinal progenitor cells'], 'delivery' => 'Subretinal injection by vitreoretinal surgeon', 'cells' => '1x10^5 to 5x10^5 RPE cells', 'sessions' => 'Single procedure, long-term monitoring'],
                ['condition' => 'Male Enhancing Fertility', 'sources' => ['MSC (autologous)', 'UC-MSC', 'Testicular stem cells'], 'delivery' => 'Intratesticular injection or IV infusion', 'cells' => '1x10^6 to 1x10^7', 'sessions' => '1-3 treatments over 3 months'],
                ['condition' => 'Female Enhancing Fertility', 'sources' => ['UC-MSC', 'BMC', 'Ovarian stem cells'], 'delivery' => 'Intrauterine, intraovarian, or IV', 'cells' => '1x10^7 to 5x10^7', 'sessions' => '1-2 treatments per cycle'],
                ['condition' => 'Prostate Challenge', 'sources' => ['MSC (autologous)', 'UC-MSC', 'Adipose SVF'], 'delivery' => 'Transperineal injection or IV infusion', 'cells' => '1x10^7', 'sessions' => '1-2 treatments over 3 months'],
            ];
            foreach ($stemCellProtocols as $protocol):
            ?>
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 card-border card-hover">
                <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-medical-violet mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <?= $protocol['condition'] ?>
                </h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-slate-500 dark:text-slate-400 text-xs uppercase font-medium mb-1.5">Cell Sources</p>
                        <ul class="space-y-1.5">
                            <?php foreach ($protocol['sources'] as $source): ?>
                            <li class="flex items-center text-slate-700 dark:text-slate-300">
                                <span class="w-1.5 h-1.5 bg-medical-violet rounded-full mr-2 flex-shrink-0"></span>
                                <span><?= $source ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <p class="text-slate-500 dark:text-slate-400 text-xs uppercase font-medium mb-1.5">Delivery Method</p>
                        <p class="text-slate-700 dark:text-slate-300"><?= $protocol['delivery'] ?></p>
                    </div>
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">Cell Count</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $protocol['cells'] ?></span>
                    </div>
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">Sessions</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $protocol['sessions'] ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- MRI Tracking -->
        <section class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-700 card-border">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6">MRI-Based Stem Cell Tracking</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-5 bg-slate-50 dark:bg-slate-700/30 rounded-xl border border-slate-100 dark:border-slate-700/50">
                    <h4 class="font-semibold text-slate-900 dark:text-slate-100 mb-2 flex items-center">
                        <svg class="w-4 h-4 text-medical-teal mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11.25 11.25l.041-.020a.75.75 0 00-.982-.982L11.25 10.25h.001zm0 0a2.25 2.25 0 01-2.25 2.25h-1.5a.75.75 0 01-.75-.75V10a.75.75 0 01.75-.75h.041a2.25 2.25 0 01.982.982z"/>
                        </svg>
                        Fluorine Tracer (UC San Diego)
                    </h4>
                    <p class="text-sm text-slate-600 dark:text-slate-300">Fluorine-based tracer labels stem cells for MRI visibility. Bright, high-contrast hot-spots with no background noise.</p>
                </div>
                <div class="p-5 bg-slate-50 dark:bg-slate-700/30 rounded-xl border border-slate-100 dark:border-slate-700/50">
                    <h4 class="font-semibold text-slate-900 dark:text-slate-100 mb-2 flex items-center">
                        <svg class="w-4 h-4 text-medical-cyan mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11.25 11.25l.041-.020a.75.75 0 00-.982-.982L11.25 10.25h.001zm0 0a2.25 2.25 0 01-2.25 2.25h-1.5a.75.75 0 01-.75-.75V10a.75.75 0 01.75-.75h.041a2.25 2.25 0 01.982.982z"/>
                        </svg>
                        Iron Oxide Labeling
                    </h4>
                    <p class="text-sm text-slate-600 dark:text-slate-300">SPIO nanoparticles create hypointensities on T2*-weighted MRI. Clinical-grade formulations available.</p>
                </div>
                <div class="p-5 bg-slate-50 dark:bg-slate-700/30 rounded-xl border border-slate-100 dark:border-slate-700/50">
                    <h4 class="font-semibold text-slate-900 dark:text-slate-100 mb-2 flex items-center">
                        <svg class="w-4 h-4 text-medical-indigo mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11.25 11.25l.041-.020a.75.75 0 00-.982-.982L11.25 10.25h.001zm0 0a2.25 2.25 0 01-2.25 2.25h-1.5a.75.75 0 01-.75-.75V10a.75.75 0 01.75-.75h.041a2.25 2.25 0 01.982.982z"/>
                        </svg>
                        Serial Lab Scan Protocol
                    </h4>
                    <p class="text-sm text-slate-600 dark:text-slate-300">Baseline MRI → Post-injection → 3/6/12 month follow-up. AI quantifies cell migration and tissue regeneration.</p>
                </div>
            </div>
        </section>
    </main>