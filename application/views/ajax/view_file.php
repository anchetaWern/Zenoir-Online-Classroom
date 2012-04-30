<!--file viewer-->
<div class="image_container">
<?php

$file_id	= $page['file_id'];
$filename 	= $page['filename'];
$file_ext	= $page['file_ext'];
$type_id	= $page['type_id'];
/*
$filetype_id 
	0-document 	- pdf, htm, html
	1-video		- webm, mp4, ogv
	2-audio		- mp3
	3-images	- png, gif, jpeg, jpg
*/
//the rest of the filetypes that are not mentioned is only for download

$back	= array(
			'id'=>'back',
			'name'=>'back',
			'value'=>'Back',
			'content'=>'Back',
			'class'=>'medium orange'
		);
		
switch($type_id){
	case 0: //document -only reads txt, pdf, xls, html 
	
			echo "<a href='/zenoir/index.php/ajax_loader/view/dl_file?fid=$file_id'>$filename</a>";	
	break;
	
	case 1: //video - only reads webm, mp4, and ogv
		if($file_ext == 'webm'){
			$codec_id = 0;
		}else if($file_ext == 'mp4'){
			$codec_id = 1;
		}else if($file_ext == 'ogv'){
			$codec_id = 2;
		}
		$codecs = array('vp8, vorbis', 'avc1.42E01E, mp4a.40.2', 'theora, vorbis');
		
		echo 	"<a href='/zenoir/index.php/ajax_loader/view/dl_file?fid=$file_id'>".$filename."</a><br/>";
		echo	"<video controls='controls' width='300' height='220'>
					<source src='/zenoir/index.php/ajax_loader/view/dl_file?fid=$file_id' type='video/$file_ext'; codecs='$codecs[$codec_id]'/>
				</video>";
	break;
	
	case 2: //audio - mp3 only
		echo 	"<a href='/zenoir/index.php/ajax_loader/view/dl_file?fid=$file_id'>".$filename."</a><br/>";
		echo 	"<audio controls='controls'>
					<source src='/zenoir/index.php/ajax_loader/view/dl_file?fid=$file_id' type='audio/mpeg'/>
					
				</audio>";
	break;
	
	case 3: //images - set content disposition on a php file to download directly
		echo 	"<a href='/zenoir/index.php/ajax_loader/view/dl_file?fid=$file_id'>".$filename."<br/>";
		echo 	"<img src='/zenoir/index.php/ajax_loader/view/dl_file?fid=$file_id'/>";
	break;

}
?>
<?php if($_SESSION['page'] != ''){ ?>
<p>
<a href="<?php echo $_SESSION['page']; ?>" class="lightbox">
<?php echo form_button($back); ?>
</a>
</p>
<?php } ?>
</div>