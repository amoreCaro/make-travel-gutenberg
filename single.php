<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id = get_the_ID();


// Categories
$categories = get_the_category();

// Content
$title   = get_the_title();
$date    = get_the_date( 'F j, Y' );
$excerpt = has_excerpt() ? get_the_excerpt() : '';
$read_time = estimate_post_read_time($post_id);
$like = get_post_like_state($post_id);
$is_saved = get_post_save_state($post_id);


// Author
$author_id = get_post_field('post_author', get_the_ID());
$avatar_url = get_avatar_url($author_id, ['size' => 48]);
$display_name = get_the_author_meta('display_name', $author_id);
$share_url   = urlencode(get_permalink());
$share_title = urlencode(get_the_title());

// the_content
$content = apply_filters( 'the_content', get_the_content() );

// tags
$tags = get_the_tags();

$coaddedmments = get_comments([
    'post_id' => get_the_ID(),
    'status'  => 'approve'
]);
$comments_num = get_comments_number(get_the_ID());

$author_url = $author_id ? get_author_posts_url($author_id) : '';
get_header();

?>

<main class="main">
    <!-- Single Post -->
    <div class="single-post">
        <div class="pt-[80px]  lg:pb-[100px] pb-[50px] bg-white dark:bg-black">
            <div class="container mx-auto relative 2xl:max-w-[1152px] xl:px-[0px] lg:px-[40px] px-[20px]">
                <div class="container mx-auto relative">
                    <?php require PATH . "/components/breadcrumbs/component.php"; ?>
                </div>
            </div>

            <div class="container mx-auto relative 2xl:max-w-[1152px] xl:px-[0px] lg:px-[40px] px-[20px]">
                <!-- Content -->
                <div class="mx-auto max-w-[800px] flex flex-col gap-5 pb-[50px] lg:pb-[100px] xl:pl-[0px]">
                    <?php
                    if ( ! empty( $categories ) ) : ?>
                        <div class="post__categories flex flex-wrap gap-2">

                            <?php foreach ( $categories as $category ) : 
                                $category_link = esc_url( get_category_link( $category->term_id ) );
                                $icon_url = carbon_get_term_meta( $category->term_id, 'category_svg' );
                                $icon_svg = '';

                                if ( $icon_url ) {
                                    $upload_dir = wp_get_upload_dir();
                                    $file_path = str_replace(
                                        $upload_dir['baseurl'],
                                        $upload_dir['basedir'],
                                        $icon_url
                                    );

                                    if ( file_exists( $file_path ) && pathinfo( $file_path, PATHINFO_EXTENSION ) === 'svg' ) {
                                        $icon_svg = file_get_contents( $file_path );
                                    }
                                }
                            ?>
                                <a
                                    href="<?php echo $category_link; ?>"
                                    class="category-chip flex items-center gap-2 rounded-full border border-[#E5E7EB] dark:border-white/20 px-4 py-1.5 text-[#374151] dark:text-white dark:bg-transparent transition-all duration-300 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black max-w-[200px] w-fit"
                                >

                                    <?php if ( $icon_svg ) : ?>
                                        <?php
                                            $icon_svg = preg_replace('/(width|height)=".*?"/', '', $icon_svg);
                                            $icon_svg = preg_replace('/fill=".*?"/', 'fill="currentColor"', $icon_svg);
                                            $icon_svg = preg_replace('/stroke=".*?"/', 'stroke="currentColor"', $icon_svg);
                                            $icon_svg = str_replace('<svg', '<svg class="w-4 h-4 flex-shrink-0"', $icon_svg);

                                            echo $icon_svg;
                                        ?>
                                    <?php endif; ?>

                                    <span class="text-xs font-medium leading-[16px] truncate">
                                        <?php echo esc_html( $category->name ); ?>
                                    </span>

                                </a>
                            <?php endforeach; ?>

                        </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $title ) ) : ?>
                        <h1 class="post__title text-black dark:text-white text-[30px] leading-[38px] md:text-[44px] md:leading-[52px] lg:text-[56px] lg:leading-[64px]">
                            <?php echo esc_html( $title ); ?>
                        </h1>
                    <?php endif; ?>

                    <?php if ( ! empty( $excerpt ) ) : ?>
                        <p class="post__excerpt text-[#374151] dark:text-[#C2C2C2] font-light text-[18px] leading-[36px] py-[18px]">
                            <?php echo esc_html( $excerpt ); ?>
                        </p>
                    <?php endif; ?>
                    <div class="w-full border-b border-neutral-200 dark:border-neutral-700"></div>

                    <div class="flex justify-between">

                        <?php if ( ! empty( $date ) ) : ?>
                            <div class="flex items-center gap-4">
                                <time 
                                    class="post__date text-black dark:text-white text-[16px] leading-[16px] font-normal" 
                                    datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                    <?php echo esc_html( $date ); ?>
                                </time>
                                <span class="post__read-time relative pl-4 dark:text-white before:content-['•'] before:absolute before:left-0  text-black dark:before:text-white">
                                    <?php echo esc_html($read_time); ?> min read
                                </span>
                            </div>
                        <?php endif; ?>
                        <div class="flex justify-between items-center relative ">
    
                            <div class="flex items-center gap-2">
                                <button
                                    class="post__like group/btn relative h-9 pe-3 shrink-0 rounded-full flex items-center gap-2 select-none transition-colors duration-200
                                    <?php echo ($like['liked'] ?? false) ? 'is-active' : ''; ?>"
                                    data-post-id="<?php echo esc_attr($post_id); ?>"
                                >
                                    <div class="post__like-bg w-[36px] h-9 rounded-full flex items-center justify-center pointer-events-none
                                        bg-[#F6F5F8] dark:bg-[#1E1E26]
                                        text-black dark:text-white
                                        transition-colors duration-200
                                        
                                        group-hover/btn:bg-[#FFF1F2]
                                        dark:group-hover/btn:bg-[#2A2A36]
                                        group-hover/btn:text-[#FF2157]
                                        
                                        group-[.is-active]/btn:bg-[#FFF1F2]
                                        dark:group-[.is-active]/btn:bg-[#2A2A36]
                                        group-[.is-active]/btn:text-[#FF2157]">
    
                                        <svg class="h-[18px] w-[18px] text-current transition-colors duration-200 group-[.is-active]/btn:hidden"
                                            viewBox="0 0 24 24" fill="none">
                                            <path d="M19.4626 3.99415C16.7809 2.34923 14.4404 3.01211 13.0344 4.06801C12.4578 4.50096 12.1696 4.71743 12 4.71743C11.8304 4.71743 11.5422 4.50096 10.9656 4.06801C9.55962 3.01211 7.21909 2.34923 4.53744 3.99415C1.01807 6.15294 0.221721 13.2749 8.33953 19.2834C9.88572 20.4278 10.6588 21 12 21C13.3412 21 14.1143 20.4278 15.6605 19.2834C23.7783 13.2749 22.9819 6.15294 19.4626 3.99415Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
    
                                        <svg class="hidden h-[18px] w-[18px] text-current transition-colors duration-200 group-[.is-active]/btn:block"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M19.4626 3.99415C16.7809 2.34923 14.4404 3.01211 13.0344 4.06801C12.4578 4.50096 12.1696 4.71743 12 4.71743C11.8304 4.71743 11.5422 4.50096 10.9656 4.06801C9.55962 3.01211 7.21909 2.34923 4.53744 3.99415C1.01807 6.15294 0.221721 13.2749 8.33953 19.2834C9.88572 20.4278 10.6588 21 12 21C13.3412 21 14.1143 20.4278 15.6605 19.2834C23.7783 13.2749 22.9819 6.15294 19.4626 3.99415Z"/>
                                        </svg>
                                    </div>
    
                                    <span class="post__like-text text-[12px] leading-[12px]
                                        text-black dark:text-white
                                        group-hover/btn:text-[#FF2157]
                                        group-[.is-active]/btn:text-[#FF2157]
                                        font-medium transition-colors duration-200">
                                            <?php echo (int) $like['count']; ?>
                                    </span>
                                </button>
    
                                <button
                                    class="group/comment relative h-9 pe-3 shrink-0 rounded-full transition-colors duration-200 cursor-default flex items-center gap-2 bg-transparent select-none"
                                    onclick="
                                        event.preventDefault();
                                        event.stopPropagation();
                                        
                                        const isActive = this.classList.toggle('is-active');
                                        const bgCircle = this.querySelector('.icon-bg-circle');
                                        const countText = this.querySelector('.count-text');
                                        const iconSvg = this.querySelector('.icon-comment-svg');
                                        
                                        if (isActive) {
                                            bgCircle.classList.remove('bg-[#F6F5F8]', 'dark:bg-[#1E1E26]', 'group-hover/comment:bg-[#E6F4F3]', 'dark:group-hover/comment:bg-[#2A2A36]');
                                            bgCircle.classList.add('bg-[#E6F4F3]', 'dark:bg-[#2A2A36]');
                                            iconSvg.classList.remove('text-black', 'dark:text-white', 'group-hover/comment:text-[#009689]');
                                            iconSvg.classList.add('text-[#009689]');
    
                                            countText.classList.remove('text-black', 'dark:text-white', 'group-hover/comment:text-[#009689]');
                                            countText.classList.add('text-[#009689]');
                                            window.location.href = '<?php echo esc_url(get_permalink($post_id) . '#comments'); ?>';
                                        } else {
                                            bgCircle.classList.add('bg-[#F6F5F8]', 'dark:bg-[#1E1E26]', 'group-hover/comment:bg-[#E6F4F3]', 'dark:group-hover/comment:bg-[#2A2A36]');
                                            bgCircle.classList.remove('bg-[#E6F4F3]', 'dark:bg-[#2A2A36]');
                                            
                                            iconSvg.classList.add('text-black', 'dark:text-white', 'group-hover/comment:text-[#009689]');
                                            iconSvg.classList.remove('text-[#009689]');
                                            
                                            countText.classList.add('text-black', 'dark:text-white', 'group-hover/comment:text-[#009689]');
                                            countText.classList.remove('text-[#009689]');
                                        }
                                    "
                                >
                                    <div class="icon-bg-circle w-[36px] h-9 rounded-full bg-[#F6F5F8] dark:bg-[#1E1E26] group-hover/comment:bg-[#E6F4F3] dark:group-hover/comment:bg-[#2A2A36] transition-colors duration-200 flex items-center justify-center pointer-events-none">
                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            viewBox="0 0 24 24" 
                                            fill="none" 
                                            class="icon-comment-svg h-[18px] w-[18px] text-black dark:text-white group-hover/comment:text-[#009689] transition-colors duration-200">
                                            <path d="M8 13.5H16M8 8.5H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M6.09881 19C4.7987 18.8721 3.82475 18.4816 3.17157 17.8284C2 16.6569 2 14.7712 2 11V10.5C2 6.72876 2 4.84315 3.17157 3.67157C4.34315 2.5 6.22876 2.5 10 2.5H14C17.7712 2.5 19.6569 2.5 20.8284 3.67157C22 4.84315 22 6.72876 22 10.5V11C22 14.7712 22 16.6569 20.8284 17.8284C19.6569 19 17.7712 19 14 19C13.4395 19.0125 12.9931 19.0551 12.5546 19.155C11.3562 19.4309 10.2465 20.0441 9.14987 20.5789C7.58729 21.3408 6.806 21.7218 6.31569 21.3651C5.37769 20.6665 6.29454 18.5019 6.5 17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                    </div>
    
                                    <span class="count-text text-[12px] leading-[12px] text-black dark:text-white group-hover/comment:text-[#009689] font-medium transition-colors duration-200 pointer-events-none">
                                        <?php echo esc_html( $comments_num ); ?>
                                    </span>
                                </button>

                                <button
                                    class="post__save <?php echo $is_saved ? 'is-active' : '' ?> group/btn relative w-9 h-9 shrink-0 rounded-full transition-colors duration-200 cursor-default flex items-center justify-center bg-transparent select-none"
                                    data-post-id="<?php echo esc_attr($post_id); ?>"
                                >
                                    <div class="icon-bg-circle w-9 h-9 rounded-full transition-colors duration-200 flex items-center justify-center pointer-events-none
                                        bg-[#F9FAFB] dark:bg-[#2A2A36]
                                        group-hover/btn:bg-[#F3F4F6]
                                        dark:group-hover/btn:bg-[#3F3F50]
                                        
                                        group-[.is-active]/btn:bg-[#F3F4F6]
                                        dark:group-[.is-active]/btn:bg-[#3F3F50]">
    
                                        <!-- OUTLINE ICON -->
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            class="icon-outline h-[18px] w-[18px] text-black dark:text-white transition-colors duration-200
                                                group-[.is-active]/btn:hidden"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="M6 3h12a1 1 0 0 1 1 1v18l-7-4-7 4V4a1 1 0 0 1 1-1z"/>
                                        </svg>
    
                                        <!-- FILLED ICON -->
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            class="icon-filled hidden h-[18px] w-[18px] text-[#374151] dark:text-[#E5E7EB] transition-colors duration-200
                                                group-[.is-active]/btn:block"
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
            </div>

                <?php render_media_block($post->ID); ?>

            <div class="post__article max-w-[800px] mx-auto pb-[50px] lg:pb-[100px] px-[20px] lg:px-[0px]">
                
                <?php 
                    if ( ! empty( $content ) ) : ?>
                        <article class="h-article mb-12">
                            <!-- Article -->
                            <?php echo $content; ?>
                        </article>
                    <?php endif; ?>
                    <?php
                        // Tags
                        if (isset( $tags ) && !empty($tags)) : ?>
                            <div class="post__tags flex flex-wrap gap-2 mx-auto mb-12">
                                <?php foreach ($tags as $tag) : 
                                    $tag_link = get_term_link($tag); 
                                    if (is_wp_error($tag_link)) continue;
                                ?>
                                    <a href="<?php echo esc_url($tag_link); ?>"
                                    class="font-medium text-[12px] leading-[12px] uppercase p-2 text-[#9395ab]/80 border border-[#9395ab] transition-colors hover:text-blue-400 hover:border-blue-400">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                <div class="post__author flex flex-col md:flex-row justify-between md:items-center text-white max-w-[800px] mx-auto">
                    <div class="post__author-name flex gap-3 mb-8 md:mb-0">
                        <div class="flex items-center gap-3">
                            <?php if ( $avatar_url ) : ?>
                                <div class="post__author-name-img shrink-0">
                                    <picture class="block w-full h-full">
                                        <img 
                                            src="data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23cccccc'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E" 
                                            data-src="<?php echo esc_url($avatar_url); ?>" 
                                            alt="<?php echo esc_attr($display_name); ?>" 
                                            width="48" 
                                            height="48" 
                                            loading="lazy" 
                                            decoding="async"
                                            class="lazy-img w-12 h-12 rounded-full object-cover bg-[#f5f5f5]"
                                        >
                                    </picture>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="post__author-name-txt flex flex-col">
                            <span class="text-black dark:text-white text-[16px] leading-[26px] font-semibold"><?php echo esc_html($display_name); ?></span>
                            <time class="text-[#c2c5c9] text-[13px] leading-[16px] font-bold" datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </div>
                    </div>


                    <div class="post__author-share items-center flex gap-3">
                        <span class="text-black dark:text-white  text-[16px] leading-[26px] font-semibold">
                            <?php echo esc_html__( "Share", THEME ); ?>
                        </span>
                    <div class="flex gap-2 text-black dark:text-white items-center">

                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>"
                        target="_blank" rel="nofollow"
                        class="flex items-center justify-center w-[32px] h-[32px]">

                            <svg width="20" height="20" viewBox="0 0 16 16"
                                class="fill-current transition-colors duration-200"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 8C16 3.6 12.4 0 8 0C3.6 0 0 3.6 0 8C0 12 2.9 15.3 6.7 15.9V10.3H4.7V8H6.7V6.2C6.7 4.2 7.9 3.1 9.7 3.1C10.6 3.1 11.5 3.3 11.5 3.3V5.3H10.5C9.5 5.3 9.2 5.9 9.2 6.5V8H11.4L11 10.3H9.1V16C13.1 15.4 16 12 16 8Z"/>
                            </svg>
                        </a>

                        <!-- Twitter -->
                        <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>"
                        target="_blank" rel="nofollow"
                        class="flex items-center justify-center w-[32px] h-[32px]">

                            <svg width="20" height="20" viewBox="0 0 20 20"
                                class="fill-current transition-colors duration-200"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.70409 10.9364L0.0486662 0H6L10.9677 7.09678L17 0H20L12.3224 9.03246L20 20H14.0487L9.05906 12.8717L3 20H0L7.70409 10.9364ZM4.35459 1.37629H3.62057L15.6937 18.6237H16.4278L4.35459 1.37629Z"/>
                            </svg>
                        </a>

                        <!-- LinkedIn -->
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>"
                        target="_blank" rel="nofollow"
                        class="flex items-center justify-center w-[32px] h-[32px]">

                            <svg width="20" height="20" viewBox="0 0 19 19"
                                class="fill-current transition-colors duration-200"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.56602 18.0003H0.882679V6.40866H4.56602V18.0003ZM2.72435 4.78366C1.53268 4.78366 0.666016 3.91699 0.666016 2.72533C0.666016 1.53366 1.64102 0.666992 2.72435 0.666992C3.91602 0.666992 4.78269 1.53366 4.78269 2.72533C4.78269 3.91699 3.91602 4.78366 2.72435 4.78366ZM17.9993 18.0003H14.316V11.717C14.316 9.87533 13.5577 9.33366 12.4743 9.33366C11.391 9.33366 10.3077 10.2003 10.3077 11.8253V18.0003H6.62435V6.40866H10.091V8.03366C10.416 7.27533 11.716 6.08366 13.5577 6.08366C15.616 6.08366 17.7827 7.27533 17.7827 10.8503V18.0003H17.9993Z"/>
                            </svg>
                        </a>

                    </div>
                    </div>
                </div>
            </div>

            <section id="comments" class="mx-auto max-w-[800px] px-[20px] lg:px-[0px] py-10 scroll-mt-10 sm:scroll-mt-20 font-sans antialiased text-gray-900 dark:text-gray-100 selection:bg-teal-500/10">
                
                <div class="flex items-center justify-between border-b  dark:border-[#27272A] pb-5 mb-8">
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-2xl">
                            <?php _e("Discussion", THEME); ?>
                        </h3>
                        <span class="inline-flex items-center justify-center bg-blue-400 text-white text-xs font-semibold px-4 py-1 rounded-full">
                            <?php echo esc_html( $comments_num ); ?>
                        </span>
                    </div>
                </div>
                
                <div class="mb-10 flex gap-4">
                    <div class="hidden sm:block h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gray-200 dark:bg-zinc-800">
                        <img src="<?php echo esc_url($avatar_url); ?>" data-src="<?php echo esc_url($avatar_url); ?>"  alt="Your Avatar" class="h-full w-full object-cover">
                    </div>
                    
                    <form id="comments__form" data-post="<?php echo get_the_ID(); ?>" class="flex-1 group">
                        <div class="relative rounded-2xl border border-gray-200 dark:border-zinc-800 bg-white dark:bg-zinc-900/40 shadow-sm dark:shadow-none transition-all duration-200 focus-within:border-blue-600 focus-within:ring-4 focus-within:ring-teal-500/5 dark:focus-within:ring-teal-500/10">
                            
                            <textarea 
                                name="comment_text"
                                class="block w-full rounded-2xl border-0 bg-transparent p-4 text-base text-gray-800 dark:text-zinc-100 placeholder-gray-400 dark:placeholder-zinc-500 focus:ring-0 outline-none resize-none min-h-[110px]" 
                                rows="3" 
                                placeholder="Join the discussion..." 
                                required
                            ></textarea>
                            
                            <div class="flex items-center justify-end gap-2 px-4 pb-3 pt-2 border-t border-gray-50 dark:border-zinc-800/80 bg-gray-50/50 dark:bg-zinc-950/60 rounded-b-2xl">
                                <button
                                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 dark:border-zinc-700 bg-transparent hover:bg-gray-100 dark:hover:bg-zinc-800 text-sm font-semibold py-2 px-4 transition-colors cursor-pointer text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-200"
                                    type="button"
                                    id="cancel-comment-btn"
                                >
                                    <?php _e("Cancel", THEME); ?>
                                </button>
                                <button 
                                    class="inline-flex items-center justify-center rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 px-5 transition-all shadow-sm active:scale-[0.98] cursor-pointer" 
                                    type="submit"
                                >
                                    <?php _e("Send", THEME); ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


                    <ul id="comments__list" class="space-y-8">
                        <?php foreach ($comments as $comment): ?>

                            <?php
                            $children = get_comments([
                                'post_id' => get_the_ID(),
                                'status'  => 'approve',
                                'parent'  => $comment->comment_ID
                            ]);
                            ?>

                            <li class="relative group">
                                
                                <!-- vertical line -->
                                <div class="absolute left-5 top-12 bottom-0 w-[1px] bg-gradient-to-b from-gray-200 via-gray-200 to-transparent dark:from-gray-800 dark:via-gray-800"></div>

                                <!-- main comment -->
                                <div class="flex gap-4">

                                    <div class="relative h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800 shadow-sm">
                                        <?php echo get_avatar($comment, 40); ?>
                                    </div>

                                    <div class="flex-1 space-y-2">

                                        <div class="flex items-center gap-2 flex-wrap text-sm">
                                            <a href="<?php echo esc_url($author_url); ?>" class="cursor-pointer font-semibold text-base text-gray-900 dark:text-white hover:text-teal-600 dark:hover:text-teal-400 transition-colors">
                                                <?php echo esc_html($comment->comment_author); ?>
                                            </a>

                                            <span class="text-gray-300 dark:text-gray-700">·</span>

                                            <span class="text-gray-400 dark:text-gray-500">
                                                <?php echo human_time_diff(strtotime($comment->comment_date), current_time('timestamp')) . ' ago'; ?>
                                            </span>
                                        </div>

                                        <div class="text-base text-gray-700 dark:text-gray-300 leading-relaxed">
                                            <?php echo esc_html($comment->comment_content); ?>
                                        </div>

                                        <div class="pt-0.5 flex items-center gap-4">
                                            <button class="inline-flex items-center gap-1.5 font-semibold text-sm text-gray-400 dark:text-gray-500 hover:text-teal-600 dark:hover:text-teal-400 transition-colors cursor-pointer">
                                                <?php _e("Reply", THEME); ?>
                                            </button>
                                            <button class="inline-flex items-center gap-1.5 font-semibold text-sm text-gray-400 dark:text-gray-500 hover:text-teal-600 dark:hover:text-teal-400 transition-colors cursor-pointer">
                                                <?php _e("Edit", THEME); ?>
                                            </button>
                                            <button data-comment-id="<?php echo $comment->comment_ID; ?>"
                                                    class="comment__delete inline-flex items-center gap-1.5 font-semibold text-sm text-gray-400 dark:text-gray-500 hover:text-teal-600 dark:hover:text-teal-400 transition-colors cursor-pointer">
                                                <?php _e("Delete", THEME); ?>
                                            </button>
                                        </div>

                                    </div>
                                </div>

                                <!-- replies -->
                                <?php if (!empty($children)): ?>
                                    <ul class="mt-6 pl-10 sm:pl-14 space-y-6 relative">

                                        <?php foreach ($children as $child): ?>

                                            <li class="relative">

                                                <div class="absolute -left-[30px] sm:-left-[35px] top-0 h-6 w-5 rounded-bl-xl border-l border-b border-gray-200 dark:border-gray-800"></div>

                                                <div class="flex gap-3">

                                                    <div class="relative h-8 w-8 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800 shadow-sm">
                                                        <?php echo get_avatar($child, 32); ?>
                                                    </div>

                                                    <div class="flex-1 space-y-2">

                                                        <div class="flex items-center gap-2 text-sm">
                                                            <a class="font-semibold text-base text-gray-900 dark:text-white hover:text-teal-600 dark:hover:text-teal-400 transition-colors">
                                                                <?php echo esc_html($child->comment_author); ?>
                                                            </a>

                                                            <span class="text-gray-300 dark:text-gray-700">·</span>

                                                            <span class="text-gray-400 dark:text-gray-500">
                                                                <?php echo human_time_diff(strtotime($child->comment_date), current_time('timestamp')) . ' ago'; ?>
                                                            </span>
                                                        </div>

                                                        <div class="text-base text-gray-700 dark:text-gray-300 leading-relaxed">
                                                            <?php echo esc_html($child->comment_content); ?>
                                                        </div>

                                                        <div class="pt-0.5">
                                                            <button class="font-semibold text-sm text-gray-400 dark:text-gray-500 hover:text-teal-600 dark:hover:text-teal-400 transition-colors cursor-pointer">
                                                                <?php _e("Reply", THEME); ?>
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </li>

                                        <?php endforeach; ?>

                                    </ul>
                                <?php endif; ?>

                            </li>

                        <?php endforeach; ?>
                    </ul>


            </section>

            <?php require PATH . "/components/related-posts/component.php"; ?>
        </div>
    </div>

    <?php 
        // Video modal
        require PATH . "/components/video-modal/component.php";
        require PATH . "/components/burger-menu/component.php";
        require PATH . "/components/modal/component.php";
    ?>
</main>

<?php get_footer(); ?>