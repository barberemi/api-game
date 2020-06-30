<?php
namespace App\Websocket;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;


class MessageManager implements MessageComponentInterface
{

    /**
     * @var \SplObjectStorage
     */
    protected $connections;

    /**
     * MessageManager constructor.
     */
    public function __construct()
    {
        $this->connections = new \SplObjectStorage();
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->connections->attach($conn);
    }

    /**
     * @param ConnectionInterface $from
     * @param string              $msg
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        foreach($this->connections as $connection)
        {
            if($connection === $from)
            {
                continue;
            }
            $connection->send($msg);
        }
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->connections->detach($conn);
    }

    /**
     * @param ConnectionInterface $conn
     * @param Exception           $e
     */
    public function onError(ConnectionInterface $conn, Exception $e)
    {
        $this->connections->detach($conn);
        $conn->close();
    }
}
