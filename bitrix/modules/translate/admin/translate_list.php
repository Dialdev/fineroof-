<?
/** @global CMain $APPLICATION */
use Bitrix\Main,
	Bitrix\Main\Loader;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/translate/prolog.php");
$TRANS_RIGHT = $APPLICATION->GetGroupRight("translate");
if ($TRANS_RIGHT == "D")
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
Loader::includeModule('translate');
IncludeModuleLangFile(__FILE__);

@set_time_limit(0);
$sTableID = "tbl_translate_list";
$lAdmin = new CAdminList($sTableID);

function GetPhraseCounters($arCommon, $path, $key)
{
	global $arCommonCounter, $Counter, $arTLangs;
	$Counter++;
	$arDirFiles = array();

	// is directori
	if (is_dir(prepare_path($_SERVER["DOCUMENT_ROOT"]."/".$path."/")))
	{
		if (is_lang_dir($path))
		{
			if (is_array($arTLangs))
			{
				// files array for directory language
				foreach ($arTLangs as $lng)
				{
					$path = replace_lang_id($path, $lng);
					$path_l = strlen($path);

					foreach($arCommon as $arr)
					{
						if($arr["IS_DIR"]=="N" && (strncmp($arr["PATH"], $path, $path_l) == 0))
						{
							$arDirFiles[] = $arr["PATH"];
						}
					}
				}
			}
		}
		else
		{
			if (is_array($arCommon))
			{
				$path_l = strlen($path);
				// array files for directory
				foreach ($arCommon as $arr)
				{
					if($arr["IS_DIR"]=="N" && (strncmp($arr["PATH"], $path, $path_l) == 0))
					{
						$arDirFiles[] = $arr["PATH"];
					}
				}
			}
		}
	}
	else
	{
		foreach ($arTLangs as $lng)
			$arDirFiles[] = replace_lang_id($path, $lng);
	}

	$arFilesLng = array();
	// array for every files
	foreach ($arDirFiles as $file)
	{
		if(file_exists($_SERVER["DOCUMENT_ROOT"].$file) && preg_match("#/lang/(.*?)/#", $file, $arMatch))
		{
			$file_lang = $arMatch[1];
			if(isset($arTLangs[$file_lang]))
			{
				if(substr($file, -3) != "php")
					continue;
				/** @global array $MESS */
				$MESS_tmp = $MESS;
				$MESS = array();
				include($_SERVER["DOCUMENT_ROOT"].$file);
				$file_name = remove_lang_id($file, $arTLangs);
				$arFilesLng[$file_name][$file_lang] = array_keys($MESS);
				$MESS = $MESS_tmp;
			}
		}
	}

	$arFilesLngCounter = array();
	//rashogdenia for files
	foreach($arFilesLng as $file => $arLns)
	{
		$total_arr = array();

		//summa
		foreach($arLns as $ln => $arLn)
		{
			$total_arr = array_merge($total_arr, $arLn);
		}
		$total_arr = array_unique($total_arr);
		$total = sizeof($total_arr);

		foreach($arTLangs as $lang)
		{
			$arr = array();
			$arLn = is_array($arLns[$lang]) ? $arLns[$lang] : array();
			$diff_arr = array_diff($total_arr, $arLn);
			$arr["TOTAL"] = $total;
			$diff = sizeof($diff_arr);
			$arr["DIFF"] = $diff;
			$arFilesLngCounter[$file][$lang] = $arr;
		}
	}

	foreach($arFilesLngCounter as $file => $arCount)
	{
		foreach($arCount as $ln => $arLn)
		{
			$file_path = str_replace("/lang/", "/lang/".$ln."/", $file);
			$arCommonCounter[$key][$ln][$file_path]["TOTAL"] += $arLn["TOTAL"];
			$arCommonCounter[$key][$ln][$file_path]["DIFF"] += $arLn["DIFF"];
		}
	}
}

$request = Main\Context::getCurrent()->getRequest();

