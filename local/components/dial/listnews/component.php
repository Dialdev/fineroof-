<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule("iblock")) {
    ShowError("Модуль Информационных блоков не установлен");
    return;
}

if(!isset($arParams["CACHE_TIME"]))
    $arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
if(strlen($arParams["IBLOCK_TYPE"])<=0)
    $arParams["IBLOCK_TYPE"] = "catalog";
$arParams["IBLOCK_ID"] = trim($arParams["IBLOCK_ID"]);

if(!is_array($arParams["PROPERTY_CODE2"]))
    $arParams["PROPERTY_CODE2"] = array();
foreach($arParams["PROPERTY_CODE2"] as $key=>$val)
    if($val==="")
        unset($arParams["PROPERTY_CODE2"][$key]);

/*************************************************************************
 * Start caching
 *************************************************************************/
if($this->startResultCache())
{
    if (stristr($arParams["PROPERTY_CODE"], 'UF')) {
        $resElem = CIBlockSection::GetList(
            ['SORT' => 'ASC'],
            ['ID' => $arParams['ITEM_ID'], 'IBLOCK_ID' => $arParams["IBLOCK_ID"]],
            false,
            ['ID', 'NAME', 'CODE', 'IBLOCK_ID', 'UF_*']
        )->fetch();

        if ($resElem[$arParams["PROPERTY_CODE"]][0]) {
            $propElems = CIBlockElement::GetList(
                [array_keys($sectionLinc[$arParams["PROPERTY_CODE"]]["VALUE"]) => 'DESC'],
                ['ID'        => $resElem[$arParams["PROPERTY_CODE"]],
                 'IBLOCK_ID' => $arParams["IBLOCK_ID"],
                 '!ID'       => $arParams['ID']
                ],
                0,
                0,
                ['ID', 'IBLOCK_ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE']
            );
            unset($resElem[$arParams["PROPERTY_CODE"]]);

            while ($arElem = $propElems->GetNext(true, false)) {
                $arElem['PREVIEW_PICTURE'] = CFile::GetFileArray($arElem['PREVIEW_PICTURE']);

                $props = CIBlockElement::GetProperty($arElem['IBLOCK_ID'], $arElem['ID']);
                $props1 = CIBlockElement::GetProperty($arElem['IBLOCK_ID'], $arElem['ID']);

                $propVal = [];
                while ($arProps = $props->GetNext(true, false)) {
                    if (in_array($arProps['CODE'], $arParams["PROPERTY_CODE2"])) {
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
                }

                while ($arProps1 = $props1->GetNext(true, false)) {
                    if (in_array($arProps1['CODE'], $arParams["PROPERTY_CODE2"])) {
                        if ($arProps1['VALUE']) {
                            $propCode[$arProps1['CODE']]['ID'] = $arProps1['ID'];
                            $propCode[$arProps1['CODE']]['NAME'] = $arProps1['NAME'];
                            $propCode[$arProps1['CODE']]['CODE'] = $arProps1['CODE'];
                            $propCode[$arProps1['CODE']]['MULTIPLE'] = $arProps1['MULTIPLE'];
                            $propCode[$arProps1['CODE']]['VALUE'] = $arProps1['VALUE'];
                            $propCode[$arProps1['CODE']]['DESCRIPTION'] = $arProps1['DESCRIPTION'];
                            $arElem['PROPERTIES'][$arProps1['CODE']] = array_merge($propCode[$arProps1['CODE']],
                                $propVal[$arProps1['CODE']]);
                        }
                    }
                }

                $sectionTemplate = CIBlockSection::GetList(
                    ['SORT' => 'ASC'],
                    ['ID' => $arElem['IBLOCK_SECTION_ID'], 'IBLOCK_ID' => $arElem["IBLOCK_ID"]],
                    false,
                    ['ID', 'NAME', 'CODE', 'IBLOCK_ID', 'UF_TEMPLATE', 'SECTION_PAGE_URL']
                )->GetNext(false, false);

                $arElem["UF_TEMPLATE"] = $sectionTemplate["UF_TEMPLATE"];
                $arElem["SECTION_PAGE_URL"] = $sectionTemplate["SECTION_PAGE_URL"];

                $sectionLinc[] = $arElem;
            }

            $arResult['ITEMS'] = $sectionLinc;
        }
    } elseif($arParams['ITEM_ID']) {
        $resElem = CIBlockElement::GetList(
            ['SORT' => 'ASC'],
            ['ID' => $arParams['ITEM_ID'], 'IBLOCK_ID' => $arParams["IBLOCK_ID"]],
            false,
            false,
            ['ID', 'NAME', 'CODE', 'IBLOCK_ID', 'PROPERTY_*']
        )->fetch();

        $props = CIBlockElement::GetProperty($resElem['IBLOCK_ID'], $resElem['ID']);

        while ($arProp = $props->GetNext(true, false)) {
            if ($arProp['CODE'] == $arParams["PROPERTY_CODE"])
                $sectionLinc[$arParams["PROPERTY_CODE"]]["VALUE"][] = $arProp["VALUE"];
        }

        if ($sectionLinc[$arParams["PROPERTY_CODE"]]["VALUE"][0]) {
            $propElems = CIBlockElement::GetList(
                [array_keys($sectionLinc[$arParams["PROPERTY_CODE"]]["VALUE"]) => 'DESC'],
                ['ID'        => $sectionLinc[$arParams["PROPERTY_CODE"]]["VALUE"],
                 'IBLOCK_ID' => $arParams["IBLOCK_ID"],
                 '!ID'       => $arParams['ID']
                ],
                0,
                0,
                ['ID', 'IBLOCK_ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE']
            );
            unset($sectionLinc[$arParams["PROPERTY_CODE"]]);

            while ($arElem = $propElems->GetNext(true, false)) {
                $arElem['PREVIEW_PICTURE'] = CFile::GetFileArray($arElem['PREVIEW_PICTURE']);

                $props = CIBlockElement::GetProperty($arElem['IBLOCK_ID'], $arElem['ID']);
                $props1 = CIBlockElement::GetProperty($arElem['IBLOCK_ID'], $arElem['ID']);

                $propVal = [];
                while ($arProps = $props->GetNext(true, false)) {
                    if (in_array($arProps['CODE'], $arParams["PROPERTY_CODE2"])) {
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
                }

                while ($arProps1 = $props1->GetNext(true, false)) {
                    if (in_array($arProps1['CODE'], $arParams["PROPERTY_CODE2"])) {
                        if ($arProps1['VALUE']) {
                            $propCode[$arProps1['CODE']]['ID'] = $arProps1['ID'];
                            $propCode[$arProps1['CODE']]['NAME'] = $arProps1['NAME'];
                            $propCode[$arProps1['CODE']]['CODE'] = $arProps1['CODE'];
                            $propCode[$arProps1['CODE']]['MULTIPLE'] = $arProps1['MULTIPLE'];
                            $propCode[$arProps1['CODE']]['VALUE'] = $arProps1['VALUE'];
                            $propCode[$arProps1['CODE']]['DESCRIPTION'] = $arProps1['DESCRIPTION'];
                            $arElem['PROPERTIES'][$arProps1['CODE']] = array_merge($propCode[$arProps1['CODE']],
                                $propVal[$arProps1['CODE']]);
                        }
                    }
                }

                $sectionTemplate = CIBlockSection::GetList(
                    ['SORT' => 'ASC'],
                    ['ID' => $arElem['IBLOCK_SECTION_ID'], 'IBLOCK_ID' => $arParams["IBLOCK_ID"]],
                    false,
                    ['ID', 'NAME', 'CODE', 'IBLOCK_ID', 'UF_TEMPLATE', 'SECTION_PAGE_URL']
                )->GetNext(false, false);

                $arElem['UF_TEMPLATE'] = $sectionTemplate["UF_TEMPLATE"];
                $arElem['SECTION_PAGE_URL'] = $sectionTemplate["SECTION_PAGE_URL"];

                $sectionLinc[] = $arElem;
            }

            $arResult['ITEMS'] = $sectionLinc;
        }
    }

    unset($sectionLinc);

    $this->setResultCacheKeys([
        "PROPERTIES",
    ]);

    $this->IncludeComponentTemplate();
}