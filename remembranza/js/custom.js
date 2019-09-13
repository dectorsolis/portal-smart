/*
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}



(function($) {

  // Menu filer
  $("#menu-flters li a").click(function() {
    $("#menu-flters li a").removeClass('active');
    $(this).addClass('active');

    var selectedFilter = $(this).data("filter");
    //  $("#menu-wrapper").fadeTo(100, 0);

    $(".menu-restaurant").fadeOut();

    setTimeout(function() {
      $(selectedFilter).slideDown();
      //$("#menu-wrapper").fadeTo(300, 1);
    }, 300);
  });

  // Add smooth scrolling to all links in navbar + footer link
  $(".sidenav a").on('click', function(event) {
    var hash = this.hash;
    if (hash) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function() {
        window.location.hash = hash;
      });
    }

  });

  $(".sidenav a").on('click', function() {
		closeNav();
	});

})(jQuery);*/

var position;

jQuery(".form-remembranzza").submit( function(event){
    event.preventDefault();  

    var form = jQuery(this);
    
    if( isEmpty( form[0]) ){
      jQuery(form[0][position]).focus();
      jQuery("#response").html('Por favor rellena todos los campos');
    }
    else{
      jQuery.ajax({
        url: "mailer/",
        method: "POST",
        data: jQuery(this).serialize(),
        beforeSend: function(){
          jQuery("#response").html("Enviando ...");
        }, 
        success: function(response){
          response = JSON.parse(response);
          jQuery("#response").html(response.html);
        }        
      });
    }


} );

function isEmpty( form ){
  var is_empty = false;
  position = -1;

  for( var i = 0; i< form.length-1 && !is_empty; i++){

    if( form[i].value.length == 0 ){
      is_empty = true;
      position = i;
    }
  }

  return is_empty;
}