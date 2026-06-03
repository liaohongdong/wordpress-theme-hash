<?php get_header(); ?>

<div class="max-w-3xl mx-auto px-4 py-8">
  <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('template-parts/content/single'); ?>
  <?php endwhile; ?>
</div>

<?php get_footer(); ?>
