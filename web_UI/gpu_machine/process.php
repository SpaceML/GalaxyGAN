<?php
$tempFile = $_FILES['file']['tmp_name'];
$ds = DIRECTORY_SEPARATOR;
$storeFolder = 'uploads';

$targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
$targetFile =  $targetPath. "recv_".$_FILES['file']['name'];
move_uploaded_file($tempFile,$targetFile);
chmod($targetFile, 0777);
$uploadFileName = $_FILES['file']['name'];

// process the file
$processDir = "uploads/".$uploadFileName;
mkdir($processDir."/test/", 0777,  true);
copy($targetFile, $processDir.$ds."test/".$uploadFileName);
chmod($processDir.$ds."test/".$uploadFileName, 0777);


$python_command = "python preprocess.py ".$processDir."/test/ ".$uploadFileName." > /tmp/py.log 2>&1";
$op = shell_exec($python_command);

$th_command = "export CUDNN_PATH=/usr/local/cuda/lib64/libcudnn.so && export LD_LIBRARY_PATH=\$LD_LIBRARY_PATH:/usr/local/torch/install/lib:/usr/local/cuda/lib64 && DATA_ROOT=".$processDir." name=001002_2.5_5.0 which_direction=BtoA phase=test display=0 gpu=1 checkpoints_dir=/mnt/ds3lab/roou_v2_checkpoint/ results_dir=demo_response/ /usr/local/torch/install/bin/th /mnt/ds3lab/astronomy/pix2pix/test.lua > /tmp/th.log 2>&1";
$op1 = shell_exec($th_command);
$processedFile = "demo_response/001002_2.5_5.0/latest_net_G_test/images/output/".$uploadFileName;

// Send the result back
header('Content-Type: image/jpg');
echo file_get_contents($processedFile);
?>