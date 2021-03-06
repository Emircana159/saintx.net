<?php
	
	/* 
	 * SAINTX > SAINTX Kişisel Web Sitesi
	 * 
	 * @author: SAINTX
	 * @web: http://saintx.net
	 * @mail: im@saintx.net
	 * @date: 28.06.2013
	 * @update: 25.08.2013
	 */
	
	set_include_path(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR);
	
	error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
	
	define('SAINTX', true);
	
	define('GRAVATAR_RES', '230');
	
	define('YOUTUBE_VIDEO_ID', '359na4NeaVA');
	
	define('YOUTUBE_VIDEO_TITLE', 'eminem - berzerk');
	
	define('SKYPE_USERNAME', 'ognkrks.tr');
	
	prepare_http_get_query();
	
	if($_GET['route_pagename'] == 'humans.txt') {
		header('Content-Type: text/plain; charset=utf-8');
		
		echo '/* TEAM */'."\n\n\t";
		echo 'Developed by: Ogün Karakuş'."\n\t";
		echo 'Contact: im@saintx.net'."\n\t";
		echo 'Twitter: @jrsaintx'."\n\t";
		echo 'From: Manisa, Türkiye'."\n\n";
		echo '/* SITE */'."\n\n\t";
		echo 'Last update: '.date('Y/m/d')."\n\t";
		echo 'Standarts: HTML5, CSS3, PHP5'."\n\t";
		echo 'Components: Modernizr, jQuery'."\n\t";
		echo 'Software: Notepad++ v6.3.3';
		
		exit;
	}
	
	if($_GET['route_pagename'] == 'skype.status.png') {
		$get = @file_get_contents(sprintf('http://mystatus.skype.com/%s.txt', SKYPE_USERNAME));
		
		switch($get) {
			case 'Online': {
				header(sprintf('Location: %s', base('assets/img/skype.online.png')));
			} break;
			case 'Away': {
				header(sprintf('Location: %s', base('assets/img/skype.away.png')));
			} break;
			case 'Do Not Disturb': {
				header(sprintf('Location: %s', base('assets/img/skype.do.not.disturb.png')));
			} break;
			default: {
				header(sprintf('Location: %s', base('assets/img/skype.offline.png')));
			}
		}
	}
	
	if($_GET['route_pagename'] == 'skype.status') {
		if(is_array($_GET['route_queries'][1]) || empty($_GET['route_queries'][1]))
			header('Location: %s', base());
		
		if(!is_array($_GET['route_queries'][1])) {
			if(substr($_GET['route_queries'][1], 0, -4) != '.png')
				$_GET['route_queries'][1] .= '.png';
			
			$skype_username = @rtrim($_GET['route_queries'][1], '.png');
		} else
			$skype_username = 'ognkrks.tr';
		
		$get = @file_get_contents(sprintf('http://mystatus.skype.com/%s.txt', $skype_username));
		
		switch($get) {
			case 'Online': {
				header(sprintf('Location: %s', base('assets/img/skype.online.png')));
			} break;
			case 'Away': {
				header(sprintf('Location: %s', base('assets/img/skype.away.png')));
			} break;
			case 'Do Not Disturb': {
				header(sprintf('Location: %s', base('assets/img/skype.do.not.disturb.png')));
			} break;
			default: {
				header(sprintf('Location: %s', base('assets/img/skype.offline.png')));
			}
		}
	}
	
	if($_GET['route_pagename'] == 'imzam') {
		header(sprintf('Location: %s', base('assets/img/saintx-imza.png')));
	}
	
	if($_GET['route_pagename'] == 'spyerror') {
		header(sprintf('Location: %s', base('assets/img/spyerror-imza.png')));
	}
	
	if($_GET['route_pagename'] == 'redirect') {
		$url = urldecode($_GET['request_queries']['url']);
		
		if(!$url)
			header('Location: '.base());
		
		if($_GET['request_queries']['no_wait'] == 'true')
			header('Location: '.$url);
			
		
		header('Content-Type: text/html; charset=utf-8');
		$html = '<!doctype html>'
				.'<html><head><meta charset="utf-8" /><title>.redirecting!.. .please wait!..</title>'
				.'<meta http-equiv="refresh" content="0;url='.$url.'" />'
				.'<link rel="stylesheet" type="text/css" href="'.base('assets/css/normalize.min.css').'" />'
				.'<link rel="stylesheet" type="text/css" href="'.base('assets/css/saintx.style.css').'" />'
				.'<style type="text/css">html,body{text-align:center;margin:0.25em 0}span{font-size:200%}</style>'
				.'</head><body><span class="saintx">.redirecting!.. .please wait!..</span></body></html>';
		exit($html);
	}
	
	function prepare_http_get_query() {
		$route = (empty($_GET['route'])) ? 'index.php' : $_GET['route'];
		unset($_GET['route']);
		
		$http_get_array_keys = array_keys($_GET);
		$http_get_array_values = array_values($_GET);
		
		foreach($http_get_array_keys as $key)
			unset($_GET[$key]);
		
		$route_array = explode('/', $route);
		$route_pagename = $route_array[0];
		$route_queries = array_values($route_array);
		
		$_GET['route_pagename'] = $route_pagename;
		$_GET['route_queries'] = $route_queries;
		
		$last_route_queries = end($route_queries);
		if(count($route_queries) > 0)
			array_pop($route_queries);
		
		$last_route_queries_array = explode('.', $last_route_queries);
		$last_route_query_extension = end($last_route_queries_array);
		if(count($last_route_queries_array) > 1)
			array_pop($last_route_queries_array);
		
		$last_route_queries = array('filename' => end($last_route_queries_array), 'extension' => $last_route_query_extension);
		$_GET['route_queries'][] = $last_route_queries;
		
		foreach($http_get_array_keys as $key => $value)
			$_GET['request_queries'][$value] = $http_get_array_values[$key];
	}
	
	function base($path='') {
		$run_script = dirname($_SERVER['SCRIPT_NAME']);
		$http_url = rtrim('http'.':'.'//'.$_SERVER['HTTP_HOST'].str_replace('\\', '/', $run_script), '/').'/';
		if(!empty($path))
			$http_url .= $path;
		return $http_url;
	}
	
	function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array()) {
		$url = 'http://www.gravatar.com/avatar/';
		$url .= md5(strtolower(trim($email)));
		$url .= "?s={$s}&amp;d={$d}&amp;r={$r}";
		
		if($img) {
			$url = '<img src="'.$url.'"';
			foreach($atts as $key => $val)
				$url .= ' '.$key.'="'.$val.'"';
			$url .= ' />';
		}
		
		return $url;
	}
	
	function show_gravatar() {
		return base('redirect?url='.urlencode(get_gravatar('im@saintx.net', 400)).'&amp;no_wait=true');
	}
	
	function yas() {
		$yil = (int) date('Y');
		$dogum_yili = 1996;
		
		return ($yil - $dogum_yili);
	}
	
	function now_playing_song() {
		return '<a href="'.base('redirect?url='.urlencode('http://youtu.be/'.YOUTUBE_VIDEO_ID)).'" class="white" target="_blank">'
			  .YOUTUBE_VIDEO_TITLE.'</a>';
	}
	
	$social = (object) array(
		'facebook' => 'https://www.facebook.com/im.saintx',
		'twitter' => 'https://twitter.com/jrsaintx',
		'gplus' => 'http://gplus.to/imsaintx',
		'github' => 'https://github.com/ogunkarakus',
		'linkedin' => 'http://tr.linkedin.com/in/ogunkarakus/'
	);
	
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
	header('Cache-Control: max-age=300');
	
