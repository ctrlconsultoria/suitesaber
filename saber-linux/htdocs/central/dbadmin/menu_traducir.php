<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      menu_traducir.php
 * @desc:      Allows to translate the different messages.
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



include("../lang/prestamo.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
include("../lang/iah_conf.php");
include("../lang/profile.php");
include("../common/get_post.php");
include("../common/header.php");
$encabezado="";
echo "<body>\n";
if (isset($arrHttp["encabezado"])){
	$encabezado="&encabezado=s";
   	include("../common/institutional_info.php");
}else{
	$encabezado="";
}
echo "
	<div class=\"sectionInfo\">
	<div class=\"breadcrumb\"><h3>".
	$msgstr["translate"]."
	</h3></div>
	<div class=\"actions\">\n";
if (isset($arrHttp["encabezado"])){
	echo "<a href=\"../common/inicio.php?reinicio=s";
	if (isset($arrHttp["base"]))echo "&base=".$arrHttp["base"];
	echo "\" class=\"defaultButton backButton\">
		<span><strong>". $msgstr["back"]."</strong></span>
		</a>
	";
}
echo "</div>
			<div class=\"spacer\">&#160;</div>
		</div>";
?>


	<script>
	$(function() {
		$( "#tabs" ).tabs().find( ".ui-tabs-nav" ).sortable({ axis: "x" });
	});
	</script>
		<style type="text/css">
			/*demo page css*/
			.demoHeaders { margin-top: 2em; }
			#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}
		</style>


<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_traducir.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/menu_traducir.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp; Script: menu_traducir.php";
?>
</font>
	</div>
<div class="middle homepage">

		<div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php echo $msgstr["traducir"]?></a></li>
				<li><a href="#tabs-2"><?php echo $msgstr["tradyudas"]?></a></li>
			</ul>

<div id="tabs-1">

	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
		<div class="boxTop">
			<div class="btLeft">&#160;</div>
			<div class="btRight">&#160;</div>
		</div>
		<div class="boxContent titleSection">
			<div class="sectionTitle">
				<h4><strong><?php echo $msgstr["traducir"]?></strong></h4>
			</div>
			<div class="sectionButtons">
				<a href="translate.php?lang=<?php echo $_SESSION["lang"]?>&componente=admin.tab<?php echo $encabezado?>" class="menuButton tooltip listButton">

					<span><strong><?php echo $msgstr["catalogacion"]?></strong></span>
				</a>

				<a href="translate.php?lang=<?php echo $_SESSION["lang"]?>&componente=dbadmin.tab<?php echo $encabezado?>" class="menuButton tooltip databaseButton">

					<span><strong><?php echo $msgstr["dbadmin"]?></strong></span>
				</a>
				<a href="translate.php?lang=<?php echo $_SESSION["lang"]?>&componente=soporte.tab<?php echo $encabezado?>" class="menuButton tooltip utilsButton">

					<span><strong><?php echo $msgstr["maintenance"]?></strong></span>
				</a>
                      <a href="translate.php?lang=<?php echo $_SESSION["lang"]?>&componente=prestamo.tab<?php echo $encabezado?>" class="menuButton tooltip importButton">

					<span><strong><?php echo $msgstr["prestamo"]?></strong></span>
				</a>
				 <a href="translate.php?lang=<?php echo $_SESSION["lang"]?>&componente=statistics.tab<?php echo $encabezado?>" class="menuButton tooltip statButton">

					<span><strong><?php echo $msgstr["statistics"]?></strong></span>
				</a>
				<a href="translate.php?lang=<?php echo $_SESSION["lang"]?>&componente=acquisitions.tab<?php echo $encabezado?>" class="menuButton tooltip databaseButton">

					<span><strong><?php echo $msgstr["acquisitions"]?></strong></span>
				</a>
                <a href="translate.php?lang=<?php echo $_SESSION["lang"]?>&componente=iah_conf.tab<?php echo $encabezado?>" class="menuButton tooltip databaseButton">

					<span><strong><?php echo $msgstr["iah-conf"]?></strong></span>
				</a>
				<a href="translate.php?lang=<?php echo $_SESSION["lang"]?>&componente=profile.tab<?php echo $encabezado?>" class="menuButton tooltip userButton">

					<span><strong><?php echo $msgstr["profiles"]?></strong></span>
				</a>
			</div>
			<div class="spacer">&#160;</div>
		</div>
		<div class="boxBottom">
			<div class="bbLeft">&#160;</div>
			<div class="bbRight">&#160;</div>
		</div>
	</div>
</div>
<div id="tabs-2">
	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
		<div class="boxTop">
			<div class="btLeft">&#160;</div>
			<div class="btRight">&#160;</div>
		</div>
		<div class="boxContent titleSection">
			<div class="sectionTitle">
				<h4><strong><?php echo $msgstr["tradyudas"]?></strong></h4>
			</div>
			<div class="sectionButtons">
				<a href="trad_ayudas_dataentry.php?><?php echo $encabezado?>" class="menuButton tooltip listButton">

					<span><strong><?php echo $msgstr["catalogacion"]?></strong></span>
				</a>

				<a href="trad_ayudas_adm.php?<?php echo $encabezado?>" class="menuButton tooltip databaseButton">

					<span><strong><?php echo $msgstr["dbadmin"]?></strong></span>
				</a>
    			<a href="trad_ayudas_loan.php?lang=<?php echo $_SESSION["lang"]?>&componente=prestamo.php<?php echo $encabezado?>" class="menuButton tooltip importButton">

					<span><strong><?php echo $msgstr["prestamo"]?></strong></span>
				</a>
				<a href="trad_ayudas_statistics.php?lang=<?php echo $_SESSION["lang"]?>&componente=estadisticas.php<?php echo $encabezado?>" class="menuButton tooltip statButton">

					<span><strong><?php echo $msgstr["statistics"]?></strong></span>
				</a>

			</div>
			<div class="spacer">&#160;</div>
		</div>
		<div class="boxBottom">
			<div class="bbLeft">&#160;</div>
			<div class="bbRight">&#160;</div>
		</div>
	</div>
<form name=admin method=post action=administrar_ex.php onSubmit="Javascript:return false">
<input type=hidden name=base>
<input type=hidden name=cipar>
<input type=hidden name=Opcion>
</form>
</div>
</div>

<?php include("../common/footer.php");?>

</body>
</html>
