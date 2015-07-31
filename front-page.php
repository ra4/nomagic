<?php

/**
 * The template for FrontPage of the site
 */
get_header();
if (have_posts()):
    while (have_posts()): the_post();
        the_content();
    endwhile;
else :
    echo '<p>N content found</p>';
endif;
get_footer();
?>