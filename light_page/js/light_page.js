
$(document).on('ready ajaxSuccess', function() {

    $(".lp_no_rel a, a.lp_no_rel ").addClass('noajax');
    $(".lp_add_rel a").each(function () {

        if($(this).hasClass("noajax")){ $(this).removeClass("noajax");	        }else{
		            //Check the external link
	               var a = new RegExp('/' + window.location.host + '/');
	               if (!a.test(this.href)) {var extlink = true;}

	                //Check the picture
	                if($(this).children('img').length){var chimg = true;}

		             // add data rel
		             if(!extlink && !chimg)
		               {
			             var param =  $(this).attr('href').split("?");
			             var link =  param[0];
			             if(param[1]) {link = link + ';'+param[1];}
				         $(this).addClass('ajax').attr('rel','get-'+lp_id+';'+link);

		                      }
		            }
    });
 });

