<?php
include 'conn.php';	
$From=$_GET['From'];
$return_arr = array(); 
if($From=="author"){
	$sql="select Id,AuthorName from `Authors` where AuthorName like '%".mysql_real_escape_string($_GET['term'])."%' ";
	//echo $sql;
	$result = mysql_query($sql);
	$numofrows=mysql_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysql_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['AuthorName'],ENT_QUOTES),ENT_QUOTES);
			$row_array['id'] = $row['Id'];
			//print_r($row_array);
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
	$sql="select Id,SubjectName from `Subject` where SubjectName like '%".mysql_real_escape_string($_GET['term'])."%' ";
	//echo $sql;
	$result = mysql_query($sql);
	$numofrows=mysql_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysql_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['SubjectName'],ENT_QUOTES),ENT_QUOTES);
			$row_array['id'] = $row['Id'];
			//print_r($row_array);
			array_push($return_arr,$row_array);
		}
	}else{
		$row_array['value']="No data found";
		$row_array['id']="";
		array_push($return_arr,$row_array);
	}	
	echo json_encode($return_arr);
}
if($From=="title"){
	$sql="select Id,TitleName from `Title` where TitleName like '%".mysql_real_escape_string($_GET['term'])."%' ";
	//echo $sql;
	$result = mysql_query($sql);
	$numofrows=mysql_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysql_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['TitleName'],ENT_QUOTES),ENT_QUOTES);
			$row_array['id'] = $row['Id'];
			//print_r($row_array);
			array_push($return_arr,$row_array);
		}
	}else{
		$row_array['value']="No data found";
		$row_array['id']="";
		array_push($return_arr,$row_array);
	}	
	echo json_encode($return_arr);
}
if($From=="institution"){
	$sql="select Id,InstitutionName from `Institution` where InstitutionName like '%".mysql_real_escape_string($_GET['term'])."%' ";
	//echo $sql;
	$result = mysql_query($sql);
	$numofrows=mysql_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysql_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['InstitutionName'],ENT_QUOTES),ENT_QUOTES);
			$row_array['id'] = $row['Id'];
			//print_r($row_array);
			array_push($return_arr,$row_array);
		}
	}else{
		$row_array['value']="No data found";
		$row_array['id']="";
		array_push($return_arr,$row_array);
	}	
	echo json_encode($return_arr);
}

if($From=="displaybook"){
	$AuthorId=$_GET['AuthorId'];
	$SubjectId=$_GET['SubjectId'];
	$TitleId=$_GET['TitleId'];
	$InstitutionId=$_GET['InstitutionId'];
	$TableNames="";
	$Condition="";
	if($AuthorId!=""){
		$TableNames.="Authors b";
		$Condition.="a.AuthorId='".$AuthorId."' and a.AuthorId=b.Id";
	}
	if($SubjectId){
		if($TableNames!=""){
			$TableNames.=",";
		}
		if($Condition!=""){
			$Condition.=" and ";
		}
		$TableNames.="Subject c";
		$Condition.="a.SubjectId='".$SubjectId."' and a.SubjectId=c.Id";
	}
	if($TitleId){
		if($TableNames!=""){
			$TableNames.=",";
		}
		if($Condition!=""){
			$Condition.=" and ";
		}
		$TableNames.="Title d";
		$Condition.="a.TitleId='".$TitleId."' and a.TitleId=d.Id";
	}
	if($InstitutionId){
		if($TableNames!=""){
			$TableNames.=",";
		}
		if($Condition!=""){
			$Condition.=" and ";
		}
		$TableNames.="Institution e";
		$Condition.="a.InstitutionId='".$InstitutionId."' and a.InstitutionId=e.Id";
	}
	$sql="Select * from Book a,".$TableNames." where ".$Condition;
	echo $sql;
	$result = mysql_query($sql);
	$row=mysql_fetch_array($result);
}
?>
