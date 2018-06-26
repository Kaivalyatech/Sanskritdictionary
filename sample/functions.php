<?php
include 'conn.php';	
$From=$_GET['From'];
$Whichfield=$_GET['Whichfield'];
$Value=$_GET['Value'];
$return_arr = array(); 
if($From=="author"){
	//$sql="SELECT dc_contributor_author FROM `books` WHERE dc_contributor_author like '%".mysql_real_escape_string($_GET['term'])."%' GROUP BY dc_contributor_author ORDER BY dc_contributor_author ASC limit 0,6";
	$sql="SELECT dc_contributor_author FROM `books` WHERE LOWER(replace(dc_contributor_author,' ','')) like '%".mysql_real_escape_string(strtolower(preg_replace('/\s+/', '', $_GET['term'])))."%' GROUP BY LOWER(replace(dc_contributor_author,' ','')) limit 0,100";
	//echo $sql;
	$result = mysql_query($sql);
	$numofrows=mysql_num_rows($result);
	//echo $numofrows;
	if($numofrows!=0)
	{
		while($row=mysql_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['dc_contributor_author'],ENT_QUOTES),ENT_QUOTES);
			//$row_array['id'] = $row['Id'];
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
	//$sql="select DISTINCT dc_subject_keywords from `books` where dc_subject_keywords like '%".mysql_real_escape_string($_GET['term'])."%' limit 0,100";
	$sql="SELECT dc_subject_keywords FROM `books` WHERE LOWER(replace(dc_subject_keywords,' ','')) like '%".mysql_real_escape_string(strtolower(preg_replace('/\s+/', '', $_GET['term'])))."%' GROUP BY LOWER(replace(dc_subject_keywords,' ','')) limit 0,100";
	//echo $sql;
	$result = mysql_query($sql);
	$numofrows=mysql_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysql_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['dc_subject_keywords'],ENT_QUOTES),ENT_QUOTES);
			//$row_array['id'] = $row['Id'];
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
	$sql="select DISTINCT dc_title from `books` where dc_title like '%".mysql_real_escape_string(strtolower(preg_replace('/\s+/', '', $_GET['term'])))."%' limit 0,100";
	//echo $sql;
	$result = mysql_query($sql);
	$numofrows=mysql_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysql_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['dc_title'],ENT_QUOTES),ENT_QUOTES);
			//$row_array['id'] = $row['Id'];
			array_push($return_arr,$row_array);
		}
	}else{
		$row_array['value']="No data found";
		//$row_array['id']="";
		array_push($return_arr,$row_array);
	}	
	echo json_encode($return_arr);
}
if($From=="institution"){
	//$sql="select DISTINCT dc_source_library from `books` where dc_source_library like '%".mysql_real_escape_string($_GET['term'])."%'";
	$sql="SELECT dc_source_library FROM `books` WHERE LOWER(replace(dc_source_library,' ','')) like '%".mysql_real_escape_string(strtolower(preg_replace('/\s+/', '', $_GET['term'])))."%' GROUP BY LOWER(replace(dc_source_library,' ',''))";
	//echo $sql;
	$result = mysql_query($sql);
	$numofrows=mysql_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysql_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['dc_source_library'],ENT_QUOTES),ENT_QUOTES);
			//$row_array['id'] = $row['Id'];
			array_push($return_arr,$row_array);
		}
	}else{
		$row_array['value']="No data found";
		//$row_array['id']="";
		array_push($return_arr,$row_array);
	}	
	echo json_encode($return_arr);
}

