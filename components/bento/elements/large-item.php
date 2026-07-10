<?php
if (!defined('ABSPATH')) exit;

setup_postdata($post);

$post_id     = $post->ID;
$placeholder = get_template_directory_uri() . '/assets/src/images/placeholder.png';

$title      = get_the_title($post_id);
$link       = get_permalink($post_id);
$thumbnail  = get_the_post_thumbnail_url($post_id, 'large') ?: $placeholder;
$excerpt    = get_the_excerpt($post_id);
$date       = get_the_date('', $post_id);

$categories = get_the_category($post_id);

$category = null;

// Якщо це архів категорії — беремо саме її
if (is_category()) {
    $current_category = get_queried_object();

    foreach ($categories as $cat) {
        if ($cat->term_id == $current_category->term_id) {
            $category = $cat;
            break;
        }
    }
}

// Якщо це не архів або категорію не знайшли
if (!$category && !empty($categories)) {
    $category = $categories[0];
}

$category_id   = $category ? $category->term_id : null;
$category_name = $category ? $category->name : '';

$category_bg_color   = $category_id ? carbon_get_term_meta($category_id, 'category_bg') : '';
$category_text_color = $category_id ? carbon_get_term_meta($category_id, 'category_text_color') : '';

$svg_value = $category_id ? carbon_get_term_meta($category_id, 'category_svg') : '';

$category_svg = '';

if ($svg_value) {
    $icon_url = is_numeric($svg_value)
        ? wp_get_attachment_url($svg_value)
        : $svg_value;

    if ($icon_url) {
        $category_svg = cf_get_inline_svg($icon_url);
    }
}

$has_custom_style = !empty($category_bg_color) || !empty($category_text_color);

$author_id  = $post->post_author;
$avatar_url = get_avatar_url($author_id, ['size' => 28]);
$username   = get_the_author_meta('display_name', $author_id);

// Media type
$media_type = get_post_media_type($post_id);

$type    = $media_type['type'];

$media   = $media_type['media'];
$gallery = $media_type['gallery'] ?? [];

$has_video   = $type === 'video';
$has_gallery = $type === 'slider';
$has_thumb   = $type === 'thumbnail';

$card_class = 'post-card'
    . ($has_gallery ? ' post-card--slider' : '')
    . ($has_video   ? ' post-card--video'  : '')
    . ($has_thumb   ? ' post-card--thumb'  : '');

$read_time = estimate_post_read_time($post_id);
$like = get_post_like_state($post_id);
$is_saved = get_post_save_state($post_id);
$comments_num = get_comments_number(get_the_ID());
?>

