<?php

$handle = fopen ("php://stdin","r");
$line = trim(fgets($handle),"\n");

$words=explode(" ",$line);

switch($words[0]){
    case 'make:app':
        if(!isset($words[1]) || !$words[1]){
            echo "\033[31m";
            print('invalid app name'."\n");
                echo "\033[30m"."\n";
            exit(0);
        }
        $words[1]=trim($words[1],'/');
        @mkdir('apps/modules/'.$words[1], 0755, true);
        @mkdir('apps/modules/'.$words[1].'/controllers', 0755, true);
        @mkdir('apps/modules/'.$words[1].'/libraries', 0755, true);
        @mkdir('apps/modules/'.$words[1].'/models', 0755, true);
        echo "\033[32m";
        print('created app: '.'apps/modules/'.$words[1]."\n");
        print('created app: '.'apps/modules/'.$words[1].'/configs'."\n");
        print('created app: '.'apps/modules/'.$words[1].'/controllers'."\n");
        print('created app: '.'apps/modules/'.$words[1].'/libraries'."\n");
        print('created app: '.'apps/modules/'.$words[1].'/models'."\n");
        echo "\033[30m"."\n";
        break;
    case 'make:migration':
        if(!isset($words[1]) || !$words[1]){
            echo "\033[31m";
            print('invalid app name'."\n");
            echo "\033[30m"."\n";
            exit(0);
        }
        $words[1]=trim($words[1],'/');
        $file='database/migrations/'.date('YmdHis').'_'.$words[1].'.php';
        $handle=fopen($file,'a+');
        $string='<?php'.PHP_EOL;
        $string.=''.PHP_EOL;
        $string.=''.PHP_EOL;
        $string.='class '.$words[1].'{'.PHP_EOL;
        $string.=''.PHP_EOL;
            $string.="    ".'public static function up(){'.PHP_EOL;
            $string.='    '.PHP_EOL;
            $string.='    '.PHP_EOL;
            $string.='    '.PHP_EOL;
            $string.='    }'.PHP_EOL;
            $string.=''.PHP_EOL;
            $string.="    ".'public static function down(){'.PHP_EOL;
            $string.='    '.PHP_EOL;
            $string.='    '.PHP_EOL;
            $string.='    '.PHP_EOL;
            $string.='    }'.PHP_EOL;
            $string.=''.PHP_EOL;
        $string.='}'.PHP_EOL;
        $string.=''.PHP_EOL;
        fwrite($handle,$string);
        fclose($handle);
        if(file_exists($file)){
            echo "\033[32m";
            print('created migation: '.$file."\n");
            echo "\033[30m"."\n";
        }
        
    break;
    default:
            echo "\033[31m";
            print('invalid command'."\n");
                echo "\033[30m"."\n";
}



