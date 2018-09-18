<?php

define('__PORT', "6868");
define('__TIMEOUT', "15");
define('__HOST', "125.212.193.77");

#define('__PORT', "6889");
#define('__TIMEOUT', "30");
#define('__HOST', "localhost");

function sendMessage($service, $body) {
    $receiveBufferSize = 2048;
	
    $sHandle = fsockopen(__HOST, __PORT, $errno, $errstr, __TIMEOUT);
    if (!$sHandle) {
        return "DEAD";//$errstr;
    } else {
        /** Write to socket * */
        fwrite($sHandle, "K2"); // Header name "K2TP"
        //fwrite($sHandle, "" . chr(0) . chr(0)); // Header version
        $len = strlen($body);
		//fwrite($sHandle, "" . chr(($service >> 8) & 0xFF) . chr($service & 0xFF)); // Header service
		fwrite($sHandle, "" . chr(($service >> 24) & 0xFF) . chr(($service >> 16) & 0xFF) . chr(($service >> 8) & 0xFF) . chr(($service) & 0xFF)); // Header service
        fwrite($sHandle, "" . chr(($len >> 24) & 0xFF) . chr(($len >> 16) & 0xFF) . chr(($len >> 8) & 0xFF) . chr(($len) & 0xFF)); // Header length
        
        //fwrite($sHandle, "0000"); // Header reverse
		//fwrite($sHandle, $service);
		//fwrite($sHandle, $len);
        fwrite($sHandle, $body); // Header body

        /** Read from socket * */
        $buf = fread($sHandle, 2); // Header name "K2"
		$buf = fread($sHandle, 4); // Header version
		$service = (ord($buf{0}) << 24) | (ord($buf{1}) << 16) | (ord($buf{2}) << 8) | (ord($buf{3}));
		//$buf = fread($sHandle, 2); // Header service
		$buf = fread($sHandle, 4); // Header length
		$length = (ord($buf{0}) << 24) | (ord($buf{1}) << 16) | (ord($buf{2}) << 8) | (ord($buf{3}));
        //$buf = fread($sHandle, 4); // Header reverse
        $buf = "";
        $count = 0;
        while ($count < $length) {
            $data = fread($sHandle, $length);
            if ($data == null) {
                break;
            }
            $count += strlen($data);
            $buf = $buf.$data;
        }
        fclose($sHandle);
        return $buf;
    }
}

function sendMessage1($service, $body) {
    $receiveBufferSize = 2048;
	
    $sHandle = fsockopen("125.212.225.129", "9455", $errno, $errstr, 15);
    if (!$sHandle) {
        return "DEAD";//$errstr;
    } else {
        /** Write to socket * */
        fwrite($sHandle, "CS"); // Header name "K2TP"
        //fwrite($sHandle, "" . chr(0) . chr(0)); // Header version
        $len = strlen($body);
        //fwrite($sHandle, "" . chr(($service >> 8) & 0xFF) . chr($service & 0xFF)); // Header service
        fwrite($sHandle, "" . chr(($service >> 24) & 0xFF) . chr(($service >> 16) & 0xFF) . chr(($service >> 8) & 0xFF) . chr(($service) & 0xFF)); // Header service
        fwrite($sHandle, "" . chr(($len >> 24) & 0xFF) . chr(($len >> 16) & 0xFF) . chr(($len >> 8) & 0xFF) . chr(($len) & 0xFF)); // Header length
        
        //fwrite($sHandle, "0000"); // Header reverse
        //fwrite($sHandle, $service);
        //fwrite($sHandle, $len);
        fwrite($sHandle, $body); // Header body

        /** Read from socket * */
        $buf = fread($sHandle, 2); // Header name "K2"
        $buf = fread($sHandle, 4); // Header version
        $service = (ord($buf{0}) << 24) | (ord($buf{1}) << 16) | (ord($buf{2}) << 8) | (ord($buf{3}));
        //$buf = fread($sHandle, 2); // Header service
        $buf = fread($sHandle, 4); // Header length
        $length = (ord($buf{0}) << 24) | (ord($buf{1}) << 16) | (ord($buf{2}) << 8) | (ord($buf{3}));
        //$buf = fread($sHandle, 4); // Header reverse
        $buf = "";
        $count = 0;
        while ($count < $length) {
            $data = fread($sHandle, $length);
            if ($data == null) {
                break;
            }
            $count += strlen($data);
            $buf = $buf.$data;
        }
        fclose($sHandle);
        return $buf;
    }
}