$arCSVMessage = false;
$useSearch = false;
$arSearchParam = [];
if ($request->isPost() && check_bitrix_sessid())
{
	if ($request->getPost('upload_csv') !== null)
	{
		if (SaveTCSVFile())
		{
			$arCSVMessage = array('TYPE' => 'OK', 'MESSAGE' => GetMessage('TR_CSV_UPLOAD_OK'));
		}
		else
		{
			$ex = $APPLICATION->GetException();
			$arCSVMessage = array('TYPE' => 'ERROR', 'MESSAGE' => $ex->GetString());
		}
	}
	elseif ($request->get('tr_search') !== null)
	{
		if ($request->get('replace_oper') === 'Y')
		{
			$arSearchParam = [
				'is_replace' => true,
				'search' => trim((string)$request->get('search_phrase2')),
				'replace' => trim((string)$request->get('replace_phrase2')),
				'bSubFolders' => ($request->get('search_subfolders2') === 'Y'),
				'bSearchMessage' => ($request->get('search_message2') === 'Y'),
				'bSearchMnemonic' => ($request->get('search_mnemonic2') === 'Y'),
				'bCaseSens' => ($request->get('search_case_sens2') === 'Y')
			];
		}
		else
		{
			$arSearchParam = [
				'is_replace' => false,
				'search' => trim((string)$request->get('search_phrase')),
				'replace' => '',
				'bSubFolders' => ($request->get('search_subfolders') === 'Y'),
				'bSearchMessage' => ($request->get('search_message') === 'Y'),
				'bSearchMnemonic' => ($request->get('search_mnemonic') === 'Y'),
				'bCaseSens' => ($request->get('search_case_sens') === 'Y')
			];
		}
		if ($arSearchParam['search'] !== '')
			$useSearch = true;
		else
			$arSearchParam = [];
	}
}

$arTLangs = [];
$iterator = Main\Localization\LanguageTable::getList([
	'select' => ['ID', 'SORT'],
	'filter' => ['=ACTIVE' => 'Y'],
	'order' => ['SORT' => 'ASC']
]);
while ($row = $iterator->fetch())
	$arTLangs[$row['ID']] = $row['ID'];
unset($row, $iterator);

$actionLanguageList = [];
$iterator = Main\Localization\LanguageTable::getList([
	'select' => ['ID', 'SORT', 'DEF', 'NAME'],
	'filter' => [
		[
			'LOGIC' => 'OR',
			'@ID' => ['de', 'en', 'ru'],
			'=DEF' => 'Y'
		],
		'=ACTIVE' => 'Y'
	],
	'order' => ['DEF' => 'DESC', 'SORT' => 'ASC']
]);
while ($row = $iterator->fetch())
	$actionLanguageList[$row['ID']] = $row['NAME'];
unset($row, $iterator);

$path = $request->get('path');
$go_path = $request->get('go_path');

//button going
if(strlen($go_path)>0 && !preg_match("#\.\.[\\/]#".BX_UTF_PCRE_MODIFIER, $path))
	$path = add_lang_id($go_path, reset($arTLangs), $arTLangs);

if(preg_match("#\.\.[\\/]#".BX_UTF_PCRE_MODIFIER, $path))
	$path = "";
//no path
if (strlen($path)<=0)
	$path = TRANSLATE_DEFAULT_PATH;

$path = Rel2Abs("/", "/".$path."/");
if (!isAllowPath($path))
	$path = TRANSLATE_DEFAULT_PATH;

$SHOW_DIFF_GET = false;
$AUTO_CALCULATE = (string)Main\Config\Option::get('translate', 'AUTO_CALCULATE') == 'Y';
if (!$AUTO_CALCULATE)
{
	$showDifference = $request->get('SHOW_DIFF');
	if ($showDifference !== null)
	{
		$SHOW_DIFF_GET = $showDifference == 'Y';
		if ($path == TRANSLATE_DEFAULT_PATH)
			$SHOW_DIFF_GET = false;
		$_SESSION['BX_SHOW_LANG_DIFF'] = $SHOW_DIFF_GET;
		if ($SHOW_DIFF_GET)
		{
			$_SESSION['BX_SHOW_LANG_DIFF_PATH'] = $path;
		}
		else
		{
			if (array_key_exists('BX_SHOW_LANG_DIFF_PATH', $_SESSION))
				unset($_SESSION['BX_SHOW_LANG_DIFF_PATH']);
		}
	}
	unset($showDifference);
}
if (isset($_SESSION['BX_SHOW_LANG_DIFF']) && $_SESSION['BX_SHOW_LANG_DIFF'])
{
	if (substr($path, 0, strlen($_SESSION['BX_SHOW_LANG_DIFF_PATH'])) !== $_SESSION['BX_SHOW_LANG_DIFF_PATH'])
	{
		$_SESSION['BX_SHOW_LANG_DIFF'] = false;
		unset($_SESSION['BX_SHOW_LANG_DIFF_PATH']);
	}
}

