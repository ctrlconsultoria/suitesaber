<?php
//
//Presenta la lista de sugerencias aprobadas
//SHOW THE LIST OF APPROVED SUGGESTIONS
//APPLIES THE SEARCH EXPRESSION "STA_1+or+STA_3" ON THE SUGGESTIONS DATABASE
// USES THE DISPLAY FORMATS
// BY TITLE: ti_bidding.pft,ti_bidding_tit.tab
// BY PROVIDER : rb_bidding.pft, rb_bidding_tit.tab
// BY DATE OF APPROVAL: da_bidding.pft, da_bidding_tit.tab
//

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="pt";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/acquisitions.php");

include("../common/get_post.php");
if(isset($_SESSION["permiso"]["ACQ_ACQALL"]))
	if (!isset($arrHttp["see_all"]))$arrHttp["see_all"]="Y";
include("../common/header.php");
$encabezado="";
echo "<script>
function Editar(Mfn){
	document.EnviarFrm.Mfn.value=Mfn
	document.EnviarFrm.Opcion.value=\"editar\"
	document.EnviarFrm.submit()
}
function Mostrar(Mfn){	msgwin=window.open(\"../dataentry/show.php?base=".$arrHttp["base"]."&Mfn="."\"+Mfn,\"show\",\"width=600, height=600, scrollbars, resizable\")
	msgwin.focus()}
</script>
";
echo "<body>\n";
include("../common/institutional_info.php");
$arrHttp["base"]="suggestions";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

// Se ubican todas las solicitudes que est�n pendientes (STATUS=0)
// se asigna el formato correspondiente a la clave de clasificaci�n
// se lee el t�tulo de las columnas de la tabla
switch($arrHttp["sort"]){	case "TI":
		$index="ti.pft";
		$tit="ti_tit.tab";
		break;
	case "RB":
		$index="rb.pft";
		$tit="rb_tit.tab";
		break;
	case "DR":
		$index="dr.pft";
		$tit="dr_tit.tab";
		break;
	case "OP":
		$index="op.pft";
		$tit="op_tit.tab";
		break;}
$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$index" ;
$tit_pft=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$tit";
if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$index" ;
if (!file_exists($Formato)){	echo $msgstr["missing"] ." $Formato";
	die;}
if (!file_exists($tit_pft)) $tit_pft=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$tit" ;
if (!file_exists($tit_pft)){
	echo $msgstr["missing"] ." $tit_pft";

}
$fp=file($tit_pft);
$tit_tab=implode("",$fp);
$Formato="@$Formato,/";
$Expresion="(STA_0 or STA_1 or STA_2 or STA_3 or STA_4 or STA_5 or STA_6 or STA_7)";        //recomendaciones aprobadas o en proceso de selecci�n de proveedores
if (!isset($arrHttp["see_all"])) $Expresion.=" and OPERADOR_".$_SESSION["login"];
$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&Expresion=$Expresion&Formato=$Formato&Opcion=buscar";
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
$recom=array();
$ix=-1;
foreach ($contenido as $value){
	$value=trim($value);
	if ($value!="")	{		$ix=$ix+1;
		$s=explode('|',$value);
		$key=$s[0].$ix;
		$recom[$key]=$value;	}


}
ksort($recom);
?>
<script src=../dataentry/js/lr_trim.js></script>
<script>
document.onkeypress =
  function (evt) {
    var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
	if (c==13) EnviarForma("")
    return true;
  }
function Enviar(sort){
	url="suggestions_status.php?base=suggestions&sort="+sort
	if (document.sort.see_all.checked)
		url+="&see_all=Y"
	self.location.href=url}
</script>
<?php

?>
<div class="sectionInfo">
<div class="language">		
<?php include("suggestions_menu.php");?>
</div>
</div>
	<div class="breadcrumb"><h3>
		<?php echo $msgstr["suggestions"].": ".$msgstr["approve"]."/".$msgstr["reject"]?>
	</h3></div>
	<div class="actions">	</div>

<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/approval_rejection.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/approval_rejection.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp; Script: suggestions_status.php</font>\n";
?>
	</div>
<form name=sort>
<div class="middle form">
	<div class="formContent">
         <?php echo $msgstr["pending_sort"]?>
		<div class="pagination">
			<a id=botoes  href=javascript:Enviar("TI") class="singleButton">

						<?php echo $msgstr["title"]?>
	
					</a>
			<a id=botoes href=javascript:Enviar("RB") class="singleButton">
						<?php echo $msgstr["recomby"]?>

					</a>
			<a id=botoes href=javascript:Enviar("DR") class="singleButton">

						<?php echo $msgstr["date_sug"]?>
	
					</a>
			<a id=botoes href=javascript:Enviar("OP") class="singleButton">

						<?php echo $msgstr["operator"]?>
	
					</a>
			<p align=right><input type=checkbox name=see_all
			<?php if (isset($arrHttp["see_all"])) echo " value=Y checked"?>><?php echo $msgstr["all_oper"]?>
		</div>
		</h5>
	<table class=listTable cellspacing=0 border=1>
		<tr>

<style type="text/css">
 th a { 
 font-size:14px;
 text-decoration:none;
 color:#fff;
 text-transform: uppercase;
}
</style>

<?php
// se imprime la lista de recomendaciones pendientes
	$t=explode('|',$tit_tab);
	echo "<th>&nbsp;</th>";
	foreach ($t as $v)  echo "<th>$v</th>";
	foreach ($recom as $value){		echo "<tr>";		$r=explode('|',$value);
		$ix1="";
		foreach ($r as $cell){			if ($ix1=="")
				$ix1=1;	
			else
			
			if ($ix1==1){
				echo "<td style=\"height:30px;\"><a id=botoes href=javascript:Editar($cell)>$msgstr[editar]</a>&nbsp;
				     	<a id=botoes href=javascript:Mostrar($cell)>$msgstr[ver]</a></td>";		
			$ix1=2;				}
			else
				echo "<td style=\"height:30px;\">$cell</td>";					}

	}
?>
<tr><td></td></tr>
</table>

</div>
	</div>
</div>
</form>
<form name=EnviarFrm method=post action=suggestions_status_ex.php>
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<input type=hidden name=Mfn value="">
<input type=hidden name=Opcion value="">
<input type=hidden name=sort value=<?php echo $arrHttp["sort"]?>>
<input type=hidden name=retorno value=../acquisitions/suggestions_status.php>
<input type=hidden name=encabezado value="S">
<?php if (isset($arrHttp["see_all"])) echo "<input type=hidden name=see_all value=\"S\"> ";?>
</form>
<?php include("../common/footer.php");
echo "</body></html>" ;
?>