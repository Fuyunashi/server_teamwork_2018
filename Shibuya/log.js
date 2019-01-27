var BAAS = BAAS || {};

BAAS.cocoa = {
 init:function(){
  this.setParameters();
  this.bindEvent();
 },

 setParameters:function(){
  this.$name = php.name;
  this.$textArea = $('#jsi-msg');
  this.$board = $('#jsi-board');
  this.$button = $('#jsi-button');

  。
  this.chatDataStore = new MilkCocoa('各自').dataStore('Room');
 },

 bindEvent:function(){
  var self = this;
  this.$button.on('click',function(){ //トークを送信
   self.sendMsg();
  });

  this.chatDataStore.on('push',function(data){ //発言者・トークを監視
   self.addText(data.value.user);
   self.addText(data.value.message);
  });
 },

 //ユーザー、メッセージ送信
 sendMsg:function(){
  if (this.$textArea.val() == ''){ return }

  var self = this;
  var name = this.$name.val();
  var text = this.$textArea.val();

  self.chatDataStore.push({user:name, message:text},function(data){
   self.$textArea.val('');
  });
 },

 //受け取り後の処理
 addText:function(json){
   var msgDom = $('<li>');
   msgDom.html(json);
   this.$board.append(msgDom[0]);
 }
}

$(function(){
 BAAS.cocoa.init();
});
