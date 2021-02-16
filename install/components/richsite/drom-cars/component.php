<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("catalog"))
{
	ShowError(GetMessage("RICHSITE_CATALOG_MODULE_NOT_INSTALL"));
	return;
}


if($arParams["IBLOCK_ID"] == NULL){
    ShowError(GetMessage("RICHSITE_PARAMS_IBLOCK_NOT_EXIST"));
    return;
}

if(!$USER->isAdmin()){
    if(file_exists("saved_file.xml")){
        $APPLICATION->RestartBuffer();
        $arResult["sxe"] = simplexml_load_file("saved_file.xml");
    }
    else{
        $currentUrl = (CMain::IsHTTPS()) ? "https://" : "http://";

        $currentUrl .= $_SERVER["HTTP_HOST"];
        
        if($arParams["QUANTITY_ALLOW"] == "Y"){
            $quantityAllow = true;
        }
        else{
            $quantityAllow = false;
        }

        $dromCars = new DromCars($arParams["IBLOCK_ID"], $currentUrl, $quantityAllow,
                $arParams["S_MARK"],
                $arParams["S_MODEL"],
                $arParams["S_CITY"],
                $arParams["YEAR_OF_MADE"],
                $arParams["VIN"],
                $arParams["ID_NEW_TYPE"],
                $arParams["VOLUME"],
                $arParams["S_FRAME_TYPE"],
                $arParams["S_COLOR"],
                $arParams["S_TRANSMISSION"],
                $arParams["S_ENGINE_TYPE"],
                $arParams["S_DRIVE_TYPE"],
                $arParams["S_WHEEL_TYPE"],
                $arParams["HAUL"],
                $arParams["PHOTOS"],
                $arParams["WHEREABOUTS"],
                $arParams["POWER"]);
        
        $arResult["cars"] = $dromCars->getCars();
        
        if($arResult["cars"] == NULL){
            ShowError(GetMessage("RICHSITE_CARS_NOT_EXIST"));
            return;
        }
        
        $arResult["sxe"] = $dromCars->getSimpleXmlElement($arResult["cars"]);

        $APPLICATION->RestartBuffer();

        if($arParams["SAVED_FILE"] != NULL){
            if($arParams["SAVED_FILE"] == "Y"){
                if(!file_exists("saved_file.xml")){
                    $arResult["sxe"]->asXML("saved_file.xml");
                }
            }
        }
    }
    $this->IncludeComponentTemplate();

    die;
}

?>