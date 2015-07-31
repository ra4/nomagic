<?php
/**
 * The template used for displaying post content
 */
get_header();
?>
<!-- site-content -->
<div class="site-content clearfix">

    <!-- main-column -->
    <div class="main-column">
        <h2><?php the_title(); ?></h2>
        <?php
        the_content();
        ?>
    </div><!-- /main-column -->
<?php get_sidebar(); ?>
</div><!-- /site-content -->
<div class="entry-meta">
    <?php
    edit_post_link(__('Edit', 'nomagic'), '<span class="edit-link">', '</span>');
    if (!post_password_required() && ( comments_open() || get_comments_number() )) :
        comments_template();
    endif;
    ?>
</div>
<?php get_footer();
?>