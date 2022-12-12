<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$bool = true;
?>
<? if($arResult['ITEMS'] > 0) ?>
<div class="content-block__wrap __services">
    <div class="content-block__body">
        <? foreach ($arResult["SECTIONS"] as $arSect): ?>
        <div class="content-block__column">
            <div class="content-block__subtitle custom-subtitle"><?= $arSect['NAME'] ?></div>
                <? if($arSect['DESCRIPTION']) {?>
                    <div class="content-block__text"><p><?= $arSect['DESCRIPTION'] ?></p></div>
                    <div class="content-block__image content-block__image_services">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/inner-services-image.png" alt="">
                    </div>
                <? } ?>
                <? if ($bool && $arSect['DESCRIPTION']): $bool = false; ?>
                    <div class="content-block__image content-block__image_worker">
                        <svg>
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/common-svg.svg#worker-with-dog"></use>
                        </svg>
                    </div>
                    <div class="content-block__image content-block__image_spiral">
                        <svg>
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/common-svg.svg#vertical-spiral"></use>
                        </svg>
                    </div>
                <? endif; ?>

            <? foreach ($arResult["ITEMS"] as $arItem): ?>
                <?
                if ($arItem['IBLOCK_SECTION_ID'] != $arSect['ID']) continue;
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="content-block__list feature-list" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <div class="feature-list__name"><?= $arItem['NAME'] ?></div>
                    <ul class="feature-list__block<?= $arItem['PROPERTIES']['GREEN_TITLE']['VALUE'] == 'Y' ? ' feature-list__block_green' : ''; ?>">
                        <?= $arItem['~PREVIEW_TEXT'] ?>
                    </ul>
                </div>
            <? endforeach; ?>

            <? if ($bool && !$arSect['DESCRIPTION']): $bool = false; ?>
                <div class="content-block__image content-block__image_worker">
                    <svg>
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/common-svg.svg#worker-with-dog"></use>
                    </svg>
                </div>
            <? endif; ?>

        </div>
        <? endforeach; ?>
    </div>
</div>
