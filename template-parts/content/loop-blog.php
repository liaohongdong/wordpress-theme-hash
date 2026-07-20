<article <?php post_class('shadow-sm rounded-xl overflow-hidden hover:shadow-md transition-shadow bg-base-100 break-inside-avoid mb-6'); ?>>
  <?php if (has_post_thumbnail()) : ?>
    <a href="<?php the_permalink(); ?>" class="block overflow-hidden">
      <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover hover:scale-105 transition-transform duration-300']); ?>
    </a>
  <?php endif; ?>

  <div class="p-4 sm:p-5">
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
      <?php echo wp_trim_words(get_the_excerpt(), 16); ?>
    </p>
  </div>
</article>