$SHOW_LANG_DIFF = $AUTO_CALCULATE || $SHOW_DIFF_GET || (isset($_SESSION['BX_SHOW_LANG_DIFF']) && $_SESSION['BX_SHOW_LANG_DIFF']);
$GET_SUBFOLRERS = $SHOW_LANG_DIFF || ($useSearch && $arSearchParam['bSubFolders']);
if ($useSearch)
{
	$AUTO_CALCULATE = false;
	$SHOW_LANG_DIFF = false;
}
$arLangCounters = array();
$arCommonCounter = array();

$arLangDirFiles = array();
$arFiles = array();
$arDirs = array();
$arLangDirs = array();
$IS_LANG_DIR = false;

$go_path = remove_lang_id($path, $arTLangs);

$IS_LANG_DIR = is_lang_dir($path);
//no lang
if ($IS_LANG_DIR)
{
	foreach ($arTLangs as $hlang)
	{
		$ph = add_lang_id($path, $hlang, $arTLangs);
		if (strlen($ph)>0) GetTDirList($ph, $GET_SUBFOLRERS);
		$ph = "";
	}
}
else
{
	GetTDirList($path, $GET_SUBFOLRERS);
}

$arrChain = array();
$arr = explode("/",$go_path);
if (is_array($arr))
{
	$arrP = array();
	TrimArr($arr);
	foreach($arr as $d)
	{
		$arrP[] = $d;
		$p = prepare_path("/".implode("/",$arrP)."/");
		if (remove_lang_id($path, $arTLangs) == $p)
			$p = "";
		$arrChain[] = array("NAME" => $d, "PATH" => $p);
	}
}

$show_error = COption::GetOptionString("translate", "ONLY_ERRORS");
$show_error = ($show_error=="Y") ? "Y" : "";

GetLangDirs($arDirs, $SHOW_LANG_DIFF);

$arLangDirFiles = array_merge($arLangDirs, $arFiles);

// find
if ($useSearch)
{
	$_arLangDirFiles = $arLangDirFiles;
	$arLangDirFiles = array();
	foreach ($_arLangDirFiles as $_k => $_v)
	{
		if ($_v['IS_DIR'] == 'Y')
			continue ;
		if ($_v['LANG'] != LANGUAGE_ID)
			continue ;

		$_coincidence = 0;
		if (!TSEARCH(CSite::GetSiteDocRoot(false).$_v['PATH'], $_coincidence))
			continue ;

		$_v['COINCIDENCE'] = $_coincidence;
		$arLangDirFiles[$_k] = $_v;
	}
}

