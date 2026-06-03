<?php get_header(); ?>

<div class="max-w-3xl mx-auto px-4 py-8">
  <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class('prose max-w-none'); ?>>
      <h1 class="text-3xl font-bold mb-6"><?php the_title(); ?></h1>
      <div><?php the_content(); ?></div>
    </article>
  <?php endwhile; ?>
</div>

<?php get_footer(); ?>
