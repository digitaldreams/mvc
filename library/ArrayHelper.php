<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ArrayHelper {

    public function filterByRegex(array $sourceArray, $regex = '', $mode = '', $useKey = FALSE) {
        if (count($sourceArray) < 1 || empty($regex)) {
            return $sourceArray;
        }
        $retArray = array();
        $rxMode = '';
        $rxFlag = '';
        switch ($mode) {
            case 'match':
                $rxMode = RegexIterator::MATCH;
                break;
            case 'matchAll':
                $rxMode = RegexIterator::ALL_MATCHES;
                break;
            case 'replace':

                break;
            case 'getMatch':
                $rxMode = RegexIterator::GET_MATCH;
                break;
            default :
                $rxMode = RegexIterator::MATCH;
                break;
                ;
        }

        $multiIterator = new RecursiveArrayIterator($sourceArray);
        $rrit = new RecursiveIteratorIterator($multiIterator);
        $regexIt = new RegexIterator($rrit, $regex, $rxMode);
        if (!empty($useKey)) {
            $regexIt->setFlags(RegexIterator::USE_KEY);
        }
        foreach ($regexIt as $key => $value) {
            if (is_string($key)) {
                $retArray[$key][] = $value;
            } else {
                $retArray[] = $value;
            }
        }
        if ($useKey) {
            $keys = array_keys($retArray);
            $multiIt = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
            $i = 1;
            foreach ($keys as $k => $mvalue) {
                if (!is_array($retArray[$mvalue]))
                    continue;
                $ait[$i] = new ArrayIterator($retArray[$mvalue]);
                $multiIt->attachIterator($ait[$i], $mvalue);
                $i++;
            }
            $retArray = array();
            foreach ($multiIt as $nArr) {
                $retArray[] = $nArr;
            }
        }

        return $retArray;
    }

    public function filterByCallback(array $sourceArray, callable $function) {
        
    }

    public function directoryFilter() {
        
    }

    /**
     * 
     * @param type $sourceArray
     * @param type $keyword /(spl|php|tutorial)/
     */
    public function priority($sourceArray, $keyword) {
       // $topemp = new SplPriorityQueue();
        //$topemp->setExtractFlags(SplPriorityQueue::EXTR_DATA);
        
        $rait = new RecursiveArrayIterator($sourceArray);
        $regex = new RecursiveRegexIterator($rait,$keyword,RecursiveRegexIterator::ALL_MATCHES);
              foreach ($regex as $value) {
            if($regex->hasChildren()){
                foreach ($regex->getChildren() as $key2=>$value2){
                /*
                 if (is_array($value) && count($value[1]) > 0) {
                $realValue = $ait->offsetGet($key);
                $topemp->insert($realValue, count($value[1]));
                }
                 */   
                print_r($value2);
                }
            }else{
                echo 'NO Children';
            }
           
        }
   
    }//End of priority Queue function

}
