<html>
        <head>
                <title>Parmme</title>
                <link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap.css'?>">
                <link rel="stylesheet" href="<?php echo base_url().'assets/css/jquery-ui.css'?>">
                <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/js/dropzone-5.7.0/dist/dropzone.css'?>">
                <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.js" type="text/javascript"></script>
                <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js" type="text/javascript"></script>
                <script src="<?php echo base_url(); ?>assets/js/bootstrap.js" type="text/javascript"></script>
                <script src="<?php echo base_url(); ?>assets/js/jquery-ui.js" type="text/javascript"></script>
                <script src="<?php echo base_url(); ?>assets/js/underscore-umd.js" type="text/javascript"></script>
                <script src="<?php echo base_url(); ?>assets/js/dropzone-5.7.0/dist/dropzone.js" type="text/javascript"></script>
        </head>
        <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Parmme - Australia's #1 Chicken Parmigiana Review Site!</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>login"> Home </a>
        </li>
    </ul>
    <ul class="navbar-nav my-lg-0">
    <?php if(!$this->session->userdata('logged_in') && !get_cookie('logged_in')) : ?> <!-- Check that there is no logged in session data and no stored cookie showing logged in status-->
        <li class="nav-item">
            <a href="<?php echo base_url(); ?>login"> Login </a>
        </li>
        <?php endif; ?>
        <?php if($this->session->userdata('logged_in') or get_cookie('logged_in')) : ?> <!-- Check that there is logged in session data or stored cookie showing logged in status-->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>login/logout"> Logout </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>profile"> User Profile </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>upload"> Post a Review </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>wishlist"> Wishlist </a>
            </li>
        <?php endif; ?>
    </ul>

    </div> 
</nav>

<script type="text/javascript">
    // Auto-logout
    $(document).ready(function(){
        // sourced from https://stackoverflow.com/questions/572938/force-logout-users-if-users-are-inactive-for-a-certain-period-of-time
        // uses underscore js library. Debounce postpones execution of the function until after the time has elapsed.
        $('div').on("click mousemove keyup", _.debounce(function(){
            window.location = "<?php echo base_url('login/logout') ?>";
        }, 1200000));
    });
</script>