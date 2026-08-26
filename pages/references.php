    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Clinical References & Resources</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Evidence base for all protocols, supplements, and therapies referenced in this platform.</p>
        </div>

        <div class="space-y-4">
            <?php
            $references = [
                ['AREDS2 Research Group', "'Lutein + Zeaxanthin and Omega-3 Fatty Acids for Age-Related Macular Degeneration'", 'JAMA Ophthalmology', '2022', '140(7):692-698'],
                ['UC San Diego School of Medicine', "'Novel Fluorine-Based Tracer for MRI Stem Cell Tracking'", 'Nature Biomedical Engineering', '2025', ''],
                ['Pupu Du et al.', "'Efficacy of Dietary Supplements for Knee Osteoarthritis: Network Meta-Analysis'", 'Frontiers in Nutrition', '2025', '12:1556133'],
                ['Wai HS et al.', "'Effect of Turmeric Products on Knee Osteoarthritis: Systematic Review'", 'BMC Complementary Medicine', '2025', '25(1):292'],
                ['Fladerer-Grollitsch JP et al.', "'Cartilage-Supporting Nutritional Supplementation in KOA'", 'Scientific Reports', '2025', '15:25625'],
                ['ExSeed Health', "'Male Fertility Supplements: 2025 Evidence Review'", 'ExSeed Clinical Guide', '2026', ''],
                ['Morula IVF', "'5 Herbs for Male Fertility and Reproductive Health'", 'JBRA Assist Reprod', '2025', '26(3):522-530'],
                ['HealthEd Academy', "'Best Herbs for Boosting Testosterone Levels in 2026'", 'HealthEd Clinical Review', '2026', ''],
                ['Healthline', "'Best Prostate Health Supplements 2026'", 'Healthline Nutrition', '2026', ''],
                ['The Good Mother Project', "'Best Fertility Supplements for Women 2026'", 'TGMP Clinical Guide', '2026', ''],
                ['Ross CL et al.', "'Effect of Low-Frequency EMF on Bone Marrow Stem Cell Differentiation'", 'Stem Cell Research', '2015', '15(1):96-108'],
                ['Cadossi M et al.', "'Pulsed Electromagnetic Fields on Tissue Repair and Regeneration'", 'Progress in Biophysics', '2024', ''],
                ['Johns Hopkins', "'Stem Cell Therapy: MRI Guidance and Monitoring'", 'NIH/PMC', '2012', 'PMC3075622'],
                ['Arc Compute', "'GPU Infrastructure for Medical Imaging AI: 2026 Guide'", 'Arc Compute Blog', '2026', ''],
                ['GPU Advisor', "'GPU Infrastructure for Healthcare AI: HIPAA-Compliant Setup'", 'GPUAdvisor', '2026', ''],
                ['American Academy of Ophthalmology', "'Vitamins for AMD: AREDS2 Update'", 'AAO.org', '2025', ''],
                ['Cleveland Clinic', "'Macular Degeneration: Nutritional Supplements'", 'Cleveland Clinic Health Library', '2023', ''],
                ['NIH/NIA', "'Osteoarthritis Initiative (OAI)'", 'National Institutes of Health', '2025', ''],
                ['RunPod', "'Top 12 Cloud GPU Providers for AI 2026'", 'RunPod Research', '2026', ''],
                ['AIMultiple', "'Comparison of Top 6 Free Cloud GPU Services 2026'", 'AIMultiple', '2026', ''],
            ];
            foreach ($references as $i => $ref):
            ?>
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 card-border transition-colors duration-200 hover:shadow-md">
                <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 rounded-lg bg-medical-teal/10 dark:bg-medical-teal/20 text-medical-teal font-bold text-sm flex items-center justify-center flex-shrink-0">
                        <?= $i + 1 ?>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-slate-100 text-sm"><?= SecurityManager::sanitizeOutput($ref[0]) ?></p>
                        <p class="text-sm text-medical-teal mt-0.5 font-medium">
                            <?= SecurityManager::sanitizeOutput($ref[1]) ?>
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            <?= SecurityManager::sanitizeOutput($ref[2]) ?> •
                            <?= SecurityManager::sanitizeOutput($ref[3]) ?>
                            <?= $ref[4] ? '• ' . SecurityManager::sanitizeOutput($ref[4]) : '' ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- RECOMMENDED PROVIDERS -->
        <div class="mt-14 mb-8">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2">
                <span class="text-teal-600">✦</span> Recommended Providers &amp; Therapies
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-2 max-w-3xl">Clinics, firms, and equipment providers in Nigeria and worldwide that offer the therapies, machines, and tests featured in Regen Med Health — a Coach &amp; Heal app.</p>
        </div>
        <?php
        $providers = [
            ['Naveen Herbs', 'International', 'Family-owned apothecary — high-quality herbs, herbal teas, and natural skincare for daily wellness.', 'https://www.naveenherbs.com'],
            ['ReGen Care Africa', 'Nigeria — Lagos', 'Regenerative medicine & aesthetics: stem cells, exosomes, PRP, NAD+, hormone balance, IV drip therapy.', 'https://www.regencareafrica.com'],
            ['Mart-Life Detox Clinic', 'Nigeria — Lagos', "Nigeria's first Modern Mayr medical spa (Viva Mayr Austria partner) — cleanse, anti-aging & wellness programs.", 'http://www.martdetoxclinic.com'],
            ['Me Cure Healthcare', 'Nigeria — Lagos', 'Diagnostic imaging: MRI, PET/CT, CT, mammography, ultrasound + pathology and eye center.', 'https://www.mecure.com.ng'],
            ['SYNLAB Nigeria', 'Nigeria — 43 locations', 'Medical diagnostics & wellness lab testing with home sample collection.', 'https://www.synlab.com.ng'],
            ['Cerba Lancet Nigeria', 'Nigeria — Nationwide', 'Medical laboratory, pathology and referral services — widest test range in Nigeria.', 'https://cerbalancetafrica.com/our-network/nigeria/'],
            ['BEMER Group', 'International — Germany', 'FDA Class II cleared PEMF devices for microcirculation and recovery (8-min twice-daily protocol).', 'https://bemergroup.com'],
            ['Swiss Bionic Solutions', 'International — Switzerland', 'iMRS prime & Omnium1 certified low-intensity PEMF systems for clinical and home use.', 'https://www.swissbionic.com'],
            ['Pulse PEMF', 'International — USA', 'Industry-leading PEMF machines and accessories for holistic recovery and performance.', 'https://pulsepemf.com'],
            ['BioXcellerator', 'International — Colombia/USA', 'Advanced stem cell therapy & protocols for orthopedic, neurological and anti-aging conditions.', 'https://www.bioxcellerator.com'],
            ['Swiss Medica', 'International — Serbia/EU', 'Regenerative medicine hospital — MSC programs for MS, autism, arthritis and more (70+ countries served).', 'https://www.startstemcells.com'],
            ['Stem Cell Institute', 'International — Panama', 'Pioneering clinic using umbilical-cord mesenchymal stem cells for degenerative conditions.', 'https://www.panamastemcells.com'],
            ['DVC Stem', 'International — Cayman Islands', 'IRB-approved GMP-grade umbilical cord MSC infusions for degenerative and inflammatory conditions.', 'https://www.dvcstem.com'],
            ['R3 Stem Cell', 'International — USA + 8 countries', '80-clinic Centers of Excellence network — stem cells, exosomes and growth factor therapies.', 'https://r3stemcell.com'],
            ['SHA Wellness Clinic', 'International — Spain/Mexico', 'Award-winning medical wellness destination — detox, longevity and cellular regeneration programs.', 'https://shawellness.com'],
            ['Lanserhof', 'International — Germany/Austria/Spain', 'World-leading preventive medicine — the Lanserhof Concept of fasting, detox and regeneration.', 'https://lanserhof.com/en/'],
            ['Canyon Ranch', 'International — USA', 'Integrative wellness resorts — longevity, nutrition, and expert-led health retreats.', 'https://www.canyonranch.com'],
            ['Viva Mayr', 'International — Austria', 'The world-renowned Modern Mayr medicine detox and digestive health center.', 'https://www.vivamayr.com'],
        ];
        foreach ($providers as $p):
            $isNigeria = strpos($p[1], 'Nigeria') === 0;
        ?>
        <a href="<?= SecurityManager::sanitizeOutput($p[3]) ?>" target="_blank" rel="noopener"
           class="block bg-white dark:bg-slate-800 rounded-xl p-5 shadow-sm border border-slate-100 dark:border-slate-700/50 card-border transition-colors duration-200 hover:shadow-md mb-3">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="font-semibold text-slate-900 dark:text-slate-100 text-sm flex items-center gap-2">
                        <?= $isNigeria ? '<span class="w-2 h-2 rounded-full bg-green-500 flex-shrink-0"></span>' : '<span class="w-2 h-2 rounded-full bg-teal-500 flex-shrink-0"></span>' ?>
                        <?= SecurityManager::sanitizeOutput($p[0]) ?>
                    </p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1"><?= SecurityManager::sanitizeOutput($p[2]) ?></p>
                </div>
                <span class="text-[0.65rem] font-semibold px-2 py-1 rounded-md flex-shrink-0 <?= $isNigeria ? 'bg-green-500/10 text-green-600 dark:text-green-400' : 'bg-medical-teal/10 text-medical-teal' ?>">
                    <?= SecurityManager::sanitizeOutput($p[1]) ?>
                </span>
            </div>
        </a>
        <?php endforeach; ?>
    </main>