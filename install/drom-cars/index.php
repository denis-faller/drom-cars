<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Выгрузка автомобилей на Дром");
?><?php
$APPLICATION->IncludeComponent(
	"richsite:drom-cars",
	"",
	Array(
	)
);?>