<?php
// ==========================================================================
// 投稿者アーカイブ無効化
// ==========================================================================
add_filter('author_rewrite_rules', '__return_empty_array');

// ==========================================================================
// フロント側でのユーザー名露出防止：著者アーカイブ/クエリを 404 に
// ==========================================================================
add_action('template_redirect', function () {
    if ( is_author()
      || get_query_var('author_name')
      || get_query_var('author')
      || isset($_GET['author'])
    ) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
        include get_404_template();
        exit;
    }
}, 9);

// ==========================================================================
// ユーザーのサイトマップを無効化（/wp-sitemap.xml 内の users を除外）
// ==========================================================================
add_filter('wp_sitemaps_add_provider', function ($provider, $name) {
    return ($name === 'users') ? false : $provider;
}, 10, 2);

// ==========================================================================
// REST API からのユーザー列挙防止
// ==========================================================================
add_filter('rest_endpoints', function ($endpoints) {
    if ( isset($endpoints['/wp/v2/users']) ) {
        unset($endpoints['/wp/v2/users']);
    }
    if ( isset($endpoints['/wp/v2/users/(?P<id>[\d]+)']) ) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
});