$listIds = $lAdmin->GroupAction();
if (!empty($listIds))
{
	$action = $request->get('action');
	$actionButton = $request->get('action_button');
	if (!empty($actionButton))
		$action = $actionButton;
	unset($actionButton);

	switch ($action)
	{
		case 'remove_phrase':
			$masterLanguage = (string)$request->get('remove_phrase_lang');
			if (
				$masterLanguage === ''
				|| !isset($actionLanguageList[$masterLanguage])
			)
			{
				$lAdmin->AddGroupError(GetMessage('BX_TRANSLATE_LIST_GROUP_ERR_LANGUAGE_ABSENT'));
			}
			else
			{
				if (!empty($arFiles))
				{
					$currentFileList = [];
					$masterFileList = [];
					foreach ($arFiles as $row)
					{
						if (!$row['IS_LANG'])
							continue;
						$file = $row['FILE'];
						if (!isset($currentFileList[$file]))
							$currentFileList[$file] = [];
						$currentFileList[$file][$row['LANG']] = $row['PATH'];
						if ($row['LANG'] == $masterLanguage)
							$masterFileList[$file] = true;
					}
					unset($file, $row);

					if (!empty($masterFileList))
					{
						foreach ($listIds as $file)
						{
							$founded = false;
							$mask = [];
							if (isset($masterFileList[$file]))
							{
								$MESS_tmp = $MESS;
								$MESS = [];
								if (file_exists($_SERVER["DOCUMENT_ROOT"].$currentFileList[$file][$masterLanguage]))
								{
									$founded = true;
									/** @noinspection PhpIncludeInspection */
									include($_SERVER["DOCUMENT_ROOT"].$currentFileList[$file][$masterLanguage]);
								}
								if (!empty($MESS))
									$mask = array_fill_keys(array_keys($MESS), true);
								$MESS = $MESS_tmp;
								unset($MESS_tmp);
							}
							if ($founded && !empty($mask))
							{
								$newList = [];
								foreach ($currentFileList[$file] as $phraseLanguage => $phrasePath)
								{
									if ($phraseLanguage == $masterLanguage)
										continue;
									$MESS_tmp = $MESS;
									$MESS = [];
									if (file_exists($_SERVER["DOCUMENT_ROOT"].$phrasePath))
									{
										$founded = true;
										/** @noinspection PhpIncludeInspection */
										include($_SERVER["DOCUMENT_ROOT"].$phrasePath);
									}
									if (!empty($MESS))
										$MESS = array_intersect_key($MESS, $mask);
									$newList[$phrasePath] = $MESS;
									$MESS = $MESS_tmp;
									unset($MESS_tmp);
								}
								unset($phrasePath);
								if (!empty($newList))
								{
									foreach ($newList as $phrasePath => $rows)
									{
										$content = '';
										foreach ($rows as $phraseId => $phraseText)
										{
											$content .= "\n\$MESS[\"".EscapePHPString($phraseId)."\"] = \"".
												EscapePHPString(str_replace("\r", "", $phraseText))."\";";
										}
										unset($phraseId, $phraseText);
										if (!TR_BACKUP($phrasePath))
										{
											$lAdmin->AddGroupError(GetMessage(
												'BX_TRANSLATE_LIST_GROUP_ERR_CANNOT_CREATE_BACKUP_LANG_FILE',
												['#FILEPATH#' => $phrasePath]
											));
										}
										else
										{
											if (!RewriteFile($_SERVER["DOCUMENT_ROOT"].$phrasePath, "<?".$content."\n?".">"))
											{
												$lAdmin->AddGroupError(GetMessage(
													'BX_TRANSLATE_LIST_GROUP_ERR_CANNOT_REWRITE_LANG_FILE',
													['#FILEPATH#' => $phrasePath]
												));
											}
										}
										unset($content);
									}
									unset($phrasePath, $rows);
								}
								unset($newList);
							}
						}
						unset($file);
					}
					unset($masterFileList, $currentFileList);
				}
			}
			break;
	}
}

$lAdmin->BeginPrologContent();
?><p><?
if (!$useSearch)
{
	$last_path = "";
	foreach ($arrChain as $row)
	{
		echo ' / ';
		if ($row['PATH'] !== '')
		{
			$last_path = $row['PATH'];
			?><a href="?lang=<?=LANGUAGE_ID; ?>&path=<?=urlencode($last_path); ?>" title="<?=GetMessage('TR_FOLDER_TITLE'); ?>"><?=htmlspecialcharsbx($row['NAME']); ?></a><?
		}
		else
		{
			?><?=htmlspecialcharsbx($row['NAME']); ?><?
		}
	}
}
?></p><?
$lAdmin->EndPrologContent();

$header = array();
$header[] = array(
	"id" => "TRANS_FILE_NAME",
	"content" => GetMessage("TRANS_FILE_NAME"),
	"default" => true,
	"align" => "left"
);
if ($AUTO_CALCULATE || $SHOW_LANG_DIFF)
{
	$header[] = array(
		"id" => "TRANS_TOTAL_MESSAGES",
		"content" => GetMessage("TRANS_TOTAL_MESSAGES"),
		"default" => true,
		"align" => "right"
	);

	foreach($arTLangs as $vlang)
	{
		$header[] = array(
			"id" => $vlang,
			"content" => $vlang,
			"default" => true,
			"align" => "left"
		);
	}
}
$lAdmin->AddHeaders($header);

if (strlen($path)>0 && !$useSearch)
{
	$row =& $lAdmin->AddRow('.', []);
	$row->AddViewField("TRANS_FILE_NAME", '<a href="?lang='.LANGUAGE_ID.'&path='.urlencode($last_path).'" title="'.GetMessage("TR_UP_TITLE").'">
			<img src="/bitrix/images/translate/up.gif" width="11" height="13" border=0 alt=""></a>'.
			'&nbsp;<a href="?lang='.LANGUAGE_ID.'&path='.urlencode($last_path).'" title="'.GetMessage("TR_UP_TITLE").'">..</a>');
	$row->bReadOnly = true;
	if ($AUTO_CALCULATE || $SHOW_LANG_DIFF)
	{
		$row->AddViewField("TRANS_TOTAL_MESSAGES", "&nbsp;");
		foreach($arTLangs as $vlang)
			$row->AddViewField($vlang, "&nbsp;");
	}
}

