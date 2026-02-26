<?php
/*
* Template Name: お知らせ詳細
*/
?>
<?php get_header(); ?>

<main>

<section class="news-single">
    <div class="bg-circle bg-circle--04"></div>
    <div class="bg-circle bg-circle--05"></div>
    <div class="news-single__inner">
      <hgroup class="news-single__heading news-heading">
        <p class="news-heading__title">お知らせ</p>
        <p class="news-heading__subtitle">news</p>
      </hgroup>
      <h1 class="news-single__title"><?php the_title(); ?></h1>
      <time class="news-single__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
      <div class="news-single__content">
        <?php the_content(); ?>
      </div>
      <div class="news-single__post-navigation post-navigation">
        <?php get_template_part('parts/post-navigation'); ?>
      </div>
      <div class="news-single__btn">
        <a href="<?php echo HOME_URL; ?>" class="top-link">
          TOPへ戻る
        </a>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
