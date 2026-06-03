<?php get_header(); ?>

<div class="max-w-7xl mx-auto px-4 py-8">
  <h1 class="text-2xl font-bold mb-8">
    搜索：<?php echo get_search_query(); ?>
  </h1>

  <?php if (have_posts()) : ?>
    <div class="grid gap-6 <?php echo hash_config('post_style') === 'card' ? 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3' : ''; ?>">
      <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('template-parts/content/loop'); ?>
      <?php endwhile; ?>
    </div>

    <div class="mt-8">
      <?php the_posts_pagination(['class' => 'flex justify-center gap-2']); ?>
    </div>
  <?php else : ?>
    <p class="text-gray-500">未找到匹配结果</p>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
