//@author Andrei

var current_row; 


//$(function(){
//console.log('click row');   
//
//$('#users-grid tr').on('click',function()
//{
//   console.log('click row');
//   current_row = $(this).children(':nth-child(1)');	 
//});	  
//   
//}); 

//$('#users-grid table tbody tr td').click(function()
//{
//  console.log('click td');
//   //current_row = $(this).children(':nth-child(1)');	 
//});	  




function TMDb(id,row){
   this.id = id;
   this.tmdb_id = null;
  
   this.current_row = row;
  
   this.init();   
}

TMDb.prototype = {
   init: function(){	  
	  this.getTmdbId(this.id);	 	  
   },
   getTmdbId: function(id){	     
	  var self = this;	  
	  if (!this.hasFilmList()){
		 $.get('getDirector/'+id,function(data){		 		 
			if (data){
			self.tmdb_id = parseInt(data.tmdb_id);		 		 
			self.populateFilmList();
			}
		 });		  
	  }
	  else {
		 this.removeFilmList();
	  }
	  
   },
   hasFilmList: function(current_row){
	  current_row = typeof(current_row) != 'undefined' ? current_row : this.current_row;
	  console.log(current_row);
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
	  console.log('current_row' + his.current_row);
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
		 console.log('has list');
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

   
   
