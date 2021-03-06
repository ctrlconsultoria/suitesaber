<?php

include "../../meta.php";

function AsociarVinculo($linea){
 	$ix=strpos($linea,"<");
 	if ($ix>0) {
    	echo "<br>".substr($linea,$ix);
 	}
}


function DibujarHtmlArea($tag,$linea,$numl,$tipoH){
 global $valortag,$fdt,$ver,$arrHttp,$Path,$xEditor,$xUrlEditor,$FCKConfigurationsPath,$FCKEditorPath,$db_path;
	if (trim($numl)=="") $numl=20;
	$numl=$numl*30;
	if ($tipoH!="B"){
		if (!isset($valortag[$tag])) {
	   		$valortag[$tag]="";
	  	}else{
	  		$valortag[$tag]=trim($valortag[$tag]);
	  	}
	}else{
		$fp=file($db_path.$arrHttp["base"]."/html/".trim($valortag[$tag]));
		$valortag[$tag]="";
		foreach ($fp as $value) $valortag[$tag].=trim($value);
	}
	  $valortag[$tag]=str_replace("\n","",$valortag[$tag]);
?>
<script type="text/javascript">

// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// oFCKeditor.BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
//var sBasePath = document.location.pathname.substring(0,document.location.pathname.lastIndexOf('_testcases')) ;
	var sBasePath='<?php echo $FCKEditorPath;?>'
	var oFCKeditor = new FCKeditor( 'tag<?php echo $tag?>','95%',<?php echo $numl?> ) ;
	oFCKeditor.BasePath	= sBasePath ;
	oFCKeditor.Config["CustomConfigurationsPath"] = "<?php echo $FCKConfigurationsPath?>"
	oFCKeditor.Config["DefaultLanguage"]		= "<?php echo $_SESSION["lang"]?>" ;

	oFCKeditor.Value	= '<?php echo str_replace("'","`",$valortag[$tag])?>' ;
	oFCKeditor.Create() ;
</script>




<?
}

function SubCampo($campo,$ksc){

	$ixpos=strpos($campo,'^'.$ksc);
	if($ixpos===false){
		$campo="";
	}else{
		$campo=substr($campo,$ixpos+2);
		$ixpos=strpos($campo,'^');
		if($ixpos===false){
		}else{
			$campo=substr($campo,0,$ixpos);
		}
	}
	return $campo;
}


function DibujarTabla($filas,$tag,$fondocelda,$field_t){
//foreach ($filas as $l) echo "$l<br>";
 global $valortag,$fdt,$ver,$arrHttp,$Path,$db_path,$lang_db,$config_date_format,$arrHttp;
 $TablaLeida="";
 $cipar=$arrHttp["cipar"];
 $seleccion="";
 $celda="";
 $cols=-1;
 $columnas= Array();
 $size= Array ("");
 $t=explode('|',$field_t);
 $subc=$t[5];
 $cant_cols=strlen($subc);
 $cant_fil=$t[8];
 if ($cant_fil==0)$cant_fil=10;
 if ($ver and $cant_fil!=1){
  	$celda=" cellpadding=0 cellspacing=1 border=0 ";
  	if (count($filas)==0) return;
 }
 $seleccion= Array();
 $ind=Array();
 echo "<td colspan=5>\n<table border=0 ";
 if ($cant_fil==1 or !$ver) {
  	echo " bgcolor=white";
 }else{
 	 echo " bgcolor=white";
 }
 echo " $celda>";
echo "<td colspan=$cant_cols><strong>".$t[2]."</strong></td><tr>";
 $indice_alfa="";  // para desplegar el �ndice alfab�tico del campo
 foreach($filas as $lin){

    if (trim($lin)!=""){
	    $l=explode('|',$lin);
	  	$cols=$cols+1;
	  	$len=$l[9];
	 	$size[$cols]=$len;
	  	$Tabla=$l[10];
	  	$Tab_name=$l[11];
	    if (trim($Tabla)!=""){
	    	switch ($Tabla){
	   			case "P":
	   				$Tab_name=str_replace("%path_database%",$db_path,$Tab_name);
		   			$xx=explode('/',$Tab_name);
					if (count($xx)>1){
						$fp=file($Tab_name);
					}else{
						if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$Tab_name))
		    				$fp = file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$Tab_name);
		 				else
							$fp = file($db_path.$arrHttp["base"]."/def/".$lang_db."/".$Tab_name);
					}
	    			foreach ($fp as $tab) {
	   					if (trim($tab)!=""){

	   					// if the table is bases.dat and the databases are purchaseorder or suggestions, include only the databases wich has copies database
	   						if ($Tab_name==$db_path."bases.dat" and ($arrHttp["base"]=="purchaseorder" or $arrHttp["base"]=="suggestions")){     // aqui se filtran las bases de datos para adquisiciones
	   							$tbz=explode('|',$tab);

	   							if (isset($tbz[2]) and trim($tbz[2])=="Y"){
	   							}else{
	   								continue;
	   							}
	   						}
	   						if (!isset($seleccion[$cols]) or $seleccion[$cols]=="")
	   							$seleccion[$cols]=$tab;
	   						else
	     						$seleccion[$cols].=";".$tab;
	     				}
	   				}
	   				break;
	  		}
	  	}
	  	$ind[$cols]=$lin;
		if (trim($l[2])!="" and $l[7]!="I") {     //columns title
		    echo "<td bgcolor=#eeeeee><b>".trim($l[2])."</b></td>";
		}
	}
}
 	$filas=explode("\n",$valortag[$tag]);
 	if ($ver) {
  		$tope=count($filas);
 	} else {
  		$tope=$cant_fil;
 	}
 	for ($i=0;$i<$tope;$i++){
  		if ($i>=count($filas)){
   			$valorf="";

  		} else {
   			$valorf=trim($filas[$i]);
   			if ($valorf!=""){
    			for ($isc=0;$isc<strlen($subc);$isc++){
     				$delim=substr($subc,$isc,1);
     				$pos=strpos($valorf, "^".$delim);
     				if (is_integer($pos)) {
      					$campo=substr($valorf,$pos+2,strlen($valorf));
      					$pos=strpos($campo, "^");
      					if (!is_integer($pos)) $pos=strlen($campo);
      					$campo=substr($campo,0,$pos);
      						$columnas[$isc]=$campo;
     				} else {
      					if ($ver){
       						$columnas[$isc]="&nbsp;";
      					}else{
       						$columnas[$isc]="";
      					}
     				}
    			}
   			}
  		}
  		echo "<tr>";
  		for ($j=0;$j<=$cols;$j++){
   			$n=$size[$j];
   			if ($n==0) $n=100;
  	 		$campo="";
   			if (count($columnas)>0) {
    			if ($i<count($filas)){
     				$campo=$columnas[$j];
    			} else {
     				if ($ver){
      					$campo=" &nbsp; ";
     				}else {
      					$campo="";
     				}
    			}
   			}


    		if (!$ver) {
     			$linea=$ind[$j];
     			$type_de=explode("|",$linea);
				$Etq=$tag."_".$i."_".substr($subc,$j,1);
				echo "<td bgcolor=#FFFFFF  valign=top>";
				if ($type_de[10]=="D"){
					if ($j==0){
						$sc_col=$subc;
					}else{
						$sc_col=substr($subc,j,1);
					}
					$separa=";";
					$base_alfa=$type_de[11];
					if ($base_alfa=="") $base_alfa=$arrHttp["base"];
					$Formato_alfa=$type_de[13];
					$prefijo=$type_de[12];
				    echo "<a id='indice' href='javascript:AbrirIndiceAlfabetico(document.forma1.tag$Etq,\"$prefijo\",\"$sc_col\",\"$separa\",\"$base_alfa\",\"$base_alfa.par\",\"tag$Etq\",\"1\",\"\",\"$Formato_alfa\")'>i</a>";
				}
				switch($type_de[7]){
					case "I":
						echo "<input type=hidden name=tag$Etq id=tag$Etq value=\"".$campo."\">\n";
						break;
					case "S":
	   					$nombrec="tag".$tag."_".$i."_".substr($subc,$j,1);
			   			if (isset($seleccion[$j]) && ($seleccion[$j]!="")){
			   				if (!$ver){
			    				echo "<select name=".$nombrec.">\n";
			    				echo "<option value=''></option>";
			    		//		echo $seleccion[$j]."<br>";
			    				$opcion=explode(";",$seleccion[$j]);
			    				foreach ($opcion as $lin){
			    					if (trim($lin)!=""){
			    						$lt=explode('|',$lin);
				     					echo "<option value=\"".trim($lt[0])."\"";
			     						if (trim(strtoupper($campo))==trim(strtoupper($lt[0])) && $campo!="") echo " selected";
			     						echo ">".trim($lt[1])."\n";
			     					}
			    				}
			    				echo "</select>";
			    			}

						}
						break;
					case "D":    //fecha, se presenta el calendario
						$ix_iso=$j+1;
						$next_field=explode('|',$ind[$ix_iso]);  //IF THE NEXT FIELD IS AN ISO FIELD CALL THE CONVERSION PROCEDURE
       					if (trim($next_field[7])=="ISO"){
       						$iso_tag="tag".$tag."_".$i."_".substr($subc,$j+1,1);
						}else{
							$iso_tag="";
						}
						echo "<!-- calendar attaches to existing form element -->
							<input type=text size=8 name=tag$Etq id=tag$Etq value='";
							if (trim($campo)!="") echo $campo;
							echo "'";
							if ($iso_tag!="") echo " onChange='Javascript:DateToIso(this.value,document.forma1.$iso_tag)'";
						echo "/>
 						<img src=\"../dataentry/img/calendar.gif\" id=\"f_tag$Etq\" style=\"cursor: pointer;\" title=\"Date selector\"
     						 />
							 <script type=\"text/javascript\">
							  Calendar.setup({
							      inputField     :    \"tag$Etq\",     // id of the input field
							       ifFormat       :    \"";
				        if ($config_date_format=="DD/MM/YY")    // format of the input field
				        	echo "%d/%m/%Y";
				        else
				        	echo "%m/%d/%Y";
				        echo "\",
							      button         :    \"f_tag$Etq\",  // trigger for the calendar (button ID)
							      align          :    \"\",           // alignment (defaults to \"Bl\")
							      singleClick    :    true
							  });
							</script>

							";
						//echo "<input type=text name=tag".$Etq." size=10 value=\"".$campo."\" onKeyDown=\"javascript:popUpCalendar(this, tag$Etq, 'dd/mm/yyyy',1)\"><a href=\"\" onClick=\"javascript:popUpCalendar(this, tag$Etq , 'dd/mm/yyyy',1);return false\"><img src=../dataentry/img/calendar.gif border=0 width=34 height=21 align=ABSBOTTOM ></a>\n";
						break;
					case " ":
					case "":
					case "ISO":
					case "X":
						if ($type_de[8]>0){
							echo "<textarea name=tag".$Etq." rows=".$type_de[8]." cols=".$type_de[9]." class=td>$campo</textarea>";
						}else{
							echo "<input type=text name=tag".$Etq." size=$n class=td value=\"$campo\">";
						}

    					break;
    				case "XF":
    					echo "<input type=text name=tag".$Etq." size=$n maxlength=$n class=td value=\"$campo\">";
    					break;
    				case "U":
     					echo "<input type=text name=tag".$Etq." size=$n class=td value=\"$campo\">";
     					echo "<a href=javascript:EnviarArchivo('tag$Etq')><img src=../dataentry/img/upload.gif border=0 alt=\"Subir archivo al servidor\"></a>
     					&nbsp; <a href=javascript:DesplegarArchivo('tag$Etq')>Ver</a?";
     					break;
     				case "K":
     					echo "<input type=text name=tag".$Etq." size=$n class=td value=\"$campo\">";
     					echo "<a href=javascript:EnviarArchivo('tag$Etq')><img src=../dataentry/img/upload.gif border=0 alt=\"Subir archivo al servidor\"></a>";

   						echo "<a href=javascript:EditarArchivo('tag$Etq')><img src=../dataentry/img/edit.gif border=0 alt=\"Editar archivo existente\"></a>";
  						break;
 					case "AI":
 						echo "<input type=hidden name=autoincrement value=$Etq>";
 						echo "<input type=hidden name=tag".$Etq." size=$n class=td value=\"$campo\">$campo";
 						break;
 					case "RO":
 						echo "<input type=hidden name=tag".$Etq." size=$n class=td value=\"$campo\">";
 						echo $campo;
 						break;
	  			}

				echo "</td>\n";
   			}else {
    			echo "$campo</td>\n";
   			}
  		}
 	}
 	echo "</td></table>\n</td></td>";
 	//if (substr($linea,37,1)!=1) echo "<td bgcolor=$fondocelda> </td>";
}

function DecodificaSubCampos($campo,$numsubc,$subc,$delimsc){
	if (trim($delimsc)=="") return;
	$valores=explode("\n",$campo);
	$salida="";
	foreach ($valores as $lin){
		 for ($isc=0;$isc<strlen($subc);$isc++){
		   	$delim=substr($subc,$isc,1);
		   	$pos=strpos($lin, "^".$delim);
		   	if (is_integer($pos)) {
		   		if ($isc==0)
		   			$delim="";
				else
		   			$delim=substr($delimsc,$isc,1);
		    	$lin=substr($lin,0,$pos).$delim." ".substr($lin,$pos+2);
		  	}

		 }
         $salida=$salida."\n".$lin;
	}
	return $salida;
}


function DibujarCheck($filas,$fondocelda,$valor,$tag,$opciones,$tope,$tipo,$subc){
global $ver,$base,$arrHttp,$Path,$db_path,$lang_db;

echo "<td class=textbody03 align=left valign=top>";
if (!$ver){
	if ($tope>1) {
    	echo "<table>\n";
	}
//	echo $db_path.$arrHttp["base"]."/".$opciones;
	if (strpos($opciones,'%path_database%')===false){
		if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$opciones))
    		$fp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$opciones);
    	else
    		$fp=file($db_path.$arrHttp["base"]."/def/".$lang_db."/".$opciones);
	}else{
		$fp=file(str_replace('%path_database%',$db_path,$opciones));
	}
    $i=0;
    $j=0;
    $ixo=-1;
    $val=split("\n",$valor);
    foreach ($fp as $linea){
    	$linea=trim($linea);
   		if ($linea!=""){
			if ($tope>1) {
			   	echo "<td class=td nowrap>";
			}
         //   echo ($subc);
			$opc=explode('|',$linea);

			if ($opc[0]=="") $opc[0]=$opc[1];
			if (!isset($opc[1]))$opc[1]=$opc[0];
			$opcVal=$opc[0];
			if (trim($subc)!=""){
				$opcVal="^".substr($subc,0,1).$opc[0]."^".substr($subc,1,1).$opc[1];
			}
			$i++;

      		if ($tipo=="R") echo "<input type=radio name=tag$tag value=\"".$opcVal."\"";
      		if ($tipo=="C") echo "<input type=checkbox name=tag$tag value=\"".$opcVal."\"";
      		foreach ($val as $check) {

      			if ($subc!=""){
      				$cc=explode('^',$check);
      				if (isset($cc[1]))$check=substr($cc[1],1);
      			}
      			if (trim($check)==trim($opc[0])) echo " checked";
      		}
      		echo ">".$opc[1]." &nbsp; &nbsp;\n";
			if ($tope>1) {
				echo "</td>";
			}
			$ixo=$ixo+1;

     		if ($ixo>=$tope-1 and $tope>1) {
        		$ixo=-1;
      			echo "<tr>";
     		}else{
				if ($tope==0) echo "<br>";
			}
    	}
  	}
	if ($tope>1) {
	    echo "</table>";
	}
 }else {
  	$filas=explode("\n",$valor);
  	$ix=0;
//  	echo "<td>";
  	foreach ($filas as $lin){
   		$ix=$ix+1;
   		$lin=trim($lin);
   		echo "$lin";
   		if ($ix<count($filas)) echo "<br>";
  	}
 }

 echo "\n</td></TABLE>\n";
}


function DibujarSelect($linea,$fondocelda,$valor,$tag,$ksc,$opciones,$rep,$subc){
 global $ver,$base,$arrHttp,$Path,$Tabla_sel,$db_path,$lang_db;
 $t=explode('|',$linea);
 $tipo=rtrim($t[7]);
 $rep=$t[4];
 $subc=rtrim($t[5]);
 $ksc=strlen($subc);
 $delimsc=rtrim($t[6]);
echo "<td bgcolor=#FFFFFF class=textbody03>";
$TipoS="";
if ($rep==1) $TipoS=" multiple";
if (!$ver){
	if (strpos($opciones,'%path_database%')===false){
		if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$opciones))
    		$fp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$opciones);
    	else
    		$fp=file($db_path.$arrHttp["base"]."/def/".$lang_db."/".$opciones);
	}else{
		$fp=file(str_replace('%path_database%',$db_path,$opciones));
	}
   	$i=0;
   	echo "<select name=tag$tag $TipoS >\n";
	echo "<option value=\"\">";
	$val=split("\n",$valor);
	foreach ($fp as $linea){
		if ($opciones=="%path_database%bases.dat" and ($arrHttp["base"]=="purchaseorder" or $arrHttp["base"]=="suggestions")){     // aqui se filtran las bases de datos para adquisiciones
			$tbz=explode('|',$linea);

			if (isset($tbz[2]) and trim($tbz[2])=="Y"){
			}else{
				continue;
			}
		}
   		$linea=trim($linea);
		if ($linea!=""){
			$opc=explode('|',$linea);
			if (!isset($opc[1])) $opc[1]=$opc[0];
			$opcVal=$opc[0];
			if (trim($subc)!=""){
				$opcVal="^".substr($subc,0,1).$opc[0]."^".substr($subc,1,1).$opc[1];
			}
   			echo "<option value=\"".$opcVal."\"";
   			foreach ($val as $check){
   				if ($subc!=""){
      				$cc=explode('^',$check);
      				$check=substr($cc[1],1);
      			}
      			if (trim($check)==trim($opc[0]) and trim($opc[0])!="") echo " selected";
   			}
   			echo ">".$opc[1]." &nbsp; &nbsp;\n";

    	}
  	}
	echo "</select>";

}else {
  	$filas=explode("\n",$valor);
  	$ix=0;
  	foreach ($filas as $lin){
   		$ix=$ix+1;
   		$lin=trim($lin);
   		echo "$lin";
   		if ($ix<count($filas)) echo "<br>";
  	}
}

echo "\n</td></tr>\n";
}


function TextBox($linea,$fondocelda,$titulo,$ver,$len,$tag,$ksc,$rep,$delimrep,$ayuda){
 global $ixicampo,$valortag,$arrHttp,$Path,$Marc,$db_path,$lang_db,$msgstr;

 $t=explode('|',$linea);
 $tipo=rtrim($t[7]);
 if ($t[0]=="AI") $tipo="AI";
 $rep=$t[4];
 $subc=rtrim($t[5]);
 $ksc=strlen($subc);
 $delimsc=rtrim($t[6]);
 $numl=$t[8];
 $cols=$t[9];
 $tag=$t[1];
 $pref=$t[12];
 $help="";
 if (isset($t[16])) $help=$t[16];
// $upload=substr($linea,53,1);
 if ($tipo!="I"){
 	echo "<td class=rotuloIng valign=top width=150>";
 	$titulo=trim($t[2]);
 	echo $titulo;
 	echo "</td>";
 	echo "<td  bgcolor=#FFFFFF class=textbody03 align=left><!-- o asissistente era para estar aqui In�cio Campos -->";
 }
 if ($rep==1 and $numl==0) $numl=1;
 if ($numl==0) $numl=1;
 $valortag[$tag]=rtrim($valortag[$tag]);
 $dummy=explode("\n", $valortag[$tag]);
 $occurs=count($dummy);
 if ($ver) {
  	foreach ($dummy as $lin){
   		if ($ksc>0 and trim($delimsc)!="") $lin=DecodificaSubCampos($lin,$ksc,$subc,$delimsc);
   		if ($tipo!="I")echo $lin."<br>";
  	}
 } else {

  		$campo=rtrim($valortag[$tag]);
  		if ($ksc>0 && $campo!=""  and trim($delimsc)!="") $campo=DecodificaSubCampos($campo,$ksc,$subc,$delimsc);
  		if ($numl<count($dummy)) $numl=count($dummy);
  		if ($numl>30) {
      		$numl=30;
  		}


		$arrow="";
		if ($rep=="1" ) {
			$arrow="ONKEYDOWN=\"return checkKey(this, event,document.forma1.tag$tag,$ixicampo)\"";
		}
		if ($tipo=="XF") $len=$cols." maxlength=$cols";

  		if ($numl>1 or $rep=="1"){
  		  	//if ($numl<=1 ) $numl=2;
   			if ($len==0) $len="100%";
   			if ($tipo=="RO")
				$it="text onfocus=blur()";
			else
				$it="";
   			echo "<textarea rows=$numl cols=$len  name=tag$tag $arrow $it>".$campo."</textarea>";
  		}else{
   			if ($len==0) $len="100%";
			switch ($tipo){
				case "P":
					$it="password";
					$campo="";
					break;
				case "AI":
					echo "<input type=hidden name=autoincrement value=$tag>";
					$it="text onfocus=blur()";
					break;
				case "RO":
					$it="text onfocus=blur()";
					break;
				case "I":
					$it=" hidden";
					break;
				default:
					$it="text";
					break;

			}
   			echo "<input type=$it name=tag$tag size=$len value=\"$campo\" $arrow>";
   			if ($tipo=="AI") {
   				if (isset($_SESSION["permiso"]["CENTRAL_RESETLCN"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["ACQ_ALL"]) or isset($_SESSION["permiso"]["ACQ_RESETCN"])){
   					echo " <a href=javascript:ChangeSeq($tag,\"$pref\")>".$msgstr["assign"]."</a>
   					&nbsp ";
   					echo "<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/autoincrement.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
   					if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])){
						echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/autoincrement.html target=_blank>".$msgstr["edhlp"]."</a>";
					}
   				}
   			}
  		}
		if ($tipo=="U" ) {
    		echo "&nbsp; <a href=javascript:EnviarArchivo('tag$tag','".$subc."')><img src=../dataentry/img/upload.gif border=0 alt=\"Subir archivo al servidor\" align=absmiddle></a>";
			echo "&nbsp; &nbsp; <a href=javascript:DesplegarArchivo('tag$tag')><img src=../dataentry/img/toolbarSearch.png border=0 align=absmiddle></a>";
   		}
   		if ($tipo=="P")
   			echo "</td><tr><td colspan=2></td><td>Confirm password</td><td><input type=password size=$len name=confirm value=\"$campo\">";
 }
 if ($tipo!="I") echo "</td></tr>\n";

}

Function PrepararFormato() {
	global $msgstr,$vars,$ver,$fondocelda,$valortag,$ixicampo,$base,$cipar,$arrHttp,$FdtHtml,$Html_ingreso,$tagisis,$db_path,$lang_db,$default_values;
    global $config_date_format,$base_fdt;
    if ($ver=="S") $ver=true;
	$cipar=$arrHttp["cipar"];
	$ixTab=-1;
	$ixicampo=0;
	$help_url="";
	$first_time="Y";
	for ($ivars=0;$ivars<count($vars);$ivars++){
 		$linea=$vars[$ivars];
		$t=explode('|',$linea);
		$titulo=$t[2];
		$len=$t[9];
		$rep=$t[4];
		$delrep="";
		$fe=urlencode($t[13]);
		if (trim($t[17])!="")$help_url=$t[17]   ;
		$tipo_e="";
		$entryType="";
		if (!$ver or $ver and isset($valortag[$t[1]]) or ($t[0]=="H")){
		echo "</center>";
		if ($t[0]=="H" and $ivars>0){
			if ($first_time=="Y")
				$first_time="N";
			else
				echo "\n<a href=\"javascript:switchMenu('myvar_$ixant');\" style=\"text-decoration:none \"><p class=areas2>[-] $titulo_ant</p></a></div></div>\n";
			$titulo_ant=$titulo;
			echo "\n<div id=\"wrapper\">
			<a onclick=\"switchMenu('myvar_$ivars');\" style=\"text-decorarion:none \"> <p class=areas1>[+]$titulo</p></a>
			<div id=\"myvar_$ivars\" style=\"display:none\">";
			$ixant=$ivars;
		}
		echo "<table width=100% border=0 cellspacing=0 >\n";
		if (isset($t[14])) if (substr($t[13],0,1)!="@") $fe.=urlencode('`$$$`'.$t[14]);
		if ($t[0]=="H"){
			$ixTab++;

			$fondocelda="#ffffff";
			$a=$t[2];
			$pos=strpos($a,"[");
  			if ($pos===false){
			}else{
				$a=substr($a,0,$pos);
  			}
			$a=trim($a);

		//	echo "\n<tr><td width=10><a href=#INICIO><img src=../dataentry/img/61.gif border=0></a></td>";
			//echo "<td>&nbsp;</TD>\n";
  		//	echo "<td colspan=3 bgcolor=#eeefef><a name=pag$ixTab></a><strong>$a</strong></td></tr>\n";
         }else{
 	 		$tipo=$t[0];
  			$tag=$t[1];
  			$subc=rtrim($t[5]);
  			$edit_subc=rtrim($t[6]);
			$nsc=strlen(rtrim($t[5]));
			$ksc="";
			$titulo=$t[2];
			$entryType=$t[7];
			$tipo_e="";
			if ($t[7]=="TB") $tipo_e="TB";
			if ($tipo=="L"){
				$lin01=$titulo;
       			if ($lin01=="") $lin01="&nbsp;";
       				if ($t[7]!="I") echo "\n<tr><td width=10> &nbsp;</td><td width=10 align=right> &nbsp; </td><td colspan=2  ><b>".$lin01."</b></td></tr>\n";
			}else{
  				if (!isset($valortag[$tag]))
  					$valortag[$tag]="";
  				else
  					$valortag[$tag]=str_replace('"',"&quot;",$valortag[$tag]);
	  			$ayuda="";
		 		if (isset($valortag[$tag]) and $t[0]!="H"){
   					if ($ver && $valortag[$tag] || !$ver){;
   						if  ($t[7]!="I"){
      						echo "<tr><td class=tag><p id=tag>";
      					}
						if ($tag<1000 and $t[7]!="I")
							echo  $tag.$ksc;
						else
							if ($t[7]!="I") echo "&nbsp;";

     					if ($t[7]!="I")echo "</p></td>\n";

    	  				$subc=rtrim($t[5]);
	      				if (substr($subc,0,1)==" ") $subc="+".substr($subc,1);
    	  					$delimsubc=rtrim($t[6]);
      						if (substr($delimsubc,0,1)==" ") $delimsubc="+".substr($delimsubc,1);
      						if (substr($subc,0,1)==" ") $subc="+"+substr($subc,1);
      						$a=trim($t[12]);
							$c="";
   							$separa="";
   							$autoridades="";
   							if ($t[10]="D") {
   								$autoridades=$t[11];
   								if ($autoridades=="") $autoridades=$base;
   							}
   							$Repetible="";
   							if ($t[4]==1) $Repetible="R";
   							$postings=1;
   							if (!$ver){
   								echo "<td valign=top width=27>";
	     						if ($a!="" and $t[3]==0)
	     							if ($t[7]!="I") echo "<a id='indice' href='javascript:AbrirIndiceAlfabetico(document.forma1.tag$tag,\"$a\",\"$c\",\"$separa\",\"$autoridades\",\"$autoridades.par\",\"tag$tag\",\"$postings\",\"$Repetible\",\"".urlencode($fe)."\")'>i</a>";
	     						else
	     							if ($t[7]!="I") echo "";

								if ($tipo=="T"  and $tipo_e!="TB") {

					 				if ($t[7]!="I") echo "<a id='assist' href='javascript:Campos(document.forma1.tag$tag,$ixicampo,\"$fe\",\"$Repetible\",\"$help_url\",\"".$arrHttp["wks_a"]."\")'>+</a>";
						 		}else{
						 			if ($tipo=="M") {
						 				$xxwk=explode("|",$arrHttp["wks_a"]);
						 				if (isset($xxwk[4])){
						 					$fe=$xxwk[4];
						 				}else{
						 					if (isset($arrHttp["wks"]))
						 						$fe=$arrHttp["wks"];
											else
												$fe="";
										}

					 					if ($t[7]!="I") echo "<a id='assist' href='javascript:CampoFijo(document.forma1.tag$tag,$ixicampo,\"$fe\",\"$base\",\"\",\"$help_url\")'>+</a>";
									}else{
										if ($t[7]!="I") echo "";
									}
									if ($tipo=="LDR") {
										if (isset($arrHttp["wks"]))
											$fe=$arrHttp["wks"];
										else
											$fe="";

									}

						 		}
                                $help="";
						 		if (isset($t[16])) $help=$t[16];
						 		//if ($tipo!="LDR"){
						 			if ($help==1 or $help_url!=""){
						 				if ($help_url=="")
						 					if ($t[7]!="I") echo "<a id='ajuda' href=javascript:Ayuda($tag)>?</a>";
										else
											if ($t[7]!="I") echo "<a href=$help_url target=_blank></a>";
						 			}else{
						 				if ($t[7]!="I") echo "";
									}
							//	}
		     					echo "</td>\n";
                            }
   		 	 				$nsc=strlen(rtrim($t[5]));
     						$ixicampo=$ixicampo+1;
    						if ($tipo!="T" and $tipo!="M" and $tipo!="AI") $tipo_e=$entryType;
    						if ($tipo=="AI") $tipo_e="AI";
    						if ($tipo=="T") $tipo_e="E";
    						if ($tipo=="M") $tipo_e="FF";
    						if ($tipo=="LDR") $tipo_e="LDR";
    						if ($tipo=="OD") $tipo_e="OD";
    						if ($tipo=="OC") $tipo_e="OC";
    						if ($tipo=="DC") $tipo_e="DC";
    						if ($tipo=="M5") $tipo_e="M5";
    						if ($entryType=="TB") $tipo_e="TB";
    						if ($entryType=="ISO") $tipo_e="ISO";
    						if ($entryType=="RO")  $tipo_e="RO";
//     echo "<input type=hidden name=idtag value=$tag>";
							if (trim($tipo_e)=="") $tipo_e="X";
							if (!$ver and $valortag[$tag]=="") $valortag[$tag]=$t[15];
		        			switch ($tipo_e) {
		        				case "M5":     //DATE OF LAST UPDATE (FIELD 005 MARC)
		        					if (!isset($default_values) or $default_values!="S"){    //CHECK IF EDITING DEFAULT VALUES
	      								$campo=$valortag[$tag];
      									echo "\n<td valign=top width=150>";
      									echo trim($titulo)."</td>\n";
      									echo "\n<td valign=top align=left>\n";
      									if (!$ver) {
      										$campo=date("YmdHi.s");
       										echo "<input type=hidden name=tag$tag  value=\"".$campo."\" >\n";
       									}
      									echo nl2br($campo);
       									echo "</td><tr>\n";
       								}
   	   								break;
   	   							case "OC":   //OPERATOR WHO CREATED THE RECORD
   	   								if (!isset($default_values) or $default_values!="S"){    //CHECK IF EDITING DEFAULT VALUES
	      								$campo=$valortag[$tag];
      									echo "\n<td valign=top width=150>";
      									echo trim($titulo)."</td>\n";
      									echo "\n<td valign=top align=left>\n";
      									if (!$ver) {
      										if (trim($campo)=="")
      											$campo=$_SESSION["login"];
       										echo "<input type=text name=tag$tag  value=\"".$campo."\" size=20 >\n";
       									}
       									echo "</td><tr>\n";
       								}
   	   								break;
   	   							case "DC":  //DATE THE RECORD WAS CREATED
   	   								if (!isset($default_values) or $default_values!="S"){    //CHECK IF EDITING DEFAULT VALUES
	      								$campo=$valortag[$tag];
      									echo "\n<td valign=top width=150>";
      									echo trim($titulo)."</td>\n";
      									echo "\n<td valign=top align=left>\n";
      									if (!$ver) {
      										if ($campo=="")
      											$campo=date("Ymd h:i:s");
       										echo "<input type=text name=tag$tag  value=\"".$campo."\" size=20 >\n";
       									}
       									echo "</td><tr>\n";
       								}
   	   								break;
		        				case "OD":     //Operator and date
		        					if (!isset($default_values) or $default_values!="S"){    //CHECK IF EDITING DEFAULT VALUES
	      								$campo=$valortag[$tag];
      									echo "\n<td valign=top width=150>";
      									echo trim($titulo)."</td>\n";
      									echo "\n<td valign=top align=left>\n";
      									//KEEP ONLY THE NUMBER OF OCCURRENCES SPECIFIED IN THE COLUMN ROW OF THE FDT
      									$ccc=explode("\n",$campo);
      									if ($t[8]==0) $t[8]=10;
      									if (count($ccc)>=$t[8]){
      										$campo="";
      										$ix=count($ccc)-$t[8]+1;
      										for ($yx=$ix;$yx<count($ccc);$yx++){
      											if ($campo=="")
      												$campo=$ccc[$ix];
      											else
      												$campo.="\n".$ccc[$ix];
      										}
      									}
      									if (!$ver) {
      										$campo.="\n"."^d".date("Ymd h:i:s")."^o".$_SESSION["login"];
       										echo "<input type=hidden name=tag$tag  value=\"".$campo."\" >\n";
       									}
      									echo nl2br($campo);
       									echo "</td><tr>\n";
       								}
   	   								break;
		        				case "LDR":
		        				    $filas=Array();
    	   							$linea01=$vars[$ivars];

                                    $ksc=0;
                                    $ldr_tit=array();
                                    echo "<td valign=top>$titulo</td><td><table cellpadding=0 cellspacing=5  bgcolor=#EEEEEE>";
                                    for ($ixsc=1;$ixsc<=100;$ixsc++){

        								$ivars=$ivars+1;
        								$linea=$vars[$ivars];
        								if (substr($linea,0,1)!="S"){    //para detectar el fin de la descripci�n del leader
        									$ivars=$ivars-1;
        									$ixsc=999;
        								}else{
        									$ksc++;
        									$filas[]=rtrim($linea);
                                            $ld=explode("|",$linea);
                                            $ldr_tit[$ksc]=  "<tr><td>".$ld[2]." (".$ld[1].")</td>";
                                            //echo "<td align=center>".$ld[2]." (".$ld[1].")</td>";
        								}

		       						}
		       						$ksc=0;
       								foreach ($filas as $linea){
       									$ksc++ ;
       									echo $ldr_tit[$ksc];
               							$ld=explode("|",$linea);
                      					echo "<td nowrap>";
                      					$ttmsel="";
	               					    if ($ld[1]==3006){

                   							if (isset($arrHttp["wk_tipom_1"])) {
                   								 $ttmsel=$arrHttp["wk_tipom_1"];
                   							}
                   							if ($ttmsel=="") if (isset($valortag[$ld[1]]))$ttmsel=$valortag[$ld[1]];
                   						}else{
                   							if (isset($valortag[$ld[1]])) $ttmsel=$valortag[$ld[1]];
                   						}
                   						echo "<select name=tag".$ld[1].">\n";
                   						echo "<option value=\"\"></option>\n";
                   						if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$ld[11]))
                   							$fpleader=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$ld[11]);
                   						else
                   						    $fpleader=file($db_path.$arrHttp["base"]."/def/".$lang_db."/".$ld[11]);
                   						foreach ($fpleader as $value){

                   							$value=trim($value);
                      						if ($value!=""){
                      							$v=explode("|",$value);
                      							$selected="";
                      							if ( trim($v[0])==trim($ttmsel)) $selected=" selected";
	                      						echo "<option value=".$v[0]."|".$v[2]." $selected>".trim($v[1])."(".$v[0].")</option>\n";
    										}
    									}
    									echo  "</select></td>\n";
    									echo "<input type=hidden name=eti$tag value=\"$linea01\">\n";
        							}
                                    echo "</table><br></td></tr>";
       								break;
		        				case "B":   //External HTMLArea
								case "A":        //HTMLarea
									echo "<td bgcolor=#FFFFFF valign=top colspan=2>";
									echo "<strong>$titulo</strong>";
									if (!$ver) {
									//	echo "<font size=1 color=red> <i>( ".$msgstr["fck_abrir1"]." <img src=../dataentry/img/toolbar.expand.gif> ".$msgstr["fck_abrir2"].")</i></font><br>";
										DibujarHtmlArea($tag,$vars[$ivars],$t[8],$tipo_e);
										$a=str_replace("'","\"",$valortag[$tag]);
									}else{

										echo "<br><font class=td>".$valortag[$tag];
									}
									echo "</td></tr>\n";
									break;
	      						case "D":
									$campo=$valortag[$tag];
        							echo "\n<td bgcolor=#FFFFFF valign=top width=150>";
       								echo trim($titulo)."</td>\n";
       								echo "\n<td bgcolor=#FFFFFF valign=top>\n";
       								if (!$ver) {
       									$next_field=explode('|',$vars[$ivars+1]);  //IF THE NEXT FIELD IS AN ISO FIELD CALL THE CONVERSION PROCEDURE
       									if (trim($next_field[7])=="ISO"){
       										$date_tag="tag$tag"; //NAME OF THE ACTUAL FIELD FOR GENERATING THE ISO DATE
       										$iso_tag="tag".$next_field[1]; //NAME OF THE ISO FIELD
       									}else{
       										$date_tag="";
       										$iso_tag="";
       									}
       									echo "<!-- calendar attaches to existing form element -->
												<input type=text name=tag$tag id=tag$tag"."_c readonly=\"1\"  value=\"$campo\" ";
												if ($iso_tag!="") echo " onChange='Javascript:DateToIso(this.value,document.forma1.$iso_tag)'";
												echo "/>
					 							<img src=\"../dataentry/img/calendar.gif\" id=\"f_tag$tag\" style=\"cursor: pointer;\" title=\"Date selector\"
					     						  />
												 <script type=\"text/javascript\">
											    Calendar.setup({

											        inputField     :    \"tag$tag"."_c\",     // id of the input field
											        ifFormat       :    \"";
											        if ($config_date_format=="DD/MM/YY")    // format of the input field
											        	echo "%d/%m/%Y";
											        else
											        	echo "%m/%d/%Y";
											        echo "\",
											        button         :    \"f_tag$tag\",  // trigger for the calendar (button ID)
											        align          :    '',           // alignment (defaults to \"Bl\")
											        singleClick    :    true
											    });
											</script>";

	       							}else{
    	    							echo $campo;
       								}
	       							echo "</td></tr>\n";
    	   							break;
    	   						case "ISO":
    	   							$campo=$valortag[$tag];
        							echo "\n<td bgcolor=#FFFFFF valign=top width=150>";
       								echo trim($titulo)."</td>\n";
       								echo "\n<td bgcolor=#FFFFFF valign=top>\n";
       								if (!$ver) {
                                        echo "<input type=text name=tag$tag";
                                        if ($date_tag!=""){
                                        	//echo " onFocus='Javascript:DateToIso(this,document.forma1.$date_tag.value)' ";
                                        }
                                        echo " value=$campo>";
                                        $date_tag="";

	       							}else{
    	    							echo $campo;
       								}
	       							echo "</td></tr>\n";
    	   							break;
    	   						case "FF":    //MARC Campo fijo
	    	  						$filas=Array();
    	   							$linea01=rtrim($vars[$ivars]);
                                    $ksc=0;
       								for ($ixsc=1;$ixsc<=100;$ixsc++){

        								$ivars=$ivars+1;
        								$linea=$vars[$ivars];
        								if (substr($linea,0,1)!="S"){
        									$ivars=$ivars-1;
        									$ixsc=999;
        								}else{
        									$ksc++;
        									$filas[]=rtrim($linea);
        								}

		       						}
		      						TextBox($linea01,$fondocelda,$titulo,$ver,$len,$tag,$ksc,$tipo,$delrep,"");
    		   						echo "<input type=hidden name=eti$tag value=\"$linea01\">\n";
       								foreach($filas as $lin){
        								echo "<input type=hidden name=eti$tag value=\"$lin\">\n";
       								}
       								break;
	    	  					case "E":
    	   							$filas=Array();
    	   							$linea01=$vars[$ivars];
                                    $sfld=$vars[$ivars+1];
       								$sf=explode('|',$sfld);
       								if ($sf[0]!="S"){
       									for ($nx=0;$nx<count($base_fdt);$nx++){
       										$ll=$base_fdt[$nx];
       										$ll_a=explode('|',$ll);
       										if ($ll_a[1]==$tag){
       											$nsc=strlen(trim($ll_a[5]));
       											for ($ixsc=1;$ixsc<=$nsc;$ixsc++){
			        								$nx=$nx+1;
		    	    								$linea=$base_fdt[$nx];
		        									$filas[]=rtrim($linea);
				    	   						}
       											$nx=9999;
       										}

       									}
       								}else{
       									for ($ixsc=1;$ixsc<=$nsc;$ixsc++){
	        								$ivars=$ivars+1;
    	    								$linea=$vars[$ivars];
        									$filas[]=rtrim($linea);
		    	   						}

       								}

		      						TextBox($linea01,$fondocelda,$titulo,$ver,$len,$tag,$ksc,$tipo,$delrep,"");
    		   						echo "<input type=hidden name=eti$tag value=\"$linea01\">\n";
       								foreach($filas as $lin){
        								echo "<input type=hidden name=eti$tag value=\"$lin\">\n";
       								}
       								break;
       				//			case "M": DibujarCampoFijo($tag,$field_t);
       				//				break;
      							case "T":
      							case "TB":
	       							$filas=Array();
	       							$field_t=$vars[$ivars];
    	   							for ($ixsc=1;$ixsc<=$nsc;$ixsc++){
        								$ivars=$ivars+1;
        								$linea=$vars[$ivars];
    	    							$filas[]=rtrim($linea);
       								}
    								DibujarTabla($filas,$tag,$fondocelda,$field_t);
         							echo "\n";
    	   							break;
      							case "R":   //Radio button
      								$tope=$t[9];
       								echo "\n<td bgcolor=#FFFFFF valign=top width=150 class=rotuloIng>$titulo</td>\n";
       								$opciones=trim($t[11]);
									$lt=array();
									$lin="";
	       							DibujarCheck($filas,$fondocelda,$valortag[$tag],$tag,$opciones,$tope,$tipo_e,$t[5]);
       								break;
      							case "C":  //check box
									$tope=$t[9];
       								echo "\n<td bgcolor=#FFFFFF valign=top width=150 class=rotuloIng>$titulo</td>\n";
    	    						$opciones=trim($t[11]);
    	    						$lt=array();
    	   							DibujarCheck($linea,$fondocelda,$valortag[$tag],$tag,$opciones,$tope,$tipo_e,$t[5]);
       								break;
      							case "S":    //select simple o m�ltiple
      							case "M":
       								echo "\n<td bgcolor=#FFFFFF valign=top width=150 class=rotuloIng>$titulo</td>\n";
    		    					$opciones=trim($t[11]);
    	   							DibujarSelect($linea,$fondocelda,$valortag[$tag],$tag,$ksc,$opciones,$rep,$t[5]);
    	   							break;
                                case "AI":     //autoincrement
								case "X":
								case "U":
      							default:
      								TextBox($vars[$ivars],$fondocelda,$titulo,$ver,$len,$tag,$ksc,$rep,$delrep,$ayuda);
	       							break;
	    			 		}
   						}else{

						}
					}
				}
  			}
  			echo "</table>";
 		}
        }
        if (isset($titulo_ant))
		echo "\n<a href=\"javascript:switchMenu('myvar_$ixant');\"><img src=../dataentry/img/close.gif border=0><strong>close</a> $titulo_ant</div></div><p>\n";
    echo "";
	}

?>
