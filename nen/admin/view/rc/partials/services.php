
<section  id="service">
  <div class="container">
    <h2>Услуги в переработке резины </h2>
    <div class="service_wrapper">
    
	    <div class="row">
<?php	    
	    	  for ($i = 2; $i <= 4; $i++) {
?>
	    
				    <div class="col-lg-4">
				            <div class="service_block">
					            <div class="feature-wrap">
					                            <div class=" delay-03s animated wow zoomIn">
					                             	<span>
					                             	Изменить картинку
												      	<input id="MAX_FILE_SIZE" type="hidden" value="16777216" name="MAX_FILE_SIZE">
														<input id="image<?=$i?>" type="file" name="image<?=$i?>">
													   <br>
						                            	<i class="fa <?=$records[$i]->image?> fa-5x"></i>
					                             	</span>
					                            </div>
														
									            			<div class="controls">
									            				<textarea id="except<?=$i?>" class=""  style="width:100%;"  name="except<?=$i?>" aria-hidden="true"><?=$records[$i]->except?></textarea>										
									            			</div>
									            			
	            										<label for="content<?=$i?>" class="control-label"><?=$translate->translate('Описание')?></label>
									            			<div class="controls">
																<textarea id="content<?=$i?>" class=""  style="width:100%;"  rows="3" name="content<?=$i?>" aria-hidden="true"><?=$records[$i]->content?></textarea>										
									            			</div>
					            	
					            </div>
				            </div>
			        </div>
        
 <?php
}
 ?>       
			        
      </div> <!-- row 1 -->
      
	   <div class="row borderTop">
	<?php	    
	    	  for ($i = 5; $i <= 7; $i++) {
?>   
        			<div class="col-lg-4 mrgTop">
          					<div class="service_block">
            					    <div class="feature-wrap">
					                            <div class=" delay-03s animated wow zoomIn">
					                             	<span>
					                             		<i class="fa <?=$records[$i]->image?>"></i>
					                               </span>
					        					</div>
					        					
														<label for="content<?=$i?>" class="control-label"><?=$translate->translate('Изменить картинку')?></label>
									            			<div class="controls">
									            				<textarea id="except<?=$i?>" class=""  style="width:100%;"  name="except<?=$i?>" aria-hidden="true"><?=$records[$i]->except?></textarea>										
									            			</div>
									            			
	            										<label for="content3" class="control-label"><?=$translate->translate('Описание')?></label>
									            			<div class="controls">
																<textarea id="content<?=$i?>" class=""  style="width:100%;"  rows="3" name="content<?=$i?>" aria-hidden="true"><?=$records[$i]->content?></textarea>										
									            			</div>

					          
          							</div>
        					</div>
       				</div> 
        
<?php
}
 ?>		        
      </div> <!-- row 2 -->
      
    </div>
  </div>   

</section>