if($From=="displaybook"){
	//echo "value--".$Value;
	//echo utf8_encode('"reason"');
	//$newvalue=str_replace('"', '', $Value);
	//echo $newvalue;
	if(($Value!="")&&($Value!="No data found")){
		$TrimValue=strtolower(preg_replace('/\s+/', '', $Value));
		if($Whichfield=="author")
		{
			$sql='select * from `books` where LOWER(replace(dc_contributor_author," ",""))="'.$TrimValue.'"';
		}
		if($Whichfield=="subject")
		{
			$sql='select * from `books` where LOWER(replace(dc_subject_keywords," ",""))="'.$TrimValue.'"';
		}
		if($Whichfield=="title")
		{
			$sql='select * from `books` where LOWER(replace(dc_title," ",""))="'.$TrimValue.'"';
		}
		if($Whichfield=="institution")
		{
			$sql='select * from `books` where LOWER(replace(dc_source_library," ",""))="'.$TrimValue.'"';
		}
		echo "<div class='Header'>".ucfirst($Whichfield)." : ".$Value."</div>";
		//echo $sql;
		$result = mysql_query($sql);
		$numofrows=mysql_num_rows($result);
		if($numofrows!=0)
		{
			while($row=mysql_fetch_array($result))
			{
				echo "<a href='bookpage.php?GoogleId=".$row['google_drive_id']."&Id=".$row['id']."' target='_blank'><div class='bookdiv'><img src='https://dli2.herokuapp.com/go-drive/images/".substr($row['google_drive_id'],0,14)."/".substr($row['google_drive_id'],14,2)."/".substr($row['google_drive_id'],16,2)."/".$row['google_drive_id'].".png'><div class='text'>";
				if($row['dc_contributor_author']){
					echo html_entity_decode(html_entity_decode($row['dc_contributor_author'],ENT_QUOTES),ENT_QUOTES)."<br>";
				}else{
					echo "--<br>";
				}
				echo html_entity_decode(html_entity_decode($row['dc_title'],ENT_QUOTES),ENT_QUOTES)."</div></div></a>";
			}
			echo "<script>$('#searchresult').css('height','auto');</script>";
		}else{
			echo "<div class='emptydiv'>No Data Found</div>";
			echo "<script>$('#searchresult').css('height','326px');</script>";
		}
	}
	//echo "<div class='bookdiv'>".$Whichfield."<br>".$Value."</div>";
}

if($From=="mainsearch"){
	if($Value!=""){
		$sql='select * from `books` where dc_title like "%'.$Value.'%" or dc_contributor_author like "%'.$Value.'%" or dc_subject_keywords like "%'.$Value.'%" or dc_source_library like "%'.$Value.'%" limit 0,200';
		$result = mysql_query($sql);
		$numofrows=mysql_num_rows($result);
		if($numofrows!=0){
			$mstr="";
			while($row=mysql_fetch_array($result))
			{
				$mstr.= "<a href='bookpage.php?GoogleId=".$row['google_drive_id']."&Id=".$row['id']."' target='_blank'><div class='bookdiv'><img src='https://dli2.herokuapp.com/go-drive/images/".substr($row['google_drive_id'],0,14)."/".substr($row['google_drive_id'],14,2)."/".substr($row['google_drive_id'],16,2)."/".$row['google_drive_id'].".png'><div class='text'>";
				if($row['dc_contributor_author']){
					$mstr.= html_entity_decode(html_entity_decode($row['dc_contributor_author'],ENT_QUOTES),ENT_QUOTES)."<br>";
				}else{
					$mstr.= "--<br>";
				}
				$mstr.= html_entity_decode(html_entity_decode($row['dc_title'],ENT_QUOTES),ENT_QUOTES)."</div></div></a>";
			}
			echo "<script>$('#searchresult').css('height','auto');</script>";
			echo $mstr;
		}else{
			echo "<div class='emptydiv'>No Data Found</div>";
			echo "<script>$('#searchresult').css('height','326px');</script>";
		}
	}else{
		echo "<script>$('#searchresult').css('height','326px');</script>";
	}
}

