<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Highloadblock as HL;

foreach ($arResult['ITEMS'] as $key => $arItem) {
    if ($arItem['~IBLOCK_SECTION_ID'] !== $arResult['ID']) {
        unset($arResult['ITEMS'][$key]);
    }
}

foreach ($arResult['ITEMS'] as $arItem) {

    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arItem['ID']], ['PROPERTY_BRAND']);

    while ($arRes = $res->Fetch()) {
        if ($arRes['PROPERTY_BRAND_VALUE']) {
            $arBrandsXML[] = $arRes['PROPERTY_BRAND_VALUE'];
        }
    }
}

$hlblock = HL\HighloadBlockTable::getById(1)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entityClass = 'BrandsTable';
$res = $entityClass::getList([
    'select' => ['*'],
    'order'  => ['UF_NAME' => 'ASC'],
    'filter' => ['ID' => $arBrandsXML]
]);

while ($arRes = $res->Fetch()) {
    $arResult['UF_BRAND'][$arRes['UF_XML_ID']] = $arRes;
}

if (isset($arResult[$arParams['SECTION_USER_FIELDS']])) {
    sort($arResult["UF_BRAND"]);
}