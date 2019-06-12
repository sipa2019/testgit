$(document).ready(function(){

/**
 * 
 * modal confirmations
 * 
 */


 
 
$('#confirm-modal').bind('show', function() {
	var
		removeBtn	= $(this).find('.btn-primary'),
		href		= $(this).data('href'),
        message		= $(this).data('message'),
        parentForm	= $(this).data('parentForm');
        
		if (href != undefined) {
			removeBtn.attr('href', href);
		} else if (parentForm != undefined) {
			removeBtn.click(function(){
				$("#" + parentForm).submit();
				return false;
			});
        }

        $(this).find('.modal-body p').html(message);
});

$('#confirm-modal-button-reverse').bind('show', function() {
    var
        href = $(this).data('href'),
        message = $(this).data('message');

    if (href != undefined) {
        $(this).find('.btn').each(function( ) {
            if (!$( this ).hasClass('btn-primary')){
                $( this ).attr('href', href);
            }
        });
    }

    $(this).find('.modal-body p').html(message);
});

/**
 * modal confirmation for delete buttons
 */

$('.confirm-delete').bind('click', function(e) {

    var href = $(this).attr('href'),
        message = $(this).attr('message');

    if (href != undefined) {
        if ($(this).hasClass('confirm-button-reverse')){
            $('#confirm-modal-button-reverse').data({'href': href, 'message' : message}).modal('show');
        }
        else{

            $('#confirm-modal').data({'href': href, 'message' : message}).modal('show');
        }  
    } else if ($(this).attr('type') == 'submit') {
        // jquery fix for mass actions forms
        if ($(this).prev().val() != '0'
            && $(this).prev().val() != undefined
            && $(document).find('td.checkbox-select input[type=checkbox]:checked').length) {
                $('#confirm-modal').data({'parentForm': $(this).parents('form').attr('id'), 'message' : message}).modal('show');
        }
    }
    
    return false;
});



/* LIST SELECTIONS */
/**
 * select all checkbox functionality
 */

$("#checkbox-select-all").click(function() {
    var checked_status = this.checked,
        total = 0;
    $("td.checkbox-select input[type=checkbox]").each(function(){
        //$(this).attr('checked', $("#checkbox-select-all").is(':checked'));
        this.checked = checked_status;
        if (this.checked) {
            total++;
        }
    });
    
    if (total 
            && $("select.mass-actions-select").val() != 0
            && $("select.mass-actions-select").val() != undefined) {
            
        $("#mass-submit").removeClass('disabled');
    } else {
        $("#mass-submit").addClass('disabled');
    }
});

/**
 *  Check any element
 */
$("#checkbox-select").live('change', function(){
        if (this.checked 
            && $("select.mass-actions-select").val() != 0
            && $("select.mass-actions-select").val() != undefined) {
    
            $("#mass-submit").removeClass('disabled');
        } else if ($("select.mass-actions-select").val() == 0
                    || $("select.mass-actions-select").val() != undefined) {
            var total = $(document).find('td.checkbox-select input[type=checkbox]:checked').length;
            if (!total)
                $("#mass-submit").addClass('disabled');
        }
});

/**
 * mass actions select
 */

$("select.mass-actions-select").change(function(){
    if ($(this).val() != 0 
        && $(this).val() != undefined
        && $(document).find('td.checkbox-select input[type=checkbox]:checked').length) {
        
        $("#mass-submit").removeClass('disabled');
    } else {
        $("#mass-submit").addClass('disabled');
    }
});


//    $(document).scroll(function () {
//        //Appear UP button
//        if ($(this).scrollTop() > 0 && $('.well').html() != undefined) {
//            $("#fixed").show();
//            $("#fixed").html($('.well').html());
//            $("#fixed").addClass('form-actions');
//            $("#fixed").width($('.well').width());
//            $("#fixed").height($('.well').height());
//            
//            //$(".well").hide();
//        } else {
//            $("#fixed").hide();
//            $("#fixed").html('');
//            $("#fixed").removeClass('form-actions');
//            //$(".well").show();
//        }
//    });
// 
	
 


    $(".call-modal").bind('click', function (e) {
        var 
            title = $(this).attr('title'),
            href = $(this).attr('href');
			// from admin-orders has history			
			dataHref =  $(this).attr('rel');

			modalView = '#tableModal';
			// pop-up for filters			
			if ($(this).hasClass('filter-by-products')){
				modalView = '#tableModalFilter';			
			}
	
			if (!dataHref){
				dataHref = '';
			}

        if (href != undefined) {
            var message = '';
            var btn = $(this);
                btn.attr('data-loading-text', 'Loading...');
                btn.button('loading'); 

            
            $.get(href, function (response) {
                message = response;
				
				$(modalView).data({'title': title, 'message' : message, 'btn':btn, 'dataHref':dataHref}).modal('show');
            });
        } 
        
        return false;        
    });
    
    $('#tableModal').bind('show', function() {
        var
            title = $(this).data('title'),
            message = $(this).data('message'),
            btn = $(this).data('btn');
			// add btn - history clients orders


			if ($(this).data('dataHref')){
				hrefHistory = $(this).data('dataHref');				
				$(this).find('.client-history').attr("href", hrefHistory);				
				$('.client-history').show();				
			} else {
				$('.client-history').hide();			
				$(this).find('.client-history').attr("href", "");								
			}

            $(this).find('.modal-header h3').text(title);
            $(this).find('.modal-body p').html(message);
    });    
    
    $("#tableModal").on('shown', function (){
        var btn = $(this).data('btn');

            $(btn).button('reset');
	
    });
	
    $('#tableModalFilter').bind('show', function() {
        var
            title = $(this).data('title'),
            message = $(this).data('message'),
            btn = $(this).data('btn');
			// add btn - history clients orders


			if ($(this).data('dataHref')){
				hrefHistory = $(this).data('dataHref');				
				$(this).find('.products-filter').attr("href", hrefHistory);				
				$('.products-filter').show();				
			} else {
				$('.products-filter').hide();			
				$(this).find('.products-filter').attr("href", "");								
			}

            $(this).find('.modal-header h3').text(title);
            $(this).find('.modal-body p').html(message);
    });    
    
    $("#tableModalFilter").on('shown', function (){
        var btn = $(this).data('btn');
		
            btn.button('reset');
	
    });

	
	

        

    
    $("#templates-languages").live('change', function(){
        location.href = $(this).val();
    });

// map
    $('#CreateMap').click(function(){
		$('#viewMap').hide();	
		$('#errorMap').hide();			
		var locality_id = $('#locality_id').val();
		var street_id = $('#street_id').val();		
		var home = $('#home').val();		
		if (locality_id){
			$.ajax({
				'type': 'post',
				'url': '/ajax/AjaxController.php?action=map',
				'data': {
					'locality_id': locality_id,
					'street_id': street_id,
					'home': home,					
				},	
				'success': function(response){
					var r = JSON.parse(response);
					if (r.success) {	
						$('#viewMap').show();
						var lat = r.lat;
						var lng = r.lng;		
						var formatted_address = r.formatted_address;
						$('#temp_lat').val(lat);	
						$('#temp_lng').val(lng);
						$('#temp_formatted_address').val(formatted_address);	
						$('#SaveMap').show();
						
						initializeMap(lat,lng);						

					} else {
						$('#errorMap').show();					
					}
				},
				'error': function (r){
					$('#errorMap').show();					
				}
			});
		}
		return false;
    });
	
	



	

	
	
	

    $('input.int-field').keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
            // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||
            // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
    });
    
    //$('form.async').ajaxForm();
    
    $('#applyonly-btn').click(function(){
		$('#applyonly').val('1');
		$(this).closest('form').submit();
		return false;
    });
	
    $('#btnDraft').click(function(){
		$('#is_draft').val('1');
		$(this).closest('form').submit();
		return false;
    });
	

    $('form').live('submit', function() {

        var form = $(this);

        if (!form.hasClass('async')) {
            return true;
        }

        var btn = form.find('input[type=submit],a.green-style,button[type=submit]');

        if(btn.length>0){
            setBtnPreload(btn);
        }
        var data = new FormData(form.get(0));
        data.append('submit',1);

        //$.ajax({
        $.ajax({
            type:'post',
            dataType:'json',
            url:form.attr('action'),
            //data:$(form).serialize() + '&submit=1',
            //data:$(form).formSerialize() + '&submit=1',
            data: data,
            mimeType : form.attr('enctype') || 'application/x-www-form-urlencoded',
            contentType: false,
            cache: false,
            processData:false,
            success: function(r){ onFormSubmitSuccess(r, form);},
            error:function(r){

                form.find('.alert-error').html(r.responseText).show();
                unsetBtnPreload();
                $('#applyonly').val('');
            }
        });
        return false;
    });

});

      function initialize(lat,lng) {
        var mapOptions = {
          center: new google.maps.LatLng(lat, lng),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("gmap"),
            mapOptions);
      }
		


