$(document).ready(function () {

	var gmapOptions = {
		center : new google.maps.LatLng(45.423494,-75.697933)
		, zoom : 13
		, mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	var map = new google.maps.Map(document.getElementById('map'), gmapOptions);

	var infoWindow;

	$('.hills li').each(function (i, elem) {
		var hill = $(this).find('a').html();

		var info = '<div class="info-window">'
			+ '<strong>' + hill + '</strong>'
			+ '</div>'
		;

		var lat = $(this).find('meta[itemprop="latitude"]').attr('content');
		var lng = $(this).find('meta[itemprop="longitude"]').attr('content');
		var pos = new google.maps.LatLng(lat, lng);

		var marker = new google.maps.Marker({
			position : pos
			, map : map
			, title : hill
			, icon : 'images/snow.png'
			, animation: google.maps.Animation.DROP
		});

		function showInfoWindow (ev) {
			if (ev.preventDefault) {
				ev.preventDefault();
			}

			if (infoWindow) {
				infoWindow.close();
			}

			infoWindow = new google.maps.InfoWindow({
				content : info
			});

			infoWindow.open(map, marker);
		}

		google.maps.event.addListener(marker, 'click', showInfoWindow);

		google.maps.event.addDomListener($(this).children('a').get(0), 'click', showInfoWindow);
	});
});
