$(function() {
	$('.countdown-elem').height($('.countdown-elem').width());
	var countdownWidth = (($(".countdown-elem").width()) / 1.3 ) + 'px';
	$('.countdown-elem h2').css('lineHeight',countdownWidth);
	
	$.fn.countdown = function(options, callback) {
		element = $(this);
		var settings = { 'date': null, 'format': null};
		if(options) {
			$.extend(settings, options);
		}
		function countdown() {		
			countToDate = Date.parse(settings['date']) / 1000;
			currentDate = Math.floor($.now() / 1000);
			
			if(countToDate <= currentDate) {
				callback.call(this);
				clearInterval(interval);
			}
			
			seconds = countToDate - currentDate;
			
			days = Math.floor(seconds / (60 * 60 * 24));
			seconds -= days * 60 * 60 * 24;
			
			hours = Math.floor(seconds / (60 * 60));
			seconds -= hours * 60 * 60;
			
			minutes = Math.floor(seconds / 60);
			seconds -= minutes * 60;
			
			flowseconds = (Math.floor((100 / 60) * seconds));
			flowminutes = (Math.floor((100 / 60) * minutes));
			flowhours = (Math.floor((100 / 24) * hours));
			flowdays = (Math.floor((100 / 365) * days));
			
			// Countdown words to edit in plural and singular format
			if (days == 1) { element.find(".time_Days").text("day"); } else { element.find(".time_Days").text("days"); }
			if (hours == 1) { element.find(".time_Hours").text("hour"); } else { element.find(".time_Hours").text("hours"); }
			if (minutes == 1) { element.find(".time_Minutes").text("minute"); } else { element.find(".time_Minutes").text("minutes"); }
			if (seconds == 1) { element.find(".time_Seconds").text("second"); } else { element.find(".time_Seconds").text("seconds"); }

			days = (String(days).length >= 2) ? days : "0" + days;
			hours = (String(hours).length >= 2) ? hours : "0" + hours;
			minutes = (String(minutes).length >= 2) ? minutes : "0" + minutes;
			seconds = (String(seconds).length >= 2) ? seconds : "0" + seconds;

			if(!isNaN(countToDate)) {
				element.find(".days").text(days);
				element.find(".hours").text(hours);
				element.find(".minutes").text(minutes);
				element.find(".seconds").text(seconds);

				
			} else { 
				alert("The date you entered is invalid or not in the correct format. \n\nPlease use the format: DD MONTH YYYY HH:MM:SS\nFor example: 05 august 2012 03:30:02\n\nIf you still see this message consult the documentation.");
				clearInterval(interval); 
			}
		}
		

		countdown();
		interval = setInterval(countdown,1000);
		
	}
});

causeRepaintsOn = $("h1, h2, h3, p");
	
$(window).resize(function() {
	causeRepaintsOn.css("z-index", 1);
	
	$('.countdown-elem').height($('.countdown-elem').width());
	var countdownWidth = (($(".countdown-elem").width()) / 1.3 ) + 'px';
	$('.countdown-elem h2').css('lineHeight',countdownWidth);
});