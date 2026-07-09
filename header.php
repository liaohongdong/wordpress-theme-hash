<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <?php wp_head(); ?>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/frontend.css">
</head>
<body <?php body_class('antialiased bg-base-100 text-base-content'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="min-h-screen flex flex-col">
  <header class="sticky top-0 z-40 bg-base-100/80 backdrop-blur-md shadow-sm relative">
    <div class="header-inner w-full px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-14 sm:h-16">
        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
          <?php if (has_custom_logo()) : ?>
            <?php the_custom_logo(); ?>
          <?php elseif ($light_logo = hash_config('light_logo')) : ?>
            <a href="<?php echo home_url(); ?>">
              <picture>
                <?php if ($dark_logo = hash_config('dark_logo')) : ?>
                <source srcset="<?php echo esc_url($dark_logo); ?>" media="(prefers-color-scheme: dark)">
                <?php endif; ?>
                <img src="<?php echo esc_url($light_logo); ?>" alt="<?php bloginfo('name'); ?>" class="max-h-8 sm:max-h-10 w-auto">
              </picture>
            </a>
          <?php else : ?>
            <a href="<?php echo home_url(); ?>" class="text-lg sm:text-xl font-bold tracking-tight text-base-content no-underline hover:text-primary transition-colors truncate">
              <?php bloginfo('name'); ?>
            </a>
          <?php endif; ?>
        </div>

        <nav class="hidden md:block">
          <?php wp_nav_menu([
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => 'menu menu-horizontal gap-1',
            'walker' => new Hash_Nav_Walker(),
            'fallback_cb' => function () {
              echo '<ul class="menu menu-horizontal gap-1"><li><a href="' . home_url() . '">首页</a></li>';
              wp_list_pages(['title_li' => '', 'number' => 5]);
              echo '</ul>';
            },
          ]); ?>
        </nav>

        <div class="flex items-center gap-1">
          <button type="button" id="search-btn" class="p-2.5 text-base-content/50 hover:text-base-content/70 hover:bg-base-200 rounded-xl transition-colors cursor-pointer" aria-label="搜索">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
            </svg>
          </button>
          <?php if (hash_config('change_theme') === 'Y') : ?>
          <button type="button" id="theme-toggle" data-default="<?php echo hash_config('theme_mode') ?: 'light'; ?>" class="p-2.5 text-base-content/50 hover:text-base-content/70 hover:bg-base-200 rounded-xl transition-colors cursor-pointer" aria-label="切换主题">
            <svg class="w-5 h-5 theme-icon-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>
            </svg>
            <svg class="w-5 h-5 theme-icon-dark hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"/>
            </svg>
          </button>
          <?php endif; ?>
          <button type="button" id="menu-btn" class="md:hidden p-2.5 text-base-content/50 hover:text-base-content/70 hover:bg-base-200 rounded-xl transition-colors cursor-pointer" aria-label="菜单">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <div id="mobile-nav" class="mobile-nav absolute top-full left-0 right-0 z-50 bg-base-100 shadow-lg md:hidden">
      <?php wp_nav_menu([
        'theme_location' => 'primary',
        'container' => false,
        'menu_class' => 'menu',
        'fallback_cb' => function () {
          echo '<ul class="menu"><li><a href="' . home_url() . '">首页</a></li>';
          wp_list_pages(['title_li' => '', 'number' => 5]);
          echo '</ul>';
        },
      ]); ?>
    </div>
  </header>

  <div id="search-overlay" class="overlay fixed inset-0 z-50 bg-black/40 backdrop-blur-sm">
    <div class="flex items-start justify-center pt-20 sm:pt-28 px-4">
      <div class="bg-base-100 rounded-2xl shadow-2xl w-full max-w-lg p-5 sm:p-6">
        <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="flex gap-3">
          <input id="search-input" type="search" name="s" placeholder="搜索文章..." autocomplete="off"
            class="flex-1 min-w-0 px-4 py-3 bg-base-200 rounded-xl text-base sm:text-sm outline-none focus:ring-2 focus:ring-primary/20 transition-all">
          <button type="submit" class="px-5 sm:px-6 py-3 bg-primary text-primary-content rounded-xl text-sm font-medium hover:bg-primary-dark active:bg-primary-dark transition-colors cursor-pointer">搜索</button>
        </form>
      </div>
    </div>
  </div>

  <main id="main" class="flex-1">
