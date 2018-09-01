# M0N1T0R
PHP Linux System Monitor based on [AdminLTE](https://github.com/almasaeed2010/AdminLTE)

![Screenshot](Screenshot.jpg)

This script gives a glance on:
- Load
- Connected Users
- Storage
- Temperature Sensors (if hddtemp or sensors are installed)
- Services
- Processes
- Netstat

Alarms and Warnings are displayed according to specific thresholds.

### Installation
Just clone the repository on apache/php server in the web directory.

The Default login/password is _admin_ / _admin_
To Change it, modify the `security.php` file and change :
- `$cred_login`
- `$cred_pass` (The password is hashed, and can be generate with: `password_hash("password", PASSWORD_DEFAULT)`

### License
The project is based on AdminLTE.

AdminLTE is an open source project by [AdminLTE.IO](https://adminlte.io) that is licensed under [MIT](http://opensource.org/licenses/MIT). AdminLTE.IO
