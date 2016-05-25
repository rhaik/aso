<?php
/**
 * 
 * 任务管理
 *
 * @author zhanghaisong 2014-1-7
 *
 */
class TaskController extends Controller {
	/**
	 * @var string
	 */
	public $layout = '//layout/main';
	/**
	 * (non-PHPdoc)
	 *
	 * @see CController::filters()
	 */
	public function filters() {
		return array (
				array (
						'TokenFilter' 
				) 
		);
	}
	/**
	 * 任务列表
	 */
	public function actionIndex() {
		$this->title = '应用试用列表';
		$data = CacheM::get ( 'TaskList' );
		if (! empty ( $data )) {
			$userTaskArray = CacheM::get ( 'UserTaskList', $this->getUserId () );
			foreach ( $data as &$v ) {
				$v ['status'] = isset ( $userTaskArray [$v->id] ) ? $userTaskArray [$v->id] : 1;
			}
		}
		$this->render ( 'index', [ 
				'data' => $data,
				'token' => Yii::app()->token->getToken()
		] );
	}
	/**
	 * 查看任务
	 */
	public function actionShow() {
		$this->title = '查看任务';
		$id = intval ( $this->request->getParam ( 'id' ) );
		if (empty ( $id )) {
			throw new HttpException ( HttpStatus::CODE_OK, ExceptionStatus::CODE_LACK_PARAMS );
		}
		$task = CacheM::get ( 'Task', $id );
		if (empty ( $task )) {
			throw new HttpException ( HttpStatus::CODE_OK, ExceptionStatus::CODE_TASK_EXIST );
		} else {
			$this->title = $task ['name'];
			$this->render ( 'show', array (
					'data' => $task 
			) );
		}
	}
	/**
	 * 我的任务
	 */
	public function actionMy() {
		$this->title = '我的任务';
		$this->render ( 'my' );
	}
}