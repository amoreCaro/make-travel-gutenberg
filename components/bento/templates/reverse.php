<?php
if (!defined('ABSPATH')) {
    exit;
}

$posts_in_cat = $posts_in_cat ?? [];

?>

<section class="bento-grid mx-auto bg-[#F6F5F8] dark:bg-[#0B0B0D] lg:py-[100px] py-[50px] px-5 xl:px-10 2xl:px-0">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-12 container">

        <div class="flex items-center gap-2 md:gap-4">

            <?php if (!empty($category_name)) : ?>
                <h2 class="text-black dark:text-white/90 text-2xl sm:text-3xl md:text-[40px] lg:text-[48px] xl:text-[56px] font-semibold tracking-tight leading-tight first-letter:uppercase">
                    <?php echo esc_html($category_name); ?>
                </h2>
            <?php endif; ?>
            <?php if ($category_svg) : ?>
                <div class="decor <?php echo esc_attr($category_decor_type); ?> -translate-y-1/2 w-8 h-8 md:w-14 md:h-14 flex items-center justify-center rounded-t-full rounded-br-full p-1.5 md:p-2 bg-white/90 dark:bg-white/10 text-black dark:text-white backdrop-blur-md border border-black/5 dark:border-white/10 shadow-sm dark:shadow-none [&_svg]:w-4 [&_svg]:h-4 md:[&_svg]:w-6 md:[&_svg]:h-6"
                    style="
                        <?php echo $category_bg_color ? 'background-color:' . esc_attr($category_bg_color) . ';' : ''; ?>
                        <?php echo $category_text_color ? 'color:' . esc_attr($category_text_color) . ';' : ''; ?>
                    ">
                    <?php echo $category_svg; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>

    <div class="space-y-8 md:space-y-12 container">

        <!-- TOP GRID -->
        <div class="reverse grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-10">

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