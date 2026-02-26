<?php
// テーマ初期設定
require get_template_directory() . '/inc/setup.php';

// 管理画面カスタマイズ（コメント・投稿削除など）
require get_template_directory() . '/inc/custom-admin.php';

// セキュリティ対策
require get_template_directory() . '/inc/security.php';

// カスタム投稿タイプの追加
require get_template_directory() . '/inc/custom-post-types.php';

// 定義
require get_template_directory() . '/inc/defines.php';

// 開発用ツール読み込み（本番では読み込まない）
if (wp_get_environment_type() === 'local') {
  require_once get_template_directory() . '/dev/dev-loader.php';
}
