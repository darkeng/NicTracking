// Assets directory
var baseUrl = 'http://'+document.domain;

// creating the view
var view = new ol.View({
  center: ol.proj.fromLonLat([-86.877366, 12.434746]),
  zoom: 14
});

// creating styles
var styles = {
  'route': new ol.style.Style({
      stroke: new ol.style.Stroke({
        width: 6, color: [237, 212, 0, 0.8]
      })
  }),
  'point': new ol.style.Style({
    image: new ol.style.Circle({
      radius: 4,
      snapToPixel: false,
      fill: new ol.style.Fill({color: [79, 20, 255, 0.83]}),
      stroke: new ol.style.Stroke({
        color: [255, 20, 20, 0.5], width: 1
      })
    })
  }),
  'carMarker': new ol.style.Style({
    image: new ol.style.Icon({
      src: baseUrl+'/img/icons/car_marker.png',
      anchor: [0.5, 1]
    })
  })
};

// Layers
var layerOSM = new ol.layer.Tile({source: new ol.source.OSM()});

var layerData = new ol.layer.Vector({
  source:new ol.source.Vector(),
  style: function(feature) {
      return styles[feature.get('type')];
    }
});

// creating the map
var map = new ol.Map({
  layers: [
    layerOSM,
    layerData
  ],
  target: document.getElementById('map'),
  controls: ol.control.defaults({
    attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
      collapsible: false
    })
  }),
  loadTilesWhileAnimating: true,
  view: view
});

//car markers sources list
var carMarkers = [];

// Geolocation marker and popup
var geoMarker, carPopup;

// LineString to store the different geolocation positions. This LineString
// is time aware.
// The Z dimension is actually used to store the rotation (heading).
var positions = new ol.geom.LineString([], ('XYZM'));

// Geolocation Control
var geolocation = new ol.Geolocation(/** @type {olx.GeolocationOptions} */ ({
  projection: view.getProjection(),
  trackingOptions: {
    maximumAge: 10000,
    enableHighAccuracy: true,
    timeout: 600000
  }
}));

var deltaMean = 500; // the geolocation sampling period mean in ms

// display popup on click
map.on('click', function(evt) {
  var feature = map.forEachFeatureAtPixel(evt.pixel,
      function(feature) {
        return feature;
      });
  var element=carPopup.getElement();
  $(element).popover('destroy');
  if(feature && feature.get('type')=='carMarker') {
    var coordinates = feature.getGeometry().getCoordinates();

    var html = '<h5>'+feature.get('marca')+' '+feature.get('modelo')+'</h5>'+
            '<p class="text-muted">'+'Color: ' + feature.get('color')+'<br />'+
            'Matricula: ' + feature.get('matricula')+'<br /></p>'+
            '<small>Actualizado '+moment(feature.get('fecha'), "YYYY-MM-DD hh:mm:ss.SSS").fromNow();+'</small>';

    carPopup.setPosition(coordinates);
    $(element).popover({
      'placement': 'top',
      'animation': false,
      'html': true,
      'content': html
    });
    $(element).popover('show');
  } else {
    $(element).popover('destroy');
  }
});

// change mouse cursor when over marker
map.on('pointermove', function(e) {
  if (e.dragging) {
    $(carPopup.getElement()).popover('destroy');
    return;
  }
  var pixel = map.getEventPixel(e.originalEvent);
  var hit = map.hasFeatureAtPixel(pixel);
  var tar=map.getTarget();
  map.getTarget().style.cursor = hit ? 'pointer' : '';
});

// Listen to position changes
geolocation.on('change', function() {
  var position = geolocation.getPosition();
  var accuracy = geolocation.getAccuracy();
  var heading = geolocation.getHeading() || 0;
  var speed = geolocation.getSpeed() || 0;
  var m = Date.now();

  addPosition(position, heading, m, speed);

  var coords = positions.getCoordinates();
  var len = coords.length;
  if (len >= 2) {
    deltaMean = (coords[len - 1][3] - coords[0][3]) / (len - 1);
  }
  var latlonPosition = ol.proj.transform(position, 'EPSG:3857',
      'EPSG:4326');
  var html = [
    'Posicion: ' + latlonPosition[0].toFixed(4) + ', ' + latlonPosition[1].toFixed(4),
    'Precision: ' + accuracy,
    'Direccion: ' + Math.round(radToDeg(heading)) + '&deg;',
    'Velocidad: ' + (speed * 3.6).toFixed(1) + ' km/h',
    'Delta: ' + Math.round(deltaMean) + 'ms'
  ].join('<br />');
  $('#mapInfo').html(html);
});

geolocation.on('error', function() {
  alert('geolocation error');
  // FIXME we should remove the coordinates in positions
});