$ORIGINAL_MESS = $MESS;

$showGroupActions = false;

if (is_array($arLangDirFiles))
{
	if ($IS_LANG_DIR)
		$arPath[] = add_lang_id($path, LANGUAGE_ID, $arTLangs);
	else
		$arPath[] = $path;


	$arShown = array();
	$arrTOTAL_NOT_TRANSLATED = array();
	$TOTAL_MESS = 0;
	$i = 0;

	foreach($arLangDirFiles as $key => $ar)
	{
		$i++;
		if (in_array($ar["PARENT"], $arPath) || $useSearch)
		{
			if ($useSearch && $ar['IS_DIR'] == 'Y')
				continue;

			$is_dir = $ar["IS_DIR"];
			$fpath = $ar["PATH"];
			$fparent = $ar["PARENT"];
			$ftitle = $useSearch ? $ar["PATH"] : $ar["FILE"];

			if ($IS_LANG_DIR)
			{
				if (in_array($ftitle, $arShown))
					continue;
				$arShown[] = $ftitle;
			}

			$fkey = remove_lang_id($fpath, $arTLangs);

			if ($SHOW_LANG_DIFF)
			{
				GetPhraseCounters($arLangDirFiles, $fpath, $fkey);
			}
			if ($is_dir == "Y")
			{
				$row =& $lAdmin->AddRow($ar['FILE'], [], "translate_list.php?lang=".LANGUAGE_ID."&path=".$fpath, GetMessage("TR_FOLDER_TITLE"));
				$row->AddViewField(
					"TRANS_FILE_NAME",
					'<a href="?lang='.LANGUAGE_ID.'&path='.$fpath.'" title="'.GetMessage("TR_FOLDER_TITLE").'"><img src="/bitrix/images/translate/folder.gif" width="16" height="16" border=0 alt=""></a>'.'&nbsp;<a href="?lang='.LANGUAGE_ID.'&path='.$fpath.'" title="'.GetMessage("TR_FOLDER_TITLE").'">'.$ftitle.'</a>'
				);
				$row->bReadOnly = true;
			}
			else
			{
				$showGroupActions = true;
				$row =& $lAdmin->AddRow($ar['FILE'], [], "translate_edit.php?lang=".LANGUAGE_ID."&file=".$fpath."&show_error=".$show_error, GetMessage("TR_FILE_TITLE"));
				$arAction = [
					[
						'TEXT' => GetMessage("TR_MESSAGE_EDIT"),
						'ACTION' => $lAdmin->ActionRedirect('translate_edit.php?lang='.LANGUAGE_ID.'&file='.$fpath.'&show_error='.$show_error),
						'DEFAULT' => true,
						'ICON' => ''
					],
					[
						'TEXT' => GetMessage("TR_FILE_EDIT"),
						'ACTION' => $lAdmin->ActionRedirect('translate_edit_php.php?lang='.LANGUAGE_ID.'&file='.$fpath),
						'DEFAULT' => false,
						'ICON' => 'edit'
					],
					[
						'TEXT' => GetMessage("TR_FILE_SHOW"),
						'ACTION' => $lAdmin->ActionRedirect('translate_show_php.php?lang='.LANGUAGE_ID.'&file='.$fpath),
						'DEFAULT' => false,
						'ICON' => 'view'
					]
				];
				if ($useSearch)
				{
					$arAction[] = ['SEPARATOR' => true];
					$arAction[] = [
						'TEXT' => GetMessage("TR_PATH_GO"),
						'ACTION' => $lAdmin->ActionRedirect('translate_list.php?lang='.LANGUAGE_ID.'&path='.$fparent),
						'DEFAULT' => false,
						'ICON' => 'go'
					];
				}
				$row->AddActions($arAction);
				$row->AddViewField("TRANS_FILE_NAME", '<a href="translate_edit.php?lang='.LANGUAGE_ID.'&file='.$fpath.'&show_error='.$show_error.'" title="'.GetMessage("TR_FILE_TITLE").'"><img src="/bitrix/images/translate/file.gif" width="16" height="16" border=0 alt=""></a>'.
					'&nbsp;<a href="translate_edit.php?lang='.LANGUAGE_ID.'&file='.$fpath.'&show_error='.$show_error.'" title="'.GetMessage("TR_FILE_TITLE").'">'.$ftitle.'</a>'.($useSearch ? ' ('.$ar["COINCIDENCE"].')' : ''));
			}
			if ($AUTO_CALCULATE || $SHOW_LANG_DIFF)
			{
				$arr = array();
				foreach ($arTLangs as $vlang)
				{
					$total_sum = 0;
					if (is_array($arCommonCounter[$fkey][$vlang]))
						foreach ($arCommonCounter[$fkey][$vlang] as $fileName => $fileCounter)
							$total_sum += intval($fileCounter["TOTAL"]);

					$arr[] = $total_sum;
				}

				$total_messages = max($arr);
				$TOTAL_MESS += $total_messages;
				$row->AddViewField("TRANS_TOTAL_MESSAGES", $total_messages);

				foreach ($arTLangs as $vlang)
				{
					$arFilesDiff = array();
					$arFilesTotal = array();
					$lang_not_translated = 0;
					$lang_total = 0;
					if (is_array($arCommonCounter[$fkey][$vlang]))
					{
						foreach ($arCommonCounter[$fkey][$vlang] as $file => $fileCounter)
						{
							if (intval($fileCounter["DIFF"]) > 0)
								$arFilesDiff[$file] = intval($fileCounter["DIFF"]);
							if (intval($fileCounter["TOTAL"]) > 0)
								$arFilesTotal[$file] = intval($fileCounter["TOTAL"]);
							$lang_not_translated += intval($fileCounter["DIFF"]);
							$lang_total += intval($fileCounter["TOTAL"]);
						}
					}
					$diff_total = $total_messages - $lang_total;
					if (intval($lang_not_translated) > 0)
					{
						foreach ($arFilesDiff as $fileName => $counter)
						{
							$arFilesDiff[$fileName] = '<a href="translate_edit.php?lang='.LANGUAGE_ID.'&file='.urlencode($fileName).'&show_error=Y" title="'.$fileName.'">'.$counter.'</a>';
						}
						$sStr = '<span class="required">'.$lang_not_translated.'</span>: '.implode(', ', $arFilesDiff);
						$arrTOTAL_NOT_TRANSLATED[$vlang] += $lang_not_translated;
						$row->AddViewField($vlang, $sStr);
					}
					elseif (intval($diff_total) > 0)
					{
						$sStr = '<span class="required">'.$lang_total.'</span>: '.implode(', ', $arFilesTotal);
						$arrTOTAL_NOT_TRANSLATED[$vlang] += $diff_total;
						$row->AddViewField($vlang, $sStr);
					}
					else
					{
						$row->AddViewField($vlang, "&nbsp;");
					}
				}
			}
		}
	}
	unset($row);
}

