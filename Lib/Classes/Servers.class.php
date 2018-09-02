<?PHP

class Server
{
	var $host;
	var $software;
	var $php;
	var $kernel;
	var $os;
	var $ip;

	var $top_load;
	var $top_users;
	var $top_tasks;
	var $top_cpu;
	var $top_cpu_pct;
	var $top_mem;
	var $top_mem_pct;
	var $top_swap;
	var $top_swap_pct;
	var $uptime;
	var $partitions;
	var $temperatures;
	var $disks_temperatures;
	var $services;
	var $processes;
	var $netstat;

	var $alarm_thresholds;
	var $warning_thresholds;

	var $alarms;
	var $warnings;

	public function __construct()
	{
		self::set_thresholds();
		self::refresh_all();
	}

	public function set_thresholds()
	{
		$this->alarm_thresholds = array();
		$this->warning_thresholds = array();

		$this->alarm_thresholds['cpu'] = 80;
		$this->warning_thresholds['cpu'] = 50;
		$this->alarm_thresholds['mem'] = 80;
		$this->warning_thresholds['mem'] = 50;
		$this->alarm_thresholds['swap'] = 80;
		$this->warning_thresholds['swap'] = 50;
		$this->alarm_thresholds['storage'] = 90;
		$this->warning_thresholds['storage'] = 80;
		$this->alarm_thresholds['temp'] = 65;
		$this->warning_thresholds['temp'] = 45;
		$this->alarm_thresholds['hddtemp'] = 50;
		$this->warning_thresholds['hddtemp'] = 40;		
	}

	public function refresh_all()
	{
		$this->alarms = array();
		$this->warnings = array();
		self::set_thresholds();
		self::refresh_sysinfo();
		self::refresh_load();
		self::refresh_services();
		self::refresh_processes();
		self::refresh_netstat();
	}

	public function refresh_sysinfo()
	{
		$this->host = gethostname();
		$this->software = $_SERVER['SERVER_SOFTWARE'];
		$this->php = phpversion();
		$this->kernel = php_uname("r");
		$this->os = PHP_OS;
		$this->ip = $_SERVER['SERVER_ADDR'];
	}

