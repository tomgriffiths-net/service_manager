<?php
//Your Variables go here: $GLOBALS['service_manager']['YourVariableName'] = YourVariableValue
class service_manager{
    public static function command($line):void{
        $lines = explode(" ", $line);
        if($lines[0] === "start"){
            if(isset($lines[1])){
                self::start_service($lines[1]);
            }
        }
        elseif($lines[0] === "stop"){
            if(isset($lines[1])){
                self::stop_service($lines[1]);
            }
        }
        elseif($lines[0] === "restart"){
            if(isset($lines[1])){
                self::restart_service($lines[1]);
            }
        }
        else{
            echo "Unknown action\n";
        }
    }//Run when base command is class name, $line is anything after base command (string). e.g. > [base command] [$line]
    //public static function init():void{}//Run at startup
    public static function start_service(string $serviceName):bool{
        exec("net start " . $serviceName . " >nul 2>&1",$output,$resultCode);
        $result = self::resultCodeToBool($resultCode);
        if($result){
            mklog('general','Started service ' . $serviceName,false);
        }
        else{
            mklog('warning','Failed to start service ' . $serviceName,false);
        }
        return $result;
    }
    public static function stop_service(string $serviceName):bool{
        exec("net stop " . $serviceName . " >nul 2>&1",$output,$resultCode);
        $result = self::resultCodeToBool($resultCode);
        if($result){
            mklog('general','Stopped service ' . $serviceName,false);
        }
        else{
            mklog('warning','Failed to stop service ' . $serviceName,false);
        }
        return $result;
    }
    public static function restart_service(string $serviceName):bool{
        self::stop_service($serviceName);
        return self::start_service($serviceName);
    }
    private static function resultCodeToBool(int $resultCode):bool{
        if($resultCode === 0){
            return true;
        }
        else{
            return false;
        }
    }
    public static function delete_service(string $serviceName):bool{
        exec('sc delete ' . $serviceName,$output,$resultCode);
        $result = self::resultCodeToBool($resultCode);
        if($result){
            mklog('general','Deleted service ' . $serviceName,false);
        }
        else{
            mklog('warning','Failed to delete service ' . $serviceName,false);
        }
        return $result;
    }
}