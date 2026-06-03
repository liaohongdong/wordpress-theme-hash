  </main>

  <footer class="border-t border-gray-200 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-8 text-center text-sm text-gray-500">
      <?php echo wp_kses_post(hash_config('footer_info', '&copy; Hash Theme')); ?>
    </div>
  </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
