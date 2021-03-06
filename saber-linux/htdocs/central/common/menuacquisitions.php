	<script>
	$(function() {
		$( "#tabs" ).tabs().find( ".ui-tabs-nav" ).sortable({ axis: "x" });
	});
	</script>


<?php

	include("../config.php");


$_SESSION["MODULO"]="acquisitions";
global $arrHttp,$msgstr,$db_path,$valortag,$lista_bases;
	include ("../lang/acquisitions.php");
?>


		<div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php echo $msgstr["suggestions"]?></a></li>
				<li><a href="#tabs-2"><?php echo $msgstr["basedatos"]?></a></li>
				<li><a href="#tabs-3"><?php echo $msgstr["admin"]?></a></li>
				<li><a href="#tabs-4"><?php echo $msgstr["admin"]?></a></li>
			</ul>

<div id="tabs-1">

			<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent loanSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
					<!--	<h4>&#160;<strong><?php echo $msgstr["suggestions"]?></strong></h4> -->
					</div>
					<div class="sectionButtons">
						<a href="../acquisitions/overview.php?encabezado=s" class="menuButton tooltip  multiLine resumeButton">

							<span><strong><?php echo $msgstr["overview"]?></strong></span>
						</a>
<?php
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_NEWSUGGESTIONS"])){
?>
						<a href="../acquisitions/suggestions_new.php?encabezado=s&base=suggestions&cipar=suggestions.par" class="menuButton tooltip  multiLine newButton">

							<span><strong><?php echo $msgstr["newsugges"]?></strong></span>
						</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_APPROVREJECT"])){
?>
						<a href="../acquisitions/suggestions_status.php?base=suggestions&cipar=suggestions.par&sort=TI&encabezado=s" class="menuButton tooltip  multiLine checkButton">

							<span><strong><?php echo $msgstr["approve"]."/".$msgstr["reject"]?></strong></span>
						</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_BIDDING"])){
?>
						<a href="../acquisitions/bidding.php?base=suggestions&sort=DA&encabezado=s&menu=s" class="menuButton tooltip  multiLine biddingButton">

							<span><strong><?php echo $msgstr["bidding"]?></strong></span>
						</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_DECISION"])){
?>
						<a href="../acquisitions/decision.php?base=suggestions&sort=DA&encabezado=s&menu=s" class="menuButton tooltip  multiLine decisionButton">

							<span><strong><?php echo $msgstr["decision"]?></strong></span>
						</a>
<?php }?>
					</div>
					<div class="spacer">&#160;</div>
				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			</div>
			
</div><div id="tabs-2">
			
			
			<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent orderSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
					<!--	<h4>&#160;<strong><?php echo $msgstr["purchase"]?></strong></h4> -->
					</div>
					<div class="sectionButtons">
<?php
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_CREATEORDER"])){
?>
						<a href="../acquisitions/order_new_menu.php?base=suggestions&sort=PV&encabezado=s" class="menuButton tooltip  multiLine newButton">

							<span><strong><?php echo $msgstr["createorder"]?></strong></span>
						</a>

						<a href="../acquisitions/order.php?base=suggestions&sort=PV&encabezado=s" class="menuButton tooltip  multiLine requisitionButton">

							<span><strong><?php echo $msgstr["generateorder"]?></strong></span>
						</a>
<?php }?>
						<a href="../acquisitions/pending_order.php?base=purchaseorder&sort=PV&encabezado=s" class="menuButton tooltip  multiLine pendingButton">

							<span><strong><?php echo $msgstr["pendingorder"]?></strong></span>
						</a>
<?php if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_RECEIVING"])){
?>
						<a href="../acquisitions/receive_order.php?encabezado=s" class="menuButton tooltip  multiLine receivingButton">

							<span><strong><?php echo $msgstr["receiving"]?></strong></span>
						</a>
<?php }?>
					</div>
					<div class="spacer">&#160;</div>
				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			</div>
			
			</div><div id="tabs-3">
<?php
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_ACQDATABASES"])){
?>
			<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent dbSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
				<!--		<h4>&#160;<strong><?php echo $msgstr["basedatos"]?></strong></h4> -->
					</div>
					<div class="sectionButtons">
						<a href="../dataentry/browse.php?base=suggestions&modulo=acquisitions" class="menuButton tooltip  multiLine suggestButton">

							<span><strong><?php echo $msgstr["suggestions"]?></strong></span>
						</a>
						<a href="../dataentry/browse.php?base=providers&modulo=acquisitions" class="menuButton tooltip  multiLine userButton">

							<span><strong><?php echo $msgstr["providers"]?></strong></span>
						</a>
						<a href="../dataentry/browse.php?base=purchaseorder&modulo=acquisitions" class="menuButton tooltip  multiLine requisitionButton">

							<span><strong><?php echo $msgstr["purchase"]?></strong></span>
						</a>
						<a href="../dataentry/browse.php?base=copies&modulo=acquisitions" class="menuButton tooltip  multiLine copiesdbButton">

							<span><strong><?php echo $msgstr["copies"]?></strong></span>
						</a>

					</div>
					<div class="spacer">&#160;</div>
				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			</div>
			
			</div><div id="tabs-4">
<?php  }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_RESETCN"])){
?>
            <div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent toolSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
						<!--<h4>&#160;<strong><?php echo $msgstr["admin"]?></strong></h4>-->
					</div>

					<div class="sectionButtons">
						<a href="../acquisitions/resetautoinc.php?base=suggestions" class="menuButton tooltip  multiLine resetButton">

							<span><strong><?php echo $msgstr["resetctl"]. " (".$msgstr["suggestions"].")"?></strong></span>
						</a>
					</div>
					<div class="spacer">&#160;</div>

				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			</div>
<?php }?>
</div>
