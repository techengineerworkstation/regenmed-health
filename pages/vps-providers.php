<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8 animate-fade-in">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">GPU Cloud Providers</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2">Free and paid GPU resources for medical lab scan AI training, inference, and model deployment.</p>
        <div class="flex flex-wrap gap-2 mt-4">
            <span class="px-3 py-1 bg-medical-teal/10 text-medical-teal dark:text-teal-400 rounded-full text-xs font-medium">
                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Free Options Available
            </span>
            <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full text-xs font-medium">
                No Credit Card Required
            </span>
        </div>
    </div>

    <!-- FREE TIER SECTION -->
    <div class="mb-10">
        <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4 flex items-center">
            <span class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </span>
            Free Tier — No Credit Card Required
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            <?php 
            $freeProviders = array_filter($vpsProviders, fn($p) => str_contains($p['tier'], 'Free'));
            foreach ($freeProviders as $key => $provider): 
            ?>
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 card-border card-hover relative overflow-hidden
                <?php if ($key === 'google_colab'): ?>ring-2 ring-medical-teal<?php endif; ?>">
                <?php if ($key === 'google_colab'): ?>
                <div class="absolute top-0 right-0 bg-medical-teal text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                    RECOMMENDED
                </div>
                <?php endif; ?>
                <?php if ($key === 'ngc'): ?>
                <div class="absolute top-0 right-0 bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                    RESEARCH GRANT
                </div>
                <?php endif; ?>
                
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100"><?= $provider['name'] ?></h3>
                    <span class="px-2.5 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium rounded-full">
                        <?= $provider['tier'] ?>
                    </span>
                </div>
                
                <div class="space-y-2.5 text-sm mb-4">
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">GPU</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $provider['gpu'] ?></span>
                    </div>
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">Weekly Limit</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $provider['weekly_limit'] ?? 'N/A' ?></span>
                    </div>
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">Max Session</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $provider['session_limit'] ?? 'N/A' ?></span>
                    </div>
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">Best For</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $provider['best'] ?></span>
                    </div>
                </div>
                
                <a href="https://<?= $provider['url'] ?>" target="_blank" rel="noopener noreferrer"
                   class="block w-full text-center py-2 bg-medical-teal/10 hover:bg-medical-teal/20 text-medical-teal dark:text-teal-400 rounded-lg text-sm font-medium transition-colors">
                    Get Started →
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- PAID TIER SECTION -->
    <div class="mb-10">
        <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4 flex items-center">
            <span class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            Paid Tier — Per-Second Billing
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            <?php 
            $paidProviders = array_filter($vpsProviders, fn($p) => $p['tier'] === 'Paid');
            foreach ($paidProviders as $key => $provider): 
            ?>
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 card-border card-hover">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-slate-900 dark:text-slate-100"><?= $provider['name'] ?></h3>
                    <span class="px-2.5 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-medium rounded-full">
                        Paid
                    </span>
                </div>
                
                <div class="space-y-2.5 text-sm mb-4">
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">GPU</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $provider['gpu'] ?></span>
                    </div>
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">Cost</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $provider['cost'] ?></span>
                    </div>
                    <div class="flex justify-between p-2.5 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                        <span class="text-slate-500 dark:text-slate-400">Best For</span>
                        <span class="font-medium text-slate-900 dark:text-slate-200"><?= $provider['best'] ?></span>
                    </div>
                </div>
                
                <a href="https://<?= $provider['url'] ?>" target="_blank" rel="noopener noreferrer"
                   class="block w-full text-center py-2 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg text-sm font-medium transition-colors">
                    Open Provider →
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- RECOMMENDED WORKFLOW -->
    <section class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-700 card-border mb-8">
        <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6">Recommended Workflow for Medical Lab Scan ML</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <?php
            $workflow = [
                ['step' => '1', 'title' => 'Prototype', 'desc' => 'Google Colab T4', 'detail' => 'Test architectures, preprocess DICOM data', 'color' => 'teal'],
                ['step' => '2', 'title' => 'Scale', 'desc' => 'SageMaker Lab T4', 'detail' => 'Longer sessions for larger datasets', 'color' => 'cyan'],
                ['step' => '3', 'title' => 'Train', 'desc' => 'NGC A100 or RunPod', 'detail' => 'Full model training on clinical datasets', 'color' => 'indigo'],
                ['step' => '4', 'title' => 'Deploy', 'desc' => 'CoreWeave H100 or Lambda', 'detail' => 'Production inference and API serving', 'color' => 'violet'],
            ];
            foreach ($workflow as $w):
            ?>
            <div class="relative p-5 bg-slate-50 dark:bg-slate-700/30 rounded-xl border border-slate-100 dark:border-slate-700/50">
                <div class="w-8 h-8 rounded-full bg-<?= $w['color'] ?>-100 dark:bg-<?= $w['color'] ?>-900/30 text-<?= $w['color'] ?>-600 dark:text-<?= $w['color'] ?>-400 flex items-center justify-center text-sm font-bold mb-3">
                    <?= $w['step'] ?>
                </div>
                <h4 class="font-semibold text-slate-900 dark:text-slate-100 text-sm"><?= $w['title'] ?></h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1"><?= $w['desc'] ?></p>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1"><?= $w['detail'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- QUICK REGISTRATION GUIDE -->
    <section class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-700 card-border">
        <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6">Quick Registration Guide</h2>
        <div class="space-y-4">
            <?php
            $guides = [
                ['provider' => 'Google Colab (FREE — Recommended)', 'steps' => [
                    'Go to colab.research.google.com',
                    'Sign in with Google account',
                    'Runtime → Change runtime type → GPU (T4)',
                    'Verify GPU: !nvidia-smi',
                    'Start training: pip install monai torch',
                ]],
                ['provider' => 'SageMaker Studio Lab (FREE — No billing)', 'steps' => [
                    'Go to studiolab.sagemaker.aws',
                    'Sign in with AWS account (no payment required)',
                    'Create project → Select GPU instance type',
                    'Upload notebook or start new',
                    'Note: 4hr sessions, storage resets after 14 days',
                ]],
                ['provider' => 'NVIDIA NGC (FREE — Research Grant)', 'steps' => [
                    'Go to ngc.nvidia.com → Sign up',
                    'Apply for NGC Community License',
                    'Access NGC Containers for medical lab scans',
                    'A100 instances for qualifying research',
                    'Best for: serious clinical model training',
                ]],
                ['provider' => 'RunPod ($0.44/hr — Fast Training)', 'steps' => [
                    'Go to runpod.io → Sign up',
                    'Verify email, add payment method',
                    'Console → GPU Pods → Deploy',
                    'Select RTX 4090 or A100, PyTorch template',
                    'Per-second billing, ready in seconds',
                ]],
            ];
            foreach ($guides as $guide):
            ?>
            <div class="p-5 bg-slate-50 dark:bg-slate-700/30 rounded-xl border border-slate-100 dark:border-slate-700/50">
                <h4 class="font-semibold text-slate-900 dark:text-slate-100 mb-3"><?= $guide['provider'] ?></h4>
                <ol class="space-y-1.5">
                    <?php foreach ($guide['steps'] as $i => $step): ?>
                    <li class="text-sm text-slate-600 dark:text-slate-300 flex items-center">
                        <span class="w-5 h-5 rounded-full bg-medical-teal text-white text-xs flex items-center justify-center mr-2 flex-shrink-0">
                            <?= $i + 1 ?>
                        </span>
                        <?= $step ?>
                    </li>
                    <?php endforeach; ?>
                </ol>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>
