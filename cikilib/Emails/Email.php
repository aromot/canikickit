<?php

namespace CikiLib\Emails;

use Swift_Message;

class Email
{
  /**
	 * @var string
	 */
  protected $charset = 'utf-8';
  
  /**
	 * @var Swift_Message
	 */
  private $message;

  /**
   * @var EmailTemplate
   */
  private $template;

  /**
   * @var string
   */
  private $subject;

  /**
   * @var array|string
   */
  private $to;
  
  function __construct(?EmailTemplate $template = null, string $subject = '', $to = '')
  {
    if( ! empty($template))
      $this->template = $template;

    if( ! empty($subject))
      $this->subject = $subject;

    if( ! empty($to))
      $this->to = $to;
  }

  public function setTemplate(EmailTemplate $template)
  {
    $this->template = $template;
  }

  public function setSubject(string $subject)
  {
    $this->subject = $subject;
  }

  public function setTo($to)
  {
    $this->to = $to;
  }

  public function send()
  {
    if(isDev())
      return $this->dump();
  }

  public function dump()
  {
    $this->makeMessage();
  }

  private function makeMessage()
  {
    if(empty($this->message)) {

      $noReplyAddr = config('emails.noReplyEmail');
			$noReply = [$noReplyAddr => config('emails.noReplyName')];

      $this->message = new Swift_Message();
      $this->message
        ->setCharset($this->charset)
				->setFrom($noReply)
				->setSender($noReply)
				->setReturnPath($noReplyAddr)
				->setReplyTo($noReply);
    }
  }
}