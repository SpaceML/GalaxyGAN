<?php
$ds = DIRECTORY_SEPARATOR; 
$storeFolder = 'uploads';

function cURLcheckBasicFunctions() {
  if( !function_exists("curl_init") &&
      !function_exists("curl_setopt") &&
      !function_exists("curl_exec") &&
      !function_exists("curl_close") ) return false;
  else return true;
} 

if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
    $targetFile =  $targetPath. $_FILES['file']['name'];
    move_uploaded_file($tempFile,$targetFile);

if( !cURLcheckBasicFunctions() ) 
{ echo "UNAVAILABLE: cURL Basic Functions"; }

$url = "129.132.102.52/process.php";

$file = new CURLFile($targetFile);
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'file' => $file,
]);

$reply = curl_exec($ch);
$processedFile = $targetPath. "drshift_". $_FILES['file']['name'];
file_put_contents($processedFile, $reply);

curl_close($ch);
echo $_FILES['file']['name'];
}
?>
