<div class="container">
	<div class="col-4 offset-4">
		<h2 class="text-center">Register</h2> 
		<?php
		if($this->session->flashdata('message'))
		{
			echo '<div class="alert alert-success"> '.$this->session->flashdata('message').'</div>';
		}
		?> 
		<form method="post" action="<?php echo base_url(); ?>register/validation"> 
			<div class="form-group">
				<label>First Name</label>
				<input type="text" name="firstName" class="form-control" value="<?php echo set_value('firstName'); ?>" />
				<span class="text-danger"><?php echo form_error('firstName'); ?></span>
			</div>
			<div class="form-group">
				<label>Last Name</label>
				<input type="text" name="lastName" class="form-control" value="<?php echo set_value('lastName'); ?>" />
				<span class="text-danger"><?php echo form_error('lastName'); ?></span>
			</div>
			<div class="form-group">
			<label>Username</label>
				<input type="text" name="username" class="form-control" value="<?php echo set_value('username'); ?>" />
				<span class="text-danger"><?php echo form_error('username'); ?></span>
			</div>
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
				<label>Email Address</label>
				<input type="text" name="email" class="form-control" value="<?php echo set_value('email'); ?>" />
				<span class="text-danger"><?php echo form_error('email'); ?></span>
			</div>
			<div class="form-group">
				<label>Mobile Phone Number</label>
				<input type="text" name="mobile" class="form-control" value="<?php echo set_value('mobile'); ?>" />
				<span class="text-danger"><?php echo form_error('mobile'); ?></span>
			</div>
			
			<div class="form-group">
				<input type="submit" name="register" value="Register" class="btn btn-primary btn-block" />
			</div>
		</form>  
	</div>
</div>