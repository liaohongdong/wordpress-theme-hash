<?php $is_card = hash_config('post_style') === 'card'; ?>

<article <?php post_class($is_card
  ? 'shadow-sm rounded-xl overflow-hidden hover:shadow-md transition-shadow bg-base-100'
  : 'pb-5 sm:pb-6 mb-5 sm:mb-6'); ?>>
  <?php if ($is_card && has_post_thumbnail()) : ?>
    <a href="<?php the_permalink(); ?>" class="block aspect-video overflow-hidden">
      <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300']); ?>
    </a>
  <?php endif; ?>

  <div class="<?php echo $is_card ? 'p-4 sm:p-5' : ''; ?>">
    <?php if (!$is_card && has_post_thumbnail()) : ?>
      <div class="flex flex-col sm:flex-row gap-3 sm:gap-6">
        <div class="flex-shrink-0 w-full sm:w-44 lg:w-48">
          <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('medium', ['class' => 'w-full h-48 sm:h-32 object-cover rounded-xl']); ?>
          </a>
        </div>
        <div class="flex-1 min-w-0">
    <?php endif; ?>

    <?php $categories = get_the_category(); if ($categories) : ?>
      <div class="flex flex-wrap gap-1.5 mb-2 sm:mb-3">
        <?php foreach ($categories as $cat) : ?>
          <a href="<?php echo get_category_link($cat->term_id); ?>"
             class="text-[0.7rem] sm:text-xs font-medium text-primary bg-primary/10 px-2 sm:px-2.5 py-1 rounded-full hover:bg-primary/20 transition-colors no-underline">
            <?php echo $cat->name; ?>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <h2 class="text-base sm:text-lg lg:text-xl font-semibold mb-1.5 sm:mb-2 leading-snug">
      <a href="<?php the_permalink(); ?>" class="text-base-content no-underline hover:text-primary transition-colors">
        <?php the_title(); ?>
      </a>
    </h2>

    <div class="text-xs sm:text-sm text-base-content/50 mb-2 sm:mb-3 flex flex-wrap items-center gap-x-3">
      <span><?php echo get_the_date('Y-m-d'); ?></span>
      <span class="hidden sm:inline">·</span>
      <span class="hidden sm:inline"><?php echo get_the_author(); ?></span>
    </div>

    <p class="text-sm sm:text-base text-base-content/70 leading-relaxed">
      <?php echo wp_trim_words(get_the_excerpt(), $is_card ? 16 : 35); ?>
    </p>

    <?php if (!$is_card) : ?>
      <div class="mt-3 sm:mt-4">
        <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-1 text-sm text-primary font-medium hover:text-primary-dark transition-colors no-underline">
          阅读更多
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
        </a>
      </div>
    <?php endif; ?>

    <?php if (!$is_card && has_post_thumbnail()) : ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</article>