<a href="<?php echo esc_url($link); ?>"
   class="<?php echo esc_attr($card_class); ?> group lg:col-span-3 bg-white dark:bg-[#18181f] rounded-[24px] md:rounded-[32px] overflow-hidden flex flex-col lg:flex-row lg:min-h-[280px]">

    <div class="h-[300px] sm:h-[350px] lg:min-h-[450px] lg:h-full lg:w-[55%] overflow-hidden relative">

        <?php if (!empty($category_name)) : ?>
            <span class="top-4 left-4 z-10 absolute flex items-center gap-2 text-[12px] leading-[16px] font-medium capitalize px-3 py-1 rounded-full w-fit
                <?php echo $has_custom_style ? '' : 'border border-black dark:border-white text-black dark:text-white'; ?>"
                style="
                    <?php if (!empty($category_bg_color)) echo 'background-color:' . esc_attr($category_bg_color) . ';'; ?>
                    <?php if (!empty($category_text_color)) echo 'color:' . esc_attr($category_text_color) . ';'; ?>
                "
            >
                <?php if (!empty($category_svg)) : ?>
                    <span class="w-5 h-5 flex items-center justify-center [&>svg]:w-full [&>svg]:h-full [&>svg]:fill-current [&>svg]:stroke-current">
                        <?php echo $category_svg; ?>
                    </span>
                <?php endif; ?>
                <?php echo esc_html($category_name); ?>
            </span>
        <?php endif; ?>

        <?php if ($has_gallery && !empty($gallery)) : ?>

            <div class="swiper slider w-full overflow-hidden relative h-full">
                
                <div class="swiper-wrapper">

                    <?php foreach ($gallery as $item) : ?>
                        <?php 
                            $img_url = $item['url'] ?? '';
                            $img_alt = $item['alt'] ?? '';
                        ?>

                        <?php if (!empty($img_url)) : ?>
                            <div class="swiper-slide">
                                <img 
                                    src="<?php echo esc_url($img_url); ?>" 
                                    alt="<?php echo esc_attr($img_alt); ?>"
                                    class="w-full h-full object-cover"
                                    loading="lazy"
                                />
                            </div>
                        <?php endif; ?>

                    <?php endforeach; ?>

                </div>

                <!-- Prev -->
                <button type="button"
                    class="slider__prev absolute left-4 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full bg-white/90 text-gray-600 flex items-center justify-center shadow-md transition hover:scale-110 hover:bg-white hover:text-gray-900 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                    </svg>
                </button>

                <!-- Next -->
                <button type="button"
                    class="slider__next absolute right-4 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full bg-white/90 text-gray-600 flex items-center justify-center shadow-md transition hover:scale-110 hover:bg-white hover:text-gray-900 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                    </svg>
                </button>

                <!-- Pagination -->
                <div class="slider__pagination swiper-pagination absolute bottom-3 left-1/2 -translate-x-1/2 z-20"></div>

            </div>

        <?php elseif ($has_video) : ?>

            <video class="post-card__video w-full h-full object-cover" loop muted loading="lazy">
                <source src="<?php echo esc_url($media); ?>" type="video/mp4">
            </video>
            <div class="absolute inset-0 pointer-events-none">
                <div class="post-card__loading hidden absolute inset-0 z-20 flex items-center justify-center">
                    <span class="dot"></span><span class="dot"></span><span class="dot"></span>
                </div>
                <div class="post-card__video-icon absolute inset-0 z-10 flex items-center justify-center">
                    <span class="bg-black/60 flex items-center justify-center rounded-full border border-white text-white w-11 h-11">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                            <path d="M17.13 7.9799C20.96 10.1899 20.96 13.8099 17.13 16.0199L14.04 17.7999L10.95 19.5799C7.13 21.7899 4 19.9799 4 15.5599V11.9999V8.43989C4 4.01989 7.13 2.2099 10.96 4.4199L13.21 5.7199"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>
            </div>

        <?php else : ?>

            <picture class="block w-full h-full">
                <img
                    data-src="<?php echo esc_url($thumbnail); ?>"
                    src="<?php echo esc_url($thumbnail); ?>"
                    alt="<?php echo esc_attr($title); ?>"
                    loading="lazy"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                >
            </picture>

        <?php endif; ?>

    </div>

    <div class="lg:w-[45%] p-4 flex flex-col text-black relative min-h-[300px] md:h-full">
        <div class="flex flex-col h-full">

            <div class="flex items-center mb-4">
                <?php if ($avatar_url) : ?>
                    <div class="post__author-name-img mr-2">
                        <img
                            src="data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23cccccc'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E"
                            data-src="<?php echo esc_url($avatar_url); ?>"
                            alt="<?php echo esc_attr($username); ?>"
                            width="28"
                            height="28"
                            loading="lazy"
                            decoding="async"
                            class="lazy-img w-[28px] h-[28px] rounded-full object-cover bg-[#f5f5f5]"
                        >
                    </div>
                <?php endif; ?>

                <?php if ($username) : ?>
                    <span class="block font-medium capitalize text-[12px] leading-[12px] text-[#404040] hover:text-black dark:text-[#d4d4d8] dark:hover:text-white">
                        <?php echo esc_html($username); ?>
                    </span>
                <?php endif; ?>

                <?php if (!empty($date)) : ?>
                    <span class="mx-[6px] font-medium text-[#6C7280] dark:text-[#9DA3AF]">·</span>
                    <time class="font-normal text-[12px] leading-[12px] text-[#6C7280] dark:text-[#9DA3AF]">
                        <?php echo esc_html($date); ?>
                    </time>
                <?php endif; ?>
            </div>

            <?php if (!empty($title)) : ?>
                <h4 style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"
                    class="text-black dark:text-white text-[24px] font-semibold leading-[32px] mb-3">
                    <?php echo esc_html($title); ?>
                </h4>
            <?php endif; ?>

            <?php if (!empty($excerpt)) : ?>
                <p style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"
                   class="text-[#373A39] dark:text-[#C4C4C4] text-[16px] leading-[24px] mb-4">
                    <?php echo esc_html($excerpt); ?>
                </p>
            <?php endif; ?>

            <div class="flex justify-between items-center relative z-10 w-full mt-auto">
        <div class="flex justify-between items-center relative z-10 w-full">

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
                    <?php echo esc_html($read_time); ?> <?php _e("min read", THEME); ?>
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
    </div>

</a>