<?
CModule::IncludeModule("iblock");

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = array();
$iblockFilter = (
	!empty($arCurrentValues['IBLOCK_TYPE'])
	? array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y')
	: array('ACTIVE' => 'Y')
);
$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
while ($arr = $rsIBlock->Fetch())
	$arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
unset($arr, $rsIBlock, $iblockFilter);


$properties = CIBlockProperty::GetList(Array("name"=>"asc"), Array("IBLOCK_ID"=>$arCurrentValues['IBLOCK_ID']));
while ($propFields = $properties->GetNext()){
  $arProp[$propFields['CODE']] = '['.$propFields['ID'].'] '.$propFields['NAME'];
}

$arComponentParameters = array(
   "PARAMETERS" => array(
    "IBLOCK_TYPE" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("IBLOCK_TYPE"),
        "TYPE" => "LIST",
        "VALUES" => $arIBlockType,
        "REFRESH" => "Y",
    ),
    "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBLOCK_IBLOCK"),
            "TYPE" => "LIST",
            "ADDITIONAL_VALUES" => "Y",
            "VALUES" => $arIBlock,
            "REFRESH" => "Y",
    ),
    "S_MARK" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_S_MARK"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "S_MODEL" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_S_MODEL"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "S_CITY" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_S_CITY"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "YEAR_OF_MADE" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_YEAR_OF_MADE"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),     
    "VIN" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_VIN"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "ID_NEW_TYPE" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_ID_NEW_TYPE"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "VOLUME" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_VOLUME"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "S_FRAME_TYPE" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_S_FRAME_TYPE"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "S_COLOR" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_S_COLOR"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "S_TRANSMISSION" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_S_TRANSMISSION"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "S_ENGINE_TYPE" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_S_ENGINE_TYPE"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "S_DRIVE_TYPE" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_S_DRIVE_TYPE"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "S_WHEEL_TYPE" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_S_WHEEL_TYPE"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "HAUL" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_HAUL"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "PHOTOS" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_PHOTOS"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "WHEREABOUTS" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_WHEREABOUTS"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),
    "POWER" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("RICHSITE_POWER"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arProp,
        "REFRESH" => "Y",
    ),        
    "QUANTITY_ALLOW" => array(
        "NAME" => GetMessage("RICHSITE_QUANTITY_ALLOW"),
        "TYPE" => "CHECKBOX",
    ),
    "SAVED_FILE" => array(
        "NAME" => GetMessage("RICHSITE_SAVED_FILE"),
        "TYPE" => "CHECKBOX",
    ),  
   )
);
?>