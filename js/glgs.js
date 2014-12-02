
  var geocoder;
  if(navigator.geolocation){
    navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
  }
  
  function successFunction(position){
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    codeLatLng(lat, lng)
  }
  
  function errorFunction(){
    //Geocoder failed
    document.getElementById("cityName").innerHTML = "Location Unavailable!";
  }
  
  function initialize(){
    geocoder = new google.maps.Geocoder();
  }
  
  function codeLatLng(lat,lng){
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
      console.log(results);
        if (results[1]) {
          for (var i=0; i<results[0].address_components.length; i++) {
            for (var b=0;b<results[0].address_components[i].types.length;b++) {
              if (results[0].address_components[i].types[b] == "administrative_area_level_1") {
                stateObj= results[0].address_components[i];
                break;
              }
		if (results[0].address_components[i].types[b] == "administrative_area_level_2") {
                cityObj= results[0].address_components[i];
                break;
              }
		if (results[0].address_components[i].types[b] == "country") {
                countryObj= results[0].address_components[i];
                break;
              }
		if (results[0].address_components[i].types[b] == "postal_code") {
                pincodeObj= results[0].address_components[i];
                break;
              }
            }
          }
	   var city = cityObj.long_name;
	   document.getElementById("cityName").innerHTML = city;
	   
        }else{
          //alert("No results found");
        }
      }else{
        //alert("Geocoder failed due to: " + status);
      }
    });
  }
  
  /*
  function getLocation(){
    if(navigator.geolocation){
      navigator.geolocation.getCurrentPosition(showPosition,showError);
    }else{
      x.innerHTML="Geolocation is not supported by this browser.";
    }
  }
  
  var lat=0, lon=0;
  function showPosition(position){
    lat=position.coords.latitude;
    lon=position.coords.longitude;
    //document.getElementById("locationCoords").innerHTML = lat + "  " + lon;
  }
  */

