<?php

/**
 * Live Search AJAX
 */
function theme_live_search_handler() {

    /**
     * Verify nonce
     */

    if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'live_search_nonce' ) ) {
        wp_die();
	}

    /**
     * Get search value
     */
    $search = isset($_POST['search'])
        ? sanitize_text_field(
            wp_unslash($_POST['search'])
        )
        : '';

    $search = trim($search);

    /**
     * Search from 1 character
     */
    if ($search === '') {
        wp_send_json_success([
            'total'   => 0,
            'results' => [],
        ]);
    }

    /**
     * Get all public post types
     */
    $post_types = get_post_types(
        [
            'public' => true,
        ],
        'names'
    );

    /**
     * Remove attachments
     */
    $post_types = array_values(
        array_diff(
            $post_types,
            [
                'attachment',
            ]
        )
    );

    /**
     * Search query
     */
    $query = new WP_Query([
        'post_type'           => $post_types,
        'post_status'         => 'publish',
        's'                   => $search,
        'posts_per_page'      => 10,
        'paged'               => 1,
        'ignore_sticky_posts' => true,
        'no_found_rows'       => false,
        'orderby'             => 'relevance',
        'order'               => 'DESC',
    ]);

    /**
     * Results
     */
    $results = [];

    if ($query->have_posts()) {

        while ($query->have_posts()) {

            $query->the_post();

            $post_id = get_the_ID();

            $post_type = get_post_type(
                $post_id
            );

            $post_type_object = get_post_type_object(
                $post_type
            );

            $type_name = $post_type_object
                ? $post_type_object->labels->singular_name
                : $post_type;

            $results[] = [
                'id'        => $post_id,
                'title'     => get_the_title($post_id),
                'url'       => get_permalink($post_id),
                'type'      => $post_type,
                'type_name' => $type_name,
            ];
        }

        wp_reset_postdata();
    }

    /**
     * Total results
     */
    $total = (int) $query->found_posts;

    /**
     * Return JSON
     */
    wp_send_json_success([
        'total'   => $total,
        'results' => $results,
    ]);
}


/**
 * AJAX hooks
 */
add_action(
    'wp_ajax_theme_live_search',
    'theme_live_search_handler'
);

add_action(
    'wp_ajax_nopriv_theme_live_search',
    'theme_live_search_handler'
);