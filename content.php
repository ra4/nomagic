<?php
	/**
		* The template for displaying content posts/pages
		*
		*  	
	*/
?>	
<?php
	
	
	$options =  get_option('nomagic_theme_options');//code to hide/display post date on blog page
	$chk=$options['nomagic_post_date_chkbox'];//code to hide/display post date on blog page
	
?>
<article class="post <?php if ( has_post_thumbnail() ) { ?>has-thumbnail <?php } ?>">
	<!-- post-thumbnail -->
	<div class="post-thumbnail">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
	</div><!-- /post-thumbnail -->
	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<p class="post-info"><?php //if checked then hide post date on blog page
		if($chk==1){echo ' by '; echo '<a href=';  echo get_author_posts_url(get_the_author_meta('ID'));echo'>'; the_author(); echo'</a> | Posted in';}else{
			//if Not checked then hide post date on blog page
			the_time('F j, Y g:i a'); echo ' by '; echo '<a href=';  echo get_author_posts_url(get_the_author_meta('ID'));echo'>'; the_author(); echo'</a> | Posted in';} ?> 
	
		<?php
			$categories = get_the_category();
			$separator = ", ";
			$output = '';		
			if ($categories) {
				foreach ($categories as $category) {
					
					$output .= '<a href="' . get_category_link($category->term_id) . '">' . $category->cat_name . '</a>'  . $separator;
					
				}
				echo trim($output, $separator);
			}
		?>
	</p>
	<?php if ( is_search() OR is_archive() ) { ?>
		<p>
			<?php echo get_the_excerpt(); ?>
			<a href="<?php the_permalink(); ?>">Read more&raquo;</a>
		</p>
		<?php } else {
		the_content();
		}
		?>
		</article>
		<div class="entry-meta">
		<?php
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
		comments_template(); 
		endif;
		edit_post_link( __( 'Edit', 'nomagic' ), '<span class="edit-link">', '</span>' );
		?>
		</div>
				