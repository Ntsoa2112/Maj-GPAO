

<?php
include "config/configuration.php";
//include "includes/DB/cnx.php";
//include "includes/SOAP/soap_param.php";
//unset($_SESSION);session_destroy();exit;
if(isset($_GET['action'])){
	switch($_GET['action']){
		case "loadsession":
		case "closesession":
			include "includes/TRT/session.php";
		break;
		case "loadproject":
		case "closeproject":
			include "includes/TRT/projet.php";
		break;
		case "openbatch":
		case "getbatch":
		case "closebatch":
			include "includes/TRT/batch.php";
		break;
		case "adddoccument":
		case "loaddocument":
		case "getdocument":
		case "detdocument":
			include "includes/TRT/document.php";
		break;
		case "process":
			include "includes/TRT/process_scan.php";
		break;

		default:
			
		break;
	}
}
include "includes/TRT/projet.php";
$idSession = 0;
$idProject = 0;
$idBatch = 0;
$isOpBatch = false;
$idProcess = 0;
$cssSession = "isDisConnected";
$cssProject = "isDisConnected";
$cssBatch = "isDisConnected";
$cssProcess = "isDisConnected";
$cssProcessWarn = "isWarnig";
//print_r($_SESSION['projects']);exit;
$requeiredProcess = "";
if(isset($_SESSION['sessId']) && !empty($_SESSION['sessId']))
{
	$idSession = $_SESSION['sessId'];
	$cssSession = "isConnected";
}else {
	$requeiredProcess = "Doit etre connecter";
}

if(isset($_SESSION['projectID']) && !empty($_SESSION['projectID']))
{
	$idProject = $_SESSION['projectID'];
	$cssProject = "isConnected";
	
}else{
	$requeiredProcess = "Projet doit etre ouvert";
}
if(isset($_SESSION['batchID']) && !empty($_SESSION['batchID']))
{
	$idBatch = $_SESSION['batchID'];
	$cssBatch = "isConnected";
	if(isset($_SESSION['batchIDOp'])  && !empty($_SESSION['batchIDOp'])){
		$isOpBatch = $_SESSION['batchIDOp'];
		if($_SESSION['batchIDOp'])
		{
			//$requeiredProcess = "Batch droit etre fermer";
		}else{
			
			$cssBatch = "isWarnig";
		}
	}else{
		$cssBatch = "isWarnig";
	}
	
}else{
	
}
if(isset($_SESSION['list_doc_serv']))
{
	//print_r($_SESSION['list_doc_serv']);
}
if(isset($_SESSION['isProcess']))
{
	$idProcess = 1;
	$cssProcess = "isConnected";
}

//mysqli_close($con);
?>


<style>
	table,th,td {
		border : 1px solid;
	}
	.isConnected {
		background-color : green;
	}
	.isDisConnected {
		background-color : red;
	}.isWarnig {
		background-color : yellow;
	}
</style>

