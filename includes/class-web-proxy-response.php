<?
class REST_Web_Proxy_Response
{
  /**
   * Get one item from the collection
   * 
   * @param mixed $data Full data about the request.
   * @param string $msg Full data about the request.
   * @return REST_Response standard rest data
   */
  function __construct($data, $msg)
  {
    $this->data = $data;
    $this->message = $msg;
  }
}
