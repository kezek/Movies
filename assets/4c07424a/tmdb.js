//@author Andrei
function TMDb(id,obj){
   this.id = id;
   this.tmdb_id = null;
   this.current_td = obj;
   this.current_row = null;
    
   this.init();   
}

TMDb.prototype = {
   init: function(){
	  this._getCurrentRow();
	  
	  this._getTmdbId(this.id);	
  	  
   },
   _getTmdbId: function(id){	     
	  var self = this;	  
	  if (!this.hasFilmList()){
		 $.get('getDirector/'+id,function(data){		 		 
			self.tmdb_id = parseInt(data.tmdb_id);		 		 
			self.populateFilmList();
		 });		  
	  }
	  else {
		 this.removeFilmList();
	  }
	  
   },
   _getCurrentRow: function(){
	  this.current_row = this.current_td.parent('tr'); 
   },
   hasFilmList: function(current_row){
	  current_row = typeof(current_row) != 'undefined' ? current_row : this.current_row;
	 
	  if (current_row.next('.film-list').length)
	  {
		 return true;
	  }
	  return false;
   },
   populateFilmList: function(tmdb_id,current_row){	  	 	 
	  
	  var self = this;
	  
	  tmdb_id = typeof(tmdb_id) != 'undefined' ? tmdb_id : this.imdb_id;
	  current_row = typeof(current_row) != 'undefined' ? current_row : this.current_row;	 
	  if (!this.hasFilmList())
	  {		 		 
		 $.post('listFilms',{
			tmdb_id: this.tmdb_id
		 },function(html){			
			current_row.after('<tr class="film-list"><td><div>'+html+'</div></td></tr>');
			self._populateKeysList();
		 });
		
	  }	  	
	  else
	  {
		 this._removeKey();
		 this.removeFilmList();
	  }
   },
   _populateKeysList: function(){
	  var self = this;
	  $('.keys span').each(function(){		
		 if (parseInt($(this).text()) == parseInt(self.id)){			 			
			$(this).after('<span>' + self.id +'</span>');
		 }
	  })
   },
   _removeKey: function(){
	  var self = this;
	  $('.keys span').each(function(){		
		 if (parseInt($(this).text()) == parseInt(self.id)){			 			
			console.log('found');
			$(this).next().remove();
		 }
	  })	 	 
   },
   removeFilmList: function(current_row){
	  current_row = typeof(current_row) != 'undefined' ? current_row : this.current_row;	  
	  current_row.next().remove();
   }
}

$(function(){
   $('.film-list .row').live('click',function(){
	  var name = jQuery(this).children('.film-name').text();
	  console.log(director_id);
	  $.post('ajax', {'film-name': name}, function(response){
		 console.log(response);
	  })  
   });
});
   
   
