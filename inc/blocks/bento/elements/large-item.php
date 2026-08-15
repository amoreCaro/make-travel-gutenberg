<?php
if (!defined('ABSPATH')) exit;

setup_postdata($post);

// Дані поста
$post_id     = $post->ID;
$placeholder = get_template_directory_uri() . '/assets/src/images/placeholder.png';

$title      = get_the_title($post_id);
$link       = get_permalink($post_id);
$thumbnail  = get_the_post_thumbnail_url($post_id, 'large') ?: $placeholder;
$excerpt    = get_the_excerpt($post_id);
$date       = get_the_date('', $post_id);

// Дані категорії
$categories = get_the_category($post_id);
$category_id = !empty($categories) ? $categories[0]->term_id : null;
$category_svg  = get_inline_svg_category_from_acf($category_id);
$category_name = get_cat_name($category_id);

$avatar_url = get_avatar_url($author_id, ['size' => 28]);
$username = get_the_author_meta('display_name', $author_id);
?>

<a href="<?php echo esc_url($link); ?>" 
   class="group lg:col-span-3 bg-white dark:bg-[#18181f] rounded-[24px] md:rounded-[32px] overflow-hidden flex flex-col lg:flex-row lg:min-h-[280px]">
    <div class="h-[300px] sm:h-[350px] lg:h-auto lg:w-[55%] overflow-hidden relative">
        <?php if (!empty($category_name)) : ?>
            <span class="top-4 left-4 z-10 absolute flex items-center gap-2 text-[12px] leading-[16px] font-medium capitalize px-5 py-1 rounded-full w-fit mb-4
                <?php echo $has_custom_style ? '' : 'border border-black dark:border-white text-black dark:text-white'; ?>"
            style="
                <?php if (!empty($category_bg_color)) echo 'background-color:' . esc_attr($category_bg_color) . ';'; ?>
                <?php if (!empty($category_text_color)) echo 'color:' . esc_attr($category_text_color) . ';'; ?>
            ">

                <?php if (!empty($category_svg)) : ?>
                    <span class="w-5 h-5 flex items-center justify-center [&>svg]:w-full [&>svg]:h-full [&>svg]:fill-current [&>svg]:stroke-current">
                        <?php echo $category_svg; ?>
                    </span>
                <?php endif; ?>

                <?php echo esc_html($category_name); ?>
            </span>
        <?php endif; ?>
        <picture class="block w-full h-full">
            <img 
                data-src="<?php echo esc_url($thumbnail); ?>" 
                src="<?php echo esc_url($thumbnail); ?>" 
                alt="<?php echo esc_attr($title); ?>" 
                loading="lazy"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            >
        </picture>

        <div class="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-r from-black/20 lg:from-black/10">
        </div>
    </div>

    <div class="lg:w-[45%] p-8 md:p-12 lg:p-12 flex flex-col text-black relative min-h-[300px] md:h-full">
