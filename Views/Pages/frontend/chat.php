
<div id='target_html_template' style="display:none;">

    <li class="left clearfix">
        <span class="chat-img pull-left">
            <img src="PIC" alt="User Avatar">
        </span>
        <div class="chat-body clearfix">
                <div class="header">
                    <strong class="primary-font">USERNAME</strong>
                    <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> TIME ago</small>
                </div>
                <p>
                    MSG
                </p>
        </div>
    </li>

</div>

<div id='user_html_template' style="display:none;">

    <li class="right clearfix">
        <span class="chat-img pull-right">
            <img src="PIC" alt="User Avatar">
        </span>
        <div class="chat-body clearfix">
            <div class="header">
                <strong class="primary-font">USERNAME</strong>
                <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> TIME ago</small>
            </div>
            <p>
                MSG
            </p>
        </div>
    </li>  

</div>


<style type="text/css">
    .text-el {
        width:55%;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; 

    }

    .last-message.text-muted.text-el {
        width:73%;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; 

    }
</style>


<div class="col-md-12" style="margin-top:60px;">
<!--  chat content -->
<div class="row" >
    <div class="col-xs-4 bg-white " style="width:32%;">
     

    <ul class="friend-list" style="box-shadow:0 0 10px gray;padding:5px; height:550px; overflow:scroll;">
        <li class="active">
            <a href="<?=$base."chat/?id={$active_side->getId()}"?>" class="clearfix">
                <img src="<?=$base.$active_side->getProfilePicture()?>" alt="" class="img-circle" style="margin-right:5px;">
                <div class="friend-name text-el"> 
                    <strong><?=$active_side->getName()?></strong>
                </div>
                <?php if($active_side->getMessage()):?>
                <div class="last-message text-muted text-el" ><?=$active_side->getMessage('msg')?></div>

                <small class="time text-muted"><?=$active_side->getMessage('passed_time')?> ago</small>
                <?php if($active_side->getMessage('new')):?>
                    <small class="chat-alert label label-danger">*</small>
                <?php elseif($active_side->getMessage('sent')):?>
                    <small class="chat-alert text-muted"><i class="fa fa-check"></i></small>
                <?php else:?>
                  <small class="chat-alert text-muted"><i class="fa fa-reply"></i></small>
                <?php endif; ?>
                <?php endif;?>
            </a>
        </li>
        <?php foreach ($all_chats as $ch_user) {?>
          <li>
            <a href="<?=$base."chat/?id={$ch_user->getId()}"?>" class="clearfix">
                <img src="<?=$base.$ch_user->getProfilePicture()?>" alt="" class="img-circle" style="margin-right:5px;">
                <div class="friend-name text-el"> 
                    <strong><?=$ch_user->getName()?></strong>
                </div>
                <div class="last-message text-muted text-el" ><?=$ch_user->getMessage('msg')?></div>

                <small class="time text-muted"><?=$ch_user->getMessage('passed_time')?> ago</small>
                <?php if($ch_user->getMessage('new')):?>
                    <small class="chat-alert label label-danger">*</small>
                <?php elseif($ch_user->getMessage('sent')):?>
                    <small class="chat-alert text-muted"><i class="fa fa-check"></i></small>
                <?php else:?>
                  <small class="chat-alert text-muted"><i class="fa fa-reply"></i></small>
                <?php endif; ?>
            </a>
          </li>
        <?php }?>
                         
      </ul><!-- end member list -->
    </div>

    
    <!-- selected chat content -->
    <div class="col-md-8 bg-white" style="box-shadow: 0 0 10px gray; padding:0;">
    <div class=" " style=" padding:0; height:410px; overflow:scroll;">
      <div class="chat-message">
          <ul class="chat" id='chatCont'>

                <?php foreach ($messages as $msg) {?>
                    <?php if ($msg['from_id'] == $user->getId()):?>

                        <li class="right clearfix">
                            <span class="chat-img pull-right">
                                <img src="<?=$base.$user->getProfilePicture()?>" alt="User Avatar">
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font"><?=$user->getName()?></strong>
                                    <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> <?=passedTime($msg['created_at'])?> ago</small>
                                </div>
                                <p>
                                    <?=$msg['msg']?>
                                </p>
                            </div>
                        </li>

                    <?php else:?>

                        <li class="left clearfix">
                            <span class="chat-img pull-left">
                                <img src="<?=$base.$target->getProfilePicture()?>" alt="User Avatar">
                            </span>
                            <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font"><?=$target->getName()?></strong>
                                        <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> <?=passedTime($msg['created_at'])?> ago</small>
                                    </div>
                                    <p>
                                        <?=$msg['msg']?>
                                    </p>
                            </div>
                        </li>

                    <?php endif;?>
                <?php }?>
          </ul>
      </div>
            
    </div><!-- selected chat content -->  

    <div class="  panel profile-info panel-success" style="margin:0px;padding:0;border-radius:0;border-right: 0;border-left: 0;border-bottom: 0;">
            <form>
                <textarea class="form-control input-lg p-text-area" rows="3" placeholder="Write a message..." style="border-radius:0 !important;" id='message'></textarea>
            </form>
            <div class="panel-footer" style="height: 55px;">
                <button type="button" class="btn btn-primary pull-right" id='send_btn'>Send</button>
                <!--ul class="nav nav-pills">
                    <li><a href="#"><i class="fa fa-camera"></i></a></li>
                    <li><a href="#"><i class=" fa fa-film"></i></a></li>
                    <li><a href="#"><i class="fa fa-microphone"></i></a></li>
                </ul-->
            </div>
        </div><!-- end add post form-->     
        </div>


    </div><!-- end chat content -->
