<?
		$GVmenuArr = array();
		$GVmenuCount = 0;
		
		$GVmenuArr[$GVmenuCount]["DESC"] = "Dashboard";
		$GVmenuArr[$GVmenuCount]["IMG"] = "<i class='fa fa-dashboard'></i>";
		$GVmenuArr[$GVmenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_dashboard&GVmenu=DASHBOARD");
		$GVmenuArr[$GVmenuCount]["TAG"] = "DASHBOARD";
		$GVmenuCount++;
		
		$GVmenuArr[$GVmenuCount]["DESC"] = "Purchase";
		$GVmenuArr[$GVmenuCount]["IMG"] = "<i class='fa fa-cart-arrow-down'></i>";
		$GVmenuArr[$GVmenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_purchase_list&GVmenu=PURCHASE");
		$GVmenuArr[$GVmenuCount]["TAG"] = "PURCHASE";
		$GVmenuCount++;
		
		$GVmenuArr[$GVmenuCount]["DESC"] = "Sales";
		$GVmenuArr[$GVmenuCount]["IMG"] = "<i class='fa fa-shopping-cart'></i>";
		$GVmenuArr[$GVmenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_sales_list&GVmenu=SALES&GVsubMenu=FRMSALES");
		$GVmenuArr[$GVmenuCount]["TAG"] = "SALES";
		$GVmenuCount++;
		
		$GVmenuArr[$GVmenuCount]["DESC"] = "Expenses";
		$GVmenuArr[$GVmenuCount]["IMG"] = "<i class='fa fa-money'></i>";
		$GVmenuArr[$GVmenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_expenses_list&GVmenu=EXPENSES");
		$GVmenuArr[$GVmenuCount]["TAG"] = "EXPENSES";
		$GVmenuCount++;
		
		$GVmenuArr[$GVmenuCount]["DESC"] = "Reports";
		$GVmenuArr[$GVmenuCount]["IMG"] = "<i class='fa fa-area-chart'></i>";
		$GVmenuArr[$GVmenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_overall_report&GVmenu=REPORTS");
		$GVmenuArr[$GVmenuCount]["TAG"] = "REPORTS";
		$GVmenuCount++;
		
		$GVmenuArr[$GVmenuCount]["DESC"] = "Settings";
		$GVmenuArr[$GVmenuCount]["IMG"] = "<i class='fa fa-wrench'></i>";
		$GVmenuArr[$GVmenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_company_info&GVmenu=SETTINGS");
		$GVmenuArr[$GVmenuCount]["TAG"] = "SETTINGS";
		$GVmenuCount++;
		
		if(strlen($GVmenu) == 0)
		{
			$GVmenu = $GVmenuArr[0]["TAG"];
		}
		
?>