<?php 
if (!defined('ABSPATH')) exit;

function post_get_likes_data($post_id) {
    return [
        'count' => (int) get_post_meta($post_id, 'likes_count', true),
        'users' => (array) get_post_meta($post_id, 'liked_users', true),
    ];
}

function post_user_liked($post_id, $user_id) {
    $users = (array) get_post_meta($post_id, 'liked_users', true);
    return in_array($user_id, $users);
}

function post_toggle_like_logic($post_id, $user_id) {

    $users = get_post_meta($post_id, 'liked_users', true);
    $users = is_array($users) ? $users : [];

    $count = (int) get_post_meta($post_id, 'likes_count', true);

    if (in_array($user_id, $users)) {

        $users = array_values(array_diff($users, [$user_id]));
        $count = max(0, $count - 1);

        $liked = false;

    } else {

        $users[] = $user_id;
        $count++;

        $liked = true;
    }

    update_post_meta($post_id, 'liked_users', $users);
    update_post_meta($post_id, 'likes_count', $count);

    return [
        'liked' => $liked,
        'count' => $count,
    ];
}

add_action('wp_ajax_post_like_toggle', 'post_like_toggle_ajax');
add_action('wp_ajax_nopriv_post_like_toggle', 'post_like_toggle_ajax');

function post_like_toggle_ajax() {

    // 🔒 login check
    if (!is_user_logged_in()) {
        wp_send_json_error([
            'message' => 'Not logged in'
        ], 401);
    }

    // 🔒 nonce check
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'post_like_nonce')) {
        wp_send_json_error([
            'message' => 'Invalid nonce'
        ], 403);
    }

    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $user_id = get_current_user_id();

    if (!$post_id) {
        wp_send_json_error(['message' => 'Invalid post ID'], 400);
    }

    $result = post_toggle_like_logic($post_id, $user_id);

    wp_send_json_success($result);
}