</div>

<script type="text/javascript">
    var chat = new function() 
    {
        this.target;
        this.user;

        this.base;
        this.send_url;
        this.load_new_url;


        this.chat_container_id = "#chatCont";
        this.message_input_id;
        this.submit_id;

        this.max_peroid = 30*1000;
        this.start_period = 500;
        this.period = 500;
        this.timerId;

        this.init =  function (obj) {
            console.log(obj);
            this.user = obj.user;
            this.target = obj.target;

            this.base = obj.base;
            this.send_url = obj.send_url;
            this.load_new_url = obj.load_new_url;

            this.chat_container_id  = obj.chat_container_id;
            this.message_input_id   = obj.message_input_id;
            this.submit_id          = obj.submit_id;

        };

        this.getHTML = function(msg, us)
        {
            html = $(us.template).html();
            html = html.replace("USERNAME",us.username);
            html = html.replace("PIC",us.pic);
            html = html.replace("MSG",msg.msg);
            html = html.replace("TIME",msg.passed_time);
            return html;
        }

        this.sendMessageJS = function() {
            var msg = $(this.message_input_id).val();
            if(!msg)
                return false;
            $.ajax({
                    type: "POST",
                    url: this.base + this.send_url,
                    data: {message: msg,target_id:this.target.id},
                    cache: false,
                    dataType: "json",
                    success: function(data){
                        //console.log(data);
                        console.log(data);
                        if(data.RC == 200) {
                            msgObj = {"msg":msg,"passed_time":"0 seconds"};
                            $(this.chat_container_id).append(this.getHTML(msgObj,this.user));
                            $(this.chat_container_id ).parent().parent().scrollTop($(this.chat_container_id).height()-300);
                            $(this.message_input_id).val(" ");
                        } else {
                            alert("problem in sending ");
                        }
                      
                    }.bind(this)
            });
            clearTimeout(this.timerId);
            this.period = this.start_period;
            this.loadMessages();

            return false;
        }

        this.loadMessages = function() {
            $.ajax({
                    type: "GET",
                    url: this.base + this.load_new_url,
                    data: {id:this.target.id},
                    cache: false,
                    dataType: "json",
                    success: function(data){
                        //console.log(data);
                        console.log(data);
                        if(data.RC == 200 && data.records.length) {
                            console.log(data);
                            for(i=0;i<data.records.length;i++) {
                                $(this.chat_container_id).append(this.getHTML(data.records[i],this.target));
                            }
                            $(this.chat_container_id ).parent().parent().scrollTop($(this.chat_container_id).height()-300);

                            this.period = this.start_period;
                          
                            this.timerId = setTimeout(this.loadMessages.bind(this), this.period);
                        } else {
                            if(this.period<this.max_peroid)
                                this.period+=this.start_period;
                            console.log("period:"+this.period);

                            this.timerId = setTimeout(this.loadMessages.bind(this), this.period);
                        }
                      
                    }.bind(this)
            });
            
        }


        this.Run = function() {

            $(document).off('click', this.submit_id).on('click', this.submit_id, function(){
                    //alert($(this).attr('link'));
                return chat.sendMessageJS();
            });
            $(document).off('keypress',this.message_input_id).on('keypress', this.message_input_id,function (e) {
         
                if (e.which == 13) {
                    return chat.sendMessageJS();
                }
            });

            this.loadMessages();
        }



    }

    chat.init({
        target: {
                    username:"<?=$target->getName()?>",
                    pic:"<?=$base.$target->getProfilePicture()?>",
                    id:"<?=$target->getId()?>",
                    template:"#target_html_template"
        },
        user:   {
                    username:"<?=$user->getName()?>",
                    pic:"<?=$base.$user->getProfilePicture()?>",
                    id:"<?=$user->getId()?>",
                    template:"#user_html_template"
        },
        base: "<?=$base?>",
        send_url: "api/chat/sendMessage/",
        load_new_url: "api/chat/getNewMessages/",

        chat_container_id: "#chatCont",
        message_input_id: "#message",
        submit_id: "#send_btn"
    });

    chat.Run();


</script>

