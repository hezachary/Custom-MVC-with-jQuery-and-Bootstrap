<?php
/**
 * ToolsExt
 * 
 * @package Extensions
 * @author Zhehai He
 * @copyright 2013
 * @version 1.0
 * @access public
 */
class ToolsExt{
    /**
     * The array has to have 'id' and 'pid' (parent id) fields.
     * 
     * $aryTest = array(
     *       array(
     *       ’id’ => 9,
     *       ’pid’=> 8,
     *       ),
     *       array(
     *       ’id’ => 1,
     *       ’pid’=> 0,
     *       ),
     *       array(
     *       ’id’ => 7,
     *       ’pid’=> 6,
     *       ),
     *       array(
     *       ’id’ => 2,
     *       ’pid’=> 0,
     *       ),
     *       array(
     *       ’id’ => 3,
     *       ’pid’=> 0,
     *       ),
     *       array(
     *       ’id’ => 4,
     *       ’pid’=> 1,
     *       ),
     *       array(
     *       ’id’ => 5,
     *       ’pid’=> 1,
     *       ),
     *       array(
     *       ’id’ => 6,
     *       ’pid’=> 4,
     *       ),
     *       array(
     *       ’id’ => 8,
     *       ’pid’=> 7,
     *       ),
     *       array(
     *       ’id’ => 11,
     *       ’pid’=> 2,
     *       ),
     *      );
     * $aryTest = ToolsExt::arySetNode($aryTest, $aryTest);
     * $aryTree = ToolsExt::arySetTree($aryTest);
     * var_dump($aryTree)
     */
    public static function arySetTree($strIdField, $strPidField, $ary, $node = 0, $aryRst = array()){
    	foreach ($ary as $key => $value){
    		if ($value['node']== $node){
    			$aryTmp[(string)$value[$strPidField]][(string)$value[$strIdField]] = array();
    			unset($ary[$key]);
    		}
    	}
    	if($node == 0){
    		$aryRst = $aryTmp;
    
    	}
    	foreach($aryRst as $key_Rst => $value_Rst){
    		foreach($aryTmp as $key_Tmp => $value_Tmp){
    			if($key_Rst==$key_Tmp){
    				$aryRst[$key_Rst]=$value_Tmp;
    			}
    		}
    	}
    
    	if(sizeof($ary) > 0){
    		foreach($aryRst as $key_Rst => $value_Rst){
    			$aryRst[$key_Rst] = self::arySetTree($strIdField, $strPidField, $ary, $node+1, $value_Rst);
    		}
    	}
    	return $aryRst;
    }
    
    public static function arySetNode($strIdField, $strPidField, $ary, $aryOrg, $node = 0){
    	$ary_1 = $ary;
    	$ary_2 = $ary;
    	$ary_3 = array();
    	foreach($ary_1 as $key_1 => $value_1){
    		foreach($ary_2 as $key_2 => $value_2){
    			if($value_1[$strPidField]==$value_2[$strIdField]){
    				$ary_3[]=$ary_1[$key_1];
    				unset($ary_1[$key_1]);
    			}
    		}
    	}
    	foreach($ary_1 as $key_1 => $value_1){
    		foreach($aryOrg as $key_Org => $value_Org){
    			if ($value_1[$strIdField]==$value_Org[$strIdField]){
    				$aryOrg[$key_Org]['node']=$node;
    			}
    		}
    	}
    	if(sizeof($ary_3) > 0){
    		$aryOrg = self::arySetNode($strIdField, $strPidField, $ary_3, $aryOrg, $node+1);
    	}
    	return $aryOrg;
    }
    
    public static function getAllArrayPermute( $set, $int_limited_size = 4 ){
        $set = array_unique( array_filter( $set ) );
        if( sizeof( $set ) < 2 )
            return array( $set );
        
        if( $int_limited_size < sizeof($set) )
            $set = array_slice( $set , 0, $int_limited_size);
        $size = sizeof($set) - 1; $perm = range(0, $size); $j = 0;
        do {
            foreach ($perm as $i) { $perms[$j][] = $set[$i]; }
        } while ($perm = self::pcNextPermutation($perm, $size) and ++$j);
        return $perms;
    }

