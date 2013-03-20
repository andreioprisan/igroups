function fileDelete(id, v)
{
	$.get("/uploader/delete?id=" + id + "&v=" + v + "", function(data) {
		if (data == '1')
		{
			fid = "#file_" + id + "";
			fid2 = "file_" + id + "";
			
			$(fid).fadeOut('slow');
			document.getElementById(""+fid2).setAttribute('class','remove')
			$("#"+fid2).remove();
			$(".remove").remove();

			if(countChildElements('files_module_table','tr') <= 1)
			{
				$('#files_module_table').hide();
				$('#files_module_table_nofile').fadeIn('slow');
			}
		}
	});
}

