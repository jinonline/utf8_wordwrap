<?php
/*
依照字串佔用的char size調整斷行位置
*/

function utf8_wordwrap($string, $length = 20, $break = "\n") {
    preg_match_all('~\p{Latin}+|\p{Han}+|\p{Hiragana}+|\p{Katakana}+|\p{Bopomofo}+|\p{Common}+~u', $string, $words);
    $new_words = array();
    foreach ($words[0] as $word) {
        if(mb_detect_encoding($word)=='UTF-8' && mb_strlen($word)>1){
            $ary_word = preg_split('/(?<!^)(?!$)/u', $word);
            foreach ($ary_word as $chinese_word) {
                $new_words[] = $chinese_word;
            }
        }else{
            $new_words[] = $word;
        }
    }

    $lines = array();
    $strlen = 0;
    $ret = '';
    foreach ($new_words as $n_word) {
        if($strlen + mb_strwidth($n_word) >= $length){
            $ret.= $break;
            $strlen = 0;
        }
        $ret .= $n_word;
        $strlen += mb_strwidth($n_word);
    }

    return $ret;
}