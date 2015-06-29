<!DOCTYPE html PUBLIC "-f33//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
<style type="text/css">
	html { height:100%; width:99.8%; }
	body { height:100%; width:100%%; margin:0px; padding:0px; font:13px/1.2 Helvetica,Arial,sans-serif; color: #000000}
	#tibia_map { height:80%; width:100%; margin:0px; padding:0px; position:relative; }
	#map_info { height:auto; width:100%; margin:0px auto; padding:0px; border:1px solid #A7D7F9; position:relative; }
	table { height:auto; width:100%; margin:0px; padding:0px; border:0px solid; }
	td { height:17px; width:100%; margin:0px; padding:0px; border:0px solid; font:inherit; }
	a { font:inherit; text-decoration:none; }
	#info_hide { border-bottom:1px solid #A7D7F9; text-align:center; }
	.td1 { width:80px; }
	.td2 { width:420px; padding:0px 0px 0px; }
</style>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script type="text/javascript" src="../js/lib/jquery.js"></script>

<script type="text/javascript">
var MAP_WIDTH = 8*256;
var MAP_HEIGHT = 8*256;
var ORIGIN_X = 29;
var ORIGIN_Y = 594;
var ORIGIN_Z = 7;
var MIN_ZOOM = 1;
var MAX_ZOOM = 6;
var map_max = Math.max(MAP_WIDTH,MAP_HEIGHT);
var map;
var floor;
var start_floor;
var start_x;
var start_y;
var start_zoom;
var linkMarker = null;
var exibirControles = true;

var NPC = {};
NPC['Mano Widin'] = [1045, 1601, 7];

function LatLngToCoord(latLng) {
	return new google.maps.Point(ORIGIN_X+Math.floor(latLng.lng()*map_max/2.56),ORIGIN_Y+Math.floor(latLng.lat()*map_max/2.56));
};

function CoordToLatLng(x,y) {
	return new google.maps.LatLng((y-ORIGIN_Y+0.5)/map_max*2.56,(x-ORIGIN_X+0.5)/map_max*2.56);
};

function CollapseTable() {
	if (document.getElementById("info_table").style.display=="none") {
		document.getElementById("info_table").style.display="inline";
		var table=document.getElementById("info_hide");
		table.innerHTML="Esconder";
		table.style.borderBottom="1px #A7D7F9 solid";
	} else {
		document.getElementById("info_table").style.display="none";
		var table=document.getElementById("info_hide");
		table.innerHTML="Mostrar";
		table.style.borderBottom="0px solid";
	}
	
	SetSize();
	MapResize();
}

function ChangeFloor(change) {
	floor+=change;
	
	if (floor<0)
		floor=0;
	else if (floor>15)
		floor=15;
		
	MapUpdate();
	map.setMapTypeId(floor+"");
	document.getElementById("floor_div").innerHTML = 7-floor;
	
	var backgroundColor = "#000000";
	
	if (floor==7)
	backgroundColor = "#336699";
	
	document.getElementById("tibia_map").style.backgroundColor = backgroundColor;
	
	if (linkMarker) {
		linkMarker.setMap(start_floor == floor?map:null);
	}
}; 

function MapUpdate() {
	var coord_x = LatLngToCoord(map.getCenter()).x;
	var coord_y = LatLngToCoord(map.getCenter()).y;
	var coord_z = floor;
	var zoom = map.getZoom();
	var url;
	document.getElementById("info_coords").innerHTML = "x: "+coord_x+"&nbsp;&nbsp;&nbsp;y: "+coord_y+"&nbsp;&nbsp;&nbsp;z: "+floor;
	url=window.location.host+"/?p=mapa&x="+coord_x+"&y="+coord_y+"&z="+floor+"&zoom="+zoom;
	document.getElementById("info_link").value=url;
	document.getElementById("info_link").innerHTML=url;
	zoom2 = Math.max(3,zoom+2);
}; 

function MapResize() {
	var center = map.getCenter(); 
	google.maps.event.trigger(map,"resize"); 
	map.setCenter(center); 
}

function SetSize() {
	document.getElementById("tibia_map").style.height=(document.body.offsetHeight-document.getElementById("map_info").offsetHeight-10)+"px";
}

function CheckLinkAndInitCoords() {
var url = {};
parent.document.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(m,key,value) {url[key] = value;});

if (url.npc != undefined && parseInt(url.npc) != NaN){
	url.npc = decodeURIComponent(url.npc);
	start_x = parseInt(NPC[url.npc][0]);
	start_y = parseInt(NPC[url.npc][1]);
	start_floor = floor = NPC[url.npc][2];
	start_zoom = 3;

	var companyMarker = new google.maps.Marker({
		position: CoordToLatLng(start_x, start_y),
		map: map,
		title:url.npc
	});
}else{
	if (url.x != undefined && parseInt(url.x) != NaN)
		start_x = parseInt(url.x);
	else
		start_x = ORIGIN_X+MAP_WIDTH/2;
		
	if (url.y != undefined && parseInt(url.y) != NaN)
		start_y = parseInt(url.y);
	else
		start_y = ORIGIN_Y+MAP_HEIGHT/2;
		
	if (url.z != undefined && parseInt(url.z) != NaN && parseInt(url.z) >= 0 && parseInt(url.z) <= 15)
		start_floor = floor = parseInt(url.z);
	else
		start_floor = floor = ORIGIN_Z;
		
	if (url.zoom != undefined && parseInt(url.zoom) != NaN)
		start_zoom = parseInt(url.zoom);
	else
		start_zoom = 2;
	}
}

