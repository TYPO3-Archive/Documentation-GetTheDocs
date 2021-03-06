<?php
/**
 * Server class to dispatch the job
 */
class Server {

	/**
	 * Dispatch the job
	 *
	 * @param array $parameters Get / Post parameters
	 * @param array $files uploaded files
	 * @return void
	 */
	public function dispatch($parameters, $files) {

		// Add possible debug flag
		if (isset($parameters['debug']) && $parameters['debug'] == 1) {
			Command::$dryRun = TRUE;
		}

		// Call the right handler
		switch ($parameters['action']) {
			case 'render':
				$agent = new ServerRender($parameters, $files);
				break;
			case 'config':
				$agent = new ServerConfig($parameters);
				break;
			case 'convert':
				$agent = new ServerConvert($parameters, $files);
				break;
			default:
				$message = "I don't know action: '{$parameters['action']}' API problem?";
				print $message;
				die();
		}

		try {
			$agent->process();
		}
		catch(Exception $e) {
			print $e->getMessage();
		}

	}
}

?>