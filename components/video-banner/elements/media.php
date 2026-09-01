<?php

if (!defined('ABSPATH')) {
    exit;
}

$media_classes = [
    'video-banner__video',
    'absolute',
    'inset-0',
    'h-full',
    'w-full',
    'object-cover',
];

/**
 * Bottom fade overlay.
 *
 * Used for image and video to smoothly darken
 * the bottom of the media and fade into transparent.
 */
// Основний вертикальний фейд знизу вгору (для тексту та кнопок)
$bottom_fade = 'bg-[linear-gradient(to_top,rgba(5,6,4,0.96)_0%,rgba(5,6,4,0.90)_14%,rgba(5,6,4,0.72)_30%,rgba(5,6,4,0.46)_48%,rgba(5,6,4,0.22)_66%,rgba(5,6,4,0.08)_84%,transparent_100%)]';

// Легке затемнення зверху, щоб верхній edge не був "голим"
$top_fade = 'bg-[linear-gradient(to_bottom,rgba(5,6,4,0.55)_0%,rgba(5,6,4,0.25)_18%,transparent_40%)]';

// М'який центральний vignette — притлумлює яскраві плями по кутах (боке)
$vignette = 'bg-[radial-gradient(ellipse_at_center,transparent_35%,rgba(5,6,4,0.15)_65%,rgba(5,6,4,0.45)_100%)]';

/**
 * Lighter bottom fade for gradient / solid backgrounds.
 */
$bottom_only_dark = 'bg-[linear-gradient(to_top,rgba(0,0,0,0.55)_0%,rgba(0,0,0,0.28)_25%,rgba(0,0,0,0.10)_50%,transparent_100%)]';

$bottom_only_light = 'bg-[linear-gradient(to_top,rgba(0,0,0,0.16)_0%,rgba(0,0,0,0.08)_30%,rgba(0,0,0,0.03)_55%,transparent_100%)]';

?>

<div class="video-banner__media absolute inset-0" aria-hidden="true">

    <?php if ($show_media === 'video' && $video_url) : ?>

        <video
            class="<?php echo esc_attr(implode(' ', $media_classes)); ?>"
            muted
            loop
            playsinline
            autoplay
            preload="auto"
            src="<?php echo esc_url($video_url); ?>"
        ></video>

        <!-- Vignette (притлумлює боке/яскраві плями по кутах) -->
        <div
            class="video-banner__overlay-vignette absolute inset-0 pointer-events-none <?php echo esc_attr($vignette); ?>"
        ></div>

        <!-- Top fade -->
        <div
            class="video-banner__overlay-top absolute inset-x-0 top-0 h-[40%] pointer-events-none <?php echo esc_attr($top_fade); ?>"
        ></div>

        <!-- Bottom fade -->
        <div
            class="video-banner__overlay-bottom absolute inset-x-0 bottom-0 h-[100%] pointer-events-none <?php echo esc_attr($bottom_fade); ?>"
        ></div>


    <?php elseif ($show_media === 'image' && $image_url) : ?>

        <img
            class="<?php echo esc_attr(implode(' ', $media_classes)); ?>"
            src="<?php echo esc_url($image_url); ?>"
            alt=""
            loading="eager"
        />

        <!-- Vignette (притлумлює боке/яскраві плями по кутах) -->
        <div
            class="video-banner__overlay-vignette absolute inset-0 pointer-events-none <?php echo esc_attr($vignette); ?>"
        ></div>

        <!-- Top fade -->
        <div
            class="video-banner__overlay-top absolute inset-x-0 top-0 h-[40%] pointer-events-none <?php echo esc_attr($top_fade); ?>"
        ></div>

        <!-- Bottom fade -->
        <div
            class="video-banner__overlay-bottom absolute inset-x-0 bottom-0 h-[100%] pointer-events-none <?php echo esc_attr($bottom_fade); ?>"
        ></div>


    <?php elseif ($show_media === 'gradient') : ?>

        <div
            class="absolute inset-0 dark:hidden"
            style="background:linear-gradient(
                <?php echo esc_attr($gradient_angle); ?>deg,
                <?php echo esc_attr($gradient_from_light); ?> 0%,
                <?php echo esc_attr($gradient_to_light); ?> 100%
            );"
        ></div>

        <div
            class="absolute inset-0 hidden dark:block"
            style="background:linear-gradient(
                <?php echo esc_attr($gradient_angle); ?>deg,
                <?php echo esc_attr($gradient_from_dark); ?> 0%,
                <?php echo esc_attr($gradient_to_dark); ?> 100%
            );"
        ></div>

        <!-- Bottom fade -->
        <div
            class="video-banner__overlay-bottom absolute inset-x-0 bottom-0 h-[55%] dark:hidden pointer-events-none <?php echo esc_attr($bottom_only_light); ?>"
        ></div>

        <div
            class="video-banner__overlay-bottom absolute inset-x-0 bottom-0 h-[55%] hidden dark:block pointer-events-none <?php echo esc_attr($bottom_only_dark); ?>"
        ></div>


    <?php elseif ($show_media === 'color') : ?>

        <div
            class="absolute inset-0 dark:hidden"
            style="background-color:<?php echo esc_attr($bg_color_light); ?>;"
        ></div>

        <div
            class="absolute inset-0 hidden dark:block"
            style="background-color:<?php echo esc_attr($bg_color_dark); ?>;"
        ></div>

        <!-- Bottom fade -->
        <div
            class="video-banner__overlay-bottom absolute inset-x-0 bottom-0 h-[55%] dark:hidden pointer-events-none <?php echo esc_attr($bottom_only_light); ?>"
        ></div>

        <div
            class="video-banner__overlay-bottom absolute inset-x-0 bottom-0 h-[55%] hidden dark:block pointer-events-none <?php echo esc_attr($bottom_only_dark); ?>"
        ></div>

    <?php endif; ?>

</div>