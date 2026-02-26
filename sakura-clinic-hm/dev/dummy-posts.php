<?php
// ==========================================================================
// ダミー投稿生成（管理画面版・拡張）：開発専用
// ==========================================================================
function add_dev_dummy_menu() {
  add_menu_page(
    'ダミー投稿生成',
    'ダミー投稿生成',
    'manage_options',
    'dev-dummy',
    'dev_dummy_posts_page',
    'dashicons-admin-generic',
    81
  );
  add_action('admin_page_dev-dummy', 'dev_dummy_posts_page');
  add_action('toplevel_page_dev-dummy', 'dev_dummy_posts_page');
}
add_action('admin_menu', 'add_dev_dummy_menu');

function dev_dummy_posts_page() {
  $post_types = get_post_types(['show_ui' => true], 'objects');
  $exclude   = ['attachment', 'wp_block', 'wp_navigation', 'wp_template', 'wp_template_part'];
  $post_types = array_diff_key($post_types, array_flip($exclude));
  $current   = isset($_GET['post_type']) ? sanitize_text_field($_GET['post_type']) : '';
  if (!$current || !isset($post_types[$current])) {
    $current = isset($post_types['news']) ? 'news' : key($post_types);
  }
?>
  <div class="wrap">
    <h1>ダミー投稿生成</h1>
    <form method="post">
      <?php wp_nonce_field('dev_generate_dummy'); ?>

      <table class="form-table">
        <tr>
          <th>投稿タイプ</th>
          <td>
            <select name="post_type" required>
              <?php foreach ($post_types as $slug => $obj) : ?>
                <option value="<?php echo esc_attr($slug); ?>" <?php selected($current, $slug); ?>><?php echo esc_html($obj->labels->singular_name ?: $obj->label); ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th>生成件数</th>
          <td>
            <input type="number" name="post_count" value="10" min="1" required>
          </td>
        </tr>
        <tr>
          <th>アイキャッチ画像</th>
          <td>
            <input type="hidden" name="dev_thumbnail_id" id="dev_thumbnail_id" value="">
            <div id="dev_thumbnail_preview" style="margin-bottom:8px;"></div>
            <button type="button" class="button" id="dev_thumbnail_select">画像を選択</button>
            <button type="button" class="button" id="dev_thumbnail_remove" style="display:none;">削除</button>
            <p class="description">選択した画像がすべての投稿のアイキャッチに設定されます。未選択の場合は設定しません。</p>
          </td>
        </tr>
      </table>

      <p>
        <input type="submit" name="dev_generate" class="button button-primary" value="ダミー投稿を作成">
      </p>
    </form>
  </div>
<?php
}

function dev_dummy_enqueue_media($hook_suffix) {
  if ($hook_suffix !== 'toplevel_page_dev-dummy') {
    return;
  }
  wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'dev_dummy_enqueue_media');

function dev_dummy_thumbnail_script() {
  $screen = get_current_screen();
  if (!$screen || $screen->id !== 'toplevel_page_dev-dummy') {
    return;
  }
?>
<script>
(function() {
  var frame;
  var input = document.getElementById('dev_thumbnail_id');
  var preview = document.getElementById('dev_thumbnail_preview');
  var btnSelect = document.getElementById('dev_thumbnail_select');
  var btnRemove = document.getElementById('dev_thumbnail_remove');

  function updatePreview(id, url) {
    input.value = id || '';
    if (id && url) {
      preview.innerHTML = '<img src="' + url + '" style="max-width:200px;height:auto;display:block;border:1px solid #ccc;">';
      btnRemove.style.display = 'inline-block';
    } else {
      preview.innerHTML = '';
      btnRemove.style.display = 'none';
    }
  }

  btnSelect.addEventListener('click', function() {
    if (frame) {
      frame.open();
      return;
    }
    frame = wp.media({
      library: { type: 'image' },
      multiple: false
    });
    frame.on('select', function() {
      var att = frame.state().get('selection').first().toJSON();
      updatePreview(att.id, att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url);
    });
    frame.open();
  });

  btnRemove.addEventListener('click', function() {
    updatePreview('', '');
  });

  <?php
  $saved_id = isset($_POST['dev_thumbnail_id']) ? absint($_POST['dev_thumbnail_id']) : 0;
  if ($saved_id && wp_attachment_is_image($saved_id)) {
    $saved_url = wp_get_attachment_image_url($saved_id, 'medium');
    if ($saved_url) {
      echo "updatePreview(" . (int) $saved_id . ", " . json_encode($saved_url) . ");";
    }
  }
  ?>
})();
</script>
<?php
}
add_action('admin_footer', 'dev_dummy_thumbnail_script');

add_action('admin_init', function () {

  if (!isset($_POST['dev_generate'])) return;
  if (!current_user_can('manage_options')) return;

  if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'dev_generate_dummy')) {
    wp_die('不正なリクエストです');
  }

  $post_type     = sanitize_text_field($_POST['post_type']);
  $post_count    = intval($_POST['post_count']);
  $thumbnail_id  = isset($_POST['dev_thumbnail_id']) ? absint($_POST['dev_thumbnail_id']) : 0;
  if ($thumbnail_id && !wp_attachment_is_image($thumbnail_id)) {
    $thumbnail_id = 0;
  }

  if (!post_type_exists($post_type)) {
    add_action('admin_notices', function () {
      echo '<div class="notice notice-error"><p>指定された投稿タイプは存在しません。</p></div>';
    });
    return;
  }

  $base_date = current_time('timestamp');

  for ($i = 0; $i < $post_count; $i++) {
    // 1件目=今日、2件目=昨日…と1日ずつずらす
    $post_date = date('Y-m-d H:i:s', strtotime("-{$i} days", $base_date));

    $content = '<!-- wp:paragraph -->
<p>お知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいりますお知らせの本文がはいります。</p>
<!-- /wp:paragraph -->';

    $post_id = wp_insert_post([
      'post_title'   => $post_count > 1 ? 'お知らせのタイトルがはいりますお知らせのタイトルがはいります ' . sprintf('%02d', $i + 1) : 'お知らせのタイトルがはいりますお知らせのタイトルがはいります',
      'post_content' => $content,
      'post_status'  => 'publish',
      'post_type'    => $post_type,
      'post_date'    => $post_date,
    ]);
    if ($post_id && !is_wp_error($post_id) && $thumbnail_id) {
      set_post_thumbnail($post_id, $thumbnail_id);
    }
  }

  add_action('admin_notices', function () use ($post_count) {
    echo '<div class="notice notice-success"><p>' . $post_count . '件のダミー投稿を作成しました。</p></div>';
  });

});