      </div>
<? if (isset($explicate) && $explicate === true) { ?>
<div id="explicate" <?=isset($szo)?"":"style=\"display: none;\""?>>
  <div class="close">
    <a id="closeExplicate"><img src="images/close.png" alt="bezar" /></a>
    <script type="text/javascript" language="javascript">
	$("a#closeExplicate").click(function() {
		$('#explicate').hide();
	});
    </script>
  </div>
  <iframe id="explframe" name="explicate" width="100%" height="100%" src="explicate.php?fh=<?=$szo?>">
  </iframe>
</div>
<? } ?>

    </div>
  </body>
</html>
