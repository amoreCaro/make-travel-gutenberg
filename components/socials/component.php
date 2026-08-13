<?php
if (!defined('ABSPATH')) exit;

$socials = carbon_get_theme_option('social_icons');

if (empty($socials) || !is_array($socials)) {
    return;
}
?>

<?php if (!empty($social_icons)) : ?>
    <ul class="flex items-center gap-3">
        <?php foreach ($social_icons as $social) :

            $icon_id = $social['icon'] ?? 0;

            if (!$icon_id) {
                continue;
            }

            $icon_url = wp_get_attachment_url($icon_id);

            if (!$icon_url) {
                continue;
            }

            $icon_svg = cf_get_inline_svg($icon_url, 16, 16);

            if (!$icon_svg) {
                continue;
            }

            $link        = $social['link'] ?? '#';
            $color_dark  = $social['color_dark'] ?? '#FFFFFF';
            $color_light = $social['color_light'] ?? '#000000';
            $hover_color = $social['hover_color'] ?? '#7D0AF2';

        ?>
            <li>
                <a
                    href="<?php echo esc_url($link); ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group flex h-9 w-9 items-center justify-center rounded-lg border border-slate-100 bg-slate-50 transition-all
                        dark:border-zinc-800 dark:bg-zinc-900
                        text-[var(--icon-light)]
                        hover:text-[var(--icon-hover)]
                        dark:text-[var(--icon-dark)]
                        dark:hover:text-[var(--icon-hover)]
                        [&>svg]:h-4 [&>svg]:w-4 [&>svg]:shrink-0"
                    style="
                        --icon-light: <?php echo esc_attr($color_light); ?>;
                        --icon-dark: <?php echo esc_attr($color_dark); ?>;
                        --icon-hover: <?php echo esc_attr($hover_color); ?>;
                    "
                >
                    <?php echo $icon_svg; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>