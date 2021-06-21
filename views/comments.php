<div class="container">
	<div class="col">

		<h2 class="text-center">All comments for <?php echo str_replace("_", " ", $this->uri->segment(4)); ?> 
		in <?php echo str_replace("_", " ", $this->uri->segment(3)); ?></h2> 

		<?php echo form_open(base_url().'reviews/show_comments/'.$this->uri->segment(3).'/'.$this->uri->segment(4)); ?>    
			<div class="table-responsive">  
			<?php 
			if(isset($comment_data))
			{
				if($comment_data > 0)  
				{  
					foreach($comment_data as $row)  
					{  
						?>   
						<table class="table table-bordered">  
							<tr>  
								<th>Comment</th>
								<th>Posted by</th>
								<th>Date</th>
							</tr> 
							<tr>
								<td><?php echo $row->comment; ?></td>
								<td><?php echo $row->username; ?></td>
								<td><?php echo $row->date; ?></td>
							</tr> 
						</table>
						<?php       
					}  
				}  
			} 				
			?>  
			</div> 
		<?php echo form_close(); ?>

		<form method="post" action="<?php echo base_url().'reviews/addComment/'.$this->uri->segment(3).'/'.$this->uri->segment(4) ;?> ">	
				       
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Leave a comment" required="required" name="comment">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">Post</button>
			</div>
		</form>

	</div>
</div>