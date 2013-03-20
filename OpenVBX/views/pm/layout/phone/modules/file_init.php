<div id="files_module" style="display: none">
<br>
<script>
$(function () {
//  $("div[rel=twipsy]").twipsy({
//    live: true
//  })
})
//javascript:;
//javascript:;
</script>

<div id="files_container" style="display:none;">
    <div id="filelist" style="display: none">Your browser does not support file upload.</div>
    <br />
    <a id="pickfiles" href="#" class="btn">1. Add Files</a> 
    <a id="uploadfiles" href="#" class="btn primary">2. Upload</a>
</div>
<div id="progressbar"></div>

<script type="text/javascript">

// file upload module
function gbi(id) {
	return document.getElementById(id);	
}

function getFileExtension(filename)
{
  var ext = /^.+\.([^.]+)$/.exec(filename);
  return ext == null ? "" : ext[1];
}

function getFileNameOnly(filename)
{
	ext = getFileExtension(filename);
	return filename.replace('.' + getFileExtension(filename), '');
}


/*
{title : "Image files", extensions : "jpg,gif,png"},
{title : "Zip files", extensions : "zip"},
{title : "AVI files", extensions : "avi"},
{title : "PDF files", extensions : "pdf"}
*/

<?php 
if (!isset($group_id)) {
	$group_id = "0";
} 	
?>
var uploader = new plupload.Uploader({
	runtimes : 'gears,html5,flash,silverlight,browserplus',
	browse_button : 'pickfiles',
	container: 'files_container',
	max_file_size : '1000mb',
	unique_names : true,
//	url : '/upload.php',
	url : '/uploader/upload?user_id=<?= $user_id ?>&group_id=<?php if (!isset($group_id) || $group_id == "") { $group_id = "0"; } echo $group_id; ?>',
	resize : {width : 320, height : 240, quality : 90},
	flash_swf_url : 'https://igrou.ps.dev/asset/js/plupload/plupload.flash.swf',
	silverlight_xap_url : 'https://igrou.ps.dev/asset/js/plupload/plupload.silverlight.xap',
	filters : [
	]
});

uploader.bind('Init', function(up, params) {
	document.getElementById('filelist').innerHTML = "<div>Current runtime: " + params.runtime + "</div>";
});

