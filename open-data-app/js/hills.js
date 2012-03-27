$(document).ready(function () {

	var locations = [];
	
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
	
	
   /****************************************************/
  /***** Rating Stars **********************************/
  /****************************************************/
	
	var $raterLi = $('.rater-usable li');

  $raterLi
    .on('mouseenter', function (ev) {
      var current = $(this).index();

      for (var i = 0; i < current; i++) {
        $raterLi.eq(i).addClass('is-rated-hover');
      }
    })
    .on('mouseleave', function (ev) {
      $raterLi.removeClass('is-rated-hover');
    });

  /****************************************************/
  /***** Geolocation **********************************/
  /****************************************************/

  var userMarker;

  function displayUserLoc (lat, lng) {
    var locDistances = []
      , totalLocs = locations.length
      , userLoc = new google.maps.LatLng(lat, lng);
    ;

    if (userMarker) {
      userMarker.setPosition(userLoc);
    } else {
      userMarker = new google.maps.Marker({
        position : userLoc
        , map : map
        , title : 'You are here.'
        , icon : 'images/user.png'
        , animation: google.maps.Animation.DROP
      });
    }

    map.setCenter(userLoc);

    var current = new LatLon(lat, lng);

    for (var i = 0; i < totalLocs; i++) {
      locDistances.push({
        id : locations[i].id
        , distance : parseFloat(current.distanceTo(new LatLon(locations[i].lat, locations[i].lng)))
      });
    }

    locDistances.sort(function (a, b) {
      return a.distance - b.distance;
    });

    var $hillsList = $('.hills');

    for (var j = 0; j < totalLocs; j++) {
      var $li = $hillsList.find('[data-id="' + locDistances[j].id + '"]');

      $li.find('.distance').html(locDistances[j].distance.toFixed(1) + ' km');

      $hillsList.append($li);
    }
  }

  if (navigator.geolocation) {
    $('#geo').click(function () {
			  navigator.geolocation.getCurrentPosition(function (pos) {
        displayUserLoc(pos.coords.latitude, pos.coords.longitude);
      });
    });
  }

  $('#geo-form').on('submit', function (ev) {
    ev.preventDefault();

    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({
      
      address : $('#adr').val() + ', Ottawa, ON'
      , region : 'CA'
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          displayUserLoc(results[0].geometry.location.lat(), results[0].geometry.location.lng());
        }
      }
    );
  });
});
