<h1><?php echo $CONFIG['software_name']; ?> - Preview</h1>
<center>

		<img style='width: 600px;' id='preview' src='./images/preview.jpg' /><br><br>
		<button onclick='refreshPreview()' id='refresh' class='btn btn-success'>Refresh</button>

</center>

<script>

function refreshPreview(){
	$("#refresh").html("Loading...");
	$.getJSON( "./api/camera.json?action=snapshot", function( json ) {
		console.log(json);
		$('#preview').attr('src', './images/preview.jpg?' + new Date().getTime());
		$("#refresh").html("Refresh");
	 });

}

</script>
            
