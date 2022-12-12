<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

try {
    $res = \Bitrix\Iblock\SectionTable::getList([
        'select' => ['ID', 'NAME', 'DESCRIPTION'],
        'filter' => ['IBLOCK_ID' => 5],
        'order' => ['SORT' => 'ASC']
    ]);
} catch (\Bitrix\Main\ObjectPropertyException $e) {
} catch (\Bitrix\Main\ArgumentException $e) {
} catch (\Bitrix\Main\SystemException $e) {
}

while ($arRes = $res->fetch()) {
    $arResult['SECTIONS'][] = $arRes;
}