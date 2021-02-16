<?
$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang)-strlen("/install/index.php"));
include(GetLangFileName($strPath2Lang."/lang/", "/install/index.php"));

Class richsite_dromcars extends CModule
{
	var $MODULE_ID = "richsite.dromcars";
	var $MODULE_NAME = "Выгрузка автомобилей на drom";
	
	function richsite_dromcars(){
		$this->PARTNER_NAME = "richsite";
		$this->PARTNER_URI = "http://marketplace.1c-bitrix.ru/solutions/richsite.dromcars/";
		
		$arModuleVersion = array();
		include("version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		
		$this->MODULE_NAME = GetMessage("RICHSITE_DROM_CARS_MODULE_INSTALL_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("RICHSITE_DROM_CARS_MODULE_INSTALL_DESCRIPTION");
	}
	
	
	function InstallDB($install_wizard = true)
	{
		global $DB, $DBType, $APPLICATION;
		RegisterModule($this->MODULE_ID);
		
		return true;
	}

	function UnInstallDB($arParams = Array())
	{
		global $DB, $DBType, $APPLICATION;
		UnRegisterModule($this->MODULE_ID);
		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles()
	{
            CopyDirFiles(dirname(__FILE__)."/drom-cars", $_SERVER["DOCUMENT_ROOT"]."/drom-cars", false, true);
            $res = CopyDirFiles(dirname(__FILE__)."/components/richsite/drom-cars", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components/richsite/drom-cars", false, true);
            return $res;
	}

	function InstallPublic()
	{
	}

	function UnInstallFiles()
	{
            if(file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/components/richsite/drom-cars")){
                DeleteDirFilesEx("/drom-cars");
                DeleteDirFilesEx("/bitrix/components/richsite/drom-cars");
            }
            return true;
	}
		
	function DoInstall()
	{
		global $DB, $APPLICATION, $step;
		$this->InstallFiles();
		$this->InstallDB(false);
		$this->InstallEvents();
		$this->InstallPublic();
		
		$APPLICATION->IncludeAdminFile(GetMessage("RICHSITE_DROM_CARS_MODULE_INSTALL_TITLE"), dirname(__FILE__)."/step1.php");

	}
		
	function DoUninstall()
	{
		global $DB, $APPLICATION, $step;
		$this->UnInstallDB();
		$this->UnInstallFiles();
		$this->UnInstallEvents();
		$APPLICATION->IncludeAdminFile(GetMessage("RICHSITE_DROM_CARS_MODULE_UNINSTALL_TITLE"), dirname(__FILE__)."/unstep1.php");
	}
}
?>