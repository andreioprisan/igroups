<?php

//require 'libraries/facebook.php';
/*
$fql = "SELECT uid, name, pic_square, email FROM user WHERE uid = me()
OR uid IN (SELECT uid2 FROM friend WHERE uid1 = me()) ";
 
$response = $facebook->api(array(
'method' => 'fql.query',
'query' =>$fql,
));

*/

$loginUrl   = $facebook->getLoginUrl(
            array(
                'scope'         => 'email,offline_access,publish_stream,user_about_me',
                'redirect_uri'  => "http://igrou.ps.dev/facebook_auth/login"
            )
    );
 
$logoutUrl  = $facebook->getLogoutUrl(array(
	'next'	=>	'http://igrou.ps.dev/facebook_auth/logout',
	'session_key'	=>	session_id()
));
$user       = $facebook->getUser();
$user_profile	= null;

if ($user) {
	try {
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api("/$user");
	} catch (FacebookApiException $e) {
        echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
        exit;
	}
	
} else {
	if (isset($_GET['code']) || !$user) {
			usleep(10);
	        echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
	        exit;
	    }
}

if (isset($_SESSION['fb_242774152447632_user_id']) && session_id() != NULL)
{
	$query = $instance->db->insert('sessions', array(
		'fb_uid' => $_SESSION['fb_242774152447632_user_id'], 
		'session_id' => session_id(),
		'user_agent' => $_SERVER['HTTP_USER_AGENT'], 
		'http_cookie' => $_SERVER['HTTP_COOKIE'], 
		'ip' => $_SERVER['REMOTE_ADDR'],
		'timestamp'	=> time())
	);	
	
	
}

if ($user_profile)
	var_dump($user_profile);

?>
<?php if (!$user) { ?>
       You've to login using FB Login Button to see api calling result.
       <a href="<?=$loginUrl?>">Facebook Login</a>
   <?php } else { ?>
       <a href="<?=$logoutUrl?>">Facebook Logout</a> <a href="http://igrou.ps.dev/facebook_test/logout">logout</a>
   <?php } ?>

<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>

    <div id="fb-root"></div>




	<script type="text/javascript">
	
	            window.fbAsyncInit = function() {
	                FB.init({appId: '242774152447632', status: true, cookie: true, xfbml: true});

	                FB.Event.subscribe('auth.login', function(response) {
	                    // do something with response
						console.log("response: ", response);
	                    login();
	                });
	                FB.Event.subscribe('auth.logout', function(response) {
	                    // do something with response
	                    logout();
	                });

	                FB.getLoginStatus(function(response) {
	                    if (response.session) {
	                        // logged in and connected user, someone you know
	                        login();
	                    }
	                });
	            };
	            (function() {
	                var e = document.createElement('script');
	                e.type = 'text/javascript';
	                e.src = document.location.protocol +
	                    '//connect.facebook.net/en_US/all.js';
	                e.async = true;
	                document.getElementById('fb-root').appendChild(e);
	            }());

	            function login(){
	                FB.api('/me', function(response) {
	                    document.getElementById('login').style.display = "block";
	                    document.getElementById('login').innerHTML = response.name + " succsessfully logged in!";
	                });
	            }
	            function logout(){
	                document.getElementById('login').style.display = "none";
	            }

	            //stream publish method
	            function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){
	                FB.ui(
	                {
	                    method: 'stream.publish',
	                    message: '',
	                    attachment: {
	                        name: name,
	                        caption: '',
	                        description: (description),
	                        href: hrefLink
	                    },
	                    action_links: [
	                        { text: hrefTitle, href: hrefLink }
	                    ],
	                    user_prompt_message: userPrompt
	                },
	                function(response) {

	                });

	            }
	            function showStream(){
	                FB.api('/me', function(response) {
	                    //console.log(response.id);
	                    streamPublish(response.name, 'group collaboration, redefined.', 'igrou.ps', 'http://igrou.ps', "Share igrou.ps");
	                });
	            }

				function share2(){
	                var share = {
	                    method: 'stream.publish',
	                    target_id: '3228881',
						message: 'testing posting on users friends walls',
	                };

	                FB.ui(share, function(response) { console.log(response); });
	            }
	
	            function share(){
	                var share = {
	                    method: 'stream.share',
	                    u: 'http://igrou.ps/'
	                };

	                FB.ui(share, function(response) { console.log(response); });
	            }

	            function graphStreamPublish(){
	                var body = 'group collaboration, redefined. igrou.ps';
	                FB.api('/me/feed', 'post', { message: body }, function(response) {
	                    if (!response || response.error) {
	                        alert('Error occured');
	                    } else {
	                        alert('Post ID: ' + response.id);
	                    }
	                });
	            }

				function graphStreamPublish2(){
	                var body = 'group collaboration, redefined. igrou.ps';
	                FB.api('/me/feed', 'post', { message: body }, function(response) {
	                    if (!response || response.error) {
	                        alert('Error occured');
	                    } else {
	                        alert('Post ID: ' + response.id);
	                    }
	                });
	            }
	
	            function fqlQuery(){
	                FB.api('/me', function(response) {
	                     var query = FB.Data.query('select name, sex, pic_square from user where uid={0}', response.id);
	                     query.wait(function(rows) {

	                       document.getElementById('name').innerHTML =
	                         'Your name: ' + rows[0].name + "<br />" +
	                         '<img src="' + rows[0].pic_square + '" alt="" />' + "<br />";
	                     });
	                });
	            }

	            function setStatus(){
	                status1 = document.getElementById('status').value;
	                FB.api(
	                  {
	                    method: 'status.set',
	                    status: status1
	                  },
	                  function(response) {
	                    if (response == 0){
	                        alert('Your facebook status not updated. Give Status Update Permission.');
	                    }
	                    else{
	                        alert('Your facebook status updated');
	                    }
	                  }
	                );
	            }
	  
	
	      </script>
	
			<h3>New Graph api & Javascript Base FBConnect Tutorial | Thinkdiff.net</h3>
			        <p><fb:login-button autologoutlink="true" perms="email,user_birthday,status_update,publish_stream,user_about_me"></fb:login-button></p>

			        <p>
			            <a href="#" onclick="showStream(); return false;">Publish Wall Post</a> |
			            <a href="#" onclick="share(); return false;">Share With Your Friends</a> |
			            <a href="#" onclick="graphStreamPublish(); return false;">Publish Stream Using Graph API</a> |
			            <a href="#" onclick="fqlQuery(); return false;">FQL Query Example</a>
			        </p>

			        <textarea id="status" cols="50" rows="5">Write your status here and click 'Status Set Using Legacy Api Call'</textarea>
			        <br />
			        <a href="#" onclick="setStatus(); return false;">Status Set Using Legacy Api Call</a>

			        <br /><br /><br />
			        <div id="login" style ="display:none"></div>
			        <div id="name"></div>


  </body>
</html>
