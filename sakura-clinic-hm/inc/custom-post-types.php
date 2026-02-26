<?php
// ==========================================================================
// カスタム投稿：お知らせ（news）
// ==========================================================================
function create_post_type_news() {
	register_post_type(
		'news',
		array(
			'labels' => array(
				'name' => 'お知らせ',
				'singular_name' => 'お知らせ',
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'news'),
			'supports' => array('title', 'editor', 'thumbnail'),
			'show_in_rest' => true,
			'menu_icon' => 'dashicons-edit',
			'menu_position' => 5,
			'taxonomies' => array('news_category'),
		)
	);

	register_taxonomy(
		'news_category',
		'news',
		array(
			'label' => 'カテゴリー',
			'hierarchical' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'rewrite' => array('slug' => 'news-category'),
			'show_in_rest' => true,
		)
	);
}
add_action('init', 'create_post_type_news');

// ==========================================================================
// カスタム投稿タイプ "news" での表示件数
// ==========================================================================
function custom_news_posts_per_page( $query ) {
  if ( ! is_admin() && $query->is_main_query() ) {
      if ( $query->is_post_type_archive( 'news' ) || $query->is_tax( 'news_category' ) ) {
          $query->set( 'posts_per_page', 8 ); // すべて8件表示
      }
  }
}
add_action( 'pre_get_posts', 'custom_news_posts_per_page' );

// ==========================================================================
// カスタム投稿タイプ「news」のパーマリンク設定
// ==========================================================================

add_filter('post_type_link', 'custom_post_type_news_permalink', 10, 2);
function custom_post_type_news_permalink($link, $post) {
    if ($post->post_type === 'news') {
        return home_url('/news/' . $post->ID . '/');
    }
    return $link;
}

add_filter('rewrite_rules_array', 'custom_post_type_news_rewrite_rules');
function custom_post_type_news_rewrite_rules($rules) {
    $new_rules = array(
        'news/([0-9]+)/?$' => 'index.php?post_type=news&p=$matches[1]',
    );
    return $new_rules + $rules;
}