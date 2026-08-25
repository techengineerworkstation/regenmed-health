    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">PEMF Therapy Parameters</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Pulsed Electromagnetic Field therapy protocols for each condition. Evidence-based frequency, intensity, and duration settings.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <?php foreach ($pemfParams as $cond => $params): 
                $labels = [
                    'knee_arthritis' => 'Knee Osteoarthritis',
                    'osteoporosis' => 'Osteoporosis',
                    'retinal' => 'Macular Degeneration',
                    'male_fertility' => 'Male Enhancing Fertility',
                    'female_fertility' => 'Female Enhancing Fertility',
                    'prostate' => 'Prostate Challenges',
                ];
                $label = $labels[$cond] ?? ucfirst(str_replace('_', ' ', $cond));
            ?>
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 card-border card-hover">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-medical-amber/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-medical-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100"><?= $label ?></h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">Frequency</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $params['frequency'] ?></span>
                    </div>
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">Intensity</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $params['intensity'] ?></span>
                    </div>
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">Waveform</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $params['waveform'] ?></span>
                    </div>
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">Duration</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $params['duration'] ?></span>
                    </div>
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">Course</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $params['sessions'] ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- PEMF Mechanisms -->
        <section class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-700 card-border">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6">PEMF Mechanisms of Action</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 bg-medical-amber/5 dark:bg-medical-amber/10 rounded-xl border border-medical-amber/10 dark:border-medical-amber/20">
                    <h4 class="font-semibold text-medical-amber mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Stem Cell Enhancement
                    </h4>
                    <ul class="text-sm text-slate-600 dark:text-slate-300 space-y-1.5">
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-amber rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Stimulates stem cell proliferation
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-amber rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Promotes differentiation toward target tissue
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-amber rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Enhances cell survival post-transplantation
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-amber rounded-full mt-1.5 mr-2 flex-shrink-0"></span>"Window effects" — specific parameters per tissue
                        </li>
                    </ul>
                </div>
                <div class="p-6 bg-medical-teal/5 dark:bg-medical-teal/10 rounded-xl border border-medical-teal/10 dark:border-medical-teal/20">
                    <h4 class="font-semibold text-medical-teal mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 01.347 6.164v.001l-.002.001A4.5 4.5 0 0112 19.5a4.49 4.49 0 01-8.9-.5v-4a4.5 4.5 0 012.242-3.882z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 100-6 3 3 0 000 6z"/>
                        </svg>
                        Anti-Inflammatory
                    </h4>
                    <ul class="text-sm text-slate-600 dark:text-slate-300 space-y-1.5">
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-teal rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Reduces pro-inflammatory cytokines
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-teal rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Modulates immune response
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-teal rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Decreases edema and swelling
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-teal rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Promotes tissue healing cascade
                        </li>
                    </ul>
                </div>
                <div class="p-6 bg-medical-cyan/5 dark:bg-medical-cyan/10 rounded-xl border border-medical-cyan/10 dark:border-medical-cyan/20">
                    <h4 class="font-semibold text-medical-cyan mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Angiogenesis
                    </h4>
                    <ul class="text-sm text-slate-600 dark:text-slate-300 space-y-1.5">
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-cyan rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Promotes new blood vessel formation
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-cyan rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Improves tissue oxygenation
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-cyan rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Enhances nutrient delivery
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-cyan rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Supports wound healing
                        </li>
                    </ul>
                </div>
                <div class="p-6 bg-medical-violet/5 dark:bg-medical-violet/10 rounded-xl border border-medical-violet/10 dark:border-medical-violet/20">
                    <h4 class="font-semibold text-medical-violet mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 7c.831 0 1.5.669 1.5 1.5v4c0 .831-.669 1.5-1.5 1.5s-1.5-.669-1.5-1.5v-4c0-.831.669-1.5 1.5-1.5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 10V5a2 2 0 114 0v5m-4 0h4m-4 0v1a2 2 0 104 0v-1m-4 0h4"/>
                        </svg>
                        Pain Management
                    </h4>
                    <ul class="text-sm text-slate-600 dark:text-slate-300 space-y-1.5">
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-violet rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Modulates nerve signal transmission
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-violet rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Reduces chronic pain perception
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-violet rounded-full mt-1.5 mr-2 flex-shrink-0"></span>Non-invasive, no drug interactions
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 bg-medical-violet rounded-full mt-1.5 mr-2 flex-shrink-0"></span>FDA-cleared for bone healing
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </main>