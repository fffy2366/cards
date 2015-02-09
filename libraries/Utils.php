<?php
class Utils{
	public function Utils(){
	}
	/**
	 * 对象转数组
	 */
	public static function object_to_array($obj){
		
		$_arr = is_object($obj) ? get_object_vars($obj) : $obj; 
		$arr = array() ;
		foreach ($_arr as $key => $val) { 
			$val = (is_array($val) || is_object($val)) ? Utils::object_to_array($val) : $val; 
			$arr[$key] = $val; 
		}
		
		//echo "1" ;
		return $arr; 
	}
	public static function safeInput(){
		   Utils::safeArray($_GET);
		   Utils::safeArray($_POST);
		   Utils::safeArray($_REQUEST);
		   Utils::safeArray($_COOKIE);
	}
	public static function safeArray(&$arr){
		foreach($arr as $k => $v){
					if(is_array($v)){
						 $arr[$k]=Utils::safeArray($v);
						  continue;
					}
			$arr[$k]=str_replace(array('<','>'),array('&lt;','&gt;'),addslashes($v));
		}    
	}
	public static function unsafeArray($arr){
		foreach($arr as $k => $v){
					if(is_array($v)){
						 $arr[$k]=Utils::unsafeArray($v);
						  continue;
					}
			$arr[$k]=str_replace(array('&lt;','&gt;'),array('<','>'),$v);
		}    
		return $arr ;
	}
	
