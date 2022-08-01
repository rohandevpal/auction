<script src='assets/js/9556cd6744b0b19628598270bd385082cda6a269.js'></script>
<script src='assets/js/ba78fede76f682cd388ed2abbfd1e1568e76f8a4.js'></script>
<script src='assets/js/ff7d5d77cd410b14515c741086c083555816f641.js.js'></script>
<!-- <script src='assets/js/setting-data.js'></script> -->
<!-- Alertify -->
<script type="text/javascript" src="assets/js/alertify.min.js"></script>
<!-- Ck Editor -->
<script src="plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
if ($('#editor').length) {
    CKEDITOR.replace('editor');
}
if ($('#editor2').length) {
    CKEDITOR.replace('editor2');
}
if ($('#editor3').length) {
    CKEDITOR.replace('editor3');
}

</script>
<script type="text/javascript">
	$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<script type="text/javascript">
	//delete row...
$('.delete-row').on('click', function(){
	var id = $(this).data('this-id');
	if(confirm("Do you want to delete this row?")){
		window.location = "?delete-row="+id;
		return true;
	}else{
		return false;
	}
});

//change status..
$('.change-status').on('change', function(){
	var id = $(this).data('this-id'),
	    status =0;

	if($(this).prop('checked')==true){
		status = 2;
	}else{
		status = 1;
	}

	//alert(id+ 'status: '+status);
	$.ajax({
		type: 'post',
		url : '',
		data: {id : id, status: status},
		success: function(response){
			console.log(response);
			//alert(id);
			alertify.message("Changes saved.", 3000);
			//alert(status);

		},
		error: function(response){
			console.log(response);
			alertify.message("Something went wrong, Please try again.", 3000);
		}
	});
});
</script>
<?php echo toast(1);?>