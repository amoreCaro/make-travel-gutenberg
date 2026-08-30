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

    function cf_get_inline_svg($svg_source, $width = 16, $height = 16, $extra_class = '') {

        if (!$svg_source) return '';

        /**
         * 🔒 ALLOW ONLY SVG FILES
         */
        $path = parse_url($svg_source, PHP_URL_PATH);
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if ($ext !== 'svg') {
            return ''; // ❌ жорсткий стоп
        }

        $upload_dir = wp_get_upload_dir();

        // тільки uploads SVG
        if (str_starts_with($svg_source, $upload_dir['baseurl'])) {

            $file_path = str_replace(
                $upload_dir['baseurl'],
                $upload_dir['basedir'],
                $svg_source
            );

            if (!file_exists($file_path)) return '';

            $svg = file_get_contents($file_path);

        } else {
            return ''; // ❌ забороняємо theme / external
        }

        if (!$svg) return '';

        // security cleanup
        $svg = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $svg);
        $svg = preg_replace('/on\w+=".*?"/i', '', $svg);
        $svg = preg_replace('/javascript:/i', '', $svg);

        // force currentColor
        $svg = preg_replace('/fill="[^"]*"/i', 'fill="currentColor"', $svg);
        $svg = preg_replace('/stroke="[^"]*"/i', 'stroke="currentColor"', $svg);

        $class = trim('cf-svg-icon fill-current ' . $extra_class);

        $svg = preg_replace(
            '/<svg([^>]*)>/',
            '<svg$1 width="'.$width.'" height="'.$height.'" class="'.$class.'">',
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

    $gallery = [];

    foreach ($gallery_raw as $item) {
        // media_gallery stores IDs; legacy complex stored ['cf_image' => id].
        $img_id = is_array($item)
            ? absint($item['cf_image'] ?? $item['image'] ?? 0)
            : absint($item);

        if (!$img_id) {
            continue;
        }

        $large = wp_get_attachment_image_url($img_id, 'large') ?: '';
        $full  = wp_get_attachment_image_url($img_id, 'full') ?: $large;

        $gallery[] = [
            'url'  => $large,
            'full' => $full,
            'alt'  => get_post_meta($img_id, '_wp_attachment_image_alt', true)
                ?: get_the_title($post_id),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Thumbnail
    |--------------------------------------------------------------------------
    */

    $thumbnail      = '';
    $thumbnail_full = '';

    if (has_post_thumbnail($post_id)) {
        $thumb_id       = (int) get_post_thumbnail_id($post_id);
        $thumbnail      = get_the_post_thumbnail_url($post_id, 'large') ?: '';
        $thumbnail_full = $thumb_id
            ? (wp_get_attachment_image_url($thumb_id, 'full') ?: $thumbnail)
            : $thumbnail;
    }

    /*
    |--------------------------------------------------------------------------
    | Priority (primary type for cards / banners)
    | video > gallery > thumbnail
    | Gallery is always returned when present so single can render hero + gallery.
    |--------------------------------------------------------------------------
    */

    $payload = [
        'media'          => '',
        'gallery'        => $gallery,
        'video'          => $video_url,
        'thumbnail'      => $thumbnail,
        'thumbnail_full' => $thumbnail_full,
    ];

    if (!empty($video_url)) {
        return array_merge($payload, [
            'type'  => 'video',
            'media' => $video_url,
        ]);
    }

    if (!empty($gallery)) {
        return array_merge($payload, [
            'type'  => 'slider',
            'media' => $gallery[0]['url'],
        ]);
    }

    if (!empty($thumbnail)) {
        return array_merge($payload, [
            'type'  => 'thumbnail',
            'media' => $thumbnail,
        ]);
    }

    // ❌ IMPORTANT: NO DEFAULT PLACEHOLDER
    return [
        'type'           => 'none',
        'media'          => '',
        'gallery'        => [],
        'video'          => '',
        'thumbnail'      => '',
        'thumbnail_full' => '',
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
