    <main class="min-h-[80vh] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md animate-fade-in">
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 card-border overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-medical-teal to-medical-cyan">
                    <h1 class="text-2xl font-bold text-white text-center">Sign In</h1>
                    <p class="text-white/80 text-sm text-center mt-1">Access the Diagnostic Platform</p>
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
                            <span><?= SecurityManager::sanitizeOutput($error) ?></span>
                        </p>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="?page=login" class="space-y-5">
                        <input type="hidden" name="csrf_token" value="<?= SecurityManager::sanitizeOutput($csrfToken) ?>">
                        <?= SecurityManager::getHoneypotField() ?>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Username</label>
                            <input type="text" name="username" required autocomplete="username"
                                   value="<?= SecurityManager::sanitizeOutput($_POST['username'] ?? '') ?>"
                                   placeholder="Enter your username"
                                   class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-teal/20 focus:border-medical-teal outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
                            <input type="password" name="password" required autocomplete="current-password"
                                   placeholder="Enter your password"
                                   class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-teal/20 focus:border-medical-teal outline-none transition">
                        </div>
                        <button type="submit"
                                class="w-full py-3 bg-medical-teal text-white font-semibold rounded-lg hover:bg-medical-teal/90 focus:ring-2 focus:ring-offset-2 focus:ring-medical-teal/30 transition shadow-lg shadow-medical-teal/30 flex items-center justify-center space-x-2"
                                <?= $lockoutRemaining > 0 ? 'disabled' : '' ?>>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11.983 0v2m0 0a2 2 0 012 2v2m0 0h-4a2 2 0 00-2 2v2H7.983v10a2 2 0 002 2h8a2 2 0 002-2V8h-4V4a2 2 0 012-2h2z"/>
                            </svg>
                            <span>Sign In</span>
                        </button>
                    </form>
                    <p class="text-center text-sm text-slate-500 dark:text-slate-400 mt-6">
                        Don't have an account?
                        <a href="?page=register" class="text-medical-teal font-medium hover:underline">Register</a>
                    </p>
                </div>
            </div>
        </div>
    </main>