<?
	//Design Functions
	if(!function_exists('GVCaptchaBox'))
	{
		function GVCaptchaBox($GVlabel, $GVvalue, $GVclass, $GVstyles, $GVother)
		{
			echo "<div class='form-group'>";
		
			if($GVlabel != "INPUT")
				echo "<label class='MyLabel'>$GVlabel</label>";
			
			echo "<div class='input-group'>";
			echo "<label class='$GVclass' style='$GVstyles' $GVother>$GVvalue</label>";
			echo "</div>";
			
			echo "</div>";
		}
	}
	
	if(!function_exists('GVUserNameBox'))
	{
		function GVUserNameBox($GVlabel, $GVname, $GVid, $GVclass, $GVstyles, $GVother)
		{
			$GVTextBoxVal = $GLOBALS[$GVname];
			$GVErrorSummary = $GLOBALS['GVErrorSummary'];
			
			if(isset($GVErrorSummary[$GVname]) != "")
			{
				$GVclass = "form-control GVLeftSideBorder Myerror ".$GVclass;
				$GVStackClass = "MyStackLeftErr";
			}
			else
			{
				$GVclass = "form-control GVLeftSideBorder".$GVclass;
				$GVStackClass = "MyStackLeft";
			}
			
			echo "<div class='form-group'>";
			
			if($GVlabel != "INPUT")
				echo "<label class='MyLabel'>$GVlabel</label>";
			
			echo "<div class='input-group'>";
			echo "<span class='GVLoginimage'><img src='/gvtech/images/user.png' style='width:25px;height:20px;margin-left:4px;margin-top:4px;'></img></span>";
			echo "<input type='text' class='$GVclass' name='$GVname' id='$GVid' value='$GVTextBoxVal' style='$GVstyles' $GVother>";
			echo "</div>";
			
			if(isset($GVErrorSummary[$GVname]) != "")
				echo "<label class='MyErrorMsg'>$GVErrorSummary[$GVname]</label>";
			
			echo "</div>";
		}
	}
	
	if(!function_exists('GVPassWordBox'))
	{
		function GVPassWordBox($GVlabel, $GVname, $GVid, $GVclass, $GVstyles, $GVother)
		{
			$GVTextBoxVal = $GLOBALS[$GVname];
			$GVErrorSummary = $GLOBALS['GVErrorSummary'];
			
			if(isset($GVErrorSummary[$GVname]) != "")
			{
				$GVclass = "form-control GVLeftSideBorder Myerror ".$GVclass;
				$GVStackClass = "MyStackLeftErr";
			}
			else
			{
				$GVclass = "form-control GVLeftSideBorder ".$GVclass;
				$GVStackClass = "MyStackLeft";
			}
			
			echo "<div class='form-group'>";
			
			if($GVlabel != "INPUT")
				echo "<label class='MyLabel'>$GVlabel</label>";
			
			echo "<div class='input-group'>";
			echo "<span class='GVLoginimage'><img src='/gvtech/images/key.png' style='width:25px;height:20px;margin-left:4px;margin-top:4px;'></img></span>";
			echo "<input type='password' class='$GVclass' name='$GVname' id='$GVid' value='$GVTextBoxVal' style='$GVstyles' $GVother>";
			echo "</div>";
			
			if(isset($GVErrorSummary[$GVname]) != "")
				echo "<label class='MyErrorMsg'>$GVErrorSummary[$GVname]</label>";
			
			echo "</div>";
		}
	}
	
	if(!function_exists('GVPwdTextBox'))
	{
		function GVPwdTextBox($GVlabel, $GVname, $GVid, $GVclass, $GVstyles, $GVother)
		{
			$GVTextBoxVal = $GLOBALS[$GVname];
			$GVErrorSummary = $GLOBALS['GVErrorSummary'];
			
			if(isset($GVErrorSummary[$GVname]) != "")
				$GVclass = "form-control MyError ".$GVclass;
			else
				$GVclass = "form-control ".$GVclass;
			
			echo "<div class='form-group'>";
			
			if($GVlabel != "INPUT")
				echo "<label class='MyLabel'>$GVlabel</label>";
			
			echo "<div class='input-group'>";
			echo "<input type='password' class='$GVclass' name='$GVname' id='$GVid' value='$GVTextBoxVal' style='$GVstyles' $GVother>";
			echo "</div>";
			
			if(isset($GVErrorSummary[$GVname]) != "")
			echo "<label class='MyErrorMsg'>$GVErrorSummary[$GVname]</label>";
			
			echo "</div>";
		}
	}
	
	if(!function_exists('GVTextBox'))
	{
		function GVTextBox($GVlabel, $GVname, $GVid, $GVclass, $GVstyles, $GVother)
		{
			$GVTextBoxVal = $GLOBALS[$GVname];
			$GVErrorSummary = $GLOBALS['GVErrorSummary'];
			
			if(isset($GVErrorSummary[$GVname]) != "")
				$GVclass = "form-control MyError ".$GVclass;
			else
				$GVclass = "form-control ".$GVclass;
			
			echo "<div class='form-group'>";
			
			if($GVlabel != "INPUT")
				echo "<label class='MyLabel'>$GVlabel</label>";
			
			echo "<div class='input-group'>";
			echo "<input type='text' class='$GVclass' name='$GVname' id='$GVid' value='$GVTextBoxVal' style='$GVstyles' $GVother>";
			echo "</div>";
			
			if(isset($GVErrorSummary[$GVname]) != "")
			echo "<label class='MyErrorMsg'>$GVErrorSummary[$GVname]</label>";
			
			echo "</div>";
		}
	}
	
	if(!function_exists('GVTextArea'))
	{
		function GVTextArea($GVlabel, $GVname, $GVid, $GVclass, $GVstyles, $GVother)
		{
			$GVTextBoxVal = $GLOBALS[$GVname];
			$GVErrorSummary = $GLOBALS['GVErrorSummary'];
			
			if(isset($GVErrorSummary[$GVname]) != "")
				$GVclass = "form-control MyError ".$GVclass;
			else
				$GVclass = "form-control ".$GVclass;
			
			echo "<div class='form-group'>";
			
			if($GVlabel != "INPUT")
				echo "<label class='MyLabel'>$GVlabel</label>";
			
			echo "<div class='input-group'>";
			echo "<textarea class='$GVclass' name='$GVname' id='$GVid' value='$GVTextBoxVal' style='$GVstyles' $GVother>$GVTextBoxVal</textarea>";
			echo "</div>";
			
			if(isset($GVErrorSummary[$GVname]) != "")
				echo "<label class='MyErrorMsg'>$GVErrorSummary[$GVname]</label>";
			
			echo "</div>";
		}
	}
	
	if(!function_exists('GVAmountBox'))
	{
		function GVAmountBox($GVlabel, $GVname, $GVid, $GVclass, $GVstyles, $GVother)
		{
			$GVTextBoxVal = $GLOBALS[$GVname];
			$GVErrorSummary = $GLOBALS['GVErrorSummary'];
			
			if(isset($GVErrorSummary[$GVname]) != "")
			{
				$GVclass = "form-control Myerror ".$GVclass;
				$GVStackClass = "MyStackLeftErr";
			}
			else
			{
				$GVclass = "form-control ".$GVclass;
				$GVStackClass = "MyStackLeft";
			}
			
			echo "<div class='form-group'>";
			
			if($GVlabel != "INPUT")
				echo "<label class='MyLabel'>$GVlabel</label>";
			
			echo "<div class='input-group'>";
			echo "<span class='$GVStackClass'>&nbsp;&nbsp;&#8377&nbsp;&nbsp;</span>";
			echo "<input type='text' class='$GVclass' name='$GVname' id='$GVid' value='$GVTextBoxVal' style='text-align:right;$GVstyles' onkeypress='return isMoneyKey(this, this.value);' oninput='validate(this)' $GVother>";
			echo "</div>";
			
			if(isset($GVErrorSummary[$GVname]) != "")
				echo "<label class='MyErrorMsg'>$GVErrorSummary[$GVname]</label>";
			
			echo "</div>";
		}
	}
	
	if(!function_exists('GVPercentBox'))
	{
		function GVPercentBox($GVlabel, $GVname, $GVid, $GVclass, $GVstyles, $GVother)
		{
			$GVTextBoxVal = $GLOBALS[$GVname];
			
			$GVErrorSummary = $GLOBALS['GVErrorSummary'];
			
			if(isset($GVErrorSummary[$GVname]) != "")
			{
				$GVclass = "form-control Myerror ".$GVclass;
				$GVStackClass = "MyStackLeftErr";
			}
			else
			{
				$GVclass = "form-control ".$GVclass;
				$GVStackClass = "MyStackLeft";
			}
			
			echo "<div class='form-group'>";
			
			if($GVlabel != "INPUT")
				echo "<label class='MyLabel'>$GVlabel</label>";
			
			echo "<div class='input-group'>";
			echo "<input type='text' class='$GVclass' name='$GVname' id='$GVid' value='$GVTextBoxVal' style='text-align:right;$GVstyles' onkeypress='return isMoneyKey(this, this.value);' $GVother>";
			echo "<span class='MyStackRight'>&nbsp;&nbsp;%&nbsp;&nbsp;</span>";
			echo "</div>";
			
			if(isset($GVErrorSummary[$GVname]) != "")
				echo "<label class='MyErrorMsg'>$GVErrorSummary[$GVname]</label>";
			
			echo "</div>";
		}
	}
	
	if(!function_exists('GVDateBox'))
	{
		function GVDateBox($GVlabel, $GVname, $GVid, $GVclass, $GVstyles, $GVother)
		{
			$GVTextBoxVal = $GLOBALS[$GVname];
			$GVErrorSummary = $GLOBALS['GVErrorSummary'];
			
			if(isset($GVErrorSummary[$GVname]) != "")
				$GVclass = "form-control MyError ".$GVclass;
			else
				$GVclass = "form-control ".$GVclass;
			
			echo "<div class='form-group'>";
			
			if($GVlabel != "INPUT")
				echo "<label class='MyLabel'>$GVlabel</label>";
			
			echo "<div class='input-group'>";
			echo "<input type='text' class='$GVclass' id='$GVid' name='$GVname' value='$GVTextBoxVal' style='$GVstyles' $GVother>";
			echo "<span class='MyStackRight'>&nbsp;&nbsp;<i class='fa fa-calendar'></i>&nbsp;&nbsp;</span>";
			echo "</div>";
			
			if(isset($GVErrorSummary[$GVname]) != "")
			echo "<label class='MyErrorMsg'>$GVErrorSummary[$GVname]</label>";
			
			echo "</div>";
		}
	}
	
	if(!function_exists('GVDateRangeBox'))
	{
		function GVDateRangeBox($GVlabel, $GVname, $GVid, $GVclass, $GVstyles, $GVother)
		{
			$GVTextBoxVal = $GLOBALS[$GVname];
			$GVErrorSummary = $GLOBALS['GVErrorSummary'];
			
			if(isset($GVErrorSummary[$GVname]) != "")
				$GVclass = "form-control MyError ".$GVclass;
			else
				$GVclass = "form-control ".$GVclass;
			
			echo "<div class='form-group'>";
			
			if($GVlabel != "INPUT")
				echo "<label class='MyLabel'>$GVlabel</label>";
			
			echo "<div id='DR_$GVid' class='input-group'>";
			echo "<input type='text' class='$GVclass' id='$GVid' name='$GVname' value='$GVTextBoxVal' style='$GVstyles' $GVother>";
			echo "<span style='margin-left: -30px;margin-top: 4px;z-index: 9999;font-size: 15px;'>&nbsp;&nbsp;<i class='fa fa-calendar'></i>&nbsp;&nbsp;</span>";
			echo "</div>";
			
			if(isset($GVErrorSummary[$GVname]) != "")
			echo "<label class='MyErrorMsg'>$GVErrorSummary[$GVname]</label>";
			
			echo "</div>";
		}
	}
	
	if(!function_exists('GVCheckBox'))
	{
		function GVCheckBox($GVlabel, $GVname, $GVid, $GVSetVal, $GVclass, $GVstyles, $GVother)
		{
			$GVCheckBoxVal = $GLOBALS[$GVname];
			
			$GVErrorSummary = $GLOBALS['GVErrorSummary'];
			
			if($GVCheckBoxVal == $GVSetVal)
				$GVother = "checked ".$GVother;
			
			echo "<div class='form-group'>";
			echo "<div class='input-group'>";
			echo "<input type='checkbox' class='$GVclass' name='$GVname' id='$GVid' value='$GVSetVal' style='$GVstyles' $GVother>";
			
			if($GVlabel != "INPUT")
				echo "&nbsp;&nbsp;<label class='MyLabel'>$GVlabel</label>";
			echo "</div>";
			
			if(isset($GVErrorSummary[$GVname]) != "")
				echo "<label class='MyErrorMsg'>$GVErrorSummary[$GVname]</label>";
			
			echo "</div>";
		}
	}
	
	if(!function_exists('GVRadioButton'))
	{
		function GVRadioButton($GVlabel, $GVname, $GVid, $GVSetVal, $GVclass, $GVstyles, $GVother)
		{
			$GVRadioBtnVal = $GLOBALS[$GVname];
			
			if($GVRadioBtnVal == $GVSetVal)
				$GVother = "checked ".$GVother;
			
			echo "<input type='radio' class='$GVclass' name='$GVname' id='$GVid' value='$GVSetVal' style='$GVstyles' $GVother><span>&nbsp;&nbsp;$GVlabel&nbsp;&nbsp;</span>";
		}
	}
	
	if(!function_exists('GVComboBox'))
	{
		function GVComboBox($GVlabel, $GVname, $GVid, $GVcboArr, $GVclass, $GVstyles, $GVother)
		{
			$GVRadioBtnVal = $GLOBALS[$GVname];
			
			$GVErrorSummary = $GLOBALS['GVErrorSummary'];
			
			if(isset($GVErrorSummary[$GVname]) != "")
				$GVclass = "custom-select MyError ".$GVclass;
			else
				$GVclass = "custom-select ".$GVclass;
			
			echo "<div class='form-group'>";
			
			if($GVlabel != "INPUT")
				echo "<label class='MyLabel'>$GVlabel</label>";
			
			echo "<div class='input-group'>";
			
			echo "<select class='$GVclass' name='$GVname' id='$GVid' style='$GVstyles' $GVother>";
			
			foreach($GVcboArr as $GVcboKey => $GVcboVal)
			{
				$GVcboSelect = "";
				
				if($GVRadioBtnVal == $GVcboKey)
					$GVcboSelect = "selected";
				
				echo "<option value='$GVcboKey' $GVcboSelect>$GVcboVal</option>";
			}
			
			echo "</select>";
			
			echo "</div>";
			
			if(isset($GVErrorSummary[$GVname]) != "")
				echo "<label class='MyErrorMsg'>$GVErrorSummary[$GVname]</label>";
			
			echo "</div>";
		}
	}
	
	if(!function_exists('GVButton'))
	{
		function GVButton($GVlabel, $GVname, $GVid, $GVbtnType, $GVclass, $GVstyles, $GVother)
		{
			if(strtoupper($GVclass) == "PRIMARY")
				$GVCtrlClass = "btn btn-primary";
			else if(strtoupper($GVclass) == "SECONDARY")
				$GVCtrlClass = "btn btn-secondary";
			else if(strtoupper($GVclass) == "SUCCESS")
				$GVCtrlClass = "btn btn-success";
			else if(strtoupper($GVclass) == "INFO")
				$GVCtrlClass = "btn btn-info";
			else if(strtoupper($GVclass) == "WARNING")
				$GVCtrlClass = "btn btn-warning";
			else if(strtoupper($GVclass) == "DANGER")
				$GVCtrlClass = "btn btn-danger";
			else if(strtoupper($GVclass) == "DARK")
				$GVCtrlClass = "btn btn-dark";
			else if(strtoupper($GVclass) == "LIGHT")
				$GVCtrlClass = "btn btn-light";
			else if(strtoupper($GVclass) == "LINK")
				$GVCtrlClass = "btn btn-link";
			else
				$GVCtrlClass = "btn";
				
			$GVclass = "MyButton ".$GVCtrlClass;
			
			echo "<button name='$GVname' type='$GVbtnType' class='$GVclass' id='$GVid' value='$GVlabel' style='$GVstyles' $GVother>$GVlabel</button>"; 
		}
	}
	
	if(!function_exists('GVHiddenInput'))
	{
		function GVHiddenInput($GVname, $GVid, $GVother)
		{
			$GVTextBoxVal = $GLOBALS[$GVname];
			echo "<input type='hidden' name='$GVname' id='$GVid' value='$GVTextBoxVal' $GVother>";
		}
	}	
	
	if(!function_exists('GViframe'))
	{
		function GViframe($GVname, $GVid, $GVsrc, $GVclass, $GVstyles, $GVother)
		{
			 echo "<iframe name='$GVname' class='$GVclass' id='$GVid' src='$GVsrc' style='$GVstyles' $GVother></iframe>"; 
		}
	}
	
	if(!function_exists('GVimage'))
	{
		function GVimage($GVname, $GVid, $GVsrc, $GVclass, $GVstyles, $GVother)
		{
			return "<img name='$GVname' class='$GVclass' id='$GVid' src='$GVsrc' style='$GVstyles' $GVother></img>";
		}
	}
	
	if(!function_exists('GVanchor'))
	{
		function GVanchor($GVname, $GVid, $GVsrc, $GVclass, $GVanchorTag, $GVstyles, $GVother)
		{
			echo "<a name='$GVname' class='$GVclass' id='$GVid' href='$GVsrc' style='$GVstyles' $GVother>$GVanchorTag</a>";
		}
	}
	
	if(!function_exists('GVimageButton'))
	{
		function GVimageButton($GVlabel, $GVname, $GVid, $GVimgSrc, $GVbtnType, $GVclass, $GVstyles, $GVother)
		{
			if(strtoupper($GVclass) == "PRIMARY")
				$GVCtrlClass = "btn btn-primary";
			else if(strtoupper($GVclass) == "SECONDARY")
				$GVCtrlClass = "btn btn-secondary";
			else if(strtoupper($GVclass) == "SUCCESS")
				$GVCtrlClass = "btn btn-success";
			else if(strtoupper($GVclass) == "INFO")
				$GVCtrlClass = "btn btn-info";
			else if(strtoupper($GVclass) == "WARNING")
				$GVCtrlClass = "btn btn-warning";
			else if(strtoupper($GVclass) == "DANGER")
				$GVCtrlClass = "btn btn-danger";
			else if(strtoupper($GVclass) == "DARK")
				$GVCtrlClass = "btn btn-dark";
			else if(strtoupper($GVclass) == "LIGHT")
				$GVCtrlClass = "btn btn-light";
			else if(strtoupper($GVclass) == "LINK")
				$GVCtrlClass = "btn btn-link";
			else if(strtoupper($GVclass) == "THEME")
				$GVCtrlClass = "btn btn-theme";
			else
				$GVCtrlClass = "btn";
				
			$GVclass = "MyButton ".$GVCtrlClass;
			
			echo "<button name='$GVname' type='$GVbtnType' class='$GVclass' id='$GVid' value='$GVlabel' style='$GVstyles' $GVother>";
			
			if($GVimgSrc != "")
				echo "$GVimgSrc ";
			
			echo "$GVlabel</button>"; 
		}
	}
	
	if(!function_exists('GVInputButton'))
	{
		function GVInputButton($GVlabel, $GVname, $GVid, $GVbtnType, $GVclass, $GVstyles, $GVother)
		{
			if(strtoupper($GVclass) == "PRIMARY")
				$GVCtrlClass = "btn btn-primary";
			else if(strtoupper($GVclass) == "SECONDARY")
				$GVCtrlClass = "btn btn-secondary";
			else if(strtoupper($GVclass) == "SUCCESS")
				$GVCtrlClass = "btn btn-success";
			else if(strtoupper($GVclass) == "INFO")
				$GVCtrlClass = "btn btn-info";
			else if(strtoupper($GVclass) == "WARNING")
				$GVCtrlClass = "btn btn-warning";
			else if(strtoupper($GVclass) == "DANGER")
				$GVCtrlClass = "btn btn-danger";
			else if(strtoupper($GVclass) == "DARK")
				$GVCtrlClass = "btn btn-dark";
			else if(strtoupper($GVclass) == "LIGHT")
				$GVCtrlClass = "btn btn-light";
			else if(strtoupper($GVclass) == "LINK")
				$GVCtrlClass = "btn btn-link";
			else if(strtoupper($GVclass) == "THEME")
				$GVCtrlClass = "btn btn-theme";
			else
				$GVCtrlClass = "btn";
				
			$GVclass = "MyButton ".$GVCtrlClass;
			
			echo "<input name='$GVname' type='$GVbtnType' class='$GVclass' id='$GVid' value='$GVlabel' style='$GVstyles' $GVother></input>"; 
		}
	}
	
	if(!function_exists('GVAlertMessage'))
	{
		function GVAlertMessage($strMsg, $GVclass="")
		{
			if(strtoupper($GVclass) == "INFO")
				$GVCtrlClass = "alert alert-info";
			else if(strtoupper($GVclass) == "WARNING")
				$GVCtrlClass = "alert alert-warning";
			else if(strtoupper($GVclass) == "DANGER")
				$GVCtrlClass = "alert alert-danger";
			else if(strtoupper($GVclass) == "SUCCESS")
				$GVCtrlClass = "alert alert-success";	
				
			echo "<div class='$GVCtrlClass alert-dismissible' style='left: 50%;margin-left: -200px;width: 400px;z-index: 9999 !important;position: absolute !important;'>";
			echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
			echo "$strMsg</div>";
		}
	}
	
	if(!function_exists('GVTextBoxWithList'))
	{
		function GVTextBoxWithList($GVlabel, $GVname, $GVid, $GVclass, $GVstyles, $GVother, $GVoptionArr=array())
		{
			$GVTextBoxVal = $GLOBALS[$GVname];
			$GVErrorSummary = $GLOBALS['GVErrorSummary'];
			
			if(isset($GVErrorSummary[$GVname]) != "")
				$GVclass = "form-control MyError ".$GVclass;
			else
				$GVclass = "form-control ".$GVclass;
			
			echo "<div class='form-group'>";
			
			if($GVlabel != "INPUT")
				echo "<label class='MyLabel'>$GVlabel</label>";
			
			$GVTextListID = "LIST_".$GVid;
			
			echo "<div class='input-group'>";
			echo "<input type='text' class='$GVclass' list='$GVTextListID' name='$GVname' id='$GVid' value='$GVTextBoxVal' style='$GVstyles' $GVother>";
			
			echo "<datalist id='$GVTextListID'>";
			foreach($GVoptionArr as $GVcboKey => $GVcboVal)
			{
				echo "<option value='$GVcboKey' $GVcboSelect>$GVcboVal</option>";
			}
			echo "</datalist>";
			
			echo "</div>";
			
			if(isset($GVErrorSummary[$GVname]) != "")
			echo "<label class='MyErrorMsg'>$GVErrorSummary[$GVname]</label>";
			
			echo "</div>";
		}
	}
	
	if(!function_exists('GVSortMethod'))
	{
		function GVSortMethod($GVsortName, $txtSortMethod)
		{
			$txtSortName = $GLOBALS['txtSortName'];
			
			if($GVsortName == $txtSortName && $txtSortMethod == "asc")
				echo "<i class='fa fa-sort-amount-asc' style='margin-left: 7px;cursor:pointer;font-size: 14px;' onclick='GVSortMethodClick(\"$GVsortName\",\"desc\");'></i>";
			else if($GVsortName == $txtSortName && $txtSortMethod == "desc")
				echo "<i class='fa fa-sort-amount-desc' style='margin-left: 7px;cursor:pointer;font-size: 14px;' onclick='GVSortMethodClick(\"$GVsortName\",\"asc\");'></i>";
			else
				echo "<i class='fa fa-sort' style='margin-left: 7px;cursor:pointer;font-size: 14px;' onclick='GVSortMethodClick(\"$GVsortName\",\"desc\");'></i>";
		}
	}
	
	if(!function_exists('GVErrBox'))
	{
		function GVErrBox($GVname, $GVstyles="")
		{
			$GVErrorSummary = $GLOBALS['GVErrorSummary'];
			
			if(isset($GVErrorSummary[$GVname]) != "")
			{
				echo "<div style='$GVstyles'>";
				echo "<label class='MyErrorMsg'>$GVErrorSummary[$GVname]</label>";
				echo "</div>";
			}
		}
	}
?>