    public static function pcNextPermutation( $p, $size ) {
        // slide down the array looking for where we're smaller than the next guy
        for ($i = $size - 1; $p[$i] >= $p[$i+1]; --$i) { }

        // if this doesn't occur, we've finished our permutations
        // the array is reversed: (1, 2, 3, 4) => (4, 3, 2, 1)
        if ($i == -1) { return false; }

        // slide down the array looking for a bigger number than what we found before
        for ($j = $size; $p[$j] <= $p[$i]; --$j) { }

        // swap them
        $tmp = $p[$i]; $p[$i] = $p[$j]; $p[$j] = $tmp;

        // now reverse the elements in between by swapping the ends
        for (++$i, $j = $size; $i < $j; ++$i, --$j) {
             $tmp = $p[$i]; $p[$i] = $p[$j]; $p[$j] = $tmp;
        }

        return $p;
    }
    
    /**
     * Retrieve user IP address
     **/
    public static function retrieveUserIp(){
    	if (empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
    		$userip = $_SERVER['REMOTE_ADDR'];
    	}else{
    		$userip = explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
    		$userip = $userip[0];
    	}
    	return $userip;
    }
    
    /**
     * Filter Html Tags for content
     **/
    public static function mb_html_filter($str, $encoding = 'utf-8') {
        return htmlentities(self::mb_filter($str, $encoding), ENT_COMPAT, 'UTF-8');
    }
    
    public static function mb_filter($str, $encoding = 'utf-8') {
        mb_regex_encoding($encoding);
        $pattern = array('<[^>]+>', '\[[^\]]+', '(\r\n)|(\n)|(\r)|\&nbsp\;', '\s+');
        $replacement = array('', '', ' ', ' ');
        for ($i=0; $i<sizeof($pattern); $i++) {
            $str = mb_ereg_replace($pattern[$i], $replacement[$i], $str);
        }
        return trim($str);
    }
    
    public static function exportFile($strFilePath, $blnAttachment = false){
        $strMime = function_exists('finfo_file') ? finfo_file(finfo_open(FILEINFO_MIME_TYPE), $strFilePath) : mime_content_type($strFilePath);
        $aryInfo = stat($strFilePath);
        header('Content-Type: '.$strMime);
        header('Content-Length: '.$aryInfo['size']);
        header('Content-Disposition: '.($blnAttachment ? 'attachment' : 'inline').'; filename="'.basename($strFilePath).'"');
        readfile($strFilePath);
        return array($strMime, $strFilePath);
    }
    
    /**
     * $aryRatio = array(width, height)
     * $strTargetPath = path/path # no "/" in the end
     **/
    public static function resize_image($aryRatio, $strSourceFilePath, $strBaseFileName, $strTargetPath = null, $inQuality = 100, $blnDisplay = true, $blnAttachment = false){
        if(!file_exists($strTargetPath)){
            mkdir($strTargetPath, 0755);
        }
        
    	$arySourceFileInfo = pathinfo($strSourceFilePath);
    	$strSourceFileDir = $arySourceFileInfo['dirname'];
    	$strSourceFileExt = $arySourceFileInfo['extension'];
        $strBaseFileRawName = wp_basename($strBaseFileName, '.'.$strSourceFileExt);
        
        $strNewFilePath = !$strTargetPath ? null : $strTargetPath.DIRECTORY_SEPARATOR.$strBaseFileRawName.'-'.implode('=', $aryRatio).'.'.$strSourceFileExt;
        
        switch(true){
            case $strNewFilePath && file_exists($strNewFilePath) && $blnDisplay:
                //read file & export screen
                return self::exportFile($strNewFilePath, $blnAttachment);
                break;
            case $strNewFilePath && file_exists($strNewFilePath) && !$blnDisplay:
            case !$strNewFilePath && !$blnDisplay:
                //do nothing
                return array();
                break;
            case $strNewFilePath && !file_exists($strNewFilePath) && $blnDisplay:
                //populate + save + export screen
                break;
            case $strNewFilePath && !file_exists($strNewFilePath) && !$blnDisplay:
                //populate + save + no export screen
                break;
            case !$strNewFilePath && $blnDisplay:
                //populate + no save + export screen
                break;
        }
        
        //A. Populate
        $aryImageInfo = getimagesize($strSourceFilePath);
        switch ($aryImageInfo['mime']) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($strSourceFilePath);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($strSourceFilePath);
                break;
            case 'image/png':
                $source = imagecreatefrompng($strSourceFilePath);
                break;
            default:
                return array($aryImageInfo['mime'], null);
                break;
        }
        
