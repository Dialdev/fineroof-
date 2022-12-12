<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Монтаж кровли, фасада, строительство фундамента и дизайн фасадов | FineRoof");
$APPLICATION->SetPageProperty("description", "Доступные цены на услуги по монтажу кровли, фасада, строительству фундамента и дизайн-проекты фасадов | FineRoof");
$APPLICATION->SetTitle("Услуги");
$titleName = $GLOBALS['APPLICATION']->GetTitle() . '';
?>	<div class="inner-title">
		<div class="container">
			<div class="inner-title__wrap inner-title__wrap_services">
				<div class="inner-title__services custom-title custom-title_inner custom-title_with-lane custom-title_full-house">
                    <? $titleDom = trim($titleName) ?>
                    <? $titleDomLast = substr($titleDom, -2); ?>
					<h2 class="title"><?= substr($titleDom, 0, -2); ?><span>
							<?= $titleDomLast ?>
							<svg class="custom-title__svg">
								<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/icons.svg#full-house"></use>
							</svg>
						</span>
					</h2>
				</div>
			</div>
		</div>
	</div>
<? $APPLICATION->IncludeComponent(
    "bitrix:news",
    "services",
    [
        "ADD_ELEMENT_CHAIN"               => "Y",
        "ADD_SECTIONS_CHAIN"              => "Y",
        "AJAX_MODE"                       => "N",
        "AJAX_OPTION_ADDITIONAL"          => "",
        "AJAX_OPTION_HISTORY"             => "N",
        "AJAX_OPTION_JUMP"                => "N",
        "AJAX_OPTION_STYLE"               => "Y",
        "BROWSER_TITLE"                   => "-",
        "CACHE_FILTER"                    => "N",
        "CACHE_GROUPS"                    => "Y",
        "CACHE_TIME"                      => "36000000",
        "CACHE_TYPE"                      => "A",
        "CHECK_DATES"                     => "Y",
        "DETAIL_ACTIVE_DATE_FORMAT"       => "d.m.Y",
        "DETAIL_DISPLAY_BOTTOM_PAGER"     => "Y",
        "DETAIL_DISPLAY_TOP_PAGER"        => "N",
        "DETAIL_FIELD_CODE"               => ["NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_TEXT", ""],
        "DETAIL_PAGER_SHOW_ALL"           => "Y",
        "DETAIL_PAGER_TEMPLATE"           => "",
        "DETAIL_PAGER_TITLE"              => "Страница",
        "DETAIL_PROPERTY_CODE"            => ["GREEN_TITLE", ""],
        "DETAIL_SET_CANONICAL_URL"        => "N",
        "DISPLAY_BOTTOM_PAGER"            => "Y",
        "DISPLAY_DATE"                    => "N",
        "DISPLAY_NAME"                    => "Y",
        "DISPLAY_PICTURE"                 => "Y",
        "DISPLAY_PREVIEW_TEXT"            => "Y",
        "DISPLAY_TOP_PAGER"               => "N",
        "FILE_404"                        => "/404.php",
        "HIDE_LINK_WHEN_NO_DETAIL"        => "N",
        "IBLOCK_ID"                       => "5",
        "IBLOCK_TYPE"                     => "catalog",
        "INCLUDE_IBLOCK_INTO_CHAIN"       => "N",
        "LIST_ACTIVE_DATE_FORMAT"         => "d.m.Y",
        "LIST_FIELD_CODE"                 => ["NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_TEXT", ""],
        "LIST_PROPERTY_CODE"              => ["GREEN_TITLE", ""],
        "MESSAGE_404"                     => "",
        "META_DESCRIPTION"                => "-",
        "META_KEYWORDS"                   => "-",
        "NEWS_COUNT"                      => "20",
        "PAGER_BASE_LINK_ENABLE"          => "N",
        "PAGER_DESC_NUMBERING"            => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL"                  => "N",
        "PAGER_SHOW_ALWAYS"               => "N",
        "PAGER_TEMPLATE"                  => ".default",
        "PAGER_TITLE"                     => "Новости",
        "PREVIEW_TRUNCATE_LEN"            => "",
        "SEF_FOLDER"                      => "/services/",
        "SEF_MODE"                        => "Y",
        "SEF_URL_TEMPLATES"               => ["detail" => "#ELEMENT_CODE#/", "news" => "", "section" => ""],
        "SET_LAST_MODIFIED"               => "N",
        "SET_STATUS_404"                  => "Y",
        "SET_TITLE"                       => "Y",
        "SHOW_404"                        => "Y",
        "SORT_BY1"                        => "SORT",
        "SORT_BY2"                        => "ID",
        "SORT_ORDER1"                     => "ASC",
        "SORT_ORDER2"                     => "DESC",
        "STRICT_SECTION_CHECK"            => "N",
        "USE_CATEGORIES"                  => "N",
        "USE_FILTER"                      => "N",
        "USE_PERMISSIONS"                 => "N",
        "USE_RATING"                      => "N",
        "USE_RSS"                         => "N",
        "USE_SEARCH"                      => "N",
        "USE_SHARE"                       => "N"
    ]
); ?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>