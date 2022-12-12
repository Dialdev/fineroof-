<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var string $componentPath
 * @var string $componentName
 * @var array $arCurrentValues
 * @global CUserTypeManager $USER_FIELD_MANAGER
 */

use Bitrix\Main\Loader,
	Bitrix\Main\Web\Json,
	Bitrix\Iblock,
	Bitrix\Catalog,
	Bitrix\Currency;

global $USER_FIELD_MANAGER;

if (!Loader::includeModule('iblock'))
	return;

$catalogIncluded = Loader::includeModule('catalog');
CBitrixComponent::includeComponentClass($componentName);

$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$offersIblock = array();
if ($catalogIncluded)
{
	$iterator = Catalog\CatalogIblockTable::getList(array(
		'select' => array('IBLOCK_ID'),
		'filter' => array('!=PRODUCT_IBLOCK_ID' => 0)
	));
	while ($row = $iterator->fetch())
		$offersIblock[$row['IBLOCK_ID']] = true;
	unset($row, $iterator);
}

$arIBlock = array();
$iblockFilter = !empty($arCurrentValues['IBLOCK_TYPE'])
	? array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y')
	: array('ACTIVE' => 'Y');

$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
while ($arr = $rsIBlock->Fetch())
{
	$id = (int)$arr['ID'];
	if (isset($offersIblock[$id]))
		continue;
	$arIBlock[$id] = '['.$id.'] '.$arr['NAME'];
}
unset($id, $arr, $rsIBlock, $iblockFilter);
unset($offersIblock);

$defaultValue = array('-' => GetMessage('CP_BCS_EMPTY'));

$arProperty = array();
$arProperty_N = array();
$arProperty_X = array();
$listProperties = array();

if ($iblockExists)
{
	$propertyIterator = Iblock\PropertyTable::getList(array(
		'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE', 'SORT'),
		'filter' => array('=IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], '=ACTIVE' => 'Y'),
		'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
	));
	while ($property = $propertyIterator->fetch())
	{
		$propertyCode = (string)$property['CODE'];

		if ($propertyCode === '')
		{
			$propertyCode = $property['ID'];
		}

		$propertyName = '['.$propertyCode.'] '.$property['NAME'];

		if ($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE)
		{
			$arProperty[$propertyCode] = $propertyName;

			if ($property['MULTIPLE'] === 'Y')
			{
				$arProperty_X[$propertyCode] = $propertyName;
			}
			elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_LIST)
			{
				$arProperty_X[$propertyCode] = $propertyName;
			}
			elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_ELEMENT && (int)$property['LINK_IBLOCK_ID'] > 0)
			{
				$arProperty_X[$propertyCode] = $propertyName;
			}
		}

		if ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_NUMBER)
		{
			$arProperty_N[$propertyCode] = $propertyName;
		}
	}
	unset($propertyCode, $propertyName, $property, $propertyIterator);
}

$arProperty_UF = array();
$arSProperty_LNS = array();
$arSProperty_F = array();
if ($iblockExists)
{
	$arUserFields = $USER_FIELD_MANAGER->GetUserFields('IBLOCK_'.$arCurrentValues['IBLOCK_ID'].'_SECTION', 0, LANGUAGE_ID);

	foreach( $arUserFields as $FIELD_NAME => $arUserField)
	{
		$arUserField['LIST_COLUMN_LABEL'] = (string)$arUserField['LIST_COLUMN_LABEL'];
		$arProperty_UF[$FIELD_NAME] = $arUserField['LIST_COLUMN_LABEL'] ? '['.$FIELD_NAME.']'.$arUserField['LIST_COLUMN_LABEL'] : $FIELD_NAME;

		if ($arUserField['USER_TYPE']['BASE_TYPE'] === 'string')
		{
			$arSProperty_LNS[$FIELD_NAME] = $arProperty_UF[$FIELD_NAME];
		}

		if ($arUserField['USER_TYPE']['BASE_TYPE'] === 'file' && $arUserField['MULTIPLE'] === 'N')
		{
			$arSProperty_F[$FIELD_NAME] = $arProperty_UF[$FIELD_NAME];
		}
	}
	unset($arUserFields);
}

$offers = false;
$filterDataValues = array();
$arProperty_Offers = array();
$arProperty_OffersWithoutFile = array();

$arSort = CIBlockParameters::GetElementSortFields(
	array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
	array('KEY_LOWERCASE' => 'Y')
);

