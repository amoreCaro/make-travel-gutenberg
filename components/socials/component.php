<?php
if (!defined('ABSPATH')) {
    exit;
}

$socials = get_field("acf_social_icons", "option");
$valid_socials = [];

if (!empty($socials)) {

    foreach ($socials as $social_item) {

        $url = $social_item['acf_social_url'] ?? '';
        $icon_id = $social_item['acf_social_icon'] ?? 0;

        $color_dark = $social_item['acf_social_color'] ?? '';
        $color_light = $social_item['acf_social_color_light_mode'] ?? '';

        $hover_color = $social_item['acf_social_hover_color'] ?? '';

        $icon_svg = get_inline_svg_social_icons_from_acf($icon_id);

        if (!empty($url) && !empty($icon_svg)) {
            $valid_socials[] = [
                'url' => $url,
                'svg' => $icon_svg,
                'color_dark' => $color_dark,
                'color_light' => $color_light,
                'hover_color' => $hover_color
            ];
        }
    }
}

if (!empty($valid_socials)) : ?>
<div class="socials flex gap-2 items-center">

    <?php foreach ($valid_socials as $social) : ?>
<a href="<?php echo esc_url($social['url']); ?>"
   class="flex items-center justify-center w-[32px] h-[32px]
          fill-current transition-colors duration-200

          text-[var(--icon-light)]
          hover:text-[var(--icon-hover)]
          
          dark:text-[var(--icon-dark)]
          dark:hover:text-[var(--icon-hover)]
   "
   style="
       --icon-light: <?php echo esc_attr($social['color_light'] ?: '#000'); ?>;
       --icon-dark: <?php echo esc_attr($social['color_dark'] ?: '#fff'); ?>;
       --icon-hover: <?php echo esc_attr($social['hover_color'] ?: $social['color_light']); ?>;
   "
>
    <?php echo $social['svg']; ?>
</a>


    <?php endforeach; ?>

</div>
<?php endif; ?>