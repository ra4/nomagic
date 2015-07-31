<?php /* Custom css file for theme options */ ?>
<style>
<?php
$options = get_option('nomagic_theme_options');
$content = $options['nomagic_custom_css'];
$content = wp_kses($content, array('\'', '\"'));
$content = str_replace('&gt;', '>', $content);
echo $content;
?>
</style>