<?php
/*此类为指定的图像文件统一生成JPG缩略图*/
class thumb 
{
	private $targetDir;
	private $sourceFile;
	private $targetFile;
	private $thumbWidth;
	private $thumbHeight;
	private $imgQuality=90;
	private $force;
	
	function __construct()
	{
		global $_G;
		$this->targetDir=$_G['setting']['attachdir'].'yiqixueba_pbl/';
		if (!is_dir($this->targetDir)) 
		{
			mkdir($this->targetDir,0777);
			fclose(fopen($this->targetDir.'/index.htm', 'w'));
		}		
	}
	
	function create($sourceFile,$targetFileName,$thumbWidth=300,$thumbHeight=300,$force=0)
	{
		$this->sourceFile=$sourceFile;
		$this->targetFile=$this->targetDir.$targetFileName;	
		$this->thumbWidth=$thumbWidth;
		$this->thumbHeight=$thumbHeight;
		$this->force=$force;
		if (!file_exists($this->sourceFile)) return 0;
		if ((file_exists($this->targetFile))&&(!$this->force)) return 0;
		$data=GetImageSize($this->sourceFile,&$info);
                         
  		if($data[0]<$this->thumbWidth and $data[1]<$this->thumbHeight){
     		$width=$data[0];
     		$height=$data[1];
  		} else if ($this->thumbWidth*$data[1]<=$this->thumbHeight*$data[0]){			
			$width=$this->thumbWidth;
     		$height=intval($width*$data[1]/$data[0]);
		} else {
			$height=$this->thumbHeight;
     		$width=intval($height*$data[0]/$data[1]);
		}

		switch($data[2])
		{
  		 	case 1:
         		$im=@ImageCreateFromGIF($this->sourceFile);
        		break;
   			case 2:
        		$im=@ImageCreateFromJPEG($this->sourceFile);
        		break;
   			case 3:
        		$im=@ImageCreateFromPNG($this->sourceFile);
        		break;
			
		}

		$srcW=ImageSX($im);
		$srcH=ImageSY($im);
		if ($data[2]==1) $to=imagecreate($width,$height);//GIF图像的画布，为256色，不是真彩色
		else $to=imagecreatetruecolor($width,$height);         
		@imagecopyresampled($to,$im,0,0,0,0,$width,$height,$srcW,$srcH);
        
		switch($data[2])
		{
  		 	case 1:
         		@ImageGIF($to,$this->targetFile.'.gif');
        		break;
   			case 2:
        		@ImageJPEG($to,$this->targetFile.'.jpg', $this->imgQuality);
        		break;
   			case 3:
        		@ImagePNG($to,$this->targetFile.'.png');
        		break;
			
		}    
		
           
		imagedestroy($im);
		imagedestroy($to);
	}
}
?>