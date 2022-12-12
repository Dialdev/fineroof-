<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<div class="props-table__body isActive">
    <? foreach ($arResult['SECTIONS'] as $keys => $arSect): ?>
    <div class="props-table__list<?= $keys == min(array_keys($arResult['SECTIONS'])) ? ' isActive galery-block' : ''; ?>">
        <div class="galery-block__slider swiper-container">
            <div class="galery-block__wrapper swiper-wrapper">
                <? foreach ($arSect['ITEMS'] as $arItem):
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))); ?>
                    <? foreach ($arItem['PROPERTIES']['FOTO']['VALUE'] as $key => $arFoto):
                        $imgFull = CFile::GetPath($arFoto);
                        $image = CFile::ResizeImageGet(
                            $arFoto,
                            array("width" => 427, "height" => 284),
                            BX_RESIZE_IMAGE_EXACT,
                            true,
                            false,
                            false,
                            IMAGE_QUALITY
                        )['src'];
                    ?>
                    <div class="galery-block__item swiper-slide" id="<? echo $this->GetEditAreaId($arItem['ID']); ?>">
                        <picture class="galery-block__image">
                            <img src="<?= $image ?>" alt="">
                        </picture>
                        <div class="galery-block__name">
                            <?= $arItem['NAME'] ?>
                        </div>
                        <? if(isset($arItem['PROPERTIES']['FOTO']['DESCRIPTION'])): ?>
                            <div class="galery-block__subtitle"><?= $arItem['PROPERTIES']['FOTO']['DESCRIPTION'][$key] ?></div>
                        <? endif; ?>
                        <div class="galery-block__svg">
                            <svg>
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/catalog-icons.svg#eye"></use>
                            </svg>
                        </div>
                        <a
                            href="<?= $imgFull ?>"
                            class="fb" data-fancybox="gallery"
                            data-title="<?= $arItem['NAME'] ?>"
                            data-description="<?= $arItem['PROPERTIES']['FOTO']['DESCRIPTION'][$key] ?>"
                            data-type="image"
                            data-group="jsFacedes<?= $arSect['ID'] ?>">
							<img src="<?= $imgFull ?>" style="display:none;">
                        </a>
                    </div>
                    <? endforeach; ?>
                <? endforeach; ?>
            </div>
        </div>
        <div class="slider-big-arrows">
            <div class="slider-control slider-left slider-left_galery">
            </div>
            <div class="slider-control slider-right slider-right_galery">
            </div>
        </div>
    </div>
    <? endforeach; ?>
</div>
