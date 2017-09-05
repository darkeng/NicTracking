var baseUrl = 'http://'+document.domain;
var trTemp, userID, veID;
function showForm(el, opt){
	var tr=$(el).parent().parent();
	if(opt=="edit"){
		$(tr).siblings().fadeOut('slow');
	}	
	if(opt=="add"){
		$(tr).parent().children().fadeOut('slow');
		trT=$("#trForm").find('tr');
		$(tr).before(trT);
		tr=trT;
	}
	trTemp=$(tr).clone();
	$("td", tr).each(function(index, el) {
		if(index==0) {veID=$(el).text();}
		else if(index==6) {
			var select =$(el).hasClass('text-danger') ? ['','selected'] : ['selected',''];
			$(el).html("<select name='perdido' class='form-control'>"+
          "<option value='false' "+select[0]+">Normal</option>"+
          "<option value='1' "+select[1]+">Perdido</option></select>");
		}
		else if(index==7){
			$(el).html("<button style='right: 3px;' type='button' rel='tooltip' class='btn btn-info' title='Guardar' onclick='vSave(this)'>"+
                "<i class='material-icons'>save</i></button>"+
            "<button type='button' rel='tooltip' class='btn btn-danger' title='Cancelar' onclick='vCancel(this)'>"+
                "<i class='material-icons'>cancel</i></button>");
		} else {
			$(el).html("<div class='form-group'>"+
				"<input type='text' name='"+$(el).attr('class')+"' class='form-control' value='"+$(el).text()+"' required>"+
				"</div>");
		}
	});
	
	$.material.init();
	$('[rel="tooltip"]').tooltip();
}

function vSave(el){
	var methodO = "";
	if (veID!="id"){
		methodO = "PUT";
		veID="/"+veID;
	}else {
		methodO ="POST";
		veID="";
	}
	var formArray=$('form').serializeArray();
	var formData = {};
	for (var i = 0; i < formArray.length; i++){
		formData[formArray[i]['name']] = formArray[i]['value'];
	}
	
	$.ajax({
	  method: methodO,
	  url: baseUrl+"/api/usuarios/"+userID+"/vehiculos"+veID,
	  data: formData,
	  success: function( msg ) {
	  	swal("Vehiculo guardado.", "", "success");
	  	if(methodO=="POST"){
	  		$(trTemp).find('td.id').text(msg.ok.id);
	  	}
	  	reloadTr(el, formArray);
	  },
	  error: function( msg ) {
	    swal("No se pudo guardar.", "", "error");
	    vCancel(el);
	  }
	});
}

function vCancel(el){
	var tr=$(el).parent().parent().empty();
	$(tr).siblings().fadeIn('slow');
	$(tr).append($(trTemp).children());
	$('.tooltip').remove();
	$('[rel="tooltip"]').tooltip();
}

function reloadTr(el, data){
	var tr=$(el).parent().parent().empty();
	$("td", trTemp).each(function(index, e) {
		if(index>0 && index<6){
			var res=$.grep(data, function(a){ return a.name == $(e).attr('class'); });
			$(e).text(res[0].value);
		}
		if(index==6){
			var res=$.grep(data, function(a){ return a.name == 'perdido'; });
			if(res[0].value=='1'){
				$(e).addClass('text-danger').text('Perdido');
			}else {
				$(e).removeClass('text-danger').text('Normal');
			}
		}
	});
	$(tr).append($(trTemp).children());
	$('.tooltip').remove();
	$('[rel="tooltip"]').tooltip();
	$(tr).siblings().fadeIn('slow');
}

$(document).ready(function(){
	userID=$("#userID").text();
});