<div class="flex flex-col h-full">
    <div class="flex items-center mb-4">
        <?php if ( $avatar_url ) : ?>
            <div class="post__author-name-img mr-2">
                <picture class="block w-full h-full">
                    <img 
                        src="data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23cccccc'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E" 
                        data-src="<?php echo esc_url($avatar_url); ?>" 
                        alt="<?php echo esc_attr($display_name); ?>" 
                        width="28" 
                        height="28" 
                        loading="lazy" 
                        decoding="async"
                        class="lazy-img w-[28px] h-[28px] rounded-full object-cover bg-[#f5f5f5]"
                    >
                </picture>
            </div>
        <?php endif; ?>
        <?php if ( $username ) : ?>
            <span class="block font-medium capitalize text-[12px] leading-[12px] text-[#404040] hover:text-black dark:text-[#d4d4d8] dark:hover:text-white">
                <?php echo esc_html( $username ); ?>
            </span>
        <?php endif; ?>
        <?php if (!empty($date)) : ?>
            <span class="mx-[6px] font-medium text-[#6C7280] dark:text-[#9DA3AF]">·</span>
            <time class="font-normal text-[12px] leading-[12px] text-[#6C7280] dark:text-[#9DA3AF]">
                <?php echo esc_html($date); ?>
            </time>
        <?php endif; ?>
    </div>
    
    <?php if (!empty($title)) : ?>
        <h4 style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" class="text-black dark:text-white text-[24px] font-semibold leading-[32px] mb-3">
            <?php echo esc_html($title); ?>
        </h4>
    <?php endif; ?>
    
    <?php if (!empty($excerpt)) : ?>
        <p style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"  class="text-[#373A39] dark:text-[#C4C4C4] text-[16px] leading-[24px] mb-4">
            <?php echo esc_html($excerpt); ?>
        </p>
    <?php endif; ?>

    <div class="flex justify-between items-center relative z-10 w-full mt-auto">
        <div class="flex gap-8">
        <button class="group text-black dark:text-white flex items-center hover:text-blue-400 dark:hover:text-blue-400 transition-colors duration-200 cursor-default"
                onclick="
                    event.preventDefault();
                    event.stopPropagation();

                    this.classList.toggle('is-active');

                    this.querySelector('.icon-outline').classList.toggle('hidden');
                    this.querySelector('.icon-filled').classList.toggle('hidden');
                ">
            <div style="width: 36px" class="bg-[#F6F5F8] dark:bg-[#1E1E26] rounded-full p-2 flex items-center justify-center w-9 h-9">
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    class="h-[18px] w-[18px] transition-colors"
                    fill="none">
                    <path
                        d="M19.4626 3.99415C16.7809 2.34923 14.4404 3.01211 13.0344 4.06801C12.4578 4.50096 12.1696 4.71743 12 4.71743C11.8304 4.71743 11.5422 4.50096 10.9656 4.06801C9.55962 3.01211 7.21909 2.34923 4.53744 3.99415C1.01807 6.15294 0.221721 13.2749 8.33953 19.2834C9.88572 20.4278 10.6588 21 12 21C13.3412 21 14.1143 20.4278 15.6605 19.2834C23.7783 13.2749 22.9819 6.15294 19.4626 3.99415Z"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                    />
                </svg>
            </div>

            <span class="ms-2 text-[12px] leading-[12px] transition-colors duration-200">
                3
            </span>
        </button>
        <button class="group text-black dark:text-white flex items-center hover:text-blue-400 dark:hover:text-blue-400 transition-colors duration-200">
            <div style="width: 36px" class="bg-[#F6F5F8] dark:bg-[#1E1E26] rounded-full p-2 flex items-center justify-center w-9 h-9">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="currentColor" fill="none" class="h-[18px] w-[18px]">
                <path d="M8 13.5H16M8 8.5H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M6.09881 19C4.7987 18.8721 3.82475 18.4816 3.17157 17.8284C2 16.6569 2 14.7712 2 11V10.5C2 6.72876 2 4.84315 3.17157 3.67157C4.34315 2.5 6.22876 2.5 10 2.5H14C17.7712 2.5 19.6569 2.5 20.8284 3.67157C22 4.84315 22 6.72876 22 10.5V11C22 14.7712 22 16.6569 20.8284 17.8284C19.6569 19 17.7712 19 14 19C13.4395 19.0125 12.9931 19.0551 12.5546 19.155C11.3562 19.4309 10.2465 20.0441 9.14987 20.5789C7.58729 21.3408 6.806 21.7218 6.31569 21.3651C5.37769 20.6665 6.29454 18.5019 6.5 17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            </svg>
            </div>

            <span class="ms-2 text-[12px] leading-[12px] transition-colors duration-200">
                3
            </span>
        </button>
        </div>

        <div class="flex items-center gap-2 relative">
            <span class="text-[12px] leading-[16px] text-black dark:text-[#D1D5DB] font-normal">4 min read</span>

            <button 
                class="group/btn relative w-9 h-9 shrink-0 rounded-full bg-[#F6F5F8] dark:bg-[#1E1E26] hover:bg-blue-500 dark:hover:bg-blue-500 transition-colors duration-200 cursor-default"
                onclick="
                    event.preventDefault();
                    event.stopPropagation();

                    this.classList.toggle('is-active');
                    this.classList.toggle('bg-blue-500');
                    this.classList.toggle('dark:bg-blue-500'); 
                    this.classList.toggle('dark:bg-[#1E1E26]'); 

                    this.querySelector('.icon-outline').classList.toggle('hidden');
                    this.querySelector('.icon-filled').classList.toggle('hidden');
                "
            >
                <div class="w-9 h-9 flex items-center justify-center pointer-events-none">
                    <svg 
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        class="icon-outline h-[18px] w-[18px] text-black stroke-current dark:text-white group-hover/btn:stroke-white transition-colors duration-200"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M6 3h12a1 1 0 0 1 1 1v18l-7-4-7 4V4a1 1 0 0 1 1-1z"/>
                    </svg>

                    <svg 
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        class="icon-filled hidden h-[18px] w-[18px] text-white transition-colors duration-200"
                        fill="currentColor"
                    >
                        <path d="M6 3h12a1 1 0 0 1 1 1v18l-7-4-7 4V4a1 1 0 0 1 1-1z"/>
                    </svg>
                </div>
            </button>
        </div>
    </div>
</div>
    </div>

</a>