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
        $table = $wpdb->prefix . 'post_reactions';

        if ( empty ( $_POST['nonce'] ) || ! wp_verify_nonce ( $_POST['nonce'], 'post_like_nonce' ) ) {
            wp_die();
        }

        $post_id = absint($_POST['post_id'] ?? 0);
        $user_id = get_current_user_id();

        if ( ! $post_id ) {
            wp_send_json_error([ 'message' => 'Invalid post' ]);
            wp_die();
        }

        if ( ! $user_id ) {
            wp_send_json_error([ 'message' => 'Not logged in' ]);
            wp_die();
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

        $existing = $wpdb->get_var($check_sql);

        if ( $existing ) {

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

            if ( $insert === false ) {

                wp_send_json_error([
                    'message' => 'Insert failed',
                    'sql_error' => $wpdb->last_error
                ]);
                wp_die();
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

        $count = $wpdb->get_var($count_sql);

        wp_send_json_success([
            'liked' => $liked,
            'count' => (int)$count
        ]);

    } catch (Throwable $e) {
        
        wp_send_json_error([
            'message' => $e->getMessage()
        ], 500);
    }

    wp_die();
}

function get_post_like_state($post_id) {
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
    if ( empty ( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'post_save_nonce' ) ) {
        wp_die();
    }

    global $wpdb;

    $table = $wpdb->prefix . 'post_reactions';
    $post_id = absint($_POST['post_id'] ?? 0);
    $user_id = get_current_user_id();

    if ( ! $post_id ) {
        wp_send_json_error([
            'message' => 'Invalid post'
        ]);
        wp_die();
    }

    if ( ! $user_id ) {
        wp_send_json_error([
            'message' => 'Not logged in'
        ]);
        wp_die();
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

function get_post_save_state(int $post_id): bool {
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

add_action('wp_ajax_load_liked_posts', 'theme_load_liked_posts');

function theme_load_liked_posts() {

    if (!is_user_logged_in()) {
        wp_send_json_error([
            'message' => 'Not logged in',
        ]);

        wp_die();
    }

    global $wpdb;

    $user_id  = get_current_user_id();
    $offset   = intval($_POST['offset'] ?? 0);
    $per_page = 4;

    $table = $wpdb->prefix . 'post_reactions';

    $all_liked_posts = $wpdb->get_col(
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

    $total_posts = count($all_liked_posts);

    $liked_posts = array_slice(
        $all_liked_posts,
        $offset,
        $per_page
    );

    $query = new WP_Query([
        'post_type'      => 'post',
        'post__in'       => !empty($liked_posts) ? $liked_posts : [0],
        'orderby'        => 'post__in',
        'posts_per_page' => $per_page,
    ]);

    ob_start();

    while ($query->have_posts()) {
        $query->the_post();

        get_template_part(
            'components/bento/elements/default-item'
        );
    }

    wp_reset_postdata();

    $new_offset = $offset + $per_page;
    $has_more   = $new_offset < $total_posts;

    wp_send_json_success([
        'html'       => ob_get_clean(),
        'offset'     => $new_offset,
        'has_more'   => $has_more,
        'total'      => $total_posts,
        'per_page'   => $per_page,
    ]);
}
add_action('wp_ajax_load_bookmarked_posts', 'theme_load_bookmarked_posts');
add_action('wp_ajax_nopriv_load_bookmarked_posts', 'theme_load_bookmarked_posts');

function theme_load_bookmarked_posts() {

    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'not logged in']);
        wp_die();
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
        get_template_part('components/bento/elements/horizontal-item');
    }

    wp_reset_postdata();

    wp_send_json_success([
        'html' => ob_get_clean(),
    ]);
}

add_action('wp_ajax_submit_comment', 'theme_submit_comment');
add_action('wp_ajax_nopriv_submit_comment', 'theme_submit_comment');

function theme_submit_comment() {
    // nonce
    if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'submit_comment_nonce')) {
        wp_die();
    }

    if (!is_user_logged_in()) {
        wp_send_json_error([ 'code' => 'not_logged_in',  'message' => 'Not logged in' ]);
        wp_die();
    }

    if (!isset($_POST['comment'], $_POST['post_id'])) {
        wp_send_json_error([ 'code' => 'invalid_data', 'message' => 'Invalid data' ]);
        wp_die();
    }

    $comment_content = sanitize_textarea_field($_POST['comment']);
    $post_id = intval($_POST['post_id']);

    if (!$post_id || empty($comment_content)) {
        wp_send_json_error([ 'code' => 'empty_data', 'message' => 'Empty data' ]);
        wp_die();
    }

    $user_id = get_current_user_id();
    $user = wp_get_current_user();

    $author = $user->display_name ?: $user->user_login;
    $email  = $user->user_email;

    $commentdata = [
        'comment_post_ID'      => $post_id,
        'comment_content'      => $comment_content,
        'comment_author'       => $author,
        'comment_author_email' => $email,
        'user_id'              => $user_id,
        'comment_author_IP'    => $_SERVER['REMOTE_ADDR'] ?? '',
        'comment_agent'        => $_SERVER['HTTP_USER_AGENT'] ?? '',
        'comment_date'         => current_time('mysql'),
        'comment_approved'     => 1,
    ];

    $comment_id = wp_insert_comment($commentdata);

    if (!$comment_id) {
        wp_send_json_error([ 'code' => 'insert_failed', 'message' => 'Failed to insert comment' ]);
        wp_die();
    }

    $comment = get_comment($comment_id);

    $author_url = get_author_posts_url($user_id);

    ob_start(); ?>

    <div class="comments__item flex gap-4">

        <!-- Avatar -->
        <div class="relative h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800 shadow-sm">
            <img 
                src="<?php echo esc_url(get_avatar_url($comment->user_id)); ?>" 
                class="h-full w-full object-cover"
                alt="avatar"
            >
        </div>

        <!-- Content -->
        <div class="flex-1 space-y-2">

            <!-- Author + time -->
            <div class="flex items-center gap-2 flex-wrap text-sm">
                <a 
                    href="<?php echo esc_url($author_url); ?>" 
                    class="cursor-pointer font-semibold text-base text-gray-900 dark:text-white hover:text-teal-600 dark:hover:text-teal-400 transition-colors"
                >
                    <?php echo esc_html($comment->comment_author); ?>
                </a>

                <span class="text-gray-300 dark:text-gray-700">·</span>

                <span class="text-gray-400 dark:text-gray-500">
                    <?php echo human_time_diff(
                        strtotime($comment->comment_date),
                        current_time('timestamp')
                    ) . ' ago'; ?>
                </span>
            </div>

            <!-- Comment text -->
            <div class="text-base text-gray-700 dark:text-gray-300 leading-relaxed">
                <?php echo esc_html($comment->comment_content); ?>
            </div>

            <!-- Actions -->
            <div class="pt-0.5 flex items-center gap-4">

                <button class="inline-flex items-center gap-1.5 font-semibold text-sm text-gray-400 dark:text-gray-500 hover:text-teal-600 dark:hover:text-teal-400 transition-colors cursor-pointer">
                    <?php _e("Reply", THEME); ?>
                </button>

                <button class="inline-flex items-center gap-1.5 font-semibold text-sm text-gray-400 dark:text-gray-500 hover:text-teal-600 dark:hover:text-teal-400 transition-colors cursor-pointer">
                    <?php _e("Edit", THEME); ?>
                </button>

                <button 
                    data-comment-id="<?php echo $comment->comment_ID; ?>" 
                    class="comment__delete inline-flex items-center gap-1.5 font-semibold text-sm text-gray-400 dark:text-gray-500 hover:text-teal-600 dark:hover:text-teal-400 transition-colors cursor-pointer"
                >
                    <?php _e("Delete", THEME); ?>
                </button>

            </div>

        </div>
    </div>

    <?php

    wp_send_json_success([
        'html' => ob_get_clean()
    ]);
}

add_action('wp_ajax_delete_comment', 'theme_delete_comment');

function theme_delete_comment() {
    if ( empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'delete_comment_nonce') ) {
        wp_die();
    }

    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Not logged in']);
        wp_die();
    }

    // 2. comment ID check
    if (empty($_POST['comment_id'])) {
        wp_send_json_error([ 'message' => 'Missing comment ID' ]);
        wp_die();
    }

    $comment_id = (int) $_POST['comment_id'];
    $comment = get_comment($comment_id);

    if (!$comment) {
        wp_send_json_error([ 'message' => 'Comment not found' ]);
        wp_die();
    }

    // if (!current_user_can('edit_comment', $comment_id)) {
    //     wp_send_json_error([ 'message' => 'No permission to delete this comment' ]);
    //     wp_die();
    // }

    // 4. delete comment (hard delete)
    $deleted = wp_delete_comment($comment_id, true);

    if (!$deleted) {
        wp_send_json_error([ 'message' => 'Failed to delete comment' ]);
        wp_die();
    }

    // 5. success response
    wp_send_json_success([ 'message' => 'Comment deleted', 'comment_id' => $comment_id ]);
}