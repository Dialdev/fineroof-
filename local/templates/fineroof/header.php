<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
IncludeTemplateLangFile(__FILE__);

use Bitrix\Main\Config\Option;
use Bitrix\Main\Page\Asset;

/**
 * @clearPhone - ф-я очистки телефона от ненужныъ символов;
 */

$email = Option::get("grain.customsettings", "email");
$city = Option::get("grain.customsettings", "city");
$street = Option::get("grain.customsettings", "street");
$phoneVolgograd = Option::get("grain.customsettings", "phoneVolgograd");
$phone2 = Option::get("grain.customsettings", "phone2");
?><!DOCTYPE html>
<html lang="<?= LANGUAGE_ID ?>">
<head>
    <title><? $APPLICATION->ShowTitle() ?></title>

    <?
    //STRING
    $APPLICATION->ShowHead();
    Asset::getInstance()->addString('<meta charset="' . LANG_CHARSET . '">');
    Asset::getInstance()->addString('<meta http-equiv="X-UA-Compatible" content="IE=Edge">');
    Asset::getInstance()->addString('<meta http-equiv="msthemecompatible" content="no">');
    Asset::getInstance()->addString('<meta http-equiv="Cache-Control" content="no-cache">');
    Asset::getInstance()->addString('<meta http-equiv="cleartype" content="on">');
    Asset::getInstance()->addString('<meta name="viewport" content="width=device-width, initial-scale=1">');
    Asset::getInstance()->addString('<meta name="theme-color" content="#54e3ea">');
    Asset::getInstance()->addString('<meta name="HandheldFriendly" content="True">');
    Asset::getInstance()->addString('<meta name="apple-mobile-web-app-capable" content="yes">');
    Asset::getInstance()->addString('<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">');
    Asset::getInstance()->addString('<link rel="icon" type="image/png" sizes="128x128" href="https://fineroof.ru/favicon.png" />');

    //CSS
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/template/css/normalize.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/template/css/style.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/template/css/swiper.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/template/css/glightbox.min.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/template/css/svg-base.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/template/css/custom.css');
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/template/fancybox/jquery.fancybox.min.css');

    //JS
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/libs/jquery-3.3.1.min.js');
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/libs/jquery.cookie.js');
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/libs/jquery.cookie.min.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/libs/anime.min.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/libs/svg4everybody.min.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/libs/picturefill.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/libs/swiper.min.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/libs/glightbox.min.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/libs/yandex-maps.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/js/vivus.min.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/js/utils.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/js/script.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/js/svg-animate.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/js/catalog.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/js/upload.js');
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/template/fancybox/jquery.fancybox.min.js');
    Asset::getInstance()->addJs('//cdn.callibri.ru/callibri.js');
    ?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-85366898-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-85366898-4');
</script>

<meta name="yandex-verification" content="21ba5ab442bd7fb9" />

</head>

