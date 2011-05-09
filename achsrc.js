function Event(id,title,userid,message,marker){
	this.id = id
	this.userid = userid
	this.title = title
	this.message = message
	this.marker = marker 
	Event.prototype.getMarker = function(){
		return this.marker
	}
}