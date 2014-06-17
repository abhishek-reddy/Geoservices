<!DOCTYPE html>
<html>
	<head>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
		<script type="text/javascript" src="/Geoservices/geo.js"></script>
		<style>
			.searchtext{float: left;width: 200px;height: 28px;margin-right: 4px;margin-top: 3px}
			.main{width:300px;margin: 10px;float: left;margin:0px 10px 10px 60px}
			.heading{width:95%;height:5.5vw;margin:auto;color:white;background:black;font-size:3vw}
			.googletextbox{margin-top:40px;float:left;width:400px}
			#Nearestno{float:left;width:100px;height:30px;margin:5px 0px 0px 3px}
			.box2{float:left;width:100px;margin-top:4px;}
			#getCords{float:left;margin:10px 0px 0px 50px}th{color:#B620C7}
		</style>
	</head>
	<body topmargin="0">
		<div class="heading">
			<h2 align="center" style="margin-top:0px" >Kalgudi - Geo Services</h2>
		</div>

		<div class="main">
			<div class="googletextbox">
				<input type="text" id="my-address" class="searchtext">
				<div style="display:none" id="nearestDiv">
					<select id="Nearestno" ><option value="Select value">Select value</option>"<?php
						for ($x=1; $x<=12; $x++)
						echo '<option value="' . $x . '">'. $x .'</option>' . PHP_EOL;
						?>
					</select>
				</div>
				<input type="text" id="radiusDiv" onblur="this.value=!this.value?'Enter distance here':this.value;" class="searchtext" value="Enter distance here" onfocus="document.getElementById('radiusDiv').value='';" style="display:none;width:130px" />
			</div>
			<div style="margin-top:10px" class="googletextbox">
				<b class="box2"><input type="radio" id="nearest" name="distance"  onclick="javascript:radiocheck();" value="nearest"> Nearest</b>
				<b class="box2"><input type="radio" name="distance" id="radius" value="Radius"  onclick="javascript:radiocheck();"> Radius</b>
			</div>
			<button id="getCords" onClick="codeAddress();"><img src="/Geoservices/img/search.jpg"/></button>
		</div>
		<div id="location" style="width:75%;float:left;margin-top:40px;"></div>
	</body>
</html>

