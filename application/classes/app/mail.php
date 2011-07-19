<?php
/**
 * This is the application class for sending emails.
 */
class App_Mail
{
	
	/**
	 * Sends an email.
	 * @param string $to
	 * @param string $subject
	 * @param mixed $message
	 * @param array $headers
	 * @return bool
	 */
	public static function send($to, $subject, $message, $headers=array())
	{
		// always prefix subject with site address
		$subject = "[".URL::base(false, true)."] {$subject}";
		
		$body = '';
		if (is_array($message))
		{
			foreach ($message as $key => $val)
			{
				$body .= "{$key}: {$val}\n";
			}
		}
		else
		{
			$body = $message;
		}
		
		// check for HTML
		if ($body != strip_tags($body))
		{
			$headers['Content-Type'] = 'text/html; charset=ISO-8859-1';
			$headers['MIME-Version'] = '1.0';
		}
		return mail($to, $subject, $body, self::headers($headers));
	}
	
	
	/**
	 * Converts headers array to a string.
	 * @param array $headers_array
	 * @return string
	 */
	private static function headers($headers_array)
	{
		// set From: header if not already set
		if (empty($headers_array['From']))
		{
			$headers_array['From'] = Kohana::config('app.email_from');
		}
		$headers = '';
		foreach ($headers_array as $key => $val)
		{
			$headers .= "{$key}: {$val}\r\n";
		}
		// strip off last \r\n
		$headers = substr($headers, 0, -2);
		return $headers;
	}
}