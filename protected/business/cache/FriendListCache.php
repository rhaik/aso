<?php
/**
 * 
 * 好友列表缓存
 *
 * @author zhanghaisong 2014-04-15
 *
 */
class FriendListCache extends Cache {
	/**
	 * 缓存KEY
	 *
	 * @var string
	 */
	protected $cacheKey = 'CACHE_FRIEND_LIST_';
	/**
	 *
	 * 加载缓存数据
	 *
	 * @return array
	 */
	public function loadCacheData($userId) {
		$criteria = new CDbCriteria ();
		$criteria->alias = 'f';
		$criteria->select = "f.*,u.name as userName,fu.name as friendName,fu.avatar as friendAvatar";
		$criteria->join = "LEFT JOIN " . UserModel::model ()->tableName () . " AS u ON f.user_id = u.id 
				LEFT JOIN " . UserModel::model ()->tableName () . " AS fu ON fu.id = f.friends";
		$criteria->compare ( 'f.user_id', $userId );
		$friendArray = UserInvitationFriendsModel::model ()->findAll ( $criteria );
		
		if (! empty ( $friendArray )) {
			foreach ( $friendArray as $k => $v ) {
				
				$data [$k] ['user_id'] = $v->user_id;
				$data [$k] ['friend_id'] = $v->friends;
				$data [$k] ['userName'] = $v->userName;
				$data [$k] ['friendAvatar'] = $v->friendAvatar;
				$data [$k] ['friendName'] = $v->friendName;
				$data [$k] ['createTime'] = date ( 'Y-m-d H:i:s', $v->times );
			}
		} else
			$data = array ();
		return $data;
	}
}