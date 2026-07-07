<?php
if (!defined('ABSPATH')) {
    exit;
}

$page_title = get_the_title();

get_header();
?>

<main class="main">
    <div class="author py-[100px] dark:bg-[#0E0E10] text-[#1D1D1F] dark:text-[#F5F5F7] min-h-screen transition-colors duration-200 mx-auto px-5 xl:px-10 2xl:px-0">
        <div class="container">

            <h1 class="text-4xl font-bold">
                <?php echo esc_html($page_title); ?>
            </h1>

        </div>
    </div>
</main>

<?php get_footer(); ?>