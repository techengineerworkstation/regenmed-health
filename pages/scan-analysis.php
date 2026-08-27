<?php if (!VERCEL_MODE && session_status() === PHP_SESSION_NONE) { session_start(); } ?><?php $scanEndpoint = VERCEL_MODE ? 'api/scan-analyze.php' : 'includes/scan-analyze.php'; ?>
<main class="max-w-7xl mx-auto px-4 py-12">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 flex items-center justify-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-medical-teal/10 flex items-center justify-center"><i class="lucide-upload-cloud text-medical-teal"></i></span>
            AI Scan Analysis
        </h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2 max-w-2xl mx-auto">Upload a lab scan (MRI, OCT, ultrasound, X-ray) for AI-assisted analysis — GPU-accelerated on your host machine or a cloud GPU VPS. Educational use only.</p>
    </div>

    <!-- BACKEND STATUS -->
    <div id="backendStatus" class="flex flex-wrap justify-center gap-3 mb-8">
        <div class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm flex items-center gap-2">
            <span id="localDot" class="w-2.5 h-2.5 rounded-full bg-slate-300"></span>
            Host GPU: <strong id="localLabel" class="text-slate-500">checking…</strong>
        </div>
        <div class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm flex items-center gap-2">
            <span id="cloudDot" class="w-2.5 h-2.5 rounded-full bg-slate-300"></span>
            Cloud GPU VPS: <strong id="cloudLabel" class="text-slate-500">checking…</strong>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <!-- UPLOAD -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700/50">
            <h2 class="font-bold text-lg text-slate-900 dark:text-slate-100 mb-4">1. Upload Scan</h2>
            <form id="scanForm">
                <div id="dropZone" class="border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl p-10 text-center cursor-pointer hover:border-medical-teal transition-colors">
                    <i class="lucide-scan text-4xl text-medical-teal mb-3"></i>
                    <p class="text-slate-600 dark:text-slate-300 font-medium">Drag &amp; drop your scan here</p>
                    <p class="text-xs text-slate-400 mt-1">JPEG / PNG / WebP · max 20MB</p>
                    <input type="file" id="scanFile" accept="image/jpeg,image/png,image/webp" class="hidden">
                    <img id="preview" class="hidden max-h-48 mx-auto mt-4 rounded-lg">
                </div>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1">Scan Type</label>
                        <select id="modality" class="w-full rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 px-3 py-2 text-sm text-slate-900 dark:text-slate-100">
                            <option>Knee MRI</option>
                            <option>Retinal OCT</option>
                            <option>Prostate mpMRI</option>
                            <option>Fertility Ultrasound</option>
                            <option selected>General</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1">Notes (optional)</label>
                        <input type="text" id="notes" placeholder="Symptoms, region, concern…" class="w-full rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 px-3 py-2 text-sm text-slate-900 dark:text-slate-100">
                    </div>
                </div>
                <button type="submit" id="analyzeBtn" class="mt-4 w-full py-3 rounded-xl bg-medical-teal text-white font-semibold hover:bg-medical-teal/90 transition-colors disabled:opacity-50" disabled>
                    <i class="lucide-cpu mr-2"></i>Analyze with AI
                </button>
            </form>
        </div>

        <!-- RESULTS -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700/50">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-lg text-slate-900 dark:text-slate-100">2. Analysis Report</h2>
                <span id="gpuBadge" class="hidden text-xs font-bold px-3 py-1.5 rounded-lg bg-green-500/10 text-green-600 dark:text-green-400"></span>
                <span id="heurBadge" class="hidden text-xs font-bold px-3 py-1.5 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400">Heuristic mode — no GPU backend</span>
            </div>
            <div id="resultEmpty" class="text-center text-slate-400 py-16">
                <i class="lucide-file-text text-4xl mb-3"></i>
                <p class="text-sm">Upload a scan and press Analyze to see the report here.</p>
            </div>
            <div id="resultLoading" class="hidden text-center text-slate-400 py-16">
                <i class="lucide-loader-2 text-4xl mb-3 animate-spin"></i>
                <p class="text-sm">Analyzing scan… this can take up to a minute on local GPU.</p>
            </div>
            <div id="resultBox" class="hidden">
                <div id="aiSection" class="hidden mb-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-medical-teal mb-2">AI Findings</h3>
                    <div id="aiText" class="text-sm text-slate-700 dark:text-slate-200 whitespace-pre-wrap leading-relaxed bg-slate-50 dark:bg-slate-900/50 rounded-xl p-4"></div>
                </div>
                <div id="heurSection" class="mb-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-medical-teal mb-2">Image Metrics</h3>
                    <p id="heurQuality" class="text-sm font-medium text-slate-800 dark:text-slate-100 mb-2"></p>
                    <ul id="heurObs" class="text-sm text-slate-600 dark:text-slate-300 space-y-1 list-disc list-inside"></ul>
                </div>
                <div id="followupSection" class="mb-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-medical-teal mb-2">Suggested Follow-up</h3>
                    <p id="followupText" class="text-sm text-slate-600 dark:text-slate-300"></p>
                </div>
                <p class="text-xs text-slate-400 border-t border-slate-100 dark:border-slate-700 pt-3" id="disclaimer"></p>
            </div>
            <div id="resultError" class="hidden text-center text-red-500 py-10 text-sm"></div>
        </div>
    </div>

    <!-- CLOUD GPU HOOK -->
    <div class="mt-8 bg-gradient-to-r from-medical-teal/5 to-indigo-500/5 rounded-2xl p-5 border border-slate-100 dark:border-slate-700/50 flex flex-col md:flex-row md:items-center gap-4 justify-between">
        <div>
            <h3 class="font-semibold text-slate-900 dark:text-slate-100 flex items-center gap-2"><i class="lucide-server text-medical-teal"></i> Need more GPU power?</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Hook a cloud GPU VPS (RunPod, Lambda, Vast.ai…) running any OpenAI-compatible vision server — set its URL as your cloud endpoint and scans analyze remotely at full speed.</p>
        </div>
        <a href="index.php?page=vps-providers" class="px-4 py-2.5 rounded-xl bg-medical-teal text-white text-sm font-semibold hover:bg-medical-teal/90 transition-colors whitespace-nowrap">Browse GPU VPS Providers →</a>
    </div>
