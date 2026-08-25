    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Integrated Treatment Protocols</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Complete protocols combining stem cell therapy, PEMF, supplements, and imaging follow-up.</p>
        </div>

        <?php foreach ($conditions as $condKey => $cond): ?>
        <section class="mb-10 bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 card-border overflow-hidden">
            <div class="px-6 py-5 bg-gradient-to-r from-medical-teal to-medical-cyan text-white">
                <h2 class="text-xl font-bold"><?= $cond['name'] ?></h2>
                <p class="text-white/80 text-sm">ICD-10: <?= $cond['icd10'] ?></p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Phase 1 -->
                    <div class="p-5 bg-medical-teal/5 dark:bg-medical-teal/10 rounded-xl border border-medical-teal/10 dark:border-medical-teal/20">
                        <div class="flex items-center mb-3">
                            <div class="w-7 h-7 rounded-full bg-medical-teal text-white text-xs font-bold flex items-center justify-center mr-2">1</div>
                            <h4 class="font-semibold text-medical-teal text-sm">Pre-Treatment</h4>
                        </div>
                        <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-1.5">
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-teal rounded-full mt-1 mr-2 flex-shrink-0"></span>MRI imaging & AI grading
                            </li>
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-teal rounded-full mt-1 mr-2 flex-shrink-0"></span>PEMF preconditioning (2 weeks)
                            </li>
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-teal rounded-full mt-1 mr-2 flex-shrink-0"></span>Supplement loading (1 week)
                            </li>
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-teal rounded-full mt-1 mr-2 flex-shrink-0"></span>Stem cell harvest/prep
                            </li>
                        </ul>
                    </div>
                    <!-- Phase 2 -->
                    <div class="p-5 bg-medical-cyan/5 dark:bg-medical-cyan/10 rounded-xl border border-medical-cyan/10 dark:border-medical-cyan/20">
                        <div class="flex items-center mb-3">
                            <div class="w-7 h-7 rounded-full bg-medical-cyan text-white text-xs font-bold flex items-center justify-center mr-2">2</div>
                            <h4 class="font-semibold text-medical-cyan text-sm">Treatment</h4>
                        </div>
                        <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-1.5">
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-cyan rounded-full mt-1 mr-2 flex-shrink-0"></span>Guided stem cell injection
                            </li>
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-cyan rounded-full mt-1 mr-2 flex-shrink-0"></span>Image-guided delivery
                            </li>
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-cyan rounded-full mt-1 mr-2 flex-shrink-0"></span>Immediate post-procedure MRI
                            </li>
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-cyan rounded-full mt-1 mr-2 flex-shrink-0"></span>PEMF same day
                            </li>
                        </ul>
                    </div>
                    <!-- Phase 3 -->
                    <div class="p-5 bg-medical-indigo/5 dark:bg-medical-indigo/10 rounded-xl border border-medical-indigo/10 dark:border-medical-indigo/20">
                        <div class="flex items-center mb-3">
                            <div class="w-7 h-7 rounded-full bg-medical-indigo text-white text-xs font-bold flex items-center justify-center mr-2">3</div>
                            <h4 class="font-semibold text-medical-indigo text-sm">Recovery</h4>
                        </div>
                        <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-1.5">
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-indigo rounded-full mt-1 mr-2 flex-shrink-0"></span>Daily PEMF sessions
                            </li>
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-indigo rounded-full mt-1 mr-2 flex-shrink-0"></span>Continue supplements
                            </li>
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-indigo rounded-full mt-1 mr-2 flex-shrink-0"></span>Activity modification
                            </li>
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-indigo rounded-full mt-1 mr-2 flex-shrink-0"></span>3-month follow-up MRI
                            </li>
                        </ul>
                    </div>
                    <!-- Phase 4 -->
                    <div class="p-5 bg-medical-violet/5 dark:bg-medical-violet/10 rounded-xl border border-medical-violet/10 dark:border-medical-violet/20">
                        <div class="flex items-center mb-3">
                            <div class="w-7 h-7 rounded-full bg-medical-violet text-white text-xs font-bold flex items-center justify-center mr-2">4</div>
                            <h4 class="font-semibold text-medical-violet text-sm">Monitoring</h4>
                        </div>
                        <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-1.5">
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-violet rounded-full mt-1 mr-2 flex-shrink-0"></span>6-month MRI + AI comparison
                            </li>
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-violet rounded-full mt-1 mr-2 flex-shrink-0"></span>12-month comprehensive review
                            </li>
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-violet rounded-full mt-1 mr-2 flex-shrink-0"></span>Supplement adjustment
                            </li>
                            <li class="flex items-start">
                                <span class="w-1 h-1 bg-medical-violet rounded-full mt-1 mr-2 flex-shrink-0"></span>Maintenance protocol
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <?php endforeach; ?>