// View Animation
function flyTo(location, done) {
  var duration = 2000;
  var zoom = view.getZoom();
  var parts = 2;
  var called = false;
  function callback(complete) {
    --parts;
    if (called) {
      return;
    }
    if (parts === 0 || !complete) {
      called = true;
      done(complete);
    }
  }
  view.animate({
    center: getCenterWithHeading(location, view.getRotation(), view.getResolution()),
    duration: duration
  }, callback);
  view.animate({
    zoom: zoom - 1,
    duration: duration / 2
  }, {
    zoom: zoom,
    duration: duration / 2
  }, callback);
}
function elastic(t) {
  return Math.pow(2, -10 * t) * Math.sin((t - 0.075) * (2 * Math.PI) / 0.3) + 1;
}
function elasticTo(location){
  view.animate({
    center: location,
    duration: 2000,
    easing: elastic
  });
}

// convert radians to degrees
function radToDeg(rad) {
  return rad * 360 / (Math.PI * 2);
}
// convert degrees to radians
function degToRad(deg) {
  return deg * Math.PI * 2 / 360;
}
// modulo for negative values
function mod(n) {
  return ((n % (2 * Math.PI)) + (2 * Math.PI)) % (2 * Math.PI);
}

function addPosition(position, heading, m, speed) {
  var x = position[0];
  var y = position[1];
  var fCoords = positions.getCoordinates();
  var previous = fCoords[fCoords.length - 1];
  var prevHeading = previous && previous[2];
  if (prevHeading) {
    var headingDiff = heading - mod(prevHeading);

    // force the rotation change to be less than 180°
    if (Math.abs(headingDiff) > Math.PI) {
      var sign = (headingDiff >= 0) ? 1 : -1;
      headingDiff = -sign * (2 * Math.PI - Math.abs(headingDiff));
    }
    heading = prevHeading + headingDiff;
  }
  positions.appendCoordinate([x, y, heading, m]);

  // only keep the 20 last coordinates
  positions.setCoordinates(positions.getCoordinates().slice(-20));

  // FIXME use speed instead
  if (heading && speed) {
    geoMarker.getElement().src = baseUrl+'/img/icons/marker_dir.png';
  } else {
    geoMarker.getElement().src = baseUrl+'/img/icons/marker.png';
  }
}

// recenters the view by putting the given coordinates at 3/4 from the top or
// the screen
function getCenterWithHeading(position, rotation, resolution) {
  var size = map.getSize();
  var height = size[1];

  return [
    position[0] - Math.sin(rotation) * height * resolution * 1 / 4,
    position[1] + Math.cos(rotation) * height * resolution * 1 / 4
  ];
}

var previousM = 0;
function updateView() {
  if(trackSwitch){
    // use sampling period to get a smooth transition
    var m = Date.now() - deltaMean * 1.5;
    m = Math.max(m, previousM);
    previousM = m;
    // interpolate position along positions LineString
    var c = positions.getCoordinateAtM(m, true);
    if (c) {
      view.setCenter(getCenterWithHeading(c, -c[2], view.getResolution()));
      view.setRotation(-c[2]);
      geoMarker.setPosition(c);
    }
  }
  map.render();
}

function restartGeo(){
  init=true;
  previousM=0;
  positions= new ol.geom.LineString([], ('XYZM'));
  updater=setInterval(getPositionData, 500);
}

function positionChange(position) {
  geolocation.set('accuracy', position.precision);
  geolocation.set('heading', degToRad(position.direccion));
  var position_ = [position.lat, position.lon];
  var projectedPosition = ol.proj.transform(position_, 'EPSG:4326',
      'EPSG:3857');
  geolocation.set('position', projectedPosition);
  geolocation.set('speed', position.velocidad);
  geolocation.changed();
}

var init=true;
function geolocate(data) {
  var coordinate = data.datos[0];
  var prevDate;
  if(init) {
    positionChange(coordinate);
    prevDate = new Date(coordinate.fecha_registro).getTime();
    init=false;
  }
  else {
    if (!coordinate) {
      return;
    }
    var newDate = new Date(coordinate.fecha_registro).getTime();
    positionChange(coordinate);
    window.setTimeout(function() {
      prevDate = newDate;
    }, (newDate - prevDate) / 0.5);
  }
  map.on('postcompose', updateView);
  map.render();
}

var vehiclesData=[];
function getVehicles(){
  $.ajax({
    url: baseUrl+'/api/usuarios/'+userID+'/vehiculos', 
    success: function(data) {
      vehiclesData=data.datos;
    },
    error: function(e) {
      console.log('Error: '+e.status);
    }
  });
}

