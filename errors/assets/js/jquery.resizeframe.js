	function resizeFrame()
	{
		var bh = $("body").height();
		var bw = $("body").width();
		var sw = screen.width;
		bh += 20;
		var wh = $(window).height();
		if (wh >= bh) { myh = wh; } else { myh = bh; } 
		var w = $(window).width();
		var c = $('#page').width();
		if (w > sw) {
			var half = (sw - c) / 2;
		} else {
			var half = (w - c) / 2;
		}
		$("#leftpanel").css('height',myh);
		$("#leftpanel").css('width',half);
		$("#rightpanel").css('left',half+c);
		$("#rightpanel").css('width',half);
		$("#rightpanel").css('height',myh);
	}

	$(document).resize(function() {
		resizeFrame()
	});

	$(document).ready(function() {

		resizeFrame();

		/* Image Cycle */
		//Settings
		var faderSettings = {
		    timing: 5555,
		    fadeSpeed: 555,
		    numberOfImages: 5,
		    imagePrefix: "bkgd",
		    imageSuffix: ".jpg",
		    imageDirectory: "/errors/assets/bkgd/"
		};
		 
	    var displayImage = function(displayImage) {
	    	var matches = displayImage.match(/(\d)\.jpg/)
	    	if (matches) var color = matches[1];
	    	var bgColor = '';
	    	switch(color)
	    	{
	    		case '1' : bgColor = 'FF9933'; // red - 'FF9933'; calborder 
	    			break;
	    		case '2' : bgColor = 'F4ABE9'; // purple
	    			break;
	    		case '3' : bgColor = 'FFA1C9'; // pink
	    			break;
	    		case '4' : bgColor = 'A3CFEC'; // blue
	    			break;
	    		case '5' : bgColor = 'C1F897'; // green
	    			break;
	    	}

		    var imageURL = faderSettings.imageDirectory + displayImage;

			$("#canvas").fadeOut(faderSettings.fadeSpeed, function(){
				$(this).css({
					'background-image': ' url('+ imageURL + ')'
				}).fadeIn(faderSettings.fadeSpeed);

				//$("body").fadeOut(faderSettings.fadeSpeed,function(){
				//	$(this).css({
				//		'background-color': '#'+bgColor
				//	}).fadeIn(faderSettings.fadeSpeed);
				//})
		    });
			$("#leftpanel").css('background','#'+bgColor);
			$("#leftpanel").css('background','-moz-linear-gradient(left, #'+bgColor+', #44484F)');
			$("#leftpanel").css('background','-webkit-gradient(linear,left top, right top, from(#'+bgColor+'), to(#44484F))');
			$("#leftpanel").css('filter',"progid:DXImageTransform.Microsoft.Gradient(StartColorStr='#"+bgColor+"', EndColorStr='#44484F', GradientType=1)");
		    
			    $("#rightpanel").css('background','#'+bgColor);
			    $("#rightpanel").css('background','-moz-linear-gradient(left, #44484F, #'+bgColor+')');
			    $("#rightpanel").css('background','-webkit-gradient(linear,left top, right top, from(#44484F), to(#'+bgColor+'))');
			    $("#rightpanel").css('filter',"progid:DXImageTransform.Microsoft.Gradient(StartColorStr='#44484F', EndColorStr='#"+bgColor+"', GradientType=1)");
		    };
		 
		    function outer() {
		    	var a = 1;
		    	function inner() {
		    		if (a==faderSettings.numberOfImages) {
		    			a = 1;
		    		} else {a++;}
		    			var imageNeeded = faderSettings.imagePrefix + a + faderSettings.imageSuffix;
						displayImage(imageNeeded);
		    		}
		    	return inner;
			}
		    var imageFade = outer();
		    var cycleMe = setInterval(imageFade, faderSettings.timing);

	});


	