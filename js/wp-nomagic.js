
/* Image uploader for theme option main logo */
jQuery(document).ready(function($){
    $('#upload-btn ,#preview_header_logo').click(function(e) {
		e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
		}).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var nomagic_header_logo = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('.nomagic-logo-upload-btn').val(nomagic_header_logo);
			$('#preview_header_logo').attr("src", nomagic_header_logo);
		});
	});
	$('#remove-btn').click(function(e) {
		$('.nomagic-logo-upload-btn').val('');
		$('#preview_header_logo').attr("src",'');
	});
});