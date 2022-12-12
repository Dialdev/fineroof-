<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<div class="inner-title">
    <div class="container">
        <div class="inner-title__wrap inner-title__wrap_no-border inner-title__wrap_catalog-page">
            <div class="inner-title__services custom-title custom-title_inner custom-title_full-house">
                <? $titleDom = $APPLICATION->GetTitle() . '' ?>
                <? $titleDomLast = substr($titleDom, -2, 2); ?>
                <h1 class="title"><?= substr($titleDom, 0, -2); ?><span>
                        <?= $titleDomLast ?>
                        <svg class="custom-title__svg">
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/icons.svg#full-house"></use>
                        </svg>
                    </span>
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="inner-page">
    <div class="container">
        <? $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "production",
            array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
                "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
                "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
                "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
                "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
                "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
            ),
            false,
            array("HIDE_ICONS" => "Y")
        );
        ?>
    </div>
</div>
