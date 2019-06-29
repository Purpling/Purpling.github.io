<?php

#if ($_SERVER['HTTPS'] != "on") {
#    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
#    header("Location: $url");
#    exit;
#}

function encode($data){
    return $data;
}
function decode($data){
    return $data;
}
function hashit($data){echo $data."<br>";
    $alf="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 !\"£$%^&*()-_=+[{]};:'@#~,<.>/?\\|`¬]";
    $tmp=random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9);echo $tmp."<br>";
    $rst="";for($i=0;$i<strlen($data);$i++){$rst=$rst.strpos($alf,substr($data,$i,1))+1;}$data="";echo $rst."<br>";
    return $rst;
}#echo hashit("test");
function fuseit($data){$data=str_replace(".","",$data);
    $time=time();$rst="";$len=strlen($data)-strlen($time);
    for($i=0;$i<($len*-1);$i++){$data=$data."0";}
    for($i=0;$i<$len;$i++){$time=$time."0";}
    for($i=0;$i<strlen($data);$i++){$rst=$rst.substr($data,$i,1).substr($time,$i,1);}
    return $rst;
}

function split($data){$rst=array("","","");$cur=0;$skip=false;
    for($i=0;$i<strlen($data);$i++){
        if($skip){$skip=false;$rst[$cur]=$rst[$cur].substr($data,$i,1);}else{
            if(substr($data,$i,1)=="\\"){$skip=true;}else{
                if(substr($data,$i,1)=="|"){$cur=$cur+1;}else{
                    $rst[$cur]=$rst[$cur].substr($data,$i,1);
                }
            }
        }
    }return $rst;
}

function chkFile($name){$file=fopen($name,"x");fclose($file);}
function estFile($name){return file_exists($name);}
function remFile($name){unlink($name);}
function setFile($name,$info){$file=fopen($name,"w");fwrite($file,$info);fclose($file);}
function addFile($name,$info){$file=fopen($name,"a");fwrite($file,$info);fclose($file);}
function getFile($name){$file=fopen($name,"r");fread($file,filesize($name));fclose($file);}
function chkFold($name){mkdir($name);}
function estFold($name){return file_exists($name);}
function remFold($name){rmdir($name);}
function getLine($name){$file=fopen($name,"r");$rst=array();while(!feof($file)){$rst[count($rst)+1]=fgets($file);}fclose($file);return $rst;}
function redirect($url){ob_start();header('Location: '.$url);ob_end_flush();die();}

if($_COOKIE["skin"]==""){setcookie("skin","0",time()+3155760000,"/");}

# 754 profiles | 744 messages | 733 groups | 740 sessions
chkFold("754"); chkFold("744"); chkFold("733"); chkFold("740"); chkFile("733/0.dat");
if(!estFile("733/0.inf")){setFile("733/0.inf","Public/General\n");}
if(!estFile("754/0.dat")){setFile("754/0.dat","0\n");}

if($_POST["un"]!=""&&$_POST["pw"]!=""){
    if ($_GET["state"]=="0"){
        if(estFile("754/".$_POST["un"].".inf")&&!estFile("740/".$_POST["un"].".dat")){
            #if(1==1){
                setFile("740/".hashit($_SERVER['REMOTE_ADDR']).".dat",getLine("754/".$_POST["un"].".inf")[1]);
                setcookie("user",hashit($_SERVER['REMOTE_ADDR']),time()+604800,"/");
                redirect("http://ircfirst.x10host.com/?a=g&b=0");
            #}else{$error="Invalid credentials.";}
        }else{$error="Invalid credentials.";}
    }else{
        if(!estFile("754/".$_POST["un"].".inf")){$num=(getLine("754/0.dat")[1]+1)."\n";
            setFile("754/0.dat",$num);setFile("754/".$_POST["un"].".inf",$num);
            setFile("754/".$num.".dat",$_POST["un"]."\n".hashit($_POST["pw"])."\n");
            redirect("http://ircfirst.x10host.com");
        }else{$error="Credentials in use.";}
    }
} # Log them in.
if($_COOKIE["user"]!=""&&$_GET["z"]=="a"&&estFile("740/".hashit($_SERVER['REMOTE_ADDR']).".dat")){
    remFile("740/".hashit($_SERVER['REMOTE_ADDR']).".dat");
    setcookie("user","",time(),"/");
    redirect("http://ircfirst.x10host.com");
} # Log them out.

