<?php

namespace Swisskite\MeteoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Goutte\Client;

class DefaultController extends Controller {
	public function indexAction() {
		$meteoLog = $this->getMeteoLog ();
		$meteoLog = $this->log2array ( $meteoLog );
		
		return $this->render ( 'SwisskiteMeteoBundle:Default:index.html.twig', array (
				'content' =>  $meteoLog  
		) );
	}
	private function getMeteoLog() {
		$client = new Client ();
		$client->request ( 'GET', 'http://www.swisskite.ch/weatherlink/downld08.txt' );
		$response = $client->getResponse ();
		$content = $response->getContent ();
		return $content;
	}
	private function log2array($file, $delim = '   ', $encl = '') {
		$file_lines = preg_split ( '/$\R?^/m', $file );
		
		// Empty file
		if ($file_lines === array ())
			return NULL;
		
		$out = NULL;
		$line_number = 0;
		// Now line per line (strings)
		foreach ( $file_lines as $line ) {
			$line_number++;
			// Skip empty lines and 3 header lines
			if (trim ( $line ) === ''  or $line_number < 4)
				continue;
				
				// Convert line to array
			$array_fields = array_map ( 'trim', str_getcsv ( $line, $delim, $encl) );
			
			$out [] = $array_fields;
			
			if($line_number > 20)
				break;
		}
		
		return $out;
	}
}
