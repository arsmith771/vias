document.getElementsByTagName("body")[0].className += " js"; //Add .js class to body tag if JavaScript is enabled

function scollToAnim(elem1, elem2){

    var linkTo = jQuery(elem1);

    jQuery(linkTo).on('click', function(event){

        event.preventDefault();
        jQuery('html, body').animate({ scrollTop: jQuery(elem2).offset().top}, 1000);

    });
}

function scrollToTop(){

	jQuery('#back-to-top').on('click', function(event) {

    	jQuery('html, body').animate({ scrollTop: 0 }, 500);
     	event.preventDefault();

	});
}

function showHideCta(){

	var scrolled = jQuery('html').scrollTop();
	//console.log(scrolled);
	if ( scrolled > 0 ) {
		jQuery('#back-to-top').show();
	} else {
		jQuery('#back-to-top').hide();
	}
}

jQuery(document).ready(function(){

	scollToAnim('a[href^="#contact-us"]', '#contact-us');
	scrollToTop();
});

jQuery(window).on('scroll', function(){

	showHideCta();
});