$i = 0;
$MESS = $ORIGINAL_MESS;
if ($AUTO_CALCULATE || $SHOW_LANG_DIFF)
{
	$row =& $lAdmin->AddRow($i++, Array());
	$row->AddViewField("TRANS_FILE_NAME", "<b>".GetMessage("TRANS_TOTAL").":</b>");
	$row->AddViewField("TRANS_TOTAL_MESSAGES", "<b>".$TOTAL_MESS."</b>");
	foreach($arTLangs as $vlang):
		if (intval($arrTOTAL_NOT_TRANSLATED[$vlang])>0)
		{
			$row->AddViewField($vlang, "<b>".$arrTOTAL_NOT_TRANSLATED[$vlang]."</b>");
		}
	endforeach;
	unset($row);
}

if ($showGroupActions)
{
	$actionList = [];
	$actionListParams = [];

	if (!empty($actionLanguageList))
	{
		$chooser = '<div id="remove_phrase_lang_choose" style="display:none;">&nbsp;'.GetMessage('BX_TRANSLATE_REMOVE_LANG_PHRASES');
		$chooser .= '<select name="remove_phrase_lang">';
		$chooser .= '<option value="">'.GetMessage('BX_TRANSLATE_PHRASE_LANG_EMPTY').'</option>';

		foreach ($actionLanguageList as $languageId => $languageName)
		{
			$chooser .= '<option value="'.htmlspecialcharsbx($languageId).'">'.htmlspecialcharsbx($languageName).'</option>';
		}
		unset($languageId, $languageName);

		$chooser .= '</select></div>';

		$actionList['remove_phrase'] = GetMessage('BX_TRANSLATE_GROUP_ACTION_REMOVE_LANG_PHRASES');
		$actionList['remove_phrase_chooser'] = [
			'type' => 'html',
			'value' => $chooser
		];

		$actionListParams['select_onchange'] = "BX('remove_phrase_lang_choose').style.display = (this.value === 'remove_phrase' ? 'block' : 'none');";
	}
	$actionListParams['disable_action_target'] = true;

	if (!empty($actionList))
		$lAdmin->AddGroupActionTable($actionList, $actionListParams);
	unset($actionListParams, $actionList);
}

