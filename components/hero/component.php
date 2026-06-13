<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

/**
 * helper для complex field
 */
function hero_img($items, $i) {
    if (empty($items[$i]['image'])) return;

    $id = $items[$i]['image'];

    echo wp_get_attachment_image($id, 'full', false, [
        'class' => 'lazy-img object-cover w-full h-full',
        'loading' => 'lazy',
    ]);
}

Block::make('Hero')
    ->add_fields([

        Field::make('complex', 'decor_images_left', 'Decor images left')
            ->set_min(1)
            ->set_max(7)
            ->add_fields([
                Field::make('image', 'image', 'Image')
                    ->set_value_type('id'),
            ]),

        Field::make('text', 'title', 'Section Title'),

        Field::make('text', 'placeholder', 'Search placeholder'),

        Field::make('complex', 'decor_images_right', 'Decor images right')
            ->set_min(1)
            ->set_max(7)
            ->add_fields([
                Field::make('image', 'image', 'Image')
                    ->set_value_type('id'),
            ])

    ])
    ->set_category('common')
    ->set_icon('smiley')
    ->set_render_callback(function ($fields) {

        $decor_images_left  = $fields['decor_images_left'] ?? [];
        $decor_images_right = $fields['decor_images_right'] ?? [];

        $title              = $fields['title'] ?? '';
        $search_placeholder = $fields['placeholder'] ?? '';

?>

<section class="hero relative min-h-[700px] flex items-center justify-center overflow-hidden bg-white dark:bg-[#0F0F11]">

<?php if (!empty($decor_images_left)) : ?>
<div class="absolute left-0 top-1/2 -translate-y-1/2 grid grid-cols-[repeat(4,min-content)] gap-6 2xl:gap-10 w-max pointer-events-none items-start">

    <div class="space-y-4 2xl:space-y-8 3xl:space-y-12 mt-8 2xl:mt-12 3xl:mt-16">
        <?php if (!empty($decor_images_left[0])) : ?>
        <div class="animate-card-smooth [animation-delay:600ms] h-48 w-48 2xl:h-64 2xl:w-64 3xl:h-80 3xl:w-80 ...">
            <picture class="block w-full h-full">
                <?php hero_img($decor_images_left, 0); ?>
            </picture>
        </div>
        <?php endif; ?>

        <?php if (!empty($decor_images_left[1])) : ?>
        <div class="animate-card-smooth [animation-delay:750ms] h-48 w-48 ...">
            <picture class="block w-full h-full">
                <?php hero_img($decor_images_left, 1); ?>
            </picture>
        </div>
        <?php endif; ?>
    </div>

    <div class="hidden md:block space-y-4 2xl:space-y-8 3xl:space-y-12 pt-24 ...">
        <?php if (!empty($decor_images_left[2])) : ?>
        <div class="animate-card-smooth [animation-delay:400ms] h-32 w-32 ...">
            <picture class="block w-full h-full">
                <?php hero_img($decor_images_left, 2); ?>
            </picture>
        </div>
        <?php endif; ?>

        <?php if (!empty($decor_images_left[3])) : ?>
        <div class="animate-card-smooth [animation-delay:550ms] h-[160px] w-[160px] ...">
            <picture class="block w-full h-full">
                <?php hero_img($decor_images_left, 3); ?>
            </picture>
        </div>
        <?php endif; ?>
    </div>

    <div class="hidden lg:block space-y-4 2xl:space-y-8 3xl:space-y-12 pt-[145px] ...">
        <?php if (!empty($decor_images_left[4])) : ?>
        <div class="animate-card-smooth [animation-delay:200ms] h-20 w-20 ...">
            <picture class="block w-full h-full">
                <?php hero_img($decor_images_left, 4); ?>
            </picture>
        </div>
        <?php endif; ?>

        <?php if (!empty($decor_images_left[5])) : ?>
        <div class="animate-card-smooth [animation-delay:350ms] h-[120px] w-[120px] ...">
            <picture class="block w-full h-full">
                <?php hero_img($decor_images_left, 5); ?>
            </picture>
        </div>
        <?php endif; ?>
    </div>

    <div class="hidden lg:block space-y-4 2xl:space-y-8 3xl:space-y-12 pt-[240px] ...">
        <?php if (!empty($decor_images_left[6])) : ?>
        <div class="animate-card-smooth [animation-delay:50ms] h-[90px] w-[90px] ...">
            <picture class="block w-full h-full">
                <?php hero_img($decor_images_left, 6); ?>
            </picture>
        </div>
        <?php endif; ?>
    </div>

</div>
<?php endif; ?>

    <!-- CENTER -->
    <div class="z-10 text-center max-w-3xl w-full px-4">

        <?php if (!empty($title)) : ?>
            <h1 class="text-5xl sm:text-7xl md:text-8xl font-medium text-[#1a1a1a] dark:text-white mb-6 md:mb-10 tracking-tight">
                <?php echo esc_html($title); ?>
            </h1>
        <?php endif; ?>

        <?php if (!empty($search_placeholder)) : ?>
        <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <div class="relative max-w-2xl mx-auto group cursor-pointer">

                <span class="absolute inset-y-0 left-5 flex items-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>

                <input
                    type="text"
                    name="s"
                    value="<?php echo get_search_query(); ?>"
                    placeholder="<?php echo esc_attr($search_placeholder); ?>"
                    class="w-full py-4 pl-12 pr-6 bg-white dark:bg-[#232125] border rounded-full"
                >

            </div>
        </form>
        <?php endif; ?>

    </div>

<?php if (!empty($decor_images_right)) : ?>
<div class="absolute right-0 top-1/2 -translate-y-1/2 grid grid-cols-[repeat(4,min-content)] gap-6 2xl:gap-10 w-max pointer-events-none items-start">

    <div class="space-y-4 2xl:space-y-8 3xl:space-y-12 mt-8 2xl:mt-12 3xl:mt-16">
        <?php if (!empty($decor_images_right[1])) : ?>
        <div class="animate-card-right [animation-delay:600ms] h-48 w-48 ...">
            <picture class="block w-full h-full">
                <?php hero_img($decor_images_right, 1); ?>
            </picture>
        </div>
        <?php endif; ?>

        <?php if (!empty($decor_images_right[0])) : ?>
        <div class="animate-card-right [animation-delay:750ms] h-48 w-48 ...">
            <picture class="block w-full h-full">
                <?php hero_img($decor_images_right, 0); ?>
            </picture>
        </div>
        <?php endif; ?>
    </div>

</div>
<?php endif; ?>

</section>

<?php
});