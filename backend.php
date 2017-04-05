<?php

           $filename  = dirname(__FILE__).'/data.txt';

           //$echo $filename;

           // store new message in the file
           $msg = isset($_GET['msg']) ? $_GET['msg'] : '';


           if ($msg != '')
           {
              //将字符串写入到文件当中.
              file_put_contents($filename,$msg);
              //退出当前脚本.
              die();
           }

           // infinite loop until the data file is not modified

            //从页面获取到当前文件的最后修改时间.
           $lastmodif= isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;

            //获取到文件的最后修改时间.
           $currentmodif = filemtime($filename);

           while ($currentmodif <= $lastmodif) // check if the data file has been modified
           {
              usleep(10000); // sleep 10ms to unload the CPU
              clearstatcache();
              //返回文件内容上次的修改时间.
              $currentmodif = filemtime($filename);
           }
           // return a json array
           $response = array();
           //读取文件内容，写到页面上面.
           $response['msg']= file_get_contents($filename);
           //返回当前文件的最后修改时间.
           $response['timestamp'] = $currentmodif;
           echo json_encode($response);
           flush();
?>