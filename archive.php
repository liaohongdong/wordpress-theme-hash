<?php get_header(); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
  <div class="flex flex-col gap-1 mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-base-content">
      <?php the_archive_title(); ?>
    </h1>
    <?php if (get_the_archive_description()) : ?>
      <p class="text-sm text-base-content/50"><?php echo get_the_archive_description(); ?></p>
    <?php endif; ?>
  </div>

  <?php if (have_posts()) : ?>
    <div class="<?php echo hash_config('post_style') === 'card'
      ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6'
      : 'flex flex-col'; ?>">
      <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('template-parts/content/loop'); ?>
      <?php endwhile; ?>
    </div>

    <?php if ($GLOBALS['wp_query']->max_num_pages > 1) : ?>
      <?php the_posts_pagination([
        'mid_size' => 2,
        'prev_text' => '‹ 上一页',
        'next_text' => '下一页 ›',
      ]); ?>
    <?php endif; ?>

  <?php else : ?>
    <div class="text-center py-20">
      <p class="text-base-content/50 text-lg">暂无内容</p>
    </div>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
