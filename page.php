<?php get_header(); ?>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
  <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class(); ?>>
      <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-6"><?php the_title(); ?></h1>
      <div class="entry-content max-w-none">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; ?>
</div>

<?php get_footer(); ?>
