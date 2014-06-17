<?php

	$username = "root";
	$password = "vsspl";
	$hostname = "localhost"; 

	//connection to the database
	$dbhandle = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
	mysql_select_db("Kalgudi",$dbhandle);
	$lat1=$_GET["lat"];
	$lng1=$_GET["lng"];

	$address=explode(',',$_GET["address"]);

	for($i=0;$i<sizeof($address);$i++) {
		$add[]="'".$address[$i]."'";
	}
	$location=str_replace("' ","'",implode(',',$add));
	$sql= mysql_query("select t0.ApmcName,t4.latitude,t4.longitude,t1.DistrictName,t2.StateName from apmc as t0,district as t1,states as t2,apmclatlng as t4 where t4.apmcid=t0.ApmcId and t0.DistrictId=t1.DistrictId and t1.StateId =t2.StateId  
and t1.DistrictName  IN (".$location.") ")   or die(mysql_error());
	$dis_total=mysql_num_rows($sql);

	if($dis_total<=0) {
		$sql= mysql_query("select t0.ApmcName,t4.latitude,t4.longitude,t1.DistrictName,t2.StateName from apmc as t0,district as t1,states as t2,apmclatlng as t4 where t4.apmcid=t0.ApmcId and t0.DistrictId=t1.DistrictId and t1.StateId =t2.StateId  
and t2.StateName  IN (".$location.") ")   or die(mysql_error());
		$state_total=mysql_num_rows($sql);
	}
	if(strcasecmp($_GET["address"],"India")==0 || $_GET['radius']!="Enter distance here" || $_GET['nearest']!="Select value") {
		$sql= mysql_query("select t0.ApmcName,t4.latitude,t4.longitude,t1.DistrictName,t2.StateName from apmc as t0,district as t1,states as t2 ,apmclatlng as t4 where t4.apmcid=t0.ApmcId and t0.DistrictId=t1.DistrictId and t1.StateId =t2.StateId ") or die(mysql_error());
	}

	$i=1;
	echo '<center><table border="1"><th>S.NO</th><th>APMC Name</th><th>District</th><th>State</th><th width="100">Latitude</th><th width="100">Longitude</th><th width="130">Distance(km)</th>';

	while($res= mysql_fetch_array($sql)) {
		
		$distance = haversineGreatCircleDistance($lat1, $lng1, $res['latitude'], $res['longitude'], 6371);
		array_push($res['distance'] = $distance);
		$var[]=$res;
	}
	
	if($_GET['radius']!="Enter distance here" && $_GET['nearest']=="Select value") {
		$result = radius_sort($var,'distance',$_GET['radius']); 
	} elseif($_GET['nearest']!="Select value" && $_GET['radius']=="Enter distance here") {	
		$result = nearestval_sort($var,'distance',$_GET['nearest']); 
	} else {
		$result = nearestval_sort($var,'distance',count($var)); 
	} 

	foreach($result as $k=>$res) {
		echo '<tr><td>'.$i.'</td><td>'.$res['ApmcName'].'</td></center>
		<td>'.$res['DistrictName'].'</td><td>'.$res['StateName'].'</td><td class="lat" id="lat'.$i.'">'.$res['latitude'].'</td><td class="lng" id="lng'.$i.'">'.$res['longitude'].'</td><td>'.$res['distance'].'</td><tr>';
		$i++;
	}
	echo '</table></center>';
	function nearestval_sort($a,$subkey,$limit) {
		foreach($a as $k=>$v) {
			$b[$k] = strtolower($v[$subkey]);
		}
		asort($b);
		foreach($b as $key=>$val) {
			$c[] = $a[$key];
		}
		return array_slice($c, 0, $limit);
	}
	function radius_sort($a,$subkey,$limit) {
		foreach($a as $k=>$v) {
			$b[$k] = strtolower($v[$subkey]);
			asort($b);
			if(round($b[$k])<=$limit) {
				$c[$k]=$b[$k];
			}
		}
		asort($c);
		foreach($c as $key=>$val) {
			$d[] = $a[$key];
		}
		return $d;
	}
	function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
	{
		// convert from degrees to radians
		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);

		$latDelta = $latTo - $latFrom;
		$lonDelta = $lonTo - $lonFrom;

		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
		cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
		return $angle * $earthRadius;
	}
?>