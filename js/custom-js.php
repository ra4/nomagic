<?php /* custom js file for theme options*/?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
	$(window).load(function() {
		<?php
			//fetches data from db 
			$options = get_option( 'nomagic_theme_options' );
			$content= $options['nomagic_custom_js'];
			$content = wp_kses( $content, array( '\'', '\"' ) );
			$content = str_replace ( '&gt;' , '>' , $content );
			echo $content;
			
		?>
	});
</script>