    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Supplement & Herbal Database</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Evidence-based supplements and herbal remedies for each condition. Both tablet and herbal forms included.</p>
        </div>

        <?php
        $supplementsDB = [
            'knee_arthritis' => [
                'tablets' => [
                    ['name' => 'Glucosamine Sulfate', 'dose' => '1500mg/day', 'evidence' => 'Strong', 'purpose' => 'Cartilage support'],
                    ['name' => 'Chondroitin Sulfate', 'dose' => '1200mg/day', 'evidence' => 'Strong', 'purpose' => 'Synergistic with glucosamine'],
                    ['name' => 'Curcumin', 'dose' => '1000mg/day', 'evidence' => 'Strong', 'purpose' => 'Anti-inflammatory'],
                    ['name' => 'Vitamin D3', 'dose' => '4000 IU/day', 'evidence' => 'Strong', 'purpose' => 'Bone health'],
                    ['name' => 'Collagen Type II', 'dose' => '40mg/day', 'evidence' => 'Moderate', 'purpose' => 'Cartilage repair'],
                    ['name' => 'Omega-3', 'dose' => '2000mg/day', 'evidence' => 'Moderate', 'purpose' => 'Anti-inflammatory'],
                    ['name' => 'Boswellia Serrata', 'dose' => '300-500mg/day', 'evidence' => 'Moderate', 'purpose' => 'Anti-inflammatory'],
                    ['name' => 'MSM', 'dose' => '1500mg/day', 'evidence' => 'Moderate', 'purpose' => 'Joint sulfur'],
                ],
                'herbs' => [
                    ['name' => 'Turmeric (Curcuma longa)', 'form' => 'Capsule/Powder', 'dose' => '500-1000mg 2x/day'],
                    ['name' => 'Ginger (Zingiber)', 'form' => 'Capsule/Tea', 'dose' => '500-1000mg/day'],
                    ['name' => 'Ashwagandha', 'form' => 'Capsule/Powder', 'dose' => '300-600mg/day'],
                    ['name' => "Devil's Claw", 'form' => 'Capsule/Tea', 'dose' => '600-1200mg/day'],
                    ['name' => 'Stinging Nettle', 'form' => 'Tea/Capsule', 'dose' => '300-600mg/day'],
                ],
            ],
            'retinal_degeneration' => [
                'tablets' => [
                    ['name' => 'AREDS2 Formula', 'dose' => '1 daily', 'evidence' => 'Gold Standard', 'purpose' => 'Slow AMD progression 25%'],
                    ['name' => 'Lutein', 'dose' => '10mg/day', 'evidence' => 'Strong', 'purpose' => 'Macular pigment'],
                    ['name' => 'Zeaxanthin', 'dose' => '2mg/day', 'evidence' => 'Strong', 'purpose' => 'Macular pigment'],
                    ['name' => 'Omega-3 DHA', 'dose' => '1000mg/day', 'evidence' => 'Moderate', 'purpose' => 'Photoreceptor health'],
                    ['name' => 'Astaxanthin', 'dose' => '6-12mg/day', 'evidence' => 'Emerging', 'purpose' => 'Crosses blood-retinal barrier'],
                    ['name' => 'Vitamin C', 'dose' => '500mg/day', 'evidence' => 'Moderate', 'purpose' => 'Antioxidant'],
                    ['name' => 'Vitamin E', 'dose' => '400 IU/day', 'evidence' => 'Moderate', 'purpose' => 'Antioxidant'],
                    ['name' => 'Zinc', 'dose' => '80mg/day', 'evidence' => 'Moderate', 'purpose' => 'Retinal enzyme cofactor'],
                ],
                'herbs' => [
                    ['name' => 'Saffron', 'form' => 'Capsule', 'dose' => '20-30mg/day'],
                    ['name' => 'Bilberry', 'form' => 'Extract', 'dose' => '160-320mg/day'],
                    ['name' => 'Ginkgo Biloba', 'form' => 'Extract', 'dose' => '120-240mg/day'],
                    ['name' => 'Goji Berry', 'form' => 'Dried/Tea', 'dose' => '10-20g/day'],
                    ['name' => 'Green Tea (EGCG)', 'form' => 'Extract/Tea', 'dose' => '400mg/day'],
                ],
            ],
            'male_fertility' => [
                'tablets' => [
                    ['name' => 'L-Carnitine', 'dose' => '2000mg/day', 'evidence' => 'Strong', 'purpose' => 'Sperm motility'],
                    ['name' => 'CoQ10 (Ubiquinol)', 'dose' => '200-400mg/day', 'evidence' => 'Strong', 'purpose' => 'Mitochondrial energy'],
                    ['name' => 'Zinc', 'dose' => '30mg/day', 'evidence' => 'Strong', 'purpose' => 'Testosterone, sperm count'],
                    ['name' => 'Vitamin D3', 'dose' => '4000 IU/day', 'evidence' => 'Strong', 'purpose' => 'Hormone balance'],
                    ['name' => 'Selenium', 'dose' => '200mcg/day', 'evidence' => 'Moderate', 'purpose' => 'Sperm morphology'],
                    ['name' => 'Folate', 'dose' => '800mcg/day', 'evidence' => 'Moderate', 'purpose' => 'DNA synthesis'],
                    ['name' => 'Vitamin E', 'dose' => '400 IU/day', 'evidence' => 'Moderate', 'purpose' => 'Antioxidant'],
                    ['name' => 'Omega-3 DHA', 'dose' => '1000mg/day', 'evidence' => 'Moderate', 'purpose' => 'Sperm membrane'],
                ],
                'herbs' => [
                    ['name' => 'Tongkat Ali', 'form' => 'Capsule', 'dose' => '200-400mg/day'],
                    ['name' => 'Ashwagandha', 'form' => 'Capsule/Powder', 'dose' => '300-600mg/day'],
                    ['name' => 'Maca Root', 'form' => 'Powder', 'dose' => '1.5-3g/day'],
                    ['name' => 'Fenugreek', 'form' => 'Capsule/Seeds', 'dose' => '500-600mg/day'],
                    ['name' => 'Mucuna Pruriens', 'form' => 'Powder', 'dose' => '2-5g/day'],
                ],
            ],
            'female_fertility' => [
                'tablets' => [
                    ['name' => 'Myo-Inositol + D-Chiro (40:1)', 'dose' => '4000+100mg/day', 'evidence' => 'Strong', 'purpose' => 'PCOS, ovulation'],
                    ['name' => 'CoQ10 (Ubiquinol)', 'dose' => '200-600mg/day', 'evidence' => 'Strong', 'purpose' => 'Egg quality'],
                    ['name' => 'Folate', 'dose' => '800mcg/day', 'evidence' => 'Essential', 'purpose' => 'Neural tube, conception'],
                    ['name' => 'Vitamin D3', 'dose' => '4000 IU/day', 'evidence' => 'Strong', 'purpose' => 'Hormone balance'],
                    ['name' => 'NAC', 'dose' => '600-1200mg/day', 'evidence' => 'Moderate', 'purpose' => 'Antioxidant, ovulation'],
                    ['name' => 'Vitex (Chasteberry)', 'dose' => '400-500mg/day', 'evidence' => 'Moderate', 'purpose' => 'Cycle regulation'],
                    ['name' => 'L-Arginine', 'dose' => '3000-5000mg/day', 'evidence' => 'Moderate', 'purpose' => 'Uterine blood flow'],
                    ['name' => 'Melatonin', 'dose' => '3mg at bedtime', 'evidence' => 'Emerging', 'purpose' => 'Egg quality antioxidant'],
                ],
                'herbs' => [
                    ['name' => 'Vitex (Chaste Tree Berry)', 'form' => 'Capsule/Tincture', 'dose' => '400-500mg/day'],
                    ['name' => 'Maca Root', 'form' => 'Powder', 'dose' => '1.5-3g/day'],
                    ['name' => 'Ashwagandha', 'form' => 'Capsule/Powder', 'dose' => '300-600mg/day'],
                    ['name' => 'Shatavari', 'form' => 'Powder', 'dose' => '500-1000mg/day'],
                    ['name' => 'Dong Quai', 'form' => 'Capsule/Decoction', 'dose' => '500-1000mg/day'],
                ],
            ],
            'prostate' => [
                'tablets' => [
                    ['name' => 'Saw Palmetto', 'dose' => '320mg/day', 'evidence' => 'Strong', 'purpose' => 'DHT blocker, BPH'],
                    ['name' => 'Beta-sitosterol', 'dose' => '60-130mg/day', 'evidence' => 'Moderate', 'purpose' => 'BPH symptoms'],
                    ['name' => 'Pygeum', 'dose' => '100-200mg/day', 'evidence' => 'Moderate', 'purpose' => 'Anti-inflammatory'],
                    ['name' => 'Zinc', 'dose' => '30mg/day', 'evidence' => 'Moderate', 'purpose' => 'Prostate function'],
                    ['name' => 'Selenium', 'dose' => '200mcg/day', 'evidence' => 'Moderate', 'purpose' => 'Antioxidant'],
                    ['name' => 'Lycopene', 'dose' => '15-30mg/day', 'evidence' => 'Moderate', 'purpose' => 'Prostate health'],
                    ['name' => 'Green Tea EGCG', 'dose' => '400-800mg/day', 'evidence' => 'Moderate', 'purpose' => 'Anti-inflammatory'],
                    ['name' => 'Quercetin', 'dose' => '500-1000mg/day', 'evidence' => 'Moderate', 'purpose' => 'Anti-inflammatory'],
                ],
                'herbs' => [
                    ['name' => 'Saw Palmetto', 'form' => 'Capsule/Berry', 'dose' => '320mg/day'],
                    ['name' => 'Stinging Nettle Root', 'form' => 'Capsule/Tea', 'dose' => '300-600mg/day'],
                    ['name' => 'Pygeum Africanum', 'form' => 'Capsule', 'dose' => '100-200mg/day'],
                    ['name' => 'Pumpkin Seed Oil', 'form' => 'Oil/Capsule', 'dose' => '320mg/day'],
                    ['name' => 'Rye Grass Pollen', 'form' => 'Capsule', 'dose' => '63-126mg/day'],
                ],
            ],
        ];

        $conditionLabels = [
            'knee_arthritis' => 'Knee Osteoarthritis',
            'retinal_degeneration' => 'Macular Degeneration',
            'male_fertility' => 'Male Enhancing Fertility',
            'female_fertility' => 'Female Enhancing Fertility',
            'prostate' => 'Prostate Health',
        ];

        foreach ($supplementsDB as $condKey => $data):
        ?>
        <section class="mb-10">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?= $conditionLabels[$condKey] ?? ucfirst($condKey) ?></h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Tablets -->
                <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden card-border">
                    <div class="px-6 py-4 bg-medical-teal/5 dark:bg-medical-teal/10 border-b border-medical-teal/10 dark:border-medical-teal/20">
                        <h3 class="font-semibold text-medical-teal flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19.428 15.428a2 2 0 01-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 01-1.806.547M8 4h8l-1 1v5.172a2 2 0 01.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            Tablet/Pharmaceutical
                        </h3>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <?php foreach ($data['tablets'] as $supp):
                            $evColor = match($supp['evidence']) {
                                'Strong' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                'Gold Standard' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                'Essential' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                'Moderate' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
                                'Emerging' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
                                default => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300',
                            };
                        ?>
                        <div class="px-6 py-3 flex items-center justify-content">
                            <div class="flex-1">
                                <p class="font-medium text-slate-900 dark:text-slate-100 text-sm"><?= $supp['name'] ?></p>
                                <p class="text-xs text-slate-500 dark:text-slate-400"><?= $supp['dose'] ?> • <?= $supp['purpose'] ?></p>
                            </div>
                            <span class="px-2 py-0.5 <?= $evColor ?> text-xs font-medium rounded-full"><?= $supp['evidence'] ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Herbs -->
                <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden card-border">
                    <div class="px-6 py-4 bg-green-50 dark:bg-green-900/10 border-b border-green-100 dark:border-green-800/30">
                        <h3 class="font-semibold text-green-700 dark:text-green-400 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            Herbal Medicine
                        </h3>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <?php foreach ($data['herbs'] as $herb): ?>
                        <div class="px-6 py-3 hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors">
                            <p class="font-medium text-slate-900 dark:text-slate-100 text-sm"><?= $herb['name'] ?></p>
                            <p class="text-xs text-slate-500 dark:text-slate-400"><?= $herb['form'] ?> • <?= $herb['dose'] ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endforeach; ?>
    </main>