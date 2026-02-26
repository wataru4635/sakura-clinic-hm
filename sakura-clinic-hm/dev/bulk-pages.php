<?php
// ==========================================================================
// 固定ページ一括作成（ダミー投稿とは独立したメニュー）：開発専用
// ==========================================================================

function add_dev_bulk_pages_menu() {
  add_menu_page(
    '固定ページ一括作成',
    '固定ページ一括作成',
    'manage_options',
    'dev-bulk-pages',
    'dev_bulk_pages_page',
    'dashicons-admin-page',
    82
  );
  add_action('admin_page_dev-bulk-pages', 'dev_bulk_pages_page');
  add_action('toplevel_page_dev-bulk-pages', 'dev_bulk_pages_page');
}
add_action('admin_menu', 'add_dev_bulk_pages_menu');

function dev_bulk_pages_page() {
  $templates = get_page_templates();
  $pages     = get_pages(['sort_column' => 'menu_order', 'hierarchical' => 1]);
  $created   = isset($_GET['dev_bulk_created']) ? (int) $_GET['dev_bulk_created'] : 0;
?>
  <div class="wrap">
    <h1>固定ページ一括作成</h1>
    <?php if ($created > 0) : ?>
      <div class="notice notice-success is-dismissible"><p><?php echo esc_html($created); ?>件の固定ページを作成しました。</p></div>
    <?php endif; ?>
    <form method="post" id="dev-bulk-pages-form">
      <?php wp_nonce_field('dev_bulk_pages'); ?>
      <table class="widefat striped" id="dev-bulk-pages-table">
        <thead>
          <tr>
            <th style="width:22%">タイトル</th>
            <th style="width:22%">スラッグ</th>
            <th style="width:22%">テンプレート</th>
            <th style="width:22%">親</th>
            <th style="width:12%"></th>
          </tr>
        </thead>
        <tbody>
          <tr class="dev-bulk-row">
            <td><input type="text" name="bulk_title[]" class="regular-text" placeholder="ページタイトル"></td>
            <td><input type="text" name="bulk_slug[]" class="regular-text" placeholder="slug（空欄で自動）"></td>
            <td>
              <select name="bulk_template[]">
                <option value="">デフォルト</option>
                <?php foreach ($templates as $file => $label) : ?>
                  <option value="<?php echo esc_attr($file); ?>"><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
              </select>
            </td>
            <td>
              <select name="bulk_parent[]">
                <option value="0">— なし —</option>
                <?php foreach ($pages as $p) : ?>
                  <option value="<?php echo esc_attr($p->ID); ?>"><?php echo esc_html($p->post_title); ?></option>
                <?php endforeach; ?>
              </select>
            </td>
            <td></td>
          </tr>
        </tbody>
      </table>
      <p>
        <button type="button" class="button" id="dev-bulk-add-row">行を追加</button>
        <input type="submit" name="dev_bulk_pages_submit" class="button button-primary" value="一括作成">
      </p>
    </form>
  </div>
  <script>
  (function() {
    var tbody = document.querySelector('#dev-bulk-pages-table tbody');
    var firstRow = tbody.querySelector('tr');
    if (!tbody || !firstRow) return;
    document.getElementById('dev-bulk-add-row').addEventListener('click', function() {
      var tr = firstRow.cloneNode(true);
      tr.querySelectorAll('input[type="text"]').forEach(function(i) { i.value = ''; });
      tr.querySelectorAll('select').forEach(function(s) { s.selectedIndex = 0; });
      tbody.appendChild(tr);
    });
  })();
  </script>
<?php
}

add_action('admin_init', function() {
  if (!isset($_POST['dev_bulk_pages_submit'])) return;
  if (!current_user_can('manage_options')) return;
  if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'dev_bulk_pages')) {
    wp_die('不正なリクエストです');
  }
  $titles    = isset($_POST['bulk_title']) ? (array) $_POST['bulk_title'] : [];
  $slugs     = isset($_POST['bulk_slug']) ? (array) $_POST['bulk_slug'] : [];
  $templates = isset($_POST['bulk_template']) ? (array) $_POST['bulk_template'] : [];
  $parents   = isset($_POST['bulk_parent']) ? (array) $_POST['bulk_parent'] : [];
  $count     = 0;
  for ($i = 0; $i < count($titles); $i++) {
    $title = trim(isset($titles[$i]) ? $titles[$i] : '');
    if ($title === '') continue;
    $slug = isset($slugs[$i]) ? sanitize_title($slugs[$i]) : '';
    if ($slug === '') $slug = sanitize_title($title);
    $template = isset($templates[$i]) ? sanitize_text_field($templates[$i]) : '';
    $parent   = isset($parents[$i]) ? absint($parents[$i]) : 0;
    $post_id  = wp_insert_post([
      'post_title'   => $title,
      'post_name'    => $slug,
      'post_type'    => 'page',
      'post_status'  => 'publish',
      'post_author'  => get_current_user_id(),
      'post_parent'  => $parent,
    ]);
    if ($post_id && !is_wp_error($post_id)) {
      if ($template !== '') {
        update_post_meta($post_id, '_wp_page_template', $template);
      }
      $count++;
    }
  }
  if ($count > 0) {
    wp_redirect(admin_url('admin.php?page=dev-bulk-pages&dev_bulk_created=' . $count));
    exit;
  }
}, 5);