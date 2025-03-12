<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bend {
		protected $queue  = '/queue/cas.banc';
		protected $rqueue  = '/queue/cas.repbanc';
		protected $timeout = 30000;
		protected $stomp = null;
		
		private $ci;
		
        public function __construct($param)
        {
/*            try {
				$this->stomp = new Stomp($param['url']);
				$this->stomp->setReadTimeout(5000);
				$this->queue = $param['queue'];
				$this->rqueue = $param['rqueue'];
				$this->timeout = $param['timeout'];
			} catch(StompException $e) {
				die('Connection failed: ' . $e->getMessage());
			}
*/
			$this->ci = &get_instance();
        }
		
		public function getLoginDetail_stomp($loginid){
			
			$uniqid = uniqid("");
			$mymail = array('loginid' => $loginid,
							'reqtype' => "loginstatus");
			
			$msg = json_encode($mymail);

			$corrId = $uniqid;
			$header = array ("correlation-id"=>$corrId);
			$this->stomp->send($this->queue, $msg, $header);

			$header1 = array ("selector"=>"JMSCorrelationID='" .  $corrId ."'");
			$this->stomp->subscribe($this->rqueue, $header1);

			$reply = $this->stomp->readFrame();
			$this->stomp->ack($reply, $header1);
			$this->stomp->unsubscribe($this->rqueue);
			
			$breply = json_decode($reply->body, true);
			return $breply;
		}
		
		public function getLoginDetail($loginid){
			
			$uniqid = uniqid("");
			$myparam = array('loginid' => $loginid,
							'reqtype' => "tellinq",
							);
			
			$this->ci->load->library('restclient', array());
			$dest_url = $this->ci->config->item('cas_url') . 'chgpos/telDetail';
			log_message('debug', print_r($dest_url, TRUE)); 
			$breply = $this->ci->restclient->post($dest_url, $myparam);
			return $breply;
		}
		
		public function getLoginParam_x1($loginid, $effDate){
			
			$uniqid = uniqid("");
			$mymail = array('loginid' => $loginid,
							'reqtype' => "tellerparam",
							'effdate'=>$effDate);
			
			$msg = json_encode($mymail);

			$corrId = $uniqid;
			$header = array ("correlation-id"=>$corrId);
			$this->stomp->send($this->queue, $msg, $header);

			$header1 = array ("selector"=>"JMSCorrelationID='" .  $corrId ."'");
			$this->stomp->subscribe($this->rqueue, $header1);
			
			//log_message('debug', print_r($filter, TRUE)); 
			log_message('debug', "about to readFreame"); 
			$reply = $this->stomp->readFrame();
			$this->stomp->ack($reply, $header1);
			$this->stomp->unsubscribe($this->rqueue);
			
			$breply = json_decode($reply->body, true);
			return $breply;
		}
		
		public function getLoginParam($loginid, $mobilePhone){
			
			$uniqid = uniqid("");
			$myparam = array('loginid' => $loginid,
							'reqtype' => "tellerparam",
							'mobilePhone'=>$mobilePhone);
			
			
			$this->ci->load->library('restclient', array());
			$dest_url = $this->ci->config->item('cas_url') . 'chgpos/telStatus';
			log_message('debug', print_r($dest_url, TRUE)); 
			$breply = $this->ci->restclient->post($dest_url, $myparam);
			return $breply;
		}
}