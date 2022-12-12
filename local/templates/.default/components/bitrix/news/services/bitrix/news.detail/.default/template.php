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
					<img src="<?= $img['src'] ?>" alt="">
				</div>
				<div class="services-item__description">
					<div class="services-item__title"><?= $arResult['NAME'] ?></div>
					<div class="services-item__text"><?= $arResult['DETAIL_TEXT'] ?></div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="container">
	<?if(in_array($arResult['ID'], array(438))):?>
		<?$APPLICATION->IncludeFile( "/include/price_roof-instalation.php", Array(), Array("MODE" => "html"));?>
	<?endif;?>
</div>
<div class="container">
	<?if(in_array($arResult['ID'], array(439))):?>
		<?$APPLICATION->IncludeFile( "/include/price_roof-montazh-fasada.php", Array(), Array("MODE" => "html"));?>
	<?endif;?>
</div>
<div class="container">
	<?if(in_array($arResult['ID'], array(444))):?>
		<?$APPLICATION->IncludeFile( "/include/price_delivery.php", Array(), Array("MODE" => "html"));?>
	<?endif;?>
</div>