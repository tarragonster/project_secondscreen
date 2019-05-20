<?php

class Notify_model extends CI_Model {

	public static $templates = array(
		'1' => [
			'setting_key' => NOTIFICATION_NEW_WATCHLIST,
			'formatted' => 'is watching',
		],
		'2' => [
			'setting_key' => NOTIFICATION_NEW_THUMBS_UP,
			'formatted' => "liked",
		],
		'3' => [
			'setting_key' => NOTIFICATION_NEW_THUMBS_UP,
			'formatted' => "disliked",
		],
		'4' => [
			'setting_key' => NOTIFICATION_NEW_THUMBS_UP,
			'formatted' => "wants to watch",
		],
		'5' => [
			'setting_key' => NOTIFICATION_COMMENT_LIKES,
			'formatted' => "liked comment",
		],
		'6' => [
			'setting_key' => NOTIFICATION_COMMENT_REPLIES,
			'formatted' => "commented on",
		],
		'7' => [
			'setting_key' => NOTIFICATION_NEW_STORIES,
			'formatted' => "Second Screen Series Suggestion:",
		],
		'8' => [
			'setting_key' => NOTIFICATION_NEW_STORIES,
			'formatted' => "New Season:"
		],
		'9' => [
			'setting_key' => NOTIFICATION_COMMENT_LIKES,
			'formatted' => "liked <<username>> 's comment: ",
		],

		'10' => [
			'setting_key' => NOTIFICATION_COMMENT_REPLIES,
			'formatted' => "replied to <<username>> 's comment on",
		],
		'11' => [
			'setting_key' => NOTIFICATION_COMMENT_MENTIONS,
			'formatted' => "mentioned <<username>> in a comment on",
		],
		'12' => [
			'setting_key' => NOTIFICATION_NEW_FOLLOWERS,
			'formatted' => "started following <<username>> ",
		],
		'13' => [
			'setting_key' => NOTIFICATION_NEW_THUMBS_UP,
			'formatted' => "just liked <<story_name>>. Check out the story.",
		],
		'14' => [
			'setting_key' => NOTIFICATION_NEW_WATCHLIST,
			'formatted' => "added <<story_name>> to their watch list. Are you going to watch it?",
		],
		'15' => [
			'setting_key' => NOTIFICATION_NEW_WATCHLIST,
			'formatted' => "just wrote a review of <<story_name>>. Go see what they said.",
		],
		'51' => [
			'setting_key' => NOTIFICATION_NEW_FOLLOWERS,
			'formatted' => "followed you. See who else they're following.",
		],
		'52' => [
			'setting_key' => NOTIFICATION_COMMENT_MENTIONS,
			'formatted' => "mentioned you",
		],
		'53' => [
			'setting_key' => NOTIFICATION_COMMENT_LIKES,
			'formatted' => "liked your comment",
		],
		'54' => [
			'setting_key' => NOTIFICATION_COMMENT_REPLIES,
			'formatted' => "replied to you",
		],
		'55' => [
			'setting_key' => NOTIFICATION_TRENDING,
			'formatted' => "Welcome to 10 Block Secret Society.",
		],
		'56' => [
			'setting_key' => NOTIFICATION_TRENDING,
			'formatted' => "Welcome to 10 Block! Add a few stories to your watch list for a quick start.",
		],
		'57' => [
			'setting_key' => NOTIFICATION_NEW_WATCHLIST,
			'formatted' => "shared <<story_name>> with you: \"<<message>>\"",
		],
		'58' => [
			'setting_key' => NOTIFICATION_NEW_STORIES,
			'formatted' => "A new story just added! Don't miss <<story_name>>.",
		],
		'59' => [
			'setting_key' => NOTIFICATION_TRENDING,
			'formatted' => "<<story_name>> is trending. Have you watched it?",
		],
		'60' => [
			'setting_key' => NOTIFICATION_NEW_WATCHLIST,
			'formatted' => "Add to <<story_name>> your watch list.",
		],
		'61' => [
			'setting_key' => NOTIFICATION_NEW_PICKS,
			'formatted' => "Pick up <<story_name>> where you left off.",
		],
		'62' => [
			'setting_key' => NOTIFICATION_NEW_PICKS,
			'formatted' => "Did you enjoy that? Add <<story_name>> to your thumbs up.",
		],
		'64' => [
			'setting_key' => NOTIFICATION_NEW_PICKS,
			'formatted' => "Let your friend know what you think of <<story_name>>.",
		],
	);

