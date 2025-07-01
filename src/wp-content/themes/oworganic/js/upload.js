jQuery(document).ready(function($){
	"use strict";
	var oworganic_upload;
	var oworganic_selector;

	function oworganic_add_file(event, selector) {

		var upload = $(".uploaded-file"), frame;
		var $el = $(this);
		oworganic_selector = selector;

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( oworganic_upload ) {
			oworganic_upload.open();
			return;
		} else {
			// Create the media frame.
			oworganic_upload = wp.media.frames.oworganic_upload =  wp.media({
				// Set the title of the modal.
				title: "Select Image",

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: "Selected",
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
				}
			});

			// When an image is selected, run a callback.
			oworganic_upload.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = oworganic_upload.state().get('selection').first();

				oworganic_upload.close();
				oworganic_selector.find('.upload_image').val(attachment.attributes.url).change();
				if ( attachment.attributes.type == 'image' ) {
					oworganic_selector.find('.oworganic_screenshot').empty().hide().prepend('<img src="' + attachment.attributes.url + '">').slideDown('fast');
				}
			});

		}
		// Finally, open the modal.
		oworganic_upload.open();
	}

	function oworganic_remove_file(selector) {
		selector.find('.oworganic_screenshot').slideUp('fast').next().val('').trigger('change');
	}
	
	$('body').on('click', '.oworganic_upload_image_action .remove-image', function(event) {
		oworganic_remove_file( $(this).parent().parent() );
	});

	$('body').on('click', '.oworganic_upload_image_action .add-image', function(event) {
		oworganic_add_file(event, $(this).parent().parent());
	});

});