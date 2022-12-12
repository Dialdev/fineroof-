<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<div class="container container_full">
    <div class="swiper-pagination"></div>
    <div class="slider-controls">
        <div class="slider-control slider-left slider-left_index">
            <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/arrow.png" alt="">
        </div>
        <div class="slider-control slider-right slider-right_index">
            <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/arrow.png" alt="">
        </div>
    </div>
    <div class="index-slider__container swiper-container">
        <div class="index-slider__wrapper swiper-wrapper">
            <? foreach ($arResult["ITEMS"] as $arItem):
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
                <div class="index-slider__item swiper-slide" id="<? echo $this->GetEditAreaId($arItem['ID']); ?>">
                    <a href="<?= $arItem['PROPERTY_LINK_VALUE'] ?>">
                        <picture>
                            <source srcset="<?= $arItem['DETAIL_PICTURE']['SRC'] ?>" media="(max-width: 479px)">
                            <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>">
                        </picture>
                    </a>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</div>