	public function __construct() {
		parent::__construct();
		$this->load->library('cipush');
	}

	public function createNotify($user_id, $type, $data = null, $sound = 'default', $sendPush = true) {
		$template = Notify_model::$templates[$type];
		if ($this->checkSetting($user_id, $template['setting_key'])) {
			$alert = $this->fillDataToTemplate($template['formatted'], $data, $type);
			$this->insertUserNotify($user_id, $type, $template['formatted'], $data);
			$this->sendNotification($user_id, $type, $alert, $data, $sound, $sendPush);
		}
	}

	public function createNotifyToFollower($user_id, $type, $data = null, $sound = 'default', $sendPush = true) {
		$users = $this->getUserFollow($user_id);
		if ($users != null) {
			$template = Notify_model::$templates[$type];
			$alert = $this->fillDataToTemplate($template['formatted'], $data, $type);
			$count = count($users);
			foreach ($users as $user) {
				if ($this->checkSetting($user['user_id'], $template['setting_key'])) {
					if (!$this->checkNotify($user['user_id'], $type, $data)) {
						$this->insertUserNotify($user['user_id'], $type, $template['formatted'], $data);
					} else {
						$this->updateNotify($user['user_id'], $type, $data, array('status' => 1, 'timestamp' => time()));
					}
					if ($sendPush)
						$this->sendNotification($user['user_id'], $type, $alert, $data, $sound, $count < 20);
				}
			}
		}
	}

	public function sendToAllUser($type, $data = null, $sound = 'default') {
		$users = $this->db
			->select('user_id, full_name')
			->where('status', 1)
			->get('user')->result_array();
		$this->createNotifyMany($users, $type, $data, $sound);
	}

	public function createNotifyMany($users, $type, $data = null, $sound = 'default') {
		if ($users != null && is_array($users) && count($users) > 0) {
			$template = Notify_model::$templates[$type];
			$alert = $this->fillDataToTemplate($template['formatted'], $data, $type);
			$count = count($users);
			foreach ($users as $user) {
				if ($this->checkSetting($user['user_id'], $template['setting_key'])) {
					if (!$this->checkNotify($user['user_id'], $type, $data)) {
						$this->insertUserNotify($user['user_id'], $type, $template['formatted'], $data);
					} else {
						$this->updateNotify($user['user_id'], $type, $data, array('status' => 1, 'timestamp' => time()));
					}
					$this->sendNotification($user['user_id'], $type, $alert, $data, $sound, $count < 20);
				}
			}
		}
	}

	public function removeNotify($user_id, $type, $data = null) {
		$this->db->where('type', $type);
		if ($data != null)
			$this->db->where('data', json_encode($data));
		if ($user_id != 0) {
			$this->db->where('user_id', $user_id);
		}
		$this->db->delete('user_notify');
	}

	public function updateNotify($user_id, $type, $data = null, $params) {
		$this->db->where('type', $type);
		if ($data != null)
			$this->db->where('data', json_encode($data));
		$this->db->where('user_id', $user_id);
		$this->db->update('user_notify', $params);
	}

	private function insertUserNotify($user_id, $type, $template, $data) {
		$params = array();
		$params['user_id'] = $user_id;
		$params['type'] = $type;
		$params['timestamp'] = time();
		$params['content'] = $template;
		if ($data != null)
			$params['data'] = json_encode($data);
		$params['status'] = 1;
		$this->db->insert('user_notify', $params);
	}

