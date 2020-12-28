
		<?php

			$obj = new COM ( 'WbemScripting.SWbemLocator');
			
			$WbemServices = $obj->ConnectServer(".");
			$lstAddr			   =	$WbemServices->ExecQuery("SELECT * FROM Win32_NetworkAdapterConfiguration  WHERE IPEnabled=TRUE");


			foreach ( $lstAddr as $wmi_call )
			{
				echo  $wmi_call->MACAddress.'<br/>';
				//return;
			}
		?>



