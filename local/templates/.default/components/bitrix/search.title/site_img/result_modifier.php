<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$PREVIEW_WIDTH = intval($arParams["PREVIEW_WIDTH"]);
if ($PREVIEW_WIDTH <= 0) {
    $PREVIEW_WIDTH = 75;
}

$PREVIEW_HEIGHT = intval($arParams["PREVIEW_HEIGHT"]);
if ($PREVIEW_HEIGHT <= 0) {
    $PREVIEW_HEIGHT = 75;
}

$arResult["ELEMENTS"] = [];
$arResult["SEARCH"] = [];

foreach($arResult["CATEGORIES"] as $category_id => $arCategory)
{
    foreach($arCategory["ITEMS"] as $i => $arItem)
    {
        if(isset($arItem["ITEM_ID"]))
        {
            $arResult["SEARCH"][] = &$arResult["CATEGORIES"][$category_id]["ITEMS"][$i];
            if (
                $arItem["MODULE_ID"] == "iblock"
                && substr($arItem["ITEM_ID"], 0, 1) !== "S"
            )
            {
                $arResult["ELEMENTS"][$arItem["ITEM_ID"]] = $arItem["ITEM_ID"];
            } elseif (
                $arItem["MODULE_ID"] == "iblock"
                && substr($arItem["ITEM_ID"], 0, 1) === "S"
            ) {
                $sectionID = str_replace('S', '', $arItem["ITEM_ID"]);
                $arResult["SECTIONS"][$arItem["ITEM_ID"]] = $sectionID;
            }
        }
    }
}

if ( CModule::IncludeModule("iblock")) {
    if (!empty($arResult["ELEMENTS"])) {
        
        $obParser = new CTextParser;
        
        $arSelect = [
            "ID",
            "IBLOCK_ID",
            "PREVIEW_TEXT",
            "PREVIEW_PICTURE",
            "DETAIL_PICTURE",
        ];
        $arFilter = [
            "IBLOCK_LID"        => SITE_ID,
            "IBLOCK_ACTIVE"     => "Y",
            "ACTIVE_DATE"       => "Y",
            "ACTIVE"            => "Y",
            "CHECK_PERMISSIONS" => "Y",
            "MIN_PERMISSION"    => "R",
        ];
        $arFilter["=ID"] = $arResult["ELEMENTS"];
        $arResult["ELEMENTS"] = [];
        $rsElements = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
        while ($arElement = $rsElements->Fetch()) {
            if ($arParams["PREVIEW_TRUNCATE_LEN"] > 0) {
                $arElement["PREVIEW_TEXT"] = $obParser->html_cut(
                    $arElement["PREVIEW_TEXT"],
                    $arParams["PREVIEW_TRUNCATE_LEN"]
                );
            }
            
            $arResult["ELEMENTS"][$arElement["ID"]] = $arElement;
        }
    }
    
    if (!empty($arResult["SECTIONS"])) {
        
        $obParser = new CTextParser;
        
        $arSelect = [
            "ID",
            "IBLOCK_ID",
            "PICTURE"
        ];
        $arFilter = [
            "IBLOCK_LID"        => SITE_ID,
            "IBLOCK_ACTIVE"     => "Y",
            "ACTIVE_DATE"       => "Y",
            "ACTIVE"            => "Y",
            "CHECK_PERMISSIONS" => "Y",
            "MIN_PERMISSION"    => "R",
        ];
        $arFilter["=ID"] = $arResult["SECTIONS"];
        $rsElements = CIBlockSection::GetList([], $arFilter, false, $arSelect);
        while ($arElement = $rsElements->Fetch()) {
            if ($arElement["PICTURE"]) {
                $arElement["PREVIEW_PICTURE"] = $arElement["PICTURE"];
                unset($arElement["PICTURE"]);
            }
    
            $arResult["ELEMENTS"]['S' . $arElement["ID"]] = $arElement;
        }
    }
}

foreach ($arResult["SEARCH"] as $i => $arItem) {
    switch ($arItem["MODULE_ID"]) {
        case "iblock":
            if ($arParams["SHOW_PREVIEW"] == "Y") {
                if (array_key_exists($arItem["ITEM_ID"], $arResult["ELEMENTS"])) {
                    $arElement = &$arResult["ELEMENTS"][$arItem["ITEM_ID"]];
                }
    
                if ($arElement["PREVIEW_PICTURE"] > 0) {
                    $arElement["PICTURE"] = CFile::ResizeImageGet(
                        $arElement["PREVIEW_PICTURE"],
                        [
                            "width"  => $PREVIEW_WIDTH,
                            "height" => $PREVIEW_HEIGHT
                        ],
                        BX_RESIZE_IMAGE_PROPORTIONAL,
                        true
                    );
                } elseif ($arElement["DETAIL_PICTURE"] > 0) {
                    $arElement["PICTURE"] = CFile::ResizeImageGet(
                        $arElement["DETAIL_PICTURE"],
                        [
                            "width"  => $PREVIEW_WIDTH,
                            "height" => $PREVIEW_HEIGHT
                        ],
                        BX_RESIZE_IMAGE_PROPORTIONAL,
                        true
                    );
                }
            }
            break;
    }
    
    $arResult["SEARCH"][$i]["ICON"] = true;
}

?>