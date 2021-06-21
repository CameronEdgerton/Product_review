<div class="container">
	<div class="col-4 offset-4">
		<h2 class="text-center">Reset Password</h2> 
		<?php
		if($this->session->flashdata('success'))
		{
			echo '<div class="alert alert-success"> '.$this->session->flashdata('success').'</div>';
		}
		if($this->session->flashdata('error'))
		{
			echo '<div class="alert alert-danger"> '.$this->session->flashdata('error').'</div>';
		}
		?> 
		<form method="post" action="<?php echo base_url(); ?>resetPassword/reset"> 
			<div class="form-group">
				<label>Password</label>
				<input type="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>" />
				<span class="text-danger"><?php echo form_error('password'); ?></span> 
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<input type="password" name="conf_password" class="form-control" value="<?php echo set_value('conf_password'); ?>" />
				<span class="text-danger"><?php echo form_error('conf_password'); ?></span> 
			</div>
			<div class="form-group">
				<input type="submit" name="reset" value="Confirm" class="btn btn-primary btn-block" />
			</div>
		</form>  
	</div>
</div>