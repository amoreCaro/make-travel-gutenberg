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

<footer class="footer py-[100px] flex items-center bg-white dark:bg-black justify-center">
    <div class="container mx-auto flex flex-col items-center gap-5 text-center">

        <!-- Disclaimer -->
        <?php if ( !empty($disclaimer) ) : ?> 
            <div class="text-[14px] leading-[28px]  font-normal max-w-[912px] mx-auto text-center text-dark dark:text-white">
                <?php echo $disclaimer; ?>
            </div>
        <?php endif; ?>

        <!-- Footer nav -->
        <?php if (!empty($menu_items)) : ?>
            <nav class="min-h-[46px] flex items-center">
                <ul class="flex justify-center flex-wrap gap-2">
                    <?php foreach ($menu_items as $item) :
                        $is_active = !empty($item->classes) && in_array('current-menu-item', $item->classes, true);
                    ?>
                        <li class="list-none">
                            <a
                                href="<?php echo esc_url($item->url); ?>"
                                class="text-[14px] leading-[20px] font-medium px-5 py-3 transition-colors duration-300
                                    text-gray-700 dark:text-white
                                    hover:text-blue-400 dark:hover:text-blue-400
                                    <?php echo $is_active ? 'text-blue-500 dark:text-blue-400' : ''; ?>"
                            >
                                <?php echo esc_html($item->title); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        <?php endif; ?>

        <?php require PATH . "/components/socials/component.php"; ?>      

        <!-- Copyright -->
        <span class="text-[14px] leading-[28px] text-gray-500 dark:text-[#d5d5d5] font-normal">
            <?php 
                echo esc_html($before_year) . ' ' . $current_year; 
            ?>
            
            <?php if (!empty($link_url)) : ?>
                <?php echo esc_html($pre_text); ?>
                <a href="<?php echo esc_url($link_url); ?>" class="underline hover:text-black dark:hover:text-white transition-colors">
                    <?php echo esc_html($link_text); ?>
                </a>
            <?php endif; ?>

            <?php 
                echo esc_html($post_text); 
            ?> 
        </span>

    </div>
</footer>

</div>
<?php wp_footer(); ?>
</body>
</html>