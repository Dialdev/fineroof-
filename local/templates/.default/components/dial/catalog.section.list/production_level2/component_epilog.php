<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!empty($arResult['SECTION']['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'])) {
    $APPLICATION->SetTitle($arResult['SECTION']['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']);
}

if (!empty($arResult['SECTION']['IPROPERTY_VALUES']['SECTION_META_DESCRIPTION'])) {
    $APPLICATION->SetPageProperty('description', $arResult['SECTION']['IPROPERTY_VALUES']['SECTION_META_DESCRIPTION']);
}

if (!empty($arResult['SECTION']['IPROPERTY_VALUES']['SECTION_META_TITLE'])) {
    $APPLICATION->SetPageProperty('title', $arResult['SECTION']['IPROPERTY_VALUES']['SECTION_META_TITLE']);
}


if (isset($_GET['AJAX_PAGE'])) {

    $content = ob_get_contents();
    ob_end_clean();

    $APPLICATION->RestartBuffer();

    list(, $content_html) = explode('<!--RestartBuffer-->', $content);

    echo $content_html;

    die();
}

if (isset($_GET['AJAX_BRAND'])) {

    $content = ob_get_contents();
    ob_end_clean();

    $APPLICATION->RestartBuffer();

    list(, $content_html) = explode('<!--RESTARTBUFFER-->', $content);

    echo $content_html;

    die();
}