        $intWidth =  imagesx($source);
        $intHeight = imagesy($source);
        
        $intNewWidth = $intWidth;
        $intNewHeight = $intHeight;
        switch(true){
            case $intWidth/$intHeight > $aryRatio[0]/$aryRatio[1]:
                $intNewHeight = (int)round($intWidth * $aryRatio[1] / $aryRatio[0]);
                break;
            case $intWidth/$intHeight < $aryRatio[0]/$aryRatio[1]:
                $intNewWidth = (int)round($intHeight * $aryRatio[0] / $aryRatio[1]);
                break;
        }
        
        $final = imagecreatetruecolor($intNewWidth, $intNewHeight);
        $backgroundColor = imagecolorallocate($final, 255, 255, 255);
        imagefill($final, 0, 0, $backgroundColor);
        imagecopy($final, $source, (($intNewWidth - $intWidth)/ 2), (($intNewHeight - $intHeight) / 2), 0, 0, $intWidth, $intHeight);
        
        
        if(!$blnDisplay){
            ob_start();
        }
        
        if(!$strNewFilePath){
            header('Content-Type: '.$aryImageInfo['mime']);
            header('Content-Disposition: '.($blnAttachment ? 'attachment' : 'inline').'; filename="'.basename($strNewFilePath).'"');
        }
        
        switch ($aryImageInfo['mime']) {
            case 'image/jpeg':
                imagejpeg($final, $strNewFilePath, $inQuality);
                break;
            case 'image/gif':
                imagegif($final, $strNewFilePath);
                break;
            case 'image/png':
                imagepng($final, $strNewFilePath, $inQuality);
                break;
        }
        
        if(!$blnDisplay){
            ob_end_clean();
        }
        
        imagedestroy($final);
        imagedestroy($source);
        
        if($strNewFilePath){
            $stat = stat($strTargetPath);
            $perms = $stat['mode'] & 0000666; //same permissions as parent folder, strip off the executable bits
            @ chmod( $strNewFilePath, $perms );
            if($blnDisplay){
                self::exportFile($strNewFilePath, $blnAttachment);
            }
        }
        
