jQuery(document).ready(function(){
	function  getBurstn(un,ni) {
	
		jQuery.ajax({
		  type: "GET",
		  url: "http://burstn.com/api/1/timeline/profile/?username="+un+"&limit="+ni+"&callback=?",
		  dataType: "json",
		  error: function(xhr, status, error) {
		  	alert('fail!');
		  },
		  
		  success: function(json){ 
		   	display_images(json);	
		  }
		  
		});
	} 
	

/* ============================================================
      build the funciton to display the images
   ============================================================ */
   
	function display_images(json) 
	{	
		jQuery.each(json.body.data, function(i,burst){
			var thumb = burst['image']['square'];
			var user = burst['user']['username'];
			var id = burst['id'];
			jQuery('ul.my_latest_bursts ').append('<li><a target="_blank" href="http://www.burstn.com/'+user+'#burst/'+id+'"><img src="'+thumb+'" alt="" /></a></li>');
		});	
	};
/* ============================================================
     finally, trigger it
   ============================================================ */
   
   getBurstn(burstn_vars.un,burstn_vars.ni);

});