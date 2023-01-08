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

        //assign value to variables
        $user_id = isset($_POST['user_id']) 
            ? $reg_activity->formatInput($_POST['user_id']) : '';
        $user_ses_id = isset($_POST['user_ses_id']) 
            ? $reg_activity->formatInput($_POST['user_ses_id']) : '';
        $transaction_id = isset($_POST['transaction_id']) 
            ? $reg_activity->formatInput($_POST['transaction_id']) : '';
        //$base=$_REQUEST['image'];
        $profile_image = isset($_POST['profile_image']) 
            ? $_POST["profile_image"]:null;

        $get_request = implode(', ', array_map(
            function ($v, $k) { return sprintf("%s=>'%s'", $k, $v); },
            $_POST,
            array_keys($_POST)
        ));

        $reg_activity->setReportType("Changed Profile Image");
        $reg_activity->setTransactionId($transaction_id);
        $reg_activity->setUserId($user_id);
        $reg_activity->setGetRequest($get_request);
        $reg_activity->setState();
        $reg_activity->setUserSessionId($user_ses_id);
        $reg_activity->createInitialReport(); 

        if (empty($profile_image)){
            throw new Exception("Error: No profile image uploaded");
        }

        if (empty($transaction_id)){
            throw new Exception("No device configuration IDs. Please contact admin");
        }

        if (empty($user_id) || empty($user_ses_id)){
            throw new Exception("Some important values are empty. Please try and rectify");
        }

        $bucketName = 'katlogg-profile-images';

        $IAM_KEY = 'AKIAIJCHNF4QYZDV3OSA';
        $IAM_SECRET = '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';

        $changeImage = new User();
        $userDetails = $changeImage->getUserByUserId($user_id);
        $keyName = md5($userDetails['registration_date'].$user_id).'.jpg';

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

        //Checks if this request has been registered before
        $reg_activity->validateRequest();
  
        //Checks if the User exist as well as if the user is ban
        $reg_activity->validateUser();

        //Check if Session ID provided Matches with User ID
        $reg_activity->checkUser();

        $tempFilePath = "tmpfile";
        $tempFilePath2 = "tmpfile";
        if(!file_exists($tempFilePath))
        {
            mkdir($tempFilePath);
        }

        $tempFilePath = $tempFilePath . "/" . $keyName;

        if (!file_put_contents(
            $tempFilePath,
            base64_decode($profile_image)
            )
        ) {
            throw new Exception("Unable to upload profile image");
        }

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
        $response = $changeImage->updateProfileImage($user_id, $profile_image_url);

        $reg_activity->setReportTypeId($user_id);
        $reg_activity->createSuccessReport();

        $kraken = new Kraken("6e623c2f61cef066ab025851852c1ff1", "c385e48263be6127a3a53663594c2b838b63556b");
        $params = array (
            "url" => $profile_image_url,
            "wait" => true,
            "lossy" => true,
            "s3_store" => array(
                "key" => $IAM_KEY,
                "secret" => $IAM_SECRET,
                "bucket" => $bucketName
            )
        );
        $data = $kraken->url($params);

        // array_map('unlink', glob("$tempFilePath2/*.*"));
        // rmdir($tempFilePath2);
        gc_collect_cycles();
        unlink($tempFilePath);

        echo json_encode($response, JSON_PRETTY_PRINT);
        
    } catch(Exception $error) {
        $reg_activity->setDescription($error->getMessage());
        $reg_activity->createErrorReport();
        echo json_encode(array('message' => $error->getMessage(), 'success' => false));
    } catch(S3Exception  $error) {
        $reg_activity->setDescription($error->getMessage());
        $reg_activity->createErrorReport();
        echo json_encode(array('message' => $error->getMessage(), 'success' => false));
    }

}