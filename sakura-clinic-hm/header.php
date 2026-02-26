<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <meta name="format-detection" content="telephone=no" />
  <!-- meta情報 -->
  <title>
    <?php
    $title_suffix = '｜【公式】さくらクリニック｜静岡県浜松市';
    if (is_front_page()) {
        echo esc_html('【公式】さくらクリニック｜静岡県浜松市');
    } elseif (is_home()) {
        $blog_page_title = get_the_title(get_option('page_for_posts'));
        echo esc_html($blog_page_title . $title_suffix);
    } elseif (is_singular('post')) {
        echo esc_html(get_the_title() . $title_suffix);
    } elseif (is_page()) {
        echo esc_html(get_the_title() . $title_suffix);
    } elseif (is_singular()) {
        echo esc_html(get_the_title() . $title_suffix);
    } elseif (is_category()) {
        echo esc_html(single_cat_title('', false) . '一覧' . $title_suffix);
    } elseif (is_post_type_archive()) {
        $cpt_slug = get_post_type() ?: get_query_var('post_type');
        $cpt_slug = is_array($cpt_slug) ? reset($cpt_slug) : $cpt_slug;
        $pt = $cpt_slug ? get_post_type_object($cpt_slug) : null;
        $pt_name = ($pt && isset($pt->labels->name)) ? $pt->labels->name : $cpt_slug;
        echo esc_html(($pt_name ?: $cpt_slug) . $title_suffix);
    } elseif (is_archive()) {
        echo esc_html(single_cat_title('', false) . $title_suffix);
    } elseif (is_search()) {
        echo esc_html('検索結果: ' . get_search_query() . $title_suffix);
    } elseif (is_404()) {
        echo esc_html('ページが見つかりません' . $title_suffix);
    } else {
        echo esc_html('【公式】さくらクリニック｜静岡県浜松市');
    }
    ?>
  </title>

  <meta name="description" content="<?php
    $base_description = '浜松市のさくらクリニックは、内科・麻酔科・リハビリテーション科を診療科目にし、地域に根ざした医療を提供しています。休診情報や求人情報を随時掲載。';
    if (is_front_page()) {
        echo esc_attr($base_description);
    } elseif (is_home()) {
        echo esc_attr(get_the_title(get_option('page_for_posts')) . ' - ' . $base_description);
    } elseif (is_page()) {
        echo esc_attr(get_the_title() . ' - ' . $base_description);
    } elseif (is_singular('post')) {
        $excerpt = get_the_excerpt();
        echo esc_attr(get_the_title() . ' - ' . ($excerpt ? $excerpt : $base_description));
    } elseif (is_singular()) {
        $excerpt = get_the_excerpt();
        echo esc_attr(get_the_title() . ' - ' . ($excerpt ? $excerpt : $base_description));
    } elseif (is_category()) {
        echo esc_attr(single_cat_title('', false) . '一覧 - ' . $base_description);
    } elseif (is_post_type_archive()) {
        $cpt_slug = get_post_type() ?: get_query_var('post_type');
        $cpt_slug = is_array($cpt_slug) ? reset($cpt_slug) : $cpt_slug;
        $pt = $cpt_slug ? get_post_type_object($cpt_slug) : null;
        $pt_name = ($pt && isset($pt->labels->name)) ? $pt->labels->name : $cpt_slug;
        echo esc_attr(($pt_name ?: $cpt_slug) . ' - ' . $base_description);
    } elseif (is_archive()) {
        echo esc_attr(single_cat_title('', false) . 'の記事一覧 - ' . $base_description);
    } elseif (is_search()) {
        echo esc_attr('検索結果: ' . get_search_query() . ' - ' . $base_description);
    } elseif (is_404()) {
        echo esc_attr('ページが見つかりません - ' . $base_description);
    } else {
        echo esc_attr($base_description);
    }
