<?php
	if($page=="register" || $page=="lost" || $page=="password")
	{
		print '<script type="text/javascript">
			var site_url = "'.$site_url.'";
			var not_available = "'.$lang['not-available'].'";
			var no_special_chars = "'.$lang['no-special-chars'].'";
			var no_password_r = "'.$lang['no-password-r'].'";
		</script>';
		print '<script src="'.$site_url.'js/register.js"></script>';
	} else if($page=="news" || $page=="read")
	{
		if($database->is_loggedin())
			if($web_admin>=$jsondataPrivileges['news'])
				print '<script src="https://cdn.ckeditor.com/4.8.0/full/ckeditor.js"></script>';
	}
	else if($page=="admin" && $a_page=="players")
	{
?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("body").tooltip({ selector: '[data-toggle=tooltip]' });
		});
		
		$(document).on("click", ".open-accountID", function () {
			 var account_id = $(this).data('id');
			 $(".modal-body #accountID").val( account_id );

			 document.getElementById("banModal").innerText = "<?php print $lang['ban']; ?> - " + document.getElementById(account_id).innerText;
			 document.getElementById("unBanModal").innerText = "<?php print $lang['unban']; ?> - " + document.getElementById(account_id).innerText;
		});
	</script>
<?php } else if($page=="referrals" || ($page=="admin" && $a_page=="redeem")) { ?>
<script>
	document.getElementById("copyButton").addEventListener("click", function() {
		copyToClipboard(document.getElementById("share"));
	});

	function copyToClipboard(elem) {
		var targetId = "_hiddenCopyText_";
		var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
		var origSelectionStart, origSelectionEnd;
		if (isInput) {
			target = elem;
			origSelectionStart = elem.selectionStart;
			origSelectionEnd = elem.selectionEnd;
		} else {
			target = document.getElementById(targetId);
			if (!target) {
				var target = document.createElement("textarea");
				target.style.position = "absolute";
				target.style.left = "-9999px";
				target.style.top = "0";
				target.id = targetId;
				document.body.appendChild(target);
			}
			target.textContent = elem.textContent;
		}
		var currentFocus = document.activeElement;
		target.focus();
		target.setSelectionRange(0, target.value.length);
		
		var succeed;
		try {
			  succeed = document.execCommand("copy");
		} catch(e) {
			succeed = false;
		}
		if (currentFocus && typeof currentFocus.focus === "function") {
			currentFocus.focus();
		}
		
		if (isInput) {
			elem.setSelectionRange(origSelectionStart, origSelectionEnd);
		} else {
			target.textContent = "";
		}
		return succeed;
	}
</script>
<?php } else if($page=="admin" && $a_page=="player_edit") { ?>
<script src="<?php print $site_url; ?>js/bootstrap-select.js"></script>
<script>
$('select.selectpicker').selectpicker({
  caretIcon: 'fa fa-angle-down'
});
</script>
<?php } ?>