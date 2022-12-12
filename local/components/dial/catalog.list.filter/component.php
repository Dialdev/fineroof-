<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

use Bitrix\Highloadblock as HL;
use Bitrix\Iblock;
use Bitrix\Main\Loader;

/*************************************************************************
Processing of received parameters
 *************************************************************************/
if(!isset($arParams["CACHE_TIME"]))
    $arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);
$arParams["SECTION_ID"] = intval($arParams["SECTION_ID"]);
$arParams["SECTION_CODE"] = trim($arParams["SECTION_CODE"]);

$arParams["SECTION_URL"]=trim($arParams["SECTION_URL"]);

$arParams["TOP_DEPTH"] = intval($arParams["TOP_DEPTH"]);
if($arParams["TOP_DEPTH"] <= 0)
    $arParams["TOP_DEPTH"] = 2;
$arParams["COUNT_ELEMENTS"] = $arParams["COUNT_ELEMENTS"]!="N";
$arParams["ADD_SECTIONS_CHAIN"] = $arParams["ADD_SECTIONS_CHAIN"]!="N"; //Turn on by default

$arResult["SECTIONS"]=array();

/*************************************************************************
Work with cache
 *************************************************************************/
if($this->startResultCache(false, ($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups())))
{
    if(!Loader::includeModule("iblock"))
    {
        $this->abortResultCache();
        ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
        return;
    }

    $existIblock = Iblock\IblockSiteTable::getList(array(
        'select' => array('IBLOCK_ID'),
        'filter' => array('=IBLOCK_ID' => $arParams['IBLOCK_ID'], '=SITE_ID' => SITE_ID, '=IBLOCK.ACTIVE' => 'Y')
    ))->fetch();
    if (empty($existIblock))
    {
        $this->abortResultCache();
        return;
    }

    $arFilter = array(
        "ACTIVE" => "Y",
        "GLOBAL_ACTIVE" => "Y",
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "CNT_ACTIVE" => "Y",
    );

    $arSelect = array();
    if(array_key_exists("SECTION_FIELDS", $arParams) && !empty($arParams["SECTION_FIELDS"]) && is_array($arParams["SECTION_FIELDS"]))
    {
        foreach($arParams["SECTION_FIELDS"] as &$field)
        {
            if (!empty($field) && is_string($field))
                $arSelect[] = $field;
        }
        if (isset($field))
            unset($field);
    }

    if(!empty($arSelect))
    {
        $arSelect[] = "ID";
        $arSelect[] = "NAME";
        $arSelect[] = "LEFT_MARGIN";
        $arSelect[] = "RIGHT_MARGIN";
        $arSelect[] = "DEPTH_LEVEL";
        $arSelect[] = "IBLOCK_ID";
        $arSelect[] = "IBLOCK_SECTION_ID";
        $arSelect[] = "LIST_PAGE_URL";
        $arSelect[] = "SECTION_PAGE_URL";
    }
    $boolPicture = empty($arSelect) || in_array('PICTURE', $arSelect);

    if(!empty($arParams["SECTION_USER_FIELDS"]))
    {
        if(is_string($arParams["SECTION_USER_FIELDS"]) && preg_match("/^UF_/", $arParams["SECTION_USER_FIELDS"]))
            $arSelect[] = $arParams["SECTION_USER_FIELDS"];
    }

    $arResult["SECTION"] = false;
    $intSectionDepth = 0;
    if($arParams["SECTION_ID"]>0)
    {
        $arFilter["ID"] = $arParams["SECTION_ID"];
        $rsSections = CIBlockSection::GetList(array(), $arFilter, $arParams["COUNT_ELEMENTS"], $arSelect);
        $rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
        $arResult["SECTION"] = $rsSections->GetNext();
    }
    elseif('' != $arParams["SECTION_CODE"])
    {
        $arFilter["=CODE"] = $arParams["SECTION_CODE"];
        $rsSections = CIBlockSection::GetList(array(), $arFilter, $arParams["COUNT_ELEMENTS"], $arSelect);
        $rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
        $arResult["SECTION"] = $rsSections->GetNext();
    }

    if(is_array($arResult["SECTION"]))
    {
        unset($arFilter["ID"]);
        unset($arFilter["=CODE"]);
        $arFilter["LEFT_MARGIN"]=$arResult["SECTION"]["LEFT_MARGIN"]+1;
        $arFilter["RIGHT_MARGIN"]=$arResult["SECTION"]["RIGHT_MARGIN"];
        $arFilter["<="."DEPTH_LEVEL"]=$arResult["SECTION"]["DEPTH_LEVEL"] + $arParams["TOP_DEPTH"];

        $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arResult["SECTION"]["IBLOCK_ID"], $arResult["SECTION"]["ID"]);
        $arResult["SECTION"]["IPROPERTY_VALUES"] = $ipropValues->getValues();

        $arResult["SECTION"]["PATH"] = array();
        $rsPath = CIBlockSection::GetNavChain(
            $arResult["SECTION"]["IBLOCK_ID"],
            $arResult["SECTION"]["ID"],
            array(
                "ID", "CODE", "XML_ID", "EXTERNAL_ID", "IBLOCK_ID",
                "IBLOCK_SECTION_ID", "SORT", "NAME", "ACTIVE",
                "DEPTH_LEVEL", "SECTION_PAGE_URL"
            )
        );
        $rsPath->SetUrlTemplates("", $arParams["SECTION_URL"]);
        while($arPath = $rsPath->GetNext())
        {
            if ($arParams["ADD_SECTIONS_CHAIN"])
            {
                $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"], $arPath["ID"]);
                $arPath["IPROPERTY_VALUES"] = $ipropValues->getValues();
            }
            $arResult["SECTION"]["PATH"][]=$arPath;
        }
    }
    else
    {
        $arResult["SECTION"] = array("ID"=>0, "DEPTH_LEVEL"=>0);
        $arFilter["<="."DEPTH_LEVEL"] = $arParams["TOP_DEPTH"];
    }
    $intSectionDepth = $arResult["SECTION"]['DEPTH_LEVEL'];

    if ($this->arParams['FILTER_NAME'] && $this->arParams['FILTER_VALUE']) {
        unset($arFilter["ID"]);
        unset($arFilter["=CODE"]);
        $arFilter[$this->arParams['FILTER_NAME']] = $this->arParams['FILTER_VALUE'];
        $arSelect[] = "UF_*";
    }

    //ORDER BY
    $arSort = array(
        "left_margin"=>"asc",
    );
    //EXECUTE
    $rsSections = CIBlockSection::GetList($arSort, $arFilter, $arParams["COUNT_ELEMENTS"], $arSelect, ['nTopCount' => 1]);
    $rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
    while($arSection = $rsSections->GetNext())
    {
        \Bitrix\Iblock\InheritedProperty\SectionValues::queue($arSection["IBLOCK_ID"], $arSection["ID"]);

        $arSection['RELATIVE_DEPTH_LEVEL'] = $arSection['DEPTH_LEVEL'] - $intSectionDepth;

        $arButtons = CIBlock::GetPanelButtons(
            $arSection["IBLOCK_ID"],
            0,
            $arSection["ID"],
            array("SESSID"=>false, "CATALOG"=>true)
        );
        $arSection["EDIT_LINK"] = $arButtons["edit"]["edit_section"]["ACTION_URL"];
        $arSection["DELETE_LINK"] = $arButtons["edit"]["delete_section"]["ACTION_URL"];


        foreach ($arSection as $key => $item) {
            if ($key == $arParams['SECTION_USER_FIELDS']) {
                $hlblock = HL\HighloadBlockTable::getById(1)->fetch();
                $entity = HL\HighloadBlockTable::compileEntity($hlblock);
                $entityClass = 'BrandsTable';
                $res = $entityClass::getList([
                    'select' => ['*'],
                    'order'  => ['UF_NAME' => 'ASC'],
                    'filter' => ['ID' => $arSection[$arParams['SECTION_USER_FIELDS']]]
                ])->fetch();

                if ($res) {
                    $arSection[$arParams['SECTION_USER_FIELDS']] = $res;
                } else {
                    unset($arSection[$arParams['SECTION_USER_FIELDS']]);
                }
            }
        }

        $arResult["SECTIONS"][]=$arSection;
    }

    $hlblock = HL\HighloadBlockTable::getById(1)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entityClass = 'BrandsTable';
    $res = $entityClass::getList([
        'select' => ['*'],
        'order'  => ['UF_NAME' => 'ASC'],
        'filter' => []
    ]);

    while ($arRes = $res->Fetch()) {
        $arResult[$arParams['SECTION_USER_FIELDS']][$arRes['ID']] = $arRes;
    }

    if (isset($arResult[$arParams['SECTION_USER_FIELDS']])) {
        sort($arResult[$arParams['SECTION_USER_FIELDS']]);
    }
    foreach ($arResult["SECTIONS"] as &$arSection)
    {
        $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arSection["IBLOCK_ID"], $arSection["ID"]);
        $arSection["IPROPERTY_VALUES"] = $ipropValues->getValues();

        if ($boolPicture)
        {
            \Bitrix\Iblock\Component\Tools::getFieldImageData(
                $arSection,
                array('PICTURE'),
                \Bitrix\Iblock\Component\Tools::IPROPERTY_ENTITY_SECTION,
                'IPROPERTY_VALUES'
            );
        }
    }
    unset($arSection);

    $arResult["SECTIONS_COUNT"] = count($arResult["SECTIONS"]);

    $this->includeComponentTemplate();
}