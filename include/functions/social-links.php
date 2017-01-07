<?php
	function getSocialLinks()
	{
		global $social_links;

		$html = '';
		foreach($social_links as $social => $link)
			if($link)
				$html = $html . '<li class="cms2-u"><a href="'. $link .'" title="'. ucfirst($social) .'" target="_blank" class="'. $social .' hide-txt">'. ucfirst($social) .'</a></li>';

		return $html;
	}