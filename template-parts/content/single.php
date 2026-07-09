<article <?php post_class(); ?>>
  <?php $categories = get_the_category(); if ($categories) : ?>
    <div class="flex flex-wrap gap-2 mb-3 sm:mb-4">
      <?php foreach ($categories as $cat) : ?>
        <a href="<?php echo get_category_link($cat->term_id); ?>"
           class="text-xs font-medium text-primary bg-primary/10 px-2.5 sm:px-3 py-1.5 rounded-full hover:bg-primary/20 transition-colors no-underline">
          <?php echo $cat->name; ?>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-3 sm:mb-4 leading-tight"><?php the_title(); ?></h1>

  <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs sm:text-sm text-base-content/50 mb-6 sm:mb-8 pb-5 sm:pb-6">
    <span class="inline-flex items-center gap-1.5">
      <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
      <?php echo get_the_date('Y-m-d'); ?>
    </span>
    <span class="inline-flex items-center gap-1.5">
      <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
      <?php the_author(); ?>
    </span>
    <?php if (comments_open()) : ?>
      <span class="inline-flex items-center gap-1.5">
        <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z"/></svg>
        <?php comments_number('0 评论', '1 评论', '% 评论'); ?>
      </span>
    <?php endif; ?>
  </div>

  <?php if (has_post_thumbnail()) : ?>
    <div class="mb-6 sm:mb-8 -mx-4 sm:mx-0">
      <?php the_post_thumbnail('large', ['class' => 'w-full h-auto rounded-none sm:rounded-xl']); ?>
    </div>
  <?php endif; ?>

  <div class="entry-content max-w-none">
    <?php the_content(); ?>
  </div>

  <?php if (has_tag()) : ?>
    <div class="mt-8 sm:mt-10 pt-6 sm:pt-8">
      <?php the_tags('<span class="text-sm font-medium text-base-content/60">标签：</span> ', ' ', ''); ?>
    </div>
  <?php endif; ?>

  <?php
  $prev = get_previous_post();
  $next = get_next_post();
  if ($prev || $next) : ?>
  <nav class="mt-10 sm:mt-12 pt-6 sm:pt-8 flex flex-col sm:flex-row gap-4 sm:gap-6">
    <?php if ($prev) : ?>
      <a href="<?php echo get_permalink($prev); ?>" class="flex-1 group p-4 sm:p-5 rounded-xl shadow-sm no-underline hover:bg-primary/5 transition-all">
        <span class="text-xs text-base-content/50">← 上一篇</span>
        <p class="text-sm sm:text-base font-medium text-base-content/80 group-hover:text-primary mt-1 line-clamp-2"><?php echo get_the_title($prev); ?></p>
      </a>
    <?php endif; ?>
    <?php if ($next) : ?>
      <a href="<?php echo get_permalink($next); ?>" class="flex-1 group p-4 sm:p-5 rounded-xl shadow-sm no-underline hover:bg-primary/5 transition-all text-right">
        <span class="text-xs text-base-content/50">下一篇 →</span>
        <p class="text-sm sm:text-base font-medium text-base-content/80 group-hover:text-primary mt-1 line-clamp-2"><?php echo get_the_title($next); ?></p>
      </a>
    <?php endif; ?>
  </nav>
  <?php endif; ?>

  <?php if (comments_open() || get_comments_number()) : ?>
    <div class="mt-8 sm:mt-10 pt-6 sm:pt-8">
      <?php comments_template(); ?>
    </div>
  <?php endif; ?>
</article>
