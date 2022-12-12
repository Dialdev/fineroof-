<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

unset($arResult['ITEMS']);

$arFilter = [
    'ACTIVE'        => 'Y',
    'IBLOCK_ID'     => $arParams['IBLOCK_ID'],
    'GLOBAL_ACTIVE' => 'Y',
];

$arSelect = ['*'];

$arOrder = ['SORT' => 'ASC', 'ID' => 'ASC'];

$rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);

$sectionLinc = [];

while ($arSection = $rsSections->GetNext(false, false))
{
    $sectionLinc[$arSection['ID']] = $arSection;

    $rsElem = CIBlockElement::GetList($arOrder, ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'IBLOCK_SECTION_ID' => $arSection['ID']]);

    while ($arElem = $rsElem->GetNext(false, false))
    {
        $props = CIBlockElement::GetProperty($arElem['IBLOCK_ID'], $arElem['ID']);
        $props1 = CIBlockElement::GetProperty($arElem['IBLOCK_ID'], $arElem['ID']);

        $propVal = [];
        while ($arProps = $props->GetNext(true, false)) {
            if(isset($arProps['VALUE'])){
                if ($arProps['MULTIPLE'] == 'Y') {
                    $propVal[$arProps['CODE']]['VALUE'][] = $arProps['VALUE'];
                } else {
                    $propVal[$arProps['CODE']]['VALUE'] = $arProps['VALUE'];
                }
            }
            $propVal[$arProps['CODE']]['DESCRIPTION'][] = $arProps['DESCRIPTION'];
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
                $arElem['PROPERTIES'][$arProps1['CODE']] = array_merge($propCode[$arProps1['CODE']], $propVal[$arProps1['CODE']]);
            }
        }

        $sectionLinc[$arElem['IBLOCK_SECTION_ID']]['ITEMS'][$arElem['ID']] = $arElem;
    }
}
$arResult['SECTIONS'] = $sectionLinc;
unset($sectionLinc);