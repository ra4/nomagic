<?php
	/**
		* The template for displaying Comments
		*
		* The area of the page that contains comments and the comment form.
		
	*/
	
	/*
		* If the current post is protected by a password and the visitor has not yet
		* entered the password we will return early without loading the comments.
	*/
	if ( post_password_required() ) {
		return;
	}
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
	<h2 class="comments-title">
		<?php
			printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'nomagic' ),
			number_format_i18n( get_comments_number() ), get_the_title() );
		?>
	</h2>
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'nomagic' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'nomagic' ) ); ?></div>
	<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'nomagic' ) ); ?></div>
	</nav><!-- #comment-nav-above -->
	<?php endif; // Check for comment navigation. ?>
	<ol class="comment-list">
	<?php
	/* code to hide/display avatars from comments */
	$options =  get_option('nomagic_theme_options');
	$comment_avatars_chk=$options['nomagic_hide_avatars_from_comment_chkbox'];
	
	if($comment_avatars_chk==1){// if hide avatars is checked hide avatars from comments
	$hide_diaplay_avatar=array(
	'style'       => 'ol',
	'short_ping'  => true,
	'avatar_size' => 0,
	);
	}
	else{ //if hide avatars is not checked display avatars from comments
	$hide_diaplay_avatar=array(
	'style'       => 'ol',
	'short_ping'  => true,
	'avatar_size' => 32,
	);
	}
	wp_list_comments($hide_diaplay_avatar);	
	?>
	</ol><!-- .comment-list -->
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
	<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'nomagic' ); ?></h1>
	<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'nomagic' ) ); ?></div>
	<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'nomagic' ) ); ?></div>
	</nav><!-- #comment-nav-below -->
	<?php endif; // Check for comment navigation. ?>
	
	<?php if ( ! comments_open() ) : ?>
	<p class="no-comments"><?php _e( 'Comments are closed.', 'nomagic' ); ?></p>
	<?php endif; 
	 endif; // have_comments() 
	 comment_form(); ?>
	</div><!-- #comments -->
		