function sendMessage3($service, $body) {
    $receiveBufferSize = 2048;
	
    $sHandle = fsockopen("125.212.193.77", "6868", $errno, $errstr, 15);
    if (!$sHandle) {
        return "DEAD";//$errstr;
    } else {
       /** Write to socket * */
        fwrite($sHandle, "K2"); // Header name "K2TP"
        //fwrite($sHandle, "" . chr(0) . chr(0)); // Header version
        $len = strlen($body);
        //fwrite($sHandle, "" . chr(($service >> 8) & 0xFF) . chr($service & 0xFF)); // Header service
        fwrite($sHandle, "" . chr(($service >> 24) & 0xFF) . chr(($service >> 16) & 0xFF) . chr(($service >> 8) & 0xFF) . chr(($service) & 0xFF)); // Header service
        fwrite($sHandle, "" . chr(($len >> 24) & 0xFF) . chr(($len >> 16) & 0xFF) . chr(($len >> 8) & 0xFF) . chr(($len) & 0xFF)); // Header length
        
        //fwrite($sHandle, "0000"); // Header reverse
        //fwrite($sHandle, $service);
        //fwrite($sHandle, $len);
        fwrite($sHandle, $body); // Header body

        /** Read from socket * */
        $buf = fread($sHandle, 2); // Header name "K2"
        $buf = fread($sHandle, 4); // Header version
        $service = (ord($buf{0}) << 24) | (ord($buf{1}) << 16) | (ord($buf{2}) << 8) | (ord($buf{3}));
        //$buf = fread($sHandle, 2); // Header service
        $buf = fread($sHandle, 4); // Header length
        $length = (ord($buf{0}) << 24) | (ord($buf{1}) << 16) | (ord($buf{2}) << 8) | (ord($buf{3}));
        //$buf = fread($sHandle, 4); // Header reverse
        $buf = "";
        $count = 0;
        while ($count < $length) {
            $data = fread($sHandle, $length);
            if ($data == null) {
                break;
            }
            $count += strlen($data);
            $buf = $buf.$data;
        }
        fclose($sHandle);
        return $buf;
    }
}

function sendMessage2($service, $body) {
    $receiveBufferSize = 2048;
	
    $sHandle = fsockopen("125.212.193.77", "6868", $errno, $errstr, 15);
    if (!$sHandle) {
        return "DEAD";//$errstr;
    } else {
       /** Write to socket * */
        fwrite($sHandle, "K2"); // Header name "K2TP"
        //fwrite($sHandle, "" . chr(0) . chr(0)); // Header version
        $len = strlen($body);
        //fwrite($sHandle, "" . chr(($service >> 8) & 0xFF) . chr($service & 0xFF)); // Header service
        fwrite($sHandle, "" . chr(($service >> 24) & 0xFF) . chr(($service >> 16) & 0xFF) . chr(($service >> 8) & 0xFF) . chr(($service) & 0xFF)); // Header service
        fwrite($sHandle, "" . chr(($len >> 24) & 0xFF) . chr(($len >> 16) & 0xFF) . chr(($len >> 8) & 0xFF) . chr(($len) & 0xFF)); // Header length
        
        //fwrite($sHandle, "0000"); // Header reverse
        //fwrite($sHandle, $service);
        //fwrite($sHandle, $len);
        fwrite($sHandle, $body); // Header body

        /** Read from socket * */
        $buf = fread($sHandle, 2); // Header name "K2"
        $buf = fread($sHandle, 4); // Header version
        $service = (ord($buf{0}) << 24) | (ord($buf{1}) << 16) | (ord($buf{2}) << 8) | (ord($buf{3}));
        //$buf = fread($sHandle, 2); // Header service
        $buf = fread($sHandle, 4); // Header length
        $length = (ord($buf{0}) << 24) | (ord($buf{1}) << 16) | (ord($buf{2}) << 8) | (ord($buf{3}));
        //$buf = fread($sHandle, 4); // Header reverse
        $buf = "";
        $count = 0;
        while ($count < $length) {
            $data = fread($sHandle, $length);
            if ($data == null) {
                break;
            }
            $count += strlen($data);
            $buf = $buf.$data;
        }
        fclose($sHandle);
        return $buf;
    }
}

function sendMessageBackup($service, $body) {
    $receiveBufferSize = 2048;
    $sHandle = fsockopen(__HOST, __PORT, $errno, $errstr, __TIMEOUT);
    if (!$sHandle) {
        return $errstr;
    } else {
        /** Write to socket * */
        fwrite($sHandle, "K2TP"); // Header name "K2TP"
        fwrite($sHandle, "" . chr(0) . chr(0)); // Header version
        $len = strlen($body);
        fwrite($sHandle, "" . chr(($len >> 24) & 0xFF) . chr(($len >> 16) & 0xFF) . chr(($len >> 8) & 0xFF) . chr(($len) & 0xFF)); // Header length
        fwrite($sHandle, "" . chr(($service >> 8) & 0xFF) . chr($service & 0xFF)); // Header service
        fwrite($sHandle, "0000"); // Header reverse
        fwrite($sHandle, $body); // Header body

        /** Read from socket * */
        $buf = fread($sHandle, 4); // Header name "K2TP"
        $buf = fread($sHandle, 2); // Header version
        $buf = fread($sHandle, 4); // Header length
        $length = (ord($buf{0}) << 24) | (ord($buf{1}) << 16) | (ord($buf{2}) << 8) | (ord($buf{3}));
        $buf = fread($sHandle, 2); // Header service
        $service = ord($buf{0}) << 8 | ord($buf{1});
        $buf = fread($sHandle, 4); // Header reverse
        $buf = fread($sHandle, $length);
        fclose($sHandle);
        return $buf;
    }
}

function stringToByte($str) {
    $data = "";
    for ($i = 0; $i < strlen($str); $i++) {
        $data .= " " . ord($str{$i});
    }
    return $data;
}

?>
