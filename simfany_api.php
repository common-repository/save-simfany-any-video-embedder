<?php #1

function simfany_api_input($content)
{	preg_match_all('/\[(simfany|video)\](.+?)\[\/(?:simfany|video)\]/si', $content, $matches);

	if (!$matches[0]) return $content;

	$url = 'http://simfany.com/api/';
	$timeout = 5;

	$pairs = array();

	for ($i=0, $c=count($matches[0]); $i<$c; $i++)
	{		if (!preg_match('/http:\/\/([a-z0-9-]+\.)+[a-z]+\//si', $matches[2][$i])) continue;

		$xml = '';
		$post = 'code='.rawurlencode($matches[2][$i]);

		if (function_exists('curl_init'))
		{			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$xml = @curl_exec($ch);
		}

		if (!$xml)
		{			$url_parts = parse_url($url);
			$host = $url_parts['host'];
			$path = (isset($url_parts['path']) ? $url_parts['path'] : '/');
			$errno = $errstr = '';

			if ($ch = fsockopen($host, 80, $errno, $errstr, $timeout))
			{
				fwrite($ch, implode("\r\n", array
					(
						'POST '.$path.' HTTP/1.1',
						'Host: '.$host,
						'Content-Type: application/x-www-form-urlencoded',
						'Content-Length: '.strlen($post),
						'Connection: close',
					)
				)."\r\n\r\n".$post);

				while (!feof($ch)) $xml.= fgets($ch);
			}
		}

		if (!$xml) continue;

		if (!preg_match('/<id>(.+?)<\/id>/si', $xml, $matches1)) continue;

		$pairs[$matches[0][$i]] = ('['.$matches[1][$i].']'.$matches1[1].'[/'.$matches[1][$i].']');
	}

	return strtr($content, $pairs);
}

function simfany_api_output($content, $options='')
{	return preg_replace('/\[(?:simfany|video)\]([a-z]?[0-9]+)\[\/(?:simfany|video)\]/si', ('<script type="text/javascript" src="http://simfany.com/$1.js'.($options ? ('?'.$options) : '').'"></script>'), $content);
}

?>