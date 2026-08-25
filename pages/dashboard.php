    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Carousel Hero Section -->
        <section class="relative rounded-3xl overflow-hidden mb-12 animate-fade-in"
                 x-data="{
                     currentSlide: 0,
                     autoplay: true,
                     slides: [
                         {
                             title: 'Empowering Growth in Life, Health & World Business',
                             subtitle: 'Coach & Heal — Regen Med Health',
                             description: 'Certified life, health, career & world business coaching — designed to help you find clarity, build confidence, and create lasting change. Medical scans, tests, and recommendations for a complete wellness journey.',
                             cta: 'Book Free Discovery Call',
                             ctaLink: '#contact',
                             badge: 'Available Online Worldwide & In-Person Across Nigeria',
                             gradient: 'from-medical-teal via-medical-cyan to-medical-indigo',
                         },
                         {
                             title: 'Health Coaching & Regenerative Medicine',
                             subtitle: 'Small Habits, Big Change',
                             description: 'Feeling run down, stressed, or out of sync? We help you build sustainable habits — better sleep, more energy, clearer mind — combined with medical scans, stem cell therapy protocols, and PEMF parameters.',
                             cta: 'Explore Health Programs',
                             ctaLink: '?page=conditions',
                             badge: 'Health Coaching + Medical Diagnostics',
                             gradient: 'from-emerald-600 via-teal-500 to-cyan-500',
                         },
                         {
                             title: 'Wellness Technology & Medical Imaging',
                             subtitle: 'See What\'s Happening Inside',
                             description: 'Our gentle, non-invasive sensors give you a window into your body\'s natural rhythms — MRI, OCT, ultrasound, and mpMRI diagnostics combined with real-time wellness data for smarter choices.',
                             cta: 'View Imaging Protocols',
                             ctaLink: '?page=imaging',
                             badge: 'Wellness Tech + Diagnostic Imaging',
                             gradient: 'from-medical-violet via-medical-indigo to-medical-cyan',
                         },
                         {
                             title: 'Life, Career & World Business Coaching',
                             subtitle: 'Clarity, Confidence & Lasting Success',
                             description: 'Whether you\'re looking for personal growth, career advancement, or world business success — we walk alongside you with 12-16 week programs designed around your goals.',
                             cta: 'Explore All Services',
                             ctaLink: '#services',
                             badge: '4 Coaching Programs',
                             gradient: 'from-medical-amber via-medical-rose to-medical-indigo',
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
                ['label' => 'People Transformed', 'value' => '500+', 'color' => 'medical-teal', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['label' => 'Coaching Programs', 'value' => '4', 'color' => 'medical-cyan', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 01-1.806.547M8 4h8l-1 1v5.172a2 2 0 01.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                ['label' => 'Challenges', 'value' => '5', 'color' => 'medical-indigo', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['label' => 'Confidential', 'value' => '100%', 'color' => 'medical-violet', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
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

        <!-- What We Offer — Coaching Services -->
        <section id="services" class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Coaching That Meets You Wherever You Are</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Every person's journey is different. These services help you grow, heal, and thrive.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $coachingCards = [
                    ['title' => 'Life Coaching', 'duration' => '8–12 weeks', 'gradient' => 'from-teal-500 to-emerald-600', 'desc' => 'Find clarity, overcome limiting beliefs, and build a life that feels meaningful — on your terms.', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                    ['title' => 'Career Coaching', 'duration' => '6–10 weeks', 'gradient' => 'from-cyan-500 to-blue-600', 'desc' => 'Eyeing a promotion, changing careers, or coming back after a break — find your footing and move forward.', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['title' => 'Health Coaching', 'duration' => '8–12 weeks', 'gradient' => 'from-indigo-500 to-violet-600', 'desc' => 'Build small, sustainable habits for more energy, better sleep, and a clearer mind — no extreme diets.', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                    ['title' => 'World Business Coaching', 'duration' => '12–16 weeks', 'gradient' => 'from-purple-500 to-fuchsia-600', 'desc' => 'Build strategy, systems, and leadership skills to grow sustainably — without losing yourself in the process.', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['title' => 'Wellness Technology', 'duration' => 'Ongoing', 'gradient' => 'from-amber-500 to-rose-600', 'desc' => 'Gentle, non-invasive sensors give you a window into your body\'s natural rhythms for smarter daily choices.', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['title' => 'Medical Diagnostics', 'duration' => 'Per Protocol', 'gradient' => 'from-blue-500 to-indigo-600', 'desc' => 'MRI, OCT, ultrasound, mpMRI — AI-assisted diagnostic imaging combined with regenerative medicine protocols.', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 012-2H6a2 2 0 01-2 2v12a2 2 0 012 2z'],
                ];
                foreach ($coachingCards as $card):
                ?>
                <a href="?page=conditions" class="group block bg-white dark:bg-slate-800/50 dark:border-slate-700/50 rounded-2xl overflow-hidden shadow-sm border border-slate-100 card-hover">
                    <div class="h-32 bg-gradient-to-br <?= $card['gradient'] ?> relative overflow-hidden">
                        <div class="absolute inset-0 medical-grid opacity-20"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="px-2 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-medium rounded-full"><?= $card['duration'] ?></span>
                        </div>
                        <div class="absolute top-4 right-4 text-white/30">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="<?= $card['icon'] ?>"/>
                            </svg>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-slate-900 dark:text-slate-100 group-hover:text-medical-teal transition mb-2"><?= $card['title'] ?></h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-3"><?= $card['desc'] ?></p>
                        <div class="flex items-center text-medical-teal text-sm font-medium">
                            <span>Learn More</span>
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Privacy Banner -->
        <section class="mb-12">
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 dark:from-slate-800 dark:to-slate-900 rounded-3xl p-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 medical-grid opacity-10"></div>
                <div class="relative flex flex-col md:flex-row items-center gap-6">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-medical-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Complete Privacy — Your Data Stays Yours</h3>
                        <p class="text-white/70 text-sm">No cloud uploads, no third-party access, no surprises. We've built our entire system with your privacy at its core. Your most personal information stays yours.</p>
                    </div>
                    <a href="#contact" class="ml-auto px-6 py-3 bg-medical-teal text-white font-semibold rounded-xl hover:bg-medical-teal/90 transition flex-shrink-0">
                        Learn More
                    </a>
                </div>
            </div>
        </section>

        <!-- Condition Cards (Challenges) -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Diagnostic Challenges</h2>
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
                            <span class="px-2 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-medium rounded-full"><?= $card['modality'] ?></span>
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

        <!-- How It Works -->
        <section class="mb-12">
            <div class="bg-white dark:bg-slate-800/50 dark:border-slate-700/50 rounded-3xl p-8 shadow-sm border border-slate-100 dark:border-slate-700 card-border">
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-2">Your Journey With Us Starts Simple</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">No complicated onboarding, no overwhelming programs. Just a straightforward path from where you are to where you want to be.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <?php
                    $steps = [
                        ['step' => '01', 'title' => "Let's Talk", 'desc' => 'It all starts with a conversation — no commitment, no pressure. We listen to where you are and what you\'d love to change.', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                        ['step' => '02', 'title' => 'Find Your Direction', 'desc' => 'Together, we explore what\'s been holding you back and what\'s possible when those barriers start to shift.', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'],
                        ['step' => '03', 'title' => 'Grow at Your Pace', 'desc' => 'Through regular one-on-one sessions, you build new habits, develop stronger skills, and start seeing real changes.', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
                        ['step' => '04', 'title' => 'Thrive in Every Area', 'desc' => 'As your confidence grows and habits solidify, the ripple effect begins — better relationships, more energy, clearer decisions.', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                    ];
                    foreach ($steps as $i => $step):
                    ?>
                    <div class="relative text-center">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-medical-teal to-medical-cyan flex items-center justify-center mx-auto mb-4 shadow-lg shadow-medical-teal/20 relative">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $step['icon'] ?>"/>
                            </svg>
                            <span class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-medical-indigo text-white text-xs font-bold flex items-center justify-center"><?= $step['step'] ?></span>
                        </div>
                        <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-2"><?= $step['title'] ?></h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400"><?= $step['desc'] ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-2">Real Stories from Real People</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Hear from people who've walked this path before you.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $testimonials = [
                    ['quote' => 'Coach Ibe helped me gain clarity I\'d been searching for years. After 10 weeks, I left a toxic job, rebuilt my confidence, and now I wake up with purpose every day.', 'initials' => 'AO', 'name' => 'Adaeze O.', 'role' => 'Life Coaching Client', 'gradient' => 'from-teal-500 to-emerald-600'],
                    ['quote' => 'The health coaching program helped me build sustainable habits — not crash diets. I have more energy, better sleep, and my stress levels dropped dramatically.', 'initials' => 'KA', 'name' => 'Kemi A.', 'role' => 'Health Coaching Client', 'gradient' => 'from-cyan-500 to-blue-600'],
                    ['quote' => 'I went from being stuck to landing my dream role in 8 weeks. The interview prep and salary negotiation coaching gave me the edge I needed.', 'initials' => 'TM', 'name' => 'Tunde M.', 'role' => 'Career Coaching Client', 'gradient' => 'from-indigo-500 to-violet-600'],
                    ['quote' => 'My revenue doubled in 4 months. Coach Ibe helped me build marketing systems, improve my leadership, and get financial clarity. Pure gold for any entrepreneur.', 'initials' => 'NE', 'name' => 'Ngozi E.', 'role' => 'World Business Coaching Client', 'gradient' => 'from-purple-500 to-fuchsia-600'],
                    ['quote' => 'Seeing my body\'s natural patterns in real time was a game-changer. I now understand how different activities affect me and make smarter daily choices.', 'initials' => 'CU', 'name' => 'Chidi U.', 'role' => 'Wellness Tech User', 'gradient' => 'from-amber-500 to-rose-600'],
                    ['quote' => 'Combining coaching with gentle wellness technology is brilliant. My coach uses my data to tailor each session. I\'ve never felt more understood or supported.', 'initials' => 'FB', 'name' => 'Fatima B.', 'role' => 'Life & Health Client', 'gradient' => 'from-rose-500 to-pink-600'],
                ];
                foreach ($testimonials as $t):
                ?>
                <div class="bg-white dark:bg-slate-800/50 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 card-hover">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br <?= $t['gradient'] ?> flex items-center justify-center text-white text-sm font-bold mr-3">
                            <?= $t['initials'] ?>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900 dark:text-slate-100 text-sm"><?= $t['name'] ?></p>
                            <p class="text-xs text-slate-500 dark:text-slate-400"><?= $t['role'] ?></p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-300 italic leading-relaxed">"<?= $t['quote'] ?>"</p>
                    <div class="flex mt-3">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Integrated Diagnostic Pipeline -->
        <section class="mb-12">
            <div class="bg-white dark:bg-slate-800/50 dark:border-slate-700/50 rounded-3xl p-8 shadow-sm border border-slate-100 dark:border-slate-700 card-border">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-6">Integrated Diagnostic & Coaching Pipeline</h2>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <?php
                    $pipeline = [
                        ['step' => '1', 'title' => 'Discovery Call', 'desc' => 'Free consultation, goals, history', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                        ['step' => '2', 'title' => 'Imaging & Scans', 'desc' => 'MRI/US/OCT per protocol', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 012 2z'],
                        ['step' => '3', 'title' => 'AI Analysis', 'desc' => 'Segmentation, grading, findings', 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
                        ['step' => '4', 'title' => 'Coaching & Treatment', 'desc' => 'Stem cells + PEMF + coaching', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 01-1.806.547M8 4h8l-1 1v5.172a2 2 0 01.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                        ['step' => '5', 'title' => 'Thrive & Monitor', 'desc' => 'Serial imaging + growth tracking', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
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

        <!-- CTA + Contact -->
        <section id="contact" class="mb-12">
            <div class="bg-gradient-to-br from-medical-teal via-medical-cyan to-medical-indigo rounded-3xl p-8 md:p-12 text-white relative overflow-hidden">
                <div class="absolute inset-0 medical-grid opacity-10"></div>
                <div class="relative text-center max-w-2xl mx-auto">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Begin Your Journey?</h2>
                    <p class="text-white/80 mb-8">The first step is always the hardest — but you don't have to take it alone. Reach out and let's explore how we can support your growth. No pressure, no judgment — just a warm conversation.</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="https://wa.me/2347010744142" target="_blank" rel="noopener"
                           class="px-6 py-3 bg-white text-medical-teal font-semibold rounded-xl hover:bg-white/90 transition shadow-lg flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            <span>Chat on WhatsApp</span>
                        </a>
                        <a href="https://t.me/" target="_blank" rel="noopener"
                           class="px-6 py-3 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-xl border border-white/20 hover:bg-white/20 transition flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                            <span>Message on Telegram</span>
                        </a>
                        <a href="mailto:Ibe@coachandheal.store"
                           class="px-6 py-3 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-xl border border-white/20 hover:bg-white/20 transition flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>Send an Email</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- GPU Cloud + PEMF (kept from original) -->
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
