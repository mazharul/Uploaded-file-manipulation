<?php
/*----------------------------------
php class for validating any picutre, video, files or script
and creating valid path on the server to upload the file
#-----------------------------------
* @ Author: Mazharul Anwar(mazharul2007@gmail.com)
* @ Homepage: http://protishobdo.com
* @ Author Twitter: http://twitter.com/mazharul_anwar
* @ Version : v1.0.200
* @ Previous version: v1.0.199 
* @ release date: April28, 2010
* @version change date: May 11, 2010
* @ Thanks to : Farhan (mohd.farhan@integricity.com)
#------------------------------------------------------------------------------------------

Copyright (C) 2010  Mazharul Anwar(mazharul2007@gmail.com)

    This program is free software: you can redistribute it and/or modify 
    it under the terms of the GNU General Public License as published by 
    the Free Software Foundation, either version 3 of the License, or 
    (at your option) any later version. 

    This program is distributed in the hope that it will be useful, 
    but WITHOUT ANY WARRANTY; without even the implied warranty of 
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
    GNU General Public License for more details. 

    You should have received a copy of the GNU General Public License 
    along with this program.  If not, see <http://www.gnu.org/licenses/>. 
#-----------------------------------------------------------------------------------------------*/

/*------------------------------------------
# main function to upload image 
# in the server
---------------------------------------------*/
class MazUploadClass{

