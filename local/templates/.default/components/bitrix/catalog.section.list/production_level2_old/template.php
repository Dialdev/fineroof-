<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

if ($arResult['SECTION']['DEPTH_LEVEL'] == 1) {
    $path = $arResult['SECTION']['LIST_PAGE_URL'];
} else {
    $path = $arResult['SECTION']['PATH'][0]['SECTION_PAGE_URL'];
}

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
?>

<? if ($arResult['SECTIONS'] && $arResult['SECTIONS'][0]['DEPTH_LEVEL'] == 2) { ?>
    <div class="inner-page">
        <div class="container">
            <div class="inner-page__wrap distributing-page">
                <a href="<?= $path ?>" class="back-button">
                    <span class="back-button__arrow"></span>
                    <span>Обратно</span>
                </a>
                <div class="distributing-page__wrap">
                    <? foreach ($arResult['SECTIONS'] as $key => $arSect) {
                        $this->AddEditAction($arSect['ID'], $arSect['EDIT_LINK'], $strSectionEdit);
                        $this->AddDeleteAction($arSect['ID'], $arSect['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams); ?>
                        <?= $key == 0 || $key == 2 || $key == 4 ? '<div class="distributing-page__column">' : '' ?>
                        <div class="distributing-page__item<?= $key == 0 || $key == 3 || $key == 4 ? ' distributing-page__item_big' : '' ?>" id="<? echo $this->GetEditAreaId($arSect['ID']); ?>">
                            <div class="distributing-page__svg">
                                <svg>
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/catalog-icons.svg#eye"></use>
                                </svg>
                            </div>
                            <picture class="distributing-page__image">
                                <img src="<?= $arSect['PICTURE']['SRC'] ?>" alt="">
                            </picture>
                            <div class="distributing-page__name">
                                <?= str_replace(' ', '<br>', $arSect['NAME']) ?>
                            </div>
                            <a href="<?= $arSect['SECTION_PAGE_URL'] ?>"></a>
                        </div>
                        <?= $key == 1 || $key == 3 || $key == 5 ? '</div>' : '' ?>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
    <? if (
        $arResult['SECTION']['UF_PRICE_LIST'] ||
        $arResult['SECTION']['UF_SALE_FILE'] ||
        $arResult['SECTION']['UF_GUARANTIES'] ||
        $arResult['SECTION']['UF_FILES_GUARANT'] ||
        $arResult['SECTION']['UF_SERTIFICATES'] ||
        $arResult['SECTION']['UF_FUTURES']
    ):?>
    <div class="props-table">
        <div class="container container-inner container-inner">
            <div class="props-table__wrap">
                <div class="props-table__tabs">
                    <? if ($arResult['SECTION']['UF_PRICE_LIST'] || $arResult['SECTION']['UF_SALE_FILE']):?>
                        <div class="props-table__tab jsTab classic-button classic-button_white isActive">Узнать цены</div>
                    <? endif; ?>
                    <? if ($arResult['SECTION']['UF_GUARANTIES'] || $arResult['SECTION']['UF_FILES_GUARANT']):?>
                        <div class="props-table__tab jsTab classic-button classic-button_white">Гарантия</div>
                    <? endif; ?>
                    <? if ($arResult['SECTION']['UF_SERTIFICATES']):?>
                        <div class="props-table__tab jsTab classic-button classic-button_white">Сертификаты</div>
                    <? endif; ?>
                    <? if ($arResult['SECTION']['UF_FUTURES']):?>
                        <div class="props-table__tab jsTab classic-button classic-button_white">Преимущества</div>
                    <? endif; ?>
                </div>
                <div class="props-table__body isActive">
                    <div class="props-table__list price-tab isActive">
                        <div class="price-tab__title inner-subtitle inner-subtitle_with-margin">
                            Узнать цены
                        </div>
                        <div class="price-tab__wrap">
                            <a href="<?= CFile::GetPath($arResult['SECTION']['UF_PRICE_LIST']); ?>" target="_blank" class="price-tab__item">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/pricelist.png" alt="Прайс">
                                <span class="price-tab__name">
                                    <span>Скачать</span>
                                    <span>прайс</span>
                                </span>
                            </a>
                            <a href="<?= CFile::GetPath($arResult['SECTION']['UF_SALE_FILE']); ?>" target="_blank" class="price-tab__item">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/coupon.png" alt="Купон">
                                <span class="price-tab__name">
                                    <span>Скачать</span>
                                    <span>скидочный купон</span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="props-table__list guarantee-tab">
                        <div class="inner-subtitle inner-subtitle_with-margin">Гарантия</div>
                        <?= htmlspecialchars_decode($arResult['SECTION']['UF_GUARANTIES']) ?>
                        <div class="props-table__links">
                            <? foreach ($arResult['SECTION']['UF_FILES_GUARANT'] as $arGuarant): ?>
                            <a href="<?= CFile::GetPath($arGuarant); ?>" target="_blank" class="props-table__link">
                                <span class='props-table__icon'>
                                    <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/downloadicon.png" alt="">
                                </span>
                                <span>
                                    <span class="recolor">Скачать</span>
                                    <span>гарантийный талон <span class="download-value"><?= $arResult['SECTION']['NAME'] ?></span> </span>
                                </span>
                            </a>
                            <? endforeach; ?>
                        </div>
                    </div>
                    <div class="props-table__list sertificate-tab">
                        <div class="inner-subtitle inner-subtitle_with-margin">Сертификаты</div>
                        <div class="props-table__sertificates">
                            <? foreach ($arResult['SECTION']['UF_SERTIFICATES'] as $arSert): ?>
                            <div class="props-table__sertificate">
                                <div class="props-table__image">
                                    <a href="<?= CFile::GetPath($arSert); ?>" class="fb" data-title="Сертификат" data-description="Описание" data-type="image">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/sertif.jpg" alt="Сертификат">
                                    </a>
                                </div>
                                <? /*<div class="props-table__sertificate-name">
                                    Сертификат соответствия на ендовый ковер
                                </div>*/ ?>
                            </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                    <div class="props-table__list advantages-tab">
                        <div class="inner-subtitle inner-subtitle_with-margin">
                            Преимущества
                        </div>
                        <?= $arResult['SECTION']['~UF_FUTURES'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? endif; ?>
<? } elseif ($arResult['SECTIONS'] && $arResult['SECTIONS'][0]['DEPTH_LEVEL'] > 2) { ?>
    <div class="inner-page">
        <div class="container">
            <div class="inner-page__wrap catalog-list">
                <a href="<?= $path ?>" class="back-button">
                    <span class="back-button__arrow"></span>
                    <span>Обратно</span>
                </a>
                <div class="catalog-list__detail catalog-section">
                    <div class="catalog-section__top">
                        <div class="container-inner">
                            <div class="catalog-section__wrapper catalog-section__wrapper_brands">
                                <div class="catalog-section__title inner-subtitle">
                                    <?= $arResult['SECTION']['NAME'] ?>
                                </div>
                                <div class="catalog-section__brand">
                                    <div class="catalog-section__supwrap">
                                        <form action="<?= $APPLICATION->GetCurPage(false) ?>" id="brandlist">
                                            <input type="hidden" name="brand" value="Docke-R">
                                            <div class="catalog-section__select brand-select">
                                                <div class="brand-select__left">
                                                    <div class="brand-select__position">
                                                        Docke-R
                                                    </div>
                                                    <div class="brand-select__position">
                                                        Shinglas
                                                    </div>
                                                    <div class="brand-select__position">
                                                        Docke-R
                                                    </div>
                                                </div>
                                                <div class="brand-select__right"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="catalog-section__additional">
                                        Выберите производителя
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="catalog-section__desc">
                        <div class="container-inner container-inner_min">
                            <?= $arResult['SECTION']['DESCRIPTION'] ?>
                        </div>
                    </div>

                    <div class="catalog-section__list">
                        <div class="container-inner container-inner_medium">
                            <div class="catalog-section__wrapper catalog-section__wrapper_items ajax_pagination">
                                <? foreach ($arResult['SECTIONS'] as $arItem):
                                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strSectionEdit);
                                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams); ?>
                                    <div class="catalog-section__item card-item" id="<? echo $this->GetEditAreaId($arSect['ID']); ?>">
                                        <a href="<?= $arItem['SECTION_PAGE_URL'] ?>" class="card-item__top bordered-item">
                                            <div class="card-item__image">
                                                <img src="<?= $arItem['PICTURE']['SRC'] ?>" alt="">
                                            </div>
                                            <div class="card-item__brand">
                                                <?= $arItem['NAME'] ?>
                                            </div>
                                            <div class="card-item__type">
                                                <?= $arItem['UF_SUB_TITLE'] ?>
                                            </div>
                                            <div class="card-item__desc">
                                                <?= TruncateText($arItem['DESCRIPTION'], 100) ?>
                                            </div>
                                        </a>
                                        <div class="card-item__button classic-button classic-button_green">От <?= $arItem['UF_PRICE'] ?> ₽ – ШТ.</div>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-block">
        <div class="container container-inner container-inner_min">
            <?= htmlspecialchars_decode($arResult['SECTION']['DESCRIPTION']) ?>
        </div>
    </div>
    <? if (
            $arResult['SECTION']['UF_PRICE_LIST'] ||
            $arResult['SECTION']['UF_SALE_FILE'] ||
            $arResult['SECTION']['UF_GUARANTIES'] ||
            $arResult['SECTION']['UF_FILES_GUARANT'] ||
            $arResult['SECTION']['UF_SERTIFICATES'] ||
            $arResult['SECTION']['UF_FUTURES']
    ):?>
    <div class="props-table">
        <div class="container container-inner container-inner">
            <div class="props-table__wrap">
                <div class="props-table__tabs">
                    <? if ($arResult['SECTION']['UF_PRICE_LIST'] || $arResult['SECTION']['UF_SALE_FILE']):?>
                    <div class="props-table__tab jsTab classic-button classic-button_white isActive">Узнать цены</div>
                    <? endif; ?>
                    <? if ($arResult['SECTION']['UF_GUARANTIES'] || $arResult['SECTION']['UF_FILES_GUARANT']):?>
                    <div class="props-table__tab jsTab classic-button classic-button_white">Гарантия</div>
                    <? endif; ?>
                    <? if ($arResult['SECTION']['UF_SERTIFICATES']):?>
                    <div class="props-table__tab jsTab classic-button classic-button_white">Сертификаты</div>
                    <? endif; ?>
                    <? if ($arResult['SECTION']['UF_FUTURES']):?>
                    <div class="props-table__tab jsTab classic-button classic-button_white">Преимущества</div>
                    <? endif; ?>
                </div>
                <div class="props-table__body isActive">
                    <div class="props-table__list price-tab isActive">
                        <div class="price-tab__title inner-subtitle inner-subtitle_with-margin">
                            Узнать цены
                        </div>
                        <div class="price-tab__wrap">
                            <a href="<?= CFile::GetPath($arResult['SECTION']['UF_PRICE_LIST']); ?>" target="_blank" class="price-tab__item">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/pricelist.png" alt="Прайс">
                                <span class="price-tab__name">
                                    <span>Скачать</span>
                                    <span>прайс</span>
                                </span>
                            </a>
                            <a href="<?= CFile::GetPath($arResult['SECTION']['UF_SALE_FILE']); ?>" target="_blank" class="price-tab__item">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/coupon.png" alt="Купон">
                                <span class="price-tab__name">
                                    <span>Скачать</span>
                                    <span>скидочный купон</span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="props-table__list guarantee-tab">
                        <div class="inner-subtitle inner-subtitle_with-margin">Гарантия</div>
                        <?= htmlspecialchars_decode($arResult['SECTION']['UF_GUARANTIES']) ?>
                        <div class="props-table__links">
                            <? foreach ($arResult['SECTION']['UF_FILES_GUARANT'] as $arGuarant): ?>
                                <a href="<?= CFile::GetPath($arGuarant); ?>" target="_blank" class="props-table__link">
                                <span class='props-table__icon'>
                                    <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/downloadicon.png" alt="">
                                </span>
                                    <span>
                                    <span class="recolor">Скачать</span>
                                    <span>гарантийный талон <span class="download-value"><?= $arResult['SECTION']['NAME'] ?></span> </span>
                                </span>
                                </a>
                            <? endforeach; ?>
                        </div>
                    </div>
                    <div class="props-table__list sertificate-tab">
                        <div class="inner-subtitle inner-subtitle_with-margin">Сертификаты</div>
                        <div class="props-table__sertificates">
                            <? foreach ($arResult['SECTION']['UF_SERTIFICATES'] as $arSert): ?>
                                <div class="props-table__sertificate">
                                    <div class="props-table__image">
                                        <a href="<?= CFile::GetPath($arSert); ?>" class="fb" data-title="Сертификат" data-description="Описание" data-type="image">
                                            <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/sertif.jpg" alt="Сертификат">
                                        </a>
                                    </div>
                                    <? /*<div class="props-table__sertificate-name">
                                    Сертификат соответствия на ендовый ковер
                                </div>*/ ?>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                    <div class="props-table__list advantages-tab">
                        <div class="inner-subtitle inner-subtitle_with-margin">
                            Преимущества
                        </div>
                        <?= $arResult['SECTION']['~UF_FUTURES'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? endif; ?>
<? } else { ?>
    <div class="content-block">
        <div class="container container-inner container-inner_min">
            <p style="text-align: center; margin-bottom: 80px">
                К сожелению товары в данной категории отсутствуют.
            </p>
        </div>
    </div>
<? } ?>