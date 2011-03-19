
<?php
// Get The Server Load
function get_ServerLoad()
    {
        IF (PHP_OS != 'WINNT' && PHP_OS != 'WIN32')
            {
                IF (file_exists('/proc/loadavg') )
                    {
                        IF ($fh = @fopen( '/proc/loadavg', 'r' ))
                            {
                                $data = @fread( $fh, 6 );
                                @fclose( $fh );
                                $load_avg = explode( " ", $data );
                                $server_load = trim($load_avg[0]);
                            }
                    }
                ELSE
                    {
                        $data = @exec('uptime');
                        preg_match('/(.*):{1}(.*)/', $data, $matches);
                        $load_arr = explode(',', $matches[2]);
                        $server_load = trim($load_arr[0]);
                    }
            }
        IF (!$server_load)
            { $server_load = 'N/A'; }

        return $server_load;
    } 
	
	echo get_ServerLoad();
	?>