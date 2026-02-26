<?php
// ==========================================================================
// 定義
// ==========================================================================
/* ---------- パスの短縮 ---------- */
define('IMAGEPATH',            get_template_directory_uri() . '/assets/images');

/* ---------- トップページの内部リンク ---------- */
define('HOME_URL',             esc_url(home_url('/')));                          // トップページ
define('CLINIC_INFO_URL',      esc_url(home_url('/') . '#clinic'));              // クリニック情報
define('HOURS_URL',            esc_url(home_url('/') . '#hours'));                // 診療時間
define('FACILITY_URL',         esc_url(home_url('/') . '#facility'));             // 施設紹介
define('ACCESS_URL',           esc_url(home_url('/') . '#access'));              // アクセス
define('CONTACT_URL',          esc_url(home_url('/') . '#contact'));             // お問い合わせ
define('TOP_NEWS_URL',         esc_url(home_url('/') . '#news'));               // お知らせ
define('NEWS_URL',             esc_url(home_url('/news')));                     // お知らせ一覧