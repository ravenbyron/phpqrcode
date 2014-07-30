<?php
namespace phpQRCode;

define('QR_FIND_BEST_MASK', true);    // if true, estimates best mask (spec. default, but extremally slow; set to false to significant performance boost but (propably) worst quality code
define('QR_FIND_FROM_RANDOM', false);    // if false, checks all masks available, otherwise value tells count of masks need to be checked, mask id are got randomly
define('QR_DEFAULT_MASK', 2);        // when QR_FIND_BEST_MASK === false
define('QR_PNG_MAXIMUM_SIZE',  1024);    // maximum allowed png image width (in pixels), tune to make sure GD and PHP can handle such big images
define('QR_MODE_NUL', -1);
define('QR_MODE_NUM', 0);
define('QR_MODE_AN', 1);
define('QR_MODE_8', 2);
define('QR_MODE_KANJI', 3);
define('QR_MODE_STRUCTURE', 4);
define('QR_ECLEVEL_L', 0);
define('QR_ECLEVEL_M', 1);
define('QR_ECLEVEL_Q', 2);
define('QR_ECLEVEL_H', 3);
define('QR_FORMAT_TEXT', 0);
define('QR_FORMAT_PNG',  1);
define('QR_IMAGE', true);
define('STRUCTURE_HEADER_BITS',  20);
define('MAX_STRUCTURED_SYMBOLS', 16);
define('N1', 3);
define('N2', 3);
define('N3', 40);
define('N4', 10);
define('QRSPEC_VERSION_MAX', 40);
define('QRSPEC_WIDTH_MAX',   177);
define('QRCAP_WIDTH',        0);
define('QRCAP_WORDS',        1);
define('QRCAP_REMINDER',     2);
define('QRCAP_EC',           3);
define('QR_VECT', true);
require_once 'classes/FrameFiller.php';
require_once 'classes/QRbitstream.php';
require_once 'classes/QRcode.php';
require_once 'classes/QRencode.php';
require_once 'classes/QRimage.php';
require_once 'classes/QRinput.php';
require_once 'classes/QRinputItem.php';
require_once 'classes/QRmask.php';
require_once 'classes/QRrawcode.php';
require_once 'classes/QRrs.php';
require_once 'classes/QRrsItem.php';
require_once 'classes/QRrsblock.php';
require_once 'classes/QRspec.php';
require_once 'classes/QRsplit.php';
require_once 'classes/QRtools.php';
require_once 'classes/QRvect.php';
require_once 'classes/qrstr.php';

