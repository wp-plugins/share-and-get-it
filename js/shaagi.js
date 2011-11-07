$(function(){
	// Clears floted elements
	$("#nav, #slider_container, a.small_button, a.large_button, #author_bio, input.submit, button").after("<div class='clear'></div>");
	$("#body_content, .folio1, #content, #header, .post, #sgl_post .post_image_container, .post_widgets, .post_share,  ul#comments_container li .comment_container, #comment_form_container #comment_form, .full .folio3, #footer, .featured_box").append('<div class="clear"></div>');
});

$(window).load(function(){
	
	// SuperFish dropDown navigation options
	$("ul#nav").superfish({ 
		animation:		{height:'show', opacity:'show'},
		delay:			600,
		autoArrows:		true,
    	dropShadows:	false
	});
	$('#page_title ul.breadcrumb_nav li').append(" /");
	
	/* IMAGES ------------------------------------------------------------- */
	// this script is to resize all images by 6px the total px of the padding (2px x 2) and border (1px x 2)
	$("#body_content img").each(function(){
		var newImgWidth = $(this).width() - 6;
		$(this).width(newImgWidth);
		
		var parentHeight = $(this).innerHeight() + 2;
		var parentWidth = $(this).outerWidth();
		var parentCss = {
			  'height' : parentHeight,
			  'width' : parentWidth
			}
		
		if( $(this).parent("a") ){
			$(this).parent("a").css(parentCss)
		}
	});
	
	// adds the fading effect when an image is wraped with an anchor tag and a animation class added to it
	$("a.go, a.play, a.zoom, a.view, a.read_more, a.external, a.arrow_left, a.arrow_right, a.read_article, a.zoom_rounded").hover(function(){
		$("img", this).stop().animate({ "opacity": 0.3 }, 400);
		}, function() {
		$("img", this).stop().animate({ "opacity": 1 }, 250);
	});
	
	// for images with caption
	$("#body_content img.with_caption").each(function(){
		var	caption = $(this).attr("title");
		var imgWidth = $(this).outerWidth();
		
		$(this).wrap('<span class="image_caption"></span>');
		$('span.image_caption').append('<span class="caption">' + caption + '</span>');
		$('span.image_caption').css('width', imgWidth - 2);
		
		// converts all the align and reset class for the outer span
		if($(this).hasClass('alignleft')){
			$('span.image_caption').addClass('alignleft');
			$(this).removeClass('alignleft');
		} else if($(this).hasClass('alignright')){
			$('span.image_caption').addClass('alignright')
			$(this).removeClass('alignright');
		}
		if($(this).hasClass('noTopMargin')){
			$('span.image_caption').addClass('noTopMargin');
			$(this).removeClass('noTopMargin');
		}
		if($(this).hasClass('noBottomMargin')){
			$('span.image_caption').addClass('noBottomMargin');
			$(this).removeClass('noBottomMargin');
		}
		if($(this).hasClass('noLeftMargin')){
			$('span.image_caption').addClass('noLeftMargin');
			$(this).removeClass('noLeftMargin');
		}
		if($(this).hasClass('noRightMargin')){
			$('span.image_caption').addClass('noRightMargin');
			$(this).removeClass('noRightMargin');
		}
	})
	/* END IMAGES --------------------------------------------------------- */
	
	// adds the project name in portfolio option 2
	$("ul#folio2 li a img").each(function(){
		 var alt = $(this).attr("alt");
		 $(this).parent().before('<span class="project_name">'+alt+'</span>')
	});
	
	// adds the dropshadow in the homepage slider
	$("#slider_container").prepend('<span id="slider_bottom_shadow"></span>');
	
	// controls the fading effect of the direction nav of the slider in portfolio option 3
	// fade in on hover and ends on mouse out
	$(".folio3 .project_slideshow").each(function(){
		$(".nivo-directionNav a", this).css("opacity", 0);
		}).hover(function(){
		$(".nivo-directionNav a", this).stop().animate({ "opacity": 1 }, 250);
		}, function() {
		$(".nivo-directionNav a", this).stop().animate({ "opacity": 0 }, 250);
	});
	
	// Adds the curved edges on the dropDown	
	$("ul#nav li > ul.subnav li:first-child").addClass("first_item");
	$("ul#nav li > ul.subnav li:last-child").addClass("last_item");
	
	// Removes last block breaker from posts on home & blog pages
	$("div.post:last").addClass("last");
	
	// $("h1:has(em), h2:has(em)").addClass("noBottomBorder");
	$("#front_boxes").append("<div class='clear front_box_bottom'></div>");
	$("#sidebar .inline_content_widget, #sidebar .tabbed_widget").append("<div class='widget_bottom'></div>");
	
	$(".folio1").css("marginBottom", 40);
	$("ul.folio2 li").css("marginBottom", 20);

	
	// Site Notices fadeout when clicked
	$(".success_notice, .error_notice, .warning_notice, .info_notice").click(function(){
		$(this).fadeOut('fast', function(){
			$(this).remove();	
		});
	});
	
	// Buttons IE7 fix
	var isIE7 = (navigator.appVersion.indexOf("MSIE 7.")==-1) ? false : true;
	if (isIE7) {
		$('a.small_button.view, a.large_button.view, a.small_button.arrow, a.large_button.arrow, a.small_button.external_link, a.large_button.external_link').wrapInner('<span class="button_content"></span>');
		$('a.small_button.view, a.large_button.view').append('<span class="view_icon"></span>');
		$('a.small_button.arrow, a.large_button.arrow').append('<span class="arrow_icon"></span>');
		$('a.small_button.external_link, a.large_button.external_link').append('<span class="external_link_icon"></span>');

	} else {
		$('a.small_button.view, a.large_button.view').append('<span class="view_icon"></span>');
		$('a.small_button.arrow, a.large_button.arrow').append('<span class="arrow_icon"></span>');
		$('a.small_button.external_link, a.large_button.external_link').append('<span class="external_link_icon"></span>');
	}
	
	// Auhtor Bio on signle post page
	$("#author_bio_container #bio").wrapInner('<div id="bio_content"></div>');
	$("#author_bio_container #bio").prepend('<div id="bio_tip_top"></div>');
	
	// Blockqoutes
	$('blockquote').wrapInner('<span class="blockquote_content"></span>');
	
	// Tabs in sidebar
	$("ul.widget_tabs li:first-child a").addClass("first_tab");
	$("ul.widget_tabs li:last-child a").addClass("last_tab");
	$('ul.widget_tabs li a').wrap('<span />');
	$("ul.widget_tabs").tabs("div.widget_tabs_content > div.tab_content", {
		effect: 'slide'
	});
	
});
