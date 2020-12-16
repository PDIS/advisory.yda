<?php

namespace Yda\Gpvip\Controllers;

use Backend\Classes\Controller;

class GpvipController extends Controller
{
    public static $msgError = "[ERROR]";

    public function __construct()
    {
    }

    public function index()
    {
        $now = time();
        $nowStr = gmdate('Y-m-d h:i:s a', $now);
        $filePath = storage_path() . '/app/media/gpvip.csv';
        $result = [];

        $fetchFlag = true;
        $file = '';

        if (file_exists($filePath)) {
            $fileTime = filemtime($filePath);
            $fileTimeStr = gmdate('Y-m-d h:i:s a', $fileTime);
            if (($now - $fileTime) <= 24 * 60 * 60) {
                $fetchFlag = false;
            }
        }

        if ($fetchFlag) {
            $url = 'http://ws.ndc.gov.tw/001/administrator/10/relfile/0/11145/81965c44-9fa2-48bb-bda1-925ae9ead700.csv';
            $curl = curl_init($url);

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_TIMEOUT => 3,
                CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
                CURLOPT_HEADER => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_VERBOSE => 1,
            ]);

            $response = curl_exec($curl);

            $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $header_size);
            $body = substr($response, $header_size);

            curl_close($curl);

            if ($response != false) {
                file_put_contents($filePath, $body);
            }
        }

        if (file_exists($filePath)) {

            $file = fopen($filePath, 'r');

            while (!feof($file)) {
                $tmp = $this->__fgetcsv($file);
                if (is_array($tmp)) {
                    array_pop($tmp);
                    $result[] = $tmp;
                }
            }
            fclose($file);

            if (count($result) <= 1) {
                if (count($result) == 1 && $result[0] == false) {
                    $result[0] = $this::$msgError;
                    $result[1] = 'Happend error when getting CSV content';
                    return $result;
                } else {
                    $result[0] = $this::$msgError;
                    $result[1] = 'Something error. Empty result.';
                    return $result;
                }
            } else {
                if ($result[count($result) - 1] == false) {
                    array_pop($result);
                }
            }
        } else {
            $result[0] = '[ERROR]';
            $result[1] = "No such file or directory. >> $filePath";
            return $result;
        }

        return $result;
    }

    private function get_headers_from_curl_response($response)
    {
        $headers = array();

        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

        foreach (explode("\r\n", $header_text) as $i => $line) {
            if ($i === 0) {
                $headers['http_code'] = $line;
            } else {
                list($key, $value) = explode(': ', $line);

                $headers[$key] = $value;
            }
        }

        return $headers;
    }

    private function __fgetcsv(&$handle, $length = null, $d = ",", $e = '"')
    {
        $d = preg_quote($d);
        $e = preg_quote($e);
        $_line = "";
        $eof = false;
        while ($eof != true) {
            $_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
            $itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
            if ($itemcnt % 2 == 0) {
                $eof = true;
            }
        }

        $_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));

        $_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
        preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
        $_csv_data = $_csv_matches[1];

        for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
            $_csv_data[$_csv_i] = preg_replace("/^" . $e . "(.*)" . $e . "$/s", "$1", $_csv_data[$_csv_i]);
            $_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
        }

        return empty($_line) ? false : $_csv_data;
    }

    private function parseHeaders($headers)
    {
        $head = array();
        foreach ($headers as $k => $v) {
            $t = explode(':', $v, 2);
            if (isset($t[1])) {
                $head[trim($t[0])] = trim($t[1]);
            } else {
                $head[] = $v;
                if (preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $v, $out)) {
                    $head['reponse_code'] = intval($out[1]);
                }

            }
        }
        return $head;
    }
}
