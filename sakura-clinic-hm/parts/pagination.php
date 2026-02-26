<?php if ($wp_query->max_num_pages > 1): ?>
  <div class="pagination">
    <?php 
      $big = 999999999; // プレースホルダー
      $current = max(1, get_query_var('paged')); // 現在のページ番号
      $total_pages = $wp_query->max_num_pages; // 総ページ数

      // ページネーションリンクを取得
      $pagination_links = paginate_links(array(
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => (get_option('permalink_structure')) ? 'page/%#%/' : '?paged=%#%',
        'current'   => $current,
        'total'     => $total_pages,
        'mid_size'  => 1,
        'end_size'  => 1,
        'prev_text' => "",
        'next_text' => "",
        'type'      => 'array'
      ));

      // ページリンクを出力
      if (!empty($pagination_links)) {
        foreach ($pagination_links as $link) {
          // 現在のページのクラスを 'current-page' に変更
          $link = str_replace('page-numbers current', 'current-page', $link);
          // 他のページリンクに 'page-link' クラスを適用（prev / next は除外）
          if (strpos($link, 'prev') === false && strpos($link, 'next') === false) {
            $link = str_replace('page-numbers', 'page-link', $link);
          }

          // 省略記号の処理（元のまま）
          if (strpos($link, 'dots') !== false) {
            echo '<span class="dots">...</span>';
          } else {
            echo wp_kses_post( $link );
          }
        }
      }
    ?>
  </div>
<?php endif; ?>
