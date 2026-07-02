<?php
if (!defined('ABSPATH')) {
    exit;
}

$current_user = get_queried_object();
$username = $current_user->display_name;
$user_email = $current_user->user_email;
$author_id = $curauth->ID;

get_header();
?>

<main class="main">

    <div class="author py-[100px] bg-[#F6F5F8] dark:bg-[#0E0E10]">
        <div class="max-w-[800px] w-full mx-auto">

            <?php require PATH . "/components/breadcrumbs/component.php"; ?>

            <!-- AUTHOR HEADER -->
            <div class=" flex justify-between items-start mb-10 px-5 xl:px-10 2xl:px-0 py-5">
                <!-- Left Side: Avatar and Details -->
                <div class="flex items-center gap-6">
                    <div class="w-24 h-24 rounded-full overflow-hidden border border-neutral-200 dark:border-neutral-800 shrink-0">
                        <?php echo get_avatar($author_id, 96); ?>
                    </div>
                    
                    <div>
                        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">
                            <?php echo esc_html($username); ?>
                        </h1>
                        <p class="text-sm text-neutral-500 mt-1">
                            <?php echo esc_html($user_email); ?>
                        </p>
                    </div>
                </div>

                <a href="/edit-profile" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-[14px] leading-[14px] font-medium rounded-full text-neutral-900 border-2 border-neutral-900 hover:bg-neutral-900 hover:text-white transition-all dark:border-neutral-100 dark:text-white dark:hover:bg-white dark:hover:text-neutral-900 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                    </svg>
                    <span>Edit Profile</span>
                </a>
                
            </div>
        </div>
        <div class="container px-5 xl:px-10 2xl:px-0 py-5 border-t border-neutral-200 dark:border-neutral-800">

            <nav class="relative -mx-5 xl:-mx-10 2xl:mx-0">

                <!-- LEFT FADE + BUTTON -->
                <div class="absolute left-0 top-0 bottom-0 z-10 w-16 pointer-events-none
                            bg-gradient-to-r from-neutral-50 dark:from-neutral-950
                            via-neutral-50/90 dark:via-neutral-950/90 to-transparent
                            opacity-0 transition-opacity duration-300"
                    id="profileSubnavLeftFade"></div>

                <button
                    id="profileSubnavPrev"
                    class="absolute left-1.5 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full
                        bg-white dark:bg-neutral-900
                        border border-neutral-200 dark:border-neutral-800
                        shadow-[0_2px_8px_rgba(0,0,0,0.08)]
                        flex items-center justify-center opacity-0 pointer-events-none scale-90
                        transition-all duration-200 hover:scale-105 hover:shadow-[0_4px_12px_rgba(0,0,0,0.12)] active:scale-95">
                    <svg class="w-4 h-4 text-neutral-600 dark:text-neutral-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6"/>
                    </svg>
                </button>

                <!-- NAV LIST -->
                <ul
                    id="profileSubnavList"
                    class="flex items-center gap-1.5 overflow-x-auto scroll-smooth
                        px-5 xl:px-10 2xl:px-0
                        [&::-webkit-scrollbar]:hidden
                        [-ms-overflow-style:none]
                        [scrollbar-width:none]">

                    <?php
                    $subnav_items = [
                        'work'        => ['label' => 'My Posts',         'url' => home_url('/shots')],
                        'reviews'     => ['label' => 'Liked Shots',      'url' => home_url('/likes')],
                        'reading-list'    => ['label' => 'Reading list', 'url' => home_url('/reading-list')],

                    ];

                    $current_slug = 'work';
                    ?>

                    <?php foreach ($subnav_items as $slug => $item) : ?>
                        <li class="flex-none">
                            <a href="<?php echo esc_url($item['url']); ?>"
                            class="block whitespace-nowrap rounded-full px-4 py-2 font-semibold transition-all duration-200 text-[16px] leading-[18px]
                            <?php echo $slug === $current_slug
                                    ? 'bg-white dark:bg-[#23232C] text-neutral-900 dark:text-white'
                                    : 'dark:text-neutral-400 text-black hover:text-neutral-500 dark:hover:text-neutral-200'; ?>">
                                <?php echo esc_html($item['label']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>

                </ul>

                <!-- RIGHT FADE + BUTTON -->
                <div class="absolute right-0 top-0 bottom-0 z-10 w-16 pointer-events-none
                            bg-gradient-to-l from-neutral-50 dark:from-neutral-950
                            via-neutral-50/90 dark:via-neutral-950/90 to-transparent
                            opacity-0 transition-opacity duration-300"
                    id="profileSubnavRightFade"></div>

                <button
                    id="profileSubnavNext"
                    class="absolute right-1.5 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full
                        bg-white dark:bg-neutral-900
                        border border-neutral-200 dark:border-neutral-800
                        shadow-[0_2px_8px_rgba(0,0,0,0.08)]
                        flex items-center justify-center opacity-0 pointer-events-none scale-90
                        transition-all duration-200 hover:scale-105 hover:shadow-[0_4px_12px_rgba(0,0,0,0.12)] active:scale-95">
                    <svg class="w-4 h-4 text-neutral-600 dark:text-neutral-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/>
                    </svg>
                </button>

            </nav>
        </div>
        <!-- POSTS -->

        <div class="mt-12 container px-5 xl:px-10 2xl:px-0 py-5">

            <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-6">

                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <?php
                    $categories  = get_the_category(get_the_ID());
                    $category_id = !empty($categories) ? $categories[0]->term_id : null;

                    if ($category_id) {
                        $category_obj = get_term($category_id, 'category');

                        $icon_id  = carbon_get_term_meta($category_id, 'category_svg');
                        $icon_url = $icon_id ? wp_get_attachment_url($icon_id) : '';

                        $category_svg        = cf_get_inline_svg($icon_url);
                        $category_bg_color   = carbon_get_term_meta($category_id, 'category_bg');
                        $category_text_color = carbon_get_term_meta($category_id, 'category_text_color');
                        $category_decor_type = carbon_get_term_meta($category_id, 'category_decor_type');
                    } else {
                        $category_obj        = null;
                        $category_svg        = '';
                        $category_bg_color   = '';
                        $category_text_color = '';
                        $category_decor_type = '';
                    }

                    include PATH . '/components/bento/elements/default-item.php';
                    ?>

                <?php endwhile; else : ?>

                    <p class="text-neutral-500">No posts yet.</p>

                <?php endif; ?>

            </div>

        </div>

        <?php 
            require PATH . "/components/pagination/component.php";
            require PATH . "/components/burger-menu/component.php";
            require PATH . "/components/modal/component.php"; 
        ?>
    </div>
</main>

<?php get_footer(); ?>