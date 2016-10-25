<?php

/**
 * curl -F "url={{https://webhookurl}}"
 *       -F "certificate=@/etc/ssl/localcerts/PUBLIC.pem"
 *       https://api.telegram.org/bot{{$key}}/setWebhook
 * Description of Telegram
 * @author ashrafimanesh
 */
abstract class AbstTelegram{
    
    protected $bot_url='https://api.telegram.org/bot';

    protected $messages=[];
    protected $api,$chat_id;
    protected function getApi()
    {
        return $this->api;
    }
    
    public function setChatId($chat_id)
    {
        $this->chat_id=$chat_id;
    }
    
    public function getChatId()
    {
        return $this->chat_id;
    }
    
    abstract function storeMessages($messages=[],$bot_id=1);
    
    abstract function run($messages=[]);
    
    public function getMe()
    {
        $result=$this->request(__FUNCTION__);
        if($result)
        {
            $this->setChatId($result['id']);
            return $this;
        }
        return false;
    }
    public function getBotId(){
        return $this->bot_id;
    }

    public function getUpdates() {
        $result=$this->request(__FUNCTION__);
        
        if($result)
        {
            foreach($result as $infos)
            {
                if(!isset($infos['message']))
                {
                    continue;
                }
                $this->messages[]=$infos;
            }
        }
        return $result;
    }
    
    public function getLastMessage()
    {
        return sizeof($this->messages) ? $this->messages[sizeof($this->messages)-1] : false;
    }
    
    public function getMessages()
    {
        return $this->messages;
    }
    
    public function setMessages($messages)
    {
        if(sizeof($messages))
        {
            foreach($messages as $infos)
            {
                if(!isset($infos['message']))
                {
                    if(isset($infos['callback_query'])){
                        $message=$infos['callback_query'];
                        $message['message']['question']=$message['message']['text'];
                        $message['message']['text']=$infos['callback_query']['data'];
                        $message['update_id']=$infos['update_id'];
                        $this->messages[]=$message;
                    }
                    continue;
                }
                $this->messages[]=$infos;
            }
        }
        return $this->messages;
    }

    public function sendMessage($chat_id, $text, $parse_mode = 'HTML',$extra=[],$debug=false) {
	$params=['chat_id'=>$chat_id,'text'=>$text,'parse_mode'=>$parse_mode];
        if(sizeof($extra))
        {
            $params=$params+$extra;
        }
        $return=$this->request(__FUNCTION__,$params);
        return $return;
    }
    
    public function sendPhoto($chat_id,$file,$caption='',$extra=[]){
        if(@filetype($file)=="file"){
            $file=new CurlFile($file,mime_content_type($file));
        }

        $params=['chat_id'=>$chat_id,'photo'=>$file,'caption'=>$caption];
        if(sizeof($extra))
        {
            $params=$params+$extra;
        }
        return $this->request(__FUNCTION__,$params);
    }
    
    public function sendDocument($chat_id,$file,$caption='',$extra=[]){
        if(@filetype($file)=="file"){
            $file=new CurlFile($file,mime_content_type($file));
        }

        $params=['chat_id'=>$chat_id,'document'=>$file,'caption'=>$caption];
        if(sizeof($extra))
        {
            $params=$params+$extra;
        }
        return $this->request(__FUNCTION__,$params);
    }
    
    public function sendSticker($chat_id,$file,$caption='',$extra=[]){
        if(@filetype($file)=="file"){
            $file=new CurlFile($file,mime_content_type($file));
        }

        $params=['chat_id'=>$chat_id,'sticker'=>$file,'caption'=>$caption];
        if(sizeof($extra))
        {
            $params=$params+$extra;
        }
        return $this->request(__FUNCTION__,$params);
    }
    
    protected function _sendFile($params){
        return $this->request(__FUNCTION__,$params);
    }