        return array($aryImageInfo['mime'], $strNewFilePath);
    }
    
    
    /**
     * Debug
     * @param $v : the value to trace
     * @param $s : dump value for sure, by default it will not dump value for object (in case it is too big)
     * @param $d : die after debug
     * @param $backtrace : if you call directly from your code, leave it as empty
     **/
    public static function _d($v, $s = true, $d=false, $backtrace = false){
    	if(true || $_REQUEST['_d']){
    		$r = dechex(rand(200, 230));
    		$g = dechex(rand(200, 230));
    		$b = dechex(rand(200, 230));
    		echo "<pre style='background-color:#$r$g$b;text-align:left'>";
            $doc_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
            $backtrace = $backtrace ? $backtrace : debug_backtrace();
            // you may want not to htmlspecialchars here
            $line = htmlspecialchars($backtrace[0]['line']);
            $file = htmlspecialchars(str_replace(array('\\', $doc_root), array('/', ''), $backtrace[0]['file']));
            $class = !empty($backtrace[1]['class']) ? htmlspecialchars($backtrace[1]['class']) . '::' : '';
            $function = !empty($backtrace[1]['function']) ? htmlspecialchars($backtrace[1]['function']) . '() ' : '';
            echo '<b>'.$class.$function.' =&gt;'.$file.' ['.$line.']</b><br/>';
    		if(is_object($v)){
                        var_export(get_class($v));
    			var_export(get_class_methods($v));
    		}
                if($s){
                    var_export($v);
                    echo "\n";
                }
            for ($k = 1; $k < sizeof($backtrace); $k++ ){
                $r = array('#'.$k.': ',$backtrace[$k]['class'], $backtrace[$k]['type'],$backtrace[$k]['function'].'()','  '.$backtrace[$k]['file']. ' ['.$backtrace[$k]['line'].']' );
                echo implode("",$r)."\n";
            }
    		echo "</pre><hr/>";
    		if($d)die();
    	}
    }
    
    /**
     * Retrieve List from ACF settings
     * @param $post : the source
     * @param $strFieldName : the select field name
     * @param $strAcfPath : the acf slug
     **/
    public static function retrieveListFromACFSettings($post, $strFieldName, $strAcfPath){
        $aryField = get_field($strFieldName, $post->ID);
        $strFieldKey = get_post_meta($post->ID, '_'.$strFieldName, true);
        
        $objDataDefine = get_page_by_path($strAcfPath, OBJECT, 'acf');
        $aryFieldSetting = get_post_meta($objDataDefine->ID, $strFieldKey, true);
        
        $aryExport = array();
        foreach($aryField as $value){
            $aryExport[$value] = $aryFieldSetting['choices'][$value];
        }
        return $aryExport;
    }
     
    /**
     * Parse Respons Header
     * @param $header : incoming header string
     * @return array()
     **/
    public static function http_parse_headers( $header )
    {
        $retVal = array();
        $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
        foreach( $fields as $field ) {
            if( preg_match('/([^:]+): (.+)/m', $field, $match) ) {
                $match[1] = preg_replace('/(?<=^|[\x09\x20\x2D])./e', '"\0"', trim($match[1]));
                if( isset($retVal[$match[1]]) ) {
                    $retVal[$match[1]] = array($retVal[$match[1]], $match[2]);
                } else {
                    $retVal[$match[1]] = trim($match[2]);
                }
            }
        }
        return $retVal;
    }
    
    public static function log($name, $data){
        @file_put_contents(mvc::app()->getUploadPath() . mvc::DIR_SEP . 'log' . mvc::DIR_SEP .basename($name).'_'.date('YmdHis').'.txt', print_r($data, 1) );
    }
    
    
    public static function exportCsv( $strFileName, $aryDataList, $strDelimiter ) {
        $strFileName = basename( $strFileName );
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename='.$strFileName);
        header('Expires: 0');
        header('Pragma: public');

        $fp = @fopen( 'php://output', 'w' );
        foreach ( $aryDataList as $aryRow )
            fputcsv( $fp, $aryRow, $strDelimiter );

        fclose($fp);
        exit;
    }
    
    public static function exportExcel( $strFileName, $aryDataList ) {
        $strFileName = basename( $strFileName );
        ob_start();
        ini_set( 'zlib.output_compression','Off' );
        set_time_limit( 0 );
        ini_set( "memory_limit","1000M" );
        header( 'Pragma: private' );
        header( "Expires: Sat, 26 Jul 1997 05:00:00 GMT" );                  // Date in the past
        header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
        header( 'Cache-Control: no-store, no-cache, must-revalidate' );     // HTTP/1.1
        header( 'Cache-Control: pre-check=0, post-check=0, max-age=0' );    // HTTP/1.1
        header( "Pragma: no-cache" );
        header( "Expires: 0" );
        header( 'Content-Transfer-Encoding: none' );
        header( 'Content-Type: application/vnd.ms-excel;' );                 // This should work for IE & Opera
        header( "Content-type: application/x-msexcel" );                    // This should work for the rest
        header( 'Content-Disposition: attachment; filename='.$strFileName );

        foreach( $aryDataList as $aryRow ) {
            array_walk($aryRow, function(&$str) {
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            });
            echo implode("\t", array_values($aryRow)) . "\r\n";
        }
        exit;
    }
    
    public static function x_get_current_post_type() {
        global $post, $typenow, $current_screen;
        if( $post && $post->post_type )
            $post_type = $post->post_type;
        elseif( $typenow )
            $post_type = $typenow;
        elseif( $current_screen && $current_screen->post_type )
            $post_type = $current_screen->post_type;
        elseif( isset( $_REQUEST['post_type'] ) )
            $post_type = sanitize_key( $_REQUEST['post_type'] );
        else
            $post_type = null;
        return $post_type;
    }
    
    public static function paginationLoad( $strUrl = null, $intSelectedPage = 1, $intPagingRange = 5, $aryPageTitleList = null, $intTotalPage, $strPagedFieldName = 'page', $blnReplaceInQuery = false ){
        $intTotalPage = (int)$intTotalPage;
        
        if( $intTotalPage < 2 )
            return array( array(), array(), 1, 1 );
        
        $intSelectedPage = (int)$intSelectedPage;
        if( !( $intSelectedPage > 0 ) )
            $intSelectedPage = 1;
        
        $intPagingRange = (int)$intPagingRange;
        if(  !( $intPagingRange % 2 ) || $intPagingRange < 3 )
            $intPagingRange = 5;
        
        $aryPageTitleList = $aryPageTitleList && is_array( $aryPageTitleList ) && sizeof( $aryPageTitleList ) == $intTotalPage ? array_values( $aryPageTitleList ) : range( 1, $intTotalPage );
        
        $strUrl = $strUrl ? $strUrl : $_SERVER['REQUEST_URI'];
        parse_str( parse_url( $strUrl, PHP_URL_QUERY ), $aryQuery );
        $strHref = parse_url( $strUrl, PHP_URL_PATH ) ;

        $intPagingRangeLowest = $intPagingRange;
        $intPagingRangeHeighest = $intTotalPage - $intPagingRange + 1;

        if ($intSelectedPage > $intPagingRangeLowest && $intSelectedPage < $intPagingRangeHeighest) {
            $intPagingRangeLow = $intSelectedPage - ($intPagingRange-1)/2;
            $intPagingRangeHeigh = $intSelectedPage + ($intPagingRange-1)/2;
            $intPagePrev = $intPagingRangeLow - 1;
            $intPageNext = $intPagingRangeHeigh + 1;
            $intPagePrevJump = $intPagingRangeLow - ($intPagingRange-1)/2;
            $intPageNextJump = $intPagingRangeHeigh + ($intPagingRange-1)/2;
        }elseif ($intSelectedPage <= $intPagingRangeLowest){
            $intPagingRangeLow=1;
            $intPagingRangeHeigh=$intPagingRangeLowest;
            $intPagePrev=0;
            $intPageNext = $intPagingRangeHeigh + 1;
            $intPagePrevJump = 0;
            $intPageNextJump = $intPagingRangeHeigh + ($intPagingRange-1)/2;
        }elseif ($intSelectedPage >= $intPagingRangeHeighest){
            $intPagingRangeLow = $intPagingRangeHeighest;
            $intPagingRangeHeigh = $intTotalPage;
            $intPagePrev = $intPagingRangeLow - 1;
            $intPageNext = 0;
            $intPagePrevJump = $intPagingRangeLow - ($intPagingRange - 1)/2;
            $intPageNextJump = 0;
        }

        $aryPageList = array();
        $i = 0;
        while( $i < $intTotalPage ){
            $blnLoaded = false;
            $intPageNum = $i + 1;
            $arySettings = null;
            if ($intPageNum >= $intPagingRangeLow && $intPageNum <= $intPagingRangeHeigh){
                $arySettings = array(
                    'class' => '',
                    'title' => $aryPageTitleList[$i],
                    'href' => self::paginationPopulateUrl( $strHref, $aryQuery, $intPageNum, $strPagedFieldName, $blnReplaceInQuery ),
                    'text' => $intPageNum,
                );
                if( $intSelectedPage == $intPageNum ){
                    $arySettings[ 'class' ] = 'active';
                    $arySettings[ 'text' ] .= ' <span class="sr-only">(current)</span>';
                }
            }elseif (!$i){
                $arySettings = array(
                    'class' => 'first',
                    'title' => $aryPageTitleList[$i],
                    'href' => self::paginationPopulateUrl( $strHref, $aryQuery, $intPageNum, $strPagedFieldName, $blnReplaceInQuery ),
                    'text' => $intPageNum,
                );
            }elseif ($intPageNum==$intTotalPage){
                $arySettings = array(
                    'class' => 'last',
                    'title' => $aryPageTitleList[$i],
                    'href' => self::paginationPopulateUrl( $strHref, $aryQuery, $intPageNum, $strPagedFieldName, $blnReplaceInQuery ),
                    'text' => $intPageNum,
                );
            }elseif ($intPageNum==$intPagePrev){
                $arySettings = array(
                    'class' => 'prev-page',
                    'title' => $aryPageTitleList[$i],
                    'href' => self::paginationPopulateUrl( $strHref, $aryQuery, $intPageNum, $strPagedFieldName, $blnReplaceInQuery ),
                    'text' => '...',
                );
            }elseif ($intPageNum==$intPageNext){
                $arySettings = array(
                    'class' => 'next-page',
                    'title' => $aryPageTitleList[$i],
                    'href' => self::paginationPopulateUrl( $strHref, $aryQuery, $intPageNum, $strPagedFieldName, $blnReplaceInQuery ),
                    'text' => '...',
                );
            }elseif ($intPageNum==$intPagePrevJump){
                $arySettings = array(
                    'class' => 'prev-range',
                    'title' => $aryPageTitleList[$i],
                    'href' => self::paginationPopulateUrl( $strHref, $aryQuery, $intPageNum, $strPagedFieldName, $blnReplaceInQuery ),
                    'text' => '&laquo;',
                );
            }elseif ($intPageNum==$intPageNextJump){
                $arySettings = array(
                    'class' => 'next-range',
                    'title' => $aryPageTitleList[$i],
                    'href' => self::paginationPopulateUrl( $strHref, $aryQuery, $intPageNum, $strPagedFieldName, $blnReplaceInQuery ),
                    'text' => '&raquo;',
                );
            }
            if( $arySettings )
                $aryPageList[] = $arySettings;
            $i++;
        }
        
        return array( $aryPageList, $aryPageTitleList, $intSelectedPage, $intTotalPage );

    }
    
    public static function paginationPopulateUrl( $strHref, $aryQuery = array(), $intPageNum, $strPagedFieldName = 'page', $blnReplaceInQuery = false ){
        if( $blnReplaceInQuery ){
            $aryQuery[ $strPagedFieldName ] = $intPageNum > 1 ? $intPageNum : null;
        }else{
            $blnPageFound = false;
            $aryHref = explode( '/' , $strHref );
            foreach( $aryHref as $intPos => $strField ){
                if( $strField == $strPagedFieldName ){
                    if( $intPageNum > 1 ){
                        $aryHref[ $intPos + 1 ] = $intPageNum;
                    }else{
                        $aryHref[ $intPos ] = null;
                        $aryHref[ $intPos + 1 ] = null;
                    }
                    $blnPageFound = true;
                    break;
                }
            }
            $aryHref = array_filter( $aryHref );
            if( !$blnPageFound && $intPageNum > 1 ){
                $aryHref[] = $strPagedFieldName;
                $aryHref[] = $intPageNum;
            }
            $strHref = '/'.implode( '/', $aryHref ).'/';
        }
        
        $aryQuery = array_filter( $aryQuery );
        return $strHref.( sizeof( $aryQuery ) ? '?'.http_build_query($aryQuery, '&amp;') : '' );
    }
    
    public static function formatBytes($bytes, $precision = 2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow]; 
    }
}