	/**
	 * return  uuid
	 */
	public static function uuid($prefix = ''){
		$chars = md5(uniqid(mt_rand(), true));
		$uuid= substr($chars,0,8) . '-';
		$uuid.= substr($chars,8,4) . '-';
		$uuid.= substr($chars,12,4) . '-';
		$uuid.= substr($chars,16,4) . '-';
		$uuid.= substr($chars,20,12);
		return $prefix . $uuid;
	} 
	// 获取客户端操作系统信息
	public static function get_os(){
	    $os = $_SERVER['HTTP_USER_AGENT'];
	    if(preg_match('/NT\s5\.1/', $os)) {
	        $os = "Windows XP";
	    } elseif (preg_match('/NT\s6\.0/', $os)) {
	        $os =  "Windows Vista \ server 2008";
	    } elseif (preg_match('/NT\s5\.2/', $os)) {
	        $os = "Windows Server 2003";
	    } elseif (preg_match('/NT\s5/', $os)) {
	        $os = "Windows 2000";
	    } elseif (preg_match('/NT\s6\.2/', $os)) {
	        $os = "Windows 8";
	    } elseif (preg_match('/NT\s6\.1/', $os)) {
	        $os = "Windows 7";
	    } elseif (preg_match('/NT/', $os)) {
	        $os = "Windows NT";
	    } elseif (preg_match('/Linux/', $os)) {
	        $os = "Linux";
	    } elseif (preg_match('/Unix/', $os)) {
	        $os = "Unix";
	    } elseif (preg_match('/Mac/',$os)) {
	        $os = "Macintosh";
	    } elseif (preg_match('/NT\s6\.1/',$os)) {
	        $os = "Windows 7";
	    } else {
	        $os = "Unknow OS";
	    }
	    return $os;
	}
	/**
	 * return
	 * $mobile_browser 是否是移动设备
	 * $mobile_type 移动设备类型
	 */
	public static function mobile_device_detect()
	{
	  $mobile_browser   = "false";
	  $user_agent       = $_SERVER['HTTP_USER_AGENT'];
	  $accept           = $_SERVER['HTTP_ACCEPT'];
	  $mobile_type="pc";
	  switch(true)
	  {
	   	 case (preg_match('/ipod/i',$user_agent));
	      $mobile_browser = "true";
	      $mobile_type="ipod";
	   	  break;
	   	 case (preg_match('/iphone/i',$user_agent));
	      $mobile_browser = "true";
	      $mobile_type="iphone";
	   	  break;
	   	 case (preg_match('/ipad/i',$user_agent));
	      $mobile_browser = "true";
	      $mobile_type="ipad";
	   	  break;
		 case (preg_match('/android/i',$user_agent));
	      $mobile_browser = "true";
	      $mobile_type="android";
	    break;
		 case (preg_match('/adr/i',$user_agent));
	      $mobile_browser = "true";
	      $mobile_type="android";
	    break;
		case (preg_match('/Chrome/i',$user_agent));
	      $mobile_browser = "false";
	      $mobile_type="Chrome";
	    break;
		//case (preg_match('/Safari/i',$user_agent));
	      //$mobile_browser = "true";
	      //$mobile_type="safari";
	   	  //break;
	
	    case (preg_match('/opera mini/i',$user_agent));
	      $mobile_browser = "true";
	      $mobile_type="opera_mini";
	    break;
	
	    case (preg_match('/blackberry/i',$user_agent));
	      $mobile_browser = "true";
	      $mobile_type="blackberry";
	    break;
	    case (preg_match('/(palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i',$user_agent));
	      $mobile_browser = "true";
	      $mobile_type="palm";
	    break;
	
	    case (preg_match('/(windows ce; ppc;|windows ce; smartphone;|windows ce; iemobile)/i',$user_agent));
	      $mobile_browser = "true";
	      $mobile_type="windows_ce";
	    break;
	
	    case (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|pda|psp|treo)/i',$user_agent)); // check if any of the values listed create a match on the user agent - these are some of the most common terms used in agents to identify them as being mobile devices - the i at the end makes it case insensitive
	      $mobile_browser = "true";
	      $mobile_type="symbian";
	    break;
	
	    case ((strpos($accept,'text/vnd.wap.wml')>0)||(strpos($accept,'application/vnd.wap.xhtml+xml')>0));
	      $mobile_browser = "true";
	      $mobile_type="wap";
	    break;
	
	    case (isset($_SERVER['HTTP_X_WAP_PROFILE'])||isset($_SERVER['HTTP_PROFILE']));
	      $mobile_browser = "true";
	      $mobile_type="wap";
	    break;
	
	    case (in_array(strtolower(substr($user_agent,0,4)),array('1207'=>'1207','3gso'=>'3gso','4thp'=>'4thp','501i'=>'501i','502i'=>'502i','503i'=>'503i','504i'=>'504i','505i'=>'505i','506i'=>'506i','6310'=>'6310','6590'=>'6590','770s'=>'770s','802s'=>'802s','a wa'=>'a wa','acer'=>'acer','acs-'=>'acs-','airn'=>'airn','alav'=>'alav','asus'=>'asus','attw'=>'attw','au-m'=>'au-m','aur '=>'aur ','aus '=>'aus ','abac'=>'abac','acoo'=>'acoo','aiko'=>'aiko','alco'=>'alco','alca'=>'alca','amoi'=>'amoi','anex'=>'anex','anny'=>'anny','anyw'=>'anyw','aptu'=>'aptu','arch'=>'arch','argo'=>'argo','bell'=>'bell','bird'=>'bird','bw-n'=>'bw-n','bw-u'=>'bw-u','beck'=>'beck','benq'=>'benq','bilb'=>'bilb','blac'=>'blac','c55/'=>'c55/','cdm-'=>'cdm-','chtm'=>'chtm','capi'=>'capi','comp'=>'comp','cond'=>'cond','craw'=>'craw','dall'=>'dall','dbte'=>'dbte','dc-s'=>'dc-s','dica'=>'dica','ds-d'=>'ds-d','ds12'=>'ds12','dait'=>'dait','devi'=>'devi','dmob'=>'dmob','doco'=>'doco','dopo'=>'dopo','el49'=>'el49','erk0'=>'erk0','esl8'=>'esl8','		ez40'=>'ez40','ez60'=>'ez60','ez70'=>'ez70','ezos'=>'ezos','ezze'=>'ezze','elai'=>'elai','emul'=>'emul','eric'=>'eric','ezwa'=>'ezwa','fake'=>'fake','fly-'=>'fly-','fly_'=>'fly_','g-mo'=>'g-mo','g1 u'=>'g1 u','g560'=>'g560','gf-5'=>'gf-5','grun'=>'grun','gene'=>'gene','go.w'=>'go.w','good'=>'good','grad'=>'grad','hcit'=>'hcit','hd-m'=>'hd-m','hd-p'=>'hd-p','hd-t'=>'hd-t','hei-'=>'hei-','hp i'=>'hp i','hpip'=>'hpip','hs-c'=>'hs-c','htc '=>'htc ','htc-'=>'htc-','htca'=>'htca','htcg'=>'htcg','htcp'=>'htcp','htcs'=>'htcs','htct'=>'htct','htc_'=>'htc_','haie'=>'haie','hita'=>'hita','huaw'=>'huaw','hutc'=>'hutc','i-20'=>'i-20','i-go'=>'i-go','i-ma'=>'i-ma','i230'=>'i230','iac'=>'iac','iac-'=>'iac-','iac/'=>'iac/','ig01'=>'ig01','im1k'=>'im1k','inno'=>'inno','iris'=>'iris','jata'=>'jata','java'=>'java','kddi'=>'kddi','kgt'=>'kgt','kgt/'=>'kgt/','kpt '=>'kpt ','kwc-'=>'kwc-','klon'=>'klon','lexi'=>'lexi','lg g'=>'lg g','lg-a'=>'lg-a','lg-b'=>'lg-b','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-f'=>'lg-f','lg-g'=>'lg-g','lg-k		'=>'lg-k','lg-l'=>'lg-l','lg-m'=>'lg-m','lg-o'=>'lg-o','lg-p'=>'lg-p','lg-s'=>'lg-s','lg-t'=>'lg-t','lg-u'=>'lg-u','lg-w'=>'lg-w','lg/k'=>'lg/k','lg/l'=>'lg/l','lg/u'=>'lg/u','lg50'=>'lg50','lg54'=>'lg54','lge-'=>'lge-','lge/'=>'lge/','lynx'=>'lynx','leno'=>'leno','m1-w'=>'m1-w','m3ga'=>'m3ga','m50/'=>'m50/','maui'=>'maui','mc01'=>'mc01','mc21'=>'mc21','mcca'=>'mcca','medi'=>'medi','meri'=>'meri','mio8'=>'mio8','mioa'=>'mioa','mo01'=>'mo01','mo02'=>'mo02','mode'=>'mode','modo'=>'modo','mot '=>'mot ','mot-'=>'mot-','mt50'=>'mt50','mtp1'=>'mtp1','mtv '=>'mtv ','mate'=>'mate','maxo'=>'maxo','merc'=>'merc','mits'=>'mits','mobi'=>'mobi','motv'=>'motv','mozz'=>'mozz','n100'=>'n100','n101'=>'n101','n102'=>'n102','n202'=>'n202','n203'=>'n203','n300'=>'n300','n302'=>'n302','n500'=>'n500','n502'=>'n502','n505'=>'n505','n700'=>'n700','n701'=>'n701','n710'=>'n710','nec-'=>'nec-','nem-'=>'nem-','newg'=>'newg','neon'=>'neon','netf'=>'netf','noki'=>'noki','nzph'=>'nzph','o2 x'=>'o2 x','o2-x'=>'o2-x','opwv'=>'opwv','owg1		'=>'owg1','opti'=>'opti','oran'=>'oran','p800'=>'p800','pand'=>'pand','pg-1'=>'pg-1','pg-2'=>'pg-2','pg-3'=>'pg-3','pg-6'=>'pg-6','pg-8'=>'pg-8','pg-c'=>'pg-c','pg13'=>'pg13','phil'=>'phil','pn-2'=>'pn-2','pt-g'=>'pt-g','palm'=>'palm','pana'=>'pana','pire'=>'pire','pock'=>'pock','pose'=>'pose','psio'=>'psio','qa-a'=>'qa-a','qc-2'=>'qc-2','qc-3'=>'qc-3','qc-5'=>'qc-5','qc-7'=>'qc-7','qc07'=>'qc07','qc12'=>'qc12','qc21'=>'qc21','qc32'=>'qc32','qc60'=>'qc60','qci-'=>'qci-','qwap'=>'qwap','qtek'=>'qtek','r380'=>'r380','r600'=>'r600','raks'=>'raks','rim9'=>'rim9','rove'=>'rove','s55/'=>'s55/','sage'=>'sage','sams'=>'sams','sc01'=>'sc01','sch-'=>'sch-','scp-'=>'scp-','sdk/'=>'sdk/','se47'=>'se47','sec-'=>'sec-','sec0'=>'sec0','sec1'=>'sec1','semc'=>'semc','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','sk-0'=>'sk-0','sl45'=>'sl45','slid'=>'slid','smb3'=>'smb3','smt5'=>'smt5','sp01'=>'sp01','sph-'=>'sph-','spv '=>'spv ','spv-'=>'spv-','sy01'=>'sy01','samm'=>'samm','sany'=>'sany','sava'=>'sava','scoo'=>'scoo','send		'=>'send','siem'=>'siem','smar'=>'smar','smit'=>'smit','soft'=>'soft','sony'=>'sony','t-mo'=>'t-mo','t218'=>'t218','t250'=>'t250','t600'=>'t600','t610'=>'t610','t618'=>'t618','tcl-'=>'tcl-','tdg-'=>'tdg-','telm'=>'telm','tim-'=>'tim-','ts70'=>'ts70','tsm-'=>'tsm-','tsm3'=>'tsm3','tsm5'=>'tsm5','tx-9'=>'tx-9','tagt'=>'tagt','talk'=>'talk','teli'=>'teli','topl'=>'topl','tosh'=>'tosh','up.b'=>'up.b','upg1'=>'upg1','utst'=>'utst','v400'=>'v400','v750'=>'v750','veri'=>'veri','vk-v'=>'vk-v','vk40'=>'vk40','vk50'=>'vk50','vk52'=>'vk52','vk53'=>'vk53','vm40'=>'vm40','vx98'=>'vx98','virg'=>'virg','vite'=>'vite','voda'=>'voda','vulc'=>'vulc','w3c '=>'w3c ','w3c-'=>'w3c-','wapj'=>'wapj','wapp'=>'wapp','wapu'=>'wapu','wapm'=>'wapm','wig '=>'wig ','wapi'=>'wapi','wapr'=>'wapr','wapv'=>'wapv','wapy'=>'wapy','wapa'=>'wapa','waps'=>'waps','wapt'=>'wapt','winc'=>'winc','winw'=>'winw','wonu'=>'wonu','x700'=>'x700','xda2'=>'xda2','xdag'=>'xdag','yas-'=>'yas-','your'=>'your','zte-'=>'zte-','zeto'=>'zeto','acs-'=>'acs-','alav		'=>'alav','alca'=>'alca','amoi'=>'amoi','aste'=>'aste','audi'=>'audi','avan'=>'avan','benq'=>'benq','bird'=>'bird','blac'=>'blac','blaz'=>'blaz','brew'=>'brew','brvw'=>'brvw','bumb'=>'bumb','ccwa'=>'ccwa','cell'=>'cell','cldc'=>'cldc','cmd-'=>'cmd-','dang'=>'dang','doco'=>'doco','eml2'=>'eml2','eric'=>'eric','fetc'=>'fetc','hipt'=>'hipt','http'=>'http','ibro'=>'ibro','idea'=>'idea','ikom'=>'ikom','inno'=>'inno','ipaq'=>'ipaq','jbro'=>'jbro','jemu'=>'jemu','java'=>'java','jigs'=>'jigs','kddi'=>'kddi','keji'=>'keji','kyoc'=>'kyoc','kyok'=>'kyok','leno'=>'leno','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-g'=>'lg-g','lge-'=>'lge-','libw'=>'libw','m-cr'=>'m-cr','maui'=>'maui','maxo'=>'maxo','midp'=>'midp','mits'=>'mits','mmef'=>'mmef','mobi'=>'mobi','mot-'=>'mot-','moto'=>'moto','mwbp'=>'mwbp','mywa'=>'mywa','nec-'=>'nec-','newt'=>'newt','nok6'=>'nok6','noki'=>'noki','o2im'=>'o2im','opwv'=>'opwv','palm'=>'palm','pana'=>'pana','pant'=>'pant','pdxg'=>'pdxg','phil'=>'phil','play'=>'play','pluc'=>'pluc','port'=>'port','prox		'=>'prox','qtek'=>'qtek','qwap'=>'qwap','rozo'=>'rozo','sage'=>'sage','sama'=>'sama','sams'=>'sams','sany'=>'sany','sch-'=>'sch-','sec-'=>'sec-','send'=>'send','seri'=>'seri','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','siem'=>'siem','smal'=>'smal','smar'=>'smar','sony'=>'sony','sph-'=>'sph-','symb'=>'symb','t-mo'=>'t-mo','teli'=>'teli','tim-'=>'tim-','tosh'=>'tosh','treo'=>'treo','tsm-'=>'tsm-','upg1'=>'upg1','upsi'=>'upsi','vk-v'=>'vk-v','voda'=>'voda','vx52'=>'vx52','vx53'=>'vx53','vx60'=>'vx60','vx61'=>'vx61','vx70'=>'vx70','vx80'=>'vx80','vx81'=>'vx81','vx83'=>'vx83','vx85'=>'vx85','wap-'=>'wap-','wapa'=>'wapa','wapi'=>'wapi','wapp'=>'wapp','wapr'=>'wapr','webc'=>'webc','whit'=>'whit','winw'=>'winw','wmlb'=>'wmlb','xda-'=>'xda-',))); // check against a list of trimmed user agents to see if we find a match
	      $mobile_browser = "true";
	      $mobile_type="other";
	    break;
	  }
	  return array($mobile_browser,$mobile_type);	
	}
	/**
	 * 获取客户端浏览器信息
	 */
	public static function get_browser(){
	    $brower = $_SERVER['HTTP_USER_AGENT'];
	    if(preg_match('/360SE/', $brower)) {
	        $brower = "360se";
	    } elseif (preg_match('/Maxthon/', $brower)) {
	        $brower ="Maxthon";
	    } elseif (preg_match('/Tencent/', $brower)) {
	        $brower = "Tencent Brower";
	    } elseif (preg_match('/Green/',$brower)) {
	        $brower = "Green Brower";
	    }elseif(preg_match('/baidu/', $brower)) {
	        $brower = "baidu";
	    } elseif (preg_match('/TheWorld/', $brower)) {
	        $brower = "The World";
	    } elseif (preg_match('/MetaSr/', $brower)) {
	        $brower = "Sogou Brower";
	    } elseif (preg_match('/Firefox/', $brower)) {
	        $brower = "Firefox";
	    } elseif (preg_match('/MSIE\s6\.0/', $brower)) {
	        $brower ="IE6.0";
	    } elseif (preg_match('/MSIE\s7\.0/', $brower)) {
	        $brower = "IE7.0";
	    } elseif (preg_match('/MSIE\s8\.0/', $brower)) {
	        $brower = "IE8.0";
	    } elseif (preg_match('/MSIE\s9\.0/', $brower)) {
	        $brower = "IE9.0";
	    } elseif (preg_match('/Netscape/', $brower)) {
	        $brower = "Netscape";
	    } elseif (preg_match('/Opera/', $brower)) {
	        $brower ="Opera";
	    } elseif (preg_match('/UCBrowser/', $brower)) {
	        $brower =  "UCBrowser";
	    } elseif (preg_match('/MQQBrowser/', $brower)) {
	        $brower =  "QQBrowser";
	    } elseif (preg_match('/Chrome/', $brower)) {
	        $brower =  "Chrome";
	    } elseif (preg_match('/Mobile\sSafari/', $brower)) {
	        $brower = "Mobile Safari";
	    } elseif (preg_match('/Safari/', $brower)) {
	        $brower = "Safari";
	    } elseif (preg_match('/Gecko/', $brower)) {
	        $brower ="Gecko";
	    } else {
	        $brower = "Unknow Browser";
	    }
	    return $brower;
	}
}
?>