?><!DOCTYPE html>
<!--[if lt IE 7]>
	<html class="no-js lt-ie9 lt-ie8 lt-ie7" xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="tr">
<![endif]-->
<!--[if IE 7]>
	<html class="no-js lt-ie9 lt-ie8" xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="tr">
<![endif]-->
<!--[if IE 8]>
	<html class="no-js lt-ie9" xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="tr">
<![endif]-->
<!--[if gt IE 8]><!-->
	<html class="no-js" xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="tr">
<!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<!--[if lt IE 9]>
			<meta http-equiv="X-UA-Compatible" content="IE=9,chrome=1" />
		<![endif]-->
		<title>.merhaba! .ben .ogün!</title>
		<meta name="author" content="SAINTX" />
		<meta name="description" content="merhaba dünya! ben .ogün!" />
		<meta name="keywords" content="ogün, ogün karakuş, saintx, php, php geliştirici" />
		<meta name="google-site-verification" content="YIRR4qg71qMeyJY9f6HNz3xEKR8867miBKKr2lYp6w8" />
		<meta name="msvalidate.01" content="300383D07ACE7E1E1DB03BF3D6F90FEC" />
		<meta name="robots" content="noindex,nofollow,noarchive" />
		<meta name="googlebot" content="noindex,nofollow,noarchive" />
		<meta property="og:image" content="<?=base('redirect?url='.urlencode(get_gravatar('im@saintx.net', 400)).'&amp;no_wait=true');?>" />
		<script type="text/javascript" src="<?=base('assets/js/modernizr.min.js');?>"></script>
		<script type="text/javascript" src="<?=base('assets/js/jquery.min.js');?>"></script>
		<script type="text/javascript" src="<?=base('assets/js/jquery.yt.player.js');?>"></script>
		<script type="text/javascript" src="<?=base('assets/js/jquery.reveal.js');?>"></script>
		<link rel="stylesheet" type="text/css" href="<?=base('assets/css/normalize.min.css');?>" />
		<link rel="stylesheet" type="text/css" href="<?=base('assets/css/saintx.style.min.css');?>" />
		<link rel="stylesheet" type="text/css" href="<?=base('assets/css/reveal.min.css');?>" />
		<link rel="shortcut icon" type="image/png" href="<?=base('assets/img/favicon.png');?>" />
		<link rel="author" type="text/plain" href="<?=base('humans.txt');?>" />
		<script type="text/javascript">$("document").ready(function(){$('span[action-id="hide"]').live("click",function(){$("#wrapper .left").stop().fadeOut(250);$('#wrapper .right div[data-id="about"]').stop().fadeOut(250);$("#wrapper .right h1").stop().fadeOut(250).next().stop().fadeOut(250);$('span[action-text="hide"]').html("göster").removeAttr("action-text").attr("action-text","show");$('span[action-id="hide"]').removeAttr("action-id").attr("action-id","show");return false});$('span[action-id="show"]').live("click",function(){$("#wrapper .left").stop().fadeIn(250);$('#wrapper .right div[data-id="about"]').stop().fadeIn(250);$("#wrapper .right h1").stop().fadeIn(250).next().stop().fadeIn(250);$('span[action-text="show"]').html("gizle").removeAttr("action-text").attr("action-text","hide");$('span[action-id="show"]').removeAttr("action-id").attr("action-id","hide");return false});var a={videoId:"<?=YOUTUBE_VIDEO_ID;?>",start:0,increaseVolumeBy:100,ratio:4/3,mute:false};$("#wrapper-video").tubular(a)});</script>
	</head>
	<body>
		<div id="wrapper-video">
			<div id="wrapper">
				<div class="left">
					<h1>
						<span class="saintx">.merhaba!</span>
						<br /><span class="saintx">.ben .</span><span class="red saintx">o</span><span class="saintx">gün!</span>
					</h1>
					<div class="clearfix empty-10"></div>
					<div class="gravatar">
						<img src="<?=show_gravatar();?>" width="<?=GRAVATAR_RES;?>" height="<?=GRAVATAR_RES;?>" alt="gravatar" />
					</div>
					<div class="clearfix empty-10"></div>
					<h2>
						<span class="saintx"><i>.sosyal medyada .<span class="red">ben</span>!</i></span>
					</h2>
					<div class="clearfix empty-10"></div>
					<div class="socialmedia mr" id="socialmedia">
						<a href="<?=base();?>" rel="home"><i class="web-icon"></i></a>
						<a href="<?=base('redirect?url='.urlencode($social->facebook));?>" target="_blank"><i class="facebook-icon"></i></a>
						<a href="<?=base('redirect?url='.urlencode($social->twitter));?>" target="_blank"><i class="twitter-icon"></i></a>
						<a href="<?=base('redirect?url='.urlencode($social->gplus));?>" target="_blank"><i class="gplus-icon"></i></a>
						<a href="<?=base('redirect?url='.urlencode($social->github));?>" target="_blank"><i class="github-icon"></i></a>
						<a href="<?=base('redirect?url='.urlencode($social->linkedin));?>" target="_blank"><i class="linkedin-icon"></i></a>
					</div>
				</div>
				<div class="right">
					<h1>
						<span class="saintx">.<span class="red">h</span>akkımda!</span>
					</h1>
					<div class="clearfix empty-10"></div>
					<div data-id="about">
						<div class="about-me">
							<span class="saintx i h">.1996 yılında akhisar'da doğdum.</span><br />
							<span class="saintx i h">.<?=yas()?> yaşındayım. (<?=date('Y')?> yılına göre)</span><br />
							<span class="saintx i h">.yeni şeyler öğrenmeyi severim.</span><br />
							<span class="saintx i h">.ayrıca php, mysql, html5, css3 &amp; javascript'e</span><br />
							<span class="saintx i h">karşı büyük ilgim var.</span><br />
							<span class="saintx i h">.gezmeye, sohbet etmeye &amp; kahve içmeye bayılırım.</span><br />
							<span class="saintx i h">.halen lisede öğrenim görmekteyim.</span><br />
							<span class="saintx i h">.gelecekteki hedefim ise</span><br />
							<span class="saintx i h">profesyonel bi' yazılımcı olmak.</span><br />
							<span class="saintx i h">.sanırım bu kadar yeter :).</span><br />
							<div class="clearfix empty-10"></div>
							<span class="saintx i">.çalan şarkı -> <?=now_playing_song();?>.</span>
						</div>
						<div class="clearfix empty-10"></div>
					</div>
				</div>
			</div>
			<div class="sticky">
				<span class="saintx link" action-id="hide">.<span class="red link">y</span>azıları <span action-text="hide">gizle</span>!</span>
			</div>
		</div>
	</body>
</html>