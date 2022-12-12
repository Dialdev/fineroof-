<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;
$aMenuLinksExt = $APPLICATION->IncludeComponent(
    "bitrix:menu.sections",
    "",
    array(
        "IBLOCK_ID" => "5",
        "DEPTH_LEVEL" => 2,
		//"IS_SEF" => "Y",
		//"SEF_BASE_URL" => "/services/"
    )
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);