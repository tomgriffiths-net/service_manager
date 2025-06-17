# service_manager
service_manager is a PHP-CLI package that provides functionality for managing windows services.

# Commands
- **start service_name**: Starts a service.
- **stop service_name**: Stops a service.
- **restart service_name**: Restarts a service.

# Functions
- **start_service(string $serviceName):bool**: Starts a service. Returns true on success or false on failure.
- **stop_service(string $serviceName):bool**: Stops a service. Returns true on success or false on failure.
- **restart_service(string $serviceName):bool**: Restarts a service. Returns true on success or false on failure.
- **selete_service(string $serviceName):bool**: Deletes a service. Returns true on success or false on failure.