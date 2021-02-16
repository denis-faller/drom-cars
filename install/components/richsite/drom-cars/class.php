<?

Class DromCars{
    
    private $iblockId;
    private $url;
    private $quantityAllow;
    private $sMarkPropCode;
    private $sModelPropCode;
    private $sCityPropCode;
    private $yearOfMadePropCode;
    private $vinPropCode;
    private $idNewTypePropCode;
    private $volumePropCode;
    private $sFrameTypePropCode;
    private $sColorPropCode;
    private $sTransmissionPropCode;
    private $sEngineTypePropCode;
    private $sDriveTypePropCode;
    private $sWheelTypePropCode;
    private $haulPropCode;
    private $photosPropCode;
    private $whereAboutsPropCode;
    private $powerPropCode;
    
    public function __construct($iblockId, $url, $quantityAllow, 
            $sMarkPropCode,
            $sModelPropCode,
            $sCityPropCode,
            $yearOfMadePropCode,
            $vinPropCode,
            $idNewTypePropCode,
            $volumePropCode,
            $sFrameTypePropCode,
            $sColorPropCode,
            $sTransmissionPropCode,
            $sEngineTypePropCode,
            $sDriveTypePropCode,
            $sWheelTypePropCode,
            $haulPropCode,
            $photosPropCode,
            $whereAboutsPropCode,
            $powerPropCode){
        $this->iblockId = $iblockId;
        $this->url = $url;
        $this->quantityAllow = $quantityAllow;
        $this->sMarkPropCode = $sMarkPropCode;
        $this->sModelPropCode = $sModelPropCode;
        $this->sCityPropCode = $sCityPropCode;
        $this->yearOfMadePropCode = $yearOfMadePropCode;
        $this->vinPropCode = $vinPropCode;
        $this->idNewTypePropCode = $idNewTypePropCode;
        $this->volumePropCode = $volumePropCode;
        $this->sFrameTypePropCode = $sFrameTypePropCode;
        $this->sColorPropCode = $sColorPropCode;
        $this->sTransmissionPropCode = $sTransmissionPropCode;
        $this->sEngineTypePropCode = $sEngineTypePropCode;
        $this->sDriveTypePropCode = $sDriveTypePropCode;
        $this->sWheelTypePropCode = $sWheelTypePropCode;
        $this->haulPropCode = $haulPropCode;
        $this->photosPropCode = $photosPropCode;
        $this->whereAboutsPropCode = $whereAboutsPropCode;
        $this->powerPropCode = $powerPropCode;
    }

    public function getCars(){
        $arrFilter = array("IBLOCK_ID"=>$this->iblockId, "ACTIVE" => "Y");
        
        $dbRes = CIBlockElement::GetList(array(), $arrFilter, false, false, array());
        
        $cars = [];

        while($obRes = $dbRes->GetNextElement()){
            $arRes = $obRes->GetFields();
            
            $cars[$arRes["ID"]]["quantity"] = CCatalogProduct::GetByID($arRes["ID"]);
            $cars[$arRes["ID"]]["quantity"] = $cars[$arRes["ID"]]["quantity"]["QUANTITY"];
            
            if(isset($arRes["DETAIL_PICTURE"])){
                $cars[$arRes["ID"]]["DETAIL_PICTURE"] = CFile::GetPath($arRes["DETAIL_PICTURE"]);
                $cars[$arRes["ID"]]["DETAIL_PICTURE"] = $this->url.$cars[$arRes["ID"]]["DETAIL_PICTURE"];
            }

            $props = $obRes->GetProperties();
            
            $cars[$arRes["ID"]]["S_MARK"] = $props[$this->sMarkPropCode]["VALUE"];
  
            $cars[$arRes["ID"]]["S_MODEL"] = $props[$this->sModelPropCode]["VALUE"];
            
            $cars[$arRes["ID"]]["S_CITY"] = $props[$this->sCityPropCode]["VALUE"];

            $cars[$arRes["ID"]]["YEAR_OF_MADE"] = $props[$this->yearOfMadePropCode]["VALUE"];
            
            $cars[$arRes["ID"]]["VIN"] = $props[$this->vinPropCode]["VALUE"];
            
            $cars[$arRes["ID"]]["PRICE"] = CPrice::GetBasePrice($arRes["ID"]);
            $cars[$arRes["ID"]]["PRICE"] = intval($cars[$arRes["ID"]]["PRICE"]["PRICE"]);

            $cars[$arRes["ID"]]["ID_NEW_TYPE"] = $props[$this->idNewTypePropCode]["VALUE"];
            
            $cars[$arRes["ID"]]["VOLUME"] = $props[$this->volumePropCode]["VALUE"];
                            
            $cars[$arRes["ID"]]["S_FRAME_TYPE"] = $props[$this->sFrameTypePropCode]["VALUE"];
            
            $cars[$arRes["ID"]]["S_COLOR"] = $props[$this->sColorPropCode]["VALUE"]; 
                       
            $cars[$arRes["ID"]]["S_TRANSMISSION"] = $props[$this->sTransmissionPropCode]["VALUE"]; 
            
            $cars[$arRes["ID"]]["S_ENGINE_TYPE"] = $props[$this->sEngineTypePropCode]["VALUE"];
            
            $cars[$arRes["ID"]]["S_DRIVE_TYPE"] = $props[$this->sDriveTypePropCode]["VALUE"]; 

            $cars[$arRes["ID"]]["S_WHEEL_TYPE"] = $props[$this->sWheelTypePropCode]["VALUE"]; 

            $cars[$arRes["ID"]]["HAUL"] = $props[$this->haulPropCode]["VALUE"]; 

            $cars[$arRes["ID"]]["ADDITIONAL"] = $arRes["DETAIL_TEXT"];
            
            foreach($props[$this->photosPropCode]["VALUE"] as $morePhotoID){
                $cars[$arRes["ID"]]["PHOTOS"][$morePhotoID] = CFile::GetPath($morePhotoID);
                $cars[$arRes["ID"]]["PHOTOS"][$morePhotoID] = $this->url.$cars[$arRes["ID"]]["PHOTOS"][$morePhotoID];
            }
            
            $cars[$arRes["ID"]]["WHEREABOUTS"] = $props[$this->whereAboutsPropCode]["VALUE"]; 

            $cars[$arRes["ID"]]["POWER"] = $props[$this->powerPropCode]["VALUE"]; 
        }
         
        return $cars;
    }

    public function getSimpleXmlElement($cars){        
        $xmlstr = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?><avtoxml></avtoxml>";
        $sxe = new SimpleXMLElement($xmlstr);
        
        $offers = $sxe->addChild('Offers');
        foreach($cars as $key=>$value){
            if($this->quantityAllow && ($value["quantity"] <= 0)){
                continue;
            }
            else{
                $off = $offers->addChild('Offer');
                $id = $off->addChild("idOffer", $key);

                $sMark = $off->addChild("sMark", $value["S_MARK"]);
                $sModel = $off->addChild("sModel", $value["S_MODEL"]);
                $sCity = $off->addChild("sCity", $value["S_CITY"]);
                $yearOfMade = $off->addChild("YearOfMade", $value["YEAR_OF_MADE"]);
                $VIN = $off->addChild("VIN", $value["VIN"]);
                $price = $off->addChild("Price", $value["PRICE"]);
                $idNewType = $off->addChild("idNewType", $value["ID_NEW_TYPE"]);
                $volume = $off->addChild("Volume", $value["VOLUME"]);
                $sFrameType = $off->addChild("sFrameType", $value["S_FRAME_TYPE"]);
                $sColor = $off->addChild("sColor", $value["S_COLOR"]);
                $sTransmission = $off->addChild("sTransmission", $value["S_TRANSMISSION"]);
                $sEngineType = $off->addChild("sEngineType", $value["S_ENGINE_TYPE"]);
                $sDriveType = $off->addChild("sDriveType", $value["S_DRIVE_TYPE"]);
                $sWheelType = $off->addChild("sWheelType", $value["S_WHEEL_TYPE"]);
                $haul = $off->addChild("Haul", $value["HAUL"]);

                $add = $off->addChild("Additional");
                $node = dom_import_simplexml($add);
                $no = $node->ownerDocument; 
                $node->appendChild($no->createCDATASection($value["ADDITIONAL"])); 

                $photos = $off->addChild("Photos");
                if(($value["DETAIL_PICTURE"] != $this->url) && $value["DETAIL_PICTURE"] != ""){
                    $photos->addAttribute("PhotoMain", $value["DETAIL_PICTURE"]);
                }
                $i = 0;
                foreach($value["PHOTOS"] as $keyPhoto=>$valuePhoto){
                    if($valuePhoto != $this->url){
                        $photo = $photos->addChild("Photo", $valuePhoto);
                    }
                    $i++;
                }

                $whereabouts = $off->addChild("Whereabouts", $value["WHEREABOUTS"]);
                $power = $off->addChild("Power", $value["POWER"]);
            }
        }
        return $sxe;
    }
}

?>