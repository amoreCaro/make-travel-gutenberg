<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make('Hero Grid')
    ->add_tab('Content', [
        Field::make('file', 'badge_svg', 'Badge Icon (SVG)')
            ->set_type(['image/svg+xml'])
            ->set_help_text('Upload an SVG icon for the badge (optional).'),

        Field::make('text', 'badge_text', 'Badge Text')
            ->set_default_value('Award - Winning - Eco - Tourism')
            ->set_help_text('Текст бейджа над заголовком.'),

        Field::make('textarea', 'title', 'Section Title')
            ->set_rows(2)
            ->set_default_value("Where Nature\nMeets Wonder")
            ->set_help_text(
                'Enter the title on 2 lines. The second line will be green.'
            ),

        Field::make('textarea', 'text', 'Section Text')
            ->set_rows(3)
            ->set_default_value(
                "Explore Hidden Wonders with Eco-Friendly Tours Pura Vida:\n" .
                "Adventure, Wildlife, Relaxation & Sustainable Luxury"
            )
            ->set_help_text('Enter the section description.'),

        Field::make('separator', 'buttons_separator', 'Buttons'),

        Field::make('text', 'button_1_text', 'Primary Button Text')
            ->set_default_value('Get Inspired'),

        Field::make('text', 'button_1_url', 'Primary Button URL'),

        Field::make('text', 'button_2_text', 'Secondary Button Text')
            ->set_default_value('Start Planning'),

        Field::make('text', 'button_2_url', 'Secondary Button URL'),
    ])

    ->add_tab('Background', [
        Field::make('radio', 'background_type', 'Content Type')
            ->set_options([
                'images' => 'Images',
                'posts'  => 'Posts',
            ])
            ->set_default_value('images'),

        Field::make('media_gallery', 'background_images', 'Gallery Images')
            ->set_type('image')
            ->set_required(true)
            ->set_conditional_logic([
                [
                    'field' => 'background_type',
                    'value' => 'images',
                ],
            ]),

        Field::make('association', 'background_posts', 'Select Posts')
            ->set_types([
                [
                    'type'     => 'post',
                    'post_type' => 'post',
                ],
            ])
            ->set_max(11)
            ->set_required(true)
            ->set_conditional_logic([
                [
                    'field' => 'background_type',
                    'value' => 'posts',
                ],
            ]),
    ])

    ->set_category('common')
    ->set_icon('smiley')

    ->set_render_callback(function ($fields) {

        /*
         * Badge
         */
        $badge_svg_id  = $fields['badge_svg'] ?? 0;
        $badge_svg_url = $badge_svg_id
            ? wp_get_attachment_url($badge_svg_id)
            : '';

        $badge_svg = $badge_svg_url
            ? cf_get_inline_svg($badge_svg_url)
            : '';

        $badge_text = $fields['badge_text'] ?? '';

        /*
         * Content
         */
        $title = $fields['title'] ?? '';
        $text  = $fields['text'] ?? '';

        /*
         * Buttons
         */
        $button_1_text = $fields['button_1_text'] ?? '';
        $button_1_url  = $fields['button_1_url'] ?? '';

        $button_2_text = $fields['button_2_text'] ?? '';
        $button_2_url  = $fields['button_2_url'] ?? '';

        /*
         * Split title into 2 lines.
         * First line = white.
         * Second line = green.
         */
        $title_lines = preg_split(
            '/\r\n|\r|\n/',
            trim($title)
        );

        $title_main   = $title_lines[0] ?? '';
        $title_accent = $title_lines[1] ?? '';

        /*
         * Background
         */
        $background_type   = $fields['background_type'] ?? 'images';
        $background_images = $fields['background_images'] ?? [];
        $background_posts  = $fields['background_posts'] ?? [];

        /*
         * Mobile grid pattern
         */
        $mobile_patterns = [
            'col-span-2 row-span-1',
            'col-span-1 row-span-1',
            'col-span-1 row-span-1',
            'col-span-2 row-span-1',
            'col-span-3 row-span-1',
            'col-span-1 row-span-1',
            'col-span-1 row-span-1',
            'col-span-1 row-span-1',
            'col-span-2 row-span-1',
            'col-span-1 row-span-1',
            'col-span-3 row-span-1',
        ];

        /*
         * Desktop grid pattern
         */
        $desktop_patterns = [
            'md:col-span-2 md:row-span-2',
            'md:col-span-1 md:row-span-1',
            'md:col-span-1 md:row-span-1',
            'md:col-span-2 md:row-span-1',
            'md:col-span-2 md:row-span-1',
            'md:col-span-2 md:row-span-1',
            'md:col-span-1 md:row-span-1',
            'md:col-span-1 md:row-span-1',
            'md:col-span-2 md:row-span-1',
            'md:col-span-1 md:row-span-1',
            'md:col-span-1 md:row-span-1',
        ];

        /*
         * Build background items
         */
        $bg_items = [];

        /*
         * Images
         */
        if ($background_type === 'images') {

            foreach ($background_images as $image_id) {

                $url = wp_get_attachment_image_url(
                    $image_id,
                    'large'
                );

                if ($url) {
                    $bg_items[] = [
                        'url'  => $url,
                        'link' => '',
                    ];
                }
            }

        /*
         * Posts
         */
        } else {

            foreach ($background_posts as $post_data) {

                $post_id = $post_data['id'] ?? 0;

                if (!$post_id) {
                    continue;
                }

                $url = get_the_post_thumbnail_url(
                    $post_id,
                    'large'
                );

                if ($url) {
                    $bg_items[] = [
                        'url'  => $url,
                        'link' => get_permalink($post_id),
                    ];
                }
            }
        }

        /*
         * Maximum 11 items
         */
        $bg_items = array_slice($bg_items, 0, 11);

        /*
         * Repeat items if less than 11
         */
        $items_count = count($bg_items);

        if ($items_count > 0 && $items_count < 11) {

            $filled = [];

            for ($i = 0; $i < 11; $i++) {
                $filled[] = $bg_items[$i % $items_count];
            }

            $bg_items = $filled;
        }

        ?>

        <section
            class="hero relative min-h-screen flex items-center justify-center overflow-hidden bg-[#0F0F11]"
        >

            <!-- Background Grid -->
            <div
                class="absolute inset-0 grid grid-cols-3 auto-rows-fr md:grid-cols-6 md:grid-rows-3 gap-1 md:gap-2"
            >

                <?php foreach ($bg_items as $index => $item) : ?>

                    <?php
                    $m_span = $mobile_patterns[
                        $index % count($mobile_patterns)
                    ];

                    $d_span = $desktop_patterns[
                        $index % count($desktop_patterns)
                    ];

                    $span = $m_span . ' ' . $d_span;

                    $tag = !empty($item['link'])
                        ? 'a'
                        : 'div';
                    ?>

                    <<?php echo $tag; ?>

                        <?php if ($tag === 'a') : ?>
                            href="<?php echo esc_url($item['link']); ?>"
                        <?php endif; ?>

                        class="<?php echo esc_attr($span); ?> relative overflow-hidden rounded-xl md:rounded-2xl block min-h-[90px] md:min-h-0"
                    >

                        <img
                            src="<?php echo esc_url($item['url']); ?>"
                            alt=""
                            class="w-full h-full object-cover"
                        >

                    </<?php echo $tag; ?>>

                <?php endforeach; ?>

            </div>

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/45"></div>

            <!-- Center Content -->
            <div
                class="relative z-10 max-w-4xl w-full mx-auto text-center px-4 py-12"
            >

                <!-- Badge -->
                <?php if (!empty($badge_text) || !empty($badge_svg)) : ?>

                    <span
                        class="hero-grid__badge inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-[0_4px_20px_rgba(0,0,0,0.15)] text-white text-[14px] mb-6"
                    >

                        <?php if (!empty($badge_svg)) : ?>

                            <span
                                class="inline-flex items-center justify-center w-4 h-4 shrink-0 [&>svg]:!w-4 [&>svg]:!h-4"
                            >
                                <?php
                                echo $badge_svg;
                                // phpcs:ignore -- trusted admin SVG markup
                                ?>
                            </span>

                        <?php endif; ?>

                        <?php if (!empty($badge_text)) : ?>
                            <?php echo esc_html($badge_text); ?>
                        <?php endif; ?>

                    </span>

                <?php endif; ?>

                <!-- Title -->
                <?php if (!empty($title_main) || !empty($title_accent)) : ?>

                    <h1
                        class="text-5xl md:text-8xl font-serif font-semibold tracking-normal text-white leading-tight"
                    >

                        <?php if (!empty($title_main)) : ?>

                            <span class="block">
                                <?php echo esc_html($title_main); ?>
                            </span>

                        <?php endif; ?>

                        <?php if (!empty($title_accent)) : ?>

                            <span class="block text-green-400">
                                <?php echo esc_html($title_accent); ?>
                            </span>

                        <?php endif; ?>

                    </h1>

                <?php endif; ?>

                <!-- Description -->
                <?php if (!empty($text)) : ?>

                    <div
                        class="mt-6 max-w-2xl mx-auto text-white/85 text-base md:text-lg whitespace-pre-line"
                    >
                        <?php echo esc_html($text); ?>
                    </div>

                <?php endif; ?>

                <!-- Buttons -->
<?php if (
    (!empty($button_1_text) && !empty($button_1_url)) ||
    (!empty($button_2_text) && !empty($button_2_url))
) : ?>

    <!-- Buttons -->
    <div class="flex flex-col sm:flex-row justify-center items-center gap-3 sm:gap-4 mt-[60px]">

        <!-- Primary Button -->
        <?php if (!empty($button_1_text) && !empty($button_1_url)) : ?>

            <a
                href="<?php echo esc_url($button_1_url); ?>"
                class="group relative inline-flex items-center justify-center gap-3
                    min-w-[180px] h-[56px] px-7
                    rounded-full
                    overflow-hidden
                    bg-green-500
                    text-white
                    font-medium text-[14px]
                    tracking-[0.01em]
                    border border-green-400/30
                    shadow-[0_8px_30px_rgba(34,197,94,0.20)]
                    transition-colors duration-300 ease-out
                    hover:bg-green-400
                    hover:border-green-300/40"
            >
                <span class="relative z-10">
                    <?php echo esc_html($button_1_text); ?>
                </span>

                <svg
                    class="relative z-10 w-4 h-4 opacity-80
                        transition-all duration-300
                        group-hover:translate-x-1
                        group-hover:opacity-100"
                    viewBox="0 0 20 20"
                    fill="none"
                    aria-hidden="true"
                >
                    <path
                        d="M4 10h11M11 5l5 5-5 5"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </a>

        <?php endif; ?>


        <!-- Secondary Button -->
        <?php if (!empty($button_2_text) && !empty($button_2_url)) : ?>

            <a
                href="<?php echo esc_url($button_2_url); ?>"
                class="group inline-flex items-center justify-center gap-3
                    min-w-[180px] h-[56px] px-7
                    rounded-full
                    bg-white/[0.07]
                    backdrop-blur-xl
                    border border-white/30
                    text-white
                    font-medium text-[14px]
                    tracking-[0.01em]
                    shadow-[0_8px_30px_rgba(0,0,0,0.12)]
                    transition-all duration-300 ease-out
                    hover:bg-white/[0.12]
                    hover:border-white/40"
            >
                <span>
                    <?php echo esc_html($button_2_text); ?>
                </span>

                <svg
                    class="w-4 h-4 opacity-70
                        transition-all duration-300
                        group-hover:translate-x-1
                        group-hover:opacity-100"
                    viewBox="0 0 20 20"
                    fill="none"
                    aria-hidden="true"
                >
                    <path
                        d="M4 10h11M11 5l5 5-5 5"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </a>

        <?php endif; ?>

    </div>

<?php endif; ?>

            </div>

            <!-- Scroll Indicator -->
            <div
                class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 text-white/80 text-center hidden sm:block"
            >

                <p class="text-xs tracking-widest uppercase mb-2">
                    Scroll to Explore
                </p>

                <div
                    class="w-6 h-10 border border-white/40 rounded-full mx-auto flex justify-center pt-2"
                >
                    <span
                        class="w-1 h-2 bg-white/80 rounded-full animate-bounce"
                    ></span>
                </div>

            </div>

        </section>

        <?php
    });