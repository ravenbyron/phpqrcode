<?php
namespace phpQRCode;
class QRencode
    {
        public $casesensitive = true;
        public $eightbit = false;

        public $version = 0;
        public $size = 3;
        public $margin = 4;
        public $back_color = 0xFFFFFF;
        public $fore_color = 0x000000;

        public $structured = 0; // not supported yet

        public $level = QR_ECLEVEL_L;
        public $hint = QR_MODE_8;

        //----------------------------------------------------------------------
        public static function factory($level = QR_ECLEVEL_L, $size = 3, $margin = 4, $back_color = 0xFFFFFF, $fore_color = 0x000000, $cmyk = false)
        {
            $enc = new QRencode();
            $enc->size = $size;
            $enc->margin = $margin;
            $enc->fore_color = $fore_color;
            $enc->back_color = $back_color;
            $enc->cmyk = $cmyk;

            switch ($level.'') {
                case '0':
                case '1':
                case '2':
                case '3':
                        $enc->level = $level;
                    break;
                case 'l':
                case 'L':
                        $enc->level = QR_ECLEVEL_L;
                    break;
                case 'm':
                case 'M':
                        $enc->level = QR_ECLEVEL_M;
                    break;
                case 'q':
                case 'Q':
                        $enc->level = QR_ECLEVEL_Q;
                    break;
                case 'h':
                case 'H':
                        $enc->level = QR_ECLEVEL_H;
                    break;
            }

            return $enc;
        }

        //----------------------------------------------------------------------
        public function encodeRAW($intext, $outfile = false)
        {
            $code = new QRcode();

            if ($this->eightbit) {
                $code->encodeString8bit($intext, $this->version, $this->level);
            } else {
                $code->encodeString($intext, $this->version, $this->level, $this->hint, $this->casesensitive);
            }

            return $code->data;
        }

        //----------------------------------------------------------------------
        public function encode($intext, $outfile = false)
        {
            $code = new QRcode();

            if ($this->eightbit) {
                $code->encodeString8bit($intext, $this->version, $this->level);
            } else {
                $code->encodeString($intext, $this->version, $this->level, $this->hint, $this->casesensitive);
            }

            QRtools::markTime('after_encode');

            if ($outfile!== false) {
                file_put_contents($outfile, join("\n", QRtools::binarize($code->data)));
            } else {
                return QRtools::binarize($code->data);
            }
        }

        //----------------------------------------------------------------------
        public function encodePNG($intext, $outfile = false,$saveandprint=false)
        {
            try {

                ob_start();
                $tab = $this->encode($intext);
                $err = ob_get_contents();
                ob_end_clean();

                $maxSize = (int) (QR_PNG_MAXIMUM_SIZE / (count($tab)+2*$this->margin));

                QRimage::png($tab, $outfile, min(max(1, $this->size), $maxSize), $this->margin,$saveandprint, $this->back_color, $this->fore_color);

            } catch (Exception $e) {
                //nothing
            }
        }

        //----------------------------------------------------------------------
        public function encodeEPS($intext, $outfile = false,$saveandprint=false)
        {
            try {

                ob_start();
                $tab = $this->encode($intext);
                $err = ob_get_contents();
                ob_end_clean();

                $maxSize = (int) (QR_PNG_MAXIMUM_SIZE / (count($tab)+2*$this->margin));

                QRvect::eps($tab, $outfile, min(max(1, $this->size), $maxSize), $this->margin,$saveandprint, $this->back_color, $this->fore_color, $this->cmyk);

            } catch (Exception $e) {
                //nothing
            }
        }

        //----------------------------------------------------------------------
        public function encodeSVG($intext, $outfile = false,$saveandprint = false, $returnandembed = false)
        {
            try {

                ob_start();
                $tab = $this->encode($intext);
                $err = ob_get_contents();
                ob_end_clean();

                $maxSize = (int) (QR_PNG_MAXIMUM_SIZE / (count($tab)+2*$this->margin));

                return QRvect::svg($tab, $outfile, min(max(1, $this->size), $maxSize), $this->margin,$saveandprint, $this->back_color, $this->fore_color, $returnandembed );

            } catch (Exception $e) {
                //nothing
            }
        }
    }
