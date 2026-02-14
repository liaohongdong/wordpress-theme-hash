<?php
// var_dump(value: 'admin.php loaded');
class Admin
{
  protected $appearance = null;
  static $options = array();

  public function init()
  {
    self::$options = $this->_admin_options();
    if (!empty(self::$options)) {
      // add_action('admin_menu', array($this, 'add_custom_options_page'));
      add_action('admin_menu', array($this, 'add_custom_options_page'));
      add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
      add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));

      add_action('admin_init', array($this, 'settings_init'));
    }
  }

  static function &_admin_options()
  {
    // 外部可通过 add_filter('admin_options_location', 回调函数) 修改配置文件路径
    $location = apply_filters('admin_options_location', get_theme_file_path('/data/admin_options.json'));
    // 读取默认配置
    $data = ConfigReader::read($location);
    self::$options = apply_filters('hash_admin_options', $data);
    return self::$options;
  }
  static function get_admin_options_name()
  {
    $name = 'admin_options';
    return apply_filters('hash_admin_options_name', $name);
  }

  static function menu_settings()
  {
    $menu = array(
      // Modes: submenu, menu
      'mode' => 'submenu',
      // Submenu default settings
      'page_title' => __('Hash主题设置', 'hash'),
      'menu_title' => __('Hash主题设置', 'hash'),
      'capability' => 'edit_theme_options',
      'menu_slug' => 'hash-framework', // 页面的唯一标识，URL 中会显示为 wp-admin/themes.php?page=hash-framework
      'parent_slug' => 'themes.php', // 父菜单（themes.php对应WordPress的“外观”菜单）
      // Menu default settings
      'icon_url' => 'dashicons-admin-generic',
      'position' => '61'
    );
    return apply_filters('hash_admin_menu', $menu);
  }

  function add_custom_options_page()
  {
    $menu = $this->menu_settings();
    $this->appearance = add_theme_page(
      $menu['page_title'],
      $menu['menu_title'],
      $menu['capability'],
      $menu['menu_slug'],
      array('Admin', 'options_page')
    );
  }

  function enqueue_admin_styles($hook)
  {
    if ($this->appearance != $hook)
      return;

    wp_enqueue_style('hash-optionsframework', get_template_directory_uri() . '/assets/css/admin.css', array(), self::$options['version']);
    add_action('admin_class', array($this, 'admin_head_style'));
  }
  function admin_head_style()
  {
    do_action('admin_custom_style');
  }


  function enqueue_admin_scripts($hook)
  {
    if ($this->appearance != $hook)
      return;

    var_dump('enqueue_admin_scripts');
    $deps = [];
    // cdn react 需要babel转义 单独的后台可以考虑----------
    // wp_enqueue_script('hash-react', get_template_directory_uri() . '/assets/js/react.production.min.js', array(), '18.3.1', true);
    // $deps[] = 'hash-react';
    // wp_enqueue_script('hash-react-dom', get_template_directory_uri() . '/assets/js/react-dom.production.min.js', array('hash-react'), '18.3.1', true);
    // $deps[] = 'hash-react-dom';
    // wp_enqueue_script('hash-babel-min', get_template_directory_uri() . '/assets/js/babel.min.js', array(), '6.1.19', true);
    // $deps[] = 'hash-babel-min';
    // cdn react 需要babel转义 单独的后台可以考虑----------
    wp_enqueue_script('hash-jquery', get_template_directory_uri() . '/assets/js/jquery4.0.js', array(), '4.0.0', true);
    $deps[] = 'hash-jquery';
    wp_enqueue_script('hash-tailwindcss', get_template_directory_uri() . '/assets/js/tailwindcss@4.1.18.js', $deps, self::$options['version'], ['in_footer' => true]);
    wp_enqueue_script('hash-admin-js', get_template_directory_uri() . '/assets/js/admin.js', $deps, self::$options['version'], ['in_footer' => true]);

    add_action('admin_js', array($this, 'admin_head_js'));
  }
  function admin_head_js()
  {
    // var_dump('admin_head_js_90');
    do_action('admin_custom_scripts11111');
  }
  function settings_init()
  {
    // $options_framework = new Options_Framework;
    $name = $this->get_admin_options_name();
    // var_dump($name);
    register_setting('hash-framework', $name, array($this, 'validate_options'));

    // register_setting( 'optionsframework', $name, array ( $this, 'validate_options' ) );
  }
  function validate_options($input)
  {
    self::$options = $this->_admin_options();
    return self::$options;
  }

  static function options_page()
  {
    require_once get_template_directory() . '/admin/react/dist/admin.php';
?>
    <!-- <style type="text/tailwindcss">
      @import "tailwindcss" prefix(tw);
      @theme {
        --myself-color: red;
      }
    </style>
    <h1 class="tw:w-[33.333%] tw:text-3xl tw:font-bold tw:underline tw:text-clifford">
      Hello world! aaa12
    </h1> -->
<?php
  }
}
