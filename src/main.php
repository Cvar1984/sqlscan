<?php

/*
 * Copyright (c) 2019 <Cvar1984>
 *
 * Licensed unter the Apache License, Version 2.0 or the MIT license, at your
 * option.
 *
 * ********************************************************************************
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * ********************************************************************************
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require 'phar://main.phar/website_parser.php';
if($argc<2) {
    throw new Exception('please inser an url');
    exit(1);
}
if(!file_exists('phar://main.phar/sql.ini')) {
    throw new Exception('sql.ini missing');
    exit(1);
}
else {
    $err=file_get_contents('phar://main.phar/sql.ini');
    $err=trim($err,',');
    $err=explode(',',$err);
}
function println($arg)
{
    echo '[#] '.$arg."\n";
}
try {
    println('Exctracting urls');
    $parser = new WebsiteParser(trim($argv[1]));
    $links = $parser->getHrefLinks();
    $count=sizeof($links);
    println('Total urls : '.$count);
    if(!empty($count)) {
        foreach($links as $urls) {
            $urls[0]=str_replace('=',"='",$urls[0]);
            println('Testing '.$urls[0]);
            $result=@file_get_contents($urls[0]);
            
            foreach($err as $errs) {
                println('Matching '.$errs);
                if(preg_match('/'.$errs.'/',$result)) {
                    println('Vuln -> '.$urls[0]);
                    $file=fopen('result.txt','a');
                    fprintf($file,$urls[0]."\n");
                    fclose($file);
                    break;
                }
            }
        }
    }
    else {
        throw new Exception('can\'t continue urls empty');
        exit(1);
    }
}
catch(Exception $e) {
    echo $e->xdebug_message;
}
