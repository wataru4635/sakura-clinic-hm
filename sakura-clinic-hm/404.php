<?php
/*
* Template Name: 404ページ
*/
?>
<?php get_header(); ?>

<main>

<section class="not-found">
    <div class="bg-circle bg-circle--04"></div>
    <div class="bg-circle bg-circle--05"></div>
    <div class="not-found__inner">
      <hgroup class="not-found__heading news-heading">
        <h1 class="news-heading__title">404</h1>
        <p class="news-heading__subtitle">Not Found</p>
      </hgroup>
      <h2 class="not-found__title">お探しのページは見つかりませんでした。</h2>
      <p class="not-found__text">
      申し訳ありませんが、アクセスしようとしたページは削除されたか、<br class="u-desktop">
      URLが間違っている可能性があります。
      </p>
      <div class="not-found__top-link-wrap">
        <a href="<?php echo HOME_URL; ?>" class="top-link">TOPへ戻る</a>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
