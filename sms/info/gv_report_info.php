<?
		$GVsubMenuArr = array();
		$GVsubMenuCount = 0;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Overall Report";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-area-chart'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_overall_report&GVmenu=$GVmenu&GVsubMenu=OVERALL");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "OVERALL";
		$GVsubMenuCount++;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Customer Report";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-group'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_customer_report&GVmenu=$GVmenu&GVsubMenu=CUSTOMER");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "CUSTOMER";
		$GVsubMenuCount++;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Sales Transaction Report";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-money'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_transaction_report&GVmenu=$GVmenu&GVsubMenu=TRANSACTION");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "TRANSACTION";
		$GVsubMenuCount++;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Monthly Report";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-calendar'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_monthly_report&GVmenu=$GVmenu&GVsubMenu=MONTHLY&frmLinkInd=1");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "MONTHLY";
		$GVsubMenuCount++;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Daily Report";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-calendar-o'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_daily_report&GVmenu=$GVmenu&GVsubMenu=DAILY&frmLinkInd=1");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "DAILY";
		$GVsubMenuCount++;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Monthly Statistics";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-calendar'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_monthly_statistics&GVmenu=$GVmenu&GVsubMenu=MONTHLYSTATISTICS&frmLinkInd=1");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "MONTHLYSTATISTICS";
		$GVsubMenuCount++;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Monthly Sales Report";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-calendar'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_sales_report&GVmenu=$GVmenu&GVsubMenu=SALESMONTHLY&frmLinkInd=1");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "SALESMONTHLY";
		$GVsubMenuCount++;
		
		if(strlen($GVsubMenu) == 0)
		{
			$GVsubMenu = $GVsubMenuArr[0]["TAG"];
		}
?>