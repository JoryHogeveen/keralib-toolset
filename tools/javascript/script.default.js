// JavaScript Document

function keralibToolset_init_website($) {
	$.fn.equalizeHeights = function(){return this.height(Math.max.apply(this, $(this).map(function(i,e){return $(e).height();}).get()));};
	if (typeof resize == 'function') {
		resize($);
	}
	
	if ($('.flexslider').length > 0) {
		keralibToolset_initFlexslider($);
	}
}


function keralibToolset_initFlexslider($) {
	// Based on Flexslider 2.2.2
	$(".entry-images .single.carousel.flexslider").flexslider({animation: "slide", animationLoop: false, itemWidth: 150, itemMargin: 5, minItems: 2});
	$(".entry-images .single.slider.flexslider").flexslider({animation: "fade", animationLoop: true, slideshowSpeed: 5000});
	
	$(".entry-images .linked.carousel.flexslider").flexslider({animation: "slide", controlNav: false, directionNav: true, animationLoop: false, slideshow: false, itemWidth: 50, itemMargin: 5, minItems: 2, asNavFor: '.entry-images .linked.slider.flexslider'});
	$(".entry-images .linked.slider.flexslider").flexslider({animation: "slide", controlNav: false, animationLoop: false, slideshow: false, sync: ".entry-images .linked.carousel.flexslider"});
	
	$("#slider.widget-area .slider.flexslider").each(function() {
		$(this).flexslider({
			animation: $(this).attr('data-animation'), 
			animationLoop: $(this).attr('data-animationLoop'), 
			controlNav: $(this).attr('data-controlNav'), 
			directionNav: $(this).attr('data-directionNav'), 
			slideshowSpeed: $(this).attr('data-slideshowSpeed')
		}); 
	});
	
	if ($('.flexslider.vertical-align-middle').length > 0) {
		keralibToolset_verticalAlignMiddle_Flexslider($);
		$(window).resize(function() {keralibToolset_verticalAlignMiddle_Flexslider($);});
		$('.flexslider.vertical-align-middle').each(function(){
			$(this).resize(function() {keralibToolset_verticalAlignMiddle_Flexslider($);});
		});
	}
}

function keralibToolset_verticalAlignMiddle_Flexslider($) {
	
	$('.flexslider.vertical-align-middle').each(function() {
		var ph = $(this).height();
		$('.slides img', this).each(function(){
			$(this).css({'margin-top':'auto'});
			var x = $(this).height() - ph;
			if (x > 0) {
				var m = '-'+(x / 2)+'px';
			} else {
				var m = ''+(x / 2)+'px';
			}
			$(this).css({'margin-top':m});
			console.log(m);
		});
	});
}

jQuery(document).ready(function() {
	keralibToolset_init_website(jQuery);
})