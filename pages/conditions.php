    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Condition Profiles</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Complete diagnostic protocols including imaging findings, severity grading, and integrated treatment planning.</p>
        </div>

        <!-- Condition Selector -->
        <div class="flex flex-wrap gap-2 mb-8 pb-2 border-b border-slate-200 dark:border-slate-700">
            <?php foreach ($conditions as $key => $cond): ?>
            <a href="?page=conditions&condition=<?= $key ?>"
               class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 <?= ($_GET['condition'] ?? 'knee_arthritis') === $key
                   ? 'bg-medical-teal text-white shadow-lg shadow-medical-teal/30'
                   : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 border border-slate-200 dark:border-slate-700' ?>">
                <?= $cond['name'] ?>
            </a>
            <?php endforeach; ?>
        </div>

        <?php
        $currentCondition = $_GET['condition'] ?? 'knee_arthritis';
        $cond = $conditions[$currentCondition] ?? $conditions['knee_arthritis'];
        $protocol = $protocols[$currentCondition] ?? $protocols['knee_arthritis'];
        ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" style="animation: slideIn 0.5s ease-out;">
            <!-- Left Column: Diagnostic Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Diagnostic Window -->
                <div class="diagnostic-window rounded-2xl overflow-hidden relative group dark:border-slate-700">
                    <div class="absolute top-0 left-0 right-0 h-9 bg-slate-800 dark:bg-slate-800 flex items-center px-4 space-x-2 border-b border-slate-700">
                        <div class="flex space-x-1.5">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                        </div>
                        <span class="ml-4 text-xs text-slate-400 font-mono">
                            <?= strtoupper(str_replace('_', ' ', $currentCondition)) ?> — DIAGNOSTIC VIEW
                        </span>
                    </div>
                    <div class="p-6 pt-14 relative">
                        <div class="bg-slate-800/30 rounded-xl p-6 sm:p-8 flex flex-col items-center justify-center min-h-[280px] border border-slate-700 dark:border-slate-700/50">
                            <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-br from-medical-teal/20 to-medical-cyan/20 flex items-center justify-center border border-medical-teal/30">
                                <svg class="w-12 h-12 text-medical-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 012-2V6a2 2 0 012-2H6a2 2 0 01-2 2v12a2 2 0 012 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-white font-semibold text-lg mb-2"><?= $cond['name'] ?></h3>
                            <p class="text-slate-400 text-sm mb-4"><?= $cond['window']['view'] ?></p>
                            <div class="inline-flex items-center px-3 py-1.5 bg-medical-teal/20 border border-medical-teal/30 rounded-full">
                                <span class="text-medical-teal text-xs font-medium">Key Finding: <?= $cond['window']['highlight'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Key Findings -->
                <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 card-border">
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-medical-teal mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Key Imaging Findings
                    </h3>
                    <ul class="findings-list grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-slate-700 dark:text-slate-300">
                        <?php foreach ($cond['key_findings'] as $finding): ?>
                        <li class="flex items-center p-2 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                            <span class="w-1.5 h-1.5 bg-medical-teal rounded-full mr-2 flex-shrink-0"></span>
                            <span><?= $finding ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Severity Grading -->
                <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 card-border">
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-medical-cyan mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 01-2-2v6a2 2 0 012 2h2a2 2 0 012-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Severity Grading
                    </h3>
                    <div class="space-y-2">
                        <?php foreach ($cond['severity_grades'] as $i => $grade):
                            $colors = [
                                'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 border-green-200 dark:border-green-800',
                                'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 border-yellow-200 dark:border-yellow-800',
                                'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 border-orange-200 dark:border-orange-800',
                                'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800',
                                'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 border-purple-200 dark:border-purple-800',
                            ];
                            $color = $colors[$i] ?? $colors[0];
                        ?>
                        <div class="flex items-center justify-between p-3 rounded-lg border <?= $color ?>">
                            <span class="text-sm font-medium"><?= $grade ?></span>
                            <div class="flex space-x-1">
                                <?php for ($j = 0; $j <= $i; $j++): ?>
                                <div class="w-2 h-2 rounded-full bg-current opacity-60"></div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Treatment Protocol -->
            <div class="space-y-6">
                <!-- Stem Cell Protocol -->
                <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 card-border">
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-medical-violet mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Stem Cell Protocol
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                            <span class="text-slate-500 dark:text-slate-400">Source</span>
                            <span class="font-medium text-slate-900 dark:text-slate-200"><?= $protocol['stem_cell']['source'] ?></span>
                        </div>
                        <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                            <span class="text-slate-500 dark:text-slate-400">Delivery</span>
                            <span class="font-medium text-slate-900 dark:text-slate-200"><?= $protocol['stem_cell']['delivery'] ?></span>
                        </div>
                        <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                            <span class="text-slate-500 dark:text-slate-400">Cell Count</span>
                            <span class="font-medium text-slate-900 dark:text-slate-200"><?= $protocol['stem_cell']['cells'] ?></span>
                        </div>
                    </div>
                </div>

                <!-- PEMF Protocol -->
                <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 card-border">
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-medical-amber mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        PEMF Protocol
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                            <span class="text-slate-500 dark:text-slate-400">Frequency</span>
                            <span class="font-medium text-slate-900 dark:text-slate-200"><?= $protocol['pemf']['frequency'] ?></span>
                        </div>
                        <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                            <span class="text-slate-500 dark:text-slate-400">Intensity</span>
                            <span class="font-medium text-slate-900 dark:text-slate-200"><?= $protocol['pemf']['intensity'] ?></span>
                        </div>
                        <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                            <span class="text-slate-500 dark:text-slate-400">Duration</span>
                            <span class="font-medium text-slate-900 dark:text-slate-200"><?= $protocol['pemf']['duration'] ?></span>
                        </div>
                    </div>
                </div>

                <!-- Supplement Protocol -->
                <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 card-border">
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-medical-teal mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19.428 15.428a2 2 0 01-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 01-1.806.547M8 4h8l-1 1v5.172a2 2 0 01.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        Supplements
                    </h3>
                    <ul class="space-y-2 text-sm text-slate-700 dark:text-slate-300">
                        <?php foreach ($protocol['supplements'] as $supp): ?>
                        <li class="flex items-center p-1.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                            <span class="w-1.5 h-1.5 bg-medical-teal rounded-full mr-2 flex-shrink-0"></span>
                            <span><?= $supp ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Herbal Protocol -->
                <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 card-border">
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        Herbal Medicine
                    </h3>
                    <ul class="space-y-2 text-sm text-slate-700 dark:text-slate-300">
                        <?php foreach ($protocol['herbs'] as $herb): ?>
                        <li class="flex items-center p-1.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2 flex-shrink-0"></span>
                            <span><?= $herb ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </main>