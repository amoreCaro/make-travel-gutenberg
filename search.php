<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$search = get_query_var('original_search') ?: get_search_query();

get_header();
?>
<main class="search-page bg-[#F6F5F8] dark:bg-[#0B0B0D] dark:bg-gradient-to-b dark:from-[#0B0B0D] dark:to-[#111114]">
    <div class="lg:pt-[46px] pt-[92px]">
        <section class="bento-grid mx-auto py-[50px] px-5 xl:px-10 2xl:px-0">
            <div class="container mb-10">
                <h1 class="text-black dark:text-white text-[32px] md:text-[40px] font-semibold">
                    <?php _e("Results for:", THEME); ?>
                    <?php echo esc_html($search); ?>
                </h1>
            </div>

            <div class="space-y-8 md:space-y-12 container">

<?php if (have_posts()) : ?>

    <?php $i = 0; ?>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-10 lg:items-stretch">

        <?php while (have_posts()) : the_post(); ?>

            <?php

            $post_categories = get_the_category();
            $category_obj    = !empty($post_categories) ? $post_categories[0] : null;

            $category_svg        = '';
            $category_bg_color   = '';
            $category_text_color = '';
            $category_decor_type = '';

            if ($category_obj) {
                $category_id = $category_obj->term_id;

                $icon_url     = carbon_get_term_meta($category_id, 'category_svg');
                $category_svg = cf_get_inline_svg($icon_url);

                $category_bg_color   = carbon_get_term_meta($category_id, 'category_bg');
                $category_text_color = carbon_get_term_meta($category_id, 'category_text_color');
                $category_decor_type = carbon_get_term_meta($category_id, 'category_decor_type');
            }
            ?>

            <?php include PATH . '/components/bento/elements/default-item.php'; ?>

            <?php $i++; ?>

        <?php endwhile; ?>

    </div>

                <?php else : ?>

                    <div class="relative flex min-h-[500px] w-full flex-col items-center justify-center overflow-hidden  px-4 py-16 text-center transition-colors duration-300">
                    
                    <div class="absolute inset-0 z-0 opacity-30 dark:opacity-10">
                        <div class="absolute left-1/2 top-1/2 h-[400px] w-[400px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-blue-400/20 blur-[100px]"></div>
                    </div>

                    <div class="relative z-10 mb-8 flex h-20 w-20 items-center justify-center rounded-2xl border border-black/5 bg-white/90 shadow-sm backdrop-blur-md dark:border-white/10 dark:bg-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10 text-black dark:text-white/90">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6" />
                        </svg>
                        
                        <span class="absolute -right-1 -top-1 flex h-4 w-4">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-40"></span>
                        <span class="relative inline-flex h-4 w-4 rounded-full border-2 border-[#F6F5F8] bg-blue-500 dark:border-[#0B0B0D]"></span>
                        </span>
                    </div>

                    <div class="relative z-10 max-w-md">
                        <h2 class="text-3xl font-semibold tracking-tight text-black dark:text-white/90 sm:text-4xl">
                         <?php _e("Horizon is Empty", THEME); ?>
                        </h2>
                        <p class="mt-4 text-base leading-relaxed text-black/60 dark:text-white/50">
                            <?php _e("We've combed through every corner of our archives, but found nothing. Maybe try different filters or check your spelling?", THEME); ?>
                        </p>
                    </div>

                    <div class="relative z-10 mt-10 flex flex-col items-center gap-4 sm:flex-row">
                        
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="group inline-flex h-11 items-center justify-center gap-2 rounded-full border-2 border-black bg-transparent px-8 text-sm font-semibold text-black transition-all hover:bg-black hover:text-white active:scale-95 dark:border-white/20 dark:text-white dark:hover:bg-white dark:hover:text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4 transition-transform duration-300 group-hover:-translate-x-1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                        </svg>
                        <?php _e("Go Back", THEME); ?>
                        </a>

                    </div>
                    </div>
                <?php endif; ?>

            </div>

        </section>

        <?php 
            require PATH . "/components/pagination/component.php";
            require PATH . "/components/burger-menu/component.php";
            require PATH . "/components/modal/component.php"; 
        ?>
        
    </div>
</main>

<?php get_footer(); ?>		