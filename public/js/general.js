// Assets directory
var baseUrl = 'http://'+document.domain;

// creating the view
var view = new ol.View({
  center: ol.proj.fromLonLat([-86.877366, 12.434746]),
  zoom: 14
});

// creating styles
var styles = {
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
  target: document.getElementById('map-cars'),
  loadTilesWhileAnimating: true,
  view: view
});

//car markers feature list
var carMarkers = [], carPopup;

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

// View Animation
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

var userID, cont=0;
function getPositionData() {
  if(cont < carMarkers.length){
    var veID=carMarkers[cont].get('id');
    $.ajax({
      url: baseUrl+'/api/usuarios/'+userID+'/vehiculos/'+veID+'/tracker/posiciones?ultimos=1', 
      success: function(data) {
        if(data.datos.length != 0){
          var cor=[data.datos[0].lat, data.datos[0].lon];
          updateMarker(cont, ol.proj.transform(cor, 'EPSG:4326', 'EPSG:3857'), data.datos[0].fecha_registro);
          cont++;
        }
      },
      error: function(e) {
        console.log('Error: '+e.status);
      }
    });
  } else {
    cont=0;
  }
}

function updateMarker(id, point, date){
  carMarkers[id].setGeometry(new ol.geom.Point(point));
  carMarkers[id].set('fecha', date);
  map.render();
}

function createMarkers(){
  var lis=$(".listVehicles").find("li");
  for(var i=0; i<lis.length; i++){
    var id=$(lis[i]).data('vehicle').id;
    carMarkers.push( new ol.Feature({
      type: 'carMarker',
      geometry: undefined,
      id: ''+id,
      tipo:$(lis[i]).data('vehicle').tipo,
      marca:$(lis[i]).data('vehicle').marca,
      modelo:$(lis[i]).data('vehicle').modelo,
      color:$(lis[i]).data('vehicle').color,
      matricula:$(lis[i]).data('vehicle').matricula
    }));
  }
  layerData.getSource().addFeatures(carMarkers);
}

function vehiclesClick(el){
  clearInterval(updater);

  var veID=$(el).parent().data('vehicle').id;
  $(".listVehicles").find("li").removeClass('active');
  $(el).parent().addClass('active');
  var vFeat=$.grep(carMarkers, function(e){ return e.get('id') == ''+veID; });
  var point=vFeat[0].getGeometry().getCoordinates();
  elasticTo(point);

  updater=setInterval(getPositionData, 500);
  
}
var updater;
$( document ).ready(function() {
  moment.locale('es');
  userID=$("#userID").text();
  carPopup = new ol.Overlay({
    element: document.getElementById('carPopup'),
    positioning: 'bottom-center',
    stopEvent: false,
    offset: [0, -50]
  });
  map.addOverlay(carPopup);
  createMarkers();
  updater=setInterval(getPositionData, 500);
});