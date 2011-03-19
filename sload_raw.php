<?php
	    if(PHP_OS != 'WINNT' && PHP_OS != 'WIN32') {
	        if(file_exists('/proc/loadavg') ) {
	            if ($fh = @fopen( '/proc/loadavg', 'r' )) {
	                $data = @fread( $fh, 6 );
	                @fclose( $fh );
	                $load_avg = explode( " ", $data );
	                $server_load = trim($load_avg[0]);
	            }
	        } else {
	            $data = @system('uptime');
	            preg_match('/(.*):{1}(.*)/', $data, $matches);
	            $load_arr = explode(',', $matches[2]);
	            $server_load = trim($load_arr[0]);
	        }
	    }
	    if(!$server_load) {
	        $server_load = 'N/A';
	    }
?>