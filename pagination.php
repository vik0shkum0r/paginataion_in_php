<?php

function pegination($total_count,$per_page,$sql,$connection){
	
	$loop_count=ceil(($total_count/$per_page));
	$dropdown=array();
	$returnarr=array();
	$page_no=1;
	$page_name=explode("/",$_SERVER['SCRIPT_NAME']);
    $page_name=end($page_name); 
	if(!isset($_GET['current_pg_no'])){
		header("location:".$page_name."?current_pg_no=1");
	}
	 $url_keys=$_SERVER['QUERY_STRING'];
	 $Url_Keys=explode("&",$url_keys);
	 $arr_index_count=0;
	 foreach($Url_Keys as $Uel_key){
		 if (strpos($Uel_key, 'current_pg_no') !== false) {
           unset($Url_Keys[$arr_index_count]);
         } 
		 $arr_index_count++;
	 } 
	 $url_keys=implode("&",$Url_Keys);
    $current_pg_no=$_GET['current_pg_no'];
    if(strlen($url_keys)>0){$and="&";}else{$and="";}
	$dropdown[]= "<select class='page_dropdown_class' name='sample' onchange='location = this.value;'>";
	for($i=1;$i<=$loop_count;$i++){
		$selected="";
		if($page_no==$current_pg_no){$selected="selected";}
		$dropdown[]="<option class='each_page_option_class' ".$selected." value='?current_pg_no=".$page_no.$and.$url_keys."'>".$page_no."</option>";
		 $page_no++;
	}
	 $dropdown[]= "</select>";
	 $Dropdown= implode("\n",$dropdown);
	 $returnarr["dropdowdn"]=$Dropdown;
	 if($_GET['current_pg_no']>1){
		 $returnarr["first_pg"]="<a class='page_btn_class' href='?current_pg_no=1".$and.$url_keys."'>First Page</a>";
		 $returnarr["previous_pg"]="<a class='page_btn_class' href='?current_pg_no=".($_GET['current_pg_no']-1).$and.$url_keys."'>Pre Page</a>";
	 }
	 if($loop_count>1 && $_GET['current_pg_no']!=$loop_count){
		  $returnarr["next_pg"]="<a class='page_btn_class' href='?current_pg_no=".($_GET['current_pg_no']+1).$and.$url_keys."'>Next  Page</a>";
		  $returnarr["last_pg"]="<a class='page_btn_class' href='?current_pg_no=".$loop_count.$and.$url_keys."'>Last Page</a>";
	 }
	   $per_page_in_sql=$per_page;
	   $current_pg_no_in_sql=$current_pg_no-1;
	  $limit_calculation=($per_page_in_sql*$current_pg_no_in_sql).",".$per_page_in_sql;
	       $sql2=$sql." limit ".$limit_calculation;
	       $q_exe2=mysqli_query($connection,$sql2);
		   $fetch_data=array();
		   while($res=mysqli_fetch_assoc($q_exe2)){
			   $fetch_data[]=$res['id'];
		   }
	    return $returnarr2=array('pages'=>$returnarr,'fetch_data'=>$fetch_data,'sql'=>$sql2);
	}



$returndata=array();
$conn=mysqli_connect('localhost','root','','onlinetestdb');
$sql="SELECT * FROM `user_answered` where 1 ";
$q_exe=mysqli_query($conn,$sql);
 $toral_rows_count=mysqli_num_rows($q_exe);


$returndata=pegination($toral_rows_count,20,$sql,$conn);


echo "<pre>";


print_r($returndata);







?>
<html>
<body>

</body>
</html>