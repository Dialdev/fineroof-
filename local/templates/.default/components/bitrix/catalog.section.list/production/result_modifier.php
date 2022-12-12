<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

unset($arResult['SECTIONS']);

$arSort = ['DEPTH_LEVEL' => 'ASC', 'SORT' => 'ASC'];
$arFilter = [
    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
    'ACTIVE' => 'Y',//обязательно
    'GLOBAL_ACTIVE' => 'Y'//обязательно
];
$arSelect = ['*', 'UF_SVG'];

$res = CIBlockSection::GetList(
    $arSort,
    $arFilter,
    array('CNT_ACTIVE' => 'Y', 'ELEMENT_SUBSECTIONS' => 'Y'),//показ колличества файлов
    $arSelect
);

$sectionLinc = [];
$section['SECTIONS'] = [];
$sectionLinc[0] = &$section['SECTIONS'];

while($arSection = $res->GetNext(false, false)) {
    $arSection['UF_SVG'] = htmlspecialchars_decode($arSection['UF_SVG']);
    $arSection['DESCRIPTION'] = htmlspecialchars_decode($arSection['DESCRIPTION']);
    $sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']] = $arSection;
    $sectionLinc[$arSection['ID']] = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
}
unset($sectionLinc);

$arResult['SECTION_COUNT'] = count($section['SECTIONS']['CHILD']);

$subSect = 0;
$subSectNum = 0;

foreach ($section['SECTIONS']['CHILD'] as $key => $sect) {
    if ($subSectNum % 3 == 0){
        $subSect++;
    }
    $arResult['SECTIONS'][$subSect][$key] = $sect;
    $subSectNum++;
}
