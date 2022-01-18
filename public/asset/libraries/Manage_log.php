<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_log {
	public function write($query) {
		$now = date('Y-m-d H:i:s');
		
		$this->index = $query['index'];
		$this->query = $query['query'];
		
		$dateYmd = substr($now, 0, 10);
		$string = read_file('application/logs/Query-log-' . $dateYmd . '.php');
		
		if ($this->index == 'first') {
			if (!file_exists('application/logs/Query-log-' . $dateYmd . '.php')) {
				$data = $string . $now . "\n" . $this->query . "\n";
				
			} else {
				$data = $string . "\n" . $now . "\n" . $this->query . "\n";
			}
			
		} else {
			$data = $string . $this->query . "\n";
		}
		
		//$data = $string . $now . "\n" . $query . "\n\n";
		
		if (!write_file('application/logs/Query-log-' . $dateYmd . '.php', $data)) {
		} else {}
	}
}