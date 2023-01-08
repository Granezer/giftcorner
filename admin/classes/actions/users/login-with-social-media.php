<?php
require_once 'headers.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

require '../../../vendor/autoload.php';
require_once "../kraken-api/Kraken.php";

if($_SERVER['REQUEST_METHOD']=='POST') {
   
    require_once 'require_files.php';
    $reg_activity = new UserLogs();
    
    try {

        require_once 'client-request.php';

        $_POST = array_merge($_POST, $client_request_json);

        // using SendGrid's PHP Library
        require_once '../../vendor/autoload.php';

        //assign value to variables
        $device_id = isset($_POST['device_id']) 
            ? $reg_activity->formatInput($_POST['device_id']) : '';
        $device_name = isset($_POST['device_name']) 
            ? $reg_activity->formatInput($_POST['device_name']) : '';
        $token_id = isset($_POST['token_id']) 
            ? $reg_activity->formatInput($_POST['token_id']) : 0;

        $transaction_id = isset($_POST['transaction_id']) 
            ? $reg_activity->formatInput($_POST['transaction_id']) : '';
        $email = isset($_POST['email']) 
        	? $reg_activity->formatInput($_POST['email']) : 0;
        
        $fullname = isset($_POST['fullname']) 
            ? $reg_activity->formatInput($_POST['fullname']) : '';
        $registration_type = isset($_POST['registration_type']) 
            ? ucfirst($reg_activity->formatInput($_POST['registration_type'])) : null;
        $profile_image_url = isset($_POST['profile_image_url']) 
            ? $_POST['profile_image_url'] : null;

        $gender = $dob = $ref_code = null;
        $username = "";
        $set_state = 'reg';
        $response = array();

        $get_request = json_encode($_POST);
        
        $reg_activity->setReportType("Registrations");
        $reg_activity->setTransactionId($transaction_id);
        $reg_activity->setUserId(0);
        $reg_activity->setGetRequest($get_request);
        $reg_activity->setState();
        $reg_activity->setUserSessionId(0);
        $reg_activity->createInitialReport(); 

        if (empty($fullname) || empty($email)){
            throw new Exception("Some important values are empty. Please try and rectify");
        }

        if (empty($transaction_id) || empty($device_id) || empty($token_id) || empty($device_name)) {
            throw new Exception("No device configuration IDs. Please contact admin");
        }

        if (!in_array($registration_type, array("Facebook", "Twitter"))) {
            throw new Exception("Invalid registration type");
        }
        
        //Checks if this request has been registered before
        $reg_activity->validateRequest();
        
        $hashed_password = md5($profile_image_url);
        // if (!$reg_activity->checkImageUrl($profile_image_url))
        //     throw new Exception("Invalid profile image url");    
        
        $userReg = new Registration();
        $getHtmlEmail = new PersonalEmail();
        $email_contents = new Library();

        $tablesAndKeys = new TablesAndKeys();
        $emailDetails = $tablesAndKeys->getTableNames();
        if (!is_array($emailDetails)) throw new Exception("Can't access API");

        $apiKey = $emailDetails['sendgrid_api'];
        $fromTitle = $emailDetails['email_title'];

        // verify user email if it exist
        $isEmailExist = $userReg->isEmailExist($email);              
        if($isEmailExist) {
        	$set_state = "login";
        	if ($isEmailExist['registration_type'] != $registration_type)
            	throw new Exception("This email ($email) has already been registered using another platform");

            // log user in
            $userLogin = new Login();
	        $response = $userLogin->loginUsers($email, $hashed_password, $device_id, $device_name, $token_id, $registration_type);

            $state = $reg_activity->checkUserLoginDevice($response['user_id'], $device_id, $device_name, $response['login_id']);

	        if ($state == "no") {

	            $date_time = date('h:i:s A\, l jS \of F Y');

	            $my_name = explode(" ", $response['fullname']);
	            $contents = $email_contents->emailContents("login on second device");

	            $title = $contents['title'];
	            $content = $contents['content'];
	            $sfrom = $contents['from_email'];

	            $title = str_replace("{name}",$my_name[0],$title);
	            $content = str_replace("{date}",$date_time,$content);
	            $content = str_replace("{device}",$device_name,$content);

	            $html_content = $getHtmlEmail->
	                personalEmailContent($title, $content, $response['fullname']);

	            $sto = $response['email'];
	            $from = new SendGrid\Email($fromTitle, $sfrom);
	            $subject = "Security Alert";
	            $to = new SendGrid\Email(strtoupper($fullname), $sto);

	            $content = new SendGrid\Content("text/html", $html_content);
	            $mail = new SendGrid\Mail($from, $subject, $to, $content);
	            // $apiKey = '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';
	            $sg = new \SendGrid($apiKey);
	            $sg->client->mail()->send()->post($mail);
	        }

        } else {

	        // This is the first time user is using this platform
	        $response = $userReg->createNewUser($username, $hashed_password, $email, $fullname, $gender, $dob, $device_id, $device_name, $token_id, $ref_code, $registration_type, $profile_image_url);

	        $code = $userReg->createConfirmationLink($email);

	        $my_name = explode(" ", $fullname);
	        $contents = $email_contents->emailContents("registration");

	        $title = $contents['title'];
	        $content = $contents['content'];
	        $sfrom = $contents['from_email'];

	        $title = str_replace("{name}",$my_name[0],$title);
	        $link = '<a href="http://www.katlogg.com/confirm-email.php?confirm-id=' . $code . '" style=" display:block; text-decoration:none; border:0; text-align:center; font-weight:bold;font-size:18px; font-family: Arial, sans-serif; color: #ffffff; background:#db4c3f" class="button_link">Confirm Email</a>';
	        $content = str_replace("{link}",$link,$content);

	        $html_content = $getHtmlEmail->personalEmailContent($title, $content, $fullname);

	        $sto = $email;
	        $from = new SendGrid\Email($fromTitle, $sfrom);
	        $subject = "Welcome to Katlogg ". $my_name[0];
	        $to = new SendGrid\Email(strtoupper($fullname), $sto);

	        $content = new SendGrid\Content("text/html", $html_content);
	        $mail = new SendGrid\Mail($from, $subject, $to, $content);
	        $sg = new \SendGrid($apiKey);
	        $sg->client->mail()->send()->post($mail);
	    }

        $bucketName = 'katlogg-profile-images';
        $IAM_KEY = 'AKIAIJCHNF4QYZDV3OSA';
        $IAM_SECRET = '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';
        $keyName = md5($response['registration_date'].$response['user_id']).'.jpg';

        // Set Amazon S3 Credentials
        $s3 = S3Client::factory(
            array(
                'credentials' => array(
                    'key' => $IAM_KEY,
                    'secret' => $IAM_SECRET
                ),
                'version' => 'latest',
                'region'  => 'us-east-2'
            )
        );

	    $tempFilePath = "tmpfile";
        if(!file_exists($tempFilePath)) mkdir($tempFilePath);

        $tempFilePath = $tempFilePath . "/" . $keyName;
        if (!file_put_contents($tempFilePath, file_get_contents($profile_image_url))) 
            throw new Exception("Unable to upload profile image");

        // Put on S3 Bucket
        $result = $s3->putObject(
            array(
                'Bucket'=>$bucketName,
                'Key' =>  $keyName,
                'SourceFile' => $tempFilePath,
                'StorageClass' => 'REDUCED_REDUNDANCY'
            )
        );

        //send user's details to updateUser function in user.php for processing
        $profile_image_url = 'https://s3.us-east-2.amazonaws.com/'.$bucketName.'/'.$keyName;
        
        $changeImage = new User();
        $changeImage->updateProfileImage($response['user_id'], $profile_image_url);

        $reg_activity->setReportTypeId($response['login_id']);
        $reg_activity->setUserId($response['user_id']);
        $reg_activity->setUserSessionId($response['user_ses_id']);
        $reg_activity->setState($set_state);
        $reg_activity->createSuccessReport();
        
        $response['profile_image_url'] = $profile_image_url;
        echo json_encode(array("message" => "success", "success" => true, "data"=>$response), JSON_PRETTY_PRINT);
         
    } catch(Exception $error) {
        $reg_activity->setDescription($error->getMessage());
        $reg_activity->createErrorReport();
        echo json_encode(array('message' => $error->getMessage(), 'success' => false));
    }
}