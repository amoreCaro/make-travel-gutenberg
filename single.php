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

$author_url = $author_id ? get_author_posts_url($author_id) : '';
get_header();

?>

<main class="main">
    <!-- Single Post -->
    <div class="single-post">
        <div class="pt-[80px]  lg:pb-[100px] pb-[50px] bg-white dark:bg-black">
            <div class="container mx-auto relative  xl:px-[0px] lg:px-[40px] px-[20px]">
                
                <div class="container mx-auto relative 2xl:max-w-[1152px] xl:px-[0px] lg:px-[40px] px-[20px]">
                    <!-- Content -->
                    <div class="mx-auto max-w-[800px] flex flex-col gap-5 pb-[50px] lg:pb-[100px] xl:pl-[0px]">
                    <?php require PATH . "/components/breadcrumbs/component.php"; ?>
                    <?php if ( ! empty( $categories ) ) : ?>
                        <div class="post__categories flex flex-wrap gap-2">

                            <?php foreach ( $categories as $category ) :

                                $category_link = esc_url( get_category_link( $category->term_id ) );

                                $category_bg_color   = carbon_get_term_meta( $category->term_id, 'category_bg' );
                                $category_text_color = carbon_get_term_meta( $category->term_id, 'category_text_color' );

                                $svg_value = carbon_get_term_meta( $category->term_id, 'category_svg' );
                                $category_svg = '';

                                if ( $svg_value ) {
                                    $icon_url = is_numeric( $svg_value )
                                        ? wp_get_attachment_url( $svg_value )
                                        : $svg_value;

                                    if ( $icon_url ) {
                                        $category_svg = cf_get_inline_svg( $icon_url );
                                    }
                                }

                                $has_custom_style = ! empty( $category_bg_color ) || ! empty( $category_text_color );
                            ?>

                                <a
                                    href="<?php echo $category_link; ?>"
                                    class="category-chip flex items-center gap-2 rounded-full px-4 py-1.5 max-w-[200px] w-fit transition-all duration-300
                                        <?php echo $has_custom_style ? '' : 'border border-[#E5E7EB] dark:border-white/20 text-[#374151] dark:text-white dark:bg-transparent hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black'; ?>"
                                    style="
                                        <?php if ( ! empty( $category_bg_color ) ) : ?>
                                            background-color: <?php echo esc_attr( $category_bg_color ); ?>;
                                        <?php endif; ?>

                                        <?php if ( ! empty( $category_text_color ) ) : ?>
                                            color: <?php echo esc_attr( $category_text_color ); ?>;
                                        <?php endif; ?>
                                    "
                                >

                                    <?php if ( ! empty( $category_svg ) ) : ?>
                                        <span class="w-4 h-4 flex items-center justify-center [&>svg]:w-full [&>svg]:h-full [&>svg]:fill-current [&>svg]:stroke-current">
                                            <?php echo $category_svg; ?>
                                        </span>
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
                    <div class="w-full dark:border-neutral-700"></div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <?php if ( ! empty( $date ) ) : ?>
                            <div class="flex items-center gap-4 justify-between">
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