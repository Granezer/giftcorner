<?php

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);

set_time_limit(500);

require '../../../vendor/autoload.php';

// if($_SERVER['REQUEST_METHOD']=='POST') {
   
    require_once 'require_files.php';
    date_default_timezone_set("Africa/Lagos");
    
    try {

        $backupDB = new General\Backup();
        
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
        $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

        $database = '';
        $db_name = "katlogg";
        if (isset($_GET['tables'])) {
            $database = $backupDB->backupDB($_GET['tables']);
            $db_name = $_GET['tables']; 
        } else $database = $backupDB->backupDB('*', $limit, $offset);

        $bucketName = 'katlogg-sql';
        $IAM_KEY = 'AKIAIJCHNF4QYZDV3OSA';
        $IAM_SECRET = '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';

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

        //save file
        $keyName= 'db-backup-'.$db_name.'-'. date("F j, Y, g-i-s a").'.sql';
        $tempFilePath = $tempFilePath . "/" . $keyName;
        $handle = fopen($tempFilePath,'w+');
        fwrite($handle,$database);
        fclose($handle);

        // Put on S3 Bucket
        $result = $s3->putObject(
            array(
                'Bucket'=>$bucketName,
                'Key' =>  $keyName,
                'SourceFile' => $tempFilePath,
                'StorageClass' => 'REDUCED_REDUNDANCY'
            )
        );
        
        //save image path
        // $response = $backup->insertBackup($keyName, date("Y-m-d H:i:s"));
        // if ($response) {
        //     $result = $backup->deleteBackup();
        //     if (!empty($result)) {
        //         // Delete an object from the bucket.
        //         $s3->deleteObject([
        //             'Bucket' => $bucketName,
        //             'Key'    => $keyName
        //         ]);
        //         gc_collect_cycles();
        //         unlink($tempFilePath);
        //     }
        //     echo json_encode(array("Operation was successful"));
        //     exit;
        // } else throw new Exception("Backup failed to save");
        echo json_encode(array("Operation was successful"));
         
    } catch(Exception $error) {
        echo json_encode(array('error' => $error->getMessage()));
    } catch(S3Exception  $error) {
        echo json_encode(array('error' => $error->getMessage()));
    }

// }