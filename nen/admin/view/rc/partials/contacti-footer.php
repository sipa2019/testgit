<footer class="footer_wrapper" id="contact">
  <div class="container">
    <section class="page_section contact" id="contact">
      <div class="contact_section">
        <h2><?=$main[5]?></h2>
        <div class="row">
          <div class="col-lg-4">
            
          </div>
          <div class="col-lg-4">
           
          </div>
          <div class="col-lg-4">
          
          </div>
        </div>
      </div>
    <div class="row">
        <div class="col-lg-4 wow fadeInLeft">	
			 	<div class="contact_info">
				 		<p class="mb-5">
			               <i class="fa fa-phone ml-2" style="font-size:26px;color:red"></i>
			               <span itemprop="telephone"><strong>+ 371 2 6177207 </strong></span> <br>
			               <i class="fa fa-phone ml-2" style="font-size:26px;color:red"></i>
			               <span itemprop="telephone"><strong>+ 371 2 9116607 (Engl)</strong></span> 
			          	</p>
				 
				 		<p class="mb-5">
				            <i class="fa  fa-envelope-o ml-3" style="font-size:26px"></i>
					            <span itemprop="email">
					            	<a href="mailto:orieco@gmail.com">orieco@gmail.com </a>
					            </span>
							<br>
							
				            <i class="fa  fa-laptop " style="font-size:26px"></i>
				            <span >
			            	www.oriecon.com
			            	</span>
			          	</p>
	        </div>

	    </div>
	    
	    <span id="soob" style="color:#df0031;"></span>
	   
	    <div class="col-lg-8 wow fadeInLeft delay-06s" id="forma_soob">
		          <div class="form" name="contactForm" id="contactForm" role="form" method="POST" action="#">
		          <div class="alert-error pl-3 mb-3" style="display:none;color:#df0031;"></div>
		            <input class="input-text" type="text" id="name" name="name" value="<?=$contacts[1]?>" onFocus="if(this.value==this.defaultValue)this.value='';" onBlur="if(this.value=='')this.value=this.defaultValue;">
		            <input class="input-text" type="text" id="email" name="email" value="<?=$contacts[2]?>" onFocus="if(this.value==this.defaultValue)this.value='';" onBlur="if(this.value=='')this.value=this.defaultValue;">
		            <textarea class="input-text text-area" id="message" name="message" cols="0" rows="0" onFocus="if(this.value==this.defaultValue)this.value='';" onBlur="if(this.value=='')this.value=this.defaultValue;"><?=$contacts[3]?></textarea>
		            <button class="input-btn" type="submit"  id="contactForm1"><?=$contacts[4]?></button>
		          </div>
	    </div>
    </div>
    </section>
    
  </div>
  
  <div class="container">
    <div class="footer_bottom"><span>Copyright © 2019,    <a href="#">Orieco</a>. </span> </div>
  </div>
</footer>
<a href="#" class="scrollup">Наверх</a>