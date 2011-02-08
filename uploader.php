<?php
/**
* example php page to implement MazUploadClass.php
* @author Mazharul Anwar(mazharul2007@gmail.com)
* @package applies_to_uploadClass
*/

include_once('MazUploadClass.php');
$uploadpdf = new MazUploadClass(); //creating new object class

$test= $_FILES['pdf']; //getting file information from html page
$siz = 2097152; //size in Byte (2MB)
$fletype = "pdf"; //File type that you want to allow user to upload, currently supported formats are, image, pdf, audio, video, 
/**
* @return string $errorFlag
* validate the input type
*/
$uploadpdf->uploadPDF($test,  $siz, $fletype); 
/*----------/end of validation--------*/

if($uploadpdf->errorFlag['fileFlag'] == "yes"){
	echo "Ahh...crap!something went wrong.";
	//give appropriate error msg to the user as something wrong with the file
}else{
	echo "yeah..got the class working";


/**
* @Directory to save file: you can specify your own directory or you can call existing class function
* @upload file: you can use either class function or your own
*/
$uploadToFolder = "image"; //Folder name you want to upload your file under...yourroot/user_uploads, you can use this variable with createpath() function

/**
* @return a path ($dir) dynamically created every time when you upload something
* the path is ... user_uploads/$uploadToFolder/currentyear/currentmonth/currentdate/
* if you want your own upload path don't call this function, instead use your own path and add your path with original path below
*/
	$uploadpdf->createPath($fletype);  //you can replace the variable :)
/**
* random code
*/
	$uploadpdf->randomCode();

	$tmpFileName = $_FILES['pdf']['tmp_name'];
/**
* if you use custom path make sure your path is already created in the server
* and include your path in $originalPath instead of using this '$uploadpdf->path'
*/
	$originalPath = $uploadpdf->path.$uploadpdf->randomDigit.$test['name'];  
	/**
	 * You can save this path into database as string 
     */
	$uploadpdf->uploadToServer($tmpFileName, $originalPath);

}

?>
