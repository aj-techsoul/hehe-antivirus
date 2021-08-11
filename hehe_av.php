<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/aj-techsoul/ELICSS@3.7.1/eli.css" />
    <script defer="" src="https://cdn.jsdelivr.net/gh/aj-techsoul/ELICSS@3.7.1/eli.min.js"></script>    
    <title>Hehe Antivirus v1.1</title>
</head>
<body>
<main>

<section class="g align-fc">
    <h1>&#128526;</h1>
    <h3 class="brown-text">Your Handy Antivirus</h3>
</section>    
<section class="">
<?php
// echo exec("clamscan -ri /");
?>
<form action="" method="POST" class="container" enctype="multipart/form-data">
<input type="text" name="path" label="Path of Malware Reports">
<input type="file" name="report" label="Upload Malware Reports" accept="*.txt">
<div class="g align-c">
<input type="submit" value="Start" class="default btn green ">
</div>
</form>
</section>
<section class="black green-text">
<pre>
<?php
if(isset($_POST) && isset($_POST['path']) || isset($_FILES) && isset($_FILES['report'])){
  echo "<small class='grey-text'>Scanning...</small><br>";  
  $type = (isset($_FILES['report'])) ? "report" : "path";
  switch($type){
      case "report":
            // file 
            $text = file_get_contents(@$_FILES["report"]["tmp_name"]);

        break;
        default:
            // path
            $text = file_get_contents(@$_POST['path']);
        break;
  }  

//   echo $text;
}
?>
<?php
$i = 0;
$j = 0;
$filespaths = array();
$ln = explode("\n",$text);
if(count($ln) > 0){
   
    foreach($ln as $l){

        if($l == "\n" || strlen($l) == 0){
            die("[--- Done ---]");
        }
       
        if(strpos($l,":") > 0){
            $i++;
            $l2 = explode(":",$l);
            
            if(isset($l2[0]) && file_exists($l2[0])){
                $filespaths[] = $l2[0];
                $qrdir = "_quarantine";
                $qrntn = $qrdir.$l2[0];
               
                if(!is_dir($qrdir)){
                    mkdir($qrdir,0755);
                }
                chmod($l2[0],0755);
                if(!file_exists($qrntn)){
                   file_put_contents($qrntn,file_get_contents($l2[0]));
                }
                
            //    copy($l2[0],$qrntn);
                echo "<small class='green-text'> ".@$l2[0]." <strong class='red-text'>".@$l2[1]."</strong> </small>";
                if(file_exists($qrntn)){
                    echo "<span class='orange-text'>[Quarantined]</span> &nbsp;&nbsp;";
                   unlink($l2[0]);
                    if(!file_exists($l2[0])){
                        echo "<span class='green-text'>[DELETED]</span>";    
                    }
                    else
                    {
                        echo "<span class='red-text'>[NOT DELETED]</span>";
                    }
                    echo "<br>";
                }
                else
                {
                    echo "<span class='yellow-text'>[<strong>Not</strong> Quarantined]</span> &nbsp;&nbsp;";
                   unlink($l2[0]);
                    if(!file_exists($l2[0])){
                        echo "<span class='green-text'>[DELETED]</span>";    
                    }
                    else
                    {
                        echo "<span class='red-text'>[NOT DELETED]</span>";
                    }
                    echo "<br>";
                }
            }
            else
            {
                echo "<small class='green-text'> ".@$l2[0]." <strong class='red-text'>".@$l2[1]."</strong> </small>";
                echo "<span class='white-text'>[Does not Exist]</span><br>";
            }
        }
    }
}   
?>
</pre>
</section>



</main>


</body>
</html>

<!-- // file path of report
// delete one by one
// domain.com/index.php put in quarantine 
// domain.com/.htaccess put in quarantine -->
