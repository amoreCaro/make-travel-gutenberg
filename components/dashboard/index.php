<?php
if (!defined('ABSPATH')) {
    exit;
}

$page_slug = get_post_field('post_name', get_queried_object_id());
// dd($page_slug);exit;
switch ($page_slug) {

    case 'profile':
        require PATH . '/components/dashboard/templates/profile.php';
        break;

    case 'likes':
        require PATH . '/components/dashboard/templates/likes.php';
        break;
    case 'edit-profile':
        require PATH . '/components/dashboard/templates/edit-profile.php';
        break;


    case 'my-posts':
        require PATH . '/components/dashboard/templates/my-posts.php';
        break;

    case 'reading-list':
        require PATH . '/components/dashboard/templates/reading-list.php';
        break;

    case 'create-post':
        require PATH . '/components/dashboard/templates/create-post.php';
        break;



    default:
        require PATH . '/components/dashboard/templates/404.php';
        break;
}