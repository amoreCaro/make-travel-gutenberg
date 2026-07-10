<?php
if (!defined('ABSPATH')) exit;

$post_id = get_the_ID();
$placeholder = get_template_directory_uri() . '/assets/src/images/placeholder.png';
$thumbnail = get_the_post_thumbnail_url($post_id, 'large');

if (!$thumbnail) {
    $thumbnail = $placeholder;
}

/**
 * CATEGORY
 */
$categories = get_the_category($post_id);

$category_id   = !empty($categories) ? $categories[0]->term_id : null;
$category_name = !empty($categories) ? $categories[0]->name : '';

$category_bg_color   = $category_id ? carbon_get_term_meta($category_id, 'category_bg') : '';
$category_text_color = $category_id ? carbon_get_term_meta($category_id, 'category_text_color') : '';
$category_svg_id     = $category_id ? carbon_get_term_meta($category_id, 'category_svg') : '';

$icon_url = $category_svg_id ? wp_get_attachment_url($category_svg_id) : '';
$category_svg = $icon_url ? cf_get_inline_svg($icon_url) : '';

$has_custom_style = !empty($category_bg_color) || !empty($category_text_color);

/**
 * POST DATA
 */
$permalink = get_permalink();
$title     = get_the_title();
$excerpt   = get_the_excerpt();
$date      = get_the_date('M d, Y');

$author_id  = $post->post_author;
$avatar_url = get_avatar_url($author_id, ['size' => 28]);
$username   = get_the_author_meta('display_name', $author_id);

$read_time = estimate_post_read_time($post_id);
$like      = get_post_like_state($post_id);
$is_saved  = get_post_save_state($post_id);
$comments_num = get_comments_number(get_the_ID());

$card_class = 'post-card'
    . ($has_gallery ? ' post-card--slider' : '')
    . ($has_video   ? ' post-card--video'  : '')
    . ($has_thumb   ? ' post-card--thumb'  : '');
?>

