    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Carousel Hero Section -->
        <section class="relative rounded-3xl overflow-hidden mb-12 animate-fade-in"
                 x-data="{
                     currentSlide: 0,
                     autoplay: true,
                     slides: [
                         {
                             title: 'AI-Assisted Diagnostic Platform',
                             subtitle: 'Regenerative Medicine Diagnostic System',
                             description: 'Integrating medical imaging, stem cell therapy protocols, PEMF parameters, and evidence-based supplement regimens for comprehensive patient care planning.',
                             cta: 'Explore Conditions',
                             ctaLink: '?page=conditions',
                             badge: 'AI-Assisted Diagnostics',
                             gradient: 'from-medical-teal via-medical-cyan to-medical-indigo',
                         },
                         {
                             title: 'Stem Cell Therapy Protocols',
                             subtitle: 'Evidence-Based Cell Sources & Delivery',
                             description: 'Comprehensive stem cell therapy protocols with cell sourcing guides, delivery methods, and AI-enhanced MRI tracking for 5 conditions.',
                             cta: 'View Stem Cell Protocols',
                             ctaLink: '?page=stem-cells',
                             badge: 'Stem Cell Therapy',
                             gradient: 'from-medical-violet via-medical-indigo to-medical-cyan',
                         },
                         {
                             title: 'PEMF Treatment Parameters',
                             subtitle: 'Precision Electromagnetic Therapy',
                             description: 'Condition-specific PEMF frequency, intensity, and duration settings that enhance stem cell activity and promote tissue regeneration.',
                             cta: 'View PEMF Parameters',
                             ctaLink: '?page=pemf',
                             badge: 'PEMF Therapy',
                             gradient: 'from-medical-amber via-medical-rose to-medical-indigo',
                         },
                         {
                             title: 'Clinical References',
                             subtitle: 'Evidence-Based Decision Support',
                             description: 'Browse clinical references, supplement databases, and comprehensive treatment protocols backed by peer-reviewed research.',
                             cta: 'View All References',
                             ctaLink: '?page=references',
                             badge: 'References',
                             gradient: 'from-medical-cyan via-medical-teal to-medical-indigo',
                         },
                     ],
                     nextSlide() {
                         this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                     },
                     prevSlide() {
                         this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                     },
                     goToSlide(index) {
                         this.currentSlide = index;
                     },
                 }"
                 x-init="setInterval(() => { if (autoplay) nextSlide(); }, 6000)">

            <!-- Slide Backgrounds -->
            <template x-for="(slide, index) in slides" :key="index">
                <div class="absolute inset-0 transition-all duration-1000 ease-in-out"
                     :class="currentSlide === index ? 'opacity-100' : 'opacity-0'">
                    <div class="absolute inset-0 bg-gradient-to-br"
                         :class="slide.gradient"></div>
                    <div class="absolute inset-0 medical-grid opacity-20"></div>
                </div>
            </template>

            <div class="relative px-8 py-16 md:py-20 lg:px-16">
                <div class="max-w-3xl">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="currentSlide === index" x-cloak x-transition:enter="transition ease-out duration-500"
                                               x-transition:enter-start="opacity-0 translate-y-4"
                                               x-transition:enter-end="opacity-100 translate-y-0"
                                               x-transition:leave="transition ease-in duration-300"
                                               x-transition:leave-start="opacity-100 translate-y-0"
                                               x-transition:leave-end="opacity-0 translate-y-4">
                            <span class="inline-flex items-center px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-sm font-medium rounded-full mb-4">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                <span x-text="slide.badge"></span>
                            </span>
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                                <span x-text="slide.title"></span><br>
                                <span class="text-white/80" x-text="slide.subtitle"></span>
                            </h1>
                            <p class="text-lg text-white/80 mb-8 max-w-2xl" x-text="slide.description"></p>
                            <div class="flex flex-wrap gap-3">
                                <a :href="slide.ctaLink"
                                   class="px-6 py-3 bg-white text-medical-teal font-semibold rounded-xl hover:bg-white/90 transition shadow-lg shadow-medical-teal/20 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19.428 15.428a2 2 0 01-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 01-1.806-.547M8 4h8l-1 1v5.172a2 2 0 01.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                    <span x-text="slide.cta"></span>
                                </a>
                                <a href="?page=case-study"
                                   class="px-6 py-3 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-xl border border-white/20 hover:bg-white/20 transition">
                                    View Case Study
                                </a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Carousel Controls -->
            <button @click="prevSlide()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 backdrop-blur-sm text-white rounded-xl hover:bg-white/20 border border-white/20 transition flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="nextSlide()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 backdrop-blur-sm text-white rounded-xl hover:bg-white/20 border border-white/20 transition flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Pagination Dots -->
            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex space-x-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="goToSlide(index)"
                            class="w-2.5 h-2.5 rounded-full transition-all duration-300 flex items-center justify-center"
                            :class="currentSlide === index
                                ? 'bg-white w-6'
                                : 'bg-white/30 hover:bg-white/50'">
                    </button>
                </template>
            </div>
        </section>

        <!-- Quick Stats -->
        <section class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
            <?php
            $stats = [
                ['label' => 'Conditions', 'value' => '5', 'color' => 'medical-teal', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['label' => 'Imaging Modalities', 'value' => '15+', 'color' => 'medical-cyan', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 012-2H6a2 2 0 01-2 2v12a2 2 0 012 2z'],
                ['label' => 'Treatment Protocols', 'value' => '25+', 'color' => 'medical-indigo', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 01-1.806.547M8 4h8l-1 1v5.172a2 2 0 01.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                ['label' => 'Supplements', 'value' => '50+', 'color' => 'medical-violet', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
            ];
            foreach ($stats as $stat):
            ?>
            <div class="bg-white dark:bg-slate-800/50 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 card-hover">
                <div class="w-10 h-10 rounded-xl bg-<?= $stat['color'] ?>/10 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-<?= $stat['color'] ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $stat['icon'] ?>"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-slate-900 dark:text-slate-100"><?= $stat['value'] ?></p>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1"><?= $stat['label'] ?></p>
            </div>
            <?php endforeach; ?>
        </section>

        <!-- Condition Cards -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Diagnostic Modules</h2>
                <a href="?page=conditions" class="text-medical-teal text-sm font-medium hover:underline flex items-center">View All <span class="ml-1">→</span></a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $conditionCards = [
                    ['key' => 'knee_arthritis', 'title' => 'Knee Osteoarthritis', 'icd' => 'M17', 'modality' => 'MRI', 'gradient' => 'from-teal-500 to-emerald-600', 'findings' => 'Cartilage loss, osteophytes, subchondral sclerosis'],
                    ['key' => 'retinal_degeneration', 'title' => 'Macular Degeneration', 'icd' => 'H35.30', 'modality' => 'OCT', 'gradient' => 'from-cyan-500 to-blue-600', 'findings' => 'Drusen, GA, subretinal fluid, CNV'],
                    ['key' => 'male_factor_enhancing_fertility', 'title' => 'Male Enhancing Fertility', 'icd' => 'N46', 'modality' => 'Scrotal US', 'gradient' => 'from-indigo-500 to-violet-600', 'findings' => 'Varicocele, semen analysis, testicular volume'],
                    ['key' => 'female_factor_enhancing_fertility', 'title' => 'Female Enhancing Fertility', 'icd' => 'N97', 'modality' => 'TV US', 'gradient' => 'from-purple-500 to-fuchsia-600', 'findings' => 'Follicle count, endometrial thickness, uterine anomalies'],
                    ['key' => 'prostate_disease', 'title' => 'Prostate Disease', 'icd' => 'N40/N41', 'modality' => 'mpMRI', 'gradient' => 'from-blue-500 to-indigo-600', 'findings' => 'Prostate volume, PI-RADS, transition zone'],
                ];
                foreach ($conditionCards as $card):
                ?>
                <a href="?page=conditions&condition=<?= $card['key'] ?>" class="group block bg-white dark:bg-slate-800/50 dark:border-slate-700/50 rounded-2xl overflow-hidden shadow-sm border border-slate-100 card-hover">
                    <div class="h-32 bg-gradient-to-br <?= $card['gradient'] ?> relative overflow-hidden">
                        <div class="absolute inset-0 medical-grid opacity-20"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="px-2 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-medium rounded-full">Diagnostic</span>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-slate-900 dark:text-slate-100 group-hover:text-medical-teal transition"><?= $card['title'] ?></h3>
                            <span class="text-xs font-mono text-slate-400 bg-slate-50 dark:bg-slate-700/50 px-2 py-0.5 rounded"><?= $card['icd'] ?></span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-3"><?= $card['findings'] ?></p>
                        <div class="flex items-center text-medical-teal text-sm font-medium">
                            <span>View Protocol</span>
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Integrated Pipeline -->
        <section class="mb-12">
            <div class="bg-white dark:bg-slate-800/50 dark:border-slate-700/50 rounded-3xl p-8 shadow-sm border border-slate-100 dark:border-slate-700 card-border">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-6">Integrated Diagnostic Pipeline</h2>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <?php
                    $pipeline = [
                        ['step' => '1', 'title' => 'Patient Intake', 'desc' => 'History, symptoms, risk factors', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['step' => '2', 'title' => 'Imaging', 'desc' => 'MRI/US/OCT per protocol', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 01-2 2v12a2 2 0 012 2z'],
                        ['step' => '3', 'title' => 'AI Analysis', 'desc' => 'Segmentation, grading, findings', 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
                        ['step' => '4', 'title' => 'Treatment Plan', 'desc' => 'Stem cells + PEMF + supplements', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 01-1.806.547M8 4h8l-1 1v5.172a2 2 0 01.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                        ['step' => '5', 'title' => 'Monitoring', 'desc' => 'Serial imaging + AI comparison', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 01-2 2v6a2 2 0 012 2h2a2 2 0 012-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                    ];
                    foreach ($pipeline as $i => $step):
                    ?>
                    <div class="relative" style="animation-delay: <?= $i * 100 ?>ms">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-medical-teal to-medical-cyan flex items-center justify-center mb-3 shadow-lg shadow-medical-teal/20">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $step['icon'] ?>"/>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-medical-teal mb-1">STEP <?= $step['step'] ?></span>
                            <h3 class="font-semibold text-slate-900 dark:text-slate-100 text-sm mb-1"><?= $step['title'] ?></h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400"><?= $step['desc'] ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- GPU Cloud Recommendation -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-slate-800/50 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 card-hover">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-medical-teal/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-medical-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
                    </div>
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100">Free GPU for AI Training</h3>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Start prototyping medical imaging models at zero cost.</p>
                <div class="bg-medical-teal/5 dark:bg-medical-teal/10 rounded-xl p-4 border border-medical-teal/10">
                    <p class="font-medium text-medical-teal mb-2">Recommended: Google Colab</p>
                    <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-1">
                        <li>• T4 GPU (15GB VRAM) - Free tier</li>
                        <li>• A100 (40GB) - Pro ($9.99/mo)</li>
                        <li>• Pre-installed PyTorch & TensorFlow</li>
                        <li>• 12-hour sessions</li>
                    </ul>
                </div>
                <a href="?page=vps-providers" class="inline-flex items-center text-sm font-medium text-medical-teal hover:underline mt-4">
                    Compare all GPU providers →
                </a>
            </div>
            <div class="bg-white dark:bg-slate-800/50 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 card-hover">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-medical-cyan/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-medical-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100">PEMF + Stem Cell Synergy</h3>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Evidence-based electromagnetic enhancement of regenerative protocols.</p>
                <div class="bg-medical-cyan/5 dark:bg-medical-cyan/10 rounded-xl p-4 border border-medical-cyan/10">
                    <p class="font-medium text-medical-cyan mb-2">Key Mechanism</p>
                    <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-1">
                        <li>• PEMF stimulates stem cell proliferation</li>
                        <li>• Enhances differentiation toward target tissue</li>
                        <li>• Reduces inflammation, promotes angiogenesis</li>
                        <li>• "Window effects" — specific parameters per condition</li>
                    </ul>
                </div>
                <a href="?page=pemf" class="inline-flex items-center text-sm font-medium text-medical-cyan hover:underline mt-4">
                    View PEMF parameters →
                </a>
            </div>
        </section>
    </main>