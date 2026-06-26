<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make('Hero')

    ->add_tab('Left content', [

        Field::make('complex', 'decor_images_left', 'Decor images left')
            ->set_min(1)
            ->set_max(7)
            ->add_fields([
                Field::make('image', 'image', 'Image')
                    ->set_required(true) 
            ]),

    ])

    ->add_tab('Center content', [
        Field::make('text', 'title', 'Section Title'),
        Field::make('text', 'placeholder', 'Search placeholder'),
    ])

    ->add_tab('Right content', [

        Field::make('complex', 'decor_images_right', 'Decor images right')
            ->set_min(1)
            ->set_max(7)
            ->add_fields([
                Field::make('image', 'image', 'Image')
                    ->set_required(true)
            ]),

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
        <?php if ( ! empty($decor_images_left[0]) ) : ?>
        <div class="animate-card-smooth [animation-delay:600ms] h-48 w-48 2xl:h-64 2xl:w-64 3xl:h-80 3xl:w-80 max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 dark:shadow-[0_0_20px_rgba(0,0,0,0.5)] rounded-2xl overflow-hidden shadow-lg -translate-x-[25%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_left, 0); ?>
            </picture>
        </div>
        <?php endif; ?>
        
        <?php if ( ! empty($decor_images_left[1]) ) : ?>
        <div class="animate-card-smooth [animation-delay:750ms] h-48 w-48 2xl:h-64 2xl:w-64 3xl:h-80 3xl:w-80 max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 dark:shadow-[0_0_20px_rgba(0,0,0,0.5)] rounded-2xl overflow-hidden shadow-lg -translate-x-[50%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_left, 1); ?>
            </picture>
        </div>
        <?php endif; ?>
    </div>

    <div class="hidden md:block space-y-4 2xl:space-y-8 3xl:space-y-12 pt-24 2xl:pt-32 3xl:pt-40">
        <?php if ( ! empty($decor_images_left[2]) ) : ?>
        <div class="animate-card-smooth [animation-delay:400ms] h-32 w-32 2xl:h-44 2xl:w-44 3xl:h-56 3xl:w-56 max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 rounded-2xl overflow-hidden shadow-lg -translate-x-[35%] 3xl:-translate-x-[40%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_left, 2); ?>
            </picture>
        </div>
        <?php endif; ?>

        <?php if ( ! empty($decor_images_left[3]) ) : ?>
        <div class="animate-card-smooth [animation-delay:550ms] h-[160px] w-[160px] 2xl:h-[210px] 2xl:w-[210px] 3xl:h-[280px] 3xl:w-[280px] max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 rounded-2xl overflow-hidden shadow-lg -translate-x-[60%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_left, 3); ?>
            </picture>
        </div>
        <?php endif; ?>
    </div>


    <div class="hidden lg:block space-y-4 2xl:space-y-8 3xl:space-y-12 pt-[145px] 2xl:pt-[160px] 3xl:pt-[230px]">
        <?php if ( ! empty($decor_images_left[4]) ) : ?>
        <div class="animate-card-smooth [animation-delay:200ms] h-20 w-20 2xl:h-[140px] 2xl:w-[140px] 3xl:h-[150px] 3xl:w-[150px] max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 rounded-2xl overflow-hidden shadow-lg -translate-x-[100%] 2xl:-translate-x-[70%] 3xl:-translate-x-[100%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_left, 4); ?>
            </picture>
        </div>
        <?php endif; ?>

        <?php if ( ! empty($decor_images_left[5]) ) : ?>
        <div class="animate-card-smooth [animation-delay:350ms] h-[120px] w-[120px] 2xl:h-[150px] 2xl:w-[150px] 3xl:h-[200px] 3xl:w-[200px] max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 rounded-2xl overflow-hidden shadow-lg -translate-x-[85%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_left, 5); ?>
            </picture>
        </div>
        <?php endif; ?>
    </div>

    <div class="hidden lg:block space-y-4 2xl:space-y-8 3xl:space-y-12 pt-[240px] 2xl:pt-[330px] 3xl:pt-[430px]">
        <?php if ( ! empty($decor_images_left[6]) ) : ?>
        <div class="animate-card-smooth [animation-delay:50ms] h-[90px] w-[90px] 2xl:h-[100px] 2xl:w-[100px] 3xl:h-40 3xl:w-40 max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 rounded-2xl overflow-hidden shadow-lg -translate-x-[120%] 2xl:-translate-x-[140%] 3xl:-translate-x-[110%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_left, 6); ?>
            </picture>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

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
                    class="w-full py-4 pl-12 pr-6 bg-[#F2F2F2] dark:bg-[#232125] rounded-full"
                >
            </div>
        </form>
        <?php endif; ?>
    </div>

<?php if ( ! empty($decor_images_right) ) : ?>
<div class="absolute right-0 top-1/2 -translate-y-1/2 grid grid-cols-[repeat(4,min-content)] gap-6 2xl:gap-10 w-max pointer-events-none items-start">
    
    <div class="hidden lg:block space-y-4 2xl:space-y-8 3xl:space-y-12 pt-[145px] 2xl:pt-[200px] 3xl:pt-[230px]">
        <?php if ( ! empty($decor_images_right[6]) ) : ?>
        <div class="animate-card-right [animation-delay:50ms] h-20 w-20 2xl:h-[100px] 2xl:w-[100px] 3xl:h-[150px] 3xl:w-[150px] max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 dark:shadow-[0_0_20px_rgba(0,0,0,0.5)] rounded-2xl overflow-hidden shadow-lg translate-x-[140%] 2xl:translate-x-[170%] 3xl:translate-x-[140%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_right, 6); ?>
            </picture>
        </div>
        <?php endif; ?>
    </div>

    <div class="hidden lg:block space-y-4 2xl:space-y-8 3xl:space-y-12 pt-[125px] 2xl:pt-[160px] 3xl:pt-[200px]">
        <?php if ( ! empty($decor_images_right[5]) ) : ?>
        <div class="animate-card-right [animation-delay:200ms] h-[100px] w-[100px] 2xl:h-[140px] 2xl:w-[140px] 3xl:h-[180px] 3xl:w-[180px] max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 dark:shadow-[0_0_20px_rgba(0,0,0,0.5)] rounded-2xl overflow-hidden shadow-lg translate-x-[110%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_right, 5); ?>
            </picture>
        </div>
        <?php endif; ?>

        <?php if ( ! empty($decor_images_right[4]) ) : ?>
        <div class="animate-card-right [animation-delay:350ms] h-[120px] w-[120px] 2xl:h-[150px] 2xl:w-[150px] 3xl:h-[200px] 3xl:w-[200px] max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 dark:shadow-[0_0_20px_rgba(0,0,0,0.5)] rounded-2xl overflow-hidden shadow-lg translate-x-[85%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_right, 4); ?>
            </picture>
        </div>
        <?php endif; ?>
    </div>

    <div class="hidden md:block space-y-4 2xl:space-y-8 3xl:space-y-12 pt-24 2xl:pt-32 3xl:pt-40">
        <?php if ( ! empty($decor_images_right[3]) ) : ?>
        <div class="animate-card-right [animation-delay:400ms] h-32 w-32 2xl:h-44 2xl:w-44 3xl:h-56 3xl:w-56 max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 dark:shadow-[0_0_20px_rgba(0,0,0,0.5)] rounded-2xl overflow-hidden shadow-lg md:translate-x-[100%] lg:translate-x-[75%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_right, 3); ?>
            </picture>
        </div>
        <?php endif; ?>

        <?php if ( ! empty($decor_images_right[2]) ) : ?>
        <div class="animate-card-right [animation-delay:550ms] h-[160px] w-[160px] 2xl:h-[210px] 2xl:w-[210px] 3xl:h-[280px] 3xl:w-[280px] max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 dark:shadow-[0_0_20px_rgba(0,0,0,0.5)] rounded-2xl overflow-hidden shadow-lg md:translate-x-[100%] lg:translate-x-[60%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_right, 2); ?>
            </picture>
        </div>
        <?php endif; ?>
    </div>

    <div class="space-y-4 2xl:space-y-8 3xl:space-y-12 mt-8 2xl:mt-12 3xl:mt-16">
        <?php if ( ! empty($decor_images_right[1]) ) : ?>
        <div class="animate-card-right [animation-delay:600ms] h-48 w-48 2xl:h-64 2xl:w-64 3xl:h-80 3xl:w-80 max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 dark:shadow-[0_0_20px_rgba(0,0,0,0.5)] rounded-2xl overflow-hidden shadow-lg translate-x-[50%] lg:translate-x-[30%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_right, 1); ?>
            </picture>
        </div>
        <?php endif; ?>

        <?php if ( ! empty($decor_images_right[0]) ) : ?>
        <div class="animate-card-right [animation-delay:750ms] h-48 w-48 2xl:h-64 2xl:w-64 3xl:h-80 3xl:w-80 max-w-full bg-gray-200 dark:bg-white/5 dark:border dark:border-white/10 dark:shadow-[0_0_20px_rgba(0,0,0,0.5)] rounded-2xl overflow-hidden shadow-lg lg:translate-x-[50%] translate-x-[80%] backdrop-blur-sm">
            <picture class="block w-full h-full">
                <?php render_decor_image($decor_images_right, 0); ?>
            </picture>
        </div>
        <?php endif; ?>
    </div>

</div>
<?php endif; ?>

</section>

<?php
});