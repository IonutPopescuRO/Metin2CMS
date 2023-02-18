<?php
	@ob_start();
	include 'include/functions/header.php';
?>
<!DOCTYPE html>
<html lang="<?php print $language_code; ?>"<?php if(in_array($language_code, $rtl)) print ' dir="rtl"'; ?>>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8" />

    <title><?php print $site_title.' - '.$title; if($offline) print ' - '.$lang['server-offline']; ?></title>

    <link rel="stylesheet" href="<?php print $site_url; ?>css/eason-displaycaps-min.css">
    <link rel="stylesheet" href="<?php print $site_url; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php print $site_url; ?>css/font-awesome.min.css">
    <link rel='stylesheet' href='<?php print $site_url; ?>css/style.css' type='text/css' media='all' />
	<?php if($page=="admin" && $a_page=="player_edit") { ?>
    <link rel='stylesheet' href='<?php print $site_url; ?>css/bootstrap-select.css'/>
	<?php } ?>
	<link rel="shortcut icon" href="<?php print $site_url; ?>images/favicon.ico?v=" />
</head>

<body class="page page-parent page-template page-template-template-blog-php">

    <div class="main-hd" role="navigation">
        <div class="page-width">
            <h1>
                <a class="hide-txt"
                   href="<?php print $site_url; ?>"
                   title="<?php print $site_title; ?>"
                   rel="home"><?php print $site_title; ?></a>
            </h1>

            <ul id="menu-header-nav" class="cms2-g main eason">
				<?php if(!$offline) { ?>
                <li class="cms2-u menu-item"><a href="<?php print $site_url; ?>news"><?php print $lang['news']; ?></a></li>
				<?php if(!$database->is_loggedin()) { ?>
                <li class="cms2-u menu-item"><a href="<?php print $site_url; ?>users/register"><?php print $lang['register']; ?></a></li>
				<?php } ?>
                <li class="cms2-u menu-item"><a href="<?php print $site_url; ?>download"><?php print $lang['download']; ?></a></li>
                <li class="cms2-u menu-item"><a href="<?php print $site_url; ?>ranking/players"><?php print $lang['ranking']; ?></a>
                    <ul class="sub-menu">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php print $site_url; ?>ranking/players"><?php print $lang['players']; ?></a>
                        </li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php print $site_url; ?>ranking/guilds"><?php print $lang['guilds']; ?></a>
                        </li>
                    </ul>
                </li>
				<?php } else { ?>
                <li class="cms2-u menu-item"><a href="<?php print $site_url; ?>"><?php print $lang['server-offline']; ?></a></li>
				<?php } if(count($json_languages['languages'])>1) { ?>
                <li class="cms2-u menu-item"><a href="#"><?php print $json_languages['languages'][$language_code]; ?></a>
					<ul class="sub-menu">
						<?php
							foreach($json_languages['languages'] as $key => $value)
								print '<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="'.$site_url.'?lang='.$key.'">'.$value.'</a></li>';
						?>
					</ul>
                </li>
				<?php } ?>
			</ul>
			
            <ul id='menu-external-nav' class='cms2-g external eason'>
                <li class='cms2-u menu-item menu-item-type-post_type'><a target='' class='relatedlink' href=''><?php print strtoupper($site_domain);?></a>
                </li>
				<?php
					if($forum!="") {
				?>
                <li class='cms2-u menu-item menu-item-type-post_type'><a target='_blank' class='relatedlink' href='<?php print $forum; ?>'>Forum</a>
                </li>
				<?php } if($support!="") { ?>
                <li class='cms2-u menu-item menu-item-type-post_type'><a target='_blank' class='relatedlink' href='<?php print $support; ?>'><?php print $lang['support']; ?></a>
                </li>
				<?php }  if($item_shop!="") { ?>
                <li class='cms2-u menu-item menu-item-type-post_type'><a target='_blank' class='relatedlink' href='<?php print $item_shop; ?>'><?php print $lang['item-shop']; ?></a>
                </li>
				<?php } ?>
            </ul>

        </div>
    </div>


    <div id="content">

        <div class="article">
            <div class="page-width">
                <div class="page-padding mt2cms2-c page-bd">
                    <div class="mt2cms2-c-l">
						<?php
							include 'pages/'.$page.'.php';
						?>
                    </div>
                    <div class="mt2cms2-c-s">
                        <div class="bd-c">
                            <ul>
								<?php include 'include/sidebar/user.php'; ?>
								<?php if(!$offline && $statistics) include 'include/sidebar/statistics.php'; ?>
								<?php include 'include/sidebar/ranking.php'; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="mt2cms2-footer esrb">
        <div class="footer-nav">
            <div class="page-width">
                <div class="page-padding">
					<?php if($social_links) { ?>
						<div class="social cms2-g">
							<div class="cms2-u">
								<ul class="cms2-g">
									<?php print $social_links; ?>
								</ul>
							</div>
						</div>
					<?php } ?>
					
					<p class="cms2-u copyright">
						<div class="row">
							<div class="col-md-8">
								&copy; Copyright <?php 
														$copyright_year = date('Y');
														if($copyright_year > 2017)
															print '2017 - '.$copyright_year;
														else print $copyright_year;
														print ' '.$site_title;
													?>
							</div>
							<div class="col-md-4">
								<p style="text-align: right">Powered by <a href="https://metin2cms.cf/" target="_blank">Metin2CMS <?php print $mt2cms; ?></a></p>
							</div>
						</div>
					</p>
                </div>
            </div>
        </div>
    </div>

	<script type="text/javascript" src="<?php print $site_url; ?>js/jquery-2.2.4.min.js"></script>
	<?php include 'include/functions/footer.php'; ?>
	<script src="<?php print $site_url; ?>js/tether.min.js"></script>
    <script src="<?php print $site_url; ?>js/bootstrap.min.js"></script>
</body>

</html>