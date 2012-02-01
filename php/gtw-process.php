<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    header('Location:http://google.com');

    $gtwPost = "";
    //Create string for GoToWebinar from same form POST data
    $gtwPost = "WebinarKey=" . urlencode($_GET['WebinarKey'])
      . "&Form=" . urlencode($_GET['Form'])
      . "&Name_First=" . urlencode($_GET['firstName'])
      . "&Name_Last=" . urlencode($_GET['lastName'])
      . "&Email=" . urlencode($_GET['email']);
    //Set POST URL for GoToWebinar
    $gtw_url = "https://www1.gotomeeting.com/en_US/island/webinar/registration.flow";
    //Start GoToWebinar submission
    $curl = @curl_init();
    @curl_setopt($curl, CURLOPT_POSTFIELDS, $gtwPost);
    @curl_setopt($curl, CURLOPT_URL, $gtw_url);
    @curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);    
    @curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    @curl_exec($curl);
    $info = @curl_getinfo($curl);
    @curl_close($curl);
    //End GoToWebinar registrant submission
    
    //START HubSpot Lead Submission
    $strPost = "";
    //create string for HubSpot with form POST data
    $strPost = "FirstName=" . urlencode($_GET['firstName'])
      . "&LastName=" . urlencode($_GET['lastName'])
      . "&Email=" . urlencode($_GET['email'])
      . "&IPAddress=" . urlencode($_SERVER['REMOTE_ADDR'])
      . "&UserToken=" . urlencode($_COOKIE['hubspotutk']);
    //set POST URL for HubSpot
    $hubspot_url = "http://amott.app5.hubspot.com/?app=leaddirector&FormName=new+webinar+process";
    //intialize cURL and send POST data
    $ch = @curl_init();
    @curl_setopt($ch, CURLOPT_POSTFIELDS, $strPost);
    @curl_setopt($ch, CURLOPT_URL, $hubspot_url);
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    @curl_exec($ch);
    @curl_close($ch);
    //END HubSpot Lead Submission
}

?>
                      