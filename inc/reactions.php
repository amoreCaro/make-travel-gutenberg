<?php 
if (!defined('ABSPATH')) exit;


add_action('before_delete_post', 'theme_delete_post_reactions');
add_action('wp_trash_post', 'theme_delete_post_reactions');

function theme_delete_post_reactions($post_id) {
    global $wpdb;

    if (get_post_type($post_id) !== 'post') {
        return;
    }

    $table = $wpdb->prefix . 'post_reactions';

    $wpdb->delete(
        $table,
        ['post_id' => (int) $post_id],
        ['%d']
    );
}

add_action('after_switch_theme', 'theme_create_post_reactions_table');

function theme_create_post_reactions_table() {
    global $wpdb;

    $table = $wpdb->prefix . 'post_reactions';
    $charset_collate = $wpdb->get_charset_collate();

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $sql = "CREATE TABLE $table (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        post_id BIGINT UNSIGNED NOT NULL,
        user_id BIGINT UNSIGNED NOT NULL,
        type VARCHAR(20) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        KEY post_id (post_id),
        KEY user_id (user_id),
        KEY type (type)
    ) $charset_collate;";

    dbDelta($sql);

    $wpdb->query("
        ALTER TABLE $table
        DROP INDEX user_post
    ");

    $wpdb->query("
        ALTER TABLE $table
        ADD UNIQUE KEY user_post_type (post_id, user_id, type)
    ");
}

add_action('wp_ajax_toggle_like', 'toggle_like');
add_action('wp_ajax_nopriv_toggle_like', 'toggle_like');

function toggle_like() {

    global $wpdb;

    try {

        error_log('========== LIKE START ==========');

        $table = $wpdb->prefix . 'post_reactions';

        error_log('TABLE=' . $table);

        if (
            empty($_POST['nonce']) ||
            !wp_verify_nonce($_POST['nonce'], 'post_like_nonce')
        ) {

            error_log('NONCE FAILED');

            wp_send_json_error([
                'message' => 'Invalid nonce'
            ]);
        }

        error_log('NONCE OK');


        $post_id = absint($_POST['post_id'] ?? 0);
        $user_id = get_current_user_id();

        error_log('POST_ID=' . $post_id);
        error_log('USER_ID=' . $user_id);

        if (!$post_id) {

            error_log('INVALID POST');

            wp_send_json_error([
                'message' => 'Invalid post'
            ]);
        }

        if (!$user_id) {

            error_log('NOT LOGGED');

            wp_send_json_error([
                'message' => 'Not logged in'
            ]);
        }

        $type = 'like';


        $check_sql = $wpdb->prepare(
            "
            SELECT id
            FROM {$table}
            WHERE post_id=%d
            AND user_id=%d
            AND type=%s
            LIMIT 1
            ",
            $post_id,
            $user_id,
            $type
        );

        error_log('CHECK SQL=' . $check_sql);

        $existing = $wpdb->get_var($check_sql);

        error_log(
            'EXISTING=' .
            var_export($existing, true)
        );


        if ($existing) {

            $deleted = $wpdb->delete(
                $table,
                [
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'type' => $type
                ],
                [
                    '%d',
                    '%d',
                    '%s'
                ]
            );

            error_log(
                'DELETE=' .
                var_export($deleted, true)
            );

            error_log(
                'DELETE ERROR=' .
                $wpdb->last_error
            );

            $liked = false;

        } else {

            $insert = $wpdb->insert(
                $table,
                [
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'type' => $type,
                    'created_at' => current_time('mysql')
                ],
                [
                    '%d',
                    '%d',
                    '%s',
                    '%s'
                ]
            );

            error_log(
                'INSERT=' .
                var_export($insert, true)
            );

            error_log(
                'INSERT_ID=' .
                $wpdb->insert_id
            );

            error_log(
                'INSERT ERROR=' .
                $wpdb->last_error
            );

            if ($insert === false) {

                wp_send_json_error([
                    'message' => 'Insert failed',
                    'sql_error' => $wpdb->last_error
                ]);
            }

            $liked = true;
        }


        $count_sql = $wpdb->prepare(
            "
            SELECT COUNT(*)
            FROM {$table}
            WHERE post_id=%d
            AND type=%s
            ",
            $post_id,
            $type
        );

        error_log('COUNT SQL=' . $count_sql);

        $count = $wpdb->get_var($count_sql);

        error_log(
            'COUNT=' .
            var_export($count, true)
        );

        error_log(
            'COUNT ERROR=' .
            $wpdb->last_error
        );

        error_log('========== LIKE END ==========');

        wp_send_json_success([
            'liked' => $liked,
            'count' => (int)$count
        ]);

    } catch (Throwable $e) {

        error_log(
            'FATAL=' .
            $e->getMessage()
        );

        wp_send_json_error([
            'message' => $e->getMessage()
        ], 500);

    }

    wp_die();
}

function get_post_like_state($post_id)
{
    global $wpdb;

    $table = $wpdb->prefix . 'post_reactions';
    $user_id = get_current_user_id();

    $count = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*) FROM {$table} WHERE post_id=%d AND type=%s",
            $post_id,
            'like'
        )
    );

    $liked = false;

    if ($user_id) {
        $liked = (bool) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT 1 FROM {$table}
                 WHERE post_id=%d AND user_id=%d AND type=%s
                 LIMIT 1",
                $post_id,
                $user_id,
                'like'
            )
        );
    }

    return [
        'count' => $count,
        'liked' => $liked
    ];
}   

