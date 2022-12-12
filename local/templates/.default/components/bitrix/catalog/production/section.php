<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);


/**
 * Берем текущий раздел и дастаем его свойства
 */
$res = CIBlockSection::GetList(
    ['SORT' => 'ASC'],
    [
        'IBLOCK_ID' => 1,
        'CODE'      => $arResult['VARIABLES']['SECTION_CODE']
    ],
    false,
    [
        '*',
        'UF_*'
    ])->Fetch();

/**
 * Применяем шаблон тот который выбран в админке или ставин production_level_1 если пусто
 */
$template = $res['UF_TEMPLATE'] == '' ? 'production_level_1' : 'production_level_' . $res['UF_TEMPLATE'];

if ($res['DEPTH_LEVEL'] != 1) {
    $res2 = CIBlockSection::GetList(
        ['SORT' => 'ASC'],
        [
            'IBLOCK_ID'  => 1,
            'ID' => $res['IBLOCK_SECTION_ID']
        ])->Fetch();
}

/**
 * Таким способом решил найти конечный раздел что бы выводить только каталог сектион лист иначе каталог сектион
 */
$maxDepth = CIBlockSection::GetList(
    ['SORT' => 'ASC'],
    [
        'IBLOCK_ID'  => 1,
        'SECTION_ID' => $res['ID'],
        'UF_SECTION_ELEMENT' => false,
    ],true)->Fetch();


?><? if (stripos($arResult['VARIABLES']['SECTION_CODE_PATH'], 'fasadnye-materialy') !== false): ?>

    <? $titleIco = '<svg class="title__svg-catalog"><use xlink:href="' . SITE_TEMPLATE_PATH . '/template/img/catalog-icons.svg#catalog7"></use></svg>'; ?>
    <? $titleName = 'ФАСАД'; ?>

<? elseif (stripos($arResult['VARIABLES']['SECTION_CODE_PATH'], 'skatnye-krovli') !== false): ?>

    <? $titleIco = '<svg class="title__svg-catalog"><use xlink:href="' . SITE_TEMPLATE_PATH . '/template/img/catalog-icons.svg#catalog6"></use></svg>'; ?>
    <? $titleName = 'КРОВЛЯ'; ?>

<? elseif (stripos($arResult['VARIABLES']['SECTION_CODE_PATH'], 'izolyatsionnye-materialy') !== false): ?>

    <? $titleIco = '<svg class="title__svg-catalog"><use xlink:href="' . SITE_TEMPLATE_PATH . '/template/img/catalog-icons.svg#catalog2"></use></svg>'; ?>
    <? $titleName = 'ИЗОЛЯЦИЯ'; ?>

<? elseif (stripos($arResult['VARIABLES']['SECTION_CODE_PATH'], 'vodostok') !== false): ?>

    <? $titleIco = '<svg class="title__svg-catalog"><use xlink:href="' . SITE_TEMPLATE_PATH . '/template/img/catalog-icons.svg#catalog1"></use></svg>'; ?>
    <? $titleName = 'ВОДОСТОК'; ?>

<? elseif (stripos($arResult['VARIABLES']['SECTION_CODE_PATH'], 'mansardnye-okna') !== false): ?>

    <? $titleIco = '<svg class="title__svg-catalog"><use xlink:href="' . SITE_TEMPLATE_PATH . '/template/img/catalog-icons.svg#catalog4"></use></svg>'; ?>
    <? $titleName = 'МАНСАРДНЫЕ ОКНА'; ?>

<? elseif (stripos($arResult['VARIABLES']['SECTION_CODE_PATH'], 'ograzhdeniya') !== false): ?>

    <? $titleIco = '<svg class="title__svg-catalog"><use xlink:href="' . SITE_TEMPLATE_PATH . '/template/img/catalog-icons.svg#catalog5"></use></svg>'; ?>
    <? $titleName = 'ЗАБОР'; ?>

<? elseif (stripos($arResult['VARIABLES']['SECTION_CODE_PATH'], 'krovelnye-aksessuary') !== false): ?>

    <? $titleIco = '<svg class="title__svg-catalog"><use xlink:href="' . SITE_TEMPLATE_PATH . '/template/img/catalog-icons.svg#catalog3"></use></svg>'; ?>
    <? $titleName = 'КОМПЛЕКТУЮЩИЕ'; ?>

<? elseif (stripos($arResult['VARIABLES']['SECTION_CODE_PATH'], 'cherdachnye-lestnitsy') !== false): ?>

    <? $titleIco = '<svg class="title__svg-catalog"><use xlink:href="' . SITE_TEMPLATE_PATH . '/template/img/catalog-icons.svg#catalog8"></use></svg>'; ?>
    <? $titleName = 'ЧЕРДАЧНЫЕ ЛЕСТНИЦЫ'; ?>

