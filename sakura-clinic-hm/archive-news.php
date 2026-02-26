<?php
/*
* Template Name: お知らせ一覧
*/
?>
<?php get_header(); ?>

<main>

  <section class="news-archive">
    <div class="bg-circle bg-circle--04"></div>
    <div class="bg-circle bg-circle--05"></div>
    <div class="news-archive__inner">
      <hgroup class="news-archive__heading news-heading">
        <h2 class="news-heading__title">お知らせ</h2>
        <p class="news-heading__subtitle">news</p>
      </hgroup>
      <?php if (have_posts()) : ?>
      <ul class="news-archive__list news-list">
        <?php while (have_posts()) : the_post(); ?>
        <li class="news-list__item">
          <a href="<?php the_permalink(); ?>" class="news-list__link">
            <time class="news-list__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
            <p class="news-list__item-title"><?php the_title(); ?></p>
          </a>
        </li>
        <?php endwhile; ?>
      </ul>
      <div class="news-archive__pagination pagination">
        <?php get_template_part('parts/pagination'); ?>
      </div>
      <?php else : ?>
      <p class="news-archive__empty">現在投稿はありません</p>
      <?php endif; ?>
      <div class="news-archive__btn">
        <a href="<?php echo HOME_URL; ?>" class="top-link">
          TOPへ戻る
        </a>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>