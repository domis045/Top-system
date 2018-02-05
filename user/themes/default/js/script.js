$.noConflict();

if (navigator.userAgent.toLowerCase().indexOf("chrome") >= 0) {
	var _interval = window.setInterval(function () {
		var autofills = jQuery('input:-webkit-autofill');
			if (autofills.length > 0) {
				window.clearInterval(_interval);
				autofills.each(function() {
					var clone = jQuery(this).clone(true, true);
          jQuery(this).after(clone).remove();
        });
      }
  }, 200);
}

jQuery(document).ready(function() {
	jQuery('#server_control_textarea').elastic();
	
	jQuery('.description_title[title]').qtip({
		style: {
      classes: 'ui-tooltip-tipsy'
    },
		position: {
      my: 'bottom left', 
      at: 'top left'
    }
	});
	
	jQuery('.chronicle_title[title]').qtip({
		style: {
      classes: 'ui-tooltip-tipsy'
    },
		position: {
      my: 'bottom center', 
      at: 'top center'
    }
	});
	
	jQuery('.login_server_status_title[title]').qtip({
		style: {
      classes: 'ui-tooltip-tipsy'
    },
		position: {
      my: 'bottom center', 
      at: 'top center'
    }
	});
	
	jQuery('.game_server_status_title[title]').qtip({
		style: {
      classes: 'ui-tooltip-tipsy'
    },
		position: {
      my: 'bottom center', 
      at: 'top center'
    }
	});
	
	jQuery('.vote_description_title[title]').qtip({
		style: {
      classes: 'ui-tooltip-tipsy'
    },
		position: {
      my: 'top left', 
      at: 'bottom left'
    }
	});
	
	jQuery('.vote_chronicle_title[title]').qtip({
		style: {
      classes: 'ui-tooltip-tipsy'
    },
		position: {
      my: 'top center', 
      at: 'bottom center'
    }
	});
	
	jQuery('.vote_login_server_status_title[title]').qtip({
		style: {
      classes: 'ui-tooltip-tipsy'
    },
		position: {
      my: 'top center', 
      at: 'bottom center'
    }
	});
	
	jQuery('.vote_game_server_status_title[title]').qtip({
		style: {
      classes: 'ui-tooltip-tipsy'
    },
		position: {
      my: 'top center', 
      at: 'bottom center'
    }
	});
	
	jQuery(".server_list_hover").mouseover(function() {
    jQuery(this).find('.list_vote_img').attr("src", global_config['theme_path'] + "/images/icons/vote_on.png");
  }).mouseout(function(){
    jQuery(this).find('.list_vote_img').attr("src", global_config['theme_path'] + "/images/icons/vote_off.png");
  });
});

function selectVoteBanner(server_id, banner_id) {
	jQuery('.vote_banner.i1').removeClass('default');
	jQuery('.vote_banner.i2').removeClass('default');
	jQuery('.vote_banner.i3').removeClass('default');
	jQuery('.vote_banner.i4').removeClass('default');
	jQuery('.vote_banner.i5').removeClass('default');
	jQuery('.vote_banner.i6').removeClass('default');
	jQuery('.vote_banner.i' + banner_id).addClass('default');
	jQuery('#vote_banner_code').val("<a href='" + global_config["home_path"] + "/vote-" + server_id + "' target='_blank'><img src='" + global_config["home_path"] + "/user/images/" + banner_id + ".jpg' alt='vote image' title='Paspausk, jei nori atiduoti balsą'></a>");
}

function _confirmAndGo(msg) {
	var ans = confirm(msg);
	if (!ans) return false;
}