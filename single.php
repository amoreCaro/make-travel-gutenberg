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

<section id="comments" class="mx-auto max-w-3xl px-4 py-10 scroll-mt-10 sm:scroll-mt-20 font-sans antialiased text-gray-900 selection:bg-teal-500/10">
    
    <!-- Section Header -->
    <div class="flex items-center justify-between border-b border-gray-100 pb-5 mb-8">
        <div class="flex items-center gap-3">
            <h3 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                Discussion
            </h3>
            <span class="inline-flex items-center justify-center bg-gray-100 text-gray-600 text-xs font-semibold px-2.5 py-1 rounded-full">
                28
            </span>
        </div>
    </div>
    
    <!-- Modern comment form -->
    <div class="mb-10 flex gap-4">
        <div class="hidden sm:block h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gray-200">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop" alt="Your Avatar" class="h-full w-full object-cover">
        </div>
        
        <form action="#" class="flex-1 group">
            <div class="relative rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-200 focus-within:border-teal-500 focus-within:ring-4 focus-within:ring-teal-500/5">
                <textarea 
                    class="block w-full rounded-2xl border-0 bg-transparent p-4 text-sm text-gray-800 placeholder-gray-400 focus:ring-0 outline-none resize-none min-h-[100px]" 
                    rows="3" 
                    placeholder="Join the discussion..." 
                    required
                ></textarea>
                
                <!-- Toolbar -->
                <div class="flex items-center justify-end gap-2 px-4 pb-3 pt-2 border-t border-gray-50 bg-gray-50/50 rounded-b-2xl">
                    <button 
                        class="inline-flex items-center justify-center rounded-xl bg-transparent hover:bg-gray-200/60 text-gray-500 hover:text-gray-700 text-xs font-semibold py-2 px-4 transition-colors cursor-pointer" 
                        type="button"
                    >
                        Cancel
                    </button>
                    <button 
                        class="inline-flex items-center justify-center rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold py-2 px-5 transition-all shadow-sm active:scale-[0.98] cursor-pointer" 
                        type="submit"
                    >
                        Send
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Comments list -->
    <div class="space-y-8">
        <ul class="space-y-8">
            
            <!-- Main comment (Level 1) -->
            <li class="relative group">
                <div class="absolute left-5 top-12 bottom-0 w-[1px] bg-gradient-to-b from-gray-200 via-gray-200 to-transparent"></div>
                
                <div class="flex gap-4">
                    <div class="relative h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gray-100 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop" alt="Avatar" class="h-full w-full object-cover">
                    </div>
                    
                    <div class="flex-1 space-y-1.5">
                        <div class="flex items-center gap-2 flex-wrap">
                            <a href="#" class="font-semibold text-sm text-gray-900 hover:text-teal-600 transition-colors">Moderator</a>
                            <span class="inline-flex items-center rounded-md bg-teal-50 px-1.5 py-0.5 text-[10px] font-medium text-teal-700 ring-1 ring-inset ring-teal-600/10">Staff</span>
                            <span class="text-gray-300 text-xs">·</span>
                            <span class="text-xs text-gray-400">Today, 14:20</span>
                        </div>
                        
                        <div class="text-sm text-gray-600 leading-relaxed">
                            <p>Welcome to our new comment interface! We’ve fully redesigned it to make conversations cleaner and easier to read. How do you like the performance so far?</p>
                        </div>
                        
                        <div class="pt-1 flex items-center gap-4 text-xs">
                            <button class="inline-flex items-center gap-1.5 font-semibold text-gray-400 hover:text-teal-600 transition-colors cursor-pointer">
                                Reply
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Replies (Level 2) -->
                <ul class="mt-6 pl-10 sm:pl-14 space-y-6 relative">
                    <li class="relative">
                        <div class="absolute -left-[30px] sm:-left-[35px] top-0 h-6 w-5 rounded-bl-xl border-l border-b border-gray-200"></div>
                        
                        <div class="flex gap-3">
                            <div class="relative h-8 w-8 shrink-0 overflow-hidden rounded-full bg-gray-100 shadow-sm">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" alt="Avatar" class="h-full w-full object-cover">
                            </div>
                            
                            <div class="flex-1 space-y-1.5">
                                <div class="flex items-center gap-2">
                                    <a href="#" class="font-semibold text-sm text-gray-900 hover:text-teal-600 transition-colors">Alexander Kovalenko</a>
                                    <span class="text-gray-300 text-xs">·</span>
                                    <span class="text-xs text-gray-400">10 min ago</span>
                                </div>
                                
                                <div class="text-sm text-gray-600 leading-relaxed">
                                    <p>It’s insanely fast! Everything loads instantly on mobile, and the thread structure finally makes it easy to follow conversations. Great job!</p>
                                </div>
                                
                                <div class="pt-1 text-xs">
                                    <button class="font-semibold text-gray-400 hover:text-teal-600 transition-colors cursor-pointer">
                                        Reply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>

            <!-- Second comment -->
            <li class="relative pt-2">
                <div class="flex gap-4">
                    <div class="relative h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gray-100 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop" alt="Avatar" class="h-full w-full object-cover">
                    </div>
                    
                    <div class="flex-1 space-y-1.5">
                        <div class="flex items-center gap-2">
                            <a href="#" class="font-semibold text-sm text-gray-900 hover:text-teal-600 transition-colors">Dmytro</a>
                            <span class="text-gray-300 text-xs">·</span>
                            <span class="text-xs text-gray-400">Yesterday</span>
                        </div>
                        
                        <div class="text-sm text-gray-600 leading-relaxed">
                            <p>Is Markdown support or inline code formatting planned for the input field? That would be really useful for technical discussions.</p>
                        </div>
                        
                        <div class="pt-1 flex items-center gap-4 text-xs">
                            <button class="inline-flex items-center gap-1.5 font-semibold text-gray-400 hover:text-teal-600 transition-colors cursor-pointer">
                                Reply
                            </button>
                        </div>
                    </div>
                </div>
            </li>

        </ul>
    </div>
</section>

            <?php require PATH . "/components/related-posts/component.php"; ?>
        </div>
    </div>

    <?php 
        // Video modal
        require PATH . "/components/video-modal/component.php";
        require PATH . "/components/burger-menu/component.php";
    ?>
</main>

<?php get_footer(); ?>