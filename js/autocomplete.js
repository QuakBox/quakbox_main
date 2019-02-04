 
$(function() {
 
 //multiple frinds
 function split( val ) {
return val.split( /,\s*/ );
}
function extractLast( term ) {
return split( term ).pop();
}
/*
$( "#friend_name")
// dont navigate away from the field on tab when selecting an item
.bind( "keydown", function( event ) {
if ( event.keyCode === $.ui.keyCode.TAB &&
$( this ).data( "ui-autocomplete" ).menu.active ) {
event.preventDefault();
}
})

.autocomplete({
source: function( request, response ) {
$.getJSON( base_url + "load_data/friends_names_ajax.php", {
term: extractLast( request.term )
}, response );
},
search: function() {
// custom minLength

var term = extractLast( this.value );

},
focus: function() {
// prevent value inserted on focus
return false;
},
select: function( event, ui ) {
var terms = split( this.value );
// remove the current input
terms.pop();
// add the selected item
terms.push( ui.item.value );
// add placeholder to get the comma-and-space at the end
terms.push( "" );
this.value = terms.join(",");
return false;
}
});
 

$("#group_name").autocomplete({
	 source: base_url + "load_data/group_names_ajax.php",			
			select: function(event,ui)
			{				
				$( "#group_id" ).val( ui.item.id);				
			}
 });

 */

function split( val ) {
return val.split( /,\s*/ );
}
function extractLast( term ) {
return split( term ).pop();
}
$( "#post_friend")
// dont navigate away from the field on tab when selecting an item
.bind( "keydown", function( event ) {
if ( event.keyCode === $.ui.keyCode.TAB &&
$( this ).data( "ui-autocomplete" ).menu.active ) {
event.preventDefault();
}
})

.autocomplete({
source: function( request, response ) {
$.getJSON( base_url + "load_data/friends_names_ajax.php", {
term: extractLast( request.term )
}, response );
},
search: function() {
// custom minLength

var term = extractLast( this.value );

},
focus: function() {
// prevent value inserted on focus
return false;
},
select: function( event, ui ) {
var terms = split( this.value );

// remove the current input
terms.pop();
// add the selected item
terms.push( ui.item.value );
// add placeholder to get the comma-and-space at the end
terms.push( "" );
this.value = terms.join( ", " );
return false;
}
});

function split( val ) {
return val.split( /,\s*/ );
}
function extractLast( term ) {
return split( term ).pop();
}
$( "#unpost_friend")
// dont navigate away from the field on tab when selecting an item
.bind( "keydown", function( event ) {
if ( event.keyCode === $.ui.keyCode.TAB &&
$( this ).data( "ui-autocomplete" ).menu.active ) {
event.preventDefault();
}
})

.autocomplete({
source: function( request, response ) {
$.getJSON( base_url + "load_data/friends_names_ajax.php", {
term: extractLast( request.term )
}, response );
},
search: function() {
// custom minLength

var term = extractLast( this.value );

},
focus: function() {
// prevent value inserted on focus
return false;
},
select: function( event, ui ) {
var terms = split( this.value );
// remove the current input
terms.pop();
// add the selected item
terms.push( ui.item.value );
// add placeholder to get the comma-and-space at the end
terms.push( "" );
this.value = terms.join( ", " );
return false;
}
});

function split( val ) {
return val.split( /,\s*/ );
}
function extractLast( term ) {
return split( term ).pop();

}
$( "#country_name")
// dont navigate away from the field on tab when selecting an item
.bind( "keydown", function( event ) {
if ( event.keyCode === $.ui.keyCode.TAB &&
$( this ).data( "ui-autocomplete" ).menu.active ) {
event.preventDefault();
}
})

.autocomplete({
source: function( request, response ) {
$.getJSON( base_url + "load_data/country_names_ajax.php", {
term: extractLast( request.term )
}, response );
},

search: function() {
// custom minLength

var term = extractLast( this.value );

},
focus: function() {
// prevent value inserted on focus
return false;
},
select: function( event, ui ) {
var terms = split( this.value );

// remove the current input
terms.pop();
// add the selected item
terms.push( ui.item.value );
// add placeholder to get the comma-and-space at the end
terms.push( "" );
this.value = terms.join( ", " );
$( "#share_country_id" ).val( ui.item.value);
return false;

}
});

});