function LoadMap() {
	var backgroundColor = "#000000";
	if(floor==7)
		backgroundColor = "#00669C";
	var mapOptions = {
		backgroundColor: backgroundColor,
		center: CoordToLatLng(start_x,start_y),
		zoom: start_zoom,
		mapTypeControlOptions: {
			mapTypeIds: ["0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15"]
		},
		disableDefaultUI: true,
		overviewMapControl: false,
		overviewMapControlOptions: {
			opened: "true"
		},
		zoomControl: true,
		zoomControlOptions: {
			style: google.maps.ZoomControlStyle.LARGE
		},
		zoomControl: true
	};
	
	var tibiaMapOptions = {
		getTileUrl: function(coord,zoom) {
			var max = Math.pow(2,zoom) - 1;
			var x = coord.x;
			var y = max - coord.y;
			
			if (x<0 || x>max || y<0 || y>max) {
				if (floor == 7)
					return "../imagens/mapa/blue.png";
				return "../imagens/mapa/black.png";
			}
			return "../tiles/"+ floor + "/" + zoom + "/" + x + "/" + y + ".jpg";
		},
		tileSize: new google.maps.Size(256,256),
		isPng: true,
		maxZoom: MAX_ZOOM,
		minZoom: MIN_ZOOM
	};

	map = new google.maps.Map(document.getElementById("tibia_map"),mapOptions);

	var tibiaMapType;
	for (var i=0;i<=15;i++) {
		tibiaMapType = new google.maps.ImageMapType(tibiaMapOptions);
		tibiaMapType.projection = new SimpleProjection();
		map.mapTypes.set(i+"",tibiaMapType);
	}
	map.setMapTypeId(floor+"");
	google.maps.event.addListener(map,"bounds_changed",MapUpdate);
	google.maps.event.addDomListener(window,"resize",MapResize);
	
	if (start_x != ORIGIN_X+MAP_WIDTH/2) {
		linkMarker = new google.maps.Marker({
			map: map,
			position: CoordToLatLng(start_x,start_y),
			title: "Duplo clique para remover.",
			animation: google.maps.Animation.BOUNCE
		});
		
		setTimeout(function() {
			linkMarker.setAnimation(null);
		}, 3000);
		
		google.maps.event.addListener(linkMarker, "dblclick", function() {
			linkMarker.setMap(null);
			linkMarker = null;
		});
	}
	google.maps.event.addListenerOnce(map, 'idle', function(){
		$("img[src='https://maps.gstatic.com/mapfiles/api-3/images/google_white2.png']").remove();
		$(".gmnoprint.gm-style-cc").remove();
	});
}

