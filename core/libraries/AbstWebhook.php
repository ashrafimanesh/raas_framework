<?php

/**
 * Description of webhook
 *
 * @author ramin ashrafimanesh <ashrafimanesh@gmail.com>
 */
abstract class AbstWebhook extends AbstTelegram{
    
    protected $bot_id;
    public function storeMessages($messages=[],$bot_id=1)
    {
        $this->bot_id=$bot_id;
        //get messages from telegram
        $unread_rows=[];
//        $unread_rows=  $this->unreadMessages();
        //store messages per user and chat id
        $user_chat_messages=$this->getUpdateMessages($messages);
        if(sizeof($user_chat_messages))
        {
            foreach($user_chat_messages as $user=>$messages)
            {
                foreach($messages as $message)
                {
                    $unread_rows[$user][]=$message;
                }
            }
        }
        return $unread_rows;
        
    }

    public function request($method,$params=[])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->bot_url.$this->api.'/'.$method);
        if($params && sizeof($params))
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
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