	public function fillDataToTemplate($template, $data, $type) {
		$user_name = '';
		$product_name = '';
		$content = '';
		if (isset($data['user_id'])) {
			$user = $this->getUserForNotify($data['user_id']);
			$user_name = $user['user_name'] . ' ';
		}
		foreach ($data as $key => $value) {
			$template = str_replace("<<$key>>", $value, $template);
		}
		if ($type >= 50) {
			// if(isset($data['season_id'])){
			// 	$season = $this->getSeasonForNotify($data['season_id']);
			// 	$content = $content.' '.$season['name'];
			// }
			if (isset($data['episode_id'])) {
				$episode = $this->getPartEpisodeForNotify($data['episode_id']);
				$content = $content . ' part ' . $episode['position'];
			}
			if (isset($data['product_id'])) {
				$product = $this->getProductForNotify($data['product_id']);
			}
			if ($content != '') {
				$product_name = $content . ' of ' . $product['name'];
			}
		} else {
			if (isset($data['product_id'])) {
				$product = $this->getProductForNotify($data['product_id']);
				$product_name = ' ' . $product['name'];
			}
			if (isset($data['uid_comment'])) {
				if ($data['uid_comment'] == $data['user_id']) {
					if ($type == 10) {
						$template = str_replace("<<username>>", 'their', $template);
					} else {
						$template = str_replace("<<username>>", 'to their', $template);
					}
				} else {
					$template = str_replace("<<username>>", $this->getUserForNotify($data['uid_comment'])['user_name'], $template);
				}
			}
			if (isset($data['episode_id'])) {
				$episode = $this->getPartEpisodeForNotify($data['episode_id']);
				$content = $content . ' part ' . $episode['position'];
			}
			if ($content != '') {
				$template = $template . ' ' . $content . ' of';
			}
		}
		return $user_name . $template . $product_name;
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

	private function getDeviceTokensOfUser($user_id) {
		$this->db->where('user_id', $user_id);
		$this->db->not_like('reg_id', '__NULL__');
		$query = $this->db->get('device_user');
		return $query->num_rows() > 0 ? $query->result_array() : null;
	}

	public function sendNotification($uid, $type, $alert, $data = null, $sound = 'default', $sendNow = true) {
		$data_send = array(
			'alert' => $alert,
			'type' => $type,
			'data' => $data,
			'sound' => $sound,
		);

		$devices = $this->getDeviceTokensOfUser($uid);
		if ($devices != null) {
			$this->cipush = new Cipush();
			foreach ($devices as $device) {
				if ($device['dtype_id'] == 1) {
					$this->cipush->addAndroid($device['reg_id'], $data_send, $sendNow);
				} else {
					$this->cipush->addIOS($device['reg_id'], $data_send, $sendNow);
				}
			}
		}
	}

	public function getUserForNotify($user_id) {
		$this->db->select('user_name, user_type, avatar, full_name, email');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user');
		return $query->num_rows() > 0 ? $query->first_row('array') : null;
	}

	public function getProductForNotify($product_id) {
		$this->db->select('name');
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('product');
		return $query->num_rows() > 0 ? $query->first_row('array') : null;
	}

	public function getComment($comment_id) {
		$this->db->where('comment_id', $comment_id);
		$query = $this->db->get('comments');
		return $query->num_rows() > 0 ? $query->first_row('array') : null;
	}

	public function getSeasonForNotify($season_id) {
		$this->db->select('name');
		$this->db->where('season_id', $season_id);
		$query = $this->db->get('season');
		return $query->num_rows() > 0 ? $query->first_row('array') : null;
	}

	public function getEpisodeForNotify($episode_id) {
		$this->db->select('name');
		$this->db->where('episode_id', $episode_id);
		$query = $this->db->get('episode');
		return $query->num_rows() > 0 ? $query->first_row('array') : null;
	}

	public function getUserFollow($user_id) {
		$this->db->select('u.*');
		$this->db->from('user_follow u');
		$this->db->where('u.follower_id', $user_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getPartEpisodeForNotify($episode_id) {
		$this->db->select('position');
		$this->db->where('episode_id', $episode_id);
		$query = $this->db->get('episode');
		return $query->num_rows() > 0 ? $query->first_row('array') : null;
	}

	public function checkNotify($user_id, $type, $data = null) {
		$this->db->where('type', $type);
		if ($data != null)
			$this->db->where('data', json_encode($data));
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_notify');
		return $query->num_rows() > 0;
	}

	public function checkSetting($user_id, $key) {
		$this->db->from('user_notification_setting');
		$this->db->where('user_id', $user_id);
		$item = $this->db->get()->first_row('array');
		if ($item == null)
			return false;
		if (isset($item[$key]) && $item[$key] == 1) {
			return true;
		}
		return false;
	}
}