$(document).ready(function(){

    $('.name_search').keyup(function() {
    	name_search = $(this).val();
    	id_client=$('#id_client').val();
    	results_target=$(this).attr('id')+"_results";
    	list_target=$(this).attr('name');
    	if (name_search.length>2){
    		$.getJSON("ajax.php?action=nameSearch&name_search="+name_search+"&id_client="+id_client, function(results){
				$('#'+results_target+' li').remove();
	    		$('#'+results_target).show();
	   		 	var ul=$('#'+results_target);        	
		   		$.each(results, function(i,user){
		   			ul.append("<li ><a href='"+list_target+"' id='"+user.id_user+"' class='user'>"+user.given_name+" "+user.surname+"</a></li>");
		   		});
	        });     
    	}
    });

	$('.numeric').keypress(function(event) {
		var controlKeys = [8, 9, 13, 35, 36, 37, 39, 48];
		var isControlKey = controlKeys.join(",").match(new RegExp(event.which));
		if (!event.which || (49 <= event.which && event.which <= 57) || isControlKey) {
			return;
		} else {
			event.preventDefault();
		    thisID = $(this).attr('id');
			fieldText = $('label[for="'+thisID+'"]').text().replace('*','');
		    if ($('p#'+thisID+'_error').length) {
		    	$('p#'+thisID+'_error').text(fieldText+' must be a number');
		    } else {
			    $(this).after('<p id="'+thisID+'_error" class="error">'+fieldText+' must be a number</p>');
			}
		}
	});
	
	$('.email').live('blur',function() {
		thisVal = $(this).val();
		thisID = $(this).attr('id');
		if (thisVal) {
			validEmail = validateEmail(thisVal)
			if (!validEmail) {
			    if ($('p#'+thisID+'_error').length) {
			    	$('p#'+thisID+'_error').slideDown().text('Please enter a valid email address');
			    } else {
				    $('#'+thisID).after('<p id="'+thisID+'_error" class="error">Please enter a valid email address</p>');
				}
			} else {
				$('label[for="'+thisID+'"]').removeClass('error');
				$(this).removeClass('error');
				$('p#'+thisID+'_error.error').slideUp(300);			
			}
		}
	});

    $('form').submit(function(e) {
    	formid = $(this).attr('id');
        errorcount = validate_form(formid);
        if (errorcount === 0) {
	        return true;
        } else if (errorcount === 1) {
        } else if (errorcount > 1) {
        } 
        return false;
    });
    
    $('input.error, select.error, textarea.error').live('blur', function () {
        if (!$(this).val()) {
            return;
        } else {
            this_id = $(this).attr('id');
            $('label[for="' + this_id + '"]').removeClass('error');
            $(this).removeClass('error');
            $('p#' + this_id + '_error.error').fadeOut(300);
        }
    });
});


function validate_form(formid) {
	var errorcount = 0;
	$('p.error').remove();
	$('.error').removeClass('error');
	$('form#'+formid+' label:contains("*"):visible').each(function () {
		thisLabelFor = $(this).attr('for');
		errorMessage = '<p id="'+thisLabelFor+'_error" class="error">' +$(this).text().replace('*', '')+' is required</p>';
		
		if ($('#'+thisLabelFor).is('.email')) {
			thisVal = $('#'+thisLabelFor).val();
			if (thisVal) {
				validEmail = validateEmail(thisVal)
				if (!validEmail) {
				    if ($('p#'+thisLabelFor+'_error').length) {
				    	$('p#'+thisLabelFor+'_error').text('Please enter a valid email address');
				    } else {
					    $('#'+thisLabelFor).after('<p id="'+thisLabelFor+'_error" class="error">Please enter a valid email address</p>');
					}
					errorcount++;
				}
			}
		}
		
		if ($('#'+thisLabelFor).is('input[type="text"]') || $('#'+thisLabelFor).is('textarea') || $('#'+thisLabelFor).is('select')){
			thisVal = $('#'+thisLabelFor).val();
			if (!thisVal.length) {
				$(this).addClass('error');
				$('#'+thisLabelFor).addClass('error');
				$('#'+thisLabelFor).after(errorMessage);
				errorcount++;
			}
		}
		
		if ($('#'+thisLabelFor).is('input[type="checkbox"]')){
			thisChecked = $('#'+thisLabelFor).is(':checked');
			if (!thisChecked) {
				$('label[for='+thisLabelFor+']').addClass('error');
				$(this).addClass('error');
				$('#'+thisLabelFor).addClass('error');
				errorcount++;
			}
		}
		
		if ($('#'+thisLabelFor).is('fieldset')){			
			if ($('#'+thisLabelFor+' input[type="radio"][name="'+thisLabelFor+'"]').length > 0) {
				if ($('#'+thisLabelFor+' input[type="radio"][name="'+thisLabelFor+'"]:checked').length === 0) {
					$('label[for='+thisLabelFor+']').addClass('error');
					$('fieldset#'+thisLabelFor).addClass('error');
					$('fieldset#'+thisLabelFor).after(errorMessage);
					errorcount++;				
				} 
			}
			
			if ($('#'+thisLabelFor+' select').length > 0) {
				selectError = 0;
				$('#'+thisLabelFor+' select').each(function() {
					if (!$(this).val().length) {
						selectError++
						return selectError;
					}
				});
				if (selectError) {
					$('label[for='+thisLabelFor+']').addClass('error');
					$('fieldset#'+thisLabelFor).addClass('error');
					$('fieldset#'+thisLabelFor).after(errorMessage);
					errorcount++;
				}
			}	
			if ($('#'+thisLabelFor+' input[type="text"]').length > 0) {
				textError = 0;
				$('#'+thisLabelFor+' input[type="text"]').each(function() {
					if (!$(this).val().length) {
						textError++
						return textError;
					}
				});
				if (textError) {
					$('label[for='+thisLabelFor+']').addClass('error');
					$('fieldset#'+thisLabelFor).addClass('error');
					$('fieldset#'+thisLabelFor+' input[type="text"]').addClass('error');
					$('fieldset#'+thisLabelFor).after(errorMessage);
					errorcount++;
				}
				
				
			
			}
		}
	});
	return errorcount;
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}