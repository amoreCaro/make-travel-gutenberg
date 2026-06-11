<?php 
    if (!defined('ABSPATH')) exit; 
?>

<div id="modal" class="fixed inset-0 flex items-center justify-center bg-zinc-900/60 backdrop-blur-sm z-50 p-4 close">
    <div class="modal max-w-[500px] w-full rounded-2xl bg-white dark:bg-zinc-950 shadow-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
        <div class="modal__head p-8 pb-4 text-left relative">
            <h2 class="text-3xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-50"><?php _e("Sign in", THEME); ?></h2>
            <p class="text-zinc-500 dark:text-zinc-400 mt-2 text-sm"><?php _e("Welcome back! Please enter your details.", THEME); ?></p>
            <button id="closeSignInModal" class="absolute top-8 right-8 text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="modal__content p-8 pt-2 flex flex-col gap-5">
            <ul class="flex gap-6 mb-2 border-b-2 border-zinc-100 dark:border-zinc-800">
                <li>
                    <a href="#" data-tab="login" class="tab__link inline-block pb-3 text-sm font-semibold  dark:border-zinc-100 text-zinc-900 dark:text-zinc-100">
                        <?php _e("Log In", THEME); ?>
                    </a>
                </li>
                <li>
                    <a href="#" data-tab="register" class="tab__link inline-block pb-3 text-sm font-medium text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                        <?php _e("Register", THEME); ?>
                    </a>
                </li>
            </ul>
            <div class="tab tab--login">
                <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="form form-login flex flex-col gap-5">
                    <input type="hidden" name="action" value="login_user">
                    <?php wp_nonce_field('login_user_nonce', 'nonce'); ?>

                    <!-- Username -->
                    <div class="relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 group-focus-within:text-zinc-900 dark:group-focus-within:text-zinc-100 transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <input type="text" name="username" placeholder="Username" class="form__input form__input-username w-full pl-11 pr-4 py-3.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:focus:ring-zinc-100/5 focus:border-zinc-900 dark:focus:border-zinc-100 transition-all">
                    </div>

                    <!-- Password -->
                    <div class="relative group password-field">
                        <!-- Icon left -->

                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 group-focus-within:text-zinc-900 dark:group-focus-within:text-zinc-100 transition-colors">

                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"

                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                                <rect x="3" y="11" width="18" height="11" rx="2"></rect>

                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>

                            </svg>

                        </div>

                        <!-- Input -->
                        <input type="password" name="password"placeholder="Password"class="form__input form__input-password w-full pl-11 pr-12 py-3.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:focus:ring-zinc-100/5 focus:border-zinc-900 dark:focus:border-zinc-100 transition-all">

                        <!-- Toggle button -->

                        <button type="button" class="toggle-password absolute right-4 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100">
                            <!-- Show -->

                            <svg class="show-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>

                            <!-- Hide -->
                            <svg class="hide-icon hidden" xmlns="http://www.w3.org/2000/svg"
                                width="18" height="18" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                                        c4.478 0 8.268 2.943 9.542 7
                                        -1.274 4.057-5.064 7-9.542 7
                                        -4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>

                    <a href="/forgot-password" class="text-xs text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 underline underline-offset-4">
                        <?php _e("Lost Your Password?", THEME); ?>
                    </a>
                    <label class="flex items-center gap-3 cursor-pointer w-fit">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" name="rememberMe" class="form__input-checkbox peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-zinc-300 dark:border-zinc-700 bg-transparent transition-all checked:bg-zinc-900 dark:checked:bg-zinc-100 checked:border-zinc-900 dark:checked:border-zinc-100"/>

                            <svg 
                                class="pointer-events-none absolute top-1/2 left-1/2 h-3.5 w-3.5 -translate-x-1/2 -translate-y-1/2 opacity-0 peer-checked:opacity-100 stroke-white dark:stroke-zinc-900" 
                                xmlns="http://www.w3.org/2000/svg" 
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke-width="4"
                            >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>

                        </div>

                        <span class="text-sm text-zinc-600 dark:text-zinc-400 transition-colors">
                             <?php _e("Remember Me", THEME); ?>
                        </span>
                    </label>

                    <div class="pt-2">
                        <button type="submit" class="w-full md:w-auto py-3 px-12 rounded-xl bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 font-semibold hover:bg-zinc-800 dark:hover:bg-white transition-all shadow-lg shadow-zinc-200 dark:shadow-none active:scale-[0.98]">
                            <?php _e("Login", THEME); ?>
                        </button>

                        <div class="popup-success hidden flex items-center p-4 mt-5 mb-0 rounded-xl border border-[#bbf7d0] bg-[#f0fdf4] shadow-sm shadow-[#dcfce7]" role="alert">
                            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-[#dcfce7] text-[#16a34a]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>

                            <div class="ms-4 text-left">
                                <p class="text-sm text-[#15803d]"><?php _e("Login success.", THEME); ?></p>
                            </div>
                        </div>

                        <div class="popup-info hidden flex items-center p-4 mt-5 mb-0 rounded-xl border border-[#bfdbfe] bg-[#eff6ff] shadow-sm shadow-[#dbeafe]" role="alert">
                            
                            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-[#dbeafe] text-[#2563eb]">
                                <svg style="animation: spin 1s linear infinite;" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <style>
                                        @keyframes spin {
                                            from { transform: rotate(0deg); }
                                            to { transform: rotate(360deg); }
                                        }
                                    </style>
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>

                            <div class="ms-4 text-left">
                                <p class="text-sm font-semibold text-[#1d4ed8] leading-tight">
                                    <?php _e("Sending user info...", THEME); ?>
                                </p>
                                <p class="text-xs text-[#93c5fd] mt-0.5 font-medium">
                                    <?php _e("Please wait, it will only take a moment", THEME); ?>
                                </p>
                            </div>
                        </div>

                        <div class="popup-error hidden flex items-center p-4 mt-5 mb-0 rounded-xl border border-[#fecaca] bg-[#fef2f2] shadow-sm shadow-[#fee2e2]" role="alert">
                            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-[#fee2e2] text-[#dc2626]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>

                            <div class="ms-4 text-left">
                                <p class="popup-error__text text-sm text-[#b91c1c]">
                                <?php _e("This email is already registered.", THEME); ?>
                                <a href="#" class="font-bold !underline !text-[#991b1b] hover:!text-[#7f1d1d]"><?php _e("Login instead?", THEME); ?></a></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab tab--register">
                <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="form form-register flex flex-col gap-5">
                   <input type="hidden" name="action" value="register_user">
                    <?php wp_nonce_field('register_user_action', 'nonce'); ?>

                    <!-- Username -->
                    <div class="relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 group-focus-within:text-zinc-900 dark:group-focus-within:text-zinc-100 transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>

                        <input type="text" name="username" placeholder="Username" class="form__input form__input-username w-full pl-11 pr-4 py-3.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:focus:ring-zinc-100/5 focus:border-zinc-900 dark:focus:border-zinc-100 transition-all">
                    </div>

                    <!-- Email -->

                    <div class="relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 group-focus-within:text-zinc-900 dark:group-focus-within:text-zinc-100 transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 7.00005L10.2426 12.2022C11.2426 13.0355 12.7574 13.0355 13.7574 12.2022L20 7.00005" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="3" y="5" width="18" height="14" rx="3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>

                        <input type="text" name="email"placeholder="Email Adress" class="form__input form__input-email w-full pl-11 pr-4 py-3.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:focus:ring-zinc-100/5 focus:border-zinc-900 dark:focus:border-zinc-100 transition-all">

                    </div>

                    <!-- Password -->

                    <div class="relative group password-field">
                        <!-- Icon left -->
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 group-focus-within:text-zinc-900 dark:group-focus-within:text-zinc-100 transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <!-- Input -->
                        <input type="password" name="password" placeholder="Password" class="form__input form__input-password w-full pl-11 pr-12 py-3.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:focus:ring-zinc-100/5 focus:border-zinc-900 dark:focus:border-zinc-100 transition-all">

                        <!-- Toggle button -->

                        <button type="button" class="toggle-password absolute right-4 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100">
                            <!-- Show -->
                            <svg class="show-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>
                            <!-- Hide -->
                            <svg class="hide-icon hidden" xmlns="http://www.w3.org/2000/svg"
                                width="18" height="18" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                                        c4.478 0 8.268 2.943 9.542 7
                                        -1.274 4.057-5.064 7-9.542 7
                                        -4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>

                    <label class="flex items-center gap-3 cursor-pointer w-fit">
                        <div class="relative flex items-center justify-center">
                            <input 
                                type="checkbox" 
                                name="agreeToTermsAndConditions"
                                class="form__input-checkbox peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-zinc-300 dark:border-zinc-700 bg-transparent transition-all checked:bg-zinc-900 dark:checked:bg-zinc-100 checked:border-zinc-900 dark:checked:border-zinc-100"
                            />

                            <svg class="pointer-events-none absolute top-1/2 left-1/2 h-3.5 w-3.5 -translate-x-1/2 -translate-y-1/2 opacity-0 peer-checked:opacity-100 stroke-white dark:stroke-zinc-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>

                        <span class="text-sm text-zinc-600 dark:text-zinc-400 transition-colors">
                             <?php _e("I agree to the", THEME); ?>
                             <a class="text-blue-500 hover:text-zinc-600 dark:hover:text-zinc-400">
                                <?php _e("Terms and Conditions", THEME); ?>
                            </a>
                        </span>
                    </label>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full md:w-auto py-3 px-12 rounded-xl bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 font-semibold hover:bg-zinc-800 dark:hover:bg-white transition-all shadow-lg shadow-zinc-200 dark:shadow-none active:scale-[0.98] disabled:bg-zinc-400 dark:disabled:bg-zinc-40 disabled:text-zinc-200 dark:disabled:text-zinc- disabled:cursor-not-allowed disabled:opacity-70"

                        >

                            <?php _e("Register", THEME); ?>
                        </button>

                        <div class="popup-success hidden flex items-center p-4 mt-5 mb-0 rounded-xl border border-[#bbf7d0] bg-[#f0fdf4] shadow-sm shadow-[#dcfce7]" role="alert">
                            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-[#dcfce7] text-[#16a34a]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>

                            <div class="ms-4 text-left">
                                <p class="text-sm text-[#15803d]"><?php _e("Your account has been created successfully.", THEME); ?></p>
                            </div>
                        </div>

                        <div class="popup-error hidden flex items-center p-4 mt-5 mb-0 rounded-xl border border-[#fecaca] bg-[#fef2f2] shadow-sm shadow-[#fee2e2]" role="alert">
                            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-[#fee2e2] text-[#dc2626]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ms-4 text-left">
                                <p class="popup-error__text text-sm text-[#b91c1c]">
                                <?php _e("This email is already registered.", THEME); ?>
                                <a href="#" class="font-bold !underline !text-[#991b1b] hover:!text-[#7f1d1d]"><?php _e("Login instead?", THEME); ?></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>