<body class="animated">
<? $APPLICATION->ShowPanel() ?>
<div class="overlay-shadow"></div>
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="header__wrap">
                <? if ($APPLICATION->GetCurPage(false) != SITE_DIR): ?>
                <a href="/" class="header__logo">
                    <? else: ?>
                    <div class="header__logo">
                        <? endif; ?>
                        <svg class="hover-check" viewBox="5 7 50 48">
                            <g class='hover-animation hover-animation_mini-forward'>
                                <path d="M48.73142,48.49357h6.45755v5.21091    h-6.43222v6.77587h-5.92736v-19.5982h13.0938v5.73978h-7.19177V48.49357z"/>
                            </g>
                            <g class='hover-animation hover-animation_mini-back'>
                                <path d="M48.73142,48.49357h6.45755v5.21091    h-6.43222v6.77587h-5.92736v-19.5982h13.0938v5.73978h-7.19177V48.49357z"/>
                            </g>
                            <g>
                                <path d="M30.50591,7.44455l-0.01562,0.0266    l-0.04644-0.07431L5.27271,21.80719v34.60947h49.78791V21.59819L30.50591,7.44455z M10.07743,50.62703V25.20511l20.32589-11.6622    l19.85301,11.41141v25.67272H10.07743z"/>
                            </g>
                        </svg>
                        <? if ($APPLICATION->GetCurPage(false) != SITE_DIR): ?>
                </a>
                <? else: ?>
            </div>
            <? endif; ?>
            <div class="header__contacts">
                <!-- <div class="header__right header-recall-button jsOpenPopup" data-target=".jsRecall"> -->
                <div class="header__right header-recall-button jsOpenPopup" data-target=".jsCallbackForm">
                    <!--data-target=".jsRecallForm" -->
                    <span class="header__item green-text callibri_phone"><?= $phoneVolgograd; ?></span>
                    <!--href="tel:--><? /*= clearPhone($phoneVolgograd);" */ ?>
                    <span class="header-callback green-text">
                        Заказать звонок
                    </span>
                </div>
            </div>
            <div class="header__contacts_mobile">
                <div class="header__right header-recall-button">
                    <!--data-target=".jsRecallForm" -->
                    <a href="tel:<?= clearPhone($phoneVolgograd); ?>" class="header__item green-text callibri_phone"><?= $phoneVolgograd; ?></a>

                    <span class="header-callback green-text jsOpenPopup" data-target=".jsRecall">
                        Заказать звонок
                    </span>
                </div>
            </div>
            <div class="header__center">
                <? /*<div class="header__contacts">
                            <div class="header__left">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/eliplse1.png" alt="">
                            </div>
                            <div class="header__right">
                                <span class="green-text"><?= str_replace(['<br>', '</br>', '<br/>'], '</span><span class="green-text">', $city) ?></span>
                            </div>
                        </div>*/ ?>
                <div class="header__contacts header__contacts_mobile">
                    <div class="header__left">
                        <? /*<img src="<?= SITE_TEMPLATE_PATH ?>/template/img/eliplse1.png" alt=""> */ ?>
                        <svg viewBox="0 0 824.000000 1280.000000">
                            <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)">
                                <path d="M3939 12537 c-636 -851 -1205 -1731 -1834 -2837 -319 -562 -488 -874
                                    -701 -1300 -747 -1494 -1248 -2881 -1381 -3820 -24 -173 -24 -550 1 -750 63
                                    -523 212 -1008 457 -1490 228 -450 505 -828 870 -1185 797 -780 1820 -1182
                                    2934 -1152 597 16 1109 139 1620 390 391 192 702 415 1026 737 345 343 608
                                    708 833 1157 352 703 529 1559 461 2221 -119 1148 -832 3048 -1780 4746 -482
                                    863 -1041 1772 -1508 2451 -256 372 -767 1072 -796 1089 -3 2 -95 -113 -202
                                    -257z"/>
                            </g>
                        </svg>
                    </div>
                    <div class="header__right">
						<a href="https://yandex.ru/maps/38/volgograd/house/ulitsa_karla_libknekhta_8/YE0Ycg9oSkQOQFpifXtyc3RmZg==/?ll=44.488355%2C48.732941&z=16.6" target="blanc"><span class="green-text">Россия, <?= str_replace(['<br>', '</br>', '<br/>'], '</span><span class="green-text">', $street) ?></span></a>
                    </div>
                </div>
            </div>
            <div class="header__contacts">
                <div class="header__right">
                    <a href="tel:<?= clearPhone($phone2); ?>" class="header__item green-text __hard-style callibri_phone">
                        <?= $phone2; ?>
                    </a>
                </div>
            </div>
            <div class="header__search">
                <span class="header-icon header-search header-search__toggle">
                    <span class="icon-search">
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.4688 14.5688L11.7875 10.8875C12.7 9.775 13.25 8.35 13.25 6.79688C13.25 3.23438 10.3594 0.34375 6.79688 0.34375C3.23125 0.34375 0.34375 3.23438 0.34375 6.79688C0.34375 10.3594 3.23125 13.25 6.79688 13.25C8.35 13.25 9.77187 12.7031 10.8844 11.7906L14.5656 15.4688C14.8156 15.7188 15.2188 15.7188 15.4688 15.4688C15.7188 15.2219 15.7188 14.8156 15.4688 14.5688ZM6.79688 11.9656C3.94375 11.9656 1.625 9.64688 1.625 6.79688C1.625 3.94688 3.94375 1.625 6.79688 1.625C9.64688 1.625 11.9688 3.94688 11.9688 6.79688C11.9688 9.64688 9.64688 11.9656 6.79688 11.9656Z"/>
                        </svg>
                    </span>
                </span>
            </div>
            <div class="header__map">
                <svg id="mainPin" class="animating jsAnimate" viewBox="-5 -5 65 65">
                    <mask id='mask-3' x='0' y='0' width='60' height='60'>
                        <path id='animatedPin' class='animated-stroke' fill='transparent' stroke='#fff' stroke-width='3.85' stroke-linecap='both' d="M23.66,50.26c-1.14,1.69-2.13,3.07-2.85,4C16.74,49,3.87,29,3.87,20.81A16.91,16.91,0,0,1,31.15,7.42h5.57A20.8,20.8,0,0,0,0,20.81c0,6,5.05,15.84,9.28,23,2.84,4.81,5.3,8.42,6.52,10.15,3.39,4.8,4,5,5,5s1.62-.21,5-5c.58-.83,1.46-2.1,2.52-3.71Z"/>
                    </mask>
                    <clipPath id="clip3">
                        <use xlink:href="#animatedPin"/>
                    </clipPath>
                    <image class='hover-animation_background' width="100%" height="100%" xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/background.png" clip-path="url(#clip3)" mask='url(#mask-3)' x="0" y="0"></image>
                </svg>
                <a href="/contacts/" class="header__button classic-button">На карте</a>
            </div>
            <button type="button" class="header__mobile">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
    </div>
    <div class="header__bottom">
        <div class="container">
            <div class="header__wrap header__wrap_column">
                <nav class="header__navigation navigation">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "main_menu",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "top",
                            "USE_EXT" => "N"
                        )
                    ); ?>
                </nav>
                
    <div class="header__fixed fixed-menu">
        <div class="container">
            <div class="fixed-menu__wrap">
                <? if ($APPLICATION->GetCurPage(false) != SITE_DIR): ?>
                <a href="/" class="header__logo fixed-menu__logo">
                    <? else: ?>
                    <div class="header__logo fixed-menu__logo">
                        <? endif; ?>
                        <svg class="hover-check" viewBox="5 8 50 48">
                            <g>
                                <path d="M30.50591,7.44455l-0.01562,0.0266    l-0.04644-0.07431L5.27271,21.80719v34.60947h49.78791V21.59819L30.50591,7.44455z M10.07743,50.62703V25.20511l20.32589-11.6622    l19.85301,11.41141v25.67272H10.07743z"/>
                            </g>
                            <g class='hover-animation hover-animation_mini-forward'>
                                <path d="M48.73142,48.49357h6.45755v5.21091    h-6.43222v6.77587h-5.92736v-19.5982h13.0938v5.73978h-7.19177V48.49357z"/>
                            </g>
                            <g class='hover-animation hover-animation_mini-back'>
                                <path d="M48.73142,48.49357h6.45755v5.21091    h-6.43222v6.77587h-5.92736v-19.5982h13.0938v5.73978h-7.19177V48.49357z"/>
                            </g>
                        </svg>
                        <? if ($APPLICATION->GetCurPage(false) != SITE_DIR): ?>
                </a>
                <? else: ?>
            </div>
            <? endif; ?>
            <div class="fixed-menu__center">
                <div class="fixed-menu__contacts header__contacts header__contacts_mobile">
                    <!--<div class="header__right">
                        <a href="tel:<?/*= clearPhone($phoneVolgograd); */?>"
                           class="header__item green-text"><?/*= $phoneVolgograd; */?></a>
                        <span>Бесплатный звонок</span>
                    </div>-->
                    <div class="header__contacts">
                        <div class="header__right header-recall-button jsOpenPopup" data-target=".jsRecall">
                            <!--data-target=".jsRecallForm" -->
                            <span class="header__item green-text callibri_phone"><?= $phoneVolgograd; ?></span>
                            <!--href="tel:--><? /*= clearPhone($phoneVolgograd);" */ ?>
                            <span class="header-callback green-text">
                                Заказать звонок
                            </span>
                        </div>
                    </div>
                    <div class="header__contacts_mobile">
                        <div class="header__right header-recall-button">
                            <!--data-target=".jsRecallForm" -->
                            <a href="tel:<?= clearPhone($phoneVolgograd);?>" class="header__item green-text callibri_phone"><?= $phoneVolgograd; ?></a>
                            <span class="header-callback green-text jsOpenPopup" data-target=".jsRecall">
                                Заказать звонок
                            </span>
                        </div>
                    </div>
                    <div class="header__search">
                        <span class="header-icon header-search header-search__toggle">
                            <span class="icon-search">
                                <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.4688 14.5688L11.7875 10.8875C12.7 9.775 13.25 8.35 13.25 6.79688C13.25 3.23438 10.3594 0.34375 6.79688 0.34375C3.23125 0.34375 0.34375 3.23438 0.34375 6.79688C0.34375 10.3594 3.23125 13.25 6.79688 13.25C8.35 13.25 9.77187 12.7031 10.8844 11.7906L14.5656 15.4688C14.8156 15.7188 15.2188 15.7188 15.4688 15.4688C15.7188 15.2219 15.7188 14.8156 15.4688 14.5688ZM6.79688 11.9656C3.94375 11.9656 1.625 9.64688 1.625 6.79688C1.625 3.94688 3.94375 1.625 6.79688 1.625C9.64688 1.625 11.9688 3.94688 11.9688 6.79688C11.9688 9.64688 9.64688 11.9656 6.79688 11.9656Z"/>
                                </svg>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="fixed-menu__navigation">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "fixed_menu",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "top",
                            "USE_EXT" => "N"
                        )
                    ); ?>
                </div>
            </div>
            <button type="button" class="header__mobile">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
        <div class="search__wrap">
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:search.title",
                "site_img",
                array(
                    "CATEGORY_0" => array(
                        0 => "iblock_catalog",
                    ),
                    "CATEGORY_0_TITLE" => "Каталог товаров",
                    "CHECK_DATES" => "N",
                    "CONTAINER_ID" => "title-search-fixed",
                    "CONVERT_CURRENCY" => "Y",
                    "INPUT_ID" => "title-search-input-fixed",
                    "NUM_CATEGORIES" => "1",
                    "ORDER" => "rank",
                    "PAGE" => "#SITE_DIR#search/index.php",
                    "PREVIEW_HEIGHT" => "75",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "PREVIEW_WIDTH" => "75",
                    "PRICE_CODE" => array(),
                    "PRICE_VAT_INCLUDE" => "Y",
                    "SHOW_INPUT" => "Y",
                    "SHOW_OTHERS" => "N",
                    "SHOW_PREVIEW" => "Y",
                    "TOP_COUNT" => "10",
                    "USE_LANGUAGE_GUESS" => "Y",
                    "COMPONENT_TEMPLATE" => "site_img",
                    "CATEGORY_0_iblock_catalog" => array(
                        0 => "1",
                    ),
                    "CURRENCY_ID" => "RUB",
                    "CATEGORY_OTHERS_TITLE" => "Прочие товары"
                ),
                false
            ); ?>
        </div>
    </div>
    </div>
    <div class="search__wrap">
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:search.title",
            "site_img",
            array(
                "CATEGORY_0" => array(
                    0 => "iblock_catalog",
                ),
                "CATEGORY_0_TITLE" => "Каталог товаров",
                "CHECK_DATES" => "N",
                "CONTAINER_ID" => "title-search",
                "CONVERT_CURRENCY" => "Y",
                "INPUT_ID" => "title-search-input",
                "NUM_CATEGORIES" => "1",
                "ORDER" => "rank",
                "PAGE" => "#SITE_DIR#search/index.php",
                "PREVIEW_HEIGHT" => "75",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PREVIEW_WIDTH" => "75",
                "PRICE_CODE" => array(),
                "PRICE_VAT_INCLUDE" => "Y",
                "SHOW_INPUT" => "Y",
                "SHOW_OTHERS" => "N",
                "SHOW_PREVIEW" => "Y",
                "TOP_COUNT" => "10",
                "USE_LANGUAGE_GUESS" => "Y",
                "COMPONENT_TEMPLATE" => "site_img",
                "CATEGORY_0_iblock_catalog" => array(
                    0 => "1",
                ),
                "CURRENCY_ID" => "RUB",
                "CATEGORY_OTHERS_TITLE" => "Прочие товары"
            ),
            false
        ); ?>
    </div>
