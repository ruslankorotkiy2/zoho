<?php 
	require('../vendor/autoload.php');

	use com\zoho\api\logger\Levels;
	use com\zoho\api\logger\LogBuilder;
	use com\zoho\crm\api\UserSignature;
	use com\zoho\crm\api\dc\USDataCenter;
	use com\zoho\api\authenticator\OAuthBuilder;
	use com\zoho\api\authenticator\store\DBBuilder;
	use com\zoho\crm\api\SDKConfigBuilder;
	
	$logger = (new LogBuilder())
		->level(Levels::INFO)
		->filePath("/Users/user_name/Documents/php_sdk_log.log")
		->build();	
		
	$user = new UserSignature("abc@zoho.com");	
	$environment = USDataCenter::PRODUCTION();
	
	$token = (new OAuthBuilder())
    ->id("1000.30E548XKWH1TNGSG24KSE1L3YUKQTH")
    ->build();

	$tokenstore = (new DBBuilder())
		->host("zoho")
		->databaseName("db")
		->userName("root")
		->password("")
		->portNumber("3306")
		->tableName("tbl")
		->build();
	
	$autoRefreshFields = false;
	$pickListValidation = false;
	$enableSSLVerification = true;
	$connectionTimeout = 2;
	$timeout = 2;
	
	$sdkConfig = (new SDKConfigBuilder())
		->autoRefreshFields($autoRefreshFields)
		->pickListValidation($pickListValidation)
		->sslVerification($enableSSLVerification)
		->connectionTimeout($connectionTimeout)
		->timeout($timeout)
		->build();	
	
	echo '<p>Привет, мир!</p>'; 
?>