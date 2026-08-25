    <main class="min-h-[80vh] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md animate-fade-in">
            <div class="bg-white dark:bg-slate-800 dark:border-slate-700/50 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 card-border overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-medical-indigo to-medical-violet">
                    <h1 class="text-2xl font-bold text-white text-center">Create Account</h1>
                    <p class="text-white/80 text-sm text-center mt-1">Join the Regen Med Health Platform</p>
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

                    <form method="POST" action="?page=register" class="space-y-5">
                        <input type="hidden" name="csrf_token" value="<?= SecurityManager::sanitizeOutput($csrfToken) ?>">
                        <?= SecurityManager::getHoneypotField() ?>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Username</label>
                            <input type="text" name="username" required autocomplete="username" minlength="3" maxlength="50"
                                   value="<?= SecurityManager::sanitizeOutput($_POST['username'] ?? '') ?>"
                                   placeholder="Choose a username"
                                   class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-indigo/20 focus:border-medical-indigo outline-none transition">
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">Letters, numbers, underscores only</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
                            <input type="password" name="password" required minlength="6" autocomplete="new-password"
                                   placeholder="Create a password"
                                   class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-indigo/20 focus:border-medical-indigo outline-none transition">
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">Minimum 6 characters</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Confirm Password</label>
                            <input type="password" name="password_confirm" required minlength="6" autocomplete="new-password"
                                   placeholder="Repeat your password"
                                   class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-medical-indigo/20 focus:border-medical-indigo outline-none transition">
                        </div>
                        <button type="submit"
                                class="w-full py-3 bg-medical-indigo text-white font-semibold rounded-lg hover:bg-medical-indigo/90 focus:ring-2 focus:ring-offset-2 focus:ring-medical-indigo/30 transition shadow-lg shadow-medical-indigo/30 flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M18 9v6m-3-3h6M8 7V3m0 0L5 6m3-3v4m-3 4h6a2 2 0 110 4H5a2 2 0 110-4zm13 9a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>Create Account</span>
                        </button>
                    </form>
                    <p class="text-center text-sm text-slate-500 dark:text-slate-400 mt-6">
                        Already have an account?
                        <a href="?page=login" class="text-medical-indigo font-medium hover:underline">Sign In</a>
                    </p>
                </div>
            </div>
        </div>
    </main>