$arPrice = array();
if ($catalogIncluded)
{
	$arOfferSort = array_merge($arSort, CCatalogIBlockParameters::GetCatalogSortFields());
	if (isset($arSort['CATALOG_AVAILABLE']))
		unset($arSort['CATALOG_AVAILABLE']);
	$arPrice = CCatalogIBlockParameters::getPriceTypesList();
}
else
{
	$arOfferSort = $arSort;
	$arPrice = $arProperty_N;
}

$arAscDesc = array(
	'asc' => GetMessage('IBLOCK_SORT_ASC'),
	'desc' => GetMessage('IBLOCK_SORT_DESC'),
);

$arComponentParameters = array(
	'GROUPS' => array(
		'SORT_SETTINGS' => array(
			'NAME' => GetMessage('SORT_SETTINGS'),
			'SORT' => 210
		),
		'ACTION_SETTINGS' => array(
			'NAME' => GetMessage('IBLOCK_ACTIONS')
		),
		'EXTENDED_SETTINGS' => array(
			'NAME' => GetMessage('IBLOCK_EXTENDED_SETTINGS'),
			'SORT' => 10000
		)
	),
	'PARAMETERS' => array(
		'SEF_MODE' => array(),
		'SEF_RULE' => array(
			'VALUES' => array(
				'SECTION_ID' => array(
					'TEXT' => GetMessage('IBLOCK_SECTION_ID'),
					'TEMPLATE' => '#SECTION_ID#',
					'PARAMETER_LINK' => 'SECTION_ID',
					'PARAMETER_VALUE' => '={$_REQUEST["SECTION_ID"]}',
				),
				'SECTION_CODE' => array(
					'TEXT' => GetMessage('IBLOCK_SECTION_CODE'),
					'TEMPLATE' => '#SECTION_CODE#',
					'PARAMETER_LINK' => 'SECTION_CODE',
					'PARAMETER_VALUE' => '={$_REQUEST["SECTION_CODE"]}',
				),
				'SECTION_CODE_PATH' => array(
					'TEXT' => GetMessage('CP_BCS_SECTION_CODE_PATH'),
					'TEMPLATE' => '#SECTION_CODE_PATH#',
					'PARAMETER_LINK' => 'SECTION_CODE_PATH',
					'PARAMETER_VALUE' => '={$_REQUEST["SECTION_CODE_PATH"]}',
				),
			),
		),
		'AJAX_MODE' => array(),
		'IBLOCK_TYPE' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('IBLOCK_TYPE'),
			'TYPE' => 'LIST',
			'VALUES' => $arIBlockType,
			'REFRESH' => 'Y',
		),
		'IBLOCK_ID' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('IBLOCK_IBLOCK'),
			'TYPE' => 'LIST',
			'ADDITIONAL_VALUES' => 'Y',
			'VALUES' => $arIBlock,
			'REFRESH' => 'Y',
		),
		'SECTION_ID' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('IBLOCK_SECTION_ID'),
			'TYPE' => 'STRING',
			'DEFAULT' => '={$_REQUEST["SECTION_ID"]}',
		),
		'SECTION_CODE' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('IBLOCK_SECTION_CODE'),
			'TYPE' => 'STRING',
			'DEFAULT' => '',
		),
		'SECTION_USER_FIELDS' => array(
			'PARENT' => 'DATA_SOURCE',
			'NAME' => GetMessage('CP_BCS_SECTION_USER_FIELDS'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'ADDITIONAL_VALUES' => 'Y',
			'VALUES' => $arProperty_UF,
		),
		'ELEMENT_SORT_FIELD' => array(
			'PARENT' => 'SORT_SETTINGS',
			'NAME' => GetMessage('IBLOCK_ELEMENT_SORT_FIELD'),
			'TYPE' => 'LIST',
			'VALUES' => $arSort,
			'ADDITIONAL_VALUES' => 'Y',
			'DEFAULT' => 'sort',
		),
		'ELEMENT_SORT_ORDER' => array(
			'PARENT' => 'SORT_SETTINGS',
			'NAME' => GetMessage('IBLOCK_ELEMENT_SORT_ORDER'),
			'TYPE' => 'LIST',
			'VALUES' => $arAscDesc,
			'DEFAULT' => 'asc',
			'ADDITIONAL_VALUES' => 'Y',
		),
		'ELEMENT_SORT_FIELD2' => array(
			'PARENT' => 'SORT_SETTINGS',
			'NAME' => GetMessage('IBLOCK_ELEMENT_SORT_FIELD2'),
			'TYPE' => 'LIST',
			'VALUES' => $arSort,
			'ADDITIONAL_VALUES' => 'Y',
			'DEFAULT' => 'id',
		),
		'ELEMENT_SORT_ORDER2' => array(
			'PARENT' => 'SORT_SETTINGS',
			'NAME' => GetMessage('IBLOCK_ELEMENT_SORT_ORDER2'),
			'TYPE' => 'LIST',
			'VALUES' => $arAscDesc,
			'DEFAULT' => 'desc',
			'ADDITIONAL_VALUES' => 'Y',
		),
		'FILTER_NAME' => array(
			'PARENT' => 'SORT_SETTINGS',
			'NAME' => 'Имя массива со значениями фильтра для фильтрации элементов',
			'TYPE' => 'STRING',
			'DEFAULT' => 'arrFilter',
		),
		'INCLUDE_SUBSECTIONS' => array(
			'PARENT' => 'DATA_SOURCE',
			'NAME' => GetMessage('CP_BCS_INCLUDE_SUBSECTIONS'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'Y' => GetMessage('CP_BCS_INCLUDE_SUBSECTIONS_ALL'),
				'A' => GetMessage('CP_BCS_INCLUDE_SUBSECTIONS_ACTIVE'),
				'N' => GetMessage('CP_BCS_INCLUDE_SUBSECTIONS_NO'),
			),
			'DEFAULT' => 'Y',
		),
		'SECTION_URL' => CIBlockParameters::GetPathTemplateParam(
			'SECTION',
			'SECTION_URL',
			GetMessage('IBLOCK_SECTION_URL'),
			'',
			'URL_TEMPLATES'
		),
		'DETAIL_URL' => CIBlockParameters::GetPathTemplateParam(
			'DETAIL',
			'DETAIL_URL',
			GetMessage('IBLOCK_DETAIL_URL'),
			'',
			'URL_TEMPLATES'
		),
		'SECTION_ID_VARIABLE' => array(
			'PARENT' => 'URL_TEMPLATES',
			'NAME' => GetMessage('IBLOCK_SECTION_ID_VARIABLE'),
			'TYPE' => 'STRING',
			'DEFAULT' => 'SECTION_ID',
		),
		'SET_TITLE' => array(),
		'SET_BROWSER_TITLE' => array(
			'PARENT' => 'ADDITIONAL_SETTINGS',
			'NAME' => GetMessage('CP_BCS_SET_BROWSER_TITLE'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
			'REFRESH' => 'Y'
		),
		'SET_META_DESCRIPTION' => array(
			'PARENT' => 'ADDITIONAL_SETTINGS',
			'NAME' => GetMessage('CP_BCS_SET_META_DESCRIPTION'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
			'REFRESH' => 'Y'
		),
		'SET_LAST_MODIFIED' => array(
			'PARENT' => 'ADDITIONAL_SETTINGS',
			'NAME' => GetMessage('CP_BCS_SET_LAST_MODIFIED'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
		),
		'ADD_SECTIONS_CHAIN' => array(
			'PARENT' => 'ADDITIONAL_SETTINGS',
			'NAME' => GetMessage('CP_BCS_ADD_SECTIONS_CHAIN'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
		),
		'PAGE_ELEMENT_COUNT' => array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('IBLOCK_PAGE_ELEMENT_COUNT'),
			'TYPE' => 'STRING',
			'HIDDEN' => isset($templateProperties['PRODUCT_ROW_VARIANTS']) ? 'Y' : 'N',
			'DEFAULT' => '18'
		),
		'LINE_ELEMENT_COUNT' => array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('IBLOCK_LINE_ELEMENT_COUNT'),
			'TYPE' => 'STRING',
			'HIDDEN' => isset($templateProperties['PRODUCT_ROW_VARIANTS']) ? 'Y' : 'N',
			'DEFAULT' => '3'
		),
		'PROPERTY_CODE' => array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('IBLOCK_PROPERTY'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'REFRESH' => isset($templateProperties['PROPERTY_CODE_MOBILE']) ? 'Y' : 'N',
			'VALUES' => $arProperty,
			'ADDITIONAL_VALUES' => 'Y',
		),
		'PROPERTY_CODE_MOBILE' => array(),
		'CACHE_TIME' => array('DEFAULT' => 36000000),
		'CACHE_FILTER' => array(
			'PARENT' => 'ADDITIONAL_SETTINGS',
			'NAME' => GetMessage('IBLOCK_CACHE_FILTER'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
		),
		'CACHE_GROUPS' => array(
			'PARENT' => 'CACHE_SETTINGS',
			'NAME' => GetMessage('CP_BCS_CACHE_GROUPS'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		)
	),
);