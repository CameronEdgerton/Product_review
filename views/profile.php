<!-- Load profile and update functionality largely adapted from https://buildasite.info/17-codeigniter-3-create-user-profile-page-and-update-user-profile-data/-->
<div class="container">
    <div class="col-4 offset-4">
	<form method="post" action="<?php echo base_url(); ?>profile/load_profile">	
		<h2 class="text-center">User Profile</h2>
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
			<div class="form-group">
				<label>First Name</label>
				<input type="text" class="form-control"  value="<?= $this->session->userdata('firstName')?>" name="firstName">
				<?= form_error('firstName') ?>
			</div>
			<div class="form-group">
				<label>Last Name</label>
				<input type="text" class="form-control"  value="<?= $this->session->userdata('lastName')?>" name="lastName">
				<?= form_error('lastName') ?>
			</div>
			<div class="form-group">
				<label>Mobile Number</label>
				<input type="text" class="form-control"  value="<?= $this->session->userdata('mobile')?>" name="mobile">
				<?= form_error('mobile') ?>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">Confirm Changes</button>
			</div>
	</form>
	</div>
</div>

