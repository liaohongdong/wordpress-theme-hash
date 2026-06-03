<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/frontend.css">
</head>
<body <?php body_class('antialiased'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="min-h-screen flex flex-col">
  <header class="border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
      <div class="text-xl font-bold">
        <a href="<?php echo home_url(); ?>" class="text-gray-900 no-underline">
          <?php bloginfo('name'); ?>
        </a>
      </div>
      <nav class="hidden md:flex gap-6">
        <?php wp_nav_menu(['theme_location' => 'primary', 'container' => false, 'menu_class' => 'flex gap-6 list-none m-0 p-0']); ?>
      </nav>
    </div>
  </header>

  <main id="main" class="flex-1">
