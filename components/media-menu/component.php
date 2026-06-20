<?php

if (!defined('ABSPATH')) {
    exit;
}

function render_media_menu_universal() {

    /**
     * Get all categories
     */
    $categories = get_terms([
        'taxonomy'   => 'category',
        'hide_empty' => true,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ]);

    /**
     * Get all tags
     */
    $tags = get_terms([
        'taxonomy'   => 'post_tag',
        'hide_empty' => true,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ]);

    /**
     * Current object
     */
    $current = get_queried_object();

    $current_category_id = null;
    $current_tag_id = null;

    if ($current instanceof WP_Term) {

        if ($current->taxonomy === 'category') {
            $current_category_id = $current->term_id;
        }

        if ($current->taxonomy === 'post_tag') {
            $current_tag_id = $current->term_id;
        }
    }

    /**
     * Blog detection
     */
    $blog_page = get_page_by_path('blog');
    $is_blog = is_page('blog');

    $blog_url = $blog_page
        ? get_permalink($blog_page->ID)
        : home_url('/blog/');

    ?>

    <div class="media-menu absolute w-full top-[80px] z-50 bg-[#F6F5F8] dark:bg-[#0B0B0D] flex flex-col py-2">

        <div class="container w-full mx-auto px-5 xl:px-0">

            <!-- HEADER -->
            <div class="media-menu__head flex items-center justify-between">

                <!-- Mobile categories button -->
                <?php if (!empty($categories)) : ?>
                <button class="media-menu__categories-btn flex items-center gap-2 md:hidden py-3 text-slate-400 hover:text-blue-600">

                    <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" class="fill-current">
                        <rect width="7" height="7" rx="1"></rect>
                        <rect x="11" width="7" height="7" rx="1"></rect>
                        <rect y="11" width="7" height="7" rx="1"></rect>
                        <rect x="11" y="11" width="7" height="7" rx="1"></rect>
                    </svg>

                    <span class="font-bold uppercase text-[15px] leading-[15px]">
                        <?php _e("Category", THEME); ?>
                    </span>

                </button>
                <?php endif; ?>

                <!-- Desktop categories menu -->
                <div class="media-menu__categories-content hidden md:block overflow-x-auto no-scrollbar">
                    <ul class="flex items-center gap-8 whitespace-nowrap">

                        <?php
                        $all_news_active = $is_blog ? 'active' : '';
                        ?>

                        <li>
                            <a href="<?php echo esc_url($blog_url); ?>"
                               class="media-menu__tab <?php echo esc_attr($all_news_active); ?> uppercase block py-3 text-[15px] leading-[18px] font-bold hover:text-black dark:hover:text-white">
                                <?php _e("All news", THEME); ?>
                            </a>
                        </li>

                        <?php if (!empty($categories)) : ?>
                            <?php foreach ($categories as $category) : ?>

                                <?php
                                $is_active = ($current_category_id === $category->term_id) ? 'active' : '';
                                ?>

                                <li>
                                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                       class="media-menu__tab <?php echo esc_attr($is_active); ?> uppercase block py-3 text-[15px] leading-[18px] font-bold hover:text-black dark:hover:text-white">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                </li>

                            <?php endforeach; ?>
                        <?php endif; ?>

                    </ul>
                </div>

                <!-- Tags button -->
                <?php if (!empty($tags)) : ?>
                <button class="media-menu__tags-btn cursor-pointer flex items-center gap-2 uppercase font-bold text-[15px] leading-[15px] transition-all duration-300 text-slate-400 hover:text-blue-600">

                    <?php _e("All tags", THEME); ?>

                    <svg class="transition-transform duration-300 transform group-hover:stroke-blue-600"
                         xmlns="http://www.w3.org/2000/svg"
                         width="18"
                         height="18"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="3"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M6 9l6 6 6-6"></path>
                    </svg>

                </button>
                <?php endif; ?>

            </div>

            <!-- Mobile navigation -->
            <div class="media-menu__navigation transition-all duration-500 max-h-0 opacity-0 mobile">

                <ul class="flex flex-col sm:flex-row items-start sm:items-center justify-start sm:justify-between w-full whitespace-nowrap">

                    <?php
                    $all_news_mobile_active = (is_home() || is_page('blog')) ? 'active' : '';
                    ?>

                    <li class="flex-1 text-left">
                        <a href="<?php echo esc_url($blog_url); ?>"
                           class="media-menu__tab <?php echo esc_attr($all_news_mobile_active); ?> uppercase py-3 text-[15px] leading-[18px] font-bold inline-block relative hover:text-black dark:hover:text-white">
                            <?php _e("All News", THEME); ?>
                        </a>
                    </li>

                    <?php if (!empty($categories)) : ?>
                        <?php foreach ($categories as $category) : ?>

                            <?php
                            $is_active_mobile = ($current_category_id === $category->term_id) ? 'active' : '';
                            ?>

                            <li class="flex-1 text-left">
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                   class="media-menu__tab <?php echo esc_attr($is_active_mobile); ?> uppercase py-3 text-[15px] leading-[18px] font-bold inline-block relative hover:text-black dark:hover:text-white">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            </li>

                        <?php endforeach; ?>
                    <?php endif; ?>

                </ul>

            </div>

            <!-- Tags -->
            <?php if (!empty($tags)) : ?>
            <div class="media-menu__tags overflow-hidden transition-all duration-500 max-h-0 opacity-0">

                <ul class="media-menu__tags-list grid grid-cols-1 md:grid-cols-3 gap-y-4 py-8">

                    <?php foreach ($tags as $tag) : ?>

                        <?php
                        $active_tag = ($current_tag_id === $tag->term_id) ? 'active' : '';
                        ?>

                        <li>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                               class="media-menu__tag uppercase text-[15px] leading-[18px] font-bold text-[#9395ab] hover:text-[#252735] dark:hover:text-white transition-all duration-300 cursor-pointer <?php echo esc_attr($active_tag); ?>">
                                #<?php echo esc_html($tag->name); ?>
                            </a>
                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>
            <?php endif; ?>

        </div>
    </div>

    <?php
}