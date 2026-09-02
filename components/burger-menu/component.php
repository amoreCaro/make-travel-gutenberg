<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get header menu
 */
$nav_menu = get_nav_menu_locations();
$menu_items = [];

if (isset($nav_menu['header_menu'])) {
    $menu_id = $nav_menu['header_menu'];
    $menu_items = wp_get_nav_menu_items($menu_id);
}

?>

<div
    id="burgerMenu"
    class="fixed inset-0 z-[1000] flex items-center justify-center opacity-0 pointer-events-none -translate-x-full transition-all duration-300 ease-out"
>

    <!-- Overlay -->
    <div
        id="burgerOverlay"
        class="absolute inset-0 bg-white/90 dark:bg-zinc-950/90 backdrop-blur-2xl"
    ></div>

    <!-- Close -->
    <button
        id="closeBurger"
        type="button"
        aria-label="Close menu"
        class="
            absolute
            top-4 right-4
            sm:top-4 sm:right-5
            z-50
            p-2 sm:p-3
            text-zinc-500
            hover:text-black
            hover:bg-black/10
            dark:text-zinc-400
            dark:hover:text-white
            dark:hover:bg-white/10
            rounded-full
            transition
        "
    >
        <svg
            class="h-6 w-6 sm:h-8 sm:w-8"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
            />
        </svg>
    </button>

    <div
        class="
            relative
            z-10
            w-full
            h-full
            flex
            flex-col
            justify-between
            items-center
            px-4
            sm:px-5
            py-8
        "
    >

        <div
            class="
                flex
                flex-col
                items-center
                flex-1
                justify-center
                w-full
            "
        >

            <!-- Search -->
            <div
                class="
                    relative
                    w-full
                    group
                    mb-10
                    max-w-md
                    md:max-w-xl
                    lg:max-w-2xl
                "
            >

                <div
                    class="
                        absolute
                        inset-y-0
                        left-0
                        pl-5
                        flex
                        items-center
                        pointer-events-none
                        text-zinc-400
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 sm:h-6 sm:w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        />
                    </svg>
                </div>

                <input
                    type="text"
                    placeholder="Search for adventures..."
                    class="
                        w-full
                        bg-black/5
                        border
                        border-black/20
                        dark:bg-white/5
                        dark:border-white/20
                        rounded-full
                        py-4
                        pl-14
                        pr-6
                        text-black
                        dark:text-white
                        text-lg
                        placeholder:text-zinc-400
                        focus:outline-none
                        focus:ring-2
                        focus:ring-black/20
                        transition
                    "
                >

            </div>

            <!-- Menu -->
            <nav class="w-full max-w-md md:max-w-xl lg:max-w-2xl">

                <ul class="flex flex-col gap-4">

                    <?php foreach ($menu_items as $item) : ?>

                        <?php

                        /**
                         * Check active menu item
                         */
                        $is_active = in_array(
                            'current-menu-item',
                            (array) $item->classes,
                            true
                        );

                        /**
                         * Icon variables
                         */
                        $icon_path = '';

                        /**
                         * Get category from menu URL
                         */
                        $path = parse_url(
                            $item->url,
                            PHP_URL_PATH
                        );

                        if ($path) {

                            $slug = basename(
                                untrailingslashit($path)
                            );

                            /**
                             * Find category by slug
                             */
                            $term = get_term_by(
                                'slug',
                                $slug,
                                'category'
                            );

                            if ($term && !is_wp_error($term)) {

                                /**
                                 * Get SVG from Carbon Fields
                                 */
                                $icon_svg = carbon_get_term_meta(
                                    $term->term_id,
                                    'category_svg'
                                );

                                /**
                                 * Carbon Fields can return
                                 * attachment ID or URL.
                                 */

                                if (is_numeric($icon_svg)) {

                                    /**
                                     * Attachment ID
                                     */
                                    $icon_path = get_attached_file(
                                        (int) $icon_svg
                                    );

                                } elseif (
                                    is_string($icon_svg) &&
                                    !empty($icon_svg)
                                ) {

                                    /**
                                     * SVG URL
                                     */
                                    $upload_dir = wp_upload_dir();

                                    $icon_path = str_replace(
                                        $upload_dir['baseurl'],
                                        $upload_dir['basedir'],
                                        $icon_svg
                                    );
                                }
                            }
                        }

                        ?>

                        <li>

                            <a
                                href="<?php echo esc_url($item->url); ?>"
                                class="
                                    group
                                    w-full
                                    flex
                                    items-center
                                    justify-between
                                    p-5
                                    rounded-full
                                    border
                                    border-black/20
                                    dark:border-white/20
                                    transition
                                    duration-300

                                    <?php
                                    echo $is_active
                                        ? '
                                            bg-black
                                            text-white
                                            dark:bg-white
                                            dark:text-black
                                        '
                                        : '
                                            text-black
                                            dark:text-white
                                            hover:bg-black
                                            hover:text-white
                                            dark:hover:bg-white
                                            dark:hover:text-black
                                        ';
                                    ?>
                                "
                            >

                                <div class="flex items-center gap-4">

                                    <?php if (
                                        !empty($icon_path) &&
                                        file_exists($icon_path)
                                    ) : ?>

                                        <?php

                                        /**
                                         * Read SVG
                                         */
                                        $svg_content = file_get_contents(
                                            $icon_path
                                        );

                                        /**
                                         * Replace hardcoded fills
                                         * with currentColor.
                                         */
                                        $svg_content = preg_replace(
                                            '/fill="[^"]*"/i',
                                            'fill="currentColor"',
                                            $svg_content
                                        );

                                        /**
                                         * Replace hardcoded strokes
                                         * with currentColor.
                                         */
                                        $svg_content = preg_replace(
                                            '/stroke="[^"]*"/i',
                                            'stroke="currentColor"',
                                            $svg_content
                                        );

                                        /**
                                         * If SVG doesn't have fill/stroke
                                         * attributes, currentColor is
                                         * still inherited from the parent.
                                         */
                                        ?>

                                        <span
                                            class="
                                                w-5
                                                h-5
                                                shrink-0
                                                flex
                                                items-center
                                                justify-center
                                                text-current
                                                [&>svg]:w-full
                                                [&>svg]:h-full
                                                [&>svg]:block
                                                [&>svg]:!fill-current
                                                [&>svg]:!stroke-current
                                            "
                                        >
                                            <?php
                                            echo $svg_content;
                                            ?>
                                        </span>

                                    <?php endif; ?>

                                    <span
                                        class="
                                            text-lg
                                            sm:text-xl
                                            font-medium
                                        "
                                    >
                                        <?php
                                        echo esc_html(
                                            $item->title
                                        );
                                        ?>
                                    </span>

                                </div>

                            </a>

                        </li>

                    <?php endforeach; ?>

                </ul>

            </nav>

        </div>

    </div>

</div>