    public function getUpdateMessages($messages,$unread_rows=[]){
        $user_chat_messages=[];
        if(sizeof($messages)<=0)
        {
            return $user_chat_messages;
        }
        load_app_model('UserMessageModel');
        $user_message_model=new UserMessageModel();
        foreach($messages as $row)
        {
            if(isset($row['message']) && isset($row['message']['chat']))
            {
                $message=&$row['message'];
                $content=isset($message['text']) ? $message['text'] : (isset($message['contact']) ? json_encode(['contact'=>$message['contact']]) : '');
                if(sizeof($unread_rows))
                {
                    if(isset($unread_rows[$message['from']['id'].'-'.$message['chat']['id']][$message['message_id']]))
                    {
                        continue;
                    }
                }
                if(!isset($user_chat_messages[$message['from']['id'].'-'.$message['chat']['id']]))
                {
                    $user_chat_messages[$message['from']['id'].'-'.$message['chat']['id']]=[];
                }
                $user_chat_messages[$message['from']['id'].'-'.$message['chat']['id']][$message['message_id']]=[
                            'message_id'=>$message['message_id'],
                            'user_id'=>$message['from']['id'],
                            'message'=>  json_encode($message),
                            'status'=>'unread',
                            'date'=>$message['date'],
                            'chat_id'=>$message['chat']['id'],
                            'chat'=>json_encode($message['chat']),
                            'update_id'=>$row['update_id'],
                            'content'=>$content,
                            'question'=>isset($message['question']) ? $message['question'] : '',
                            'bot_id'=>  $this->getBotId(),
                            'tusername'=>@$message['from']['username']
                        ];
            }
        }
        if(sizeof($user_chat_messages))
        {
            foreach($user_chat_messages as $i=>$user_messages)
            {
                $result=$user_message_model->insert($user_messages);
                if(!$result)
                {
                    unset($user_chat_messages[$i]);
                }
            }
        }
        return $user_chat_messages;
    }
    
    public function unreadMessages()
    {
        load_app_model('UserMessageModel');
        $user_message_model=new UserMessageModel();
        $user_message_model->db->where(array('status'=>'unread','bot_id'=> $this->getBotId()));
        $result=$user_message_model->db->get(UserMessageModel::get_tbl_name());
        $unread_rows=$unread_ids=[];
        if($result)
        {
            $result=$result->result_array();
            foreach($result as $row)
            {
                $message=  json_decode($row['message'],true);
                $unread_ids[]=$row['id'];
                $unread_rows[$row['user_id'].'-'.$row['chat_id']][$row['message_id']]=[
                    'message_id'=>$row['message_id'],
                    'user_id'=>$row['user_id'],
                    'message'=>  $row['message'],
                    'status'=>'unread',
                    'date'=>$message['date'],
                    'chat_id'=>$row['chat_id'],
                    'chat'=>json_encode($message['chat']),
                    'update_id'=>$row['update_id'],
                    'content'=>$row['content'],
                    'id'=>$row['id']
                ];
            }
        }
        if(sizeof($unread_rows))
        {
            $user_message_model->db->where_in(['id'=>$unread_ids]);
            $user_message_model->update(['status'=>'read']);
        }
        return $unread_rows;
    }


    public function ReplyKeyboardMarkup($params) {
        return new InlineKeyboardMarkup();
    }
    
    public function InlineKeyboardMarkup($params) {
        
    }
    
    public function request2($method,$params=[])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->bot_url.$this->api.'/'.$method);
        
        if($params && sizeof($params))
        {
//            if(!in_array($method, ['sendPhoto']))
//            {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
//            }
        }

        // in real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS, 
        //          http_build_query(array('postvar1' => 'value1')));

        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $exec=curl_exec ($ch);
        $response = json_decode($exec,true);
        curl_close ($ch);
        if(isset($response['ok']) && $response['ok'])
        {
            return $response['result'];
        }
        return FALSE;
    }
    
}