add_action('wp_ajax_toggle_save', 'toggle_save');
add_action('wp_ajax_nopriv_toggle_save', 'toggle_save');

function toggle_save() {
    global $wpdb;

    $table = $wpdb->prefix . 'post_reactions';

    // nonce
    if (
        empty($_POST['nonce']) ||
        !wp_verify_nonce($_POST['nonce'], 'post_save_nonce')
    ) {
        wp_send_json_error([
            'message' => 'Invalid nonce'
        ]);
    }

    $post_id = absint($_POST['post_id'] ?? 0);
    $user_id = get_current_user_id();

    if (!$post_id) {
        wp_send_json_error([
            'message' => 'Invalid post'
        ]);
    }

    if (!$user_id) {
        wp_send_json_error([
            'message' => 'Not logged in'
        ]);
    }

    $type = 'save';

    // check existing
    $existing = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT id
             FROM {$table}
             WHERE post_id = %d
             AND user_id = %d
             AND type = %s
             LIMIT 1",
            $post_id,
            $user_id,
            $type
        )
    );

    if ($existing) {

        $wpdb->delete(
            $table,
            [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'type' => $type
            ],
            ['%d', '%d', '%s']
        );

        $saved = false;

    } else {

        $insert = $wpdb->insert(
            $table,
            [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'type' => $type,
                'created_at' => current_time('mysql')
            ],
            ['%d', '%d', '%s', '%s']
        );

        if ($insert === false) {
            wp_send_json_error([
                'message' => 'Insert failed',
                'sql_error' => $wpdb->last_error
            ]);
        }

        $saved = true;
    }

    $count = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
             FROM {$table}
             WHERE post_id = %d
             AND type = %s",
            $post_id,
            $type
        )
    );

    wp_send_json_success([
        'saved' => $saved,
        'count' => $count
    ]);

    wp_die();
}

function get_post_save_state(int $post_id): bool
{
    if (!is_user_logged_in()) {
        return false;
    }

    global $wpdb;

    $table = $wpdb->prefix . 'post_reactions';
    $user_id = get_current_user_id();

    return (bool) $wpdb->get_var(
        $wpdb->prepare("
            SELECT id
            FROM $table
            WHERE user_id = %d
            AND post_id = %d
            AND type = %s
            LIMIT 1
        ", $user_id, $post_id, 'save')
    );
}

add_action('wp_ajax_load_liked_posts', 'load_liked_posts');

function load_liked_posts() {

    global $wpdb;

    $user_id = get_current_user_id();
    $offset = intval($_POST['offset'] ?? 0);

    $table = $wpdb->prefix . 'post_reactions';

    $liked_posts = $wpdb->get_col(
        $wpdb->prepare(
            "
            SELECT post_id
            FROM {$table}
            WHERE user_id = %d
            AND type = %s
            ORDER BY id DESC
            ",
            $user_id,
            'like'
        )
    );

    $liked_posts = array_slice(
        $liked_posts,
        $offset
    );

    $query = new WP_Query([
        'post_type' => 'post',
        'post__in' => !empty($liked_posts)
            ? $liked_posts
            : [0],
        'orderby' => 'post__in',
        'posts_per_page' => -1,
    ]);

    ob_start();

    while ($query->have_posts()) {
        $query->the_post();

        get_template_part(
            'components/bento/elements/default-item'
        );
    }

    wp_reset_postdata();

    wp_send_json_success([
        'html' => ob_get_clean(),
    ]);

}

add_action('wp_ajax_load_bookmarked_posts', 'load_bookmarked_posts');
add_action('wp_ajax_nopriv_load_bookmarked_posts', 'load_bookmarked_posts');

function load_bookmarked_posts() {

    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'not logged in']);
    }

    global $wpdb;

    $user_id = get_current_user_id();
    $offset  = intval($_POST['offset'] ?? 0);

    $table = $wpdb->prefix . 'post_reactions';

    $saved_posts = $wpdb->get_col(
        $wpdb->prepare("
            SELECT post_id
            FROM {$table}
            WHERE user_id = %d
            AND type = %s
            ORDER BY id DESC
        ", $user_id, 'save')
    );

    $saved_posts = array_slice($saved_posts, $offset);

    $query = new WP_Query([
        'post_type'      => 'post',
        'post__in'       => !empty($saved_posts) ? $saved_posts : [0],
        'orderby'        => 'post__in',
        'posts_per_page' => -1,
    ]);

    ob_start();

    while ($query->have_posts()) {
        $query->the_post();
        get_template_part('components/bento/elements/default-item');
    }

    wp_reset_postdata();

    wp_send_json_success([
        'html' => ob_get_clean(),
    ]);
}