if($From=="rangefilter"){
	if($Value!=""){
		$sql='select * from `books` where dc_date_citation="'.$Value.'"';
		//echo $sql;
		$result = mysql_query($sql);
		$numofrows=mysql_num_rows($result);
		if($numofrows!=0){
			while($row=mysql_fetch_array($result))
			{
				echo "<a href='bookpage.php?GoogleId=".$row['google_drive_id']."&Id=".$row['id']."' target='_blank'><div class='bookdiv'><img src='https://dli2.herokuapp.com/go-drive/images/".substr($row['google_drive_id'],0,14)."/".substr($row['google_drive_id'],14,2)."/".substr($row['google_drive_id'],16,2)."/".$row['google_drive_id'].".png'><div class='text'>";
				if($row['dc_contributor_author']){
					echo html_entity_decode(html_entity_decode($row['dc_contributor_author'],ENT_QUOTES),ENT_QUOTES)."<br>";
				}else{
					echo "--<br>";
				}
				echo html_entity_decode(html_entity_decode($row['dc_title'],ENT_QUOTES),ENT_QUOTES)."</div></div></a>";
			}
			echo "<script>$('#searchresult').css('height','auto');</script>";
		}else{
			echo "<div class='emptydiv'>No Data Found</div>";
			echo "<script>$('#searchresult').css('height','326px');</script>";
		}
	}
}

/*if($From=="datesearch"){
	//echo $Value."value==".date('Y-m-d',strtotime($Value));
	if($Value!=""){
		$sql='select * from `books` where dc_date_digitalpublicationdate="'.date('Y-m-d',strtotime($Value)).'"';
		$result = mysql_query($sql);
		$numofrows=mysql_num_rows($result);
		if($numofrows!=0){
			while($row=mysql_fetch_array($result))
			{
				$file = "https://dli2.herokuapp.com/go-drive/images/".substr($row['google_drive_id'],0,14)."/".substr($row['google_drive_id'],14,2)."/".substr($row['google_drive_id'],16,2)."/".$row['google_drive_id'].".png";
				if (file_exists($file)){
					echo "yes";
				}else{
					echo "no";
				}
				echo "<a href='http://dli.sanskritdictionary.com/view/".$row['google_drive_id']."' target='_blank'><div class='bookdiv'><img src='".$file."'><div class='text'>Title--".html_entity_decode(html_entity_decode($row['dc_title'],ENT_QUOTES),ENT_QUOTES)."<br>Author--".html_entity_decode(html_entity_decode($row['dc_contributor_author'],ENT_QUOTES),ENT_QUOTES)."<br>".$row['google_drive_id']."</div></div></a>";
			}
			echo "<script>$('#searchresult').css('height','auto');</script>";
		}else{
			echo "<div class='emptydiv'>No Data Found</div>";
			echo "<script>$('#searchresult').css('height','326px');</script>";
		}
	}
}*/

/*if($From=="displaybook"){
	$AuthorId=$_GET['AuthorId'];
	$SubjectId=$_GET['SubjectId'];
	$TitleId=$_GET['TitleId'];
	$InstitutionId=$_GET['InstitutionId'];
	$Condition="";
	if($AuthorId!=""){
		$Condition.="a.AuthorId='".$AuthorId."'";
	}
	if($SubjectId){
		if($Condition!=""){
			$Condition.=" and ";
		}
		$Condition.="a.SubjectId='".$SubjectId."'";
	}
	if($TitleId){
		if($Condition!=""){
			$Condition.=" and ";
		}
		$Condition.="a.TitleId='".$TitleId."'";
	}
	if($InstitutionId){
		if($Condition!=""){
			$Condition.=" and ";
		}
		$Condition.="a.InstitutionId='".$InstitutionId."'";
	}
	$sql="Select * from Book a,Authors b,Subject c,Title d,Institution e where a.AuthorId=b.Id and a.SubjectId=c.Id and a.TitleId=d.Id and a.InstitutionId=e.Id and ".$Condition;
	$result = mysql_query($sql);
	$numofrows=mysql_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysql_fetch_array($result))
		{
			echo "<div class='bookdiv'>".$row['TitleName']."<br>".$row['AuthorName']."<br>".$row['SubjectName']."<br>".$row['InstitutionName']."</div>";
		}
		echo "<script>$('#searchresult').css('height','auto');</script>";
	}else{
		echo "<script>$('#searchresult').css('height','326px');</script>";
	}
}*/

?>
