<?php echo form_open_multipart('upload/do_upload');?> 
<div class="row justify-content-center">
    <div class="col-md-4 col-md-offset-6 centered">
    <h2 class="text-center">Post a Review</h2>
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
            <label>Restaurant name</label>
            <input type="text" name="restaurant" class="form-control" value="<?php echo set_value('restaurant'); ?>" />
            <span class="text-danger"><?php echo form_error('restaurant'); ?></span>
        </div>
        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" class="form-control" value="<?php echo set_value('city'); ?>" />
            <span class="text-danger"><?php echo form_error('city'); ?></span>
        </div>
        <div class="form-group">
            <label>Flavour rating (1-5)</label>
            <input type="text" name="flavour" class="form-control" value="<?php echo set_value('flavour'); ?>" />
            <span class="text-danger"><?php echo form_error('flavour'); ?></span>
        </div>
        <div class="form-group">
            <label>Portion size rating (1-5)</label>
            <input type="text" name="portion_size" class="form-control" value="<?php echo set_value('portion_size'); ?>" />
            <span class="text-danger"><?php echo form_error('portion_size'); ?></span>
        </div>
        <div class="form-group">
            <label>Crumb quality rating (1-5)</label>
            <input type="text" name="crumb_quality" class="form-control" value="<?php echo set_value('crumb_quality'); ?>" />
            <span class="text-danger"><?php echo form_error('crumb_quality'); ?></span>
        </div>
        <div class="form-group">
            <label>Juiciness rating (1-5)</label>
            <input type="text" name="juiciness" class="form-control" value="<?php echo set_value('juiciness'); ?>" />
            <span class="text-danger"><?php echo form_error('juiciness'); ?></span>
        </div>
        <div class="form-group">
            <label>Chicken-sauce-cheese ratio rating (1-5)</label>
            <input type="text" name="ratio" class="form-control" value="<?php echo set_value('ratio'); ?>" />
            <span class="text-danger"><?php echo form_error('ratio'); ?></span>
        </div>
        <div class="form-group">
            <label>Condiment quality rating (1-5)</label>
            <input type="text" name="condiment_quality" class="form-control" value="<?php echo set_value('condiment_quality'); ?>" />
            <span class="text-danger"><?php echo form_error('condiment_quality'); ?></span>
        </div>
		<div class="form-group">
            <input type="file" name="userfile" size="20" /> 
        </div>
		<div class="form-group">
            <input type="submit" value="Upload Review" />
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<h3></h3>
<div class="main"> </div>