<html>
	<head>
	</head>
	<body>
		<h1>TEST </h1>
		
		<table style="">
			<thead>
				<tr>
					<th>Process</th>
					<th>params</th>
					<th>action</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Reuperation de la session</td>
					<td class="<?php echo $cssSession; ?>"><?php if($idSession==0){ echo "Déconnécté"; }else{ echo "SessionId: ".$idSession;}?></td>
					<td><?php if($idSession==0){ ?><button onclick="loadSession()">Ouvrir session</button><?php }else{ ?><button onclick="closeSession()">Fermé session</button><?php } ?></td>
				</tr>
				
				<tr>
					<td>Chargement du Projet</td>
					<td class="<?php echo $cssProject; ?>"><?php if($idProject==0){ echo "Projet Non ouvert"; }else{ echo "ProjetId: ".$idProject;}?>
						<ul>
					<?php
						$project_list = array();
						if(isset($_SESSION['projects']))
						{
							$project_list = $_SESSION['projects']->projects->Project;
						}
						foreach($project_list as $key => $project)
						{
					?>
						<li><a href="process.php?action=loadproject&Guid=<?php echo $project->Guid; ?>"> <?php echo $project->Name; ?>(<?php echo $project->Id; ?>) </a></li>
						
						<?php } ?>
					</ul>
					</td>
					<td><?php if($idProject==0){ ?><button onclick="loadProject()">Ouvrir projet</button><?php }else{ ?><button onclick="closeProject()">Fermé projet</button><?php } ?>

					
					</td>


				</td>
				</tr>
				
				<tr>
					<td>Recuperation des batch</td>
					<td></td>
					<td><button onclick="getbatch()">GetBatch</button></td>
				</tr>
				
				<tr>
					<td>Ouverture du batch</td>
					<td class="<?php echo $cssBatch; ?>"><?php if($idBatch==0){ if($isOpBatch && $idBatch!=0){ echo "Batch Fermé: ".$idBatch;} else { echo "Batch Non ouvert"; }}else{ echo "Batch ouvert: ".$idBatch;}?>
					<ul>
					<?php
						$batch_list = array();
						if(isset($_SESSION['batch_list']))
						{
							$batch_list = $_SESSION['batch_list']->batches->Batch;
						}
						foreach($batch_list as $key => $batch)
						{
					?>
						<li><a href="process.php?action=openbatch&id=<?php echo $batch->Id; ?>"> <?php echo $batch->Name; ?>(<?php echo $batch->Id; ?>) Count = <?php echo $batch->DocumentsCount; ?></a></li>
						
						<?php } ?>
					</ul>
					</td>
					
					
					<td><?php 
							if($idBatch==0 || $isOpBatch==false){ 
						?>
								<button onclick="loadBatch()">Ouvrir batch</button>
						<?php }else{ ?>
							<button onclick="closeBatch()">Fermé batch</button>
						<?php } ?></td>
				</tr>
				
				<tr>
					<form action="process.php?action=adddoccument" method="POST"  enctype="multipart/form-data">
					<td>Ajouter un document</td>
					<td><input type="file" name="file"/></td>
					<td><input type="submit" value="telecharger le fichier"/></td>
					</form>
				</tr>
				
				<tr>
					<td>Lancer le PROCESS DE Scan</td>
					<?php if($requeiredProcess =="") { ?>
					<td class="<?php echo $cssProcess; ?>"><?php if($idProcess==0){ echo "Traitement Non lancé"; }else{ echo " Traitement en cours ";}?></td>
					<td><?php if($idProcess==0){ ?><button onclick="process()">PROCESS</button><?php } else{ ?><button onclick="process()">RE-PROCESS</button><?php } ?><button onclick="verif()">VERIF</button><button onclick="exporter()">EXPORT</button></td>
					<?php } else { ?>
					<td class="<?php echo $cssProcessWarn; ?>"><?php echo $requeiredProcess ?></td>
						<td></td>
					<?php } ?>
				</tr>
				
				<tr>
					<td>Reuperation de la liste des documents sur serveur</td>
					<td></td>
					<td><button onclick="getdocument()">GetDocuments</button></td>
				</tr>
			</tbody>
		</table>
		
		<?php
		if(isset($_SESSION['det_doc_serv']))
		{
		?>
		<table style="">
			<thead>
				<tr>
					<th colspan="2">Detail</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Id</td>
					<td><?php echo $_SESSION['det_doc_serv']['documentId'];?></td>
				</tr>
				<tr>
					<td>FileName</td>
					<?php if(!empty($_SESSION['det_doc_serv']['data']->fileNames)) {

							$list_files = $_SESSION['det_doc_serv']['data']->fileNames->string;

						?>
					<td>
						<ul>
							<?php
								if(!empty($list_files) && $list_files!=null && count($list_files)>0)
								{
									foreach($list_files as $key => $file)
									{
										?>
										<li><a href="process.php?action=detdocument&url=<?php echo $file;?>"><?php print_r($file);?></a></li>
										<?php
									}
								}
							?>
						</ul>
						

					</td>
					<?php } else { ?>
					<td></td>
					<?php } ?>
				</tr>
			</tbody>
		</table>
		<?php } ?>
		
		<?php
		if(isset($_SESSION['det_doc_serv_expt']))
		{


			$data = $_SESSION['det_doc_serv_expt']->file->Bytes;

			$files_fr = file_put_contents('exhport.xls', $data);//foury

			print_r($files_fr);
		?>
		<table style="">
			<thead>
				<tr>
					<th colspan="2">File</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Name</td>
					<td><?php echo $_SESSION['det_doc_serv_expt']->file->Name;?></td>
				</tr>
				<tr>
					<td>Bytes</td>
					<?php if(!empty($_SESSION['det_doc_serv_expt']->file->Bytes)) {?>
					<td><?php echo $_SESSION['det_doc_serv_expt']->file->Bytes;?></a></td>
					<?php } else { ?>
					<td></td>
					<?php } ?>
				</tr>
			</tbody>
		</table>
		<?php } ?>
		<table style="">
			<thead>
				<tr>
					<th>Id</th>
					<th>ProcessingStageType</th>
					<th>TemplateName</th>
					<th>Pages</th>
					<th>Error</th>
					<th>IsProcessed</th>
					<th>TaskId</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$list_doc_serv = array();
				if(isset($_SESSION['list_doc_serv']))
				{
					$list_doc_serv = $_SESSION['list_doc_serv']->documents->Document;
				}
				foreach($list_doc_serv as $key => $doc)
				{
			?>
				<tr>
					<td><a href="process.php?action=loaddocument&id=<?php echo $doc->Id;?>"><?php echo $doc->Id;?></a> </td>
					<td><?php echo $doc->ProcessingStageType;?> </td>
					<td><?php echo $doc->TemplateName;?> </td>
					<td> 
						<?php
							if(isset($doc->Pages) && !empty($doc->Pages) && !empty($doc->Pages->Page))
							{
						?>
						<ul>
							<?php
								foreach($doc->Pages->Page as $key => $page)
								{
									print_r($page);
							?>
							
							<?php } ?>
						</ul>
						
						<?php } ?>
					</td>
					<td><?php echo $doc->ErrorText;?> </td>
					<td><?php echo $doc->IsProcessed;?> </td>
					<td><?php echo $doc->TaskId;?> </td>
					
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		
	</body>
</html>
<script>
	function loadSession(){
		window.location.href = "process.php?action=loadsession";
	}
	function closeSession(){
		window.location.href = "process.php?action=closesession";
	}
	function loadProject(){
		window.location.href = "process.php?action=loadproject";
	}
	function closeProject(){
		window.location.href = "process.php?action=closeproject";
	}
	
	function loadBatch(){
		window.location.href = "process.php?action=openbatch";
	}
	function closeBatch(){
		window.location.href = "process.php?action=closebatch";
	}
	
	function process(){
		window.location.href = "process.php?action=process";
	}

	function verif(){
		window.location.href = "process.php?action=process";
	}

	function exporter(){
		window.location.href = "process.php?action=process";
	}
	function getdocument(){
		window.location.href = "process.php?action=getdocument";
	}
	
	function getbatch(){
		window.location.href = "process.php?action=getbatch";
	}
</script>
