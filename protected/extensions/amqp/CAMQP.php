<?php

/**
 * AMQP extension wrapper to communicate with RabbitMQ server
 * For More documentation please see:
 * http://php.net/manual/en/book.amqp.php
 */

/**
 * @defgroup CAMQP
 * @ingroup AMQPModule
 * @version 1.0.1
 */

/**
 * @class CAMQP
 * @brief Use for comunicate with AMQP server
 * @details  Send and recieve messages. Implements Wrapper template.
 *
 * "A" - Team:
 * @author     Andrey Evsyukov <thaheless@gmail.com>
 * @author     Alexey Spiridonov <a.spiridonov@2gis.ru>
 * @author     Alexey Papulovskiy <a.papulovskiyv@2gis.ru>
 * @author     Alexander Biryukov <a.biryukov@2gis.ru>
 * @author     Alexander Radionov <alex.radionov@gmail.com>
 * @author     Andrey Trofimenko <a.trofimenko@2gis.ru>
 * @author     Artem Kudzev <a.kiudzev@2gis.ru>
 * @author     Alexey Ashurok <a.ashurok@2gis.ru>
 *   
 * @link       http://www.2gis.ru
 * @copyright  2GIS
 * @license http://www.yiiframework.com/license/
 *
 * Requirements:
 * --------------
 *  - Yii 1.1.x or above
 *  - Rabbit php library or AMQP PECL library
 *
 * Usage:
 * --------------
 *
 * To write a message into the MQ-Exchange:
 *
 *     Yii::App()->amqp->exchange('topic')->publish('some message','some.route');
 *
 *
 * To read a message from MQ-Queue:
 *
 *     Yii::App()->amqp->queue('some_listener')->get();
 *
 */
class CAMQP extends CApplicationComponent
{
	public $server = [
		'host' => 'localhost',
		'port' => '5672',
		'vhost' => '/',
		'login' => 'guest',
		'password' => 'guest',
	];
	/**
	 * 是否持久化
	 * @var boolean
	 */
	public $durable= true;
	/**
	 * 是否自动删除
	 * 
	 * @var boolean
	 */
	public $autodelete = true;
	/**
	 * 
	 * @var AMQPConnection
	 */
    protected $conn = null;
    /**
     * 
     * @var AMQPChannel
     */
    protected $channel = null;
	
	/**
	 * @brief Initialize component.
	 * @details in case fakeMode is enabled loading fake Queue and Exchange classes
	 */
	public function init() {
		$this->createConnection();
		parent::init ();
	}
	public function createConnection() {
		try {
			if (! is_array ( $this->server ))
				throw new CHttpException ( 200, '消息队列配置参数错误', 500 );
			$this->conn = new AMQPConnection ( $this->server );
			
			if (method_exists ( $this->conn, 'connect' ) && $this->conn->isConnected () == false) {
				if (! $this->conn->connect ()) {
					throw new CHttpException ( 200, '连接队列失败', 500 );
				}
			}
			$this->channel = new AMQPChannel ( $this->conn );
		} catch ( AMQPConnectionException $e ) {
			throw new CHttpException ( 200, '创建队列失败', 500 );
		}
	}
    /**
     * @brief
     * @details Returns an instance of AMQPExchange for exchange a queue is bind
     * @param $exchange
     * @param $queue
     * @param $routingKey
     */
    public function bindExchangeToQueue($exchange, $queue, $routingKey = "")
    {
       	$ex = $this->exchange($exchange); 	//创建交换
        $qe = $this->queue($queue); 		//创建队列
        $qe->bind($exchange, $routingKey);
        return $ex;
    }
    /**
     * @brief Binds a queue to specified exchange
     * @details Returns an instance of AMQPQueue for queue an exchange is bind
     * @param $queue
     * @param $exchange
     * @param $routingKey
     */
    public function bindQueueToExchange($queue, $exchange, $routingKey = "")
    {
        $ex = $this->exchange($exchange); 	//创建交换
        $qe = $this->queue($queue); 		//创建队列
        $qe->bind($exchange, $routingKey);
        return $qe;
    }
	/**
	 * @brief Get exchange by name
	 * 
	 * @param $name name
	 *        	of exchange
	 * @return object AMQPExchange
	 */
	public function exchange($name) {
		$ex = new AMQPExchange ( $this->channel );
		$ex->setName ( $name );
		$ex->setType ( AMQP_EX_TYPE_DIRECT );
		if ($this->durable)
			$ex->setFlags ( AMQP_DURABLE );
		$ex->declareExchange ();
		return $ex;
	}

    /**
     * @brief Get queue by name
     * @param $name  name of exchange
     * @return  object AMQPQueue
     */
    public function queue($name) {
		$queue = new AMQPQueue ( $this->channel );
		$queue->setName ( $name );
		if ($this->durable)
			$queue->setFlags ( AMQP_DURABLE ); 	// 持久化
		if ($this->autodelete)
			$queue->setFlags ( AMQP_AUTODELETE ); // auto-delete
		$queue->declareQueue ();
		return $queue;
	}

    /**
     * Returns AMQPConnection instance
     *
     * @return AMQPConnection
     */
    public function getClient()
    {
        return $this->client;
    }
    /**
     * 
     */
    public function __destruct(){
    	if ($this->conn){
    		$this->conn->disconnect();
    	}
    }
} 