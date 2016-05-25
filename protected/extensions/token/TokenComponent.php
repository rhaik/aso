<?php
/**
 * @author zhanghaisong
 *
 * 给特定动作设置验证令牌，比如注册激活等。
 */
class TokenComponent extends CApplicationComponent {
	/**
	 *
	 * @var string 用于加密令牌的密钥，使用时后请自己制定
	 */
	public $secretKey = 'change it!';
	/**
	 * token过期时间
	 *
	 * @var integer
	 */
	public $expire = 3600;
	/**
	 * 
	 * @var string
	 */
	public $token;
	/**
	 * 创建一个令牌
	 *
	 * @param string $action
	 *        	令牌类型名
	 * @param mixed $params
	 *        	参数
	 * @param int $duration
	 *        	令牌有效期
	 * @param int $data
	 *        	令牌附加数据
	 * @return boolean
	 */
	public function create($action, $params, $duration = 0) {
		$identityKey = $this->createIdentityKey ( $action, $params );
		$token = $this->createTokenKey ( $identityKey );
		$expireTime = $duration > 0 ? $duration : $this->expire;
		if ($this->save ( $action, $identityKey, $token, $expireTime, $params )) {
			Yii::app ()->getCache ()->set ( 'USER_' . $token, $params, $expireTime );
			$this->token = $token;
			return $token;
		}
		return false;
	}
	/**
	 * 获取TOKEN
	 * 
	 * @return string
	 */
	public function getToken() {
		return $this->token;
	}
	/**
	 * 验证一个令牌是否有效
	 *
	 * @param string $token
	 *        	令牌字符串
	 * @param string $action
	 *        	令牌类型名
	 * @param boolean $delete
	 *        	是否验证之后删除
	 * @return boolean
	 */
	public function validateToken($token, $action = 'user.Login', $delete = false) {
		if (empty ( $token )) {
			return false;
		}
		$tokenData = Yii::app ()->getCache ()->get ( 'USER_' . $token );
		
		if (empty ( $tokenData )) {
			$record = $this->find ( $action, $token );
			if (! $record instanceof TokenModel || $record->token != $token || ($record->expire_time > 0 && $record->expire_time < time ()))
				return false;
			
			Yii::app ()->getCache ()->set ( 'USER_' . $token, $record->data, (time () - $record->expire_time) );
		}
		
		if ($delete) {
			Yii::app ()->getCache ()->delete ( 'USER_' . $token );
			$this->deleteByTokenKey ( $action, $token );
		}
		$this->token = $token;
		return true;
	}
	
	/**
	 * 产生标示符，可以不依赖其他环境产生一个可以定位该令牌的字符串。同样时间，同样类型，同样参数生成同样的标示符。
	 *
	 * @param string $action
	 *        	令牌类型名
	 * @param mixed $params
	 *        	参数
	 * @return string
	 */
	protected function createIdentityKey($action, $params) {
		return md5 ( $action . serialize ( $params ) );
	}
	
	/**
	 * 生成一个令牌
	 *
	 * @param string $identityKey
	 *        	标示符
	 * @return string
	 */
	protected function createTokenKey($identityKey) {
		return md5 ( $identityKey . $this->secretKey . time () );
	}
	/**
	 * 获取token有效期
	 */
	public function getExpire() {
		$this->expire;
	}
	
	/**
	 * 保存令牌
	 *
	 * @param string $action
	 *        	令牌类型名
	 * @param string $identityKey
	 *        	标示符
	 * @param string $tokenKey
	 *        	令牌
	 * @param int $expireTime
	 *        	到期日期
	 * @param string $data
	 *        	存储到令牌里面的数据
	 * @return boolean
	 */
	protected function save($action, $identityKey, $tokenKey, $expireTime, $data = null) {
		$tokenModel = TokenModel::model ()->find ( 'identity = :identity AND action = :action', array (
				':action' => $action,
				':identity' => $identityKey 
		) );
		
		if (empty ( $tokenModel )) {
			$token = new TokenModel ();
			$token->action = $action;
			$token->identity = $identityKey;
			$token->token = $tokenKey;
			$token->expire_time = $expireTime;
			$token->user_id = $data ['user_id'];
			$token->data = $data;
			return $token->save ();
		} else {
			Yii::app ()->cache->delete ( 'USER_' . $tokenModel->token );
			$tokenModel->token = $tokenKey;
			$tokenModel->expire_time = $expireTime;
			$tokenModel->data = $data;
			return $tokenModel->update ();
		}
	}
	
	/**
	 * 从数据库中取出令牌的model
	 *
	 * @param string $action
	 *        	令牌类型名
	 * @param string $token
	 *        	令牌字符串
	 * @return TokenRecord
	 */
	protected function find($action, $token) {
		return TokenModel::model ()->find ( 'token = :token AND action = :action', array (
				':action' => $action,
				':token' => $token 
		) );
	}
	
	/**
	 * delele by token key
	 *
	 * @param string $action        	
	 * @param string $tokenKey        	
	 * @return boolean
	 */
	protected function deleteByTokenKey($action, $tokenKey) {
		return TokenModel::model ()->deleteAll ( ' token = :token AND action = :action', array (
				':action' => $action,
				':token' => $tokenKey 
		) );
	}
}