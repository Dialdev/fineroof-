<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Highloadblock as HL;

$resElem = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    ['ID' => $arResult['ID'], '!PROPERTY_RECOMENDATION_ITEM' => false],
    0,
    0,
    ['ID', 'NAME', 'CODE', 'IBLOCK_ID', 'PROPERTY_RECOMENDATION_ITEM']
)->Fetch();

$props = CIBlockElement::GetProperty($resElem['IBLOCK_ID'], $resElem['ID']);

while ($arProp = $props->GetNext(true, false)) {
    if ($arProp['CODE'] == 'RECOMENDATION_ITEM') {
        $sectionLinc['RECOMENDATION_ITEM']["VALUE"][] = $arProp["VALUE"];
    }
}


$propElems = CIBlockElement::GetList(
    [array_keys($sectionLinc['RECOMENDATION_ITEM']["VALUE"]) => 'DESC'],
    ['ID' => $sectionLinc['RECOMENDATION_ITEM']["VALUE"], '!ID' => $arResult['ID']],
    0,
    0,
    ['ID', 'IBLOCK_ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE']
);
unset($sectionLinc['RECOMENDATION_ITEM']);

while ($arElem = $propElems->GetNext(true, false)) {
    $arElem['PREVIEW_PICTURE'] = CFile::GetFileArray($arElem['PREVIEW_PICTURE']);

    $props = CIBlockElement::GetProperty($arElem['IBLOCK_ID'], $arElem['ID']);
    $props1 = CIBlockElement::GetProperty($arElem['IBLOCK_ID'], $arElem['ID']);

    $propVal = [];
    while ($arProps = $props->GetNext(true, false)) {
        if ($arProps['VALUE']) {
            if ($arProps['MULTIPLE'] == 'Y') {
                $propVal[$arProps['CODE']]['VALUE'][] = $arProps['VALUE'];
            } else {
                $propVal[$arProps['CODE']]['VALUE'] = $arProps['VALUE'];
            }
        }
        if ($arProps['DESCRIPTION']) {
            $propVal[$arProps['CODE']]['DESCRIPTION'][] = $arProps['DESCRIPTION'];
        }
    }

    while ($arProps1 = $props1->GetNext(true, false)) {
        if ($arProps1['VALUE']) {
            $propCode[$arProps1['CODE']]['ID'] = $arProps1['ID'];
            $propCode[$arProps1['CODE']]['NAME'] = $arProps1['NAME'];
            $propCode[$arProps1['CODE']]['CODE'] = $arProps1['CODE'];
            $propCode[$arProps1['CODE']]['PROPERTY_TYPE'] = $arProps1['PROPERTY_TYPE'];
            $propCode[$arProps1['CODE']]['MULTIPLE'] = $arProps1['MULTIPLE'];
            $propCode[$arProps1['CODE']]['VALUE'] = $arProps1['VALUE'];
            $propCode[$arProps1['CODE']]['DESCRIPTION'] = $arProps1['DESCRIPTION'];
            $arElem['PROPERTIES'][$arProps1['CODE']] = array_merge($propCode[$arProps1['CODE']],
                $propVal[$arProps1['CODE']]);
        }
    }

    $sectionLinc[] = $arElem;
}

$arResult['PROPERTIES']['RECOMENDATION_ITEM']['VALUE_ITEM'] = $sectionLinc;

unset($sectionLinc);


$hlblock = HL\HighloadBlockTable::getById(2)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entityClass = 'ColorTable';
$res = $entityClass::getList([
    'select' => ['*'],
    'filter' => ['UF_XML_ID' => $arResult['PROPERTIES']['COLOR']['VALUE']]
]);

while ($arRes = $res->Fetch()) {
    $arResult['PROPERTIES']['COLOR']['HIGHLOAD'][$arRes['UF_XML_ID']] = $arRes['UF_DESCRIPTION'] ? $arRes['UF_DESCRIPTION'] : $arRes['UF_NAME'];
}

if (isset($arResult[$arParams['SECTION_USER_FIELDS']])) {
    sort($arResult["UF_BRAND"]);
}