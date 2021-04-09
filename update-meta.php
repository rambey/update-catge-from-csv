<?php

    $begin_time = array_sum(explode(' ', microtime()));
    @ini_set('max_execution_time', -1);
    @ini_set('memory_limit', '256M');
    @set_time_limit(0);

    require '../../config/config.inc.php';
    require '../../init.php';

   if (($handle = fopen("ancres-de.csv", "r")) !== FALSE) {
       

        for ($current_line = 0; $line = fgetcsv($handle, 0, ","); $current_line++) {
            if($current_line >= 1)
            {
              
                $category_id = $line[0];
                $ancre = $line[1];
                $ancre_updated = $line[2];
                
                if ($category_id && !empty($ancre_updated)) {
                    
                    $query = 'UPDATE '._DB_PREFIX_.'category_lang  categ_lang
                                LEFT JOIN '._DB_PREFIX_.'category categ   ON  categ.id_category = categ_lang.id_category
                                SET categ_lang.name = "'. $ancre_updated.'"';
                    
                    $query .= 'WHERE categ_lang.id_shop = "1" AND categ_lang.id_lang = "2" AND categ.id_category = '.$category_id;
                     
                    
                    if(Db::getInstance()->execute($query)){
                        echo '&nbsp;&nbsp;:&nbsp;&nbsp;<a href="'.$line['0'].'" style="background:green; color:white;">'.$line['0'].'</a><br>';
                    }else{
                        echo '&nbsp;&nbsp;:&nbsp;&nbsp;<a href="'.$line['0'].'" style="background:red; color:white;">'.$line['0'].'</a><br>';
                    }
                    
                } 
            }
        }
    }
    $end_time = array_sum(explode(' ', microtime()));
    echo 'Le temps d\'exécution est '.($end_time - $begin_time);
