<div class="container">
	<div class="col">

		<h2 class="text-center">Wishlist</h2> 
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
		<?php echo form_open(base_url().'wishlist/show_wishlist'); ?>    
		<div class="table-responsive">  
		<?php 
		if(isset($fetch_data))
		{ 
			if($fetch_data > 0)  
			{  
				foreach($fetch_data as $row)  
				{  
					$restaurant = str_replace("_", " ", $row['restaurant']);
					?>   
					<table class="table table-bordered">  
						<tr>  
							<th>Restaurant</th>
							<th>City</th>
							<th>Action</th>
						</tr> 
						<tr>
							<td><?php echo $restaurant; ?></td>
							<td><?php echo $row['city']; ?></td>
							<td><a href=<?php echo base_url().'wishlist/removefromWishlist/'.$row['restaurant'].'/'.$row['city']; ?>>Remove from wishlist</td>
						</tr> 
					</table> 
					<?php       
				}  
			}  
		} 				
		?>  
		</div> 
	<?php echo form_close(); ?>
	</div>
</div>