<?php
if (!defined('ABSPATH')) {
    exit;
}

$posts_in_cat = $posts_in_cat ?? [];

?>

<section class="bento-grid mx-auto bg-[#F6F5F8] dark:bg-[#0B0B0D] lg:py-[100px] py-[50px] px-5 xl:px-10 2xl:px-0">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-12 container">

        <div class="flex items-center gap-4">

            <?php if (!empty($category_name)) : ?>
                <h2 class="text-black dark:text-white/90 text-[32px] md:text-[40px] lg:text-[48px] xl:text-[56px] font-semibold tracking-tight leading-tight first-letter:uppercase">
                    <?php echo esc_html($category_name); ?>
                </h2>
            <?php endif; ?>
            <?php if ($category_svg) : ?>
                <div class="decor <?php echo esc_attr($category_decor_type); ?> -translate-y-1/2 w-14 h-14 flex items-center justify-center rounded-t-full rounded-br-full p-2 bg-white/90 dark:bg-white/10 text-black dark:text-white backdrop-blur-md border border-black/5 dark:border-white/10 shadow-sm dark:shadow-none"
                    style="
                        <?php echo $category_bg_color ? 'background-color:' . esc_attr($category_bg_color) . ';' : ''; ?>
                        <?php echo $category_text_color ? 'color:' . esc_attr($category_text_color) . ';' : ''; ?>
                    ">
                    <?php echo $category_svg; ?>
                </div>
            <?php endif; ?>

        </div>

        <?php if (!empty($bento_button) && !empty($category_link)) : ?>

            <a
                href="<?php echo esc_url($category_link); ?>"
                class="group flex items-center justify-center gap-1.5
                text-xs px-4 py-2
                md:text-base md:px-9 md:py-3 md:gap-2
                text-black dark:text-white
                border-2 border-black dark:border-white/20
                font-semibold rounded-full
                transition-all duration-300
                hover:bg-black hover:text-white
                dark:hover:bg-white dark:hover:text-black"
            >

                <?php echo esc_html($bento_button); ?>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                    class="w-3.5 h-3.5 md:w-5 md:h-5 transition-transform duration-300 group-hover:translate-x-1.5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"
                    />
                </svg>

            </a>

        <?php endif; ?>

    </div>

    <div class="space-y-8 md:space-y-12 container">

        <!-- TOP GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-10">

            <?php foreach ($posts_in_cat as $index => $post) : ?>

                <?php
                setup_postdata($post);

                switch ($index) {

                    case 0:
                        $item_index = 0;

                        include PATH . '/components/bento/elements/large-item.php';
                        break;

                    case 1:
                        $item_index = 1;

                        include PATH . '/components/bento/elements/default-item.php';
                        break;
                }
                ?>

            <?php endforeach; ?>

        </div>

        <!-- BOTTOM GRID -->
        <?php if (count($posts_in_cat) > 2) : ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-10">

                <?php foreach ($posts_in_cat as $post_index => $post) : ?>

                    <?php
                    if ($post_index < 2) {
                        continue;
                    }

                    setup_postdata($post);

                    $item_index = $post_index;

                    include PATH . '/components/bento/elements/default-item.php';
                    ?>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>

<?php wp_reset_postdata(); ?>