function setBtnPreload(btns){
	
	$.each(btns, function(i, btn){
		btn = $(btn);
		btn.addClass('preload');
	    var titleBtn = btn.attr('value');
	    if(!titleBtn){
	    	titleBtn = btn.text();
	    }
	    btn.attr('disabled', true);
	    btn.attr('title', titleBtn);
	    btn.attr('value', ' ');
	    btn.html('&nbsp;');
	});
}
function unsetBtnPreload(){
	var btns = $('.preload');
	$.each(btns, function(i, btn){
		btn = $(btn);
		btn.attr('disabled', false);
		btn.removeClass('preload');
		var titleBtn = btn.attr('title');
	    btn.attr('value', titleBtn);
	    btn.html(titleBtn);
	});
}
function onFormSubmitSuccess(r, form) {
	form.find('.control-group').removeClass('error').find('.help-inline').remove();//old
	form.find('label').removeClass('error');
	form.find('td').removeClass('error');	
	form.find('.info-box').remove();
	//form.find('.error-box').hide();

	unsetBtnPreload();

    if (r.success) {
    	if(r.message && r.noredirect) {
    		form.find('.alert-success').html(r.message).show();

    	} else {

    		var url = r.returnto? r.returnto:location.href;

    		if(r.message){

    			form.find('.alert-success').html(r.message).show();
    			setTimeout(function(){location.href = url;/*location.reload();*/},3500);
    		}else {

    			location.href = url;
				
    		}
    	}
    } else {   

    	if (r.message != undefined) {
    		form.find('.alert-error').html(r.message).show();
    	}
        if (r.errors != undefined) {
            for (var name in r.errors) {

				element = form.find('input[name="'+name+'"],textarea[name="'+name+'"],select[name="'+name+'"],select[name="'+name+'[]"],:checkbox[name="'+name+'[]"]');

                if (element) {
					result = element.parents('.control-group').find('.table-striped');
					
					if (!result.length){
						element.parents('.control-group').addClass('error');
					} else {
						elementLabel = form.find('label[for="'+name+'"]');				
						if (elementLabel) {	
							elementLabel.addClass('error');
						}
						element.parents('td').addClass('error');
					}
					if(!element.data('no-error')){
						for (var msg in r.errors[name]) {
							element.before('<div class="info-box">'+r.errors[name][msg]+'</div>');
							break;
						}
					}
                }

				if ('price'==name){
					$.each(r.errors[name], function(key,elmes){
						elementPrice = form.find('input[name="price['+key+']"]');										
						elementPrice.parents('td').addClass('error');					
						for (var msg in elmes) {
							elementPrice.before('<div class="info-box">'+elmes[msg]+'</div>');
							break;
						}
					});				
					elementLabel = form.find('label[for="'+name+'"]');				
					if (elementLabel) {	
						elementLabel.addClass('error');
					}					
				}

            }
			
			$('html, body').animate({
				scrollTop: $(".page-header").offset().top
			}, 2000);				
			
			
			
			
			
			
        }
        //form.find('.error-box').html(r.message).show();
    }
    $('#applyonly').val('');
    
    
    
    

    
    
    
}