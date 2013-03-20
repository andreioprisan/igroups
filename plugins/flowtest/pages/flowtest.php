<?php 
$pluginData = OpenVBX::$currentPlugin->getInfo();
require_once $pluginData['plugin_path'] . '/FlowTest.php';
$flowTest = new flowTest(OpenVBX::$currentPlugin);

$exception = false;

if(isset($_POST['callsid'])){
    $flowTest->setCallSid($_POST['callsid']);
} else if (isset($_GET['callsid'])){
    $flowTest->setCallSid($_GET['callsid']);
}

try{
    //make an incomming request to the client, and redirect the call to the flow
    if(isset($_POST['testflow']) AND array_key_exists($_POST['flow'], $flowTest->getFlows())){
        $flowTest->callFlow($_POST['flow']);
    }

    if(isset($_GET['testflow']) AND array_key_exists($_GET['flow'], $flowTest->getFlows())){
        $flowTest->callFlow($_GET['flow']);
    }

} catch (Exception $exception) {
    
}

?>

<div class="vbx-plugin">
<?php if($exception):?>
	<div class="notify">
		<p class="message">Could not call your Virtual Phone - is it online?<a href class="close action"></a></p>
	</div>
<?php endif;?>
<?php if($flowTest->getCallSid()):?>
	<div class="notify">
		<p class="message">Connected to the Virtual Browser Phone. You can continue to test without hanging up.<a href class="close action"></a></p>
	</div>
<?php endif;?>

<h2 class="" style="display:inline; padding: 20px 0px 10px 0px; line-height: 60px; display:inline;">Flow Test<small> can help you</small></h2>
    <form action="" method="post" style="display:inline">
        <button class="submit-button ui-state-focus btn primary" type="submit" name="testflow" style="padding-left: 10px; top: -3px; left: 3px;right: 8px;">Test Flow</button>
        <?php echo form_dropdown('flow', $flowTest->getFlows(), '', "style='display:inline;'") ?>
        <input type="hidden" name="callsid" value="<?php echo $flowTest->getCallSid()?>">
    </form>

	<h2 class="" style="display:inline; padding: 20px 0px 10px 0px; line-height: 60px"><small> through the Virtual Phone right in your browser</small></h2>

 

</div>