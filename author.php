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
        <div class="max-w-[800px] w-full mx-auto  px-5 xl:px-10 2xl:px-0">

            <?php require PATH . "/components/breadcrumbs/component.php"; ?>

            <h1 class="mt-6 mb-8 text-4xl font-bold tracking-tight text-neutral-900 dark:text-white">
                Author
            </h1>

            <!-- AUTHOR HEADER -->
            <?php
            $args = [
                'username'   => $username,
                'user_email' => $user_email,
                'author_id'  => $author_id,
            ];

            require PATH . '/components/profile/component.php';
            ?>
        </div>
        <?php require PATH . '/components/profileSubnav/component.php'; ?>
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