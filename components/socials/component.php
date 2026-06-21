<?php
if (!defined('ABSPATH')) exit;

$socials = carbon_get_theme_option('social_icons');

if (empty($socials) || !is_array($socials)) {
    return;
}
?>

<div class="socials flex gap-2 items-center">

    <?php foreach ($socials as $item) :

        $icon_id = $item['icon'] ?? 0;

        if (!$icon_id) {
            continue;
        }

        $icon_url = wp_get_attachment_url($icon_id);

        if (!$icon_url) {
            continue;
        }

        $icon_svg = cf_get_inline_svg($icon_url, 20, 20);

        if (!$icon_svg) {
            continue;
        }

        $url = $item['link'] ?? '#'; 

        $color_dark  = $item['color_dark'] ?? '#fff';
        $color_light = $item['color_light'] ?? '#000';
        $hover_color = $item['hover_color'] ?? $color_light;

    ?>

        <a href="<?php echo esc_url($url); ?>"
           class="flex items-center justify-center w-[32px] h-[32px]
                  transition-colors duration-200
                  text-[var(--icon-light)]
                  hover:text-[var(--icon-hover)]
                  dark:text-[var(--icon-dark)]
                  dark:hover:text-[var(--icon-hover)]"
           style="
                --icon-light: <?php echo esc_attr($color_light); ?>;
                --icon-dark: <?php echo esc_attr($color_dark); ?>;
                --icon-hover: <?php echo esc_attr($hover_color); ?>;
           "
        >
            <?php echo $icon_svg; ?>
        </a>

    <?php endforeach; ?>

</div>