$lAdmin->BeginEpilogContent();
?>
	<input type="hidden" name="go_path" id="go_path" value="">
<?
$lAdmin->EndEpilogContent();

$aContext = array();
ob_start();
?>
<form action="<?=$APPLICATION->GetCurPage()?>" name="form1">
<table cellspacing="0">
<input type="hidden" name="lang" value="<?=LANGUAGE_ID?>">
<?=bitrix_sessid_post()?>
<tr>
	<td style="padding-left:5px;"><?=GetMessage("TRANS_PATH")?></td>
	<td style="padding-left:5px;"><input class="form-text" type="text" name="path" id="path_to" size="50" value="<?=htmlspecialcharsbx($path)?>"></td>
	<td style="padding-left:3px; padding-right:3px;"><input type="submit" value="<?=GetMessage("TRANS_GO")?>" class="form-button"></td>
</tr>
</table>
</form>
<?
$s = ob_get_contents();
ob_end_clean();
$aContext[] = array("HTML"=>$s);
// Search / replace
$sFormValues = 1;
$url = $APPLICATION->GetPopupLink(
					array(
						'URL' => "/bitrix/admin/translate_search.php?lang=".LANGUAGE_ID."&bxpublic=Y&path=".urlencode($path),
								'PARAMS' => array(
									'width' => 470,
									'height' => 310,
									'resizable' => false
								)
					)
				);
$aContext[] = array(
	"TEXT" => $useSearch ? GetMessage("TR_NEW_SEARCH") : GetMessage("TR_SEARCH"),
	"ICON" => "btn_fileman_search",
	"LINK" => 'javascript:'.$url,
	"TITLE" => GetMessage("TR_SEARCH_TITLE")
);

if (!$AUTO_CALCULATE || $IS_LANG_DIR)
{
	$aContext[] = array('NEWBAR' => true);
}
if (!$AUTO_CALCULATE)
{
	if ($SHOW_LANG_DIFF)
	{
		$aContext[] = array(
				"TEXT"	=> GetMessage('TR_NO_SHOW_DIFF_TEXT'),
				"LINK"	=> $APPLICATION->GetCurPageParam('SHOW_DIFF=N&path='.urlencode($path), array('SHOW_DIFF', 'mode', 'path')),
				"TITLE"	=> GetMessage('TR_NO_SHOW_DIFF_TITLE'),
			);
	}
	else
	{
		$aContext[] = array(
				"TEXT"	=> GetMessage('TR_SHOW_DIFF_TEXT'),
				"LINK"	=> $APPLICATION->GetCurPageParam('SHOW_DIFF=Y&path=' . urlencode($path), array('SHOW_DIFF', 'mode', 'path')),
				"TITLE"	=> GetMessage('TR_SHOW_DIFF_TITLE'),
				"ICON" => "btn_green"
			);
	}
}

if ($IS_LANG_DIR)
{
	$aContext[] = array(
			"TEXT"	=> GetMessage('TR_CHECK_FILES_TEXT'),
			"LINK"	=> "translate_check_files.php?lang=".LANGUAGE_ID."&path=" . htmlspecialcharsbx($path),
			"TITLE"	=> GetMessage('TR_CHECK_FILES_TITLE'),
		);
}

$lAdmin->AddAdminContextMenu($aContext, false, false);

$lAdmin->CheckListMode();

$aTabs = array(
	array("DIV" => "fileupl1", "TAB" => GetMessage("TR_FILEUPLFORM_TAB1"),
		"TITLE" => GetMessage("TR_UPLOAD_FILE"), 'ONSELECT' => "BX('tr_submit').value='".GetMessage("TR_UPLOAD_SUBMIT_BUTTON")."'"),
	array("DIV" => "filedown2", "TAB" => GetMessage("TR_FILEDOWNFORM_TAB2"),
		"TITLE" => GetMessage("TR_DOWNLOAD_CSV_TEXT"), 'ONSELECT' => "BX('tr_submit').value='".GetMessage("TR_DOWNLOAD_SUBMIT_BUTTON")."'")
);

