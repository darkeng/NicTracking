$(document).ready(function() {
var styles = {
	'route': new ol.style.Style({
      stroke: new ol.style.Stroke({
        width: 6, color: [237, 212, 0, 0.8]
      })
    }),
    'geoMarker': new ol.style.Style({
      image: new ol.style.Circle({
        radius: 4,
        snapToPixel: false,
        fill: new ol.style.Fill({color: [79, 20, 255, 0.83]}),
        stroke: new ol.style.Stroke({
          color: [255, 20, 20, 0.5], width: 1
        })
      })
    })
};
var viewn= new ol.View({
      center: ol.proj.fromLonLat([-86.879089, 12.438570]),
      zoom: 16
    });
var layerData = new ol.layer.Vector({
	source:new ol.source.Vector(),
	style: function(feature) {
  		return styles[feature.get('type')];
    }
});
var layerOSM = new ol.layer.Tile({source: new ol.source.OSM()});
var map = new ol.Map({
    target: 'map',
    layers: [
      layerOSM,
      layerData
    ],
    view: viewn
});
var datos; var suc;
$.ajax({
    url: 'http://nictracking.com/api/usuarios/1/vehiculos/10/tracker/posiciones', 
    success: function(data) {
      datos=data;
      suc=true;
    },
    error: function(e) {
      alert('ha ocurrido un error');
    }
});
var i=0;
function worker() {
  if(suc)
	if(i<datos['datos'].length){
    	var pos=ol.proj.fromLonLat([datos['datos'][i]['lat'], datos['datos'][i]['lon']])
    	viewn.setCenter(pos);
    	layerData.getSource().addFeature(
	    	new ol.Feature({
		        type: 'geoMarker',
		        geometry: new ol.geom.Point(pos)
      		})
	    );
	    i++;
	    map.render();
	}
}
setInterval(worker, 500);
});