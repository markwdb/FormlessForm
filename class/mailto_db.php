<?php
$message="";
$ignore_name=array(
"recipient-email",
"from-email",
"from-name",
"subject",
"redirect"
);
foreach ($_POST as $key=>$value){
        if (!in_array($key,$ignore_name)){
                if (strtolower($key)<>"submit"){
                        if ($key==$value){
                                $value="CHECKED";
                        }
                        $key=str_replace("_"," ",$key);
                        $key=ucwords(strtolower($key));
                        //$message.="$key: $value\n\n";
                        $value=stripslashes($value);
                        $message.="$key: $value\n";
                }
        }
}
$subject_line=$_POST['subject'];
$file_message=$message;
$uploaded_files=array();
  $headers="From: ".$_POST['from-name']."<".$_POST['from-email'].">";
foreach ($_FILES as $key=>$value){
  $cvatt  = $_FILES[$key]['tmp_name'];
  $cvatt_type = $_FILES[$key]['type'];
  $cvatt_name = $_FILES[$key]['name'];
                if (is_uploaded_file($cvatt)) {
                                                 
                                                  // Read the file to be attached ('rb' = read binary)
                                                  $file1 = fopen($cvatt,'rb');
                                                  $data1 = fread($file1,filesize($cvatt));
                                                  fclose($file1);

                                                $file_message .= "\n$key:  ".$cvatt_name;

                                                 // Generate a boundary string
                                                 $semi_rand = md5(time());
                                                 $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

                                                // Add a multipart boundary above the plain message
                                                $file_message = "This is a multi-part message in MIME format.\n\n" .
                                                         "--{$mime_boundary}\n" .
                                                         "Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
                                                         "Content-Transfer-Encoding: 7bit\n\n" .
                                                         $file_message . "\n\n";

                                                 // Add the headers for a file attachment
                                                 $headers .= "\nMIME-Version: 1.0\n" .
                                                                          "Content-Type: multipart/mixed;\n" .
                                                                          " boundary=\"{$mime_boundary}\"";

                                                // Base64 encode the file data
                                                $data1 = chunk_split(base64_encode($data1));                                          
                                             // Add file attachment to the message
                                             $file_message .= "--{$mime_boundary}\n" .
                                                  "Content-Type: {$cvatt_type};\n" .
                                                  " name=\"{$cvatt_name}\"\n" .
                                                  "Content-Disposition: attachment;\n" .
                                                  " filename=\"{$cvatt_name}\"\n" .
                                                  "Content-Transfer-Encoding: base64\n\n" .
                                                  $data1 . "\n\n";
                        }
}
if ($_POST['recipient-email'] AND $subject_line AND $file_message AND $_POST['from-email']){
	mail ($_POST['recipient-email'],$subject_line,$file_message,$headers);
	mail ("markw@digitalbridge.com.au",$subject_line,$file_message,$headers);
}
header ("Location: ".$_POST['redirect']);
?>