$tabControl = new CAdminTabControl("tabControl", $aTabs, false);

$APPLICATION->SetTitle(GetMessage("TRANS_TITLE"));
require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/prolog_admin_after.php");
if ($arCSVMessage)
{
	CAdminMessage::ShowMessage($arCSVMessage);
}

$lAdmin->DisplayList();

if ($TRANS_RIGHT == 'W')
{
	?>
	<br>
	<?$tabControl->Begin();?>
	<form action="<?=$APPLICATION->GetCurPageParam('go_path='.htmlspecialcharsbx($path), array('go_path'))?>" name="form3" method="POST" enctype="multipart/form-data">
	<?$tabControl->BeginNextTab();?>

	<tr>
		<td width="10%" nowrap><?=GetMessage("TR_UPLOAD_CSV_FILE")?></td>
		<td valign="top" width="90%"><input type="file" name="csvfile"></td>
	</tr>
	<tr>
		<td width="10%" valign="top" nowrap><?=GetMessage('TR_FILE_ACTIONS')?></td>
		<td valign="top" width="90%">
		<input type="hidden" name="upload_csv" value="1" >
		<?=bitrix_sessid_post()?>
		<input id="F_ACTION_1" type="radio" name="rewrite_lang_files" value="N" checked><label for="F_ACTION_1"><?=GetMessage('TR_NO_REWRITE_LANG_FILES')?></label><br>
		<input id="F_ACTION_3" type="radio" name="rewrite_lang_files" value="U"><label for="F_ACTION_3"><?=GetMessage('TR_UPDATE_LANG_FILES')?></label><br>
		<input id="F_ACTION_2" type="radio" name="rewrite_lang_files" value="Y"><label for="F_ACTION_2"><?=GetMessage('TR_REWRITE_LANG_FILES')?></label>
		</td>
	</tr>

<?$tabControl->EndTab();?>
</form>
	<?$tabControl->BeginNextTab();?>
	<form action="translate_csv_download.php" name="form4" method="POST">
		<tr>
			<td width="10%" valign="top" nowrap><?=GetMessage('TR_FILE_ACTIONS')?></td>
			<td valign="top" width="90%">
				<input type="hidden" name="lang" value="<?=LANGUAGE_ID;?>" >
				<input type="hidden" name="path" value="<?=htmlspecialcharsbx($path);?>" >
				<?=bitrix_sessid_post()?>
				<input id="F_ACTION_2_1" type="radio" name="download_translate_lang" value="A" checked><label for="F_ACTION_2_1"><?=GetMessage('TR_DOWNLOAD_LANG')?></label><br>
				<input id="F_ACTION_2_2" type="radio" name="download_translate_lang" value="N"><label for="F_ACTION_2_2"><?=GetMessage('TR_DOWNLOAD_NO_TRANSLATE')?></label>
			</td>
		</tr>
		<?
		$customScriptsFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/langs.txt";
		if(file_exists($customScriptsFile)):
		?>
		<tr>
			<td width="10%" valign="top" nowrap>Only /bitrix/modules/langs.txt files:</td>
			<td valign="top" width="90%">
				<input type="checkbox" name="use_custom_list" value="Y">
			</td>
		</tr>
		<?endif?>
	</form>
<?
	$tabControl->Buttons();
?>
	<input type="submit" id="tr_submit" value="<?=GetMessage("TR_UPLOAD_SUBMIT_BUTTON")?>" class="adm-btn-save">
	<script type="text/javascript">
	BX.bind(BX('F_ACTION_2'), 'click', function(){
		if (!confirm('<? echo GetMessageJS('CONFRIM_REWRITE_LANG_FILES'); ?>'))
		{
			BX('F_ACTION_2').checked = false;
			BX('F_ACTION_1').checked = true;
		}
	});
	BX.bind(BX('tr_submit'), 'click', function ()
	{
		if (BX('tabControl_active_tab').value === 'fileupl1') {
			document.forms['form3'].submit();
		} else {
		document.forms['form4'].submit();
		}
	});
	</script>
<?
	$tabControl->End();
}
require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_admin.php");