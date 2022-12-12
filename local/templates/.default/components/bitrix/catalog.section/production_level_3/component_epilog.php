<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Context;

$request = Context::getCurrent()->getRequest();

if ($request->get('AJAX_PAGE') && $request->isAjaxRequest()) {

    $content = ob_get_contents();
    ob_end_clean();

    $APPLICATION->RestartBuffer();

    list(, $content_html) = explode('<!--RestartBuffer-->', $content);

    echo $content_html;

    die();
}

if ($request->get('AJAX_BRAND') && $request->isAjaxRequest()) {

    $content = ob_get_contents();
    ob_end_clean();

    $APPLICATION->RestartBuffer();

    list(, $content_html) = explode('<!--RESTARTBUFFER-->', $content);

    echo $content_html;

    die();
}