</main>

<script nonce="<?= SecurityManager::getNonce() ?>">
(function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('scanFile');
    const preview = document.getElementById('preview');
    const analyzeBtn = document.getElementById('analyzeBtn');
    let selectedFile = null;

    function setStatus(dotId, labelId, s) {
        const dot = document.getElementById(dotId), label = document.getElementById(labelId);
        if (s.online) {
            dot.className = 'w-2.5 h-2.5 rounded-full ' + (s.accelerated ? 'bg-green-500' : 'bg-yellow-500');
            label.textContent = s.accelerated ? (s.type + ' accelerated') : 'online (CPU)';
            label.className = s.accelerated ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400';
        } else {
            dot.className = 'w-2.5 h-2.5 rounded-full bg-slate-300';
            label.textContent = 'offline';
            label.className = 'text-slate-400';
        }
    }

    fetch('<?= $scanEndpoint ?>?action=status').then(r => r.json()).then(d => {
        setStatus('localDot', 'localLabel', d.local);
        setStatus('cloudDot', 'cloudLabel', d.cloud);
        if (!d.local.online && !d.cloud.online) {
            document.getElementById('heurBadge').classList.remove('hidden');
        }
    }).catch(() => {
        document.getElementById('localLabel').textContent = 'unreachable';
        document.getElementById('heurBadge').classList.remove('hidden');
    });

    dropZone.addEventListener('click', () => fileInput.click());
    ['dragover', 'dragenter'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.add('border-medical-teal'); }));
    ['dragleave', 'drop'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.remove('border-medical-teal'); }));
    dropZone.addEventListener('drop', ev => { if (ev.dataTransfer.files.length) setFile(ev.dataTransfer.files[0]); });
    fileInput.addEventListener('change', () => { if (fileInput.files.length) setFile(fileInput.files[0]); });

    function setFile(file) {
        if (!/^image\/(jpeg|png|webp)$/.test(file.type)) { alert('Only JPEG/PNG/WebP accepted'); return; }
        selectedFile = file;
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.classList.remove('hidden'); };
        reader.readAsDataURL(file);
        analyzeBtn.disabled = false;
    }

    document.getElementById('scanForm').addEventListener('submit', function(ev) {
        ev.preventDefault();
        if (!selectedFile) return;
        const fd = new FormData();
        fd.append('scan', selectedFile);
        fd.append('modality', document.getElementById('modality').value);
        fd.append('notes', document.getElementById('notes').value);
        analyzeBtn.disabled = true;
        document.getElementById('resultEmpty').classList.add('hidden');
        document.getElementById('resultBox').classList.add('hidden');
        document.getElementById('resultError').classList.add('hidden');
        document.getElementById('resultLoading').classList.remove('hidden');

        fetch('<?= $scanEndpoint ?>', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(d => {
                document.getElementById('resultLoading').classList.add('hidden');
                if (!d.ok) { document.getElementById('resultError').textContent = d.error || 'Analysis failed'; document.getElementById('resultError').classList.remove('hidden'); return; }
                const gpuBadge = document.getElementById('gpuBadge'), heurBadge = document.getElementById('heurBadge');
                gpuBadge.classList.add('hidden'); heurBadge.classList.add('hidden');
                if (d.backend === 'heuristic') {
                    heurBadge.classList.remove('hidden');
                    document.getElementById('aiSection').classList.add('hidden');
                } else {
                    gpuBadge.textContent = (d.gpu.accelerated ? '⚡ GPU accelerated' : 'AI analysis') + (d.gpu.type ? ' · ' + d.gpu.type : '') + (d.backend === 'cloud-gpu' ? ' · cloud VPS' : ' · host');
                    gpuBadge.classList.remove('hidden');
                    document.getElementById('aiSection').classList.remove('hidden');
                    document.getElementById('aiText').textContent = d.ai_text;
                }
                document.getElementById('heurSection').classList.remove('hidden');
                document.getElementById('heurQuality').textContent = d.heuristic.quality;
                const obs = document.getElementById('heurObs');
                obs.innerHTML = '';
                (d.heuristic.observations || []).forEach(o => { const li = document.createElement('li'); li.textContent = o; obs.appendChild(li); });
                document.getElementById('followupSection').classList.remove('hidden');
                document.getElementById('followupText').textContent = (d.heuristic.followup || []).join(' · ');
                document.getElementById('disclaimer').textContent = d.disclaimer;
                document.getElementById('resultBox').classList.remove('hidden');
            })
            .catch(err => {
                document.getElementById('resultLoading').classList.add('hidden');
                document.getElementById('resultError').textContent = 'Network error: ' + err.message;
                document.getElementById('resultError').classList.remove('hidden');
            })
            .finally(() => { analyzeBtn.disabled = false; });
    });
})();
</script>
