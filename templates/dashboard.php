<?php
/**
 * Template Name: Dashboard Page Template
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!is_user_logged_in()) {
    global $wp_query;

    $wp_query->set_404();
    require get_404_template();
    exit;
}
$current_user = wp_get_current_user();
$page_slug    = get_post_field('post_name', get_the_ID());

$page_title = get_the_title();
$excerpt    = get_the_excerpt();

get_header();
?>

<main class="main py-24">

    <div class="container">

        <?php require PATH . '/components/breadcrumbs/component.php'; ?>
        <?php get_template_part(
            'components/head/component',
        null,
        [
            'page_title' => $page_title,
            'excerpt'    => $excerpt,
        ]
    ); ?>

    </div>

    <?php require PATH . '/components/profileSubnav/component.php'; ?>

    <div class="container grid gap-8 items-start xl:grid-cols-[280px_minmax(0,1fr)]">
            <?php require PATH . '/components/account-sidebar/component.php'; ?>


            <main class="dashboard-content">
                <?php require PATH . '/components/dashboard/index.php'; ?>
            </main>

    </div>

</main>

<?php get_footer(); ?>