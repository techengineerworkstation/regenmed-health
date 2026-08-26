    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Lab Scan Protocols</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Standardized lab scan acquisition and analysis protocols for each diagnostic module.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <?php
            $labScanProtocols = [
                ['condition' => 'Knee Osteoarthritis', 'modality' => 'MRI', 'planes' => 'Sagittal PD/T2, Coronal T1, Axial FS', 'sequences' => '3D SPGR for cartilage mapping', 'protocol' => '3T preferred, 1.5T acceptable', 'duration' => '25-30 min'],
                ['condition' => 'Knee Osteoarthritis', 'modality' => 'X-ray', 'planes' => 'AP standing, Lateral, Sunrise', 'sequences' => 'Weight-bearing essential', 'protocol' => 'Kellgren-Lawrence grading', 'duration' => '5 min'],
                ['condition' => 'Macular Degeneration', 'modality' => 'OCT', 'planes' => 'Macular cube 512x128', 'sequences' => 'B-scan, En face, OCTA', 'protocol' => 'Heidelberg Spectralis/Carl Zeiss', 'duration' => '10 min'],
                ['condition' => 'Macular Degeneration', 'modality' => 'FA/OCTA', 'planes' => '30° field', 'sequences' => 'Early/mid/late phases', 'protocol' => 'Fluorescein dye 5ml 10%', 'duration' => '15 min'],
                ['condition' => 'Male Enhancing Fertility', 'modality' => 'Scrotal US', 'planes' => 'Transverse + Longitudinal', 'sequences' => 'Color Doppler, spectral analysis', 'protocol' => '7-15 MHz linear transducer', 'duration' => '15 min'],
                ['condition' => 'Female Enhancing Fertility', 'modality' => 'TV US', 'planes' => 'Sagittal uterus, transverse ovaries', 'sequences' => '3D ultrasound, power Doppler', 'protocol' => '5-9 MHz transvaginal probe', 'duration' => '20 min'],
                ['condition' => 'Female Enhancing Fertility', 'modality' => 'HSG', 'planes' => 'AP fluoroscopy', 'sequences' => 'Contrast flow, spillage', 'protocol' => 'Water-soluble contrast', 'duration' => '10 min'],
                ['condition' => 'Prostate Challenge', 'modality' => 'mpMRI', 'planes' => 'T2 axial, DWI, DCE', 'sequences' => 'PI-RADS v2.1 scoring', 'protocol' => '3T with surface coil', 'duration' => '35-40 min'],
            ];
            foreach ($labScanProtocols as $protocol):
            ?>
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 card-border card-hover">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100"><?= $protocol['condition'] ?></h3>
                    <span class="px-3 py-1 bg-medical-teal/10 dark:bg-medical-teal/20 text-medical-teal text-xs font-semibold rounded-full"><?= $protocol['modality'] ?></span>
                </div>
                <div class="space-y-2 text-sm text-slate-600 dark:text-slate-300">
                    <div class="flex py-1.5">
                        <span class="font-medium text-slate-700 dark:text-slate-200 w-24 flex-shrink-0">Planes:</span>
                        <span class="ml-2"><?= $protocol['planes'] ?></span>
                    </div>
                    <div class="flex py-1.5">
                        <span class="font-medium text-slate-700 dark:text-slate-200 w-24 flex-shrink-0">Sequences:</span>
                        <span class="ml-2"><?= $protocol['sequences'] ?></span>
                    </div>
                    <div class="flex py-1.5">
                        <span class="font-medium text-slate-700 dark:text-slate-200 w-24 flex-shrink-0">Equipment:</span>
                        <span class="ml-2"><?= $protocol['protocol'] ?></span>
                    </div>
                    <div class="flex py-1.5">
                        <span class="font-medium text-slate-700 dark:text-slate-200 w-24 flex-shrink-0">Duration:</span>
                        <span class="ml-2"><?= $protocol['duration'] ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- AI Analysis Pipeline -->
        <section class="mt-12 bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-700 card-border">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6">AI Analysis Pipeline</h2>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <?php
                $pipeline = [
                    ['step' => '1', 'title' => 'Preprocessing', 'desc' => 'DICOM/NIfTI → Numpy array, normalization, resampling'],
                    ['step' => '2', 'title' => 'Segmentation', 'desc' => 'U-Net/nnU-Net for region-of-interest extraction'],
                    ['step' => '3', 'title' => 'Feature Extraction', 'desc' => 'CNN features, radiomics, clinical data fusion'],
                    ['step' => '4', 'title' => 'Classification', 'desc' => 'Severity grading, finding detection, diagnosis'],
                    ['step' => '5', 'title' => 'Report', 'desc' => 'Structured report, recommendations, confidence scores'],
                ];
                $stepColors = ['bg-medical-teal', 'bg-medical-cyan', 'bg-medical-indigo', 'bg-medical-violet', 'bg-medical-amber'];
                foreach ($pipeline as $i => $step):
                ?>
                <div class="p-5 bg-slate-50 dark:bg-slate-700/30 rounded-xl border border-slate-100 dark:border-slate-700/50 text-center">
                    <div class="w-8 h-8 rounded-full <?= $stepColors[$i] ?> text-white text-sm font-bold flex items-center justify-center mb-2 mx-auto">
                        <?= $step['step'] ?>
                    </div>
                    <h4 class="font-semibold text-slate-900 dark:text-slate-100 text-sm mb-1"><?= $step['title'] ?></h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400"><?= $step['desc'] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>