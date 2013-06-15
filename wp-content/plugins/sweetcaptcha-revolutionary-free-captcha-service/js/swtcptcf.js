
//if ( !jQuery.curCSS ) { jQuery.curCSS = jQuery.css; }

jQuery(document).ready(function(){
	jQuery('#swtcptcf_additions_options').change( function() {
		if(jQuery(this).is(':checked') )
			jQuery('.swtcptcf_additions_block').removeClass('swtcptcf_hidden');
		else
			jQuery('.swtcptcf_additions_block').addClass('swtcptcf_hidden');
	});
	jQuery('#swtcptcf_change_label').change( function() {
		if(jQuery(this).is(':checked') )
			jQuery('.swtcptcf_change_label_block').removeClass('swtcptcf_hidden');
		else
			jQuery('.swtcptcf_change_label_block').addClass('swtcptcf_hidden');
	});
	jQuery('#swtcptcf_display_add_info').change( function() {
		if(jQuery(this).is(':checked') )
			jQuery('.swtcptcf_display_add_info_block').removeClass('swtcptcf_hidden');
		else
			jQuery('.swtcptcf_display_add_info_block').addClass('swtcptcf_hidden');
	});
});