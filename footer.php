<?php
if (!defined('ABSPATH')) {
    exit;
}

$disclaimer = wp_kses_post(carbon_get_theme_option('footer_text'));

$nav_menu   = get_nav_menu_locations();
$menu_items = [];

if (isset($nav_menu['footer_menu'])) {
    $menu_id    = $nav_menu['footer_menu'];
    $menu_items = wp_get_nav_menu_items($menu_id);
}

$before_year = carbon_get_theme_option('footer_before_year');

$pre_text = carbon_get_theme_option('footer_pre_text');

$link_text = carbon_get_theme_option('footer_link_text');

$link_url = carbon_get_theme_option('footer_link_url');

$post_text = carbon_get_theme_option('footer_post_text');

$current_year = date('Y');

?>

<footer class="w-full bg-[#f4f7fa] py-12 px-4 font-sans text-[#1e293b]">
    <div class="container mx-auto">
        
        <!-- Головна біла картка футера -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 md:p-12">
            
            <!-- Верхня частина: 3 колонки -->
            <div class="grid grid-cols-3 lg:grid-cols-12 gap-8 pb-8 border-b border-slate-100">
                
                <!-- Про компанію (Колонка 1) -->
                <div class="lg:col-span-5 flex flex-col items-start space-y-5 lg:pr-8 lg:border-r lg:border-slate-100">
                    <a href="/" class="block">
                        <!-- Замініть на свій логотип, додано заглушку тексту з картинки -->
                        <div class="flex items-center gap-2 font-bold text-xl text-[#0f2d5a] tracking-wide uppercase">
                            <img src="assets/images/logo.svg" alt="Cortics" class="h-6 error-fallback:hidden">
                        </div>
                    </a>

                    <p class="text-[12px] leading-[22px] text-[#566985] max-w-md font-medium">
                        A premium tech publication dedicated to delivering fresh tech
                        perspectives, startup ecosystem deep-dives, and honest gadget
                        reviews to a global audience of forward-thinkers.
                    </p>

                    <a href="#" class="inline-block bg-[#0f2d5a] hover:bg-opacity-90 text-white text-xs font-semibold px-6 py-3 rounded-md transition-colors">
                        Read more
                    </a>
                </div>

                <!-- Категорії (Колонка 2) -->
                <div class="lg:col-span-4 lg:px-6">
                    <h3 class="text-[17px] font-semibold text-[#122d5a] mb-5 pb-2  border-b border-slate-100">
                        Categories
                    </h3>

                    <!-- Двоколонковий список за макетом -->
                    <ul class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm text-slate-600">
                        <li class="flex items-center gap-2 hover:text-[#0f2d5a] transition-colors">
                            <i class="fa-light fa-angle-right text-xs text-blue-500"></i>
                            <a href="#">AI</a>
                        </li>
                        <li class="flex items-center gap-2 hover:text-[#0f2d5a] transition-colors">
                            <i class="fa-light fa-angle-right text-xs text-blue-500"></i>
                            <a href="#">Gadgets</a>
                        </li>
                        <li class="flex items-center gap-2 hover:text-[#0f2d5a] transition-colors">
                            <i class="fa-light fa-angle-right text-xs text-blue-500"></i>
                            <a href="#">Gaming</a>
                        </li>
                        <li class="flex items-center gap-2 hover:text-[#0f2d5a] transition-colors">
                            <i class="fa-light fa-angle-right text-xs text-blue-500"></i>
                            <a href="#">Health</a>
                        </li>
                        <li class="flex items-center gap-2 hover:text-[#0f2d5a] transition-colors">
                            <i class="fa-light fa-angle-right text-xs text-blue-500"></i>
                            <a href="#">Lifestyle</a>
                        </li>
                        <li class="flex items-center gap-2 hover:text-[#0f2d5a] transition-colors">
                            <i class="fa-light fa-angle-right text-xs text-blue-500"></i>
                            <a href="#">Reviews</a>
                        </li>
                        <li class="flex items-center gap-2 hover:text-[#0f2d5a] transition-colors">
                            <i class="fa-light fa-angle-right text-xs text-blue-500"></i>
                            <a href="#">Science</a>
                        </li>
                        <li class="flex items-center gap-2 hover:text-[#0f2d5a] transition-colors">
                            <i class="fa-light fa-angle-right text-xs text-blue-500"></i>
                            <a href="#">Startups</a>
                        </li>
                    </ul>
                </div>

                <!-- Контакти (Колонка 3) -->
                <div class="lg:col-span-3">
                    <h3 class="text-base font-bold text-[#0f2d5a] mb-5 pb-3 border-b border-slate-100">
                        Contacts
                    </h3>

                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="grid grid-cols-[70px_1fr] gap-2">
                            <span class="text-slate-400">Call :</span>
                            <a href="tel:+489756412322" class="hover:text-[#0f2d5a] transition-colors font-medium">
                                +489756412322
                            </a>
                        </li>
                        <li class="grid grid-cols-[70px_1fr] gap-2">
                            <span class="text-slate-400">Write :</span>
                            <a href="mailto:yourmail@domain.com" class="hover:text-[#0f2d5a] transition-colors font-medium break-all">
                                yourmail@domain.com
                            </a>
                        </li>
                        <li class="grid grid-cols-[70px_1fr] gap-2">
                            <span class="text-slate-400">Find us :</span>
                            <span class="font-medium">SA 27TH Brooklyn NY</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Нижня частина всередині картки (Соцмережі, меню та кнопка "To Top") -->
            <div class="flex flex-col sm:flex-row items-center justify-between pt-6 gap-6">
                
                <!-- Соцмережі -->
            <ul class="flex items-center gap-3">
                <li>
                    <a href="#" class="w-9 h-9 flex items-center justify-center bg-slate-50 border border-slate-100 text-slate-500 rounded-lg hover:bg-slate-100 hover:text-[#0f2d5a] transition-all" aria-label="Facebook">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12z"/>
                        </svg>
                    </a>
                </li>
                
                <li>
                    <a href="#" class="w-9 h-9 flex items-center justify-center bg-slate-50 border border-slate-100 text-slate-500 rounded-lg hover:bg-slate-100 hover:text-[#0f2d5a] transition-all" aria-label="X (Twitter)">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                </li>
                
                <li>
                    <a href="#" class="w-9 h-9 flex items-center justify-center bg-slate-50 border border-slate-100 text-slate-500 rounded-lg hover:bg-slate-100 hover:text-[#0f2d5a] transition-all" aria-label="Instagram">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>
                </li>
                
                <li>
                    <a href="#" class="w-9 h-9 flex items-center justify-center bg-slate-50 border border-slate-100 text-slate-500 rounded-lg hover:bg-slate-100 hover:text-[#0f2d5a] transition-all" aria-label="TikTok">
                        <svg fill="currentColor" class="h-4 w-4" viewBox="0 0 448 512"><path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"></path></svg>
                    </a>
                </li>
            </ul>

                <!-- Декоративний індикатор по центру (як на скріншоті) -->
                <div class="hidden md:block w-8 h-1.5 bg-blue-600 rounded-full bg-opacity-80"></div>

                <!-- Меню та Кнопка вгору -->
                <div class="flex items-center gap-6">
                    <ul class="flex items-center gap-4 text-[12px] leading-[36px] font-semibold text-slate-500">
                        <li><a href="#" class="hover:text-[#0f2d5a] transition-colors">Terms</a></li>
                        <li><a href="#" class="hover:text-[#0f2d5a] transition-colors">Cookie Policy</a></li>
                    </ul>

                    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="group flex items-center gap-2 border border-slate-100 bg-slate-50 hover:bg-slate-100 px-4 py-2 rounded-lg transition-colors">
                        <span class="text-xs font-semibold text-slate-600">To Top</span>
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            viewBox="0 0 24 24" 
                            width="14" 
                            height="14" 
                            fill="none"
                            class="transform transition-transform duration-200 group-hover:-translate-y-1"
                        >
                            <path d="M18 15L12 9L6 15" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>

            </div>

        </div>

        <!-- Копірайт під білою карткою -->
        <div class="mt-6 text-center text-xs text-slate-400">
            <p>
                © <span class="text-blue-500 font-medium">Cortics 2026</span> All rights reserved | Powered by WordPress.
            </p>
        </div>

    </div>
</footer>

</div>
<?php wp_footer(); ?>
</body>
</html>