<?php
if (!defined('ABSPATH')) exit;

global $wp_query;

$category_obj = $wp_query->get_queried_object();

$category_id   = $category_obj->term_id;
$category_name = $category_obj->name;
$category_link = get_term_link($category_obj);

/**
 * Term meta (decor)
 */
$icon_url            = carbon_get_term_meta($category_id, 'category_svg');
$category_svg        = cf_get_inline_svg($icon_url);

$category_bg_color   = carbon_get_term_meta($category_id, 'category_bg');
$category_text_color = carbon_get_term_meta($category_id, 'category_text_color');
$category_decor_type = carbon_get_term_meta($category_id, 'category_decor_type');

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$posts_in_cat = $wp_query->posts;
$total_posts = count($posts_in_cat);

get_header(); 
?>

<main class="main">
    <div class="archive-page">

        <div class="lg:pt-[46px] pt-[92px] lg:pb-[100px] pb-[50px] bg-white dark:bg-black">
        <?php 

        ?>
        <?php if ( ! empty ( $posts_in_cat ) ) : ?>

            <section class="bento-grid mx-auto bg-[#F6F5F8] dark:bg-[#0B0B0D] dark:bg-gradient-to-b dark:from-[#0B0B0D] dark:to-[#111114] lg:py-[80px] py-[50px] px-5 xl:px-10 2xl:px-0">

                <!-- HEADER -->
                <?php if (!empty($category_name)) : ?>
                    <div class="flex items-center mb-12 justify-between container">

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

                    </div>
                <?php endif; ?>

                <div class="space-y-8 md:space-y-12 container">

                    <?php for ($i = 0; $i < $total_posts; $i += 6) :
                        $block_posts = array_slice($posts_in_cat, $i, 6);
                    ?>

                        <!-- 1st row -->
                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-10">
                            <?php foreach ($block_posts as $index => $post) :
                                setup_postdata($post);

                                if ($index > 1) continue;

                                if ($index === 0) {
                                    include PATH . '/components/bento/elements/large-item.php';
                                } else {
                                    include PATH . '/components/bento/elements/default-item.php';
                                }

                            endforeach; ?>
                        </div>

                        <!-- 2nd row -->
                        <?php if (count($block_posts) > 2) : ?>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-10 mt-6">
                                <?php foreach ($block_posts as $index => $post) :
                                    if ($index < 2) continue;

                                    setup_postdata($post);
                                    include PATH . '/components/bento/elements/default-item.php';

                                endforeach; ?>
                            </div>
                        <?php endif; ?>

                    <?php endfor; ?>

                </div>

            </section>

            <?php wp_reset_postdata(); 
            
            endif; ?>

        <?php 
            include_once( PATH . "/components/pagination/component.php" );
        ?>
        </div>
    </div>
    <?php 
        include_once( PATH . "/components/burger-menu/component.php" );
    ?>
</main>

<?php get_footer(); ?>