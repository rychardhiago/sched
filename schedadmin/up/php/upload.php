<?php
session_start();

function newName($path, $filename) {
    $res = "$path/$filename";
    if (!file_exists($res)) return $res;
    $fnameNoExt = pathinfo($filename,PATHINFO_FILENAME);
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    $i = 1;
    while(file_exists("$path/$fnameNoExt ($i).$ext")) $i++;
    return "$path/$fnameNoExt ($i).$ext";
}

$output_dir = "../../../admin/empresas/".$_POST['empresaid']."/documentos/";
if (!file_exists($output_dir)) {
    mkdir($output_dir, 0777, true);
}

if(isset($_FILES["myfile"]))
{
    $ret = array();

    $error =$_FILES["myfile"]["error"];

    if(!is_array($_FILES["myfile"]["name"])) //single file
    {
        $fileName = newName($output_dir,$_FILES["myfile"]["name"]);
        move_uploaded_file($_FILES["myfile"]["tmp_name"],$fileName);
        $ret[]= $_FILES["myfile"]["name"];
    }
    else  //Multiple files, file[]
    {
        $fileCount = count($_FILES["myfile"]["name"]);
        for($i=0; $i < $fileCount; $i++)
        {
            $fileName = newName($output_dir,$_FILES["myfile"]["name"][$i]);
            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$fileName);
            $ret[]= $_FILES["myfile"]["name"][$i];
        }

    }
    echo json_encode($ret);
}
 ?>