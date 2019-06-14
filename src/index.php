<?php

class HTTPException extends Exception
{
  public $status = 200;
  function __construct($status, $message) {
    $this->status = $status;
    $this->message = $message;
  }
}

$required = ['to','subject','message'];

try
{
  foreach ($required as $post) {
    if ( ! isset($_POST[$post]))
      throw new HTTPException(400, "$post required");
    $$post = $_POST[$post];
  }

  $filterVarOpts = [
    'options' => [
      'default' => false
    ]
  ];
  
  if ( ! filter_var($to, FILTER_VALIDATE_EMAIL, $filterVarOpts))
    throw new HTTPException(422, 'invalid to address');

  mail($to, $subject, $message);
}
catch (HTTPException $e)
{
  http_response_code($e->status);
  error_log($e->getMessage());
}
catch (Exception $e)
{
  error_log($e->getMessage());
}
