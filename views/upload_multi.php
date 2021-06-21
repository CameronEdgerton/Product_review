<div class="container">
    <div class="col">
	<form action="<?php echo base_url('profile/dragDropUpload/'); ?>" class="dropzone"></form>
	<h2 class="text-center">Profile Pictures</h2>
	<?php 
	if(!empty($files)){ 
		foreach($files as $row){ 
			$filePath = 'uploads/'.$row["file_name"]; 
			$fileMime = mime_content_type($filePath); 
	?> 
		<embed src="<?php echo base_url('uploads/'.$row["file_name"]); ?>" type="<?php echo $fileMime; ?>" width="350px" height="240px" /> 
	<?php 
		} 
	}
	else { 
	?> 
		<p>No file(s) found...</p> 
	<?php } ?>
	
	</div>
</div>

