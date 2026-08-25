    <main class="min-h-[80vh] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md animate-fade-in">
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 card-border overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-[#16a34a] via-[#0d9488] to-[#7c3aed]">
                    <div class="flex justify-center mb-3">
                        <img src="/assets/svg/logo.svg" alt="Logo" class="w-12 h-12">
                    </div>
                    <h1 class="text-2xl font-bold text-white text-center">Sign In to Regen Med Health</h1>
                    <p class="text-white/80 text-sm text-center mt-1">No password needed — enter your email to receive a magic link</p>
                </div>
                <div class="p-8">
                    <?php if (!empty($errors)): ?>
                    <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30 rounded-lg">
                        <?php foreach ($errors as $error): ?>
                        <p class="text-sm text-red-700 dark:text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <span><?= SecurityManager::sanitizeOutput(is_array($error) ? implode(', ', $error) : $error) ?></span>
                        </p>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($magicLinkGenerated)): ?>
                    <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800/30 rounded-lg">
                        <p class="text-sm text-green-700 dark:text-green-400 font-medium mb-2">Your sign-in link is ready:</p>
                        <a href="<?= SecurityManager::sanitizeOutput($magicLinkGenerated) ?>"
                           class="block text-sm text-medical-teal font-mono break-all underline hover:text-[#7c3aed] transition">
                            <?= SecurityManager::sanitizeOutput($magicLinkGenerated) ?>
                        </a>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Click the link above to sign in. The link expires in 15 minutes.</p>
                    </div>
                    <?php else: ?>
                    <form method="POST" action="?page=login" class="space-y-5">
                        <input type="hidden" name="csrf_token" value="<?= SecurityManager::sanitizeOutput($csrfToken) ?>">
                        <?= SecurityManager::getHoneypotField() ?>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email Address</label>
                            <input type="email" name="email" required autocomplete="email"
                                   value="<?= SecurityManager::sanitizeOutput($_POST['email'] ?? '') ?>"
                                   placeholder="you@example.com"
                                   class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-[#0d9488]/20 focus:border-[#0d9488] outline-none transition">
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">We'll send you a one-time sign-in link</p>
                        </div>
                        <button type="submit"
                                class="w-full py-3 bg-gradient-to-r from-[#16a34a] via-[#0d9488] to-[#7c3aed] text-white font-semibold rounded-lg hover:opacity-90 focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]/30 transition shadow-lg shadow-[#0d9488]/30 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>Send Magic Link</span>
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
