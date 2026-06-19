<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Short debug **/
if (!function_exists('dd')) {
    function dd($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}

if (!function_exists('limit_gallery_items')) {
    function limit_gallery_items($items, $max_count = 4) {
        if (empty($items) || !is_array($items)) {
            return [];
        }
        return array_slice($items, 0, $max_count);
    }
}

if (!function_exists('cf_get_inline_svg')) {
    function cf_get_inline_svg($svg_url, $width = 50, $height = 50) {

        if (!$svg_url) return '';

        // конвертуємо URL → path
        $path = str_replace(
            wp_get_upload_dir()['baseurl'],
            wp_get_upload_dir()['basedir'],
            $svg_url
        );

        if (!file_exists($path)) {
            return '';
        }

        $svg = file_get_contents($path);

        if (!$svg) return '';

        $svg = preg_replace('/fill=".*?"/', 'fill="currentColor"', $svg);
        $svg = preg_replace('/stroke=".*?"/', 'stroke="currentColor"', $svg);

        $svg = preg_replace(
            '/<svg([^>]*)>/',
            '<svg$1 width="'.$width.'" height="'.$height.'" class="fill-current">',
            $svg,
            1
        );

        return $svg;
    }
}

if (!function_exists('render_gallery_image')) {
    function render_gallery_image($url, $alt, $wrapper_class = '', $img_class = 'w-full h-full object-cover') {
        $wrapper_class = $wrapper_class ? "overflow-hidden $wrapper_class" : 'overflow-hidden';
        echo '<div class="'.esc_attr($wrapper_class).'">';
        echo '<img data-src="'.esc_url($url).'" src="'.esc_url($url).'" alt="'.esc_attr($alt).'" class="lazy-img '.esc_attr($img_class).'">';
        echo '</div>';
    }
}

/**
 * Render image by index
 */
if (!function_exists('render_decor_image')) {
    function render_decor_image($items, $index) {

        if (empty($items[$index]['image'])) return;

        $img = $items[$index]['image'];

        // якщо ID (WordPress attachment)
        if (is_numeric($img)) {

            // full — щоб працювало як "data-src"
            $url = wp_get_attachment_image_url($img, 'full');

            // optional placeholder (можеш змінити на medium або blur image)
            $placeholder = wp_get_attachment_image_url($img, 'thumbnail');

        } else {
            $url = $img;
            $placeholder = $img;
        }

        ?>
        <img
            src="<?php echo esc_url($placeholder); ?>"
            data-src="<?php echo esc_url($url); ?>"
            class="lazy-img object-cover w-full h-full"
            alt=""
        >
        <?php
    }
}

/**
 * Визначає media-тип поста на основі блоку carbon-fields/media
 */
function get_post_media_type(int $post_id): array
{
    /*
    |--------------------------------------------------------------------------
    | Video
    |--------------------------------------------------------------------------
    */

    $video_id = carbon_get_post_meta($post_id, 'cf_video');

    $video_url = !empty($video_id)
        ? wp_get_attachment_url($video_id)
        : '';

    /*
    |--------------------------------------------------------------------------
    | Gallery
    |--------------------------------------------------------------------------
    */

    $gallery_raw = carbon_get_post_meta($post_id, 'cf_gallery');

    if (!is_array($gallery_raw)) {
        $gallery_raw = [];
    }

    $gallery_raw = array_slice($gallery_raw, 0, 4);

    $gallery = [];

    foreach ($gallery_raw as $item) {

        $img_id = $item['cf_image'] ?? 0;

        if (!$img_id) {
            continue;
        }

        $gallery[] = [
            'url' => wp_get_attachment_image_url($img_id, 'large'),
            'alt' => get_post_meta($img_id, '_wp_attachment_image_alt', true)
                ?: get_the_title($post_id),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Thumbnail
    |--------------------------------------------------------------------------
    */

    $thumbnail = has_post_thumbnail($post_id)
        ? get_the_post_thumbnail_url($post_id, 'large')
        : '';

    /*
    |--------------------------------------------------------------------------
    | Priority
    |--------------------------------------------------------------------------
    */

    if (!empty($video_url)) {
        return [
            'type' => 'video',
            'media' => $video_url,
            'gallery' => [],
        ];
    }

    if (!empty($gallery)) {
        return [
            'type' => 'slider',
            'media' => $gallery[0]['url'],
            'gallery' => $gallery,
        ];
    }

    if (!empty($thumbnail)) {
        return [
            'type' => 'thumbnail',
            'media' => $thumbnail,
            'gallery' => [],
        ];
    }

    // ❌ IMPORTANT: NO DEFAULT PLACEHOLDER
    return [
        'type' => 'none',
        'media' => '',
        'gallery' => [],
    ];
}

if (!function_exists('estimate_post_read_time')) {

    function estimate_post_read_time($post_id) {

        $content = get_post_field('post_content', $post_id);
        $text = wp_strip_all_tags($content);

        // слова
        $words = str_word_count($text);

        // середня швидкість читання
        $reading_speed = 200;

        // час тексту
        $minutes = ceil($words / $reading_speed);

        // картинки
        $images = substr_count($content, '<img');

        // +10 сек за кожну картинку
        $minutes += ceil(($images * 10) / 60);

        return max(1, $minutes);
    }

}
