<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <?php echo view('snippets', ['location' => 'header']) ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php echo apply_filters('body_attributes', '') ?>>
<?php echo view('snippets', ['location' => 'body_top']) ?>
<?php wp_body_open(); ?>
<?php do_action('get_header'); ?>

<div id="app">
  <?php echo view(app('sage.view'), app('sage.data'))->render(); ?>
</div>

<?php do_action('get_footer'); ?>
<?php wp_footer(); ?>
<?php echo view('snippets', ['location' => 'body_bottom']) ?>
</body>
</html>
