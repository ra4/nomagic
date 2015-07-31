<?php
/**
 * The template for displaying specific post
 */
?>
<?php
get_header();
if (have_posts()):
    while (have_posts()): the_post();
        ?>
        <article class="post">
            <?php
            if (get_post_format() == false) {
                get_template_part('content', 'single');
                previous_post_link();
            } else {
                get_template_part('content', get_post_format());
                previous_post_link('<strong>%link</strong>');
                echo '<br><br>';
                next_post_link('<strong>%link</strong>');
            }
            ?>

        </article>
        <?php
    endwhile;
else :
    echo '<p>No content found</p>';
endif;
get_footer();
?>