
<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Categories</th>

        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
	
	<?php 
	$fees = $model->confFees;
	if($fees ){
		foreach($fees as $fee){
			echo '<tr>
        <td>'.$fee->fee_name .'</td>
        <td>'.$fee->fee_currency .' '.$fee->fee_amount .'</td>
      </tr>';
		}
		
	}
	
	
	?>
      
    </tbody>
  </table>
</div>



<div class="item-blog-txt p-t-33">
	<h4 class="p-b-11">
		<a href="blog-detail.html" class="m-text24">
			Payment Information
		</a>
	</h4>

	

	<p class="p-b-12">
		</p>
		
		<?=$model->payment_info?>
		
	
</div>