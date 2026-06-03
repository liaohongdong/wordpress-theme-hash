<article <?php post_class(); ?>>
  <h1 class="text-4xl font-bold mb-4"><?php the_title(); ?></h1>

  <div class="text-sm text-gray-500 mb-8">
    <span><?php echo get_the_date(); ?></span>
    <span class="mx-2">·</span>
    <span><?php the_category(', '); ?></span>
    <span class="mx-2">·</span>
    <span><?php the_author(); ?></span>
  </div>

  <?php if (has_post_thumbnail()) : ?>
    <div class="mb-8">
      <?php the_post_thumbnail('large', ['class' => 'w-full rounded-lg']); ?>
    </div>
  <?php endif; ?>

  <div class="prose max-w-none">
    <?php the_content(); ?>
  </div>

  <?php if (has_tag()) : ?>
    <div class="mt-8 pt-6 border-t border-gray-200">
      <?php the_tags('<span class="text-sm font-medium text-gray-500">标签：</span> ', ' '); ?>
    </div>
  <?php endif; ?>
</article>
