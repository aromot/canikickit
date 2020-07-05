<?php

namespace CikiLib\Apps;

use DateTime;
use InvalidArgumentException;

class FrontendApp
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var array
	 */
  private $manifestData;
  

	function __construct(string $name)
	{
		if (empty($name))
			throw new InvalidArgumentException("The name of the FrontendApp is empty.");

		$this->name = $name;
		$this->config = config('frontendApps.' . $name);
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function readManifest(): array
	{
		if (empty($this->manifestData)) {

      // $path = $this->nameToManifestPath($this->name);
			$path = $this->getManifestPath();

			if (!file_exists($path))
				throw new FrontendAppException("File $path DOES NOT EXIST.");

			$contents = file_get_contents($path);
			$this->manifestData = json_decode($contents, true);
		}

		return $this->manifestData;
	}

	public function getManifestPath(): string
	{
		return $this->config['build']['manifest'];
	}

	public function getBuildPath(): string
	{
		return $this->config['build']['path'];
	}

	private function checkDevServer(string $host, int $port, string $filePath): bool
	{
		$timeout = 0;
		$fp = @fsockopen($host, $port, $errNom, $errMsg, $timeout);

		if ($fp === false)
			return false;

		$filePath = '/' . ltrim($filePath, '/');

		$out = "GET $filePath HTTP/1.1\r\n";
		$out .= "Host: localhost\r\n";
		$out .= "Connection: Close\r\n\r\n";

		fwrite($fp, $out);

		while (!feof($fp)) {
			$line = trim(fgets($fp, 1000));

			if (preg_match('/^http\/[\d+\.]+\s+(\d+)\s+ok\b/i', $line, $matches)) {
				if (200 === (int) $matches[1]) {
					fclose($fp);
					return true;
				}
			}

			if (empty($line))
				break;
		}

		fclose($fp);
		return false;
	}

	public function isDevServerRunning(): bool
	{
		$cfgDev = $this->config['dev'];
		$scripts = (array) $cfgDev['scripts'];
		// check the last script of the scripts because it is probably the entrypoint as the scripts are ordered.
		return $this->checkDevServer($cfgDev['host'], $cfgDev['port'], $scripts[count($scripts)-1]);
	}

	private function makeDevHost(): string
	{
		$devCfg = $this->config['dev'];
		$devHost = 'http://' . $devCfg['host'];

		if( ! empty($devCfg['port']))
			$devHost .= ':' . $devCfg['port'];

		return $devHost;
	}

	public function getDevScripts(): array
	{
		$devHost = $this->makeDevHost();

		return array_map(function($script) use ($devHost) {
			return $devHost . '/' . ltrim($script, '/');
		}, $this->config['dev']['scripts']);
	}

	public function getBuildScripts(): array
	{
		$this->readManifest();

		return array_map(function($script) {
			return $this->manifestData[$script];
		}, $this->config['build']['scripts']);
	}

	public function getInitRoute(): string
	{
		return isset($this->config['initRoute']) ? route($this->config['initRoute']) : '';
	}

	public function getBuildDatetime(): DateTime
	{
		$manifestFile = $this->getManifestPath();
		
		if( ! file_exists($manifestFile))
			throw new FrontendAppException("The manifest file $manifestFile doesn't exist.");
			
		$dt = new DateTime();
		$dt->setTimestamp(filemtime($manifestFile));
		return $dt;
	}

	public function getDevPath(): string
	{
		if( ! isset($this->config['dev']['path']))
			throw new FrontendAppException("The path is not defined in the configuration.");
			
		return $this->config['dev']['path'];
	}

	/**
	 * Run the build npm script of the app. Can be defined in the config build.cmd or "npm run build" by default
	 *
	 * @return string The npm script output.
	 */
	public function runBuild(): string
	{
		$cwd = getcwd();

		$basePath = $this->getDevPath();
		chdir($basePath);
		
		ob_start();
		if(isset($this->config['build']['cmd']))
			system($this->config['build']['cmd']);
		else
			system('npm run build');
		$output = ob_get_clean();

		chdir($cwd);

		return $output;
  }
  
  public function getSmartScripts(): array
  {
    return $this->isDevServerRunning() ? $this->getDevScripts() : $this->getBuildScripts();
  }

  public function getInitScript(array $payload = []): string
  {
    $inputs = $payload + [
      'initRoute' => $this->getInitRoute()
    ];

    return "<script>var CIKI_inputs = ".json_encode($inputs, JSON_PRETTY_PRINT)."</script>";
  }
}
