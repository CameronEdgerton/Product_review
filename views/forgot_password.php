<div class="container">
	<div class="col-4 offset-4">
		<h2 class="text-center">Reset Password</h2> 
		<?php
		if($this->session->flashdata('message'))
		{
			echo '<div class="alert alert-success"> '.$this->session->flashdata('message').'</div>';
		}
		?> 
		<form method="post" action="<?php echo base_url(); ?>resetPassword/validation"> 
			<div class="form-group">
				<label>Email Address</label>
				<input type="text" name="email" class="form-control" value="<?php echo set_value('email'); ?>" />
				<span class="text-danger"><?php echo form_error('email'); ?></span>
			</div>			
			<div class="form-group">
				<input type="submit" name="reset" value="Reset Password" class="btn btn-primary btn-block" />
			</div>
		</form>   
	</div>
</div>