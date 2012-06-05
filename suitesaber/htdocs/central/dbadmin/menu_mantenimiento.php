<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      menu_mantenimiento.php
 * @desc:      Implements maintenance menu options
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *  
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *  
 * == END LICENSE ==
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");

include("../common/get_post.php");
if (!isset($arrHttp["base"])) $arrHttp["base"]="";

if (strpos($arrHttp["base"],"|")===false){

}   else{
		$ix=strpos($arrHttp["base"],'^b');
		$arrHttp["base"]=substr($arrHttp["base"],2,$ix-2);
}
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
?>

<script src=../dataentry/js/lr_trim.js></script>

<script languaje=javascript>


function EnviarForma(Opcion,Mensaje){
	base="<?php echo $arrHttp["base"]?>"
	if (Opcion=="eliminarbd" || Opcion=="inicializar"){
		if (base==""){
			alert("<?php echo $msgstr["seldb"]?>")
			return
		}

	}
	if (Opcion!="explorar") Mensaje+=" "+base
//	if (confirm(Mensaje)==true){
		switch (Opcion){
			case "fullinv":
				msgwin=window.open("","fullinv","menu=no,status, width=200, height=100")
				msgwin.document.writeln("<html><title><?php echo $msgstr["mnt_gli"]?></title><body><font color=red face=verdana><?php echo $msgstr["mnt_lig"].". ".$msgstr["mnt_espere"]?> ...")
				msgwin.document.writeln("</body></html>")
				msgwin.focus()
				document.admin.target="fullinv"
				break
			case "eliminarbd":
				document.admin.base.value=base
				document.admin.cipar.value=base+".par"
				document.admin.action="eliminarbd.php"
				document.admin.target=""
				break;
			case "inicializar":
				document.admin.target=""
				break;
            case "cn":  //assign control number
            	document.admin.base.value=base
				document.admin.cipar.value=base+".par"
				document.admin.action="assign_control_number.php"
				document.admin.target=""
				break
			case "resetcn":    //RESET LAST CONTROL NUMBER IN THE BIBLIOGRAPHIC DATABASE
				document.admin.base.value=base
				document.admin.cipar.value=base+".par"
				document.admin.action="reset_control_number.php"
				document.admin.target=""
				break;
			case "linkcopies":    //LINK BIBLIOGRAPHIC DATABASE WITH COPIES DATABASE
				document.admin.base.value=base
				document.admin.cipar.value=base+".par"
				document.admin.action="copies_linkdb.php"
				document.admin.target=""
				break;
			case "unlockbd":
		   	document.admin.action="../dataentry/wxis/administrar.xis";

				break;
//			default:
//				alert("coming soon!!!!!")
				return;

		}
		document.admin.Opcion.value=Opcion
		document.admin.base.value=base
		document.admin.cipar.value=base+".par"
		document.admin.submit()
//	}

}

</script>
<style type="text/css">
#botoes {
	width: 300px; 	
	}
</style>

<body>
<?php
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}


echo "<div class=\"sectionInfo\"><div class=\"language\">";
	
if (isset($arrHttp["encabezado"])){
	echo "<a href=\"../common/inicio.php?reinicio=s&base=".$arrHttp["base"]."\" class=\"defaultButton backButton\">";
echo "<span><strong>". $msgstr["back"]."</strong></span></a>";
}	
	
echo "</div></div>
		<div class=\"breadcrumb\">";
		echo	"<h3>$msgstr[maintenance]:$arrHttp[base]</h3>";
echo		"</div><div class=\"actions\">";
		

echo	"</div>";



?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento.html target=_blank>".$msgstr["edhlp"]."</a>";
echo " &nbsp; Script: menu_mantenimiento.php";
?>

</div>
<div class="middle form">
	<div class="formContent">
<form name=maintenance>
<table cellspacing=5 width=400 align=center>
	<tr>
		<td>

		<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
         
		
			<a id="botoes" href='javascript:EnviarForma("inicializar","<?php echo $msgstr["mnt_ibd"]?>")'><?php echo $msgstr["mnt_ibd"]?></a></li>
			<a id="botoes" href='javascript:EnviarForma("eliminarbd","<?php echo $msgstr["mnt_ebd"]?>")'><?php echo $msgstr["mnt_ebd"]?></a></li>
			<a id="botoes" href='javascript:EnviarForma("lock","<?php echo $msgstr["mnt_lock"]?>")'><?php echo $msgstr["mnt_lock"]?></a></li>
			<a id="botoes" href='javascript:EnviarForma("unlock","<?php echo $msgstr["mnt_unlock"]?>")'><?php echo $msgstr["mnt_unlock"]?></a></li>
			<a id="botoes" href='javascript:EnviarForma("cn","<?php echo $msgstr["assigncn"]?>")'><?php echo $msgstr["assigncn"]?></a></li>
			<a id="botoes" href='javascript:EnviarForma("linkcopies","<?php echo $msgstr["linkcopies"]?>")'><?php echo $msgstr["linkcopies"]?></a></li>
			<a id="botoes" href='Javascript:EnviarForma("resetcn","<?php echo $msgstr["resetcn"]?>")'><?php echo $msgstr["resetcn"]?></a></li>
			<hr>
				<a  id=botoes href='javascript:EnviarForma("unlockbd","<?php echo $msgstr["mnt_desb"]?>")'><?php echo $msgstr["mnt_desb"]?></a>

		</td>
</table></form>
<form name=admin method=post action=administrar_ex.php onSubmit="Javascript:return false">
<input type=hidden name=base>
<input type=hidden name=cipar>
<input type=hidden name=Opcion>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>"?>
</form>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
