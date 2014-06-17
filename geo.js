function Ajaxobject() {
	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlhttp;
}

function initialize() {
	var address = (document.getElementById('my-address'));
	var autocomplete = new google.maps.places.Autocomplete(address);
	autocomplete.setTypes(['geocode']);
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		var place = autocomplete.getPlace();
		if (!place.geometry) {
			return;
		}
		var address = '';
		if (place.address_components) {
			address = [
			(place.address_components[0] && place.address_components[0].short_name || ''),
			(place.address_components[1] && place.address_components[1].short_name || ''),
			(place.address_components[2] && place.address_components[2].short_name || '')
			].join(' ');
		}
	});
}

function codeAddress() {
	geocoder = new google.maps.Geocoder();
	var address = document.getElementById("my-address").value;
	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			var lat=results[0].geometry.location.lat();
			var lng=results[0].geometry.location.lng();
			radialdistance(lat,lng);
		}
	});
}

function radiocheck() {
	var nearest=document.getElementById('nearest').checked;
	var radius=document.getElementById('radius').checked;
	if(nearest==true)
	{
		document.getElementById("nearestDiv").style.display='block';
		document.getElementById("radiusDiv").style.display="none";
		document.getElementById("radiusDiv").value="Enter distance here";
	} else if(radius==true) {
		document.getElementById("radiusDiv").style.display="block";
		document.getElementById("nearestDiv").style.display="none";document.getElementById("Nearestno").value="Select value";
	}
}

function radialdistance(lat1,lon1)
{
	var address = document.getElementById('my-address').value;
	var Nearestno =document.getElementById('Nearestno').value;
	var radiusvalue =document.getElementById('radiusDiv').value;
	document.getElementById("location").innerHTML="<img src='/Geoservices/img/load.jpg' style='margin:60px 0px 0px 400px;float:left' />";
	xmlhttp= Ajaxobject();
	xmlhttp.onreadystatechange=function() { 
		if(xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("location").innerHTML=xmlhttp.responseText;
		}
	};
	xmlhttp.open("GET","/Geoservices/geoservice.php?address="+address+"&lat="+lat1+"&lng="+lon1+"&nearest="+Nearestno+"&radius="+radiusvalue,true);
	xmlhttp.send();
}

google.maps.event.addDomListener(window, 'load', initialize);