</header>

<script type="application/ld+json">
    {
        "@conte xt": "http://schema.org",
        "@type": "Organization",
        "url": "",
        "logo": ""
    }


</script>

<? ### сделал так для того что бы умельцы не редактировали главную через редактор эрмитаж ### ?>
<? if ($APPLICATION->GetCurPage(false) == '/') { ?>
<main class="main">

      
    <div class="container">
        <div class="after-menu">
            <div class="logo-bottom"><img src="/include/img/logo-01.svg"></div>
            <ul class="flex-list">
            <li>Предоставляем широкий спектр строительных материалов для наружной отделки в Волжском и Волгограде</li>
            <li>Сервис, доставка, монтаж, качественная консультация</li>
            </ul>
        </div>
    </div>
    <div class="index-slider">
        <? $APPLICATION->IncludeComponent(
            "bitrix:news.line",
            "index_top_slider",
            Array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "300000",
                "CACHE_TYPE" => "A",
                "DETAIL_URL" => "",
                "FIELD_CODE" => array("NAME", "DETAIL_PICTURE", "PREVIEW_PICTURE", "PROPERTY_LINK"),
                "IBLOCKS" => array("2"),
                "IBLOCK_TYPE" => "content",
                "NEWS_COUNT" => "10",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "ACTIVE_FROM",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "DESC"
            )
        ); ?>
    </div>
    <div class="catalog-slider">
        <div class="container_big container">
            <div class="catalog-slider__pattern">
                <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/pattern.svg#pattern" alt="">
            </div>
            <div class="catalog-slider__wrap">
                <div class="catalog-slider__title custom-title custom-title_no-border custom-title_with-lane custom-title_full-house index-title__last-svg">
                    <span>Просто.</span>
                    <span>Со вкусом.</span>
                    <span>Для ва
                            <span>
                                с.
                                <svg class="custom-title__svg _index">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/icons.svg#full-house"></use>
                                </svg>
                            </span>
                        </span>
                </div>

                <? $APPLICATION->IncludeComponent(
                    "bitrix:news.line",
                    "index_two_slider",
                    Array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "300000",
                        "CACHE_TYPE" => "A",
                        "DETAIL_URL" => "",
                        "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "PROPERTY_LINK"),
                        "IBLOCKS" => array("6"),
                        "IBLOCK_TYPE" => "content",
                        "NEWS_COUNT" => "10",
                        "SORT_BY1" => "SORT",
                        "SORT_BY2" => "ACTIVE_FROM",
                        "SORT_ORDER1" => "ASC",
                        "SORT_ORDER2" => "DESC"
                    )
                ); ?>
            </div>
        </div>
    </div>
    <div class="catalog">
        <div class="container container_full">
            <div class="catalog__svg catalog__svg_worker" style="-webkit-transform: translateX(-700px);-moz-transform: translateX(-700px);-ms-transform: translateX(-700px);-o-transform: translateX(-700px);transform: translateX(-700px);">
                <svg>
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/icons.svg#worker1-play"></use>
                </svg>
            </div>
            <div class="catalog__wrap">
                <a href="/catalog/" class="catalog__title custom-title custom-title_with-border custom-title_not-full-house custom-title_center">
                    <span>Каталог</span>
                    <span>
							Продукции
							<svg class="custom-title__svg">
								<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/icons.svg#corner-house"></use>
							</svg>
						</span>
                </a>
                <div class="catalog__svg catalog__svg_hammer" style="-webkit-transform: translateX(700px);-moz-transform: translateX(700px);-ms-transform: translateX(700px);-o-transform: translateX(700px);transform: translateX(700px);">
                    <svg>
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/icons.svg#hammer-play"></use>
                    </svg>
                </div>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "index_catalog",
                    Array(
                        "ADD_SECTIONS_CHAIN" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "COUNT_ELEMENTS" => "Y",
                        "IBLOCK_ID" => "1",
                        "IBLOCK_TYPE" => "catalog",
                        "SECTION_CODE" => "",
                        "SECTION_FIELDS" => array("", ""),
                        "SECTION_ID" => $_REQUEST["SECTION_ID"],
                        "SECTION_URL" => "/catalog/#SECTION_CODE_PATH#/",
                        "SECTION_USER_FIELDS" => array("UF_SVG", ""),
                        "SHOW_PARENT_NAME" => "Y",
                        "TOP_DEPTH" => "1",
                        "VIEW_MODE" => "LINE"
                    )
                ); ?>
            </div>
        </div>
    </div>
    <div class="content-block">
        <div class="container">
            <div class="content-block__wrap">
                <div class="content-block__images image-block">
                    <img id="mainFormObject" src="<?= SITE_TEMPLATE_PATH ?>/template/img/background5.png" alt="">
                </div>
                <div class="content-block__body">
                    <? $APPLICATION->IncludeFile("/local/includes/main_text.php", false, array('SHOW_BORDER' => true, 'WORKFLOW ' => false, 'MODE' => 'html'), array('HIDE_ICONS' => 'Y')); ?>

                    <? } elseif (CSite::InDir('/catalog/') || CSite::InDir('/services/') || CSite::InDir('/news/') || CSite::InDir('/gallery/') || CSite::InDir('/contacts/')) { ?>

                    <main class="main">

                            <div class="breadcrumbs">
                                <div class="container">
                                    <? $APPLICATION->IncludeComponent(
                                        "bitrix:breadcrumb",
                                        "breadcrumbs",
                                        Array(
                                            "PATH" => "",
                                            "SITE_ID" => "s1",
                                            "START_FROM" => "0"
                                        )
                                    ); ?>
                                </div>
                            </div>
                        <?/* if ($APPLICATION->GetCurPage(false) != '/catalog/' && $APPLICATION->GetCurPage(false) != '/services/') { ?>
                            <div class="breadcrumbs">
                                <div class="container">
                                    <? $APPLICATION->IncludeComponent(
                                        "bitrix:breadcrumb",
                                        "breadcrumbs",
                                        Array(
                                            "PATH" => "",
                                            "SITE_ID" => "s1",
                                            "START_FROM" => "0"
                                        )
                                    ); ?>
                                </div>
                            </div>
                        <? } */?>

                        <? } else { ?>

                        <main class="main">
                            <?
                            if ($APPLICATION->GetCurPage(false) != '/services/'
                                && ($APPLICATION->GetCurPage(false) != '/gallery/')
                                && ($APPLICATION->GetCurPage(false) != '/news/')
                                && ($APPLICATION->GetCurPage(false) != '/contacts/')) {
                                ?>
                                <div class="inner-title">
                                    <div class="container">
                                        <div class="inner-title__wrap">
                                            <div class="inner-title__services custom-title custom-title_inner custom-title_no-border custom-title_with-lane custom-title_full-house">
                                                <h1 class="title"><?= $APPLICATION->ShowTitle(false); ?></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <? } ?>
                            <?
                            if ($APPLICATION->GetCurPage(false) != '/gallery/') {
                            if ($APPLICATION->GetCurPage(false) == '/services/') {
                                echo '<div class="inner-services content-block content-block_inner">';
                            } else {
                                echo '<div class="inner-page">';
                            }
                            ?>
                            <div class="container">
                                <? } ?>

                                <? } ?>