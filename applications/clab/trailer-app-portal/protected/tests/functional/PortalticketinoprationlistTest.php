<?php

/**
 * @version 0.2
 * @package gizur
 * @copyright &copy; gizur
 * @author Anil Kumar Singh <anil-singh@essindia.co.in>
 */

/**
 * Unit Test class for Testing the Gizur REST API ( wrapper over 
 * vtiger Portal functional testing )
 * Contains methods which test  
 * Login / authentication, view details of an asset, list category based
 * trouble tickets and create a trouble ticket
 * 
 * Testing method:
 * > phpunit --verbrose PortalTest
 */
require_once 'PHPUnit/Autoload.php';
class PortalticketinoprationlistTest extends PHPUnit_Framework_TestCase
{

    Const GIZURCLOUD_SECRET_KEY  = "9b45e67513cb3377b0b18958c4de55be";
    Const GIZURCLOUD_API_KEY = "GZCLDFC4B35B";
    Const API_VERSION = "0.1";

    protected $credentials = Array(
            'cloud3@gizur.com' => 'rksh2jjf',
    );

    protected $url = "http://gizurtrailerapp-env.elasticbeanstalk.com/api/index.php/api/";
    //protected $url = "http://localhost/gizurcloud/api/index.php/api/";
    
    
   public function testPortalticketinoperationlist(){
        $model = 'HelpDesk';
        $category = 'inoperation';

        echo " Getting Trouble Ticket Inoperation List" . PHP_EOL;        

        $params = array(
                    'Verb'          => 'GET',
                    'Model'	    => $model,
                    'Version'       => self::API_VERSION,
                    'Timestamp'     => date("c"),
                    'KeyID'         => self::GIZURCLOUD_API_KEY,
                    'UniqueSalt'    => uniqid()
        );

        // Sorg arguments
        ksort($params);

        // Generate string for sign
        $string_to_sign = "";
        foreach ($params as $k => $v)
            $string_to_sign .= "{$k}{$v}";

        // Generate signature
        $signature = base64_encode(hash_hmac('SHA256', 
                    $string_to_sign, self::GIZURCLOUD_SECRET_KEY, 1));
        //login using each credentials
        foreach($this->credentials as $username => $password){            
            $rest = new RESTClient();
            $rest->format('json'); 
            $rest->set_header('X_USERNAME', $username);
            $rest->set_header('X_PASSWORD', $password);
            $rest->set_header('X_TIMESTAMP', $params['Timestamp']);
            $rest->set_header('X_UNIQUE_SALT', $params['UniqueSalt']);
            $rest->set_header('X_SIGNATURE', $signature);                   
            $rest->set_header('X_GIZURCLOUD_API_KEY', self::GIZURCLOUD_API_KEY);
            $response = $rest->get($this->url.$model."/$category");
            $response = json_decode($response);
            //check if response is valid
            if (isset($response->success)){
                $this->assertEquals($response->success,true, " Checking validity of response");
            } else {
                $this->assertInstanceOf('stdClass', $response);
            }
            unset($rest);
        } 
    }

}
