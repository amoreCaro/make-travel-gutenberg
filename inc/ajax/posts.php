<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 1. перевірити, що запит є POST;
// 2. перевірити nonce;
// перевірити, що користувач авторизований;
// перевірити права користувача (current_user_can()).
// отримати сирі дані з $_POST та $_FILES.
function theme_collect_post_request() {
	return [
		'user_id'    => get_current_user_id(),
		'title'      => $_POST['post_title'] ?? '',
		'content'    => $_POST['post_content'] ?? '',
		'excerpt'    => $_POST['post_excerpt'] ?? '',
		'categories' => $_POST['post_categories'] ?? '',
		'tags'       => $_POST['post_tags'] ?? '',
		'featured'   => $_FILES['thumbnail'] ?? null,
		'video'      => $_FILES['video'] ?? null,
		'gallery'    => $_FILES['gallery'] ?? [],
	];
}

// Очистити всі отримані дані.
// Жодних перевірок на помилки тут бути не повинно.
function theme_sanitize_post_data( array $data ): array {
	// Категорії приходять рядком "1,5,7" — розбираємо в масив ID.
	$categories = ! empty( $data['categories'] )
		? array_filter( array_map( 'absint', explode( ',', $data['categories'] ) ) )
		: [];

	// Теги приходять рядком "one, two, three" — розбираємо в масив рядків.
	$tags = ! empty( $data['tags'] )
		? array_filter( array_map( 'sanitize_text_field', array_map( 'trim', explode( ',', $data['tags'] ) ) ) )
		: [];

	return [
		'user_id'    => absint( $data['user_id'] ?? 0 ),
		'title'      => sanitize_text_field( $data['title'] ?? '' ),
		'content'    => wp_kses_post( $data['content'] ?? '' ),
		'excerpt'    => sanitize_textarea_field( $data['excerpt'] ?? '' ),
		'categories' => $categories,
		'tags'       => $tags,
		'featured'   => $data['featured'] ?? null,
		'video'      => $data['video'] ?? null,
		'gallery'    => $data['gallery'] ?? [],
	];
}

// Перевірити чи дані коректні.
function theme_validate_post_data( array $data ): void {
	if ( empty( $data['user_id'] ) ) {
		wp_send_json_error( [
			'field'   => 'user_id',
			'message' => 'User is required.',
		] );
	}

	if ( empty( $data['title'] ) ) {
		wp_send_json_error( [
			'field'   => 'title',
			'message' => 'Title is required.',
		] );
	}
}

// Створити пост через wp_insert_post().
// Повернути ID створеного поста.
function theme_insert_post_item() {

}

// Після створення поста прив'язати:
//     - categories;
//     - tags;
//     - custom taxonomies.
function theme_save_post_taxonomies() {

}

// Обробити всі файли :
    // featured image
    // gallery
    // video
function theme_upload_post_media() {

}

function theme_create_post_handler() {
	// 1. Метод запиту.
	if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
        wp_die();
	}

	// 2. Nonce.
	if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'theme_create_post' ) ) {
        wp_die();
	}

	// 3. Права користувача (is_user_logged_in() тут не потрібен — wp_ajax_ без nopriv
	// вже гарантує авторизацію; current_user_can() перевіряє саме дозвіл на дію).
	if ( ! current_user_can( 'publish_posts' ) ) {
		wp_send_json_error( [ 'message' => 'Insufficient permissions.' ], 403 );
	}

	$request = theme_collect_post_request();
	$data    = theme_sanitize_post_data( $request );

	theme_validate_post_data( $data );

	// theme_insert_post_item();
	// theme_save_post_taxonomies();
	// theme_upload_post_media();
	// wp_send_json_success();
}

add_action( 'wp_ajax_theme_create_post', 'theme_create_post_handler' );