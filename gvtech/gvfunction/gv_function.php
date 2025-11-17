<?
	//Session changes
	if(!function_exists('GVPopToPageSession'))
	{
		function GVPopToPageSession()
		{
			session_start();
			$_SESSION["gvid"] = $_SESSION['page_gvid'];
			$_SESSION['page_gvid'] = "";
		}
	}
	
	if(!function_exists('GVPageSessionChange'))
	{
		function GVPageSessionChange($_GVSesssionStr)
		{
			session_start();
			$_SESSION["gvid"] = $_GVSesssionStr;
		}
	}
	
	if(!function_exists('GVPrevPageSessionClear'))
	{
		function GVPrevPageSessionClear()
		{
			session_start();
			$_SESSION['page_gvid'] = "";
		}
	}
	
	//key Generate function
	if(!function_exists('GVgenerateCrc32KEY'))
	{
		function GVgenerateCrc32KEY($strKey)
		{
			return strtoupper(hash("crc32",$strKey));
		}
	}
	
	if(!function_exists('GVgenerateRandomKEY'))
	{
		function GVgenerateRandomKEY()
		{
			$KeyNOW = date("YmdHisa");
			$GVkey = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"),0,10).rand(1,999999).$KeyNOW;
			return strtoupper(hash("sha1",$GVkey));
		}
	}
	
	if(!function_exists('GVgenerateKEY'))
	{
		function GVgenerateKEY($strKey)
		{
			return strtoupper(hash("sha1",$strKey));
		}
	}
	
	if(!function_exists('GVgetRandom'))
	{
		function GVgetRandom()
		{
			$GVrandom = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"),0,6);
			return strtoupper($GVrandom);
		}
	}
	
	if(!function_exists('GVgenerateStringKEY'))
	{
		function GVgenerateStringKEY($_GVstrSalt, $_GVstrHasKey)
		{
			$_GVstrSalt = GVStringFormat($_GVstrSalt);
			$_GVstrHasKey = GVStringFormat($_GVstrHasKey);
			$_GVkey = "GV@2020PJRB";
			
			$_GVstrSalt_tmp = substr($_GVstrSalt, 0, 2);
			$_GVstrHasKey_tmp = substr($_GVstrHasKey, 2, 2);
			
			$_GVorginalSalt = $_GVstrSalt_tmp.$_GVstrHasKey.$_GVstrHasKey_tmp.$_GVkey;
			
			return strtoupper(hash("sha1",$_GVorginalSalt));
		}
	}
	
	//Encrption and Decreption
	if(!function_exists('GVstringEncrption'))
	{
		function GVstringEncrption($strEncrypt)
		{
			$strDecrpt = "";
			
			$_GVkey = "DD9A7F3E99C0E6C191B909EB9AE88796826E6A02";
			
			$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
			$iv = openssl_random_pseudo_bytes($ivlen);
			$ciphertext_raw = openssl_encrypt($strEncrypt, $cipher, $_GVkey, $options=OPENSSL_RAW_DATA, $iv);
			$hmac = hash_hmac('sha256', $ciphertext_raw, $_GVkey, $as_binary=true);
			$strDecrpt = base64_encode( $iv.$hmac.$ciphertext_raw);
			$strDecrpt = bin2hex($strDecrpt);
			
			return $strDecrpt;
		}
	}
	
	if(!function_exists('GVstringDecrption'))
	{
		function GVstringDecrption($strDecrpt)
		{
			$strEncrypt = "";
			
			$_GVkey = "DD9A7F3E99C0E6C191B909EB9AE88796826E6A02"; //gvinfotech
			
			$strDecrpt = hex2bin($strDecrpt);
			$strDecrpt = base64_decode($strDecrpt);
			$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
			
			$iv = substr($strDecrpt, 0, $ivlen);
			$hmac = substr($strDecrpt, $ivlen, $sha2len=32);
			
			$ciphertext_raw = substr($strDecrpt, $ivlen+$sha2len);
			$original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $_GVkey, $options=OPENSSL_RAW_DATA, $iv);
			$calcmac = hash_hmac('sha256', $ciphertext_raw, $_GVkey, $as_binary=true);
			if (hash_equals($hmac, $calcmac))
			{
				$strEncrypt = $original_plaintext;
			}
			
			return $strEncrypt;
		}
	}
	
	if(!function_exists('GVqueryString'))
	{
		function GVqueryString($queryStr)
		{
			return "&gvid=".GVstringEncrption($queryStr);
		}
	}
	
	if(!function_exists('GVqueryStringData'))
	{
		function GVqueryStringData()
		{
			$qryStr = GVstringDecrption($GLOBALS["gvid"]);
			
			$tokenKey = strtok($qryStr, "&");
			
			while ($tokenKey !== false)
			{
				$qryStrArr = explode("=", $tokenKey); 
				$GLOBALS[$qryStrArr[0]] = $qryStrArr[1];
				$tokenKey = strtok("&");
			}
		}
	}
	
	if(!function_exists('GVHiddenString'))
	{
		function GVHiddenString($queryStr)
		{
			$GLOBALS["gvhd"] = GVstringEncrption($queryStr);
			
			return GVHiddenInput("gvhd","gvhd","");
		}
	}
	
	if(!function_exists('GVHiddenStringData'))
	{
		function GVHiddenStringData()
		{
			$qryStr = GVstringDecrption($GLOBALS["gvhd"]);
			
			$tokenKey = strtok($qryStr, "&");
			
			while ($tokenKey !== false)
			{
				$qryStrArr = explode("=", $tokenKey); 
				$GLOBALS[$qryStrArr[0]] = $qryStrArr[1];
				$tokenKey = strtok("&");
			}
		}
	}
	
	//Formatting Function
	if(!function_exists('GV_Divide'))
	{
		function GV_Divide($numerator, $denominator)
		{
			if($numerator > 0 && $denominator > 0)
				return $numerator / $denominator;
			else
				return 0;
		}
	}
	
	if(!function_exists('GVformatAmount'))
	{
		function GVformatAmount($amtVal)
		{
			if($amtVal != "")
				$amtVal = round($amtVal,2);
			else
				$amtVal = "0.00";
				
			return sprintf("%.2F",$amtVal);
		}
	}
	
	if(!function_exists('GVisNumeric'))
	{
		function GVisNumeric($amtVal)
		{
			if(is_numeric($amtVal))
				return true;
			else
				return false;
		}
	}
	
	if(!function_exists('GVcheckDate'))
	{
		function GVcheckDate($dateVal)
		{
			$dateArr = explode("-",$dateVal);
			
			return checkdate($dateArr[1],$dateArr[0],$dateArr[2]);
		}
	}
	
	if(!function_exists('GVfixedInputText'))
	{
		function GVfixedInputText($strValue)
		{
			return GVStringFormat($strValue);
		}
	}
	
	if(!function_exists('GVSetDateFormat'))
	{
		function GVSetDateFormat($strValue)
		{
			date_default_timezone_set($strValue);
		}
	}
	
	if(!function_exists('GVGetDBCurrentDateTime'))
	{
		function GVGetDBCurrentDateTime()
		{
			return date("Y-m-d H:i:s",strtotime("now"));
		}
	}
	
	if(!function_exists('GVGetCurrentDateTime'))
	{
		function GVGetCurrentDateTime()
		{
			return date("Y-m-d h:i:sa",strtotime("now"));
		}
	}
	
	if(!function_exists('GVGetCurrentDate'))
	{
		function GVGetCurrentDate()
		{
			return date("d-m-Y",strtotime("now"));
		}
	}
	
	if(!function_exists('GVGetDateDBformat'))
	{
		function GVGetDateDBformat($strDate)
		{
			$strDate = date_create($strDate);
			return date_format($strDate, "Y-m-d");
		}
	}
	
	if(!function_exists('GVGetUserDateformat'))
	{
		function GVGetUserDateformat($strDate)
		{
			$strDate = date_create($strDate);
			return date_format($strDate, "d-m-Y");
		}
	}
	
	if(!function_exists('GVGetUserDateTimeformat'))
	{
		function GVGetUserDateTimeformat($strDate)
		{
			$dt = DateTime::createFromFormat('Y-m-d H:i:s', $strDate);
			return $dt->format("d-m-Y  h:i A"); 
		}
	}
	
	if(!function_exists('GVCurrecyFormat'))
	{
		function GVCurrecyFormat($strAmt, $removeCurrencyInd=0)
		{
			$formatter = new \NumberFormatter($locale = 'en_IN', NumberFormatter::DECIMAL_ALWAYS_SHOWN);
    			
    			if($removeCurrencyInd == 1)
    			{
    				$formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
    			}
    			
    			return $formatter->format($strAmt);
		}
	}
	
	if(!function_exists('GVStringFormat'))
	{
		function GVStringFormat($inputStr)
		{
			return trim($inputStr ?? ""," \n\r\t\v\x00"); 
		}
	}
	
	if(!function_exists('GVSetErrorCodes'))
	{
		function GVSetErrorCodes($controlName, $strDesc)
		{
			if($GLOBALS["ErrorInd"] == 0)
			{
				GVAlertMessage("Page Contains Error.Please Verify","DANGER");
			}
			
			$GVErrArr = $GLOBALS["GVErrorSummary"];
			$GVErrArr[$controlName] = $strDesc;
			$GLOBALS["ErrorInd"] = 1;
			$GLOBALS["GVErrorSummary"] = $GVErrArr;
		}
	}
	
	//script function
	if(!function_exists('GVLoadPageDirect'))
	{
		function GVLoadPageDirect($strSrc)
		{
			$strLoadPage = "";
			$strLoadPage = "<script>";
			$strLoadPage .= "parent.location.href = '$strSrc';";
			$strLoadPage .= "</script>'";
			echo $strLoadPage;
		}
	}
	
	if(!function_exists('GVLoadIframeDirect'))
	{
		function GVLoadIframeDirect($strSrc)
		{
			$strLoadPage = "";
			$strLoadPage = "<script>";
			$strLoadPage .= "parent.document.getElementById('GVmainFrame').src = '$strSrc';";
			$strLoadPage .= "</script>'";
			echo $strLoadPage;
		}
	}
	
	if(!function_exists('GVPopSaveLoad'))
	{
		function GVPopSaveLoad()
		{
			GVPopToPageSession();
			
			$strLoadPage = "";
			$strLoadPage = "<script>";
			$strLoadPage .= "parent.document.getElementById('GVPOPOUT').style.display = 'none';";
			$strLoadPage .= "parent.document.getElementById('GVmainFrame').src = parent.document.getElementById('GVmainFrame').src;";
			$strLoadPage .= "</script>'";
			echo $strLoadPage;
		}
	}
	
	if(!function_exists('GVPopSaveLoadURL'))
	{
		function GVPopSaveLoadURL($strSrc,$ssData="")
		{
			GVPrevPageSessionClear();
			GVPageSessionChange($ssData);
			
			$strLoadPage = "";
			$strLoadPage = "<script>";
			$strLoadPage .= "parent.document.getElementById('GVPopFrame').src = '';";
			$strLoadPage .= "parent.document.getElementById('GVPOPOUT').style.display = 'none';";
			$strLoadPage .= "parent.document.getElementById('GVmainFrame').src = '$strSrc';";
			$strLoadPage .= "</script>'";
			echo $strLoadPage;
		}
	}
	
	if(!function_exists('GVPopClose'))
	{
		function GVPopClose()
		{
			GVPopToPageSession();
			
			$strLoadPage = "";
			$strLoadPage = "<script>";
			$strLoadPage .= "parent.document.getElementById('GVPOPOUT').style.display = 'none';";
			$strLoadPage .= "parent.document.getElementById('GVLOADEROUT').style.display = 'none';";
			$strLoadPage .= "</script>'";
			echo $strLoadPage;
		}
	}
	
	if(!function_exists('GVsweetAlertMessage'))
	{
		function GVsweetAlertMessage($strMsg, $alertType)
		{
			$strLoadPage = "";
			$strLoadPage = "<script>";
			
			if($alertType == "MsgOK")
				$strLoadPage .= "swal('$strMsg');";
			
			$strLoadPage .= "</script>'";
			echo $strLoadPage;
		}
	}
	
	if(!function_exists('GVGenerateHTMLtoPDF'))
	{
		function GVGenerateHTMLtoPDF($htmlContent, $HTMLSetupArr=array())
		{
			require "../../gvtech/vendor/autoload.php";
			$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format'=> $HTMLSetupArr['format'], 'orientation' => $HTMLSetupArr['orientation']]);
			
			$stylesheet = file_get_contents('../../gvtech/css/pdfStyle.css');
   			
   			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->SetHeader($HTMLSetupArr['Header']);
			$mpdf->SetFooter($HTMLSetupArr['Footer']);
			$mpdf->WriteHTML($htmlContent);
			
			$mpdf->Output($HTMLSetupArr['File_Name'].".pdf", "D");
		}
	}
?>