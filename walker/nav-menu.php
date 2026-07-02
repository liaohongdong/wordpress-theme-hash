<?php
if (!defined('ABSPATH')) exit;

class Hash_Nav_Walker extends Walker_Nav_Menu {
  public function start_lvl(&$output, $depth = 0, $args = null) {
    $output .= '<ul>';
  }
  public function end_lvl(&$output, $depth = 0, $args = null) {
    $output .= '</ul>';
  }
  public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
    $classes = empty($item->classes) ? [] : (array) $item->classes;
    $class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
    $output .= '<li class="' . esc_attr($class_names) . '">';
    $has_children = in_array('menu-item-has-children', $classes);
    if ($has_children) {
      $output .= '<details><summary>';
    }
    $atts = [];
    $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
    $atts['target'] = !empty($item->target) ? $item->target : '';
    $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
    $atts['href']   = !empty($item->url) ? $item->url : '';
    $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
    $attributes = '';
    foreach ($atts as $attr => $value) {
      if (!empty($value)) {
        $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }
    $title = apply_filters('the_title', $item->title, $item->ID);
    $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . $title . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;
    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    if ($has_children) {
      $output .= '</summary>';
    }
  }
  public function end_el(&$output, $item, $depth = 0, $args = null) {
    $classes = empty($item->classes) ? [] : (array) $item->classes;
    if (in_array('menu-item-has-children', $classes)) {
      $output .= '</details>';
    }
    $output .= '</li>';
  }
}