?>">
  <meta name="keywords" content="さくらクリニック,浜松市,内科,麻酔科,リハビリテーション科,往診,往診対応クリニック,クリニック求人" />
  <!-- canonical -->
  <link rel="canonical" href="<?php
    if (is_front_page()) {
        echo esc_url(home_url('/'));
    } elseif (is_singular()) {
        echo esc_url(get_permalink());
    } elseif (is_category() || is_tag() || is_tax()) {
        echo esc_url(get_term_link(get_queried_object()));
    } elseif (is_post_type_archive()) {
        $cpt_slug = get_post_type() ?: get_query_var('post_type');
        $cpt_slug = is_array($cpt_slug) ? reset($cpt_slug) : $cpt_slug;
        $archive_url = $cpt_slug ? get_post_type_archive_link($cpt_slug) : '';
        echo esc_url($archive_url ?: home_url('/'));
    } elseif (is_search()) {
        echo esc_url(home_url('/') . '?s=' . get_search_query());
    } else {
        echo esc_url(home_url('/'));
    }
  ?>" />
  <!-- ogp -->
  <meta property="og:title" content="<?php
    $og_title_suffix = '｜【公式】さくらクリニック｜静岡県浜松市';
    if (is_front_page()) {
        echo esc_attr('【公式】さくらクリニック｜静岡県浜松市');
    } elseif (is_singular('post')) {
        echo esc_attr(get_the_title() . $og_title_suffix);
    } elseif (is_page()) {
        echo esc_attr(get_the_title() . $og_title_suffix);
    } elseif (is_singular()) {
        echo esc_attr(get_the_title() . $og_title_suffix);
    } elseif (is_post_type_archive()) {
        $cpt_slug = get_post_type() ?: get_query_var('post_type');
        $cpt_slug = is_array($cpt_slug) ? reset($cpt_slug) : $cpt_slug;
        $pt = $cpt_slug ? get_post_type_object($cpt_slug) : null;
        $pt_name = ($pt && isset($pt->labels->name)) ? $pt->labels->name : $cpt_slug;
        echo esc_attr(($pt_name ?: $cpt_slug) . $og_title_suffix);
    } else {
        echo esc_attr('【公式】さくらクリニック｜静岡県浜松市');
    }
  ?>" />
  <meta property="og:type" content="<?php echo esc_attr((is_singular('post') || (is_singular() && !is_page())) ? 'article' : 'website'); ?>">
  <meta property="og:url" content="<?php
    if (is_front_page()) {
        echo esc_url(home_url('/'));
    } elseif (is_singular()) {
        echo esc_url(get_permalink());
    } elseif (is_category() || is_tag() || is_tax()) {
        echo esc_url(get_term_link(get_queried_object()));
    } elseif (is_post_type_archive()) {
        $cpt_slug = get_post_type() ?: get_query_var('post_type');
        $cpt_slug = is_array($cpt_slug) ? reset($cpt_slug) : $cpt_slug;
        $archive_url = $cpt_slug ? get_post_type_archive_link($cpt_slug) : '';
        echo esc_url($archive_url ?: home_url('/'));
    } else {
        echo esc_url(home_url('/'));
    }
  ?>" />
  <meta property="og:image" content="https://sakura-clinic-hm.com/wp-content/themes/sakura-clinic-hm/assets/images/og-img.jpg" />
  <meta property="og:site_name" content="【公式】さくらクリニック｜静岡県浜松市" />
  <meta property="og:description" content="<?php
    $og_description = '浜松市のさくらクリニックは、内科・麻酔科・リハビリテーション科を診療科目にし、地域に根ざした医療を提供しています。休診情報や求人情報を随時掲載。';
    if (is_front_page()) {
        echo esc_attr($og_description);
    } elseif (is_singular('post')) {
        $excerpt = get_the_excerpt();
        echo esc_attr($excerpt ? $excerpt : $og_description);
    } elseif (is_page()) {
        echo esc_attr(get_the_title() . ' - ' . $og_description);
    } elseif (is_singular()) {
        $excerpt = get_the_excerpt();
        echo esc_attr($excerpt ? $excerpt : $og_description);
    } elseif (is_post_type_archive()) {
        $cpt_slug = get_post_type() ?: get_query_var('post_type');
        $cpt_slug = is_array($cpt_slug) ? reset($cpt_slug) : $cpt_slug;
        $pt = $cpt_slug ? get_post_type_object($cpt_slug) : null;
        $pt_name = ($pt && isset($pt->labels->name)) ? $pt->labels->name : $cpt_slug;
        echo esc_attr(($pt_name ?: $cpt_slug) . ' - ' . $og_description);
    } else {
        echo esc_attr($og_description);
    }
  ?>" />
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header class="header">
    <div class="header__inner">
    <a href="<?php echo HOME_URL; ?>" class="header__logo-link">
        <?php
          $logo_tag = (is_front_page() || is_home()) ? 'h1' : 'div';
        ?>
        <<?php echo esc_attr($logo_tag); ?> class="header__logo">
          <img src="<?php echo IMAGEPATH; ?>/common/logo.webp" alt="さくらクリニック" width="133"
            height="44" class="header__logo-img" >
        </<?php echo esc_attr($logo_tag); ?>>
      </a>
      <nav class="header__nav">
        <ul class="header__nav-list">
          <li class="header__nav-item">
            <a href="<?php echo TOP_NEWS_URL; ?>" class="header__nav-link<?php if(is_post_type_archive('news') || is_singular('news')): ?> current<?php endif; ?>">お知らせ</a>
          </li>
          <li class="header__nav-item">
            <a href="<?php echo CLINIC_INFO_URL; ?>" class="header__nav-link">クリニック情報</a>
          </li>
          <li class="header__nav-item">
            <a href="<?php echo HOURS_URL; ?>" class="header__nav-link">診療時間</a>
          </li>
          <li class="header__nav-item">
            <a href="<?php echo FACILITY_URL; ?>" class="header__nav-link">施設紹介</a>
          </li>
          <li class="header__nav-item">
            <a href="<?php echo ACCESS_URL; ?>" class="header__nav-link">アクセス</a>
          </li>
          <li class="header__nav-item">
            <a href="<?php echo CONTACT_URL; ?>" class="header__nav-link">お問い合わせ</a>
          </li>
        </ul>
      </nav>
        <button class="header__hamburger-button js-hamburger" type="button" aria-label="メニューを開く">
        <span></span>
          <span></span>
          <span></span>
        </button>
        </div>
  </header>

  <div class="drawer">
    <div class="drawer__body">
      <ul class="drawer__list">
        <li class="drawer__item">
          <a href="<?php echo TOP_NEWS_URL; ?>"
            class="drawer__link<?php if(is_post_type_archive('news') || is_singular('news')): ?> current<?php endif; ?>">
              <span class="drawer__link-text">お知らせ</span>
              <span class="drawer__link-icon">
                <img src="<?php echo IMAGEPATH; ?>/common/arrow_down.svg" alt="下矢印" width="23" height="23">
              </span>
            </a>
        </li>
        <li class="drawer__item">
          <a href="<?php echo CLINIC_INFO_URL; ?>" class="drawer__link">
            <span class="drawer__link-text">クリニック情報</span>
            <span class="drawer__link-icon">
              <img src="<?php echo IMAGEPATH; ?>/common/arrow_down.svg" alt="下矢印" width="23" height="23">
            </span>
          </a>
        </li>
        <li class="drawer__item">
          <a href="<?php echo HOURS_URL; ?>" class="drawer__link">
            <span class="drawer__link-text">診療時間</span>
            <span class="drawer__link-icon">
              <img src="<?php echo IMAGEPATH; ?>/common/arrow_down.svg" alt="下矢印" width="23" height="23">
            </span>
          </a>
        </li>
        <li class="drawer__item">
          <a href="<?php echo FACILITY_URL; ?>" class="drawer__link">
            <span class="drawer__link-text">施設紹介</span>
            <span class="drawer__link-icon">
              <img src="<?php echo IMAGEPATH; ?>/common/arrow_down.svg" alt="下矢印" width="23" height="23">
            </span>
          </a>
        </li>
        <li class="drawer__item">
          <a href="<?php echo ACCESS_URL; ?>" class="drawer__link">
            <span class="drawer__link-text">アクセス</span>
            <span class="drawer__link-icon">
              <img src="<?php echo IMAGEPATH; ?>/common/arrow_down.svg" alt="下矢印" width="23" height="23">
            </span>
          </a>
        </li>
        <li class="drawer__item">
          <a href="<?php echo CONTACT_URL; ?>" class="drawer__link">
            <span class="drawer__link-text">お問い合わせ</span>
            <span class="drawer__link-icon">
              <img src="<?php echo IMAGEPATH; ?>/common/arrow_down.svg" alt="下矢印" width="23" height="23">
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>