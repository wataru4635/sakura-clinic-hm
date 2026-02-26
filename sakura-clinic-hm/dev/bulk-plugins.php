<?php
// ==========================================================================
// プラグイン一括追加（選択してインストール・有効化を一括操作）：開発専用
// ==========================================================================

function dev_bulk_plugins_list() {
  return [
    'advanced-custom-fields' => ['name' => 'Advanced Custom Fields', 'file' => 'advanced-custom-fields/acf.php'],
    'duplicate-post'         => ['name' => 'Yoast Duplicate Post', 'file' => 'duplicate-post/duplicate-post.php'],
    'xml-sitemap-feed'       => ['name' => 'XML Sitemap & Google News', 'file' => 'xml-sitemap-feed/xml-sitemap-feed.php'],
    'siteguard'              => ['name' => 'SiteGuard WP Plugin', 'file' => 'siteguard/siteguard.php'],
    'wp-multibyte-patch'     => ['name' => 'WP Multibyte Patch', 'file' => 'wp-multibyte-patch/wp-multibyte-patch.php'],
    'fv-top-level-cats'      => ['name' => 'FV Top Level Categories', 'file' => 'fv-top-level-cats/fv-top-level-cats.php'],
    'all-in-one-seo-pack'    => ['name' => 'All In One SEO', 'file' => 'all-in-one-seo-pack/all_in_one_seo_pack.php'],
  ];
}

function add_dev_bulk_plugins_menu() {
  add_menu_page(
    'プラグイン一括追加',
    'プラグイン一括追加',
    'manage_options',
    'dev-bulk-plugins',
    'dev_bulk_plugins_page',
    'dashicons-plugins-checked',
    83
  );
  add_action('admin_page_dev-bulk-plugins', 'dev_bulk_plugins_page');
  add_action('toplevel_page_dev-bulk-plugins', 'dev_bulk_plugins_page');
}
add_action('admin_menu', 'add_dev_bulk_plugins_menu');

function dev_bulk_plugins_page() {
  $list   = dev_bulk_plugins_list();
  $result = isset($_GET['dev_bulk_plugins_result']) ? sanitize_text_field($_GET['dev_bulk_plugins_result']) : '';
?>
  <div class="wrap">
    <h1>プラグイン一括追加</h1>
    <?php if ($result !== '') : ?>
      <div class="notice notice-info is-dismissible"><p><?php echo esc_html($result); ?></p></div>
    <?php endif; ?>
    <form method="post" id="dev-bulk-plugins-form">
      <?php wp_nonce_field('dev_bulk_plugins'); ?>
      <p>追加するプラグインにチェックを入れ、有効化するものには「有効化」にもチェックを入れてから実行してください。既にインストール済みのものはスキップされ、有効化のみ行えます。</p>
      <table class="widefat striped">
        <thead>
          <tr>
            <th style="width:8%">追加</th>
            <th style="width:8%">有効化</th>
            <th>プラグイン名</th>
            <th style="width:18%">状態</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($list as $slug => $info) :
            $path = WP_PLUGIN_DIR . '/' . $info['file'];
            $installed = file_exists($path);
            $active = $installed && is_plugin_active($info['file']);
          ?>
            <tr>
              <td><input type="checkbox" name="bulk_plugins[]" value="<?php echo esc_attr($slug); ?>"></td>
              <td><input type="checkbox" name="bulk_plugins_activate[]" value="<?php echo esc_attr($slug); ?>"></td>
              <td><?php echo esc_html($info['name']); ?></td>
              <td>
                <?php if ($active) : ?>有効化済み
                <?php elseif ($installed) : ?>インストール済み（無効）
                <?php else : ?>未インストール
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <p>
        <input type="submit" name="dev_bulk_plugins_submit" class="button button-primary" value="一括で追加">
      </p>
    </form>
  </div>
<?php
}

add_action('admin_init', function() {
  if (!isset($_POST['dev_bulk_plugins_submit'])) return;
  if (!current_user_can('manage_options')) return;
  if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'dev_bulk_plugins')) {
    wp_die('不正なリクエストです');
  }
  $list     = dev_bulk_plugins_list();
  $slugs    = isset($_POST['bulk_plugins']) ? (array) $_POST['bulk_plugins'] : [];
  $slugs    = array_intersect($slugs, array_keys($list));
  $activate_slugs = isset($_POST['bulk_plugins_activate']) ? (array) $_POST['bulk_plugins_activate'] : [];
  $activate_slugs = array_intersect($activate_slugs, array_keys($list));
  $messages = [];

  $to_process = array_unique(array_merge($slugs, $activate_slugs));
  if (empty($to_process)) {
    wp_redirect(admin_url('admin.php?page=dev-bulk-plugins&dev_bulk_plugins_result=' . urlencode('追加または有効化するプラグインが選択されていません。')));
    exit;
  }

  if (!function_exists('is_plugin_active')) {
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
  }
  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/misc.php';
  require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
  require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';
  require_once ABSPATH . 'wp-admin/includes/class-automatic-upgrader-skin.php';

  foreach ($to_process as $slug) {
    $info     = $list[$slug];
    $file     = $info['file'];
    $path     = WP_PLUGIN_DIR . '/' . $file;
    $installed = file_exists($path);

    if (!$installed && in_array($slug, $slugs, true)) {
      $url = 'https://downloads.wordpress.org/plugin/' . $slug . '.latest-stable.zip';
      $upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
      $result   = $upgrader->install($url);
      if (is_wp_error($result)) {
        $messages[] = $info['name'] . ': インストール失敗（' . $result->get_error_message() . '）';
        continue;
      }
      $messages[] = $info['name'] . ': インストールしました';
    }

    if (in_array($slug, $activate_slugs, true) && file_exists($path)) {
      $act = activate_plugin($file, '', false);
      if (is_wp_error($act)) {
        $messages[] = $info['name'] . ': 有効化失敗（' . $act->get_error_message() . '）';
      } else {
        $messages[] = $info['name'] . ': 有効化しました';
      }
    }
  }

  wp_redirect(admin_url('admin.php?page=dev-bulk-plugins&dev_bulk_plugins_result=' . urlencode(implode(' / ', $messages))));
  exit;
}, 5);