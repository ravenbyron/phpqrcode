<?php
namespace phpQRCode;
class QRtools
    {
        //----------------------------------------------------------------------
        public static function binarize($frame)
        {
            $len = count($frame);
            foreach ($frame as &$frameLine) {

                for ($i=0; $i<$len; $i++) {
                    $frameLine[$i] = (ord($frameLine[$i])&1)?'1':'0';
                }
            }

            return $frame;
        }

        //----------------------------------------------------------------------
        public static function tcpdfBarcodeArray($code, $mode = 'QR,L', $tcPdfVersion = '4.5.037')
        {
            $barcode_array = array();

            if (!is_array($mode))
                $mode = explode(',', $mode);

            $eccLevel = 'L';

            if (count($mode) > 1) {
                $eccLevel = $mode[1];
            }

            $qrTab = QRcode::text($code, false, $eccLevel);
            $size = count($qrTab);

            $barcode_array['num_rows'] = $size;
            $barcode_array['num_cols'] = $size;
            $barcode_array['bcode'] = array();

            foreach ($qrTab as $line) {
                $arrAdd = array();
                foreach(str_split($line) as $char)
                    $arrAdd[] = ($char=='1')?1:0;
                $barcode_array['bcode'][] = $arrAdd;
            }

            return $barcode_array;
        }

        //----------------------------------------------------------------------
        public static function clearCache()
        {
            self::$frames = array();
        }

        //----------------------------------------------------------------------
        public static function dumpMask($frame)
        {
            $width = count($frame);
            for ($y=0;$y<$width;$y++) {
                for ($x=0;$x<$width;$x++) {
                    echo ord($frame[$y][$x]).',';
                }
            }
        }

        //----------------------------------------------------------------------
        public static function markTime($markerId)
        {
            list($usec, $sec) = explode(" ", microtime());
            $time = ((float) $usec + (float) $sec);

            if (!isset($GLOBALS['qr_time_bench']))
                $GLOBALS['qr_time_bench'] = array();

            $GLOBALS['qr_time_bench'][$markerId] = $time;
        }

        //----------------------------------------------------------------------
        public static function timeBenchmark()
        {
            self::markTime('finish');

            $lastTime = 0;
            $startTime = 0;
            $p = 0;

            echo '<table cellpadding="3" cellspacing="1">
                    <thead><tr style="border-bottom:1px solid silver"><td colspan="2" style="text-align:center">BENCHMARK</td></tr></thead>
                    <tbody>';

            foreach ($GLOBALS['qr_time_bench'] as $markerId=>$thisTime) {
                if ($p > 0) {
                    echo '<tr><th style="text-align:right">till '.$markerId.': </th><td>'.number_format($thisTime-$lastTime, 6).'s</td></tr>';
                } else {
                    $startTime = $thisTime;
                }

                $p++;
                $lastTime = $thisTime;
            }

            echo '</tbody><tfoot>
                <tr style="border-top:2px solid black"><th style="text-align:right">TOTAL: </th><td>'.number_format($lastTime-$startTime, 6).'s</td></tr>
            </tfoot>
            </table>';
        }

        public static function save($content, $filename_path)
        {
            try {
                $handle = fopen($filename_path, "w");
                fwrite($handle, $content);
                fclose($handle);

                return true;
            } catch (Exception $e) {
                echo 'Exception  : ',  $e->getMessage(), "\n";
            }

        }

    }
