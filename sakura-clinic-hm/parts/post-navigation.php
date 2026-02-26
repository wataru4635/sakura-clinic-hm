<?php
$prev_post = get_previous_post();
$next_post = get_next_post();

function render_post_nav_item($post, $class, $direction) {
  if ($post) {
    $url = esc_url(get_permalink($post->ID));
    $title = esc_html(get_the_title($post->ID));
    ?>
    <a href="<?php echo $url; ?>" class="<?php echo esc_attr($class); ?>">
      <?php if ($direction === 'prev'): ?>
        <span class="prev-arrow"></span>
      <?php endif; ?>
      <span class="post-title"><?php echo $title; ?></span>
      <?php if ($direction === 'next'): ?>
        <span class="next-arrow"></span>
      <?php endif; ?>
    </a>
    <?php
  } else {
    echo '<span class="' . esc_attr($class) . ' empty"></span>';
  }
}
?>

<?php render_post_nav_item($prev_post, 'prev-post', 'prev'); ?>
<?php render_post_nav_item($next_post, 'next-post', 'next'); ?>