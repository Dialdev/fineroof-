<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<div class="catalog-slider__wrapper swiper-container" dir="ltr">
    <div class="swiper-pagination catalog-slider__pagination"></div>
    <div class="slider-controls catalog-slider__controls">
        <div class="slider-control slider-left slider-left_catalog">
            <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/arrow.png" alt="">
        </div>
        <div class="slider-control slider-right slider-right_catalog">
            <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/arrow.png" alt="">
        </div>
    </div>
    <div class="catalog-slider__heads">
<!--        <div class="catalog-slider__head">-->
<!--            <img src="--><?//= SITE_TEMPLATE_PATH ?><!--/template/img/house-slider.png" alt="">-->
<!--        </div>-->
        <div class="catalog-slider__head">
            <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/house-slider.png" alt="">
        </div>
    </div>
    <div class="catalog-slider__subwrap swiper-wrapper">
        <? foreach ($arResult["ITEMS"] as $arItem):
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            $img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], ['width' => 347, 'height' => 347], BX_RESIZE_IMAGE_EXACT);
            ?>
            <a href="<?= $arItem['PROPERTY_LINK_VALUE'] ?>" class="catalog-slider__item swiper-slide" id="<? echo $this->GetEditAreaId($arItem['ID']); ?>">
                <div class="catalog-slider__block" data-swiper-parallax="60%" data-swiper-parallax-opacity="0">
                    <div class="catalog-slider__picture">
                        <img src="<?= $img['src'] ?>" alt="<?= $arItem['NAME'] ?>">
                    </div>
                    <div class="catalog-slider__name">
                        <?= $arItem['NAME'] ?>
                    </div>
                </div>
            </a>
        <? endforeach; ?>
    </div>
</div>
