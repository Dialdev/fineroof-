<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("not_show_nav_chain", "Y");
$APPLICATION->SetTitle("Ошибка 404");
?><h3>Ошибка 404: Страница недоступна или не существует</h3>
<p>
	 Вы можете найти нужный раздел в карте сайта ниже или перейти на <a href="/">главную страницу</a>.
</p>
<!--ul>
	<li><a href="/catalog/">Продукция</a></li>
	<li><a href="/services/">Услуги</a></li>
	<li><a href="/news/">Новости</a></li>
	<li><a href="/gallery/">Фотогалерея</a></li>
	<li><a href="/services/dostavka/">Доставка</a></li>
	<li><a href="/contacts/">Контакты</a></li>
</ul-->
<?$APPLICATION->IncludeComponent(
	"bitrix:main.map",
	"",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COL_NUM" => "1",
		"LEVEL" => "3",
		"SET_TITLE" => "N",
		"SHOW_DESCRIPTION" => "N"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>