<style type="text/css">
    #right{
        background-color:white;
        width:260px;
        height:650px;
        -moz-border-radius: 20px;
        -webkit-border-radius: 20px;
        -khtml-border-radius: 20px;
        margin-right:20px;
    }
    .user1{
        background-color:black;
        width:75px;
        height:75px;
        float:left;
        margin-left:10px;
    }
    .user2{
        background-color:black;
        width:75px;
        height:75px;
        float:right;
        margin-right:10px;
    }
    #with{
        text-align:center;
        width:80px;
        float:left;
    }
    p{
        font-size:1.5em;
    }
    .img{
        width:50px;
        margin-left:5px;
        margin-top:2px;
        float:left;
    }
    h4{
        margin-top:15px;
        margin-left:1px;
    }
    #form{
        width:95%;
        height:132px;
        background-color:#e3e3e3;
    }
    #recent{
        width:250px;
        height:425px;
        margin-top:0px;
        margin-right:auto;
        margin-left:auto;
        padding:5px;
    }
    .photo{
        width:50px;
        float:left;
    }
    .sub{
        font-weight:bold;
    }
    .half {
        margin-left:55px;
    }
    .msg{
        font-size:80%;
        color:#777777;
    }
    .section{
        min-height:55px;
        margin-top:10px;
        background-color:#c2c2c2;
        border: 1px solid #686868;
        padding:2px;
    }
    .person{
        color:blue;
    }
    .read{
        margin-top:-40px;
        margin-left:150px;
    }

    #current_users {
        float:right;
    }

    #message_header {
        float:left;
        max-width:300px;
    }

    #message_body_wrapper {
        padding-top:8px;
        clear:both;
    }

    #message_body {
        clear:both;
        border-top: 1px dashed;
    }

    #click_message {
        color: #404040;
        font-size:105%;
        text-align:center;
    }

    .text {
        float:none;
    }

    .subject {

    }

</style>
<div id="help">
    <?php if(!@$message): ?>
    <div id="click_message"><p>(Click a message on the right to view it)</p></div>
    <?php else: ?>
    <div class="subject">
        <div id="message_header">
            <h2><?php echo $message->subject ?></h2>
            <h4>
                <?php if($message->from->id == Session::instance()->get('user_id')): ?>
                <?php echo $message->to->getFullName(); ?>
                <?php else: ?>
                <?php echo $message->from->getFullName(); ?>
                <?php endif; ?>
            </h4>
        </div>

        <div id="current_users">
            <div class="user1">
                <a href="/<?php echo $message->from->username ?>">
                <?php if($message->from->has_profile_image): ?>
                    <?php 
                    if($message->from->has_message_image) {
                        echo Images::getImage($message->from->id, 'image01.jpg', 75, 75, true, true);
                    } else {
                        if(!Images::downloadResizeAndUpload($message->from->id, 'image01.jpg', 75, 75)) {
                            echo '<img src="/content/images/image01.jpg" width="75" height="75" />';
                        } else {
                            $message->from->has_message_image = true;
                            $message->from->save();

                            echo Images::getImage($message->from->id, 'image01.jpg', 75, 75, true, true);
                        }
                    }
                    ?>
                <?php else: ?>
                <img src="/content/images/image01.jpg" width="75" height="75" />
                <?php endif; ?>
                </a>
            </div>
            <div id="with">
                <p>with</p>
            </div>
            <div class="user2">
                <a href="/<?php echo $message->to->username ?>">
                    <?php if($message->to->has_profile_image): ?>
                        <?php
                        if($message->to->has_message_image) {
                            echo Images::getImage($message->to->id, 'image01.jpg', 75, 75, true, true);
                        } else {
                            if(!Images::downloadResizeAndUpload($message->to->id, 'image01.jpg', 75, 75)) {
                                echo '<img src="/content/images/image01.jpg" width="75" height="75" />';
                            } else {
                                $message->to->has_message_image = true;
                                $message->to->save();

                                echo Images::getImage($message->to->id, 'image01.jpg', 75, 75, true, true);
                            }
                        }
                        ?>
                    <?php else: ?>
                    <img src="/content/images/image01.jpg" width="75" height="75" />
                    <?php endif; ?>
                </a>
            </div>
        </div>
        <div style="clear:both"></div>
    </div>
    <div id="form">
        <form action="/inbox/reply/<?php echo $message->id ?>" style="margin-left:8px" method="POST">
            <textarea name="message" style="width:90%;margin-top:8px;" rows="5"></textarea><br/>
            <input type="hidden" name="from" value="<?php echo Session::instance()->get('user_id') ?>" />
            <input type="submit" value="Reply" />
        </form>
    </div>
    <div id="message_body_wrapper">
        <div id="message_body">
            <?php foreach($message->responses as $response): ?>
            <?php $response_member = Model_Member::quickLoad($message->getMember($response->message_from)) ?>
            <div class="postbody">
                <div class="img">
                    <?php if($response_member->has_profile_image): ?>
                        <?php echo Images::getImage($response_member->id, 'image01.jpg', 50, 0, true, true); ?>
                    <?php else: ?>
                    <img src="/content/images/image01.jpg" height="50"/>
                    <?php endif; ?>
                </div>
                <div class="text" style="margin-top:10px;float:none;">
                    <?php echo stripslashes($response->message) ?>
                    <div class="time"><a href="/<?php echo $response_member->username ?>"><?php echo $response_member->firstname ?></a> said on <?php echo date("n/j/Y \a\\t g:i a", strtotime($response->date_sent)) ?></div>
                </div>
                <div style="clear:both;height:4px;"></div>
                <div style="display:none;"></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
</div>
<div id="right">
    <div style="clear:both"></div>

    <div id="recent">
        <h2 style="margin:0;padding:0;padding-left:5px;">Conversations</h2>
        <?php echo Model_PrivateMessage::generateRecentMessageList() ?>
    </div>


</div>