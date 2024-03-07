function run(el) {
  
    const xhr = new XMLHttpRequest();
	
	const selectVal = el.querySelector('select').value;
	const actionVal = el.querySelector("input[name='action']").value;

	const params = "gener-filter=" + selectVal + "&action=" + actionVal;
  
    const url = true_obj.ajaxurl;
    xhr.open("POST", url, true);

	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector('.wrapper-books').innerHTML = xhr.responseText;
        }
    }
 
    xhr.send(params);
}


document.querySelector("#filter").addEventListener("submit", (event) => {
	event.preventDefault();
	run(event.srcElement);
});

jQuery( function( $ ){
	$( '#resetBtn' ).on('click',function(e){
		e.preventDefault();
		var filter = $(this);

		console.log('filter.serialize()', filter.serialize());

		$.ajax({
			url : true_obj.ajaxurl,
			data : {
                'gener-filter': '',
                action: 'myfilter'
            },
			type : 'POST',
			success : function( data ){
				$( '.wrapper-books' ).html(data.slice(0, -1));
			}
		});
		return false;
	});
});

// jQuery( function( $ ){
// 	$( '#filter' ).submit(function(e){
// 		e.preventDefault();
// 		var filter = $(this);

// 		console.log('filter.serialize()', filter.serialize());

// 		$.ajax({
// 			url : true_obj.ajaxurl, // обработчик
// 			data : filter.serialize(), // данные
// 			type : 'POST',
// 			beforeSend : function( xhr ){
// 				filter.find( 'button' ).text( 'Загружаю...' );
// 			},
// 			success : function( data ){
// 				filter.find( 'button' ).text( 'Применить фильтр' );
// 				$( '.wrapper-books' ).html(data.slice(0, -1));
// 			}
// 		});
// 		return false;
// 	});
// });