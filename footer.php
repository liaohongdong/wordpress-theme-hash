  </main>

  <footer class="border-t border-gray-200 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 pb-6 sm:pb-8 border-b border-gray-100">
        <div>
          <h3 class="text-sm font-semibold text-gray-900 mb-3">关于</h3>
          <p class="text-sm text-gray-500 leading-relaxed">
            <?php echo wp_kses_post(hash_config('footer_about_me', '底部关于我们说明')); ?>
          </p>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-gray-900 mb-3">快速链接</h3>
          <?php wp_nav_menu([
            'theme_location' => 'primary',
            'container' => false,
            'depth' => 1,
            'fallback_cb' => '__return_false',
            'items_wrap' => '<ul class="space-y-2">%3$s</ul>',
          ]); ?>
        </div>
        <div class="sm:col-span-2 lg:col-span-1">
          <h3 class="text-sm font-semibold text-gray-900 mb-3">搜索</h3>
          <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="flex gap-2">
            <input type="search" name="s" placeholder="搜索..."
              class="flex-1 min-w-0 px-3 py-2.5 border border-gray-200 rounded-lg text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
            <button type="submit" class="px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark active:bg-primary-dark transition-colors cursor-pointer">搜索</button>
          </form>
        </div>
      </div>
      <div class="pt-5 sm:pt-6 text-center text-xs sm:text-sm text-gray-400">
        <?php echo wp_kses_post(hash_config('footer_info', '&copy; Hash Theme')); ?>
      </div>
    </div>
  </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
