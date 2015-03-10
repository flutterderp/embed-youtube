<!DOCTYPE html>
<html lang="en-GB">
	<head>
		<meta charset="utf-8">
		<title>Video Stuffs</title>
		
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,700' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Droid+Sans+Mono|Roboto:400,400italic,700|Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
		<style type="text/css">
			body { background-color: #fff; color: #222; font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 16px; }
			pre { font-family: 'Droid Sans Mono', monospace; }
			div.wrapper { font-size: 0.8rem; }
		</style>
	</head>
	<body>
		<div class="wrapper" id="wrapper">
		
			<?php
			//https://www.youtube.com/watch?v=fXH8wlK3aOc
			$video_uri	= 'https://vimeo.com/116090051';
			$video			= embedUrl($video_uri);
			?>
			<pre><?php print_r($video); ?></pre>
			<p><img src="<?php echo $video->image; ?>" alt="" width="380"></p>
			
		</div>
	</body>
</html>

<?php
function embedUrl($uri)
{
	if(stripos($uri, 'youtube.com'))
	{
		$type					= 'youtube';
		$video_arr		= parse_url($uri);
		parse_str($video_arr['query'], $query_str);
		$video_id			= $query_str['v'];
		$video_image	= 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
		$video_uri		= 'https://www.youtube.com/embed/' . $video_id . '?controls=0&amp;rel=0';
	}
	elseif(stripos($uri, 'youtu.be'))
	{
		$type					= 'youtube';
		$video_id			= str_ireplace('http://youtu.be/', '', $uri);
		$video_image	= 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
		$video_uri		= 'https://www.youtube.com/embed/' . $video_id . '?controls=0&amp;rel=0';
	}
	elseif(stripos($uri, '//vimeo.com'))
	{
		$type					= 'vimeo';
		$video_id			= preg_replace( '(https?://vimeo.com/)', '', $uri );
		$vimeo				= unserialize(@file_get_contents('https://vimeo.com/api/v2/video/' . $video_id . '.php'));
		$video_image	= $vimeo[0]['thumbnail_large'];
		$video_uri		= 'https://player.vimeo.com/video/' . $video_id;
	}
	else
	{
		$type					= '';
		$video_id			= '';
		$video_image	= '';
		$video_uri		= $uri;
	}
	
	$placeholder		= 'http://placehold.it/1200x680/ccc/333/&text=Thumbnail%20not%20available';
	$result					= new stdClass();
	$result->type		= $type;
	$result->id			= $video_id;
	$result->image	= !empty($video_image) ? $video_image : $placeholder;
	$result->uri		= $video_uri;
	
	return $result;
}
