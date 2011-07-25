/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

$(document).ready(function(){
	$(".menu > li").click(function(e){
		switch(e.target.id){
			case "wall":
				//change status & style menu
				$("#wall").addClass("active");
				$("#info").removeClass("active");
				$("#links").removeClass("active");
				$("#interests").removeClass("active");
				$("#photos").removeClass("active");
				//display selected division, hide others
				$("div.wall").fadeIn();
				$("div.info").css("display", "none");
				$("div.links").css("display", "none");
				$("div.interests").css("display", "none");
				$("div.photos").css("display", "none");
			break;
			case "info":
				//change status & style menu
				$("#wall").removeClass("active");
				$("#info").addClass("active");
				$("#links").removeClass("active");
				$("#interests").removeClass("active");
				$("#photos").removeClass("active");
				//display selected division, hide others
				$("div.info").fadeIn();
				$("div.wall").css("display", "none");
				$("div.links").css("display", "none");
				$("div.interests").css("display", "none");
				$("div.photos").css("display", "none");
			break;
			case "links":
				//change status & style menu
				$("#wall").removeClass("active");
				$("#info").removeClass("active");
				$("#links").addClass("active");
				$("#interests").removeClass("active");
				$("#photos").removeClass("active");
				//display selected division, hide others
				$("div.links").fadeIn();
				$("div.wall").css("display", "none");
				$("div.info").css("display", "none");
				$("div.interests").css("display", "none");
				$("div.photos").css("display", "none");
			break;
			case "interests":
				//change status & style menu
				$("#wall").removeClass("active");
				$("#info").removeClass("active");
				$("#links").removeClass("active");
				$("#interests").addClass("active");
				$("#photos").removeClass("active");
				//display selected division, hide others
				$("div.info").css("display", "none");
				$("div.wall").css("display", "none");
				$("div.links").css("display", "none");
				$("div.interests").fadeIn();
				$("div.photos").css("display", "none");
			break;
			case "photos":
			  //change status & style menu
			  $("#wall").removeClass("active");
			  $("#info").removeClass("active");
			  $("#links").removeClass("active");
			  $("#interests").removeClass("active");
			  $("#photos").addClass("active");
			  //display selected division, hide others
			  $("div.info").css("display", "none");
			  $("div.wall").css("display", "none");
			  $("div.links").css("display", "none");
			  $("div.interests").css("display", "none");
			  $("div.photos").fadeIn();
			break;
		}
		//alert(e.target.id);
		return false;
	});
});
