$(document).ready(function(){
	

	$('#contact .field').attr("tabindex",0);
	
	$('#contact .field').focus(function(){
		$(this).attr("contenteditable", "true");
	});
	$('#contact .field').blur(function(){
		$(this).removeAttr("contenteditable");
	});
	
	
    $('#submit').live('click', function() {
	    name = $('#name').html();
	    email = $('#email').html();
	    comments = $('#comments').html();
	    
	    dataString = "name="+name+"&email="+email+"&comments="+comments;
	    
	    $.getJSON("ajax.php?action=sendForm&name="+name+"&email="+email+"&comments="+comments);
	    
	  	$.ajax({
		    type: "POST",
		    url: "ajax.php",
		    data: dataString,
		    cache: false,
		    success: function(data){
			    alert(data);
		    }
		
	    });

	    return false;
    });

});