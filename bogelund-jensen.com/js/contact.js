$(document).ready(function() {
	$('#contact-error').fadeOut();
	
		$('form#contact-us').submit(function() {
			
			$('form#contact-us .error').remove();
			var hasError = false;
			$('.requiredField').each(function() {
				if($.trim($(this).val()) == '') {
					
					$(this).addClass("contact-form-error").delay(3000).queue(function(){
	    				$(this).removeClass("contact-form-error").dequeue();
					});
					$("#contact-button").addClass("contact-button-error").delay(3000).queue(function(){
	    				$(this).removeClass("contact-button-error").dequeue();
					});
					$(".contact-response").addClass("contact-error").delay(3000).queue(function(){
		    			$(this).removeClass("contact-error").dequeue();
					});

					hasError = true;
				} else if($(this).hasClass('email')) {
					var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
					if(!emailReg.test($.trim($(this).val()))) {
						
						$(this).addClass("contact-form-error").delay(3000).queue(function(){
	    					$(this).removeClass("contact-form-error").dequeue();
						});
						$("#contact-button").addClass("contact-button-error").delay(3000).queue(function(){
		    				$(this).removeClass("contact-button-error").dequeue();
						});
						$(".contact-response").addClass("contact-error").delay(3000).queue(function(){
		    				$(this).removeClass("contact-error").dequeue();
						});
					
						hasError = true;
					}
				}
			});
			if(!hasError) {
				$('.contact-response').hide();
				$('.contact-loading').fadeIn(500);
					
				var formInput = $(this).serialize();
				$.post($(this).attr('action'),formInput, function(data){
					$('form#contact-us').delay(1500).slideUp(1000, function() {				   
						$('#contact-success').delay(500).slideDown(500);
					});
				});
			}
			
			return false;
		});
	});