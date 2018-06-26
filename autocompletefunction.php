<?php
include 'conn.php';	
$From=$_GET['From'];
$Value=$_GET['Value'];
$return_arr = array(); 
if($From=="author"){
	$sql="SELECT dc_contributor_author FROM `books` WHERE LOWER(replace(dc_contributor_author,' ','')) like '%".strtolower(preg_replace('/\s+/', '', $_GET['term']))."%' GROUP BY LOWER(replace(dc_contributor_author,' ','')) limit 0,100";
	$result = mysqli_query($conn,$sql);
	$numofrows=mysqli_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['dc_contributor_author'],ENT_QUOTES),ENT_QUOTES);
			array_push($return_arr,$row_array);
		}
	}else{
		$row_array['value']="No data found";
		$row_array['id']="";
		array_push($return_arr,$row_array);
	}	
	echo json_encode($return_arr);
}
if($From=="subject"){
	$sql="SELECT dc_subject_keywords FROM `books` WHERE LOWER(replace(dc_subject_keywords,' ','')) like '%".strtolower(preg_replace('/\s+/', '', $_GET['term']))."%' GROUP BY LOWER(replace(dc_subject_keywords,' ','')) limit 0,100";
	$result = mysqli_query($conn,$sql);
	$numofrows=mysqli_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['dc_subject_keywords'],ENT_QUOTES),ENT_QUOTES);
			array_push($return_arr,$row_array);
		}
	}else{
		$row_array['value']="No data found";
		//$row_array['id']="";
		array_push($return_arr,$row_array);
	}	
	echo json_encode($return_arr);
}
if($From=="title"){
	$sql="SELECT dc_title FROM `books` WHERE LOWER(replace(dc_title,' ','')) like '%".strtolower(preg_replace('/\s+/', '', $_GET['term']))."%' GROUP BY LOWER(replace(dc_title,' ','')) ORDER BY `books`.`dc_title` ASC LIMIT 0,100";
	$result = mysqli_query($conn,$sql);
	$numofrows=mysqli_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['dc_title'],ENT_QUOTES),ENT_QUOTES);
			array_push($return_arr,$row_array);
		}
	}else{
		$row_array['value']="No data found";
		array_push($return_arr,$row_array);
	}	
	echo json_encode($return_arr);
}
if($From=="institution"){
	$sql="SELECT dc_source_library FROM `books` WHERE LOWER(replace(dc_source_library,' ','')) like '%".strtolower(preg_replace('/\s+/', '', $_GET['term']))."%' GROUP BY LOWER(replace(dc_source_library,' ',''))";
	$result = mysqli_query($conn,$sql);
	$numofrows=mysqli_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['dc_source_library'],ENT_QUOTES),ENT_QUOTES);
			array_push($return_arr,$row_array);
		}
	}else{
		$row_array['value']="No data found";
		array_push($return_arr,$row_array);
	}	
	echo json_encode($return_arr);
}
?>
