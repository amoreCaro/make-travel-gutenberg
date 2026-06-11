<?php
if (!defined('ABSPATH')) {
    exit;
}

$disclaimer = wp_kses_post( carbon_get_theme_option('footer_text') );
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
        <?php if (!empty($footer_items)) : ?>
        <nav class="min-h-[46px] flex items-center">
            <ul class="flex justify-center flex-wrap">
                <?php foreach ($footer_items as $item) : 
                    $text = $item->title ?? '';
                    $url  = $item->url ?? '';

                    if (!$text) continue;
                ?>
                    <li>
                        <a
                            href="<?php echo esc_url($url); ?>"
                            class="text-[14px] leading-[20px] font-medium text-gray-700 dark:text-white px-5 py-3 transition-colors duration-300 hover:text-blue-400 dark:hover:text-blue-400" 
                        >
                            <?php echo esc_html($text); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <?php endif; ?>




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