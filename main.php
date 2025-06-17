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
        mklog(1,'Starting service ' . $serviceName);
        if(!is_admin::check()){
            mklog(2,'Failed to start service due to a permission error');
            return false;
        }

        exec("net start " . $serviceName . " >nul 2>&1", $output, $exitCode);
        if($exitCode === 0){
            return true;
        }
        else{
            mklog(2,'Failed to start service ' . $serviceName . ': ' . $exitCode);
        }
        return false;
    }
    public static function stop_service(string $serviceName):bool{
        mklog(1,'Stoping service ' . $serviceName);
        if(!is_admin::check()){
            mklog(2,'Failed to stop service due to a permission error');
            return false;
        }

        exec("net stop " . $serviceName . " >nul 2>&1", $output, $exitCode);
        if($exitCode === 0){
            return true;
        }
        else{
            mklog(2,'Failed to stop service ' . $serviceName . ': ' . $exitCode);
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
    public static function delete_service(string $serviceName):bool{
        mklog(1,'Deleting service ' . $serviceName);
        if(!is_admin::check()){
            mklog(2,'Failed to delete service due to a permission error');
            return false;
        }

        exec('sc delete ' . $serviceName, $output, $exitCode);
        if($exitCode === 0){
            mklog(1,'Deleted service ' . $serviceName);
            return true;
        }
        else{
            mklog(2,'Failed to delete service ' . $serviceName . ': ' . $exitCode);
        }
        return false;
    }
}