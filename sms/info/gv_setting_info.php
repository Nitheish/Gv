<?
		$GVsubMenuArr = array();
		$GVsubMenuCount = 0;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Company Information";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-university'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_company_info&GVmenu=$GVmenu&GVsubMenu=COMPANY");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "COMPANY";
		$GVsubMenuCount++;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Password Change";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-key'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_passwrd_change&GVmenu=$GVmenu&GVsubMenu=PWDCHANGE");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "PWDCHANGE";
		$GVsubMenuCount++;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Employees";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-user'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_employee_list&GVmenu=$GVmenu&GVsubMenu=EMPLOYEES");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "EMPLOYEES";
		$GVsubMenuCount++;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Vendors";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-handshake-o'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_vendor_list&GVmenu=$GVmenu&GVsubMenu=VENDORS");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "VENDORS";
		$GVsubMenuCount++;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Customers";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-group'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_customer_list&GVmenu=$GVmenu&GVsubMenu=CUSTOMERS");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "CUSTOMERS";
		$GVsubMenuCount++;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Departments";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-group'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_department_list&GVmenu=$GVmenu&GVsubMenu=DEPARTMENTS");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "DEPARTMENTS";
		$GVsubMenuCount++;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Product Categories";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-cube'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_pdt_category_list&GVmenu=$GVmenu&GVsubMenu=PDTCATEGORY");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "PDTCATEGORY";
		$GVsubMenuCount++;
		
		$GVsubMenuArr[$GVsubMenuCount]["DESC"] = "Products";
		$GVsubMenuArr[$GVsubMenuCount]["IMG"] = "<i class='fa fa-cubes'></i>";
		$GVsubMenuArr[$GVsubMenuCount]["LINK"] = GVstringEncrption("LoadHtmlPage=gv_product_list&GVmenu=$GVmenu&GVsubMenu=PRODUCTS");
		$GVsubMenuArr[$GVsubMenuCount]["TAG"] = "PRODUCTS";
		$GVsubMenuCount++;
		
		if(strlen($GVsubMenu) == 0)
		{
			$GVsubMenu = $GVsubMenuArr[0]["TAG"];
		}
?>