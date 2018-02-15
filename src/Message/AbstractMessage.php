<?php
namespace Serato\UserProfileSdk\Message;

use Serato\UserProfileSdk\Queue\AbstractMessageQueue;

/**
 * Base class from which all concrete message implementations much inherit.
 *
 * Each concrete implementation represents a user action or event that is
 * captured with specific attributes and placed into a queue for downstream
 * processing by the Serato User Profile application.
 *
 * Child classes need only implement `get` and `set` methods to populate the
 * `AbstractMessage::params` property.
 */
class AbstractMessage
{
    /* @var array */
    private $params = [];

    /* @var int */
    private $userId;

    /**
     * Constructs the instance
     *
     * @param int   $userId    User ID
     * @param array $body      Array of message parameters
     */
    public function __construct($userId, array $params = [])
    {
        $this->userId = $userId;
        $this->params = $params;
    }

    /**
     * Send the message to message queue
     *
     * @param AbstractMessageQueue  $queue  A concrete abstract queue instance
     * @return mixed  A unique message identifier
     */
    public function send(AbstractMessageQueue $queue)
    {
        return $queue->sendMessage($this);
    }

    /**
     * Send the message for delivery as part of batch send operation
     *
     * @param AbstractMessageQueue  $queue  A concrete abstract queue instance
     * @return void
     */
    public function sendToBatch(AbstractMessageQueue $queue)
    {
        $queue->sendMessageToBatch($this);
    }

    /**
     * Creates a new message instance
     *
     * @param int   $userId    User ID
     * @param array $body      Array of message parameters
     * @return self
     */
    public static function create($userId, array $params = [])
    {
        return new static($userId, $params);
    }

    /**
     * Returns the message params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Returns the user ID
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Returns the type of message
     *
     * @return string
     */
    public function getType()
    {
        $className = get_class($this);
        return substr($className, strrpos($className, '\\') + 1);
    }

    /**
     * Set a parameter value
     *
     * @param string    $name   Parameter name
     * @param mixed     $value  Parameter value
     * @return self
     */
    protected function setParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * Get a parameter value
     *
     * @param string    $name   Parameter name
     * @return null | mixed
     */
    protected function getParam($name)
    {
        return isset($this->params[$name]) ? $this->params[$name] : null;
    }
}
