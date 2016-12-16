$(document).ready(function () {
	var scroll_start = 0;
	var startchange = $('#myCarousel');
	var offset = startchange.offset();
	if (startchange.length) {
		$(document).scroll(function () {
			scroll_start = $(this).scrollTop();
			if (scroll_start > offset.top) {
				$('.navbar-brand').css('visibility', 'visible');
			} else {
				$('.navbar-brand').css('visibility', 'hidden');
			}
		});
	}

	$("#gwolle_gb_write_button").click(function () {
		if ($("#gwolle_gb_new_entry").css('display') == 'none') {
			$("#gwolle_gb_new_entry").show();
		}

	})
});


/*LIEN VOIR PLUS DE PRODUITS SIMILAIRES FICHE PRODUIT*/

/*function toggleT1(a, id) {
      var textus = document.getElementById("hiddenZone");
        textus.style.display = "block";
    };

    function toggleT2(a, id) {
      var textum = document.getElementById("hiddenZone");
      textum.style.display = "none";
    };*/

$(document).ready(function () {
	$("#voirPlus").click(function () {
		$("#hiddenZone").fadeIn(1400);
		$("#voirPlus").hide();
	});
});

$(document).ready(function () {
	$("#masquer").click(function () {
		$("#hiddenZone").fadeOut(1400);
		$("#voirPlus").fadeIn(1400);
	});
});

/*Index animation mail dans zone telechargement section LA MArqur
$(document).ready(function(){
    $("#telechCatalogue").click(function(){
        $(".mailCatalogue").animate({
        height: 'toggle'
    });
    });

});*/


$(document).ready(function () {
	$('[data-toggle="popover"]').popover();
});


/*$(document).ready(function () {
	$('.wp-post-image').imageLens({ lensSize: 200 });
});*/