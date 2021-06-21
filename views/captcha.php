<!-- All Captcha functionality (view and controller) is largely adapted from the following link: https://www.codexworld.com/implement-captcha-codeigniter-captcha-helper/-->

<div class="container">
    <div class="col-4 offset-4 text-center"">
        <h4>Submit Captcha Code</h4>
        <p id="captImg"><?php echo $captchaImg; ?></p>
        <button class="btn btn-primary btn-block">Load new Captcha</button>
        <br>
        <form method="post">
            <div class="form-group">
            Enter the code : 
            </div>
            <div class="form-group">
            <input type="text" name="captcha" value=""/>
            </div>
            <?php
				if($this->session->flashdata('message'))
				{
					echo '<div class="alert alert-danger"> '.$this->session->flashdata('message').'</div>';
				}
				?> 
            <div class="form-group">
            <input type="submit" name="submit" value="SUBMIT" class="btn btn-primary btn-block"/>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function(){
    $("button").click(function(){
        $.get('<?php echo base_url().'captcha/refresh'; ?>', function(data){
            $('#captImg').html(data);
        });
    });
});
</script>