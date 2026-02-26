<?php
/*
* Template Name: トップページ
*/
?>
<?php get_header(); ?>

<main>

  <section class="mv">
    <picture>
      <source srcset="<?php echo IMAGEPATH; ?>/top/mv_sp.webp" media="(max-width: 767px)" type="image/webp" width="390" height="339">
      <img src="<?php echo IMAGEPATH; ?>/top/mv.webp" alt="さくらクリニック 待合室の様子" width="1366" height="795" fetchpriority="high" class="mv__img">
    </picture>
    <div class="mv__copy">
      <div class="mv__copy-content">
        <h2 class="mv__copy-title">わたしたちは、<span class="mv__copy-highlight">地域のかかりつけ医</span>として<br>診療にあたっています</h2>
      </div>
    </div>
  </section>

  <section class="top-news" id="news">
    <div class="bg-circle bg-circle--01 js-circle" aria-hidden="true"></div>
    <div class="bg-circle bg-circle--02 js-circle" aria-hidden="true"></div>
    <div class="top-news__inner">
      <hgroup class="top-news__heading news-heading js-fade-in">
        <h2 class="news-heading__title">お知らせ</h2>
        <p class="news-heading__subtitle">news</p>
      </hgroup>
      <?php
        $news_query = new WP_Query([
          'post_type'      => 'news',
          'posts_per_page' => 5,
          'post_status'    => 'publish',
          'orderby'        => 'date',
          'order'          => 'DESC',
        ]);
        if ($news_query->have_posts()) :
      ?>
      <ul class="top-news__list news-list js-news-list">
        <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
        <li class="news-list__item">
          <a href="<?php the_permalink(); ?>" class="news-list__link">
            <time class="news-list__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
            <p class="news-list__item-title"><?php the_title(); ?></p>
          </a>
        </li>
        <?php endwhile; ?>
      </ul>
      <?php wp_reset_postdata(); ?>
      <?php else : ?>
      <p class="top-news__empty">現在投稿はありません</p>
      <?php endif; ?>
      <div class="top-news__btn js-fade-up">
        <a href="<?php echo NEWS_URL; ?>" class="top-news__btn-link">
          お知らせ一覧
        </a>
      </div>
    </div>
  </section>

  <section class="clinic-info" id="clinic">
    <div class="clinic-info__inner">
      <div class="bg-circle bg-circle--03 js-circle" aria-hidden="true"></div>
      <div class="clinic-info__heading section-heading js-section-heading">
        <h2 class="section-heading__title">クリニック情報</h2>
        <img src="<?php echo IMAGEPATH; ?>/common/section_icon.svg" alt="セクション見出しの装飾アイコン" width="27" height="32" aria-hidden="true" class="section-heading__icon">
      </div>

      <div class="clinic-info__table-wrap js-fade-up">
        <table class="clinic-info__table">
          <tbody>
            <tr class="clinic-info__row">
              <th class="clinic-info__th">クリニック名</th>
              <td class="clinic-info__td">さくらクリニック</td>
            </tr>
            <tr class="clinic-info__row">
              <th class="clinic-info__th">診療科目</th>
              <td class="clinic-info__td">内科、麻酔科、リハビリテーション科 ※院内・院外処方対応可</td>
            </tr>
            <tr class="clinic-info__row">
              <th class="clinic-info__th">院長</th>
              <td class="clinic-info__td">鈴木 滋</td>
            </tr>
            <tr class="clinic-info__row">
              <th class="clinic-info__th">副院長</th>
              <td class="clinic-info__td">鈴木 翼</td>
            </tr>
            <tr class="clinic-info__row">
              <th class="clinic-info__th">住所</th>
              <td class="clinic-info__td">〒432-8012 <br class="u-mobile">静岡県浜松市中央区布橋3丁目14-17</td>
            </tr>
            <tr class="clinic-info__row">
              <th class="clinic-info__th">電話番号</th>
              <td class="clinic-info__td">
                <a href="tel:0534526567" class="clinic-info__tel">
                  <span class="clinic-info__tel-icon" aria-hidden="true">
                    <img src="<?php echo IMAGEPATH; ?>/common/tel_icon.svg" alt="電話番号" width="20" height="20" aria-hidden="true">
                  </span>
                  053-452-6567（クリックで発信）
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <section class="clinic-hours" id="hours">
    <div class="clinic-hours__bg-top">
      <img src="<?php echo IMAGEPATH; ?>/common/bg-top.svg" alt="診療時間" width="1366" height="111" class="clinic-hours__bg-img">
    </div>
    <div class="clinic-hours__bg-bottom">
      <img src="<?php echo IMAGEPATH; ?>/common/bg-bottom.svg" alt="診療時間" width="1366" height="111" class="clinic-hours__bg-img">
    </div>
    <div class="clinic-hours__inner">
      <div class="clinic-hours__heading section-heading js-section-heading">
        <h2 class="section-heading__title">診療時間</h2>
        <img src="<?php echo IMAGEPATH; ?>/common/section_icon.svg" alt="セクション見出しの装飾アイコン" width="27" height="32" aria-hidden="true" class="section-heading__icon">
      </div>

      <div class="js-fade-up">
        <div class="clinic-hours__table-wrap">
          <table class="clinic-hours__table">
            <thead>
              <tr class="clinic-hours__head-row">
                <th class="clinic-hours__th clinic-hours__th--label" scope="col">診療時間</th>
                <th class="clinic-hours__th" scope="col">月</th>
                <th class="clinic-hours__th" scope="col">火</th>
                <th class="clinic-hours__th" scope="col">水</th>
                <th class="clinic-hours__th" scope="col">木</th>
                <th class="clinic-hours__th" scope="col">金</th>
                <th class="clinic-hours__th" scope="col">土</th>
                <th class="clinic-hours__th" scope="col">日</th>
              </tr>
            </thead>
            <tbody>
              <tr class="clinic-hours__body-row">
                <td class="clinic-hours__label">午前</td>
                <td class="clinic-hours__cell"><span class="clinic-hours__dot" aria-hidden="true"></span></td>
                <td class="clinic-hours__cell"><span class="clinic-hours__dot" aria-hidden="true"></span></td>
                <td class="clinic-hours__cell"><span class="clinic-hours__dot" aria-hidden="true"></span></td>
                <td class="clinic-hours__cell"><span class="clinic-hours__dot" aria-hidden="true"></span></td>
                <td class="clinic-hours__cell"><span class="clinic-hours__dot" aria-hidden="true"></span></td>
                <td class="clinic-hours__cell"><img src="<?php echo IMAGEPATH; ?>/common/sankaku.svg" alt="土曜午前" width="24" height="24" class="clinic-hours__sankaku" aria-hidden="true"></td>
                <td class="clinic-hours__cell clinic-hours__cell--closed"><img src="<?php echo IMAGEPATH; ?>/common/batu.svg" alt="休診" width="24" height="24" class="clinic-hours__batu" aria-hidden="true"></td>
              </tr>
              <tr class="clinic-hours__body-row clinic-hours__body-row--alt">
                <td class="clinic-hours__label">午後</td>
                <td class="clinic-hours__cell"><span class="clinic-hours__dot" aria-hidden="true"></span></td>
                <td class="clinic-hours__cell"><span class="clinic-hours__dot" aria-hidden="true"></span></td>
                <td class="clinic-hours__cell"><span class="clinic-hours__dot" aria-hidden="true"></span></td>
                <td class="clinic-hours__cell clinic-hours__cell--closed"><img src="<?php echo IMAGEPATH; ?>/common/batu.svg" alt="休診" width="24" height="24" class="clinic-hours__batu" aria-hidden="true"></td>
                <td class="clinic-hours__cell"><span class="clinic-hours__dot" aria-hidden="true"></span></td>
                <td class="clinic-hours__cell clinic-hours__cell--closed"><img src="<?php echo IMAGEPATH; ?>/common/batu.svg" alt="休診" width="24" height="24" class="clinic-hours__batu" aria-hidden="true"></td>
                <td class="clinic-hours__cell clinic-hours__cell--closed"><img src="<?php echo IMAGEPATH; ?>/common/batu.svg" alt="休診" width="24" height="24" class="clinic-hours__batu" aria-hidden="true"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <ul class="clinic-hours__note">
          <li class="clinic-hours__note-item">・午前：8:30〜12:00（受付は11:30まで）</li>
          <li class="clinic-hours__note-item">・午後：15:00〜18:30（受付は17:30まで）</li>
          <li class="clinic-hours__note-item">※第3・第5土曜は休診</li>
        </ul>
      </div>

      <div class="clinic-hours__guide">
        <div class="clinic-hours__guide-heading section-heading js-section-heading">
          <h3 class="section-heading__title">神経ブロック療法を<br class="u-mobile">ご希望される患者さんへ</h3>
          <img src="<?php echo IMAGEPATH; ?>/common/section_icon.svg" alt="セクション見出しの装飾アイコン" width="27" height="32" aria-hidden="true" class="section-heading__icon">
        </div>
        <div class="clinic-hours__guide-content js-fade-in --delay-1">
          <p class="clinic-hours__guide-text">
            患者さんの安全のため、神経ブロック療法をご希望される方は、<br><span class="clinic-hours__guide-text-highlight">終了1時間前（午前：11時、午後：17時）</span>までにご来院ください。
          </p>
          <div class="clinic-hours__therapy-box">
            <div class="clinic-hours__therapy-head">
              <p class="clinic-hours__therapy-title">神経ブロック療法</p>
            </div>
            <ul class="clinic-hours__therapy-list">
              <li class="clinic-hours__therapy-item">・硬膜外ブロック療法（腰部・仙骨）</li>
              <li class="clinic-hours__therapy-item">・トリガーポイント</li>
              <li class="clinic-hours__therapy-item">・肩甲上ブロック</li>
              <li class="clinic-hours__therapy-item">・星状神経節ブロック&emsp;&emsp;など</li>
            </ul>
          </div>
          <p class="clinic-hours__guide-note">
            ※病状の把握および神経ブロックの際には安静時間が必要となります。<br>
            ※電気、牽引などの治療をご希望される方もご協力お願いいたします。
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="facility" id="facility">
    <div class="facility__inner">
      <div class="facility__heading section-heading js-section-heading">
        <h2 class="section-heading__title">施設紹介</h2>
        <img src="<?php echo IMAGEPATH; ?>/common/section_icon.svg" alt="セクション見出しの装飾アイコン" width="27" height="32" aria-hidden="true" class="section-heading__icon">
      </div>
      <ul class="facility__list">
        <li class="facility__item js-facility-item">
          <h3 class="facility__item-head"><span class="facility__item-head-text">外観写真</span></h3>
          <div class="facility__item-img-wrap">
            <img src="<?php echo IMAGEPATH; ?>/top/facility01.webp" alt="クリニック外観" width="545" height="320" class="facility__item-img" loading="lazy">
          </div>
        </li>
        <li class="facility__item js-facility-item">
          <h3 class="facility__item-head"><span class="facility__item-head-text">待合室</span></h3>
          <div class="facility__item-img-wrap">
            <img src="<?php echo IMAGEPATH; ?>/top/facility02.webp" alt="待合室の様子" width="545" height="320" class="facility__item-img" loading="lazy">
          </div>
        </li>
        <li class="facility__item js-facility-item">
          <h3 class="facility__item-head"><span class="facility__item-head-text">治療室</span></h3>
          <div class="facility__item-img-wrap">
            <img src="<?php echo IMAGEPATH; ?>/top/facility03.webp" alt="治療室の様子" width="545" height="320" class="facility__item-img" loading="lazy">
          </div>
        </li>
      </ul>
    </div>
  </section>

  <section class="access" id="access">
    <div class="access__inner">
      <div class="access__content">
        <div class="access__heading section-heading js-section-heading">
          <h2 class="section-heading__title">アクセス情報</h2>
          <img src="<?php echo IMAGEPATH; ?>/common/section_icon.svg" alt="セクション見出しの装飾アイコン" width="27" height="32" aria-hidden="true" class="section-heading__icon">
        </div>
        <div class="js-fade-in">
          <div class="access__map-wrap">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3279.4611473488158!2d137.71093292755575!3d34.718768797997605!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x601adee59eca050b%3A0xd6598f855f717bcc!2z44CSNDMyLTgwMTIg6Z2Z5bKh55yM5rWc5p2-5biC5Lit5aSu5Yy65biD5qmL77yT5LiB55uu77yR77yU4oiS77yR77yX!5e0!3m2!1sja!2sjp!4v1771978336221!5m2!1sja!2sjp" width="921" height="464" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="さくらクリニックの地図"></iframe>
          </div>
          <div class="access__info">
            <p class="access__info-item">●〒432-8012 静岡県浜松市中央区布橋3丁目14-17</p>
            <p class="access__info-item">●遠鉄バス「浜松北高」下車 徒歩5分</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="top-contact" id="contact">
    <div class="top-contact__inner">
      <div class="top-contact__heading section-heading js-section-heading">
        <h2 class="section-heading__title">お問い合わせ</h2>
        <img src="<?php echo IMAGEPATH; ?>/common/section_icon.svg" alt="セクション見出しの装飾アイコン" width="27" height="32" aria-hidden="true" class="section-heading__icon">
      </div>
      <div class="top-contact__tel-block js-fade-in --delay-2">
        <a href="tel:0534526567" class="top-contact__tel-link">
          <span class="top-contact__tel-main">
            <span class="top-contact__tel-icon" aria-hidden="true">
              <img src="<?php echo IMAGEPATH; ?>/common/tel_icon.svg" alt="電話" width="28" height="28">
            </span>
            <span class="top-contact__tel-number">053-452-6567</span>
          </span>
          <span class="top-contact__tel-call-note">（クリックで発信）</span>
        </a>
        <p class="top-contact__tel-note top-contact__tel-note--brown">（診療時間内に電話受付）</p>
      </div>
    </div>
  </section>

  <section class="top-philosophy" id="philosophy">
    <div class="top-philosophy__inner">
      <div class="top-philosophy__block js-fade-in">
        <h2 class="top-philosophy__heading">
          <span class="top-philosophy__bar" aria-hidden="true"></span>
          基本理念
        </h2>
        <p class="top-philosophy__lead">
          「医療人たる前に、誠の人間たれ」<br class="u-mobile">
          の精神を胸に、<br class="u-desktop">患者さんに寄り添い<br class="u-mobile">
          地域のかかりつけ医として<br class="u-mobile">
          いつでも頼れる医療の提供を目指します。
        </p>
      </div>
      <div class="top-philosophy__block js-fade-in">
        <h2 class="top-philosophy__heading">
          <span class="top-philosophy__bar" aria-hidden="true"></span>
          基本方針
        </h2>
        <ul class="top-philosophy__list">
          <li class="top-philosophy__item">
            <span class="top-philosophy__label">患者対応</span>
            <p class="top-philosophy__text">患者中心の医療：患者さんの人間性（もしくは権利）を尊重し、思いやりと誠実さをもって接します。</p>
          </li>
          <li class="top-philosophy__item">
            <span class="top-philosophy__label">医療の質</span>
            <p class="top-philosophy__text">医療安全管理を徹底し、安全で質の高い医療を提供します。</p>
          </li>
          <li class="top-philosophy__item">
            <span class="top-philosophy__label">地域貢献・連携</span>
            <p class="top-philosophy__text">地域医療機関と連携し、地域全体の健康と福祉に貢献します。</p>
          </li>
          <li class="top-philosophy__item">
            <span class="top-philosophy__label">組織運営</span>
            <p class="top-philosophy__text">職員一人一人がチーム医療の一翼を担うことを自覚し、一丸となった医療を提供します。</p>
          </li>
        </ul>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>