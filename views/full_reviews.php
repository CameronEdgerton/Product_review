<div class="container">
	<div class="col">

		<h2 class="text-center">All reviews for <?php echo str_replace("_", " ", $this->uri->segment(4)); ?> 
		in <?php echo str_replace("_", " ", $this->uri->segment(3)); ?></h2> 

		<?php
		if($this->session->flashdata('success'))
		{
			echo '<div class="alert alert-success"> '.$this->session->flashdata('success').'</div>';
		}
		if($this->session->flashdata('error'))
		{
			echo '<div class="alert alert-danger"> '.$this->session->flashdata('error').'</div>';
		}
		if($this->session->flashdata('good'))
						{
							echo '<div class="alert alert-success"> '.$this->session->flashdata('good').'</div>';
						}
		if($this->session->flashdata('bad'))
		{
			echo '<div class="alert alert-danger"> '.$this->session->flashdata('bad').'</div>';
		}
		?> 

		<form method="post" action="<?php echo base_url()."reviews/addtoWishlist/".$this->uri->segment(4)."/".$this->uri->segment(3); ?>">
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">Add to Wishlist</button>
			</div>
		</form>

		<?php echo form_open(base_url().'reviews/show_reviews'); ?>    
		<div class="table-responsive">  
		<?php 
		if(isset($fetch_data))
		{
			if($fetch_data > 0)  
			{  
				foreach($fetch_data as $row)  
				{  
					?>   
					<table class="table table-bordered">  
						<tr>  
							<th>Image</th>
							<th>Flavour</th>
							<th>Portion size</th>
							<th>Crumb quality</th>
							<th>Juiciness</th>
							<th>Chicken-sauce-cheese ratio</th>
							<th>Condiment quality</th>
							<th>Date of review</th>
						</tr> 
					<h3 class="text-center">Review posted by <?php echo $row->username; ?></h2>
						<tr>
							<td><img width="320" height="240" src="<?php echo sprintf("%s/uploads/resized/%s", base_url(), $row->filename); ?>"></td>
							<td><?php echo $row->flavour; ?></td>
							<td><?php echo $row->portion_size; ?></td>
							<td><?php echo $row->crumb_quality; ?></td>
							<td><?php echo $row->juiciness; ?></td>
							<td><?php echo $row->ratio; ?></td>
							<td><?php echo $row->condiment_quality; ?></td>
							<td><?php echo $row->date; ?></td>
						</tr> 
					</table>
					<h4> <?php echo $row->likes; ?> users liked this review</h4>
					<a href="<?php echo base_url().'reviews/likeReview/'.$row->id.'/'.$this->uri->segment(4)."/".$this->uri->segment(3) ;?>">Like this review</a>
					<?php       
				}  
			}  
		} 				
		?>  
		</div> 
	<?php echo form_close(); ?>

	</div>
</div>