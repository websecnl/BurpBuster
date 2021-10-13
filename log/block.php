<?php
 
 
// Get the IP address of the visitor so we can work with it later.
$ip = $_SERVER['REMOTE_ADDR'];
 
// This is where we pull the file and location of the htaccess file. If it's in
// the same directory as this php file, just leave it as is.
$htaccess = '.htaccess';
 
// This pulls the current contents of your htaccess file so we can search it later.
$contents = file_get_contents($htaccess, TRUE) 
          OR exit('Unable to open .htaccess');
 
// Lets search the htaccess file to see if there is already a ban in place.
$exists = !stripos($contents, 'deny from ' . $ip . "\n") 
          OR exit('Already banned, nothing to do here.');
 
// Here we just pull some details we can use later.
$date   = date('Y-m-d H:i:s');
$uri    = htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES);
$agent  = htmlspecialchars($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES);
$agent  = str_replace(array("\n", "\r"), '', $agent);
 
// If you would like to be emailed everytime a ban happens, put your email
// INSIDE the quotes below. (e.g. 'my@email.com')
$email = '';
 
// This is where we can whitelist IP's so they can never be banned. Simply remove 
// the //  from the front of one of the example IP addresses below and add the 
// address you wish to whitelist. Make sure that you leave the single quotes (') 
// intact and the comma at the end. Adding a person to the whitelist AFTER they 
// have been banned will NOT remove them. You must open the htaccess file and 
// locate their ban by hand and remove it.
$whitelist = array(
  // '123.123.123.123',
  // '123.123.123.123',
  // '123.123.123.123',
);
 
 
// This section prevents people from being sent to this script by mistake
// via a link, image, or other referer source. If you don't want to check
// the referer, you can remove the following line. Make sure you also
// remove the ending } at the very end of this script.
if (empty($_SERVER['HTTP_REFERER'])) {
 
// This section will write the IP address to the htaccess file and in turn
// ban the address. It will however check the whitelist above to see if
// should be banned.
  if (in_array($ip, $whitelist)) {
 
    // User is in whitelist, print a message and end script.
    echo "Hello user! Because your IP address ({$ip}) is in our whitelist,
    you were not banned for attempting to visit this page. End of line.";
 
  } else {
 
    // User is NOT in whitelist - we need to ban em...
    $ban =  "\n# The IP below was banned on $date for trying to access {$uri}\n";
    $ban .= "# Agent: {$agent}\n";
    $ban .= "Deny from {$ip}\n";
 
    file_put_contents($htaccess, $ban, FILE_APPEND) 
		  OR exit('Cannot append rule to .htaccess');
 
    // Send email if address is specified
    if (!empty($email)) {
      $message = "IP Address: {$ip}\n";
      $message .= "Date/Time: {$date}\n";
      $message .= "User Agent: {$agent}\n";
      $message .= "URL: {$uri}";
 
      mail($email, 'Website Auto Ban: ' . $ip, $message);
    }
 
    // Send 403 header to browser and print HTML page
    header('HTTP/1.1 403 Forbidden', TRUE);
    echo '<html><head><title>Error 403 - Banned</title></head><body>
    <center><h1>Error 403 - Forbidden</h1>Hello user, you have been 
    banned from accessing our site. If you feel this ban was a mistake, 
    please contact the website administrator to have it removed.<br />
    <em>IP Address: '.$ip.'</em></center></body></html>';
 
  }
 
}
