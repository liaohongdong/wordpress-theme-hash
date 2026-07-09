<?php get_header(); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 text-center">
  <h1 class="text-7xl sm:text-9xl font-bold text-base-content/20 mb-4">404</h1>
  <p class="text-lg sm:text-xl text-base-content/60 mb-2">页面未找到</p>
  <p class="text-sm text-base-content/50 mb-8">你访问的页面不存在或已被移除</p>
  <a href="<?php echo home_url(); ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-primary-content rounded-xl text-sm font-medium no-underline hover:bg-primary-dark transition-colors">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
    返回首页
  </a>
</div>

<?php get_footer(); ?>
