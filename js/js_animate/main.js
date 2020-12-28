$.noConflict();
jQuery(document).ready(function($){

 //alert("TEST RONNY GET FUNCTION READY ");

 $("#owl-example").owlCarousel({
    // Most important owl features
    items : 7,
    pagination : true,
    paginationSpeed : 1000,
    autoPlay:3000,
    navigation : true,
    navigationText : ["","<i class='fa fa-angle-right'></i>"],
    slideSpeed : 800,
 });
$("#owl-secondFiches").owlCarousel({
   items :1,
    pagination : true,
    paginationSpeed : 1000,
    autoPlay:3000,
    navigation : true,
    navigationText : ["","<i class='fa fa-angle-right'></i>"],
    slideSpeed : 800,
  //  random:true
});
/*	$("#navigation").sticky({
		topSpacing : 75,
	});

	$('#nav').onePageNav({
		currentClass: 'current',
		changeHash: false,
		scrollSpeed: 15000,
		scrollThreshold: 0.5,
		filter: '',
		easing: 'easeInOutExpo'
	});

     $('#top-nav').onePageNav({
         currentClass: 'active',
         changeHash: true,
         scrollSpeed: 1200
    });*/
//Initiat WOW JS
    new WOW().init();

});
