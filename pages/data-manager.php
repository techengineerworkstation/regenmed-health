    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="dataManager()">
        <div class="mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Data Management & Upload Center</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Upload scan data, manage training datasets, track AI inferences, and generate recommendations.</p>
        </div>

        <!-- Upload Section -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Scan Upload -->
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 card-border card-hover">
                <div class="w-12 h-12 rounded-xl bg-medical-teal/10 dark:bg-medical-teal/20 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-medical-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 012-2V6a2 2 0 012-2H6a2 2 0 01-2 2v12a2 2 0 012 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-2">Scan Data Upload</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Upload DICOM, NIfTI, or processed scan images for analysis.</p>

                <form @submit.prevent="uploadScan" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Condition</label>
                        <select x-model="scanForm.condition"
                                class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-teal/20 focus:border-medical-teal outline-none transition">
                            <option value="knee_arthritis">Knee Osteoarthritis</option>
                            <option value="retinal_degeneration">Macular Degeneration</option>
                            <option value="male_factor_enhancing_fertility">Male Enhancing Fertility</option>
                            <option value="female_factor_enhancing_fertility">Female Enhancing Fertility</option>
                            <option value="prostate_disease">Prostate Disease</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Imaging Modality</label>
                        <select x-model="scanForm.modality"
                                class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-teal/20 focus:border-medical-teal outline-none transition">
                            <option value="MRI">MRI</option>
                            <option value="CT">CT</option>
                            <option value="Ultrasound">Ultrasound</option>
                            <option value="OCT">OCT</option>
                            <option value="X-ray">X-ray</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Patient ID</label>
                        <input type="text" x-model="scanForm.patientId" placeholder="e.g., P001"
                               class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-teal/20 focus:border-medical-teal outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Severity Grade</label>
                        <select x-model="scanForm.severity"
                                class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-teal/20 focus:border-medical-teal outline-none transition">
                            <option value="1">Grade 1 (Minimal/Mild)</option>
                            <option value="2">Grade 2 (Mild/Moderate)</option>
                            <option value="3">Grade 3 (Moderate)</option>
                            <option value="4">Grade 4 (Severe)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Scan File (DICOM/NIfTI)</label>
                        <input type="file" @change="scanForm.file = $event.target.files[0]"
                               accept=".dcm,.nii,.nii.gz,.png,.jpg,.jpeg"
                               class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 rounded-lg text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:bg-medical-teal/10 file:text-medical-teal file:font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Clinical Notes</label>
                        <textarea x-model="scanForm.notes" rows="2" placeholder="Key findings, measurements..."
                                  class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-teal/20 focus:border-medical-teal outline-none transition"></textarea>
                    </div>
                    <button type="submit"
                            class="w-full py-3 bg-medical-teal text-white text-sm font-semibold rounded-lg hover:bg-medical-teal/90 transition shadow-lg shadow-medical-teal/20 flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span>Upload & Process</span>
                    </button>
                    <div x-show="uploadStatus" x-transition class="p-2.5 bg-medical-teal/10 dark:bg-medical-teal/20 text-medical-teal text-xs rounded-lg" x-text="uploadStatus"></div>
                </form>
            </div>

            <!-- Training Data Upload -->
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 card-border card-hover">
                <div class="w-12 h-12 rounded-xl bg-medical-cyan/10 dark:bg-medical-cyan/20 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-medical-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-2">Training Data Upload</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Upload labeled datasets for model training.</p>

                <form @submit.prevent="uploadTraining" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Dataset Name</label>
                        <input type="text" x-model="trainingForm.name" placeholder="e.g., Knee MRI OA Dataset v2"
                               class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-cyan/20 focus:border-medical-cyan outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Model Type</label>
                        <select x-model="trainingForm.modelType"
                                class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-cyan/20 focus:border-medical-cyan outline-none transition">
                            <option value="segmentation">Segmentation (U-Net/nnU-Net)</option>
                            <option value="classification">Classification (ResNet/ViT)</option>
                            <option value="detection">Detection (YOLO/RCNN)</option>
                            <option value="registration">Registration</option>
                            <option value="reconstruction">Reconstruction</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">GPU Provider</label>
                        <select x-model="trainingForm.gpu"
                                class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-cyan/20 focus:border-medical-cyan outline-none transition">
                            <option value="google_colab">Google Colab (Free T4)</option>
                            <option value="runpod">RunPod ($0.44/hr)</option>
                            <option value="lambda">Lambda Labs ($0.56/hr)</option>
                            <option value="vastai">Vast.ai ($0.30/hr)</option>
                            <option value="local">Local GPU</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Dataset Files (ZIP/CSV/Images)</label>
                        <input type="file" @change="trainingForm.file = $event.target.files[0]"
                               accept=".zip,.csv,.json,.tar.gz"
                               class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 rounded-lg text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:bg-medical-cyan/10 file:text-medical-cyan file:font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Number of Samples</label>
                        <input type="number" x-model="trainingForm.samples" placeholder="e.g., 1000"
                               class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-cyan/20 focus:border-medical-cyan outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Labeling Status</label>
                        <select x-model="trainingForm.labeled"
                                class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-cyan/20 focus:border-medical-cyan outline-none transition">
                            <option value="fully_labeled">Fully Labeled</option>
                            <option value="partially_labeled">Partially Labeled</option>
                            <option value="unlabeled">Unlabeled (Self-supervised)</option>
                            <option value="synthetic">Synthetic Data</option>
                        </select>
                    </div>
                    <button type="submit"
                            class="w-full py-3 bg-medical-cyan text-white text-sm font-semibold rounded-lg hover:bg-medical-cyan/90 transition shadow-lg shadow-medical-cyan/20 flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Add Training Data</span>
                    </button>
                </form>
            </div>

            <!-- Inference Results Upload -->
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 card-border card-hover">
                <div class="w-12 h-12 rounded-xl bg-medical-indigo/10 dark:bg-medical-indigo/20 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-medical-indigo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 01-2-2v6a2 2 0 012 2h2a2 2 0 012-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-2">Inference Results</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Log AI model outputs for tracking and review.</p>

                <form @submit.prevent="uploadInference" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Model Used</label>
                        <input type="text" x-model="inferenceForm.model" placeholder="e.g., nnU-Net v2"
                               class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-indigo/20 focus:border-medical-indigo outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Input Scan Reference</label>
                        <input type="text" x-model="inferenceForm.scanRef" placeholder="e.g., P001_Knee_MRI"
                               class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-indigo/20 focus:border-medical-indigo outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Inference Result</label>
                        <select x-model="inferenceForm.result"
                                class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-indigo/20 focus:border-medical-indigo outline-none transition">
                            <option value="positive_finding">Positive Finding Detected</option>
                            <option value="negative">No Significant Finding</option>
                            <option value="requires_review">Requires Human Review</option>
                            <option value="segmentation_complete">Segmentation Complete</option>
                            <option value="classification_result">Classification Result</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">
                            Confidence Score (<span x-text="inferenceForm.confidence + '%'"></span>)
                        </label>
                        <input type="range" x-model="inferenceForm.confidence" min="0" max="100" step="0.1"
                               class="w-full accent-medical-indigo">
                        <div class="mt-1.5 h-1.5 bg-slate-200 dark:bg-slate-600 rounded-full overflow-hidden">
                            <div class="h-full rounded-full bg-medical-indigo transition-all"
                                 :style="'width: ' + inferenceForm.confidence + '%'">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Output File (Segmentation/Mask)</label>
                        <input type="file" @change="inferenceForm.file = $event.target.files[0]"
                               accept=".nii,.nii.gz,.png,.jpg,.dcm"
                               class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 rounded-lg text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:bg-medical-indigo/10 file:text-medical-indigo file:font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1.5">Findings Summary</label>
                        <textarea x-model="inferenceForm.summary" rows="2" placeholder="AI-generated findings..."
                                  class="w-full px-3.5 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-indigo/20 focus:border-medical-indigo outline-none transition"></textarea>
                    </div>
                    <button type="submit"
                            class="w-full py-3 bg-medical-indigo text-white text-sm font-semibold rounded-lg hover:bg-medical-indigo/90 transition shadow-lg shadow-medical-indigo/20 flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Save Inference</span>
                    </button>
                </form>
            </div>
        </section>

        <!-- Data Summary Dashboard -->
        <section class="mb-10">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Data Summary</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 card-border">
                    <p class="text-3xl font-bold text-medical-teal" x-text="dataStore.scans.length">0</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Scans Uploaded</p>
                </div>
                <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 card-border">
                    <p class="text-3xl font-bold text-medical-cyan" x-text="dataStore.training.length">0</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Training Datasets</p>
                </div>
                <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 card-border">
                    <p class="text-3xl font-bold text-medical-indigo" x-text="dataStore.inferences.length">0</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Inferences Logged</p>
                </div>
                <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 card-border">
                    <p class="text-3xl font-bold text-medical-rose" x-text="dataStore.recommendations.length">0</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Recommendations</p>
                </div>
            </div>
        </section>

        <!-- Recent Data Tables -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
            <!-- Recent Scans -->
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 card-border overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/50 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100">Recent Scans</h3>
                    <span class="text-xs text-slate-400 dark:text-slate-400" x-text="dataStore.scans.length + ' total'"></span>
                </div>
                <div class="overflow-x-auto max-h-80 overflow-y-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 dark:bg-slate-700/30 text-slate-500 dark:text-slate-400 text-xs uppercase sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left">Patient</th>
                                <th class="px-4 py-3 text-left">Condition</th>
                                <th class="px-4 py-3 text-left">Modality</th>
                                <th class="px-4 py-3 text-left">Grade</th>
                                <th class="px-4 py-3 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            <template x-for="(scan, index) in dataStore.scans" :key="index">
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors">
                                    <td class="px-4 py-3 font-mono text-xs text-slate-600 dark:text-slate-300" x-text="scan.patientId"></td>
                                    <td class="px-4 py-3 text-slate-700 dark:text-slate-200" x-text="scan.condition"></td>
                                    <td class="px-4 py-3"><span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-700/40 text-slate-600 dark:text-slate-300 rounded text-xs" x-text="scan.modality"></span></td>
                                    <td class="px-4 py-3"><span class="px-2 py-0.5 bg-medical-teal/10 dark:bg-medical-teal/20 text-medical-teal rounded text-xs" x-text="'Grade ' + scan.severity"></span></td>
                                    <td class="px-4 py-3 text-slate-400 dark:text-slate-400 text-xs" x-text="scan.date"></td>
                                </tr>
                            </template>
                            <tr x-show="dataStore.scans.length === 0">
                                <td colspan="5" class="px-4 py-8 text-center text-slate-400 dark:text-slate-500">No scans uploaded yet</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Inferences -->
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 card-border overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/50 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100">Recent Inferences</h3>
                    <span class="text-xs text-slate-400 dark:text-slate-400" x-text="dataStore.inferences.length + ' total'"></span>
                </div>
                <div class="overflow-x-auto max-h-80 overflow-y-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 dark:bg-slate-700/30 text-slate-500 dark:text-slate-400 text-xs uppercase sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left">Model</th>
                                <th class="px-4 py-3 text-left">Result</th>
                                <th class="px-4 py-3 text-left">Confidence</th>
                                <th class="px-4 py-3 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            <template x-for="(inf, index) in dataStore.inferences" :key="index">
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors">
                                    <td class="px-4 py-3 font-mono text-xs text-slate-600 dark:text-slate-300" x-text="inf.model"></td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-0.5 rounded text-xs"
                                              :class="inf.result.includes('positive') ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' : 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'"
                                              x-text="inf.result"></span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex-1 h-1.5 bg-slate-200 dark:bg-slate-600 rounded-full overflow-hidden">
                                                <div class="h-full rounded-full transition-all"
                                                     :class="inf.confidence > 80 ? 'bg-green-500' : inf.confidence > 60 ? 'bg-yellow-500' : 'bg-red-500'"
                                                     :style="'width: ' + inf.confidence + '%'"></div>
                                            </div>
                                            <span class="text-xs text-slate-500 dark:text-slate-400" x-text="inf.confidence + '%'"></span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-slate-400 dark:text-slate-400 text-xs" x-text="inf.date"></td>
                                </tr>
                            </template>
                            <tr x-show="dataStore.inferences.length === 0">
                                <td colspan="4" class="px-4 py-8 text-center text-slate-400 dark:text-slate-500">No inferences logged yet</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- AI Recommendation Generator -->
        <section class="bg-gradient-to-br from-medical-teal via-medical-cyan to-medical-indigo rounded-2xl p-8 text-white">
            <div class="max-w-3xl">
                <h2 class="text-2xl font-bold mb-3">AI-Powered Treatment Recommendations</h2>
                <p class="text-white/80 mb-6">Generate personalized treatment plans based on uploaded data, current evidence, and integrated protocols.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1.5">Patient/Case Reference</label>
                        <select x-model="recommendation.caseRef"
                                class="w-full px-3.5 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white text-sm focus:ring-2 focus:ring-white/30 outline-none transition">
                            <option value="" class="text-slate-900">Select case...</option>
                            <template x-for="scan in dataStore.scans" :key="scan.patientId">
                                <option :value="scan.patientId" class="text-slate-900" x-text="scan.patientId + ' - ' + scan.condition"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1.5">Treatment Focus</label>
                        <select x-model="recommendation.focus"
                                class="w-full px-3.5 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white text-sm focus:ring-2 focus:ring-white/30 outline-none transition">
                            <option value="comprehensive" class="text-slate-900">Comprehensive (All Modalities)</option>
                            <option value="stem_cell" class="text-slate-900">Stem Cell Therapy</option>
                            <option value="pemf" class="text-slate-900">PEMF Protocol</option>
                            <option value="supplements" class="text-slate-900">Supplements & Herbs</option>
                            <option value="imaging" class="text-slate-900">Imaging Follow-up</option>
                        </select>
                    </div>
                </div>
                <button @click="generateRecommendation()"
                        class="px-6 py-3 bg-white text-medical-teal font-semibold rounded-xl hover:bg-white/90 transition shadow-lg shadow-medical-teal/20 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    <span>Generate Recommendation</span>
                </button>
            </div>
        </section>

        <!-- Generated Recommendations -->
        <section x-show="generatedRecommendation" x-transition class="mt-6 bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 card-border">
            <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-4 flex items-center">
                <svg class="w-5 h-5 text-medical-teal mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Generated Treatment Recommendation
            </h3>
            <div class="prose prose-sm max-w-none text-slate-700 dark:text-slate-300" x-html="generatedRecommendation"></div>
        </section>
    </main>

    <script>
    function dataManager() {
        return {
            uploadStatus: '',
            scanForm: { condition: 'knee_arthritis', modality: 'MRI', patientId: '', severity: '1', file: null, notes: '' },
            trainingForm: { name: '', modelType: 'segmentation', gpu: 'google_colab', file: null, samples: '', labeled: 'fully_labeled' },
            inferenceForm: { model: '', scanRef: '', result: 'positive_finding', confidence: 85, file: null, summary: '' },
            recommendation: { caseRef: '', focus: 'comprehensive' },
            generatedRecommendation: '',
            dataStore: {
                scans: [],
                training: [],
                inferences: [],
                recommendations: []
            },

            init() {
                const saved = localStorage.getItem('regenmed_data');
                if (saved) this.dataStore = JSON.parse(saved);
            },

            saveData() {
                localStorage.setItem('regenmed_data', JSON.stringify(this.dataStore));
            },

            uploadScan() {
                if (!this.scanForm.patientId) { this.uploadStatus = 'Please enter a Patient ID'; return; }
                const scan = {
                    ...this.scanForm,
                    file: this.scanForm.file ? this.scanForm.file.name : 'No file',
                    date: new Date().toLocaleDateString()
                };
                this.dataStore.scans.unshift(scan);
                this.saveData();
                this.uploadStatus = 'Scan uploaded successfully for ' + scan.patientId;
                this.scanForm = { condition: 'knee_arthritis', modality: 'MRI', patientId: '', severity: '1', file: null, notes: '' };
                setTimeout(() => this.uploadStatus = '', 3000);
            },

            uploadTraining() {
                const training = {
                    ...this.trainingForm,
                    file: this.trainingForm.file ? this.trainingForm.file.name : 'No file',
                    date: new Date().toLocaleDateString()
                };
                this.dataStore.training.unshift(training);
                this.saveData();
                this.trainingForm = { name: '', modelType: 'segmentation', gpu: 'google_colab', file: null, samples: '', labeled: 'fully_labeled' };
            },

            uploadInference() {
                const inference = {
                    ...this.inferenceForm,
                    file: this.inferenceForm.file ? this.inferenceForm.file.name : 'No file',
                    date: new Date().toLocaleDateString()
                };
                this.dataStore.inferences.unshift(inference);
                this.saveData();
                this.inferenceForm = { model: '', scanRef: '', result: 'positive_finding', confidence: 85, file: null, summary: '' };
            },

            generateRecommendation() {
                const caseData = this.dataStore.scans.find(s => s.patientId === this.recommendation.caseRef);
                const condName = caseData ? caseData.condition.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : 'General';
                const grade = caseData ? caseData.severity : '2';

                let rec = `<div class="space-y-4">
                    <div class="p-4 bg-medical-teal/5 dark:bg-medical-teal/10 rounded-xl border border-medical-teal/10 dark:border-medical-teal/20">
                        <h4 class="font-semibold text-medical-teal mb-2">Patient Case: ${this.recommendation.caseRef || 'General'}</h4>
                        <p class="text-sm"><strong>Condition:</strong> ${condName}</p>
                        <p class="text-sm"><strong>Severity:</strong> Grade ${grade}</p>
                        <p class="text-sm"><strong>Focus:</strong> ${this.recommendation.focus.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</p>
                    </div>`;

                if (this.recommendation.focus === 'comprehensive' || this.recommendation.focus === 'stem_cell') {
                    rec += `<div class="p-4 bg-medical-violet/5 dark:bg-medical-violet/10 rounded-xl border border-medical-violet/10 dark:border-medical-violet/20">
                        <h4 class="font-semibold text-medical-violet mb-2">Stem Cell Therapy Protocol</h4>
                        <ul class="text-sm space-y-1 list-disc pl-4">
                            <li><strong>Source:</strong> ${this.getStemCellSource(condName)}</li>
                            <li><strong>Delivery:</strong> ${this.getDeliveryMethod(condName)}</li>
                            <li><strong>Cell Count:</strong> ${this.getCellCount(condName)}</li>
                            <li><strong>Schedule:</strong> Single injection with 3-month follow-up imaging</li>
                        </ul>
                    </div>`;
                }

                if (this.recommendation.focus === 'comprehensive' || this.recommendation.focus === 'pemf') {
                    rec += `<div class="p-4 bg-medical-amber/5 dark:bg-medical-amber/10 rounded-xl border border-medical-amber/10 dark:border-medical-amber/20">
                        <h4 class="font-semibold text-medical-amber mb-2">PEMF Therapy Protocol</h4>
                        <ul class="text-sm space-y-1 list-disc pl-4">
                            <li><strong>Frequency:</strong> ${this.getPemfFrequency(condName)}</li>
                            <li><strong>Intensity:</strong> ${this.getPemfIntensity(condName)}</li>
                            <li><strong>Duration:</strong> ${this.getPemfDuration(condName)}</li>
                            <li><strong>Schedule:</strong> Daily sessions for 8-12 weeks</li>
                        </ul>
                    </div>`;
                }

                if (this.recommendation.focus === 'comprehensive' || this.recommendation.focus === 'supplements') {
                    rec += `<div class="p-4 bg-medical-teal/5 dark:bg-medical-teal/10 rounded-xl border border-medical-teal/10 dark:border-medical-teal/20">
                        <h4 class="font-semibold text-medical-teal mb-2">Supplement & Herbal Regimen</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase mb-1.5">Tablets</p>
                                <ul class="text-sm space-y-1 list-disc pl-4">${this.getTablets(condName)}</ul>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase mb-1.5">Herbs</p>
                                <ul class="text-sm space-y-1 list-disc pl-4">${this.getHerbs(condName)}</ul>
                            </div>
                        </div>
                    </div>`;
                }

                if (this.recommendation.focus === 'comprehensive' || this.recommendation.focus === 'imaging') {
                    rec += `<div class="p-4 bg-medical-cyan/5 dark:bg-medical-cyan/10 rounded-xl border border-medical-cyan/10 dark:border-medical-cyan/20">
                        <h4 class="font-semibold text-medical-cyan mb-2">Imaging Follow-up Schedule</h4>
                        <ul class="text-sm space-y-1 list-disc pl-4">
                            <li><strong>Baseline:</strong> Complete imaging workup (current)</li>
                            <li><strong>3 months:</strong> Follow-up imaging to assess treatment response</li>
                            <li><strong>6 months:</strong> Serial imaging for regeneration monitoring</li>
                            <li><strong>12 months:</strong> Comprehensive reassessment with AI comparison</li>
                        </ul>
                    </div>`;
                }

                rec += `<div class="p-4 bg-slate-50 dark:bg-slate-700/30 rounded-xl border border-slate-200 dark:border-slate-700/50">
                    <p class="text-xs text-slate-500 dark:text-slate-400"><strong>Disclaimer:</strong> This is a research-based recommendation generated for educational purposes. All treatment decisions must be made by qualified healthcare providers based on individual patient assessment.</p>
                </div></div>`;

                this.generatedRecommendation = rec;
                this.dataStore.recommendations.unshift({
                    date: new Date().toLocaleDateString(),
                    caseRef: this.recommendation.caseRef || 'General',
                    focus: this.recommendation.focus
                });
                this.saveData();
            },

            getStemCellSource(cond) {
                const sources = {
                    'Knee Osteoarthritis': 'Bone Marrow Concentrate (BMC) or Umbilical Cord MSC',
                    'Macular Degeneration': 'iPSC-derived RPE cells or UC-MSC',
                    'Male Enhancing Fertility': 'Mesenchymal Stem Cells (MSC)',
                    'Female Enhancing Fertility': 'UC-MSC or BMC for ovarian rejuvenation',
                    'Prostate Disease': 'MSC (autologous or allogeneic)'
                };
                return sources[cond] || 'MSC (condition-specific)';
            },
            getDeliveryMethod(cond) {
                const methods = {
                    'Knee Osteoarthritis': 'Intra-articular injection under ultrasound guidance',
                    'Macular Degeneration': 'Subretinal injection by vitreoretinal surgeon',
                    'Male Enhancing Fertility': 'Intratesticular injection or IV infusion',
                    'Female Enhancing Fertility': 'Intrauterine or intraovarian injection',
                    'Prostate Disease': 'Transperineal injection or IV infusion'
                };
                return methods[cond] || 'Targeted injection';
            },
            getCellCount(cond) {
                const counts = {
                    'Knee Osteoarthritis': '1x10^7 to 1x10^8 cells',
                    'Macular Degeneration': '1x10^5 to 5x10^5 RPE cells',
                    'Male Enhancing Fertility': '1x10^6 to 1x10^7 MSC',
                    'Female Enhancing Fertility': '1x10^7 to 5x10^7 cells',
                    'Prostate Disease': '1x10^7 MSC'
                };
                return counts[cond] || '1x10^6 to 1x10^7 cells';
            },
            getPemfFrequency(cond) {
                const freqs = {
                    'Knee Osteoarthritis': '15-50 Hz',
                    'Macular Degeneration': 'N/A (use PBMT: Red/NIR light)',
                    'Male Enhancing Fertility': '1-10 Hz',
                    'Female Enhancing Fertility': '5-25 Hz',
                    'Prostate Disease': '10-50 Hz'
                };
                return freqs[cond] || '1-50 Hz';
            },
            getPemfIntensity(cond) {
                const ints = {
                    'Knee Osteoarthritis': '1-5 mT',
                    'Macular Degeneration': 'N/A (use PBMT)',
                    'Male Enhancing Fertility': '1-5 mT',
                    'Female Enhancing Fertility': '1-3 mT',
                    'Prostate Disease': '1-3 mT'
                };
                return ints[cond] || '1-5 mT';
            },
            getPemfDuration(cond) {
                const durs = {
                    'Knee Osteoarthritis': '30-60 min/day',
                    'Macular Degeneration': 'Daily PBMT sessions',
                    'Male Enhancing Fertility': '30 min/day for 12 weeks',
                    'Female Enhancing Fertility': '30 min/day for 8-12 weeks',
                    'Prostate Disease': '30 min/day for 4-8 weeks'
                };
                return durs[cond] || '30 min/day';
            },
            getTablets(cond) {
                const tabs = {
                    'Knee Osteoarthritis': '<li>Curcumin 1000mg/day</li><li>Glucosamine 1500mg/day</li><li>Vitamin D3 4000IU/day</li><li>Collagen Type II 40mg/day</li>',
                    'Macular Degeneration': '<li>AREDS2 formula daily</li><li>Lutein 10mg/day</li><li>Zeaxanthin 2mg/day</li><li>Omega-3 1000mg/day</li>',
                    'Male Enhancing Fertility': '<li>CoQ10 200mg/day</li><li>L-Carnitine 2000mg/day</li><li>Zinc 30mg/day</li><li>Vitamin D3 4000IU/day</li>',
                    'Female Enhancing Fertility': '<li>Myo-Inositol 4g/day</li><li>CoQ10 200mg/day</li><li>Folate 800mcg/day</li><li>Vitamin D3 4000IU/day</li>',
                    'Prostate Disease': '<li>Saw Palmetto 320mg/day</li><li>Beta-sitosterol 60mg/day</li><li>Zinc 30mg/day</li><li>Lycopene 15mg/day</li>'
                };
                return tabs[cond] || '<li>Multivitamin daily</li>';
            },
            getHerbs(cond) {
                const herbs = {
                    'Knee Osteoarthritis': '<li>Turmeric (Curcuma longa)</li><li>Boswellia serrata</li><li>Ashwagandha</li><li>Ginger</li>',
                    'Macular Degeneration': '<li>Saffron 20mg/day</li><li>Bilberry extract</li><li>Ginkgo biloba</li><li>Goji berry</li>',
                    'Male Enhancing Fertility': '<li>Tongkat Ali</li><li>Ashwagandha</li><li>Maca root</li><li>Fenugreek</li>',
                    'Female Enhancing Fertility': '<li>Vitex (Chasteberry)</li><li>Maca root</li><li>Ashwagandha</li><li>Shatavari</li>',
                    'Prostate Disease': '<li>Saw Palmetto</li><li>Stinging Nettle root</li><li>Pygeum</li><li>Pumpkin seed oil</li>'
                };
                return herbs[cond] || '<li>Consult herbalist</li>';
            }
        }
    }
    </script>