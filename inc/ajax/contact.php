<?php

if (!defined('ABSPATH')) exit;

add_action('wp_ajax_submit_contact_form', 'handle_submit_contact_form');
add_action('wp_ajax_nopriv_submit_contact_form', 'handle_submit_contact_form');

function handle_submit_contact_form() {

    if (!wp_verify_nonce($_POST['nonce'], 'submit_contact_nonce')) {
        wp_die();
    }

    $name = sanitize_text_field($_POST['name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');
    $website = sanitize_text_field($_POST['website'] ?? '');
    $page_id = absint($_POST['page_id'] ?? 0);

    if (!empty($website)) {
        wp_send_json_success([
            'message' => 'Message sent successfully'
        ]);
    }

    if (empty($name)) {
        wp_send_json_error([
            'field' => 'name',
            'message' => 'Name is required'
        ]);
    }

    if (empty($email) || !is_email($email)) {
        wp_send_json_error([
            'field' => 'email',
            'message' => 'Email is required'
        ]);
    }

    if (empty($message)) {
        wp_send_json_error([
            'field' => 'message',
            'message' => 'Message is required'
        ]);
    }

    $to = get_option('admin_email');

    $mail_subject = '[' . wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES) . '] New contact message from ' . $name;

    $body = "Name: {$name}\nEmail: {$email}\n\nMessage:\n{$message}\n\nPage: " . ($page_id ? get_permalink($page_id) : home_url('/'));

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>'
    ];

    $sent = wp_mail($to, $mail_subject, $body, $headers);

    if (!$sent) {
        wp_send_json_error([
            'message' => 'Failed to send message'
        ]);
    }

    wp_send_json_success([
        'message' => 'Message sent successfully'
    ]);
}
