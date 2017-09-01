$(document).ready(function(){
	$.ajax({
		url: "/getArticles",
		type: "POST",
		data: {_token:  $('.token').text().trim() },
		dataType: "json",
		success: function(data) {
			console.log("Success!");
		},
		error: function (xhr, status, error) {
			console.log("Sorry, there was a problem!");
		}
	});
});
