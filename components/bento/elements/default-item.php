<?php
if (!defined('ABSPATH')) exit;

setup_postdata($post);

$post_id     = $post->ID;
$placeholder = get_template_directory_uri() . '/assets/src/images/placeholder.png';

$title     = get_the_title($post_id);
$link      = get_permalink($post_id);
$thumbnail = get_the_post_thumbnail_url($post_id, 'large') ?: $placeholder;
$excerpt   = get_the_excerpt($post_id);
$date      = get_the_date('', $post_id);

$categories = get_the_category($post_id);

$category = null;

// Якщо це сторінка архіву категорії — використовуємо саме її
if (is_category()) {
    $current_category = get_queried_object();

    foreach ($categories as $cat) {
        if ($cat->term_id == $current_category->term_id) {
            $category = $cat;
            break;
        }
    }
}

// Якщо не знайшли або це не архів — беремо першу категорію
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
    // Якщо Carbon Fields повертає ID
    if (is_numeric($svg_value)) {
        $icon_url = wp_get_attachment_url($svg_value);
    } else {
        // Якщо повертає URL
        $icon_url = $svg_value;
    }

    if ($icon_url) {
        $category_svg = cf_get_inline_svg($icon_url);
    }
}

$has_custom_style = !empty($category_bg_color) || !empty($category_text_color);

// Media type
$media_type = get_post_media_type($post_id);

$type    = $media_type['type'];

$media   = $media_type['media'];
$gallery = $media_type['gallery'] ?? [];

$has_video   = $type === 'video';
$has_gallery = $type === 'slider';
$has_thumb   = $type === 'thumbnail';

$card_class = 'post-card'
    . ($has_gallery ? ' post-card--slider preview-buttons-hover' : '')
    . ($has_video   ? ' post-card--video'  : '')
    . ($has_thumb   ? ' post-card--thumb'  : '');

$read_time = estimate_post_read_time($post_id);

$card_tag = $has_gallery ? 'div' : 'a';
$content_tag = $has_gallery ? 'a' : 'div';
$content_href = $has_gallery ? ' href="' . esc_url($link) . '"' : '';
$card_href = $has_gallery ? '' : ' href="' . esc_url($link) . '"';
?>

<<?php echo $card_tag; ?><?php echo $card_href; ?>
   class="<?php echo esc_attr($card_class); ?> group w-full flex flex-col bg-white dark:bg-[#18181f] overflow-hidden rounded-[24px] shadow-sm w-full min-h-[450px] h-full">

    <div class="h-[200px] md:h-[185px] overflow-hidden relative flex-shrink-0">
        <?php if ($has_gallery && !empty($gallery)) : ?>

            <div class="swiper slider w-full overflow-hidden relative h-[185px]">
                
                <div class="swiper-wrapper">

                    <?php foreach ($gallery as $item) : ?>
                        <?php 
                            $img_url = $item['url'] ?? '';
                            $img_alt = $item['alt'] ?? '';
                        ?>

                        <?php if (!empty($img_url)) : ?>
                            <div class="swiper-slide">
                                <img 
                                    data-src="<?php echo esc_url($img_url); ?>"
                                    src="<?php echo esc_url($img_url); ?>" 
                                    alt="<?php echo esc_attr($img_alt); ?>"
                                    class="w-full h-full object-cover lazy-img"
                                    loading="lazy"
                                />
                            </div>
                        <?php endif; ?>

                    <?php endforeach; ?>

                </div>

                <!-- Prev -->
                <button type="button"
                    class="slider__prev absolute left-4 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full bg-white/90 text-gray-600 flex items-center justify-center shadow-md transition hover:scale-110 hover:bg-white hover:text-gray-900 active:scale-95"
                    aria-label="<?php esc_attr_e('Previous image', THEME); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                    </svg>
                </button>

                <!-- Next -->
                <button type="button"
                    class="slider__next absolute right-4 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full bg-white/90 text-gray-600 flex items-center justify-center shadow-md transition hover:scale-110 hover:bg-white hover:text-gray-900 active:scale-95"
                    aria-label="<?php esc_attr_e('Next image', THEME); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                    </svg>
                </button>

                <!-- Pagination -->
                <div class="slider__pagination swiper-pagination hidden"></div>

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
                    <span class="bg-black/60 flex items-center justify-center rounded-full text-white w-11 h-11">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64" fill="none">
                          <circle cx="32" cy="32" r="30" stroke="#FFFFFF" stroke-width="2.5"/>
                          <path d="M25.5 20.36c0-1.57 1.73-2.52 3.06-1.7l14.28 8.84c1.28.79 1.28 2.68 0 3.47l-14.28 8.84c-1.33.82-3.06-.13-3.06-1.7V20.36z" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="1.5" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>
            </div>

        <?php else : ?>

            <picture class="block w-full h-full">
                <img
                    data-src="<?php echo esc_url($thumbnail); ?>"
                    src="<?php echo esc_url($placeholder); ?>"
                    alt="<?php echo esc_attr($title); ?>"
                    loading="lazy"
                    class="lazy-img w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                >
            </picture>

        <?php endif; ?>

    </div>

    <<?php echo $content_tag; ?><?php echo $content_href; ?>
        class="p-4 flex flex-col flex-grow justify-between">

        <div class="flex flex-col flex-1">


            <?php if (!empty($category_name)) : ?>
                <span class="top-4 mb-3 left-4 flex items-center gap-2 text-[12px] leading-[16px] font-medium capitalize px-3 py-1 rounded-full w-fit
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
    
                    <span>
                        <?php echo esc_html($category_name); ?>
                    </span>
                </span>
            <?php endif; ?>
    
            <?php if (!empty($title)) : ?>
                <h4 style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"
                    class="text-black font-semibold dark:text-white text-[16px] leading-[24px] mb-3">
                    <?php echo esc_html($title); ?>
                </h4>
            <?php endif; ?>
    
            <?php if (!empty($excerpt)) : ?>
                <p style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"
                    class="text-[#373A39] dark:text-[#C4C4C4] text-sm leading-relaxed mb-4">
                    <?php echo esc_html($excerpt); ?>
                </p>
            <?php endif; ?>


        <?php if (!empty($date)) : ?>
            <time class="mt-auto mb-4 font-normal text-[12px] leading-[12px] text-[#6C7280] dark:text-[#9DA3AF]">
                <?php echo esc_html($date); ?>
            </time>
        <?php endif; ?>

        </div>

    </<?php echo $content_tag; ?>>

</<?php echo $card_tag; ?>>