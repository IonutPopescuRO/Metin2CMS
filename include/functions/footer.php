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
			if($web_admin>=$news_lvl)
				print '<script src="http://cdn.ckeditor.com/4.5.10/full/ckeditor.js"></script>';
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
<?php } ?>