	public function refresh_load()
	{
		$this->alarms['dashboard'] = 0;
		$this->warnings['dashboard'] = 0;

		$top = explode("\n", shell_exec('top -bn1 | head -n 5'));

		$found = preg_match("/\s+load average:\s+(\d+\.\d+),\s+(\d+\.\d+),\s+(\d+\.\d+)/", $top[0], $top_load_matches);
		if ($found == 1) {
			array_shift($top_load_matches);
			$this->top_load = $top_load_matches;
		}

		$found = preg_match("/\s+(\d+)\s+users?,/", $top[0], $top_users_matches);
		if ($found == 1) {
			array_shift($top_users_matches);
			$this->top_users = $top_users_matches[0];
		}

		$found = preg_match("/^Tasks:\s+(\d+) total,\s+(\d+) running,\s+(\d+) sleeping,\s+(\d+) stopped,\s+(\d+) zombie/", $top[1], $top_tasks_matches);
		if ($found == 1) {
			array_shift($top_tasks_matches);
			$this->top_tasks = $top_tasks_matches;
		}

		$found = preg_match("/^%Cpu\(s\):\s+(\d+\.\d+) us,\s+(\d+\.\d+) sy,\s+(\d+\.\d+) ni,\s+(\d+\.\d+) id,\s+(\d+\.\d+) wa,\s+(\d+\.\d+) hi,\s+(\d+\.\d+) si,\s+(\d+\.\d+) st/", $top[2], $top_cpu_matches);
		if ($found == 1) {
			array_shift($top_cpu_matches);
			$this->top_cpu = $top_cpu_matches;
		}

		$found = preg_match("/^KiB Mem :\s+(\d+) total,\s+(\d+) free,\s+(\d+) used,\s+(\d+) buff\/cache/", $top[3], $top_mem_matches);
		if ($found == 1) {
			array_shift($top_mem_matches);
			$this->top_mem = $top_mem_matches;
		}

		$found = preg_match("/^KiB Swap:\s+(\d+) total,\s+(\d+) free,\s+(\d+) used\.\s+(\d+) avail Mem/", $top[4], $top_swap_matches);
		if ($found == 1) {
			array_shift($top_swap_matches);
			$this->top_swap = $top_swap_matches;
		}

		$this->top_cpu_pct = sprintf('%.0f',(array_sum($this->top_cpu) - $this->top_cpu[3]));

		if ($this->top_mem[0] == 0) { $this->top_mem_pct = 0; } else {
			$this->top_mem_pct = sprintf('%.0f',($this->top_mem[2] / $this->top_mem[0]) * 100);
		}

		if ($this->top_swap[0] == 0) { $this->top_swap_pct = 0; } else {
			$this->top_swap_pct = sprintf('%.0f',($this->top_swap[2] / $this->top_swap[0]) * 100);
		}

		if ($this->top_cpu_pct > $this->alarm_thresholds['cpu']) { $this->alarms['dashboard']++; } elseif ($this->top_cpu_pct > $this->warning_thresholds['cpu']) { $this->warnings['dashboard']++; }
		if ($this->top_mem_pct > $this->alarm_thresholds['mem']) { $this->alarms['dashboard']++; } elseif ($this->top_mem_pct > $this->warning_thresholds['mem']) { $this->warnings['dashboard']++; }
		if ($this->top_swap_pct > $this->alarm_thresholds['swap']) { $this->alarms['dashboard']++; } elseif ($this->top_swap_pct > $this->warning_thresholds['swap']) { $this->warnings['dashboard']++; }

		$uptime = strtok( exec( "cat /proc/uptime" ), "." );
		$this->uptime[0] = sprintf( "%2d", ($uptime/(3600*24)) );
		$this->uptime[1] = sprintf( "%2d", ( ($uptime % (3600*24)) / 3600) );
		$this->uptime[2] = sprintf( "%2d", ($uptime % (3600*24) % 3600)/60 );
		$this->uptime[3] = sprintf( "%2d", ($uptime % (3600*24) % 3600)%60 );

		$this->partitions = array();
		$partitions_fstab = explode("\n", shell_exec("cat /etc/fstab | grep -E '\s(ext(3|4)|btrfs)\s' | grep -v 'noauto' | awk '{print $2}'"));
		array_pop($partitions_fstab);
		foreach ($partitions_fstab as $partition_fstab) {
			$df = shell_exec("df ".$partition_fstab." | tail -n +2");
			$found = preg_match("/^([\/\w\d]+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)%\s([\/\w\d]+)/", $df, $df_matches);
			if ($found == 1) {
				array_shift($df_matches);
				if ($df_matches[4] > $this->alarm_thresholds['storage']) { $this->alarms['dashboard']++; } elseif ($df_matches[4] > $this->warning_thresholds['storage']) { $this->warnings['dashboard']++; }
				array_push($this->partitions, $df_matches);
			}
		}

		$this->temperatures = array();
		if (is_executable("/usr/bin/sensors")) {
			$sensors = explode("\n", shell_exec("sensors -A | grep 'Temp:'"));
			array_pop($sensors);
			foreach ($sensors as $sensor) {
				$found = preg_match("/^([\w\d ]+):\s+.(\d+\.\d+).\w\s+/", $sensor, $sensor_matches);
				if ($found == 1) {
					array_shift($sensor_matches);
					if ($sensor_matches[1] > $this->alarm_thresholds['temp']) { $this->alarms['dashboard']++; } elseif ($sensor_matches[1] > $this->warning_thresholds['temp']) { $this->warnings['dashboard']++; }
					array_push($this->temperatures, $sensor_matches);
				}
			}
		}

		$disks = array();
		$lsblk = explode("\n", shell_exec("lsblk -n --raw"));
		array_pop($lsblk);
		foreach ($lsblk as $blk) {
			array_push($disks, substr($blk, 0, 3));
		}
		$disks = array_unique($disks);

		$this->disks_temperatures = array();
		if (is_executable("/usr/bin/hddtemp")) {
			foreach ($disks as $disk) {
				$hddtemp = shell_exec("hddtemp -n /dev/".$disk);
				if ($hddtemp > $this->alarm_thresholds['hddtemp']) { $this->alarms['dashboard']++; } elseif ($hddtemp > $this->warning_thresholds['hddtemp']) { $this->warnings['dashboard']++; }
				$this->disks_temperatures[$disk] = $hddtemp;
			}
		}
	}

	public function refresh_services() {
		$this->alarms['services'] = 0;
		$this->warnings['services'] = 0;

		$this->services = array();
		$systemctl = explode("\n", shell_exec("systemctl list-units --type service --no-legend | grep -Ev '(^systemd-|@)'"));
		array_pop($systemctl);
		foreach ($systemctl as $service) {
			$found = preg_match("/^([\w\-\d]+)\.service\s+(\w+)\s+(\w+)\s+(\w+)\s+\w+/", $service, $service_matches);
			if ($found == 1) {
				array_shift($service_matches);
				if (($service_matches[1] != 'loaded' ) || ($service_matches[2] != 'active') || ($service_matches[3] == 'failed')) { $this->alarms['services']++; }
				array_push($this->services, $service_matches);
			}
		}
	}

	public function refresh_processes() {
		$this->alarms['processes'] = 0;
		$this->warnings['processes'] = 0;

		$this->processes = array();
		$ps = explode("\n", shell_exec("ps -e --no-headers --format 'uid uname pid ppid tty %cpu %mem cmd'"));
		array_pop($ps);
		foreach ($ps as $process) {
			$found = preg_match("/^\s+(\d+)\s+(.+)\s+(\d+)\s+(\d+)\s+(.+)\s+(\d+\.\d+)\s+(\d+\.\d+)\s+(.+)/", $process, $process_matches);
			if ($found == 1) {
				array_shift($process_matches);
				array_push($this->processes, $process_matches);
			}
		}
	}

	public function refresh_netstat() {
		$this->alarms['netstat'] = 0;
		$this->warnings['netstat'] = 0;

		$this->netstat = array();
		$netstat = explode("\n", shell_exec("netstat -lnut | tail -n +3"));
		array_pop($netstat);
		foreach ($netstat as $net) {
			$found = preg_match("/^([\w\d]+)\s+\d+\s+\d+\s+(\d+\.\d+\.\d+\.\d+):(\d+)\s+/", $net, $netstat_matches);
			if ($found == 1) {
				array_shift($netstat_matches);
				array_push($this->netstat, $netstat_matches);
			}
		}
	}
}

?>