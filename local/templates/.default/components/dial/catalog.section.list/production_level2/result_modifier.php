<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

foreach ($arResult['SECTIONS'] as $key => &$arSect) {

    $res = CIBlockElement::GetList(['PROPERTY_PRICE' => 'ASC'], ['IBLOCK_SECTION_ID' => $arSect['ID']],false, ['nTopCount' => 1], ['*', 'PROPERTY_PRICE'])->Fetch();

    $arSect['ELEMENT_PRICE'] = $res['PROPERTY_PRICE_VALUE'];
}