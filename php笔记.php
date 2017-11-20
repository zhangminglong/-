<?php
    public static function getParents($lists = [], $id = '',$lev = 0)
    {
        $trees = [];
        foreach ($lists as $key => $value) {
            if ($value == $id) {
                $trees[] = $key;
                $trees   = array_merge(self::getParents($lists, $key), $trees);
            }
        }
        return $trees;
    }

    public function getSubTree($data , $id = 0 , $lev = 0) {
		//定义存起来的数组
     	static $son = array();

     	foreach($data as $key => $value) {

         	if($value['pid'] == $id) {

            	$value['lev'] = $lev;

            	$son[] = $value;
            	//查出线下三级
            	if ($lev < 3) {
            		$this->getSubTree($data , $value['id'] , $lev+1);
            	}
         }
     }
     	return $son;
	}


	public function getNumeberOne($arr = null,$id = null)
	{
		$par = array();
		while ($arr[$id]) {
			$par[] = $arr[$id];
			$id = $arr[$id];

		}

		return $par;
	}

    /**
     * 同时支持U-TF8和GBK截取
     * @dateTime 2017-08-24T17:59:25+0800
     * @author sky
     * @param    [type]                   $string [description]
     * @param    [type]                   $sublen [description]
     * @param    integer                  $start  [description]
     * @param    string                   $code   [description]
     * @return   [type]                           [description]
     */
    public function cut_str($string, $sublen, $start =0, $code ='UTF-8')
    {
        if($code =='UTF-8')
        {
            $pa ="/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
            preg_match_all($pa, $string, $t_string);

            if(count($t_string[0])- $start > $sublen)return join('', array_slice($t_string[0], $start, $sublen))."........";
            return join('', array_slice($t_string[0], $start, $sublen));
        }else{
            $start = $start*2;
            $sublen = $sublen*2;
            $strlen = strlen($string);
            $tmpstr ='';
            for($i=0; $i<$strlen; $i++){
                if($i>=$start && $i<($start+$sublen)){
                    if(ord(substr($string, $i,1))>129){
                        $tmpstr.= substr($string, $i,2);
                    }else{
                        $tmpstr.= substr($string, $i,1);
                    }
                }
                if(ord(substr($string, $i,1))>129) $i++;
            }
                    if(strlen($tmpstr)<$strlen ) $tmpstr.="..........";
                    return $tmpstr;
            }
    }