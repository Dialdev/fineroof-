<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<section class="services">
	<div class="container">
		<div class="services__wrap">
            
            <? foreach ($arResult["ITEMS"] as $arItem): ?>
                <?
                $this->AddEditAction(
                    $arItem['ID'],
                    $arItem['EDIT_LINK'],
                    CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT")
                );
                $this->AddDeleteAction(
                    $arItem['ID'],
                    $arItem['DELETE_LINK'],
                    CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
                    ["CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]
                );
                $img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], ['width' => 230, 'height' => 230], BX_RESIZE_IMAGE_PROPORTIONAL);
                ?>
				<a href="<?= $arItem["DETAIL_PAGE_URL"]; ?>" class="services-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
					<div class="services-item__img">
						<img src="<?= $img["src"] ?>" alt="">
					</div>
					<div class="services-item__description">
						<div class="services-item__title"><?= $arItem["NAME"]; ?></div>
						<div class="services-item__text"><?= $arItem["PREVIEW_TEXT"]; ?></div>
					</div>
				</a>
            <? endforeach; ?>

		</div>
	</div>
</section>