var veID, userID, cont=0; var vehiclesIdList=[]; var coords=[];
function getPositionData() {
  if(trackSwitch){
    $.ajax({
      url: baseUrl+'/api/usuarios/'+userID+'/vehiculos/'+veID+'/tracker/posiciones?ultimos=1', 
      success: function(data) {
        if(data.datos.length != 0)
          geolocate(data);
      },
      error: function(e) {
        console.log('Error: '+e.status);
      }
    });
  }else {    
    if(cont<vehiclesIdList.length) {
      $.ajax({
        url: baseUrl+'/api/usuarios/'+userID+'/vehiculos/'+vehiclesIdList[cont]+'/tracker/posiciones?ultimos=1', 
        success: function(data) {
          if(data.datos.length != 0){
            var cor=[data.datos[0].lat, data.datos[0].lon];
            coords.push({
              'point': ol.proj.transform(cor, 'EPSG:4326', 'EPSG:3857'),
              'date': data.datos[0].fecha_registro
          });
          }
          cont++;
        },
        error: function(e) {
          console.log('Error: '+e.status);
        }
      });
    }else {
      cont=0;
      updateMarkers();
      coords=[];
    }
  }
}

function updateMarkers(){
  for(var i=0; i<vehiclesIdList.length; i++){
    carMarkers[i].setGeometry(new ol.geom.Point(coords[i].point));
    carMarkers[i].set('fecha', coords[i].date);
  }
  map.render();
}

function createMarkers(){
  var lis=$(".listVehicles").find("li");
  for(var i=0; i<lis.length; i++){
    var id=$(lis[i]).data('vehicle').id;
    carMarkers.push( new ol.Feature({
      type: 'carMarker',
      geometry: undefined,
      id: 'vMarker-'+id,
      tipo:$(lis[i]).data('vehicle').tipo,
      marca:$(lis[i]).data('vehicle').marca,
      modelo:$(lis[i]).data('vehicle').modelo,
      color:$(lis[i]).data('vehicle').color,
      matricula:$(lis[i]).data('vehicle').matricula
    }));
    vehiclesIdList.push(id);
  }
  layerData.getSource().addFeatures(carMarkers);
}

function createElements(){
  $("#map").append("<div id='mapInfo'></div>");
  $("#map").append("<div id='carPopup'></div>");
  $("#map").append("<img id='geolocation_marker' class='hidden' src='"+baseUrl+"/img/icons/marker_dir.png' />");
  
  geoMarker = new ol.Overlay({
    positioning: 'center-center',
    element: document.getElementById("geolocation_marker"),
    stopEvent: false
  });
  carPopup = new ol.Overlay({
    element: document.getElementById('carPopup'),
    positioning: 'bottom-center',
    stopEvent: false,
    offset: [0, -50]
  });
  map.addOverlay(carPopup);
  map.addOverlay(geoMarker);
}

function actionsClick(el){
  if($(".listVehicles").find("li").hasClass('active')){
    
    $.ajax({
      method: 'PATCH',
      url: baseUrl+"/api/usuarios/"+userID+"/vehiculos/"+veID,
      data: $(el).data('action'),
      success: function( msg ) {
        swal("Accion enviada.", "", "success");
      },
      error: function( msg ) {
        swal("No se pudo enviar la accion.", "", "error");
      }
    });
  }
    else{
      swal("Selecciona un vehiculo", "Ve al menu MIS VEHICULOS y elige uno de tus vehiculos.");
    }
}

function vehiclesClick(el){
  clearInterval(updater);
  veID=$(el).parent().data('vehicle').id;
  $(".listVehicles").find("li").removeClass('active');
  $(el).parent().addClass('active');
  var vFeat=$.grep(carMarkers, function(e){ return e.get('id') == "vMarker-"+veID; });
  var point=vFeat[0].getGeometry().getCoordinates();
  if(trackSwitch) {
    trackSwitch=false;
    $("#geolocation_marker").addClass('hidden');
    flyTo(point, function(){
      restartGeo();
      trackSwitch=true;
      $("#geolocation_marker").removeClass('hidden');
    });
  }else {
    elasticTo(point);
    updater=setInterval(getPositionData, 500);
  }
}
var antzoom=view.getZoom();
function trackingChange(el){
  if($(".listVehicles").find("li").hasClass('active')){
      if(el.checked) {
        antzoom=view.getZoom();
        view.setZoom(19);
        $("#geolocation_marker").removeClass('hidden');
        $('#mapInfo').removeClass('hidden');
        trackSwitch = true;
        layerData.setVisible(false);
      } else {
        view.setZoom(antzoom);
        $("#geolocation_marker").addClass('hidden');
        $('#mapInfo').addClass('hidden');
        view.setRotation(0);
        trackSwitch=false;
        layerData.setVisible(true);
      }
    } else {
      $(el).prop("checked", false);
      swal("Selecciona un vehiculo", "Ve al menu MIS VEHICULOS y elige uno de tus vehiculos.");
    }
    $('.track-switch').val(el.checked);
}

var trackSwitch=false; var updater;
$( document ).ready(function() {
  moment.locale('es');
  userID=$("#userID").text();
  createElements();
  createMarkers();
  $(".listVehicles").find("a").attr("onclick", "vehiclesClick(this)");
  $("#dActions").find("a").attr("onclick", "actionsClick(this)");
  $(".track-switch").attr("onchange", "trackingChange(this)");
  
  updater=setInterval(getPositionData, 500);

});


