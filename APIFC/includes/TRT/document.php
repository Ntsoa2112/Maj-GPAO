<?php

include AB_DB_SSITE."/includes/SOAP/soap_param.php";
switch($_GET['action']){
	case "adddoccument":
		try{
			$filename = $_FILES['file']['name'];
			
			
			if(isset($_FILES['file'])){
				if ($_FILES['file']['size'] == 0 && $_FILES['file']['error'] == 0)
				{
					echo "<script>alert('Aucun fichier seletionner');</script>";
					header('Location: process.php');
				}
			}else{
				echo "<script>alert('Aucun fichier seletionner');</script>";
					header('Location: process.php');
			}
			
				
			$file = file_get_contents($_FILES['file']['tmp_name']); $byteArr = str_split($file); $byteArr = array_map('ord', $byteArr);

			$ap_BatChIdRange = array( 
				'batchId'     =>    $_SESSION['batchID'],
				'idsCount'     =>    1
			); 
			// get nextId Doc
			$info_IdDoc = $soapClient->GetBatchIdsRange($ap_BatChIdRange);
			$id_doc = $info_IdDoc->rangeBegin;

			$ap_param_file = array( 
				'Name'     =>    $filename,
				'Bytes'     =>    $file
			); 

			$ap_param_document = array( 
				'Id'     =>    $id_doc,
				'BatchId'     =>    $_SESSION['batchID'],
				'DocIndex'     =>    0,
				'ProcessingStageType'     =>    200,//import
				'IsProcessed'     =>    true,
				'HasProcessingErrors'     =>    true,
				'HasDocumentErrors'     =>    true,
				'HasWarnings'     =>    true,
				'HasAssemblingErrors'     =>    true,
				'HasAttachments'     =>    true,
				'HasErrors'     =>    true,
				'OwnerId'     =>    0,
				'FileVersion'     =>    1,
				'StageExternalId'     =>    1000,
				'TaskId'     =>    20,
				'UncertainSymbols'     =>    1,
				'VerificationSymbols'     =>    1,
				'TotalSymbols'     =>    1,
				'Priority'     =>    1,
				'ParentId'     =>    0,
				'Flags'     =>    0,
				'HasAttachments'     =>    true
			); 
			$ap_param_doc_import = array( 
				'sessionId'     =>    $_SESSION['sessId'],
				'batchId'     =>    $_SESSION['batchID'],
				//'document'     =>    $info_documents->document,
				'document'     =>    $ap_param_document,
				'excludeFromAutomaticAssembling'     =>   true,
				'previousItemId'     =>   0,
				'file'     =>    $ap_param_file
			); 


			$infodocImport = $soapClient->AddNewDocument($ap_param_doc_import); 
			echo "<script>alert('Document : ".$infodocImport->documentId." ')</script>";
			
			$arr_uploaded = array();
			
			if(isset($_SESSION['uploaded_doc']) && !isset($_SESSION['uploaded_doc'])){
				$_SESSION['uploaded_doc'] = array() ;
			}else{
				
			}
			$_SESSION['uploaded_doc'][] = $infodocImport->documentId;
			header('Location: process.php');
			
		}
		catch (SoapFault $fault) { 
			$error = 1; 
			print_r($fault);
			echo("Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring."--We will now take you back to our home page.'"); 
		} 
		
		break;
	case "getdocument":
			try{
				$ap_param_forbatch_op = array( 
				'sessionId'     =>    $_SESSION['sessId'],
				'batchId'     =>    $_SESSION['batchID']
				); 
				$info_batch_op = $soapClient->GetDocuments  ($ap_param_forbatch_op);
				$_SESSION['list_doc_serv'] = $info_batch_op;
				header('Location: process.php');
			}catch (SoapFault $fault) { 
					$error = 1; 
					print_r($fault);
					echo("Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring."--We will now take you back to our home page.'"); 
			} 
		break;
		
	case "loaddocument":
			try{
				$ap_param_forbatch_op = array( 
				'sessionId'     =>    $_SESSION['sessId'],
				'documentId'     =>    $_GET['id'],
				'batchId'     =>    $_SESSION['batchID']
				); 
				$info_batch_op = $soapClient->GetDocumentResultsList  ($ap_param_forbatch_op);
				$_SESSION['det_doc_serv'] = array();
				$_SESSION['det_doc_serv']['data'] = $info_batch_op;
				$_SESSION['det_doc_serv']['documentId'] = $_GET['id'];
				header('Location: process.php');
			}catch (SoapFault $fault) { 
					$error = 1; 
					print_r($fault);
					echo("Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring."--We will now take you back to our home page.'"); 
			} 
		break;
	case "detdocument":
			try{
				$ap_param_forbatch_op = array( 
				'sessionId'     =>    $_SESSION['sessId'],
				'fileName'     =>    $_GET['url'],
				'documentId'     =>    $_SESSION['det_doc_serv']['documentId'],
				'batchId'     =>    $_SESSION['batchID']
				); 
				$info_batch_op = $soapClient->LoadDocumentResult  ($ap_param_forbatch_op);
				$_SESSION['det_doc_serv_expt'] = $info_batch_op;
				header('Location: process.php');
			}catch (SoapFault $fault) { 
					$error = 1; 
					print_r($fault);
					echo("Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring."--We will now take you back to our home page.'"); 
			} 
		break;
}
