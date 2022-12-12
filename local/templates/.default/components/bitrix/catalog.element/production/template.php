<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);
?>    <div class="inner-page">
        <div class="container">
            <div class="inner-page__wrap card-detail">
                <a href="<?= $arResult['SECTION']['SECTION_PAGE_URL'] ?>" class="back-button">
                    <span class="back-button__arrow"></span>
                    <span>Обратно</span>
                </a>
                <div class="card-detail__top">
                    <div class="container-inner">
                        <h1 class="card-detail__title inner-subtitle inner-subtitle_with-margin">
                            <!--<?= $arResult['SECTION']['NAME'] ?>--> <?= $arResult['NAME'] ?>
                            <?= $arResult['PROPERTIES']['SUB_TITLE']['VALUE'] !== '' ? ' . ' . $arResult['PROPERTIES']['SUB_TITLE']['VALUE'] : '' ?>
                        </h1>
                    </div>
                </div>
                <div class="card-detail__content text-block container-inner container-inner_min">
                    <?= $arResult['DETAIL_TEXT'] ?>
                </div>
                <div class="card-detail__block container-inner bordered-item">
                    <? $colorCount = count(array_keys($arResult['PROPERTIES']['COLOR']['VALUE'])); ?>
                    <? if ($colorCount): ?>
                        <span class="card-detail__count">
                            <?= $colorCount; ?> цветов<?= textEnd($colorCount, 1); ?> решен<?= textEnd($colorCount,
                                2); ?>
                        </span>
                    <? endif; ?>
                    <div class="card-detail__subwrap">
                        <div class="card-detail__left">
                            <div class="card-detail__loop">
                                <svg>
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/loop.svg#loop"></use>
                                </svg>
                            </div>
                            <? if ($arResult['PROPERTIES']['DETAIL_SLIDER']['VALUE']): ?>
                                <? foreach ($arResult['PROPERTIES']['DETAIL_SLIDER']['VALUE'] as $key => $color): ?>
                                    <div class="card-detail__image ajax__image<?= $key == 0 ? ' isActive' : ''; ?>"
                                         data-id="<?= $arResult['PROPERTIES']['DETAIL_SLIDER']['DESCRIPTION'][$key] ?>">
                                        <a href="<?= CFile::GetPath($color) ?>" class="fb"
                                           data-title="<?= $arResult['NAME'] ?>" data-type="image">
                                            <img src="<?= CFile::GetPath($color) ?>"
                                                 alt="<?= $arResult['NAME'] ?>">
                                        </a>
                                    </div>
                                <? endforeach; ?>
                            <? else: ?>
                                <div class="card-detail__image">
                                    <a href="<?= $arResult['PREVIEW_PICTURE']['SRC'] ?>" class="fb"
                                       data-title="<?= $arResult['NAME'] ?>" data-type="image">
                                        <img src="<?= $arResult['PREVIEW_PICTURE']['SRC'] ?>"
                                             alt="<?= $arResult['NAME'] ?>">
                                    </a>
                                </div>
                            <? endif; ?>
                            <? if ($arResult['PROPERTIES']['PRICE']['VALUE']): ?>
							<p>Цена:</p>
                                <div class="card-detail__price">
                                    <span class="price"><?= is_numeric($arResult['PROPERTIES']['PRICE']['VALUE'])
                                            ? $arResult['PROPERTIES']['PRICE']['VALUE'] . ' ₽'
                                            : $arResult['PROPERTIES']['PRICE']['VALUE'] ?></span>
                                </div>
                            <? endif; ?>
                        </div>
                        <? if ($arResult['PROPERTIES']['PROPS']['VALUE']) { ?>
                            <div class="card-detail__right">
                                <? foreach ($arResult['PROPERTIES']['PROPS']['VALUE'] as $key => $arProps) { ?>
                                    <div class="card-detail__row">
                                        <div class="card-detail__prop"><?= $arProps ?></div>
                                        <div class="card-detail__prop card-detail__prop_value"><?= $arResult['PROPERTIES']['PROPS']['DESCRIPTION'][$key] ?></div>
                                    </div>
                                <? } ?>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
            <? if ($arResult['PROPERTIES']['COLOR']['VALUE']) { ?>
                <div class="items-slider">
                    <div class="container container-inner">

                        <div class="items-slider__title"><?= $arResult['PROPERTIES']['COLOR']['HIGHLOAD'][$arResult['PROPERTIES']['COLOR']['VALUE'][0]] ?></div>
                        <div class="items-slider__body">
                            <div class="items-slider__wrap">
                                <? foreach ($arResult['PROPERTIES']['COLOR']['VALUE'] as $key => $color) { ?>
                                    <? $color = substr($color, 0, 1) == '#' ? $color : '#' . $color ?>
                                    <? $color = substr($color, 1, 2) == '#' ? substr($color, 1) : $color ?>
                                    <div class="items-slider__item<?= $color == '#ffffff' ? ' items-slider__item_white' : '' ?> ajax__color<?= $key == 0 ? ' isActive' : ''?>"
                                         style='fill: <?= $color ?>;'
                                         data-id="<?= $key+1 ?>"
                                         data-name="<?= $arResult['PROPERTIES']['COLOR']['HIGHLOAD'][$color] ?>">
                                        <svg>
                                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/catalog-icons.svg#color-drop"></use>
                                        </svg>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>

<div class="images-slider">
    <div class="container">
        <div class="images-slider__wrap">
            <div class="images-slider__body">
                <div class="container-inner">
                    <div class="slider-small-arrows slider-small-arrows_min">
                        <div class="slider-control slider-left slider-left_images-slider" >
                        </div>
                        <div class="slider-control slider-right slider-right_images-slider" >
                        </div>
                    </div>
                    <div class="images-slider__wrapper swiper-container">
                        <div class="swiper-wrapper">

                            <? if ($arResult['PROPERTIES']['DETAIL_SLIDER']['VALUE']): ?>
                                <? foreach ($arResult['PROPERTIES']['DETAIL_SLIDER']['VALUE'] as $key => $color): ?>
                                    <div class="images-slider__item swiper-slide">
                                        <a href="<?= CFile::GetPath($color) ?>" class="fb"
                                           data-title="<?= $arResult['NAME'] ?>" data-type="image">
                                            <img src="<?= CFile::GetPath($color) ?>"
                                                 alt="<?= $arResult['NAME'] ?>">
                                        </a>
                                    </div>
                                <? endforeach; ?>
                            <? endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="get-payment">
        <div class="container">
            <div class="get-payment__wrap">
                <div class="get-payment__button big-button jsOpenPopup" data-target='.jsCallbackForm'>Выполнить расчет
                </div>
            </div>
        </div>
    </div>
    <div class="props-table">
        <div class="container container-inner container-inner">
            <div class="props-table__wrap">
                <div class="props-table__tabs">
                    <? if ($arResult['PROPERTIES']['FILE_PRICE']['VALUE'] || $arResult['PROPERTIES']['FILE_SALE']['VALUE']) { ?>
                        <div class="props-table__tab jsTab classic-button classic-button_white isActive">Узнать цены
                        </div>
                    <? } ?>
                    <? if ($arResult['PROPERTIES']['GUARANTIES']['VALUE']) { ?>
                        <div class="props-table__tab jsTab classic-button classic-button_white">Гарантия</div>
                    <? } ?>
                    <? if ($arResult['PROPERTIES']['SERTIFICATS']['VALUE']) { ?>
                        <div class="props-table__tab jsTab classic-button classic-button_white">Сертификаты</div>
                    <? } ?>
                    <? if ($arResult['PROPERTIES']['FEATURES']['VALUE']) { ?>
                        <div class="props-table__tab jsTab classic-button classic-button_white">Преимущества</div>
                    <? } ?>
                    <? foreach ($arResult['PROPERTIES']['MULTI_TABS']['DESCRIPTION'] as $tabs): ?>
                        <div class="props-table__tab jsTab classic-button classic-button_white"><?= $tabs ?></div>
                    <? endforeach; ?>
                </div>
                <div class="props-table__body isActive">
                    <? if ($arResult['PROPERTIES']['FILE_PRICE']['VALUE'] || $arResult['PROPERTIES']['FILE_SALE']['VALUE']) { ?>
                        <div class="props-table__list price-tab isActive">
                            <div class="price-tab__title inner-subtitle inner-subtitle_with-margin">
                                Узнать цены
                            </div>
                            <div class="price-tab__wrap">
                                <a href="<?= CFile::GetPath($arResult['PROPERTIES']['FILE_PRICE']['VALUE']) ?>"
                                   target="_blank" class="price-tab__item">
                                    <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/pricelist.png" alt="Прайс">
                                    <span class="price-tab__name">
                                    <span>Скачать</span>
                                    <span><?= $arResult['PROPERTIES']['FILE_PRICE']['DESCRIPTION'] ?></span>
                                </span>
                                </a>
                                <a href="<?= CFile::GetPath($arResult['PROPERTIES']['FILE_SALE']['VALUE']) ?>"
                                   target="_blank" class="price-tab__item">
                                    <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/coupon.png" alt="Купон">
                                    <span class="price-tab__name">
                                    <span>Скачать</span>
                                    <span><?= $arResult['PROPERTIES']['FILE_SALE']['DESCRIPTION'] ?></span>
                                </span>
                                </a>
                            </div>
                        </div>
                    <? } ?>
                    <? if ($arResult['PROPERTIES']['GARANT_SERT']['VALUE']) { ?>
                        <div class="props-table__list guarantee-tab">
                            <div class="inner-subtitle inner-subtitle_with-margin">Гарантия</div>
                            <?= htmlspecialchars_decode($arResult['PROPERTIES']['GUARANTIES']['VALUE']['TEXT']) ?>
                            <div class="props-table__links">
                                <? foreach ($arResult['PROPERTIES']['GARANT_SERT']['VALUE'] as $key => $arProps) { ?>
                                    <a href="<?= CFile::GetPath($arProps) ?>" target="_blank" class="props-table__link">
                                    <span class='props-table__icon'>
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/downloadicon.png" alt="">
                                    </span>
                                        <span>
                                        <span class="recolor">Скачать</span>
                                        <span class="download-value"><?= $arResult['PROPERTIES']['GARANT_SERT']['DESCRIPTION'][$key] ?></span>
                                    </span>
                                    </a>
                                <? } ?>
                            </div>
                        </div>
                    <? } ?>
                    <? if ($arResult['PROPERTIES']['SERTIFICATS']['VALUE']) { ?>
                        <div class="props-table__list sertificate-tab">
                            <div class="inner-subtitle inner-subtitle_with-margin">Сертификаты</div>
                            <div class="props-table__sertificates">
                                <? foreach ($arResult['PROPERTIES']['SERTIFICATS']['VALUE'] as $key => $arProps) { ?>
                                    <div class="props-table__sertificate">
                                        <div class="props-table__image">
                                            <a href="<?= CFile::GetPath($arProps) ?>" class="fb"
                                               data-title="Сертификат"
                                               data-description="Описание" data-type="image">
                                                <img src="<?= CFile::GetPath($arProps) ?>"
                                                     alt="<?= $arResult['PROPERTIES']['SERTIFICATS']['DESCRIPTION'][$key] ?>">
                                            </a>
                                        </div>
                                        <div class="props-table__sertificate-name">
                                            <?= $arResult['PROPERTIES']['SERTIFICATS']['DESCRIPTION'][$key] ?>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    <? } ?>
                    <? if ($arResult['PROPERTIES']['FEATURES']['VALUE']) { ?>
                        <div class="props-table__list advantages-tab">
                            <div class="inner-subtitle inner-subtitle_with-margin">
                                Преимущества
                            </div>
                            <? foreach ($arResult['PROPERTIES']['FEATURES']['VALUE'] as $key => $arProps) { ?>
                                <div class="props-table__item">
                                    <div class="props-table__name">
                                        <?= $arResult['PROPERTIES']['FEATURES']['DESCRIPTION'][$key] ?>
                                    </div>
                                    <ul class="props-table__desc">
                                        <li><?= $arProps['TEXT'] ?></li>
                                    </ul>
                                </div>
                            <? } ?>
                        </div>
                    <? } ?>
                    <? foreach ($arResult['PROPERTIES']['MULTI_TABS']['DESCRIPTION'] as $key => $tabs): ?>
                        <div class="props-table__list<? $key === 0 ? ' isActive' : '' ?>">
                            <div class="price-tab__title inner-subtitle inner-subtitle_with-margin"><?= $tabs ?></div>
                            <div class="props-table__item">
                                <? /*<div class="props-table__name"></div> */ ?>
                                <?= $arResult['PROPERTIES']['MULTI_TABS']['~VALUE'][$key]['TEXT'] ?>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>

 <?   $APPLICATION->IncludeComponent(
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
    );
?>