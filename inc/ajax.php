<?php

if (!defined('ABSPATH')) exit;

add_action('wp_ajax_nopriv_register_user', 'handle_register_user');
add_action('wp_ajax_register_user', 'handle_register_user');

function handle_register_user() {
    if (!wp_verify_nonce($_POST['nonce'], 'register_user_nonce')) {
        wp_die();
    }

    $username = (isset($_POST['username']) && !empty($_POST['username'])) ? sanitize_user($_POST['username']) : '';
    $email = (isset($_POST['email']) && !empty($_POST['email'])) ? sanitize_email($_POST['email']) : '';
    $password = $_POST['password'] ?? '';
    $agree = isset($_POST['agree']) ? true : false;

    // Валідація
    if (empty($username)) {
        wp_send_json_error([
            'field' => 'username',
            'message' => 'Username is required'
        ]);
    }

    if (empty($email)) {
        wp_send_json_error([
            'field' => 'email',
            'message' => 'Email is required'
        ]);
    }

    if (empty($password)) {
        wp_send_json_error([
            'field' => 'password',
            'message' => 'Password is required'
        ]);
    }

    if (!$agree) {
        wp_send_json_error([
            'field' => 'agreeToTermsAndConditions',
            'message' => 'You must agree to terms and conditions'
        ]);
    }

    if (username_exists($username)) {
        wp_send_json_error([
            'field' => 'username',
            'message' => 'Username already exists'
        ]);
    }

    if (email_exists($email)) {
        wp_send_json_error([
            'field' => 'email',
            'message' => 'Email already exists'
        ]);
    }

    $user_id = wp_insert_user([
        'user_login' => $username,
        'user_email' => $email,
        'user_pass'  => $password,
        'role'       => 'subscriber'
    ]);

    // Перевірка помилки
    if (is_wp_error($user_id)) {
        wp_send_json_error([
            'message' => $user_id->get_error_message()
        ]);
    }

    wp_send_json_success([
        'message' => 'User created successfully',
        'user_id' => $user_id
    ]);

    wp_die();
}

add_action('wp_ajax_nopriv_login_user', 'handle_login_user');
add_action('wp_ajax_login_user', 'handle_login_user');

function handle_login_user() {

    if (!wp_verify_nonce($_POST['nonce'], 'login_user_nonce')) {
        wp_send_json_error([
            'message' => 'Invalid request'
        ]);
    }

    $username = sanitize_user($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = !empty($_POST['rememberMe']);

    if (empty($username)) {
        wp_send_json_error([
            'field' => 'username',
            'message' => 'Username is required'
        ]);
    }

    if (empty($password)) {
        wp_send_json_error([
            'field' => 'password',
            'message' => 'Password is required'
        ]);
    }

    $creds = [
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => $remember
    ];

    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        wp_send_json_error([
            'message' => 'Wrong username or password.'
        ]);
    }

    wp_set_current_user($user->ID);
    wp_set_auth_cookie($user->ID);

    wp_send_json_success([
        'message' => 'Login successful',
        'user' => [
            'id' => $user->ID,
            'name' => $user->display_name,
            'logged_in' => true,
        ]
    ]);
}