function FloorControl() {
	var controlDiv = document.createElement("DIV");
	controlDiv.style.margin = "0px";
	controlDiv.style.padding = "0px";
	
	var upDiv = document.createElement("DIV");
	upDiv.style.cursor="pointer";
	upDiv.style.width = "20px";
	upDiv.style.height = "20px";
	upDiv.style.margin = "0px";
	upDiv.style.padding = "5px 6px";
	upDiv.title = "+1";
	upDiv.style.background = "url(../imagens/mapa/up.png) no-repeat center";
	controlDiv.appendChild(upDiv);
	
	var floorDiv = document.createElement("DIV");
	floorDiv.style.width = "20px";
	floorDiv.style.height = "21px";
	floorDiv.style.margin = "0px 6px";
	floorDiv.style.padding = "0px";
	floorDiv.style.pointerEvents = "none";
	floorDiv.style.background = "url(../imagens/mapa/floor.png) no-repeat center";
	controlDiv.appendChild(floorDiv);
	
	var textDiv = document.createElement("DIV");
	textDiv.id = "floor_div";
	textDiv.style.width = "18px";
	textDiv.style.height = "21px";
	textDiv.style.margin = "0px";
	textDiv.style.padding = "1px 0px";
	textDiv.style.textAlign = "center";
	textDiv.style.color = "red";
	textDiv.style.font = "bold 15px Helvetica,Arial,sans-serif";
	textDiv.innerHTML = 7-floor;
	floorDiv.appendChild(textDiv);
	
	var downDiv = document.createElement("DIV");
	downDiv.style.cursor="pointer";
	downDiv.style.width = "20px";
	downDiv.style.height = "20px";
	downDiv.style.margin = "0px 0px";
	downDiv.style.padding = "5px 6px";
	downDiv.title = "-1";
	downDiv.style.background = "url(../imagens/mapa/down.png) no-repeat center";
	controlDiv.appendChild(downDiv);
	
	var centerDiv = document.createElement("DIV");
	centerDiv.style.cursor="pointer";
	centerDiv.style.width = "20px";
	centerDiv.style.height = "20px";
	centerDiv.style.margin = "0px 0px";
	centerDiv.style.padding = "5px 6px";
	centerDiv.title = "Centro";
	centerDiv.style.background = "url(../imagens/mapa/center.png) no-repeat center";
	controlDiv.appendChild(centerDiv);
	
	var CENTER = CoordToLatLng(start_x,start_y);
	google.maps.event.addDomListener(upDiv,"click",function() {ChangeFloor(-1)});
	google.maps.event.addDomListener(downDiv,"click",function() {ChangeFloor(+1)});
	google.maps.event.addDomListener(centerDiv,"click",function() {map.setCenter(CENTER)});
	if(exibirControles)
		map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);
}

function Crosshair() {
	if (map.controls[google.maps.ControlPosition.TOP_CENTER].getLength()==0) {
		var xDiv = document.createElement("DIV");
		xDiv.style.width = "100%";
		xDiv.style.height = "1px";
		xDiv.style.background = "url(../imagens/mapa/cx.png) repeat-x center";
		xDiv.style.pointerEvents = "none";
		map.controls[google.maps.ControlPosition.LEFT_CENTER].push(xDiv);
		
		var yDiv = document.createElement("DIV");
		yDiv.style.width = "1px";
		yDiv.style.height = "100%";
		yDiv.style.background = "url(../imagens/mapa/cy.png) repeat-y center";
		yDiv.style.pointerEvents = "none";
		map.controls[google.maps.ControlPosition.TOP_CENTER].push(yDiv);
	}else{
		map.controls[google.maps.ControlPosition.LEFT_CENTER].clear();
		map.controls[google.maps.ControlPosition.TOP_CENTER].clear();
	}
};

function SimpleProjection() {
};

SimpleProjection.prototype.fromLatLngToPoint = function(latLng) {
	return new google.maps.Point(latLng.lng()*100,latLng.lat()*100);
};

SimpleProjection.prototype.fromPointToLatLng = function(point,noWrap) { 
	return new google.maps.LatLng(point.y/100,point.x/100);
};

function Init() {
	SetSize();
	CheckLinkAndInitCoords();
	LoadMap();
	FloorControl();
	Crosshair();
}

</script>
</head>

<body onload="Init()">
	<div id="tibia_map"></div>
	<div id="map_info">
	
	<table>
		<tr>
			<td id="info_hide" onclick="CollapseTable();">Esconder</td>
		</tr>
	</table>
	
	<table id="info_table">
		<tr>
			<td class="td1">
				<input id="crosshair_checkbox" type="checkbox" value="1" checked="checked" onclick="Crosshair();" />Cursor
			</td>
		</tr>
		
		<tr>
			<td class="td1">Coordenadas:</td>
			<td class="td2" id="info_coords"></td>
		</tr>
		<tr>
			<td class="td1" valign="top">Link direto:</td>
			<td class="td2">
				<input id="info_link" readonly="readonly" type="text" value="" size="45" style="background:#FFFFFF; color:#000000; padding-left: 1px; border: 1px solid #A7D7F9; -moz-border-radius: 2px; border-radius: 2px;" onclick="this.select()" />
			</td>
		</tr>
	</table>
	</div>
	
	<script type="text/javascript">SetSize();</script>
	
	</body>
</html>