<? endif; ?>

    <div class="inner-title">
        <div class="container">
            <div class="inner-title__wrap">
                <div class="inner-title__services custom-title custom-title_inner custom-title_full-house">
                   
                    <? if ($res['DEPTH_LEVEL'] == 1 && $res['ID'] != 23): ?>
                        <? $titleDom = trim($titleName) ?>
                        <? $titleDomLast = substr($titleDom, -2); ?>
                        <h1 class="title"><?= substr($titleDom, 0, -2); ?><span>
                                <?= $titleDomLast ?>
                                <svg class="custom-title__svg">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/icons.svg#full-house"></use>
                                </svg>
                            </span>
                        </h1>
                    <? else: ?>
                        <h1 class="title"><?$APPLICATION->ShowTitle(false);?></h1>
                        
                        <?/* $titleDom = trim($titleName) ?>
                        <? $titleDomLast = substr($titleDom, -2); ?>
                        <span class="title"><?= substr($titleDom, 0, -2); ?><span>
                                <?= $titleDomLast*/ ?>
                      <!--           <svg class="custom-title__svg">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/icons.svg#full-house"></use>
                                </svg>
                            </span>
                        </span> -->
                    <? endif; ?>
                </div>
                <?= $titleIco; ?>
            </div>
        </div>
    </div>
    <style>
        .title__svg-catalog {
            position: absolute;
            display: block;
            right: 0;
            bottom: -20px;
            width: 200px;
            height: 170px;
        }
    </style>
