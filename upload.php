<?php
	require_once('SimpleXLSX.php');
    date_default_timezone_set("Asia/Calcutta");
	if ( $xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name']) ) {
 		$printData ='';
 		$allrows = $xlsx->rows();

        $report_dt = ""; 
        $voyage = "";
        $vslname = ""; 
        $callsign = ""; 
        $opr = "";
        $line = 0;
        $contcount = 0;

 		$printData .= "UNB+UNOA:2+KMT+".$_GET['recv_code']."+".date('Ymd:Hi',time())."+".date('YmdHis',time())."'\n";
        $printData .= "UNH+".date('YmdHis',time())."+COPRAR:D:00B:UN:SMDG21+LOADINGCOPRAR '\n";
        $line++;
        
        for($excelrow=0;$excelrow<6;$excelrow++){
            if($excelrow==1) {
                $report_dt = date('YdmHis',strtotime($allrows[$excelrow][1]));
            }
            if($excelrow==3) {
                if(!empty($allrows[$excelrow][3])) {
                    $tmp = explode('/',$allrows[$excelrow][3]);
                    $voyage = $tmp[0];
                    $callsign = $tmp[1];
                    $opr = $tmp[2];
                    $vslname = $allrows[$excelrow][1];
                }
            }
        }
        $printData .= "BGM+45+".$report_dt."+5'\n";$line++;
        $printData .= "TDT+20+".$voyage."+1++172:".$opr."+++".$_GET['Callsign'].":103::".$vslname."'\n";$line++;
        $printData .= "RFF+VON:".$voyage."'\n";$line++;
        $printData .= "NAD+CA+".$opr."'\n";$line++;

        for($excelrow=8;$excelrow<count($allrows);$excelrow++){
            
                if($excelrow>=7){
                    $contcount++;
                    $fe = "5";
                    if(!empty($allrows[$excelrow][3]) && $allrows[$excelrow][3]=="E"){
                        $fe = "4";
                    } 
                    $type = "2";
                    if(!empty($allrows[$excelrow][11]) && $allrows[$excelrow][11]=="Y"){
                        $type = "6";
                    }
                    if(!empty($allrows[$excelrow][1]) || !empty($allrows[$excelrow][7])){
                        $printData .= "EQD+CN+".$allrows[$excelrow][1]."+".$allrows[$excelrow][7].":102:5++".$type."+".$fe."'\n";
                        $line++;
                    }
                    if(!empty($allrows[$excelrow][6])) { 
                       $printData .= "LOC+11+".$allrows[$excelrow][5].":139:6'\n"; 
                       $line++;
                    }
                    if(!empty($allrows[$excelrow][6])){
                        $printData .= "LOC+7+".$allrows[$excelrow][6].":139:6'\n"; 
                        $line++;
                    }
                    if(!empty($allrows[$excelrow][19])){
                         $printData .= "LOC+9+".$allrows[$excelrow][19].":139:6'\n";
                         $line++;
                    }
                    if(!empty($allrows[$excelrow][13])){ 
                        $printData .= "MEA+AAE+VGM+KGM:".$allrows[$excelrow][13]."'\n"; 
                        $line++;
                    }
                    if(!empty($allrows[$excelrow][17]) && trim($allrows[$excelrow][17])!="/") {
                        $dim = explode('/',$allrows[$excelrow][17]);
                        if(trim($dim[0])=="OF") {
                          $printData .= "DIM+5+CMT:".trim($dim[1])."'\n";
                          $line++;
                        }
                        if(trim($dim[0])=="OB") {
                           $printData .= "DIM+6+CMT:".trim($dim[1])."'\n";
                           $line++;
                        }
                        if(trim($dim[0])=="OR") {
                           $printData .= "DIM+7+CMT::".trim($dim[1])."'\n";
                           $line++;
                        }
                        if(trim($dim[0])=="OL") {
                            $printData .= "DIM+8+CMT::".trim(dim[1])."'\n";
                            $line++;
                        }
                        if(trim($dim[0])=="OH") {
                            $printData .= "DIM+9+CMT:::".trim($dim[1])."'\n";
                            $line++;
                        }
                    }
                    if(!empty($allrows[$excelrow][15]) && trim($allrows[$excelrow][15])!="/") {
                          $temperature = $allrows[$excelrow][15];
                          $temperature = str_replace(" ", "",$temperature);
                          $temperature = str_replace("C", "",$temperature);
                          $temperature = str_replace("+", "",$temperature);
                          $printData .= "TMP+2+".$temperature.":CEL'\n";
                          $line++;
                    }
                    if(!empty($allrows[$excelrow][25]) && trim($allrows[$excelrow][25])!="/") {
                          $tmp = explode(',',$allrows[$excelrow][25]);
                          if($tmp[0]=="L") {
                              $printData .= "SEL+".$tmp[1]."+CA'\n";
                              $line++;
                          }
                          if($tmp[0]=="S") {
                              $printData .= "SEL+".$tmp[1]."+SH'\n";
                              $line++;
                          }
                          if($tmp[0]=="M") {
                              $printData .= "SEL+".$tmp[1]."+CU'\n";
                              $line++;
                          }
                    }
                    if(!empty($allrows[$excelrow][8])) {
                        $printData .= "FTX+AAI+++".$allrows[$excelrow][8]."'\n";
                        $line++;
                    }
                    if(!empty($allrows[$excelrow][12]) && $allrows[$excelrow][12] !=" ") {
                        $printData .= "FTX+AAA+++".trim($allrows[$excelrow][12])."'\n";
                        $line++;
                    }
                    if(!empty($allrows[$excelrow][18]) && $allrows[$excelrow][18]!=" " && trim($allrows[$excelrow][18])!="/") {
                        $printData .= "FTX+HAN++".$allrows[$excelrow][18]."'\n";
                        $line++;
                    }
                    if(!empty($allrows[$excelrow][14])&& $allrows[$excelrow][14] != " "&& trim($allrows[$excelrow][14])!="/") {
                          $tmp = explode('/',$allrows[$excelrow][14]);
                          $printData .= "DGS+IMD+".$tmp[0]."+".$tmp[1]."'\n";
                          $line++;
                    }
                    if(!empty($allrows[$excelrow][2])) { 
                        $printData .= "NAD+CF+".$allrows[$excelrow][2].":160:ZZZ'\n"; 
                        $line++;
                    }

                
            }
            
        }
        $contcount--;
            $printData .= "CNT+16:".$contcount."'\n"; $line++; $line++;
            $printData .= "UNT+".$line."+".date('YmdHis',time())."'\n";
            $printData .= "UNZ+1+".date('YmdHis',time())."'";
            echo $printData;
        
  	} else {
    	echo SimpleXLSX::parseError();
  	}


   
?>