	public $errorMsg;
	 public $mainArray = array();


/*--------------------------------------------
* @Creating Path for uploaded files
* @default path is ..user_uploads/$uploadType/$tyear/$tmonth/$tday/
* @ you can change the $uploadType from your file handeling php file
---------------------------------------------*/
public function createPath($uploadType){
		$tyear = date("Y");
		$tmonth = date("m");
		$tday = date("d");
		
	# Checking the directory and creating folders for images according to the year, month and day
	  if (!is_dir("user_uploads/$uploadType/$tyear/$tmonth/$tday"))  
		 {  
			if (!is_dir("user_uploads/$uploadType/$tyear/$tmonth"))  
			  { 
				   if (!is_dir("user_uploads/$uploadType/$tyear"))
				     { 
						
						if(!is_dir("user_uploads/$uploadType"))
							{
								if(!is_dir("user_uploads"))
								  {
									 $umask = umask(0);
									  mkdir("user_uploads", 0777, true); 
									 umask($umask);
									 }else{}						 
									 $umask = umask(0);
									  mkdir("user_uploads/$uploadType", 0777, true); 
									 umask($umask);
									}else{}

									 $umask = umask(0);
									   mkdir("user_uploads/$uploadType/$tyear", 0777, true); 
									   umask($umask);
									   } else {} 
									 $umask = umask(0);
									   mkdir("user_uploads/$uploadType/$tyear/$tmonth", 0777, true);
										umask($umask);

			  }  
			  else {} 
			 $umask = umask(0);
			  mkdir("user_uploads/$uploadType/$tyear/$tmonth/$tday", 0777, true); 
			umask($umask); 
			$path = "user_uploads/$uploadType/$tyear/$tmonth/$tday/";
		 }   

		 else {}

		return $this->path = "user_uploads/$uploadType/$tyear/$tmonth/$tday/";
				

} #-----------/end of function createPath---

/*--------------------------
# uploaded file validation
# @param $pdf, the name of uploaded file, eg. $pdf = $_FILES['pdf'];
# @param $size the file size that you want to restrict the user
# @param $fltype is the type of file, currently support pdf, image, video, audio, pdf files!
-----------------------------*/

public function uploadPDF($pdf, $size, $fltype){
	
          
        if($fltype != ""){ #start of pdf file upload   
			             $this->arrayCondition($fltype);
			           
           if(!empty($pdf)){ #checking file validation
			  
			  $mimeTypeFlag = "yes";
		
			 foreach($this->mainArray['MIMEtype'] as $r){
			  	if($pdf['type'] == $r){
			  		$mimeTypeFlag = "no";
			  		break;
			  	}
			   }
			
			
			if(($mimeTypeFlag == "no") && ($pdf['size'] <= $size)){				
				$ext = end(explode(".",strtolower($pdf['name'])));
				
				 $this->errorFlag['fileFlag'] = "yes";
				
			
				foreach($this->mainArray['fileTypeArray']  as $value){
				   if($ext == $value){
				   	$this->errorFlag['fileFlag'] = "no";
				   	break;
					  }else{ }
				 }
				
			}else{
				$errorPdf = "yes";
				$this->errorFlag['fileFlag'] = "yes";
				
			}
		}else{
			$this->errorFlag['fileFlag'] = "yes";
		}
	}else{
		
		$this->errorFlag['fileFlag'] = "yes";
		$this->msgError['msgError']  = "FileType is not provided";
		
	}#--/end of file validation
	return $this->errorFlag;

    } #---/end of pdf file upload-----

/*-------------------------
* array select
-------------------------------*/
private  function arrayCondition($fltype){
	        
	          
	                 if($fltype == "pdf"){
					      $fileTypeArray =  array('pdf','x-pdf', 'acrobat', 'vnd.pdf' );
					      $MIMEtype = array('application/pdf','application/x-pdf', 'application/acrobat', 'applications/vnd.pdf', 'text/pdf', 'text/x-pdf'); 
					      $this->mainArray['fileTypeArray']= $fileTypeArray;
					      $this->mainArray['MIMEtype'] = $MIMEtype;
				      }elseif($fltype == "image"){
					      $fileTypeArray = array('jpg', 'jpeg', 'gif', 'png', 'tif', 'bmp');
					      $MIMEtype = array('image/jpg', 'image/gif', 'image/jpeg', 'image/png', 'image/tiff', 'image/bmp');
					      $this->mainArray['fileTypeArray'] = $fileTypeArray;
					     $this->mainArray['MIMEtype'] = $MIMEtype;
				      }
				      /*elseif($filetype == "file"){
					      $fileTypeArray = array('php', 'php5', 'html', 'css', 'aspx', 'asp');
					     
				      }*/elseif($fltype == "video"){
					      $fileTypeArray = array('map2', 'mpa', 'mpe', 'mpeg', 'mpg', 'mpeg', 'mov', 'qt', 'avi', 'movie', 'flv', 'swf', 'mp4', 'moov');
					       $MIMEtype = array('video/mpeg', 'video/quicktime', 'video/x-msvideo', 'video/x-sgi-movie', 'video/avi', 'video/x-flv', 'video/mp4');
					      $this->mainArray['fileTypeArray']= $fileTypeArray;
					      $this->mainArray['MIMEtype'] = $MIMEtype;
					     
				      }elseif($fltype == "audio"){
					     $fileTypeArray = array('mp2', 'mp3', 'snd', 'wav', 'tif', 'aif', 'aifc', 'au', 'mid', 'midi', 'mod');
					     $MIMEtype = array('audio/basic', 'audio/x-wav', 'audio/aiff', 'audio/x-aiff', 'audio/midi', 'audio/x-midi', 'audio/mod', 'audio/x-mod');
					     $this->mainArray['fileTypeArray']= $fileTypeArray;
					     $this->mainArray['MIMEtype'] = $MIMEtype;
	              			}

                
                
              
	}#----/end of Array select
	
public function randomCode(){
	$this->randomDigit=mt_rand();
	return $this->randomDigit;
}

/*-----------------
* @upload file
* @param $file is temporary file name , $_FILES['pdf']['tmp_name']
* @param original path to the server to store the file
*----------------------*/

public function uploadToServer($file, $to){
	if(!empty($file) && !empty($to)){
	move_uploaded_file($file, $to);
	}
}


} #----/end of class----
?>