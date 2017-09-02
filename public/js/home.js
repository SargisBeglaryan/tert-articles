$(document).ready(function(){
	$('.updateArticles').on('click', function (){
		$(this).attr('disabled', true);
		$('a').attr('disabled', true);
		$('.loader').show(100);
		$.ajax({
			url: "/getArticles",
			type: "POST",
			data: {_token:  $('.token').text().trim()},
			success: function(data) {
				ajaxCallResponse('Success');
			},
			error: function (xhr, status, error) {
				ajaxCallResponse('Error!');
				console.log("Sorry, there was a problem!");
			}
		});
	});
	function ajaxCallResponse(message){
		$('.loader').hide(100);
		$('.updateArticles').removeAttr("disabled");
		$('a').removeAttr("disabled");
		alert(message);
	}
});
