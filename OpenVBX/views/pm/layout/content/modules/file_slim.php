<div id="files_module" style="display: block">
<br>
<?php
$style_filetable = "";

//var_dump($group_files);
$group_files = $this->filemanager->get_group_files($group_id, $user_id);

$i = 0;
foreach ($group_files as $file)
{
	$group_files[$i]->size 		= $this->filemanager->format_bytes($file->size);
	$udata 						= $this->igroups_user->get_user_details($file->user_id);
	$group_files[$i]->author 	= $udata->first_name." ".$udata->last_name;
	$group_files[$i]->delete 	= "user_id=".$file->user_id."&group_id=".$file->group_id."&encID=".$file->encID."&encFileName=".$file->encFileName;

	$i++;
}

if (!isset($group_files)) {
	$style_filetable = "display:none;";	
	?>
	<script type="text/javascript">
	var totalfilescount = 0;
	alert("1");
	</script>
	<?php
} else if (count($group_files) == 0) {
	$style_filetable = "display:none;";
	?>
	<script type="text/javascript">
	var totalfilescount = <?= count($group_files) ?>;
	alert("2");
	</script>
	<?php
} else { ?>

<script type="text/javascript">
var counter = 'totalfilescount = <?= count($group_files) ?>;';
var myFucn = new Function(counter);
 myFucn();

</script>

<?php 
}

?>
<table class="condensed-table" id="files_module_table" style="<?= $style_filetable ?>">
	<thead>
		<tr>
			<th>File Name</th>
			<th>type</th>
			<th>size</th>
			<th>author</th>
			<th style="width: 55px">&nbsp;&nbsp;&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php if (isset($group_files)) {
		if (count($group_files) > 0)
		{
			foreach($group_files as $file) 
			{
			?>
		<tr id="file_<?= $file->encID ?>">
			<th><div data-placement="left" rel="twipsy" data-original-title="<?= $file->name ?>"><?php
			$f =  $file->name;
			if (strlen($f) > 22)
			{
				$d = substr($f, 0, 22).'...';
			} else {
				$d = $f;
			}
			echo $d;
			?></div></th>
			<td><?= $file->ext ?></td>
			<td><?php
			echo $file->size; ?></td>
			<td><?= $file->author ?></td>
			<td id="status_<?= $file->encID ?>">
				<div style="width: 55px">
					<div data-placement="left" rel="twipsy" data-original-title="Download File" style="display: inline;">
						<a href="/uploader/download/<?= $file->encID ?>"><img src="/asset/icons/minimalistica_red/16x16/page_full.png"></a>
					</div> <div data-placement="left" rel="twipsy" data-original-title="Permanently Delete File" style="display: inline;">
						<a href="#" onclick="fileDelete('<?= $file->encID ?>','<?= sha1($file->delete) ?>');  return false;"><img src="/asset/icons/minimalistica_red/16x16/delete.png" style="display: inline;"></a>
					</div>
				</div>
			</td>
		</tr>
			<?php
			}
		}
	}
		?>

	</tbody>
</table>
<?php
$style_files_module_table_nofile = "display:none;";
if ($style_filetable == "display:none;")
{
	$style_files_module_table_nofile = "display:block;";
}
?>

<div id="files_module_table_nofile" style="<?= $style_files_module_table_nofile ?>">No files uploaded yet.</div>
<script>
            $(function () {
              $("div[rel=twipsy]").twipsy({
                live: true
              })
            })
//javascript:;
//javascript:;
          </script>

<script type="text/javascript">

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

</script>

	
</div>