<div class="container">
	<div class="col-4 offset-4">	
	<?php 
	if($this->session->flashdata('error'))
	{
		echo '<div class="alert alert-danger"> '.$this->session->flashdata('error').'</div>';
	}
	?> 
		<h2 class="text-center">Find a parmi</h2>  

		<form method="GET" action="<?php echo site_url('reviews/show_restaurants');?>">   
			<div class="form-group">
				<label>Search for restaurants in your city</label>
				<input type="text" class="form-control" placeholder="E.g. Brisbane" required="required" name="city" id="city">
				
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">Search</button>
			</div>
		</form>		
		<?php 
		if(isset($fetch_data))
		{ ?>
		<div class="table-responsive">  
		<table class="table table-bordered">  
				<tr>  
					<th>Restaurant</th>
					<th>See Reviews</th>
				</tr>  
		<?php
			if($fetch_data > 0)  
			{  
				foreach($fetch_data as $row)  
				{  	?>
					<tr>
						<td><?php echo str_replace('_', ' ', $row->restaurant); ?></td>  
						<td><a href="<?php echo site_url("reviews/show_reviews/".str_replace(' ', '_',$row->city)."/". str_replace(' ', '_', $row->restaurant));?>">Go</a></td>
					</tr> 
					<?php       
					}  
			}  
		} 
		?>  
		</table>  
	</div> 
		
	</div>
	<script type="text/javascript">
        $(document).ready(function(){
            $("#city").autocomplete({
			  source: "<?php echo site_url('reviews/get_city_names/?');?>",
			  
            });
        });
    </script>
