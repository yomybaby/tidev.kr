jQuery(document).ready(function() {
    var widgetImages = jQuery('.img-container');
    jQuery.each(widgetImages, function(index, value) {
        var parentWidth = jQuery(this).parents('.smart-post-list').width();
		var parentMarginLeft = jQuery(this).parents('.smart-post-list').css('margin-left');
		var parentMarginRight = jQuery(this).parents('.smart-post-list').css('margin-right');
		var parentPaddingLeft = jQuery(this).parents('.smart-post-list').css('padding-left');
		var parentPaddingRight = jQuery(this).parents('.smart-post-list').css('padding-right');
		var parentComputedWidth = (parseInt(parentWidth) - (parseInt(parentMarginLeft) + parseInt(parentMarginRight) + parseInt(parentPaddingLeft) + parseInt(parentPaddingRight)));
        var imgContainer = jQuery(this);
        if (parentComputedWidth < imgContainer.width()) {
        	jQuery(this).find('img').css('width', parentComputedWidth);
        	imgContainer.css('width', parentComputedWidth);
        }
    });
});