<?php
if (!defined('ABSPATH')) {
    exit;
}

$logo_type   = carbon_get_theme_option('footer_logo_type');
$logo_text   = carbon_get_theme_option('logo_text');
$logo_img_id = carbon_get_theme_option('footer_logo_image');

$disclaimer = wp_kses_post(carbon_get_theme_option('footer_disclaimer')) ?: "A premium tech publication dedicated to delivering fresh tech perspectives, startup ecosystem deep-dives, and honest gadget reviews to a global audience of forward-thinkers.";

$categories_title = carbon_get_theme_option("categories_title");
$categories = carbon_get_theme_option('footer_categories');

$locations_title = carbon_get_theme_option('locations_title');
$footer_locations = carbon_get_theme_option('footer_locations');

$social_icons = carbon_get_theme_option('social_icons');

$nav_menu   = get_nav_menu_locations();
$menu_items = [];

if (isset($nav_menu['footer_menu'])) {
    $menu_id    = $nav_menu['footer_menu'];
    $menu_items = wp_get_nav_menu_items($menu_id);
}

$company_name = carbon_get_theme_option('footer_company_name');
$rights_text  = carbon_get_theme_option('footer_rights_text');
$powered_by   = carbon_get_theme_option('footer_powered_by_text');

?>

<footer class="w-full bg-[#f4f7fa] dark:bg-black py-12 px-0 md:px-4 font-sans text-[#1e293b] dark:text-zinc-100">
    <div class="container mx-auto">
        
        <!-- Головна чорна картка футера в dark mode -->
        <div class="bg-[#f4f7fa] dark:bg-black md:bg-white md:dark:bg-[#09090b] rounded-2xl shadow-sm py-30 px-5 md:p-[60px_50px_20px]">
            
            <!-- Верхня частина: 3 колонки -->
            <div class="grid grid-cols-1 lg:grid-cols-3  gap-5 md:gap-8 pb-5">
                
                <!-- Про компанію (Колонка 1) -->
                <div class="md:col-span-1 flex flex-col items-start lg:pr-8 ">
                    <?php if ($logo_text || $logo_img_id) : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="block mb-[34px]">
                            <div class="flex items-center gap-2 font-bold text-xl text-[#0f2d5a] dark:text-white tracking-wide uppercase">

                                <?php if ($logo_type === 'image' && $logo_img_id) : ?>

                                    <?php echo wp_get_attachment_image(
                                        $logo_img_id,
                                        'full',
                                        false,
                                        [
                                            'alt'   => esc_attr($logo_text),
                                            'class' => 'w-full max-w-[130px] min-w-[130px] h-8 object-cover'
                                        ]
                                    ); ?>

                                <?php elseif ($logo_type === 'text') : ?>

                                    <span><?php echo esc_html($logo_text); ?></span>

                                <?php endif; ?>

                            </div>
                        </a>
                    <?php endif; ?>
                    <?php if ( ! empty( $disclaimer ) ) : ?>
                        <p class="text-[12px] leading-[22px] text-[#566985] dark:text-zinc-400 max-w-md font-medium pb-[10px]">
                            <?php echo esc_html($disclaimer); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Категорії (Колонка 2) -->
                <div class="md:col-span-1 lg:px-6">
                    <?php if ( !empty ( $categories_title ) ) : ?>
                    <h3 class="text-[17px] font-semibold text-[#122d5a] dark:text-zinc-200 mb-5 pb-2">
                        <?php echo esc_html($categories_title); ?>
                    </h3>   
                    <?php endif; ?>

                    <?php if ( !empty( $categories ) ) : ?>
                        <ul class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm text-[#566A85] dark:text-zinc-400">
                                <?php foreach ( $categories as $category ) : ?>
                                    <?php
                                    $term = get_term( $category['id'] );

                                    if (!$term || is_wp_error($term)) {
                                        continue;
                                    }
                                    ?>
                                    <li class="group flex items-center gap-2 hover:text-[#122E5A] dark:hover:text-white transition-colors duration-200">
                                        <svg class="transform transition-transform duration-200 group-hover:translate-x-1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            width="12"
                                            height="12"
                                            fill="none">
                                            <path d="M8.5 5L15.5 12L8.5 19"
                                                stroke="#3277DF"
                                                stroke-width="2.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                        </svg>

                                        <a href="<?php echo esc_url(get_term_link($term)); ?>">
                                            <?php echo esc_html( $term->name ); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                </div>

                <!-- Локації (Колонка 3) -->
                <div class="md:col-span-1 lg:px-6">
                    <?php if ( ! empty( $locations_title ) ) : ?>
                    <h3 class="text-[17px] font-semibold text-[#122d5a] dark:text-zinc-200 mb-5 pb-2">
                        <?php echo esc_html( $locations_title ); ?>
                    </h3>
                    <?php endif; ?>

                    <?php if ( ! empty( $footer_locations ) ) : ?>
                        <ul class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm text-[#566A85] dark:text-zinc-400">
                            <?php foreach ( $footer_locations as $location ) :
                                $term = get_term( $location['id'] );

                                if ( ! $term || is_wp_error( $term ) ) {
                                    continue;
                                }
                            ?>
                                <li class="group flex items-center gap-2 hover:text-[#122E5A] dark:hover:text-white transition-colors duration-200">
                                    <svg class="transform transition-transform duration-200 group-hover:translate-x-1"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        width="12"
                                        height="12"
                                        fill="none">
                                        <path d="M8.5 5L15.5 12L8.5 19"
                                            stroke="#3277DF"
                                            stroke-width="2.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                    </svg>
                                    <a
                                        href="<?php echo esc_url( get_term_link( $term ) ); ?>"
                                        class="text-inherit"
                                    >
                                        <?php echo esc_html( $term->name ); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Нижня частина всередині картки -->
            <div class="flex flex-col sm:flex-row items-left md:items-center justify-between pt-5 gap-5 md:gap-6">
                
                <!-- Соцмережі -->
                <?php require PATH . "/components/socials/component.php"; ?>
                <!-- Декоративний індикатор -->

                <!-- Меню та Кнопка вгору -->
                <div class="flex flex-col-reverse sm:flex-row md:items-center sm:gap-6">
                    <?php if (!empty($menu_items)) : ?>
                        <ul class="flex items-center gap-4 text-[12px] leading-[36px] font-semibold text-slate-500 dark:text-zinc-400 pr-4">
                            <?php foreach ($menu_items as $item) : ?>
                                <li>
                                    <a
                                        href="<?php echo esc_url($item->url); ?>"
                                        class="transition-colors hover:text-zinc-800 dark:hover:text-white"
                                        target="<?php echo esc_attr($item->target ?: '_self'); ?>"
                                    >
                                        <?php echo esc_html($item->title); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <!-- Vertical divider -->


                    <button
                        onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                        class="w-fit group flex items-center gap-2 border border-slate-100 dark:border-zinc-800 bg-slate-50 dark:bg-zinc-900 hover:bg-slate-100 dark:hover:bg-zinc-800 px-4 py-2.5 rounded-lg transition-colors"
                    >
                        <span class="text-xs font-semibold text-slate-600 dark:text-zinc-300">To Top</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" class="transform transition-transform duration-200 group-hover:-translate-y-1">
                            <path d="M18 15L12 9L6 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>

        </div>

        <!-- Копірайт під білою карткою -->


        <div class="mt-6 text-center text-xs text-slate-400 dark:text-zinc-500">
            <p>
                &copy;
                <span class="text-[#0f2d5a] dark:text-zinc-300 font-medium">
                    <?php echo esc_html($company_name); ?> <?php echo date('Y'); ?>
                </span>

                <?php echo esc_html($rights_text); ?>

                <?php if (!empty($powered_by)) : ?>
                    | <?php echo esc_html($powered_by); ?>
                <?php endif; ?>
            </p>
        </div>

    </div>
</footer>

</div>
<?php wp_footer(); ?>
</body>
</html>