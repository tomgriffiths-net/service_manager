<?php
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
    }
    public static function start_service(string $serviceName):bool{
        mklog('general','Starting service ' . $serviceName,false);
        if(!is_admin::check()){
            mklog('warning','Failed to start service due to a permission error',false);
            return false;
        }

        exec("net start " . $serviceName . " >nul 2>&1",$output,$resultCode);
        if(self::resultCodeToBool($resultCode)){
            return true;
        }
        else{
            mklog('warning','Failed to start service ' . $serviceName . ': ' . $resultCode,false);
        }
        return false;
    }
    public static function stop_service(string $serviceName):bool{
        mklog('general','Stoping service ' . $serviceName,false);
        if(!is_admin::check()){
            mklog('warning','Failed to stop service due to a permission error',false);
            return false;
        }

        exec("net stop " . $serviceName . " >nul 2>&1",$output,$resultCode);
        if(self::resultCodeToBool($resultCode)){
            return true;
        }
        else{
            mklog('warning','Failed to stop service ' . $serviceName . ': ' . $resultCode,false);
        }
        return false;
    }
    public static function restart_service(string $serviceName):bool{
        if(self::stop_service($serviceName)){
            if(self::start_service($serviceName)){
                return true;
            }
        }
        return false;
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
        mklog('general','Deleting service ' . $serviceName,false);
        if(!is_admin::check()){
            mklog('warning','Failed to delete service due to a permission error',false);
            return false;
        }

        exec('sc delete ' . $serviceName,$output,$resultCode);
        if(self::resultCodeToBool($resultCode)){
            mklog('general','Deleted service ' . $serviceName,false);
            return true;
        }
        else{
            mklog('warning','Failed to delete service ' . $serviceName . ': ' . $resultCode,false);
        }
        return false;
    }
}