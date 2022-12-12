<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница - тест (удалить допустимо)");
?>Страница находится в разработке....<?$APPLICATION->IncludeComponent(
	"soobwa:soobwa.comments", 
	"template1", 
	array(
		"COMPONENT_TEMPLATE" => "template1",
		"ID_CHAT" => "DEFAULT_1612376511",
		"AUTH" => "Y",
		"AUTH_URL" => "",
		"ENTRY_URL" => "",
		"MODERATION" => "Y",
		"COUNT" => "5",
		"CACHE" => "Y",
		"CACHE_TIMES" => "36000000"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>