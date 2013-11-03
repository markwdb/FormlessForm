$(document).ready(function(){
	
	$('#contact .field').attr("tabindex",0);
	
	$('#contact .field').focus(function(){
		$(this).attr("contenteditable", "true");
	});
	$('#contact .field').blur(function(){
		$(this).removeAttr("contenteditable");
	});
	$('#contact p.field').keypress(function(event) {
	    if (event.keyCode == 13) {
	        event.preventDefault();
	    }
	});
	
    $('#submit').live('click', function() {
	    name = $('#name').html();
	    email = $('#email').html();
	    comments = $('#comments').html();
	    
	    dataString = "name="+name+"&email="+email+"&comments="+comments;
	    	    
	  	$.ajax({
		    type: "POST",
		    url: "ajax.php",
		    data: dataString,
		    cache: false,
		    success: function(data){
			    if ((data).length) {
		    		$('.message').addClass('error').append(JSON.parse(data));
			    } else {
				    alert('Success!');				    
			    }
		    }
		
	    });
	    return false;
    });

});