uploader.bind('FilesAdded', function(up, files) {
	document.getElementById('files_module_table_nofile').style.display = "none";
	
	if (document.getElementById('files_module_table').style.display == "block")
	{ 
		$('#files_module_table_nofile').hide();
	}
	
	if (document.getElementById('files_module_table_nofile').style.display == "block")
	{ 
		$('#files_module_table_nofile').hide();
	}

	if (document.getElementById('files_module_table').style.display == "none") 
	{
		$('#files_module_table').fadeIn('slow');
	}
	
	for (var i in files) {
		document.getElementById('filelist').innerHTML += '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b> (pending) </b></div>';
//		document.getElementById('files_module').getElementsByTagName('tbody').append("<tr><th>" + files[i].name + "</th><td>DOC</td><td>Andrei</td><td>" + plupload.formatSize(files[i].size) + "</td><td>view | del</td></tr>");
//		console.log("file:" + files[i]);
		
		filerow = document.createElement("tr");
		//<tr id>
		var attribute = document.createAttribute("id");
	    attribute.nodeValue = 'file_' + files[i].id;
	    filerow.setAttributeNode(attribute); 
		
		filerow_name = document.createElement("th");
		filerow_name_content = document.createTextNode("" + getFileNameOnly(files[i].name) + "");

		filerow_name_twipsy = document.createElement("div");

		if (getFileNameOnly(files[i].name).length > 22)
		{
			filename_shorter = getFileNameOnly(files[i].name).substring(0,22) + '...';
		} else {
			filename_shorter = getFileNameOnly(files[i].name);	
		}
		
		filerow_name_twipsy_content = document.createTextNode('' + filename_shorter + '');
		filerow_name_twipsy.appendChild(filerow_name_twipsy_content);

	    var attribute = document.createAttribute("data-placement");
	    attribute.nodeValue = "left";
	    filerow_name_twipsy.setAttributeNode(attribute); 
		var attribute = document.createAttribute("rel");
	    attribute.nodeValue = "twipsy";
	    filerow_name_twipsy.setAttributeNode(attribute); 
		var attribute = document.createAttribute("title");
	    attribute.nodeValue = files[i].name;
	    filerow_name_twipsy.setAttributeNode(attribute); 
		filerow_name.appendChild(filerow_name_twipsy);
	
//		filerow_name_content.innerHTML = "<div data-placement='left' rel='twipsy' title='" + getFileNameOnly(files[i].name) + "'>" + getFileNameOnly(files[i].name) + "</div>";

		filerow.appendChild(filerow_name);
		
		filerow_name = document.createElement("td");
		filerow_name_content = document.createTextNode('' + getFileExtension(files[i].name) + '');
		filerow_name.appendChild(filerow_name_content);
		filerow.appendChild(filerow_name);
		
		filerow_name = document.createElement("td");
		filerow_name_content = document.createTextNode('' + plupload.formatSize(files[i].size) + '');
		filerow_name.appendChild(filerow_name_content);
		filerow.appendChild(filerow_name);
		
		filerow_name = document.createElement("td");
		filerow_name_content = document.createTextNode('<?php echo $this->fullname; ?>');
		filerow_name.appendChild(filerow_name_content);
		filerow.appendChild(filerow_name);
		
		filerow_name = document.createElement("td");
		var attribute = document.createAttribute("id");
	    attribute.nodeValue = 'status_' + files[i].id;
	    filerow_name.setAttributeNode(attribute); 
		
//		filerow_name_content = document.createTextNode('view | del');
		filerow_col_placeholder = document.createElement("div");
		var attribute = document.createAttribute("style");
	    attribute.nodeValue = "width: 55px;";
	    filerow_col_placeholder.setAttributeNode(attribute); 
	    
		
//		filerow_name_content = document.createTextNode('pending');
		filerow_name.appendChild(filerow_col_placeholder);
		filerow.appendChild(filerow_name);
		
		document.getElementById('files_module_table').getElementsByTagName('tbody')[0].appendChild(filerow);

		
	}
});

uploader.bind('UploadProgress', function(up, file) {
	document.getElementById('files_module_table_nofile').style.display = "none";
	
	if (file.percent != 100)
	{
		document.getElementById('status_' + file.id).innerHTML = '<div style="width: 55px;"><div class="meter-wrap"><div id="progress_" class="meter-value" style="background-color: #0064CD; width: '+ file.percent + '%;"></div></div></div>';
//		document.getElementById('status_' + file.id).innerHTML = '<span>' + file.percent + "%</span>";
	} else {
		var sha1del =  "user_id=<?= $this->user_id ?>&group_id=<?= $this->group_id ?>&encID="+ file.id +"&encFileName=" + file.target_name + "";
//		console.log(file);
		document.getElementById('status_' + file.id).innerHTML = "<div style='width: 55px;'><div data-placement='left' rel='twipsy' data-original-title='Download File' style='display: inline;'><a href='/uploader/download/" + file.id + "'><img src='/asset/icons/minimalistica_red/16x16/page_full.png'></a></div> <a href='#' onclick=\"fileDelete('"+ file.id +"','" + SHA1(sha1del) + "');  return false;\"><img src='/asset/icons/minimalistica_red/16x16/delete.png' style='display: inline;'></a>";
	}
});

uploader.bind('QueueChanged', function(up) {
	document.getElementById('files_module_table_nofile').style.display = "none";
	
	//alert('Queued files: ' + uploader.files.length);
});

uploader.bind('Error', function(up, err) {
//	console.log(up);
//	console.log(err);
	
    document.getElementById('filelist').append("<div>Error: " + err.code +
        ", Message: " + err.message +
        (err.file ? ", File: " + err.file.name : "") +
        "</div>"
    );

    up.refresh(); // Reposition Flash/Silverlight
});

uploader.bind('FileUploaded', function(up, file) {
//	document.getElementById('status_' + file.id).innerHTML = 'view';
//	document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>completed</span>';
	
//	totalfilescount++;
	
});

document.getElementById('uploadfiles').onclick = function() {
	uploader.start();
	return false;
};

uploader.init();
</script>

	
</div>