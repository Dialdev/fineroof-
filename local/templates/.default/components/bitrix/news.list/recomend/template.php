<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<? if ($arResult['ITEMS']) { ?>
    <div class="items-block">
        <div class="container container-inner">
            <div class="inner-subtitle inner-subtitle_margin-bottom">С этим товаром покупают</div>
            <div class="items-block__wrap container-inner container-inner_min">
                <div class="slider-small-arrows">
                    <div class="slider-control slider-left slider-left_similar"></div>
                    <div class="slider-control slider-right slider-right_similar"></div>
                </div>
                <div class="items-block__slider swiper-container">
                    <div class="items-block__wrapper swiper-wrapper">
                        <? foreach ($arResult['ITEMS'] as $key => $arItems) { ?>
                            <? $name = $arItems['PROPERTIES']['SUB_TITLE']['VALUE'] ? $arItems['PROPERTIES']['SUB_TITLE']['VALUE'] : $arItems['NAME'] ?>
                            <? if ($arItems["UF_TEMPLATE"] == 1): ?>
                                <a href="<?= $arItems['DETAIL_PAGE_URL'] ?>" class="items-block__item small-item bordered-item swiper-slide">
                                    <span class="small-item__img">
                                        <img src="<?= imgResize($arItems['PREVIEW_PICTURE']['ID'], 180, 180) ?>" alt="<?= $name ?>">
                                    </span>
                                    <span class="small-item__text"><?= $name ?></span>
                                </a>
                            <? else: ?>
                                <a href="<?= $arItems['SECTION_PAGE_URL'] ?>" class="items-block__item small-item bordered-item swiper-slide">
                                    <span class="small-item__img">
                                        <img src="<?= imgResize($arItems['PREVIEW_PICTURE']['ID'], 180, 180) ?>" alt="<?= $name ?>">
                                    </span>
                                    <span class="small-item__text"><?= $name ?></span>
                                </a>
                            <? endif; ?>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
	</div><?
}