<div class="<?php echo esc_attr($card_class); ?> flex flex-row justify-start items-start gap-6 pb-10 border-b border-gray-100 dark:border-neutral-800 last:border-0">

    <!-- THUMBNAIL -->
    <?php if ($thumbnail) : ?>
        <div class="w-[96px] h-[96px] md:w-[176px] md:h-[176px] lg:w-[224px] lg:h-[224px] shrink-0 overflow-hidden rounded-2xl">
            <a href="<?php echo esc_url($permalink); ?>" class="block w-full h-full">
                <picture class="block w-full h-full">
                    <img
                        data-src="<?php echo esc_url($thumbnail); ?>"
                        src="<?php echo esc_url($thumbnail); ?>"
                        alt="<?php echo esc_attr($title); ?>"
                        loading="lazy"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                    >
                </picture>
            </a>
        </div>
    <?php endif; ?>

    <div class="flex-1 min-w-0  space-y-3">

        <!-- Categories -->
        <?php if (!empty($category_name)) : ?>
            <span class="inline-flex items-center gap-2 text-[12px] leading-[16px] font-medium capitalize px-5 py-1 rounded-full w-fit"
                style="
                    background-color: <?php echo esc_attr($category_bg_color); ?>;
                    color: <?php echo esc_attr($category_text_color); ?>;
                "
            >
                <?php if (!empty($category_svg)) : ?>
                    <span class="w-4 h-4 flex items-center justify-center [&>svg]:w-full [&>svg]:h-full [&>svg]:fill-current [&>svg]:stroke-current">
                        <?php echo $category_svg; ?>
                    </span>
                <?php endif; ?>

                <?php echo esc_html($category_name); ?>
            </span>
        <?php endif; ?>
        <!-- Title -->
        <?php if (!empty($title)) : ?>
            <h2 class="text-[18px] leading-[28px] font-semibold text-[#111827] hover:text-[#312e81] dark:text-[#F3F4F6] dark:hover:text-[#A5B4FC]  transition">
                <a href="<?php echo esc_url($permalink); ?>" class="line-clamp-1">
                    <?php echo esc_html($title); ?>
                </a>
            </h2>
        <?php endif; ?>

        <!-- Excerpt -->
        <?php if (!empty($excerpt)) : ?>
            <p class="text-[14px] leading-[20px] font-normal text-[#6b7280] line-clamp-2">
                <?php echo esc_html($excerpt); ?>
            </p>
        <?php endif; ?>

        <!-- Meta -->
        <div class="flex items-center gap-2 pt-2 text-sm text-gray-400">

            <div class="flex items-center gap-2">
                <?php if ($avatar_url) : ?>
                    <div class="post__author-name-img mr-2 flex-shrink-0">
                        <img
                            src="<?php echo esc_url($avatar_url); ?>"
                            alt="<?php echo esc_attr($username); ?>"
                            width="28"
                            height="28"
                            loading="lazy"
                            decoding="async"
                            class="w-[28px] h-[28px] rounded-full object-cover bg-[#f5f5f5]"
                        >
                    </div>
                <?php endif; ?>
                
                <?php if ($username) : ?>
                <span class="text-xs sm:text-sm text-gray-700 dark:text-[#F3F4F6]">
                    <?php echo esc_html($username); ?>
                </span>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($date)) : ?>
            <span>•</span>
            <time class="text-xs sm:text-sm">
                <?php echo esc_html($date); ?>
            </time>
            <?php endif; ?>
        </div>

        <!-- ACTIONS -->

        <div class="flex justify-between items-center relative z-10 w-full pt-3">

            <div class="flex items-center gap-4">
                <button
                    class="post__like group/btn relative h-9 pe-3 shrink-0 rounded-full flex items-center gap-2 select-none transition-colors duration-200
                    <?php echo ($like['liked'] ?? false) ? 'is-active' : ''; ?>"
                    data-post-id="<?php echo esc_attr($post_id); ?>"
                >
                    <div class="post__like-bg w-[36px] h-9 rounded-full flex items-center justify-center pointer-events-none
                        bg-[#F6F5F8] dark:bg-[#1E1E26]
                        text-black dark:text-white
                        transition-colors duration-200
                        
                        group-hover/btn:bg-[#FFF1F2]
                        dark:group-hover/btn:bg-[#2A2A36]
                        group-hover/btn:text-[#FF2157]
                        
                        group-[.is-active]/btn:bg-[#FFF1F2]
                        dark:group-[.is-active]/btn:bg-[#2A2A36]
                        group-[.is-active]/btn:text-[#FF2157]">

                        <svg class="h-[18px] w-[18px] text-current transition-colors duration-200 group-[.is-active]/btn:hidden"
                            viewBox="0 0 24 24" fill="none">
                            <path d="M19.4626 3.99415C16.7809 2.34923 14.4404 3.01211 13.0344 4.06801C12.4578 4.50096 12.1696 4.71743 12 4.71743C11.8304 4.71743 11.5422 4.50096 10.9656 4.06801C9.55962 3.01211 7.21909 2.34923 4.53744 3.99415C1.01807 6.15294 0.221721 13.2749 8.33953 19.2834C9.88572 20.4278 10.6588 21 12 21C13.3412 21 14.1143 20.4278 15.6605 19.2834C23.7783 13.2749 22.9819 6.15294 19.4626 3.99415Z"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>

                        <svg class="hidden h-[18px] w-[18px] text-current transition-colors duration-200 group-[.is-active]/btn:block"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.4626 3.99415C16.7809 2.34923 14.4404 3.01211 13.0344 4.06801C12.4578 4.50096 12.1696 4.71743 12 4.71743C11.8304 4.71743 11.5422 4.50096 10.9656 4.06801C9.55962 3.01211 7.21909 2.34923 4.53744 3.99415C1.01807 6.15294 0.221721 13.2749 8.33953 19.2834C9.88572 20.4278 10.6588 21 12 21C13.3412 21 14.1143 20.4278 15.6605 19.2834C23.7783 13.2749 22.9819 6.15294 19.4626 3.99415Z"/>
                        </svg>
                    </div>

                    <span class="post__like-text text-[12px] leading-[12px]
                        text-black dark:text-white
                        group-hover/btn:text-[#FF2157]
                        group-[.is-active]/btn:text-[#FF2157]
                        font-medium transition-colors duration-200">
                            <?php echo (int) $like['count']; ?>
                    </span>
                </button>


                                <button
                    class="group/comment relative h-9 pe-3 shrink-0 rounded-full transition-colors duration-200 cursor-default flex items-center gap-2 bg-transparent select-none"
                    onclick="
                        event.preventDefault();
                        event.stopPropagation();
                        
                        const isActive = this.classList.toggle('is-active');
                        const bgCircle = this.querySelector('.icon-bg-circle');
                        const countText = this.querySelector('.count-text');
                        const iconSvg = this.querySelector('.icon-comment-svg');
                        
                        if (isActive) {
                            bgCircle.classList.remove('bg-[#F6F5F8]', 'dark:bg-[#1E1E26]', 'group-hover/comment:bg-[#E6F4F3]', 'dark:group-hover/comment:bg-[#2A2A36]');
                            bgCircle.classList.add('bg-[#E6F4F3]', 'dark:bg-[#2A2A36]');
                            iconSvg.classList.remove('text-black', 'dark:text-white', 'group-hover/comment:text-[#009689]');
                            iconSvg.classList.add('text-[#009689]');

                            countText.classList.remove('text-black', 'dark:text-white', 'group-hover/comment:text-[#009689]');
                            countText.classList.add('text-[#009689]');
                            window.location.href = '<?php echo esc_url(get_permalink($post_id) . '#comments'); ?>';
                        } else {
                            bgCircle.classList.add('bg-[#F6F5F8]', 'dark:bg-[#1E1E26]', 'group-hover/comment:bg-[#E6F4F3]', 'dark:group-hover/comment:bg-[#2A2A36]');
                            bgCircle.classList.remove('bg-[#E6F4F3]', 'dark:bg-[#2A2A36]');
                            
                            iconSvg.classList.add('text-black', 'dark:text-white', 'group-hover/comment:text-[#009689]');
                            iconSvg.classList.remove('text-[#009689]');
                            
                            countText.classList.add('text-black', 'dark:text-white', 'group-hover/comment:text-[#009689]');
                            countText.classList.remove('text-[#009689]');
                        }
                    "
                >
                    <div class="icon-bg-circle w-[36px] h-9 rounded-full bg-[#F6F5F8] dark:bg-[#1E1E26] group-hover/comment:bg-[#E6F4F3] dark:group-hover/comment:bg-[#2A2A36] transition-colors duration-200 flex items-center justify-center pointer-events-none">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            viewBox="0 0 24 24" 
                            fill="none" 
                            class="icon-comment-svg h-[18px] w-[18px] text-black dark:text-white group-hover/comment:text-[#009689] transition-colors duration-200">
                            <path d="M8 13.5H16M8 8.5H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6.09881 19C4.7987 18.8721 3.82475 18.4816 3.17157 17.8284C2 16.6569 2 14.7712 2 11V10.5C2 6.72876 2 4.84315 3.17157 3.67157C4.34315 2.5 6.22876 2.5 10 2.5H14C17.7712 2.5 19.6569 2.5 20.8284 3.67157C22 4.84315 22 6.72876 22 10.5V11C22 14.7712 22 16.6569 20.8284 17.8284C19.6569 19 17.7712 19 14 19C13.4395 19.0125 12.9931 19.0551 12.5546 19.155C11.3562 19.4309 10.2465 20.0441 9.14987 20.5789C7.58729 21.3408 6.806 21.7218 6.31569 21.3651C5.37769 20.6665 6.29454 18.5019 6.5 17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <span class="count-text text-[12px] leading-[12px] text-black dark:text-white group-hover/comment:text-[#009689] font-medium transition-colors duration-200 pointer-events-none">
                        <?php echo esc_html($comments_num); ?>
                    </span>
                </button>
            </div>

            <div class="flex items-center gap-2 relative">
                <span class="text-[12px] leading-[16px] text-black dark:text-[#D1D5DB] font-normal">
                    <?php echo esc_html($read_time); ?> min read
                </span>
                <button
                    class="post__save <?php echo $is_saved ? 'is-active' : '' ?> group/btn relative w-9 h-9 shrink-0 rounded-full transition-colors duration-200 cursor-default flex items-center justify-center bg-transparent select-none"
                    data-post-id="<?php echo esc_attr($post_id); ?>"
                >
                    <div class="icon-bg-circle w-9 h-9 rounded-full transition-colors duration-200 flex items-center justify-center pointer-events-none
                        bg-[#F9FAFB] dark:bg-[#2A2A36]
                        group-hover/btn:bg-[#F3F4F6]
                        dark:group-hover/btn:bg-[#3F3F50]
                        
                        group-[.is-active]/btn:bg-[#F3F4F6]
                        dark:group-[.is-active]/btn:bg-[#3F3F50]">

                        <!-- OUTLINE ICON -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="icon-outline h-[18px] w-[18px] text-black dark:text-white transition-colors duration-200
                                group-[.is-active]/btn:hidden"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M6 3h12a1 1 0 0 1 1 1v18l-7-4-7 4V4a1 1 0 0 1 1-1z"/>
                        </svg>

                        <!-- FILLED ICON -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="icon-filled hidden h-[18px] w-[18px] text-[#374151] dark:text-[#E5E7EB] transition-colors duration-200
                                group-[.is-active]/btn:block"
                            fill="currentColor"
                        >
                            <path d="M6 3h12a1 1 0 0 1 1 1v18l-7-4-7 4V4a1 1 0 0 1 1-1z"/>
                        </svg>

                    </div>
                </button>
            </div>

        </div>

    </div>

</div>