<?
if ($maxDepth) {
    if ($_REQUEST['brand']) {
        $brand = 'brand';
    } else {
        $brand = '';
    }
    $intSectionID = $APPLICATION->IncludeComponent(
        "dial:catalog.section.list",
        "production_level2",
        [
            "ADD_SECTIONS_CHAIN"  => "Y",
            "CACHE_GROUPS"        => "Y",
            "CACHE_TIME"          => "36000000",
            "CACHE_TYPE"          => "A",
            "COUNT_ELEMENTS"      => "Y",
            "IBLOCK_ID"           => "1",
            "IBLOCK_TYPE"         => "catalog",
            "SECTION_ID"          => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_CODE"        => $arResult["VARIABLES"]["SECTION_CODE"],
            "SECTION_FIELDS"      => [
                0 => "",
                1 => "",
            ],
            "SECTION_URL"         => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
            "SECTION_USER_FIELDS" => "UF_BRAND",
            "SHOW_PARENT_NAME"    => "Y",
            "TOP_DEPTH"           => "1",
            "VIEW_MODE"           => "LINE",
            "COMPONENT_TEMPLATE"  => "production_level2",
            "REQUEST_USER_FIELDS" => $brand
        ],
        false
    );
/*
    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section.list",
        "production_level2",
        [
            "IBLOCK_TYPE"         => "catalog",
            "IBLOCK_ID"           => "1",
            "SECTION_ID"          => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_CODE"        => $arResult["VARIABLES"]["SECTION_CODE"],
            "CACHE_TYPE"          => "A",
            "CACHE_TIME"          => $arParams["CACHE_TIME"],
            "CACHE_GROUPS"        => "N",
            "COUNT_ELEMENTS"      => "Y",
            "TOP_DEPTH"           => "1",
            "SECTION_URL"         => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
            "VIEW_MODE"           => $arParams["SECTIONS_VIEW_MODE"],
            "SHOW_PARENT_NAME"    => $arParams["SECTIONS_SHOW_PARENT_NAME"],
            "HIDE_SECTION_NAME"   => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
            "ADD_SECTIONS_CHAIN"  => "Y",
            "COMPONENT_TEMPLATE"  => "production_level2",
            "SECTION_FIELDS"      => [
                0 => "",
                1 => "",
            ],
            "SECTION_USER_FIELDS" => [
                0 => "UF_SVG",
                1 => "UF_SUB_TITLE",
                2 => "UF_PRICE",
                3 => "UF_TEMPLATE",
                4 => "UF_FUTURES",
                5 => "UF_SERTIFICATES",
                6 => "UF_FILES_GUARANT",
                7 => "UF_GUARANTIES",
                8 => "UF_SALE_FILE",
                9 => "UF_PRICE_LIST",
            ]
        ],
        false
    );*/
} else { ?>

    <?
    $GLOBALS['arrFilter'] = [
        'PROPERTY_BRAND' => $_REQUEST['brand'],
    ];

    $intSectionID = $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        $template,
        [
            "IBLOCK_TYPE"               => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID"                 => $arParams["IBLOCK_ID"],
            "ELEMENT_SORT_FIELD"        => "PROPERTY_BRAND",
            "ELEMENT_SORT_ORDER"        => "ASC",
            "ELEMENT_SORT_FIELD2"       => $arParams["ELEMENT_SORT_FIELD2"],
            "ELEMENT_SORT_ORDER2"       => $arParams["ELEMENT_SORT_ORDER2"],
            "PROPERTY_CODE"             => $arParams["LIST_PROPERTY_CODE"],
            "PROPERTY_CODE_MOBILE"      => $arParams["LIST_PROPERTY_CODE_MOBILE"],
            "META_KEYWORDS"             => $arParams["LIST_META_KEYWORDS"],
            "META_DESCRIPTION"          => $arParams["LIST_META_DESCRIPTION"],
            "BROWSER_TITLE"             => $arParams["LIST_BROWSER_TITLE"],
            "SET_LAST_MODIFIED"         => $arParams["SET_LAST_MODIFIED"],
            "INCLUDE_SUBSECTIONS"       => $arParams["INCLUDE_SUBSECTIONS"],
            "BASKET_URL"                => $arParams["BASKET_URL"],
            "ACTION_VARIABLE"           => $arParams["ACTION_VARIABLE"],
            "PRODUCT_ID_VARIABLE"       => $arParams["PRODUCT_ID_VARIABLE"],
            "SECTION_ID_VARIABLE"       => $arParams["SECTION_ID_VARIABLE"],
            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
            "PRODUCT_PROPS_VARIABLE"    => $arParams["PRODUCT_PROPS_VARIABLE"],
            "CACHE_TYPE"                => $arParams["CACHE_TYPE"],
            "CACHE_TIME"                => $arParams["CACHE_TIME"],
            "CACHE_FILTER"              => $arParams["CACHE_FILTER"],
            "CACHE_GROUPS"              => $arParams["CACHE_GROUPS"],
            "SET_TITLE"                 => $arParams["SET_TITLE"],
            "MESSAGE_404"               => $arParams["~MESSAGE_404"],
            "SET_STATUS_404"            => $arParams["SET_STATUS_404"],
            "SHOW_404"                  => $arParams["SHOW_404"],
            "FILE_404"                  => $arParams["FILE_404"],
            "DISPLAY_COMPARE"           => $arParams["USE_COMPARE"],
            "PAGE_ELEMENT_COUNT"        => 999,
            "LINE_ELEMENT_COUNT"        => 999,
            "PRICE_CODE"                => $arParams["~PRICE_CODE"],
            "USE_PRICE_COUNT"           => $arParams["USE_PRICE_COUNT"],
            "SHOW_PRICE_COUNT"          => $arParams["SHOW_PRICE_COUNT"],

            "PRICE_VAT_INCLUDE"          => $arParams["PRICE_VAT_INCLUDE"],
            "USE_PRODUCT_QUANTITY"       => $arParams['USE_PRODUCT_QUANTITY'],
            "ADD_PROPERTIES_TO_BASKET"   => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
            "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
            "PRODUCT_PROPERTIES"         => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

            "DISPLAY_TOP_PAGER"               => $arParams["DISPLAY_TOP_PAGER"],
            "DISPLAY_BOTTOM_PAGER"            => $arParams["DISPLAY_BOTTOM_PAGER"],
            "PAGER_TITLE"                     => $arParams["PAGER_TITLE"],
            "PAGER_SHOW_ALWAYS"               => $arParams["PAGER_SHOW_ALWAYS"],
            "PAGER_TEMPLATE"                  => $arParams["PAGER_TEMPLATE"],
            "PAGER_DESC_NUMBERING"            => $arParams["PAGER_DESC_NUMBERING"],
            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
            "PAGER_SHOW_ALL"                  => $arParams["PAGER_SHOW_ALL"],
            "PAGER_BASE_LINK_ENABLE"          => $arParams["PAGER_BASE_LINK_ENABLE"],
            "PAGER_BASE_LINK"                 => $arParams["PAGER_BASE_LINK"],
            "PAGER_PARAMS_NAME"               => $arParams["PAGER_PARAMS_NAME"],
            "LAZY_LOAD"                       => $arParams["LAZY_LOAD"],
            "MESS_BTN_LAZY_LOAD"              => $arParams["~MESS_BTN_LAZY_LOAD"],
            "LOAD_ON_SCROLL"                  => $arParams["LOAD_ON_SCROLL"],

            "OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
            "OFFERS_FIELD_CODE"      => $arParams["LIST_OFFERS_FIELD_CODE"],
            "OFFERS_PROPERTY_CODE"   => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
            "OFFERS_SORT_FIELD"      => $arParams["OFFERS_SORT_FIELD"],
            "OFFERS_SORT_ORDER"      => $arParams["OFFERS_SORT_ORDER"],
            "OFFERS_SORT_FIELD2"     => $arParams["OFFERS_SORT_FIELD2"],
            "OFFERS_SORT_ORDER2"     => $arParams["OFFERS_SORT_ORDER2"],
            "OFFERS_LIMIT"           => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

            "SECTION_ID"                => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_CODE"              => $arResult["VARIABLES"]["SECTION_CODE"],
            "SECTION_URL"               => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
            "DETAIL_URL"                => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
            "USE_MAIN_ELEMENT_SECTION"  => $arParams["USE_MAIN_ELEMENT_SECTION"],
            'CONVERT_CURRENCY'          => $arParams['CONVERT_CURRENCY'],
            'CURRENCY_ID'               => $arParams['CURRENCY_ID'],
            'HIDE_NOT_AVAILABLE'        => $arParams["HIDE_NOT_AVAILABLE"],
            'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

            'LABEL_PROP'           => $arParams['LABEL_PROP'],
            'LABEL_PROP_MOBILE'    => $arParams['LABEL_PROP_MOBILE'],
            'LABEL_PROP_POSITION'  => $arParams['LABEL_PROP_POSITION'],
            'ADD_PICT_PROP'        => $arParams['ADD_PICT_PROP'],
            'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
            'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
            'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
            'ENLARGE_PRODUCT'      => $arParams['LIST_ENLARGE_PRODUCT'],
            'ENLARGE_PROP'         => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
            'SHOW_SLIDER'          => $arParams['LIST_SHOW_SLIDER'],
            'SLIDER_INTERVAL'      => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
            'SLIDER_PROGRESS'      => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

            'OFFER_ADD_PICT_PROP'         => $arParams['OFFER_ADD_PICT_PROP'],
            'OFFER_TREE_PROPS'            => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
            'PRODUCT_SUBSCRIPTION'        => $arParams['PRODUCT_SUBSCRIPTION'],
            'SHOW_DISCOUNT_PERCENT'       => $arParams['SHOW_DISCOUNT_PERCENT'],
            'DISCOUNT_PERCENT_POSITION'   => $arParams['DISCOUNT_PERCENT_POSITION'],
            'SHOW_OLD_PRICE'              => $arParams['SHOW_OLD_PRICE'],
            'SHOW_MAX_QUANTITY'           => $arParams['SHOW_MAX_QUANTITY'],
            'MESS_SHOW_MAX_QUANTITY'      => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
            'RELATIVE_QUANTITY_FACTOR'    => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
            'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
            'MESS_RELATIVE_QUANTITY_FEW'  => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
            'MESS_BTN_BUY'                => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
            'MESS_BTN_ADD_TO_BASKET'      => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
            'MESS_BTN_SUBSCRIBE'          => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
            'MESS_BTN_DETAIL'             => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
            'MESS_NOT_AVAILABLE'          => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
            'MESS_BTN_COMPARE'            => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

            'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
            'DATA_LAYER_NAME'        => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
            'BRAND_PROPERTY'         => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

            'TEMPLATE_THEME'               => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
            "ADD_SECTIONS_CHAIN"           => "Y",
            'ADD_TO_BASKET_ACTION'         => $basketAction,
            'SHOW_CLOSE_POPUP'             => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
            'COMPARE_PATH'                 => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
            'COMPARE_NAME'                 => $arParams['COMPARE_NAME'],
            'USE_COMPARE_LIST'             => 'Y',
            'BACKGROUND_IMAGE'             => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
            'COMPATIBLE_MODE'              => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
            'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),
            "FILTER_NAME"                  => 'arrFilter',
            "USE_FILTER"                   => "Y",
        ],
        false
    );

	/*$APPLICATION->IncludeComponent(
        "dial:listnews",
        "",
        [
            "CACHE_GROUPS"   => "Y",
            "CACHE_TIME"     => "36000000",
            "CACHE_TYPE"     => "A",
            "DETAIL"         => "Y",
            "IBLOCK_ID"      => "1",
            "IBLOCK_TYPE"    => "catalog",
            "ITEM_ID"        => $intSectionID,
            "PROPERTY_CODE"  => "UF_RECOMEND",
            "PROPERTY_CODE2" => ["SUB_TITLE", ""]
        ]
);*/
}
?>