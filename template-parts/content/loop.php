<?php $is_card = hash_config('post_style') === 'card'; ?>

<article <?php post_class($is_card ? 'border border-gray-200 rounded-lg overflow-hidden' : 'border-b border-gray-100 pb-6'); ?>>
  <?php if ($is_card && has_post_thumbnail()) : ?>
    <a href="<?php the_permalink(); ?>" class="block aspect-video overflow-hidden">
      <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
    </a>
  <?php endif; ?>

  <div class="<?php echo $is_card ? 'p-4' : ''; ?>">
    <?php if (!$is_card && has_post_thumbnail()) : ?>
      <div class="flex gap-6">
        <div class="flex-shrink-0 w-48">
          <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('medium', ['class' => 'w-full h-32 object-cover rounded']); ?>
          </a>
        </div>
        <div class="flex-1">
    <?php endif; ?>

    <h2 class="text-xl font-semibold mb-2">
      <a href="<?php the_permalink(); ?>" class="text-gray-900 no-underline hover:text-primary">
        <?php the_title(); ?>
      </a>
    </h2>

    <div class="text-sm text-gray-500 mb-3">
      <span><?php echo get_the_date(); ?></span>
      <span class="mx-2">·</span>
      <span><?php the_category(', '); ?></span>
    </div>

    <p class="text-gray-600 leading-relaxed">
      <?php echo wp_trim_words(get_the_excerpt(), $is_card ? 20 : 40); ?>
    </p>

    <?php if (!$is_card && has_post_thumbnail()) : ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</article>
