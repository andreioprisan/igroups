<?php
class FlowTest
{
    protected $callSid;
    
    /**
     * OpenVBX Plugin Object
     * 
     * @var Plugin
     */
    protected $plugin;
    
    /**
     * Create a new FLowTest object, using the Plugin object.
     * 
     * @param Plugin $plugin
     */
    public function __construct($plugin)
    {
        $this->setPlugin($plugin);
        $this->getCI()->load->helper('form');
        $this->getCI()->load->helper('url');
    }
    
    public function callFlow($flow)
    {
        $twiml = new Response();
        //generate url to the selected flow
        $twiml->addPause();
        $twiml->addRedirect(site_url('twiml/applet/voice/' . $flow .'/start'));
        $this->startClientCall($twiml);
    }
    
    public function callSay($text)
    {
        $twiml = new Response();
        //generate url to the selected flow
        $twiml->addSay($text);
        $twiml->addPause(array('length' => 60*4));
        $twiml->addHangup();
        $this->startClientCall($twiml);
    }
    
    protected function getEchoUrl($twiml)
    {
        //TODO: would be nice to do this without using the twimlet
        return "http://twimlets.com/echo?Twiml=" . $twiml->asURL(true);
    }
    
    protected function attemptRedirect($twiml)
    {
        //make sure there's a current call sid
        if(!$this->getCallSid()){
            return false;
        }
        
        //check if there's an active call
        $response = $this->getTwilio()->request(
        	"Accounts/".$this->getCI()->twilio_sid."/Calls/" . $this->getCallSid(), 
        	"GET");
            
        if($response->IsError){
            return false;
        }
        
        if("in-progress" != $response->ResponseXml->Call->Status){
            return false;
        }
        
        $response = $this->getTwilio()->request(
        	"Accounts/".$this->getCI()->twilio_sid."/Calls/" . $this->getCallSid(), 
        	"POST",
            array("Url" => $this->getEchoUrl($twiml)));
        
        if($response->IsError){
            return false;
        }
        
        if("in-progress" != $response->ResponseXml->Call->Status){
            return false;
        }
        
        return true;
    }
    
    protected function startClientCall($twiml)
    {
        if($this->attemptRedirect($twiml)){
            return;
        }
        
        //start a call to the client
        $response = $this->getTwilio()->request(
        	"Accounts/".$this->getCI()->twilio_sid."/Calls",
            "POST",
             array("Caller" => $this->getClient(),
                   "To" => 	$this->getClient(),
                   "Url" => $this->getEchoUrl($twiml)
             )
        );
        
        if($response->IsError){
            throw new Exception('error starting call');
        }
        
        $this->callSid = (string) $response->ResponseXml->Call->Sid;
    }
    
    public function getClient()
    {
        $client = false;
        foreach(OpenVBX::getCurrentUser()->devices as $device){
            if('client:' == substr($device->value, 0, strlen('client:'))){
                $client = $device->value;
                break;
            }
        }
        
        if(!$client){
            throw new Exception('could not find client');
        }
        
        return $client;
    }
    
    public function getFlows()
    {
        $flows = array();

        foreach(OpenVBX::getFlows() as $flow){
            $flows[$flow->values['id']] = $flow->values['name'];
        }
        
        return $flows;
    }
    
    public function setCallSid($sid)
    {
        $this->callSid = $sid;
    }
    
    public function getCallSid()
    {
        return $this->callSid;
    }
    
    /**
     * Get the plugin info array, or the data of a single key.
     * 
     * @param string $key
     */
    public function getPluginInfo($key)
    {
        $info = $this->getPlugin()->getInfo(); 
        return $info[$key];
    }
    
	/**
	 * Get the plugin object.
	 * 
     * @return Plugin $plugin
     */
    public function getPlugin ()
    {
        return $this->plugin;
    }

	/**
     * Set the plugin object.
     * 
     * @param Plugin $plugin
     */
    public function setPlugin (Plugin $plugin)
    {
        $this->plugin = $plugin;
    }
    
	/**
     * Get the CI superclass. If not set, try to use CI_Base::get_instance()
     * 
     * @return CI_Base $ci
     */
    public function getCI ()
    {
        if(empty($this->ci)){
            $this->setCI(CI_Base::get_instance());
        }
        return $this->ci;
    }

	/**
	 * Set the CI superclass.
	 * 
     * @param CI_Base $ci
     */
    public function setCI (CI_Base $ci)
    {
        $this->ci = $ci;
    }
    
	/**
	 * Get a rest client with the current sid/token. If not set, create one 
	 * using the credientials from the CI superclass.
	 * 
     * @return TwilioRestClient $twilio
     */
    public function getTwilio ()
    {
        if(empty($this->twilio)){
            $this->setTwilio(
                new TwilioRestClient(
                    $this->getCI()->twilio_sid, 
                    $this->getCI()->twilio_token));
        }
        return $this->twilio;
    }

	/**
	 * Set the rest client to use.
	 * 
     * @param TwilioRestClient $twilio
     */
    public function setTwilio ($twilio)
    {
        $this->twilio = $twilio;
    }
}