if($_COOKIE["user"]==""){
    echo "<body style='margin: 0px'><div id='init'>";
        if($_COOKIE["skin"]=="1"){echo "<div id='head' style='padding-top: 2%; height: 16%; width: 100%; overflow: auto; background-color: #aaa;'>";} # Dark theme.
        else{echo "<div id='head' style='padding-top: 2%; height: 16%; width: 100%; overflow: auto; background-color: #ccc;'>";} # Light theme.
            echo "<div style='text-align: center; font-size: 50;'>IRC First</div><div style='text-align: center; font-size: 40;'>Login Area</div><br>";
            echo "<div style='text-align: center; font-size: 25;'><span style='color: #bbf;'>Total: 0</span> | <span style='color: #9f9;'>Online: 0</span> | <span style='color: #fbf;'>Peak: 0</span> | <span style='color: #ff9;'>Today: 0</span></div>";
        echo "</div>";
        if($_COOKIE["skin"]=="1"){echo "<div id='body' style='text-align: center; padding-top: 3%; height: 67%; width: 100%; overflow: auto; background-color: #333; color: #fff;'>";} # Dark theme.
        else{echo "<div id='body' style='text-align: center; padding-top: 3%; height: 67%; width: 100%; overflow: auto; background-color: #fff;'>";} # Light theme.
            echo "<form action='http://ircfirst.x10host.com?state=0' method='post'>";
                echo "<h2>Username: </h2><input type='text' name='un' placeholder='Username' required><br>";
                echo "<h2>Password: </h2><input type='text' name='pw' placeholder='Password' required><br>";
                echo "<br><input type='submit' value='Login'> <input type='submit' value='Register' formaction='http://ircfirst.x10host.com?state=1'>";
                if($error){echo "<h2 style='color: #c00;'>".$error."</h2>";}
                echo "<br><br><br><div style='color: #c00; font-size: 35;'>Disclaimer:</div>";
                echo "<div style='color: #c00; font-size: 20;'>Don't use passwords that you use for other accounts.</div>";
                echo "<div style='color: #c00; font-size: 20;'>This site is not responsable for the content of its users.</div>";
            echo "</form>";
        echo "</div>";
        if($_COOKIE["skin"]=="1"){echo "<div id='foot' style='padding-top: 1.5%; height: 5.7%; width: 100%; overflow: auto; background-color: #777;'>";} # Dark theme.
        else{echo "<div id='foot' style='padding-top: 1.5%; height: 5.7%; width: 100%; overflow: auto; background-color: #999;'>";} # Light theme.
            echo "<div style='text-align: center; font-size: 20;'>Copyright &#169; Robert Brown 2019-".date("Y")."</div>";
        echo "</div>";
    echo "</div></body>";
} # Not logged in.
if($_COOKIE["user"]!=""){
    echo "<head><meta http-equiv='refresh' content='30'><style>a:link{color: #000;}a:visited{color: #000;}a:hover{color: #fff;}a:active{color: #fff;}</style></head>";
    echo "<body style='margin: 0px'><div id='init'>";
        if($_COOKIE["skin"]=="1"){echo "<div id='head' style='padding-top: 2%; height: 16%; width: 100%; overflow: auto; background-color: #aaa;'>";} # Dark theme.
        else{echo "<div id='head' style='padding-top: 2%; height: 16%; width: 100%; overflow: auto; background-color: #ccc;'>";} # Light theme.
            echo "<div style='text-align: center; font-size: 50;'>IRC First</div><div style='text-align: center; font-size: 40;'>User Area</div><br>";
            echo "<div style='text-align: center; font-size: 25;'><a href='http://ircfirst.x10host.com/?a=p'>Profile</a> | <a href='http://ircfirst.x10host.com/?a=m'>Messages</a> | <a href='http://ircfirst.x10host.com/?a=f'>Friends</a> | <a href='http://ircfirst.x10host.com/?a=g'>Groups</a></div>";
            echo "<form action='http://ircfirst.x10host.com/?z=a' method='post'>";
                echo "<input type='submit' value='Logout' style='position: absolute; top: 1%; right: 1%;'>";
            echo "</form>";
        echo "</div>";
        if($_COOKIE["skin"]=="1"){echo "<div id='body' style='text-align: center; padding-top: 1%; height: 67%; width: 100%; max-height: 69%; overflow: auto; background-color: #333; color: #eee;'>";} # Dark theme.
        else{echo "<div id='body' style='text-align: center; padding-top: 1%; height: 67%; width: 100%; max-height: 69%; overflow: auto; background-color: #fff;'>";} # Light theme.
            if($_GET["b"]!=""){if($_GET["a"]=="m"){$file="744/";}if($_GET["a"]=="g"){$file="733/";}
            $count=0;foreach(getLine($file.$_GET["b"].".dat") as $a){if($a!=""){$a=split($a);$count=$count+1;$time=split(str_replace(" ","|",$a[0]));#getLine("754/".$a[2].".dat")[1]
                echo "<div id='".$count."' style='margin-left: 12.5%; width: 75%; max-width: 75%; padding-top: 1%; padding-bottom: 1%; margin-bottom: 1%; background-color: #bbb;'><a href=''>".$a[2]."</a> <span style='color: #9f9;'>".$time[1]."</span> <span style='color: #99f;'>".$time[0]."</span><br>".decode($a[1])."</div>";
            }}}
        echo "</div>";
        if($_COOKIE["skin"]=="1"){echo "<div id='foot' style='padding-top: 2%; height: 8.3%; width: 100%; overflow: auto; background-color: #777;'>";} # Dark theme.
        else{echo "<div id='foot' style='padding-top: 2%; height: 8.3%; width: 100%; overflow: auto; background-color: #999;'>";} # Light theme.
            echo "<form action='http://ircfirst.x10host.com/?a=".$_GET["a"]."&b=".$_GET["b"]."' method='post' style='text-align: center;'>";
                if($_GET["b"]!=""){if($_GET["a"]=="m"||$_GET["a"]=="g"){echo "<input type='submit' value='Send'> <input type='text' size='40' name='msg' placeholder='Message' required>";}}
            echo "</form>";
            echo "<div style='text-align: center; font-size: 20;'>Copyright &#169; Robert Brown 2019-".date("Y")."</div>";
        echo "</div>";
    echo "</div></body>";
} # Logged in.
if($_POST["msg"]!=""){if($_GET["a"]=="m"){$file="744/";}if($_GET["a"]=="g"){$file="733/";}
    addFile($file.$_GET["b"].".dat",date("d/m/Y H:i",strtotime("+5 hours"))."|".str_replace("|","\\|",str_replace("\\","\\\\",encode($_POST["msg"])))."|".getLine("740/".$_COOKIE["user"].".dat")[1]."\n");
    redirect("http://ircfirst.x10host.com/?a=".$_GET["a"]."&b=".$_GET["b"]);
} # Save message.

?>