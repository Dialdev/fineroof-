<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';

$strReturn .= '<div class="breadcrumbs__wrap" itemprop="http://schema.org/breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList"><ul class="breadcrumbs__list">';

$strReturn .= '<li><img src="' .SITE_TEMPLATE_PATH. '/template/img/breadcrumb.png" alt="" class="breadcrumbs__img"></li>';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
			<li class="breadcrumbs__item" id="bx_breadcrumb_'.$index.'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a class="breadcrumbs__link" href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="url">
					<span class="breadcrumbs__link" itemprop="name">'.$title.'</span>
				</a>
				<meta itemprop="position" content="'.($index + 1).'" />
			</li>';
	}
	else
	{
		$strReturn .= '
			<li class="breadcrumbs__item breadcrumbs__item_active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<meta itemprop="position" content="'.($index + 1).'" />
				<span itemprop="name">'.$title.'</span>
			</li>';
	}
}


$strReturn .= '</ul></div>';

return $strReturn;