$(document).ready(function () {
    /**
     *
     *  Change data in Summary (Right side of Add page ).
     *
     */
    $('#sku').change(function() {
        $('#briefsku').text($(this).val());
    });

    $('#price').change(function() {
        $('#briefprice').text($(this).val());
    });

    $('#name').change(function() {
        $('#briefname').text($(this).val());
    });
  
    /**
     * JQuery
     *
     *  Dynamic Form
     *
     */

    $("#type").change(function(){
        //alert($(this).val());
       $('#briefbadge').text($(this).val());

        switch ($(this).val()) {
            case 'book':
                $( "#pole1" ).empty();
                $('\
                \
                <div id="pole2">\
                \
                \<div class="alert alert-dismissible alert-primary">\
                    <button type="button" class="close" data-dismiss="alert">&times;</button>\
                        <strong>Hint!</strong> Please provide weight in KG\
                </div>\
									   		\
									   		<div class="mb-3">\
									   			<label for="weight">WEIGHT <span class="text-muted"></span></label>\
									   			<input type="number" class="form-control" id="weight" name="weight" placeholder="weight" maxlength="14">\
								                    <div class="invalid-feedback">\
								                        Please enter a valid weight.\
								                    </div>\
									   		</div>\
								   		</div>\
								   		\
								   		\
								   		\
								   		')
                    .fadeIn('slow')
                    .appendTo('#pole1');
reak;
            case 'dvd':

                $( "#pole1" ).empty();

                $('<div id="pole3">\
                \
                \<div class="alert alert-dismissible alert-primary">\
                    <button type="button" class="close" data-dismiss="alert">&times;</button>\
                        <strong>Hint!</strong> Please provide size in MB\
                </div>\
									   		\
								    		<div class="mb-3">\
								    		<label for="size">Size<span class="text-muted"></span></label>\
							                    <input type="number" class="form-control" id="size" name="size" placeholder="Size"  maxlength="14">\
								                    <div class="invalid-feedback">\
								                        Please enter your Size.\
								                    </div>\
								    		</div>\
								     	</div>')
                    .fadeIn('slow')
                    .appendTo('#pole1');


                break;
            case 'furniture':

                $( "#pole1" ).empty();
                $('<div id="pole4">\
                \
                \<div class="alert alert-dismissible alert-primary">\
                    <button type="button" class="close" data-dismiss="alert">&times;</button>\
                        <strong>Hint!</strong> Please provide dimensions HxLxW\
                </div>\
									   		\
								    		<div class="mb-3">\
								                    <label for="height"> Height <span class="text-muted"></span></label>\
								                    <input type="number" class="form-control" id="height" name="height" maxlength="14" placeholder="DIM: H">\
								                </div>\
								                <div class="mb-3">\
								                    <label for="length"> Length <span class="text-muted"></span></label>\
								                    <input type="number" class="form-control" id="length" name="length" maxlength="14" placeholder="DIM: L">\
								                </div>\
								                <div class="mb-3">\
								                    <label for="width"> Width <span class="text-muted"></span></label>\
								                    <input type="number" class="form-control" id="width" name="width" maxlength="14" placeholder="DIM: W">\
								                </div>\
								     	</div>')
                    .fadeIn('slow')
                    .appendTo('#pole1');


                break;
            default:

                $( "#pole1" ).empty();
                break;
        }

    });

    /**
     *  For Delete From DB and index Cards and data
     *
     *
     */

    $("#DelPic").click(function(){

        var picturs = [];
        $('.checkboxes input:checked').each(function() {

            if($(this).is(':checked') == true){
                picturs.push($(this).val());
                var row = $(this).parents('.pic');
                row.remove();
            }

        });

        //alert(picturs);
        //event.preventDefault();

        var serviceURL = 'add/DeletePicturs';

        var datastring = {'picturs': picturs};

        $.ajax({
            type:    "POST",
            data:    datastring,
            url:     serviceURL,
            cache:   false,
            success: function(msg){

            },
            error:   function(msg){
                alert("Error! Please contact Scandi Web HR for punishment");
            }
        });

    });

});