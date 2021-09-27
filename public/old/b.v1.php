<?php
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

/**
 * Create Records
 * This method is used to create records of a module and print the response.
 * @param moduleAPIName - The API Name of the module to create records in.
 * @throws Exception
 */
function createRecords(string $moduleAPIName)
{
	//API Name of the module to create records
	//$moduleAPIName = "module_api_name";
	//Get instance of RecordOperations Class that takes moduleAPIName as parameter
	$recordOperations = new RecordOperations();
	//Get instance of BodyWrapper Class that will contain the request body
	$bodyWrapper = new BodyWrapper();
	//List of Record instances
	$records = array();
	$recordClass = 'com\zoho\crm\api\record\Record';
	//Get instance of Record Class
	$record1 = new $recordClass();
	/*
	 * Call addFieldValue method that takes two arguments
	 * 1 -> Call Field "." and choose the module from the displayed list and press "." and choose the field name from the displayed list.
	 * 2 -> Value
	 */
	$record1->addFieldValue(Leads::City(), "City");
	$record1->addFieldValue(Leads::LastName(), "FROm PHP");
	$record1->addFieldValue(Leads::FirstName(), "First Name");
	$record1->addFieldValue(Leads::Company(), "KKRNP");
	$record1->addFieldValue(Vendors::VendorName(), "Vendor Name");
	$record1->addFieldValue(Deals::Stage(), new Choice("Clo"));
	$record1->addFieldValue(Deals::DealName(), "deal_name");
	$record1->addFieldValue(Deals::Description(), "deals description");
	$record1->addFieldValue(Deals::ClosingDate(), new \DateTime("2021-06-02"));
	$record1->addFieldValue(Deals::Amount(), 50.7);
	$record1->addFieldValue(Campaigns::CampaignName(), "Campaign_Name");
	$record1->addFieldValue(Solutions::SolutionTitle(), "Solution_Title");
	$record1->addFieldValue(Accounts::AccountName(), "Account_Name");
	$record1->addFieldValue(Cases::CaseOrigin(), new Choice("AutomatedSDK"));
	$record1->addFieldValue(Cases::Status(), new Choice("AutomatedSDK"));
	/*
	 * Call addKeyValue method that takes two arguments
	 * 1 -> A string that is the Field's API Name
	 * 2 -> Value
	 */
	$record1->addKeyValue("Custom_field", "Value");
	$record1->addKeyValue("Date_1", new \DateTime('2021-03-08'));
	$record1->addKeyValue("Date_Time_2", date_create("2020-06-02T11:03:06+05:30")->setTimezone(new \DateTimeZone(date_default_timezone_get())));
	$record1->addKeyValue("Subject", "From PHP");
	$taxes = array();
	$tax = new Tax();
	$tax->setValue("Sales Tax - 20.0 %");
	array_push($taxes, $tax);
	$record1->addKeyValue("Tax", $taxes);
	$record1->addKeyValue("Product_Name", "AutomatedSDK");
	$imageUpload = new ImageUpload();
	$imageUpload->setEncryptedId("ae9c7cefa418aec1d6a5cc2d9ab35c32c868f35aa764283fe160f1ca5d9fc777");
	$record1->addKeyValue("Image_Upload", [$imageUpload]);
	$fileDetails = array();
	$fileDetail1 = new FileDetails();
	$fileDetail1->setFileId("ae9c7cefa418aec1d6a5cc2d9ab35c32dd6c9909d3d45a7d43f4f5997f98fef9");
	array_push($fileDetails, $fileDetail1);
	$fileDetail2 = new FileDetails();
	$fileDetail2->setFileId("ae9c7cefa418aec1d6a5cc2d9ab35c32cf8c21acc735a439b1e84e92ec8454d7");
	array_push($fileDetails, $fileDetail2);
	$fileDetail3 = new FileDetails();
	$fileDetail3->setFileId("ae9c7cefa418aec1d6a5cc2d9ab35c3207c8e1a4448a63b609f1ba7bd4aee6eb");
	array_push($fileDetails, $fileDetail3);
	$record1->addKeyValue("File_Upload", $fileDetails);
	/** Following methods are being used only by Inventory modules */
	$vendorName = new $recordClass();
	$vendorName->addFieldValue(Vendors::id(), "34770617247001");
	$record1->addFieldValue(Purchase_Orders::VendorName(), $vendorName);
	$dealName = new $recordClass();
	$dealName->addFieldValue(Deals::id(), "34770614995070");
	$record1->addFieldValue(Sales_Orders::DealName(), $dealName);
	$contactName = new $recordClass();
	$contactName->addFieldValue(Contacts::id(), "34770614977055");
	$record1->addFieldValue(Purchase_Orders::ContactName(), $contactName);
	$accountName = new $recordClass();
	$accountName->addKeyValue("name", "automatedAccount");
	$record1->addFieldValue(Quotes::AccountName(), $accountName);
	$record1->addKeyValue("Discount", 10.5);
	$inventoryLineItemList = array();
	$inventoryLineItem = new $recordClass();
	$lineItemProduct = new LineItemProduct();
	$lineItemProduct->setId("34770615356009");
	$inventoryLineItem->addKeyValue("Product_Name", $lineItemProduct);
	$inventoryLineItem->addKeyValue("Quantity", 1.5);
	$inventoryLineItem->addKeyValue("Description", "productDescription");
	$inventoryLineItem->addKeyValue("ListPrice", 10.0);
	$inventoryLineItem->addKeyValue("Discount", "5%");
	$productLineTaxes = array();
	$productLineTax = new LineTax();
	$productLineTax->setName("Sales Tax");
	$productLineTax->setPercentage(20.0);
	array_push($productLineTaxes, $productLineTax);
	$inventoryLineItem->addKeyValue("Line_Tax", $productLineTaxes);
	array_push($inventoryLineItemList, $inventoryLineItem);
	$record1->addKeyValue("Quoted_Items", $inventoryLineItemList);
	$record1->addKeyValue("Invoiced_Items", $inventoryLineItemList);
	$record1->addKeyValue("Purchase_Items", $inventoryLineItemList);
	$record1->addKeyValue("Ordered_Items", $inventoryLineItemList);
	$lineTaxes = array();
	$lineTax = new LineTax();
	$lineTax->setName("Sales Tax");
	$lineTax->setPercentage(20.0);
	array_push($lineTaxes,$lineTax);
	$record1->addKeyValue('$line_tax', $lineTaxes);
	/** End Inventory **/
	/** Following methods are being used only by Activity modules */
	// Tasks,Calls,Events
	$record1->addFieldValue(Tasks::Description(), "Test Task");
	$record1->addKeyValue("Currency",new Choice("INR"));
	$remindAt = new RemindAt();
	$remindAt->setAlarm("FREQ=NONE;ACTION=EMAILANDPOPUP;TRIGGER=DATE-TIME:2020-07-03T12:30:00.05:30");
	$record1->addFieldValue(Tasks::RemindAt(), $remindAt);
	$whoId = new $recordClass();
	$whoId->setId("34770614977055");
	$record1->addFieldValue(Tasks::WhoId(), $whoId);
	$record1->addFieldValue(Tasks::Status(),new Choice("Waiting for input"));
	$record1->addFieldValue(Tasks::DueDate(), new \DateTime('2021-03-08'));
	$record1->addFieldValue(Tasks::Priority(),new Choice("High"));
	$record1->addKeyValue('$se_module', "Accounts");
	$whatId = new $recordClass();
	$whatId->setId("34770610207118");
	$record1->addFieldValue(Tasks::WhatId(), $whatId);
	/** Recurring Activity can be provided in any activity module*/
	$recurringActivity = new RecurringActivity();
	$recurringActivity->setRrule("FREQ=DAILY;INTERVAL=10;UNTIL=2020-08-14;DTSTART=2020-07-03");
	$record1->addFieldValue(Events::RecurringActivity(), $recurringActivity);
	// Events
	$record1->addFieldValue(Events::Description(), "Test Events");
	$startdatetime = date_create("2020-06-02T11:03:06+05:30")->setTimezone(new \DateTimeZone(date_default_timezone_get()));
	$record1->addFieldValue(Events::StartDateTime(), $startdatetime);
	$participants = array();
	$participant1 = new Participants();
	$participant1->setParticipant("username@gmail.com");
	$participant1->setType("email");
	$participant1->setId("34770615902017");
	array_push($participants, $participant1);
	$participant2 = new Participants();
	$participant2->addKeyValue("participant", "34770615844006");
	$participant2->addKeyValue("type", "lead");
	array_push($participants, $participant2);
	$record1->addFieldValue(Events::Participants(), $participants);
	$record1->addKeyValue('$send_notification', true);
	$record1->addFieldValue(Events::EventTitle(), "From PHP");
	$enddatetime = date_create("2020-07-02T11:03:06+05:30")->setTimezone(new \DateTimeZone(date_default_timezone_get()));
	$record1->addFieldValue(Events::EndDateTime(), $enddatetime);
	$remindAt = date_create("2020-06-02T11:03:06+05:30")->setTimezone(new \DateTimeZone(date_default_timezone_get()));
	$record1->addFieldValue(Events::RemindAt(), $remindAt);
	$record1->addFieldValue(Events::CheckInStatus(), "PLANNED");
	$remindAt = new RemindAt();
	$remindAt->setAlarm("FREQ=NONE;ACTION=EMAILANDPOPUP;TRIGGER=DATE-TIME:2020-07-23T12:30:00+05:30");
	$record1->addFieldValue(Tasks::RemindAt(), $remindAt);
	$record1->addKeyValue('$se_module', "Leads");
	$whatId = new $recordClass();
	$whatId->setId("34770614381002");
	$record1->addFieldValue(Events::WhatId(), $whatId);
	$record1->addFieldValue(Tasks::WhatId(), $whatId);
	$record1->addFieldValue(Calls::CallType(), new Choice("Outbound"));
	$record1->addFieldValue(Calls::CallStartTime(), date_create("2020-07-02T11:03:06+05:30")->setTimezone(new \DateTimeZone(date_default_timezone_get())));
	/** End Activity **/
	/** Following methods are being used only by Price_Books modules */
	$pricingDetails = array();
	$pricingDetail1 = new PricingDetails();
	$pricingDetail1->setFromRange(1.0);
	$pricingDetail1->setToRange(5.0);
	$pricingDetail1->setDiscount(2.0);
	array_push($pricingDetails, $pricingDetail1);
	$pricingDetail2 = new PricingDetails();
	$pricingDetail2->addKeyValue("from_range", 6.0);
	$pricingDetail2->addKeyValue("to_range", 11.0);
	$pricingDetail2->addKeyValue("discount", 3.0);
	array_push($pricingDetails, $pricingDetail2);
	$record1->addFieldValue(Price_Books::PricingDetails(), $pricingDetails);
	$record1->addKeyValue("Email", "user1223@zoho.com");
	$record1->addFieldValue(Price_Books::Description(), "TEST");
	$record1->addFieldValue(Price_Books::PriceBookName(), "book_name");
	$record1->addFieldValue(Price_Books::PricingModel(), new Choice("Flat"));
	$tagList = array();
	$tag = new Tag();
	$tag->setName("Testtask");
	array_push($tagList, $tag);
	//Set the list to Tags in Record instance
	$record1->setTag($tagList);
	//Add Record instance to the list
	array_push($records, $record1);
	//Set the list to Records in BodyWrapper instance
	$bodyWrapper->setData($records);
	$trigger = array("approval", "workflow", "blueprint");
	$bodyWrapper->setTrigger($trigger);
	//bodyWrapper.setLarId("34770610087515");
	//Call createRecords method that takes BodyWrapper instance as parameter.
	$response = $recordOperations->createRecords($moduleAPIName, $bodyWrapper);
	if($response != null)
	{
		//Get the status code from response
		echo("Status Code: " . $response->getStatusCode() . "\n");
		if($response->isExpected())
		{
			//Get object from response
			$actionHandler = $response->getObject();
			if($actionHandler instanceof ActionWrapper)
			{
				//Get the received ActionWrapper instance
				$actionWrapper = $actionHandler;
				//Get the list of obtained ActionResponse instances
				$actionResponses = $actionWrapper->getData();
				foreach($actionResponses as $actionResponse)
				{
					//Check if the request is successful
					if($actionResponse instanceof SuccessResponse)
					{
						//Get the received SuccessResponse instance
						$successResponse = $actionResponse;
						//Get the Status
						echo("Status: " . $successResponse->getStatus()->getValue() . "\n");
						//Get the Code
						echo("Code: " . $successResponse->getCode()->getValue() . "\n");
						echo("Details: " );
						//Get the details map
						foreach($successResponse->getDetails() as $key => $value)
						{
							//Get each value in the map
							echo($key . " : "); print_r($value); echo("\n");
						}
						//Get the Message
						echo("Message: " . $successResponse->getMessage()->getValue() . "\n");
					}
					//Check if the request returned an exception
					else if($actionResponse instanceof APIException)
					{
						//Get the received APIException instance
						$exception = $actionResponse;
						//Get the Status
						echo("Status: " . $exception->getStatus()->getValue() . "\n");
						//Get the Code
						echo("Code: " . $exception->getCode()->getValue() . "\n");
						echo("Details: " );
						//Get the details map
						foreach($exception->getDetails() as $key => $value)
						{
							//Get each value in the map
							echo($key . " : " . $value . "\n");
						}
						//Get the Message
						echo("Message: " . $exception->getMessage()->getValue() . "\n");
					}
				}
			}
			//Check if the request returned an exception
			else if($actionHandler instanceof APIException)
			{
				//Get the received APIException instance
				$exception = $actionHandler;
				//Get the Status
				echo("Status: " . $exception->getStatus()->getValue() . "\n");
				//Get the Code
				echo("Code: " . $exception->getCode()->getValue() . "\n");
				echo("Details: " );
				//Get the details map
				foreach($exception->getDetails() as $key => $value)
				{
					//Get each value in the map
					echo($key . " : " . $value . "\n");
				}
				//Get the Message
				echo("Message: " . $exception->getMessage()->getValue() . "\n");
			}
		}
		else
		{
			print_r($response);
		}
	}
}