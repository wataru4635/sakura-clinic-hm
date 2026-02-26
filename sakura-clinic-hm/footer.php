<div class="to-top">
    <img src="<?php echo IMAGEPATH; ?>/common/to-top.svg" class="to-top__img" alt="ページトップへ戻る" width="56" height="55">
 </div>

<footer class="footer">
  <div class="footer__bg-sakura01">
    <picture>
      <source srcset="<?php echo IMAGEPATH; ?>/common/footer_bg_sakura01_sp.svg" media="(max-width: 767px)" type="image/svg+xml" width="173" height="48">
      <img class="" src="<?php echo IMAGEPATH; ?>/common/footer_bg_sakura01.svg" alt="フッター背景装飾（桜）" width="410" height="113" loading="lazy">
    </picture>
  </div>
  <div class="footer__bg-sakura02">
    <picture>
      <source srcset="<?php echo IMAGEPATH; ?>/common/footer_bg_sakura02_sp.svg" media="(max-width: 767px)" type="image/svg+xml" width="117" height="100">
      <img class="" src="<?php echo IMAGEPATH; ?>/common/footer_bg_sakura02.svg" alt="フッター背景装飾（桜）" width="239" height="186" loading="lazy">
    </picture>
  </div>
  <div class="footer__inner">
    <a href="<?php echo HOME_URL; ?>" class="footer__logo-link">
      <img src="<?php echo IMAGEPATH; ?>/common/logo-white.webp" alt="さくらクリニック" width="193" height="34" class="footer__logo-img" loading="lazy">
    </a>
    <p class="footer__copyright">&copy; さくらクリニック all rights reserved.</p>
  </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>