<?php
/**
 * The template for displaying posts in the Aside post format
 */
?>

<article class="post post-aside">
    <h2><?php the_title(); ?></h2>
    <p class="mini-meta"><a href="<?php the_permalink(); ?>"><?php the_author(); ?> @ <?php the_time('F j, Y'); ?></a></p>
    <?php the_content(); ?>

</article>