<?php
namespace com\zoho\crm\sample\initializer;
use com\zoho\api\authenticator\OAuthBuilder;
use com\zoho\api\authenticator\store\DBBuilder;
use com\zoho\api\authenticator\store\FileStore;
use com\zoho\crm\api\InitializeBuilder;
use com\zoho\crm\api\UserSignature;
use com\zoho\crm\api\dc\USDataCenter;
use com\zoho\api\logger\LogBuilder;
use com\zoho\api\logger\Levels;
use com\zoho\crm\api\SDKConfigBuilder;
use com\zoho\crm\api\ProxyBuilder;

namespace com\zoho\crm\sample\record;
use com\zoho\crm\api\HeaderMap;
use com\zoho\crm\api\ParameterMap;
use com\zoho\crm\api\layouts\Layout;
use com\zoho\crm\api\record\APIException;
use com\zoho\crm\api\record\ActionWrapper;
use com\zoho\crm\api\record\BodyWrapper;
use com\zoho\crm\api\record\ConvertActionWrapper;
use com\zoho\crm\api\record\ConvertBodyWrapper;
use com\zoho\crm\api\record\DeletedRecordsWrapper;
use com\zoho\crm\api\record\FileBodyWrapper;
use com\zoho\crm\api\record\FileDetails;
use com\zoho\crm\api\record\LeadConverter;
use com\zoho\crm\api\record\LineItemProduct;
use com\zoho\crm\api\record\LineTax;
use com\zoho\crm\api\record\MassUpdate;
use com\zoho\crm\api\record\MassUpdateActionWrapper;
use com\zoho\crm\api\record\MassUpdateBodyWrapper;
use com\zoho\crm\api\record\MassUpdateResponseWrapper;
use com\zoho\crm\api\record\MassUpdateSuccessResponse;
use com\zoho\crm\api\record\Participants;
use com\zoho\crm\api\record\PricingDetails;
use com\zoho\crm\api\record\RecordOperations;
use com\zoho\crm\api\record\RecurringActivity;
use com\zoho\crm\api\record\RemindAt;
use com\zoho\crm\api\record\ResponseWrapper;
use com\zoho\crm\api\record\SuccessResponse;
use com\zoho\crm\api\record\SuccessfulConvert;
use com\zoho\crm\api\tags\Tag;
use com\zoho\crm\api\record\DeleteRecordParam;
use com\zoho\crm\api\record\DeleteRecordsParam;
use com\zoho\crm\api\record\GetDeletedRecordsHeader;
use com\zoho\crm\api\record\GetDeletedRecordsParam;
use com\zoho\crm\api\record\GetMassUpdateStatusParam;
use com\zoho\crm\api\record\GetRecordHeader;
use com\zoho\crm\api\record\GetRecordParam;
use com\zoho\crm\api\record\GetRecordsHeader;
use com\zoho\crm\api\record\GetRecordsParam;
use com\zoho\crm\api\record\SearchRecordsParam;
use com\zoho\crm\api\record\{Cases, Field, Solutions, Accounts, Campaigns, Calls, Leads, Tasks, Deals, Sales_Orders, Contacts, Quotes, Events, Price_Books, Purchase_Orders, Vendors};
use com\zoho\crm\api\util\Choice;
use com\zoho\crm\api\util\StreamWrapper;
use com\zoho\crm\api\record\Territory;
use com\zoho\crm\api\record\Comment;
use com\zoho\crm\api\record\Consent;
use com\zoho\crm\api\attachments\Attachment;
use com\zoho\crm\api\record\CarryOverTags;
use com\zoho\crm\api\record\ImageUpload;
use com\zoho\crm\api\record\Tax;
use com\zoho\crm\api\users\User;

  function initialize()
  {
    /*
      * Create an instance of Logger Class that requires the following
      * level -> Level of the log messages to be logged. Can be configured by typing Levels "::" and choose any level from the list displayed.
      * filePath -> Absolute file path, where messages need to be logged.
    */
    $logger = (new LogBuilder())
    ->level(Levels::INFO)
    ->filePath("/Users/user_name/Documents/php_sdk_log.log")
    ->build();

    //Create an UserSignature instance that takes user Email as parameter
    $user = new UserSignature("ruslan@zoho.com");

    /*
      * Configure the environment
      * which is of the pattern Domain::Environment
      * Available Domains: USDataCenter, EUDataCenter, INDataCenter, CNDataCenter, AUDataCenter
      * Available Environments: PRODUCTION(), DEVELOPER(), SANDBOX()
    */
    $environment = USDataCenter::PRODUCTION();

    /*
    * Create a Token instance
    * clientId -> OAuth client id.
    * clientSecret -> OAuth client secret.
    * grantToken -> GRANT token.
    * redirectURL -> OAuth redirect URL.
    */
    //Create a Token instance
    $token = (new OAuthBuilder())
    ->clientId("1000.AW2DOD5SYKF2MC13SSPS3M5IXA3YDZ")
    ->clientSecret("7ecb945ff2bd1891cc74f5d2ee16af9ae4fa7339ea")
    ->grantToken("1000.2d09924268cc626c461558c964461975.78a154977f90abb8e1ef346e514d562b")
    ->redirectURL("http:\\zoho")
    ->build();

    /*
     * TokenStore can be any of the following
     * DB Persistence - Create an instance of DBStore
     * File Persistence - Create an instance of FileStore
     * Custom Persistence - Create an instance of CustomStore
    */

    /*
    * Create an instance of DBStore.
    * host -> DataBase host name. Default value 
    * databaseName -> DataBase name. Default  value 
    * userName -> DataBase user name. Default value 
    * password -> DataBase password. Default value 
    * portNumber -> DataBase port number. Default value
    */
    //$tokenstore = (new DBBuilder())->build();

    $tokenstore = (new DBBuilder())
    ->host("zoho")
    ->databaseName("db")
    ->userName("root")
    ->password("")
    ->portNumber("3306")
    ->tableName("tbl")
    ->build();

    // $tokenstore = new FileStore("absolute_file_path");

    // $tokenstore = new CustomStore();

    $autoRefreshFields = false;

    $pickListValidation = false;

    $connectionTimeout = 2;//The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.

    $timeout = 2;//The maximum number of seconds to allow cURL functions to execute.

    $enableSSLVerification = false;

    $sdkConfig = (new SDKConfigBuilder())->autoRefreshFields($autoRefreshFields)->pickListValidation($pickListValidation)->sslVerification($enableSSLVerification)->connectionTimeout($connectionTimeout)->timeout($timeout)->build();

    $resourcePath = "/Users/user_name/Documents/phpsdk-application";

    //Create an instance of RequestProxy
	/*
    $requestProxy = (new ProxyBuilder())
    ->host("proxyHost")
    ->port("proxyPort")
    ->user("proxyUser")
    ->password("password")
    ->build();
	*/
    /*
      * Set the following in InitializeBuilder
      * user -> UserSignature instance
      * environment -> Environment instance
      * token -> Token instance
      * store -> TokenStore instance
      * SDKConfig -> SDKConfig instance
      * resourcePath -> resourcePath - A String
      * logger -> Log instance (optional)
      * requestProxy -> RequestProxy instance (optional)
    */
    (new InitializeBuilder())
    ->user($user)
    ->environment($environment)
    ->token($token)
    ->store($tokenstore)
    ->SDKConfig($sdkConfig)
    ->resourcePath($resourcePath)
    ->logger($logger)
    //->requestProxy($requestProxy)
    ->initialize();
  }
  
  $recordClass = 'com\zoho\crm\api\record\Record';
  //$record1 = new $recordClass();
?>