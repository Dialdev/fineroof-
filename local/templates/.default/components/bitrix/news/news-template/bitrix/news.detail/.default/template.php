<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?php
$img = CFile::ResizeImageGet($arResult['PREVIEW_PICTURE']['ID'], ['width' => 300, 'height' => 300], BX_RESIZE_IMAGE_PROPORTIONAL);
?>
<section class="services services_detail" id="<?= $this->GetEditAreaId($arResult['ID']); ?>">
	<div class="container">
		<div class="services__wrap services__wrap_detail">
			<div class="services-item services-item_detail">
				<div class="services-item__img">
					<img src="<?= $img['src'] ?>" alt="<?=$arResult['NAME']?>" title="<?= $arResult['NAME'] ?>">
				</div>
				<div class="services-item__description">                        
					<span class="news__date-inner"><?= $arResult["DISPLAY_ACTIVE_FROM"]; ?></span>
					<div class="services-item__title"><?= $arResult['NAME'] ?></div>
					<div class="services-item__text"><?= $arResult['DETAIL_TEXT'] ?></div>
				</div>
			</div>
		</div>
	</div>
</section>